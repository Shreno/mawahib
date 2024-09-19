<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_AdSense;
use Illuminate\Support\Facades\Http;

class GoogleAdSenseController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri(config('services.google.redirect'));
        $this->client->addScope('https://www.googleapis.com/auth/adsense.readonly');
    }

    public function redirectToGoogle()
    {
        $authUrl = $this->client->createAuthUrl();
        return redirect()->to($authUrl);
    }

    public function handleGoogleCallback(Request $request)
    {
        $code = $request->query('code');
        if (!$code) {
            return redirect()->route('home')->with('error', 'Authorization code not found.');
        }

        $this->client->fetchAccessTokenWithAuthCode($code);
        $accessToken = $this->client->getAccessToken();
        $refreshToken = $accessToken['refresh_token'] ?? null;

        session(['google_access_token' => $accessToken['access_token']]);
        session(['google_refresh_token' => $refreshToken]);

        return redirect()->route('adsense.report');
    }

    public function getEarnings($startDate,$endDate)
    {
        $accessToken = session('google_access_token');
        if (!$accessToken) {
            return redirect()->route('google.redirect');
        }

        $this->client->setAccessToken($accessToken);
        $adsense = new Google_Service_AdSense($this->client);
        $accountId = '9978657914'; // Replace with your AdSense account ID
        $startDate = '2024-08-01';
        $endDate = '2024-08-31';

        $report = $adsense->accounts_reports->generate($accountId, $startDate, $endDate, [
            'metric' => ['EARNINGS'],
        ]);

        $rows = $report->getRows();

        // Save earnings to database
        foreach ($rows as $row) {
            // Assume your `earnings` table has columns: date, earnings
            \DB::table('earnings')->updateOrInsert(
                ['date' => $row[0]], 
                ['earnings' => $row[1]]
            );
        }

        return view('adsense-report', ['earnings' => $rows]);
    }
}