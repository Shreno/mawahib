<?php 
namespace App\Services;

use Google_Client;
use Google_Service_AdSense;
use App\Models\User;
use App\Models\Earning;
use App\Models\Article;
use App\Models\Wallet;


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
        // التحقق مما إذا كان الرمز المميز قد انتهت صلاحيته
        if ($client->isAccessTokenExpired()) {
            // جلب refresh token من قاعدة البيانات أو من المستخدم نفسه
            $refreshToken = $client->getRefreshToken();
        
            if ($refreshToken) {
                // تحديث الرمز المميز باستخدام refresh token
                $newAccessToken = $client->fetchAccessTokenWithRefreshToken($refreshToken);
        
                // حفظ الرمز المحدث في قاعدة البيانات أو الجلسة
                $user->Access_token = json_encode($client->getAccessToken());
                $user->save();
            } else {
            }
        }
        $client->addScope('https://www.googleapis.com/auth/adsense.readonly');
        $client->addScope('https://www.googleapis.com/auth/adsense');
          $service = new \Google_Service_AdSense($client);
          $accountId = 'accounts/pub-4171446342963559'; // ملاحظة: هنا نستخدم المسار الكامل
          $reports = $service->accounts_reports->generate($accountId, [
            'metrics' => ['ESTIMATED_EARNINGS'], // التأكد من استخدام 'metrics' وليس 'metric'
            'dateRange'=>'LAST_30_DAYS',
            'dimensions'=>'PAGE_URL'
        ]); 

        foreach($reports['rows'] as $row)
{
    $url = $row['cells'][0]['value'];
    $cost = $row['cells'][1]['value'];
    $baseUrl = "https://mwhib.com/";
    $slug = str_replace($baseUrl, '', $url);
    $slug = str_replace('/', '', $slug);

    // جلب المقال بناءً على الـ slug
    $article = Article::where('slug', $slug)->first();

    if ($article) {
        // تقسيم الأرباح
        $totalEarnings = $cost;
        $websiteShare = $totalEarnings * 0.30; // 30% للموقع
        $creatorShare = $totalEarnings * 0.70; // 70% لصاحب المحتوى

        // البحث عن الأرباح السابقة للمقالة
        $earning = Earning::where('article_id', $article->id)->first();

        // جلب التاريخ الحالي والتاريخ المخزن لآخر تحديث
        $currentDate = now();
        $lastUpdatedDate = $earning ? $earning->updated_at : null;

        // التحقق مما إذا كانت آخر 30 يومًا
        $daysDiff = $lastUpdatedDate ? $lastUpdatedDate->diffInDays($currentDate) : 31;

        if ($earning) {
            if ($daysDiff <= 30) {
                // إذا كان آخر تحديث خلال آخر 30 يومًا، نقوم بتحديث البيانات الحالية
                $earning->site_share = $websiteShare;
                $earning->creator_share = $creatorShare;
                $earning->total_revenue = $totalEarnings;
                $earning->save();
            } else {
                // إذا مرَّت أكثر من 30 يومًا، نضيف المكاسب الجديدة إلى المكاسب السابقة
                $earning->site_share += $websiteShare;
                $earning->creator_share += $creatorShare;
                $earning->total_revenue += $totalEarnings;
                $earning->save();
            }
        } else {
            // إذا لم يكن هناك سجل أرباح سابق، إنشاء سجل أرباح جديد
            $earning = Earning::create([
                'article_id' => $article->id,
                'site_share' => $websiteShare,
                'creator_share' => $creatorShare,
                'total_revenue' => $totalEarnings,
            ]);
        }

        // البحث عن محفظة صاحب المحتوى
        $wallet = Wallet::where('user_id', $article->creator_id)->first();

        if ($wallet) {
            if ($daysDiff <= 30) {
                // إذا كان آخر تحديث خلال آخر 30 يومًا، استبدال المكاسب في المحفظة
                $wallet->balance -= $wallet->last_earning; // إزالة المكسب السابق
                $wallet->balance += $creatorShare; // إضافة المكسب الجديد
                $wallet->last_earning = $creatorShare; // تحديث آخر مكسب
                $wallet->save();
            } else {
                // إذا مرَّت أكثر من 30 يومًا، إضافة المكاسب الجديدة إلى المكاسب السابقة
                $wallet->balance += $creatorShare;
                $wallet->last_earning = $creatorShare;
                $wallet->save();
            }
        } else {
            // إذا لم تكن المحفظة موجودة، إنشاء محفظة جديدة
            $wallet = Wallet::create([
                'user_id' => $article->creator_id,
                'balance' => $creatorShare,
                'last_earning' => $creatorShare, // تخزين آخر مكسب
            ]);
        }
    }

    // يمكنك استخدام dd لاختبار النتائج
    dd($url, $cost, $article, $earning, $wallet);
     }
      
    }
}