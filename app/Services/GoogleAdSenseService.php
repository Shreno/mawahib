<?php 
namespace App\Services;

use Google_Client;
use Google_Service_AdSense;
use App\Models\User;

class GoogleAdSenseService
{
    // protected $client;

    // public function __construct()
    // {
    //     $this->client = new Google_Client();
        
    //     // تحميل بيانات اعتماد حساب الخدمة
    //     $this->client->setAuthConfig(storage_path(path:'app\google-service-account.json'));

    //     // إضافة الصلاحيات المطلوبة (scope)
    //     $this->client->addScope('https://www.googleapis.com/auth/adsense.readonly');

    //     // تأكيد أن الحساب حساب خدمة
    //     $this->client->useApplicationDefaultCredentials();
    // }

    protected $client;

    public function __construct()
    {
        $this->client = new Google_Client();
        $user=User::find(1);
        $this->client->setAccessToken($user->Access_token);

        // if ($this->client->isAccessTokenExpired()) {
        //     $this->client->refreshToken($this->client->getRefreshToken());
        // }
    }

    public function getEarnings($startDate, $endDate)
    {
        $adsense = new Google_Service_AdSense($this->client);


        // استخدم معرف الحساب AdSense الخاص بك بالشكل الصحيح
        $accountId = 'accounts/9978657914'; // ملاحظة: هنا نستخدم المسار الكامل
        // قم باستدعاء التقرير
        $report = $adsense->accounts_reports->generate($accountId, [
            'metrics' => ['TOTAL_EARNINGS'], // التأكد من استخدام 'metrics' وليس 'metric'
            'dateRange'=>'TODAY',
        ]);

        return $report->getRows();
    }
}