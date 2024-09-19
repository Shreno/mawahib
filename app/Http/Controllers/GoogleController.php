<?php
namespace App\Http\Controllers;

use Google_Client;
use Illuminate\Http\Request;
use App\Models\User;

class GoogleController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setClientId(config('services.google.client_id'));  // ضع Client ID هنا
        $this->client->setClientSecret(config('services.google.client_secret'));  // ضع Client Secret هنا
        $this->client->setRedirectUri(route('google.callback'));
        $this->client->addScope('https://www.googleapis.com/auth/adsense.readonly'); // فقط لقراءة بيانات AdSense
        $this->client->access_type="offline";


    }

    public function redirectToGoogle()
    {
        $authUrl = $this->client->createAuthUrl();
        return redirect()->away($authUrl);
    }

    public function handleGoogleCallback(Request $request)
    {
        $this->client->authenticate($request->code);
        $token = $this->client->getAccessToken();


        User::where('id',1)->update(['Access_token'=>$token['access_token']]);

        // حفظ Access Token في الجلسة أو قاعدة البيانات
        session(['google_access_token' => $token]);

        return redirect()->route(route: 'home');  // إعادة التوجيه إلى الصفحة الرئيسية أو أي صفحة أخرى
    }
}