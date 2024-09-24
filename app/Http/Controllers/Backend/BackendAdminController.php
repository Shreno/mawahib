<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class BackendAdminController extends Controller
{
    public function index(Request $request)
    {
       if(auth()->user()->hasRole('editor'))
       {

        $totalEarnings=Transaction::where('user_id',Auth()->user()->id)->where('type','deposit')->sum('amount');
        return view('admin.index_editor',compact('totalEarnings'));

       }else{
        return view('admin.index');

       }
    }
       
}
