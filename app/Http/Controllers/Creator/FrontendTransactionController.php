<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\Transaction;

use Illuminate\Http\Request;

class FrontendTransactionController extends Controller
{
    
    public function __construct()
    {
       
    }

    public function index(Request $request)
    {
       
        $totalEarnings = Auth()->user()->earnings()->sum('creator_share'); // إجمالي أرباح الـ creator        

        $transactions=Transaction::where('user_id',Auth()->user()->id)->orderBy('id','DESC')->paginate(100);

        return view('creator.transactions.index',compact('transactions','totalEarnings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Update the specified resource in storage.
     *
   
     */
    public function destroy(Earning $earnings)
    {
        $earnings->delete();
        toastr()->success('تمت العملية بنجاح');
        return redirect()->back();;
    }
}
