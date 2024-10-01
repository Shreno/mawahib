<?php 
namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Google\Client;
use Google\Service\Adsense;
use Illuminate\Http\Request;
use App\Models\Earning;
use App\Models\Article;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Setting;


class GoogleAdSenseService
{
    private function getClient()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/client_secret.json'));  // Path to client secret JSON
        $client->addScope('https://www.googleapis.com/auth/adsense.readonly');
        $client->setRedirectUri(url('/callback'));
        $client->setAccessType('offline'); // Ensure you get a refresh token
        $client->setPrompt('select_account consent');
        
        return $client;
    }

    public function authRedirect()
    {
        $client = $this->getClient();
        $tokenData = User::where('id', 1)->first();

        // Check if token exists and is still valid
        if ($tokenData->google_access_token !=null && $tokenData->token_expires_at->gt(Carbon::now())) {
            return redirect()->route('adsense.data');
        }

        // If no valid token, redirect for authentication
        return redirect()->away($client->createAuthUrl());
    }

    public function oauthCallback(Request $request)
    {
        $client = $this->getClient();

        if ($request->has('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));

            if (!isset($token['error'])) {
                // Save the tokens in the database
                $this->storeToken($token);
                return redirect()->route('adsense.data');
            } else {
                return response()->json(['error' => 'Authorization failed']);
            }
        }

        return redirect()->route('adsense.auth');
    }

    private function storeToken($token)
    {
        // Store or update token in the database
        User::where('id',1)->update(
           
            [
                'google_access_token'  => $token['access_token'],
                'google_refresh_token' => $token['refresh_token'] ?? null,
                'token_expires_at'    => Carbon::now()->addSeconds($token['expires_in']),
            ]
        );
    }

    public function getAdSenseData()
    {
        $client = $this->getClient();
        $tokenData = User::where('id', 1)->first();

        if ($tokenData->google_access_token==null) {
            return redirect()->route('adsense.auth');
        }

        // Set the access token
        $client->setAccessToken([
            'access_token' => $tokenData->google_access_token,
            'expires_in'   => $tokenData->token_expires_at->diffInSeconds(Carbon::now()),
        ]);

        // Refresh the token if it's expired
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($tokenData->google_refresh_token);
            $this->storeToken($client->getAccessToken());  // Store new access token
        }

        // Now you can interact with the AdSense API
        $adsense = new Adsense($client);
        // $accounts = $adsense->accounts->listAccounts();
        $accountId = 'accounts/pub-4171446342963559';
        $reports = $adsense->accounts_reports->generate($accountId, [
            'metrics' => ['ESTIMATED_EARNINGS'],
            'dimensions' => ['PAGE_URL', 'DATE'], // تحديد الأبعاد كـ PAGE_URL و DATE لجلب الأرباح حسب الصفحة واليوم
            'dateRange' => 'LAST_7_DAYS',       // تحديد نطاق التاريخ، هنا الأرباح خلال آخر 30 يومًا
        ]); 
        foreach ($reports['rows'] as $row) {
            $url = $row['cells'][0]['value'];
            $day = $row['cells'][1]['value'];
            $cost = $row['cells'][2]['value'];
            $baseUrl = "https://mwhib.com/";
            $slug = str_replace($baseUrl, '', $url);
            $slug = str_replace('/', '', $slug);
            $article = Article::where('slug', $slug)->first();
            $totalEarnings = $cost;
            $settings=Setting::where('key','percentage_website')->first();
            $website_per=$settings->value;
            $creator_per=100-$website_per;
            $websiteShare = $totalEarnings * ($website_per/100); 
            $creatorShare = $totalEarnings * ($creator_per/100) ;
            if($article)
            {
            $earning = Earning::where('article_id', $article->id)->where('total_revenue',$totalEarnings)->where('date',$day)->first();

            if(!$earning)
            {
                Transaction::create([
                    'user_id' => $article->creator_id,
                    'type' => 'deposit',
                    'amount' => $creatorShare,
                    'article_id' => $article->id,
                    'description' => 'الربح اليومي',
                    'date' => $day,

                ]);
                // 
                if (!$earning) {
                    $earning = Earning::create([
                        'article_id' => $article->id,
                        'site_share' => $websiteShare,
                        'creator_share' => $creatorShare,
                        'total_revenue' => $totalEarnings,
                        'date' => $day,

                    ]);}

                $wallet = Wallet::where('user_id', $article->creator_id)->first();

                if ($wallet) {
                
                        $wallet->balance += $creatorShare;
                        $wallet->last_earning = $creatorShare;
                        $wallet->save();
                
                } else {
                    $wallet = Wallet::create([
                        'user_id' => $article->creator_id,
                        'balance' => $creatorShare,
                        'last_earning' => $creatorShare,
                    ]);
                }               
            }
        }

        }
    }
    


   

  
}