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

    public function index(Request $request,User $user){
        $roles = Role::get();
        return view('admin.users.roles',compact('roles','user'));
    }
    public function update(Request $request,User $user){
        $user->syncRoles($request->roles);

        //$user->syncPermissions(DB::table('model_has_permissions')->whereIn('role_id',$request->roles)->pluck('permission_id'));
        toastr()->success("تمت العملية بنجاح");
        return redirect()->route('admin.users.index');
    }

    //////
    // إضافة مبلغ إلى المحفظة (إيداع):
    public function deposit($userId, $amount)
{
    $wallet = Wallet::where('user_id', $userId)->first();
    $wallet->balance += $amount;
    $wallet->save();

    // تسجيل المعاملة
    Transaction::create([
        'user_id' => $userId,
        'type' => 'deposit',
        'amount' => $amount,
        'status' => 'completed'
    ]);
}
// تعليق مبلغ (مثلًا عند انتظار أرباح):

public function addPending($userId, $amount)
{
    $wallet = Wallet::where('user_id', $userId)->first();
    $wallet->pending_balance += $amount;
    $wallet->save();

    // تسجيل المعاملة
    Transaction::create([
        'user_id' => $userId,
        'type' => 'pending',
        'amount' => $amount,
        'status' => 'pending'
    ]);
}
// سحب مبلغ من المحفظة:
public function withdraw($userId, $amount)
{
    $wallet = Wallet::where('user_id', $userId)->first();

    if ($wallet->balance >= $amount) {
        $wallet->balance -= $amount;
        $wallet->withdrawn_balance += $amount;
        $wallet->save();

        // تسجيل المعاملة
        Transaction::create([
            'user_id' => $userId,
            'type' => 'withdrawal',
            'amount' => $amount,
            'status' => 'completed'
        ]);

        return "تم سحب المبلغ بنجاح!";
    } else {
        return "الرصيد غير كافٍ للسحب.";
    }
}
// عرض المعاملات الخاصة بصاحب المحفظة:
public function showTransactions($userId)
{
    return Transaction::where('user_id', $userId)->get();
}
// 5. تحديث الرصيد المعلق عند إتمام الأرباح:
public function approvePending($userId, $amount)
{
    $wallet = Wallet::where('user_id', $userId)->first();

    if ($wallet->pending_balance >= $amount) {
        $wallet->pending_balance -= $amount;
        $wallet->balance += $amount;
        $wallet->save();

        // تحديث حالة المعاملة
        $transaction = Transaction::where('user_id', $userId)
            ->where('amount', $amount)
            ->where('status', 'pending')
            ->first();
        
        if ($transaction) {
            $transaction->status = 'completed';
            $transaction->save();
        }

        return "تمت الموافقة على الأرباح المعلقة!";
    } else {
        return "الرصيد المعلق غير كافٍ.";
    }
}

}
