<?php 
namespace App\Services;

use Google_Client;
use Google_Service_AdSense;
use App\Models\User;
use App\Models\Earning;
use App\Models\Article;
use App\Models\Wallet;
use App\Models\Transaction;


class GoogleAdSenseService
{
    

    protected $client;

    public function __construct()
    {
        
    }

    public function getEarnings($startDate, $endDate)
    {
        $client = new \Google_Client();
        $user = User::find(1); // جلب المستخدم الذي لديه Access Token
        $client->setAccessToken($user->Access_token); // تعيين Access Token

        if ($client->isAccessTokenExpired()) {
            $refreshToken = $client->getRefreshToken();
        
            if ($refreshToken) {
                $newAccessToken = $client->fetchAccessTokenWithRefreshToken($refreshToken);
                $user->Access_token = json_encode($client->getAccessToken());
                $user->save();
            }
        }

        $client->addScope('https://www.googleapis.com/auth/adsense.readonly');
        $client->addScope('https://www.googleapis.com/auth/adsense');
        $service = new \Google_Service_AdSense($client);
        $accountId = 'accounts/pub-4171446342963559';

        $reports = $service->accounts_reports->generate($accountId, [
            'metrics' => ['ESTIMATED_EARNINGS'],
            'dateRange' => 'LAST_30_DAYS',
            'dimensions' => 'PAGE_URL'
        ]); 

        foreach ($reports['rows'] as $row) {
            $url = $row['cells'][0]['value'];
            $cost = $row['cells'][1]['value'];
            $baseUrl = "https://mwhib.com/";
            $slug = str_replace($baseUrl, '', $url);
            $slug = str_replace('/', '', $slug);

            $article = Article::where('slug', $slug)->first();

            if ($article) {
                $totalEarnings = $cost;
                $websiteShare = $totalEarnings * 0.30; 
                $creatorShare = $totalEarnings * 0.70; 

                $earning = Earning::where('article_id', $article->id)->first();
                $currentDate = now();
                $lastUpdatedDate = $earning ? $earning->updated_at : null;
                $daysDiff = $lastUpdatedDate ? $lastUpdatedDate->diffInDays($currentDate) : 31;

                if ($earning) {
                    if ($daysDiff <= 30) {
                        $earning->site_share = $websiteShare;
                        $earning->creator_share = $creatorShare;
                        $earning->total_revenue = $totalEarnings;
                        $earning->save();
                    } else {
                        $earning->site_share += $websiteShare;
                        $earning->creator_share += $creatorShare;
                        $earning->total_revenue += $totalEarnings;
                        $earning->save();
                    }
                } else {
                    $earning = Earning::create([
                        'article_id' => $article->id,
                        'site_share' => $websiteShare,
                        'creator_share' => $creatorShare,
                        'total_revenue' => $totalEarnings,
                    ]);
                }

                $wallet = Wallet::where('user_id', $article->creator_id)->first();

                if ($wallet) {
                    if ($daysDiff <= 30) {
                        $wallet->balance = $wallet->balance-$wallet->last_earning; 
                        $wallet->balance += $creatorShare; 
                        $wallet->last_earning = $creatorShare;
                        $wallet->save();
                    } else {
                        $wallet->balance += $creatorShare;
                        $wallet->last_earning = $creatorShare;
                        $wallet->save();
                    }
                } else {
                    $wallet = Wallet::create([
                        'user_id' => $article->creator_id,
                        'balance' => $creatorShare,
                        'last_earning' => $creatorShare,
                    ]);
                }

                // **إضافة الربح اليومي إلى جدول المعاملات**
                Transaction::create([
                    'user_id' => $article->creator_id, 
                    'type' => 'deposit', 
                    'amount' => $creatorShare,
                    'article_id' => $article->id, 
                    'description' => 'الربح اليومى ',
                ]);
            }

            // يمكنك استخدام dd لاختبار النتائج
            dd($url, $cost, $article, $earning, $wallet);
        }
    }

  
}