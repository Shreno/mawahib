<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class BackendWalletController extends Controller
{
    public function __construct()
    {
        
    }

    public function index(Request $request){

        $wallets=Wallet::orderBy('id','desc')->paginate(100);
        
        return view('admin.wallets.index',compact('wallets'));
    }


     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Wallet $wallet)
    {
        $transactions=Transaction::where('user_id',$wallet->user_id)->orderBy('id','DESC')->paginate(100);
        return view('admin.wallets.show',compact('wallet','transactions'));
    }
   




}
