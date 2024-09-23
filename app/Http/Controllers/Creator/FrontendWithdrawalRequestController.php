<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Wallet;


class FrontendWithdrawalRequestController extends Controller
{
    public function create(){
        return view('creator.withdrawal.create');

    }

    public function store(Request $request){
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:Zain Cash,USDT Binance,Payoneer',
            'payment_details' => 'nullable|string',
        ]);
    
        $wallet = Wallet::where('user_id', auth()->id())->first();
    
        if ($wallet->balance >= $request->amount) {
            // إنشاء طلب السحب
            WithdrawalRequest::create([
                'user_id' => auth()->id(),
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_details' => $request->payment_details,
                'status' => 'pending',
            ]);
    
           
    
            toastr()->success(__('تم إرسال طلب السحب'));
            return redirect()->back();


        } else {
            toastr()->success(__('الرصيد غير متاح'));
            return redirect()->back();


        }
        
    }




}