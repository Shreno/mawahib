<?php
namespace App\Http\Controllers;

use App\Services\GoogleAdSenseService;
use Illuminate\Http\Request;

class AdSenseController extends Controller
{
    protected $adsenseService;

    public function __construct(GoogleAdSenseService $adsenseService)
    {
        $this->adsenseService = $adsenseService;
    }

    public function fetchEarnings()
    {
        // استدعاء الأرباح بين تاريخين
        $startDate = '2024-08-01';
        $endDate = '2024-08-31';
        $earnings = $this->adsenseService->getEarnings($startDate, $endDate);

        // قم بتخزين البيانات في قاعدة البيانات
        foreach ($earnings as $row) {
            \DB::table('earnings')->updateOrInsert(
                ['date' => $row[0]], 
                ['earnings' => $row[1]]
            );
        }

        return response()->json(['message' => 'Earnings fetched and stored successfully.']);
    }
}