<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use Google\Client;
use Google\Service\Adsense;
use App\Models\Earning;
use App\Models\Article;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Setting;

class FetchAdSenseData extends Command
{
    protected $signature = 'adsense:fetch';

    protected $description = 'Fetch Google AdSense data and update earnings daily';

    public function __construct()
    {
        parent::__construct();
    }

    private function getClient()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/client_secret.json'));
        $client->addScope('https://www.googleapis.com/auth/adsense.readonly');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        return $client;
    }

    public function handle()
    {
        $client = $this->getClient();
        $tokenData = User::where('id', 1)->first();

        if ($tokenData->google_access_token == null) {
            $this->error('No access token found, please authenticate first.');
            return;
        }

        $client->setAccessToken([
            'access_token' => $tokenData->google_access_token,
            'expires_in' => $tokenData->token_expires_at->diffInSeconds(Carbon::now()),
        ]);

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($tokenData->google_refresh_token);
            $this->storeToken($client->getAccessToken());
        }

        $adsense = new Adsense($client);
        $accountId = 'accounts/pub-4171446342963559';
        $reports = $adsense->accounts_reports->generate($accountId, [
            'metrics' => ['ESTIMATED_EARNINGS'],
            'dimensions' => ['PAGE_URL', 'DATE'],
            'dateRange' => 'LAST_7_DAYS',
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
            $settings = Setting::where('key', 'percentage_website')->first();
            $website_per = $settings->value;
            $creator_per = 100 - $website_per;
            $websiteShare = $totalEarnings * ($website_per / 100);
            $creatorShare = $totalEarnings * ($creator_per / 100);

            if ($article) {
                $earning = Earning::where('article_id', $article->id)
                    ->where('total_revenue', $totalEarnings)
                    ->where('date', $day)
                    ->first();

                if (!$earning) {
                    Transaction::create([
                        'user_id' => $article->creator_id,
                        'type' => 'deposit',
                        'amount' => $creatorShare,
                        'article_id' => $article->id,
                        'description' => 'الربح اليومي',
                        'date' => $day,
                    ]);

                    Earning::create([
                        'article_id' => $article->id,
                        'site_share' => $websiteShare,
                        'creator_share' => $creatorShare,
                        'total_revenue' => $totalEarnings,
                        'date' => $day,
                    ]);

                    $wallet = Wallet::where('user_id', $article->creator_id)->first();

                    if ($wallet) {
                        $wallet->balance += $creatorShare;
                        $wallet->last_earning = $creatorShare;
                        $wallet->save();
                    } else {
                        Wallet::create([
                            'user_id' => $article->creator_id,
                            'balance' => $creatorShare,
                            'last_earning' => $creatorShare,
                        ]);
                    }
                }
            }
        }
    }

    private function storeToken($token)
    {
        User::where('id', 1)->update([
            'google_access_token' => $token['access_token'],
            'google_refresh_token' => $token['refresh_token'] ?? null,
            'token_expires_at' => Carbon::now()->addSeconds($token['expires_in']),
        ]);
    }
}