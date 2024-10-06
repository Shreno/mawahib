<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;
use App\Models\User;
use Carbon\Carbon;
use Google\Client;
use Google\Service\Adsense;
use App\Models\Earning;
use App\Models\Article;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Setting;


class BackendScheduleController extends Controller
{

 
    public function update_traffics_country(){
      $rate_limits = \App\Models\RateLimit::whereNull('country_code')->get();
      foreach($rate_limits as $rate_limit){
        $country=(new \UserSystemInfoHelper)->get_country_from_ip($rate_limit->ip);
        $rate_limit->update([
        'country_code'=>$country['country_code'],
        'country_name'=>$country['country']
        ]);
      }
    }
    public function update_under_attack(){

      //enable under attack
      $ip=\UserSystemInfoHelper::get_ip();
      $total_req_per_minute = \App\Models\RateLimitDetail::where('created_at','>=',\Carbon::parse(now())->subMinutes(2)->format('Y-m-d H:i:s'))->orderBy('id','DESC')->count();

      if($total_req_per_minute>=10000){ 
          $attacks=\App\Models\UnderAttack::where('status','UNDER_ATTACK')->where('release_at','>',\Carbon::parse(now())->format('Y-m-d H:i:s'))->count();
          if($attacks==0){ 
              \App\Models\UnderAttack::create(['status'=>"UNDER_ATTACK",'release_at'=>\Carbon::parse(now())->addMinutes(30)->format('Y-m-d H:i:s')]);
              (new \App\Helpers\SecurityHelper)->enable_under_attack_mode(); 
          }
      }

      //disable under attack
      $under_attacks=\App\Models\UnderAttack::where('status','UNDER_ATTACK')->where('created_at','<',\Carbon::parse(now())->addMinutes(15)->format('Y-m-d H:i:s'))->count();
      if($under_attacks){
        (new \App\Helpers\SecurityHelper)->disable_under_attack_mode(); 
        \App\Models\UnderAttack::where('status','UNDER_ATTACK')->update(['status'=>"MEDIUM"]);
      }
      $blocked_ips = \App\Models\BlockIp::whereDate('created_at','<',\Carbon::parse(now())->subMinutes(30)->format('Y-m-d H:i:s'))->get();
      foreach($blocked_ips as $blocked_ip){
        $response =  (new \App\Helpers\SecurityHelper)->unblock_ip($blocked_ip->state_id);
      }

    }
    public function clean_system(){
        //general users
        $delete_sessions = \App\Models\Session::whereNull('user_id')->delete();

        //loged in users
        $delete_old_sessions = \App\Models\Session::whereNull('user_id')->where('last_activity','<',\Carbon::now()->subDays(30)->valueOf()/1000)->delete();

        //delete rate limits
        $delete_rate_limits = \App\Models\RateLimit::where('created_at','<',\Carbon::parse(now())->subDays(8)->format('Y-m-d H:i:s'))->delete();

        //delete rate limit details
        $delete_rate_limit_details = \App\Models\RateLimitDetail::where('created_at','<',\Carbon::parse(now())->subDays(8)->format('Y-m-d H:i:s'))->delete();

        //delete item seens
        $delete_old_rate_limits = \App\Models\ItemSeen::whereDate('created_at', '<',\Carbon::now()->subDays(1))->delete();

        //old_error_reports
        $delete_old_error_reports = \App\Models\ReportError::whereDate('created_at', '<',\Carbon::now()->subDays(3))->delete();

    }

    //

    public function adsense()
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
    private function getClient()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/client_secret.json'));
        $client->addScope('https://www.googleapis.com/auth/adsense.readonly');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        return $client;
    }

    private function storeToken($token)
    {
        User::where('id', 1)->update([
            'google_access_token' => $token['access_token'],
            'google_refresh_token' => $token['refresh_token'] ?? null,
            'token_expires_at' => Carbon::now()->addSeconds($token['expires_in']),
        ]);
    }


    // 

      

}
