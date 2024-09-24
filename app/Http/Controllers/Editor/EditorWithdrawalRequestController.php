<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Wallet;


class EditorWithdrawalRequestController extends Controller
{

    public function index(Request $request)
    {
        $withdrawal_requests =  WithdrawalRequest::where('user_id',Auth()->user()->id)->where(function($q)use($request){
            if($request->id!=null)
                $q->where('id',$request->id);
            if($request->q!=null)
                $q->where('payment_method','LIKE','%'.$request->q.'%')->orWhere('payment_details','LIKE','%'.$request->q.'%')
                ->orWhere('amount','LIKE','%'.$request->q.'%')->orWhere('status','LIKE','%'.$request->q.'%')
                ->orwhereHas('user', function($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->q . '%');});
        })->orderBy('id','DESC')->paginate(100);
        return view('editor.withdrawal_requests.index',compact('withdrawal_requests'));
    }
    public function create(){
        return view('editor.withdrawal_requests.create');

    }

    public function show($id){
        $WithdrawalRequest=WithdrawalRequest::find($id);
        return view('editor.withdrawal_requests.show',compact('WithdrawalRequest'));
    }

    public function edit($id){
        $WithdrawalRequest=WithdrawalRequest::find($id);
        return view('editor.withdrawal_requests.edit',compact('WithdrawalRequest'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:Zain Cash,USDT Binance,Payoneer',
            'payment_details' => 'nullable|string',
        ]);
    
        $wallet = Wallet::where('user_id', auth()->id())->first();
    
        if ($wallet->balance >= $request->amount) {
            // إنشاء طلب السحب
            WithdrawalRequest::where('id',$id)->update([
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_details' => $request->payment_details,
                'status' => 'pending',
            ]);
    
           
    
            toastr()->success(__('تم تحديث طلب السحب'));
            return redirect()->route('user.withdrawal_requests.index');


        } else {
            toastr()->success(__('الرصيد غير متاح'));
            return redirect()->back();


        }
        
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


    public function destroy($id)
    {
        $withdrawal_equests=WithdrawalRequest::find($id);
        if($withdrawal_equests->satus!='approved')
        {
            $withdrawal_equests->delete();
            toastr()->success(__('تم مسح الطلب '));
            return redirect()->route('editor.withdrawal_requests.index');

        }else{
            toastr()->success(__('لا يمكن مسح الطلب'));
            return redirect()->route('editor.withdrawal_requests.index');
        }
        
    }




}