<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Transaction;


class BackendWithdrawalRequestController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('can:withdrawal_requests-create', ['only' => ['create','store']]);
        $this->middleware('can:withdrawal_requests-read',   ['only' => ['show', 'index']]);
        $this->middleware('can:withdrawal_requests-update',   ['only' => ['edit','update']]);
        $this->middleware('can:withdrawal_requests-delete',   ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $withdrawal_requests = WithdrawalRequest::where(function($q)use($request){
            if($request->id!=null)
                $q->where('id',$request->id);
        })->orderBy('id','DESC')->paginate(100);
        return view('admin.withdrawal_requests.index',compact('withdrawal_requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tag_name'=>"required|unique:tags,tag_name",
            'slug'=>"required|unique:tags,tag_name"
        ]);
        Tag::create([
            'tag_name'=>$request->tag_name,
            'arabic_name'=>$request->arabic_name,
            'english_name'=>$request->english_name,
            'slug'=>strtolower(str_replace(' ','-',$request->slug))
        ]);
        toastr()->success('تمت العملية بنجاح','عملية ناجحة');
        return redirect()->route('admin.tags.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $WithdrawalRequest=WithdrawalRequest::find($id);
        return view('admin.withdrawal_requests.show',compact('WithdrawalRequest'));

    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\WithdrawalRequest  $withdrawal_requests
     * @return \Illuminate\Http\Response
     */
    public function update(request $request,$id)
    {
        $withdrawal_requests=WithdrawalRequest::find($id);
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'image_confirm' => 'required_if:status,approved|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // التأكد من أن الطلب لا يزال قيد الانتظار
        if ($withdrawal_requests->status !== 'pending') {
            return back()->withErrors('هذا الطلب تم معالجته من قبل.');
        }
        if($request->status=='approved')
        {

               // خصم المبلغ من محفظة المستخدم
               $Wallet = Wallet::where('user_id',$withdrawal_requests->user_id)->first();
               if($Wallet->balance < $withdrawal_requests->balance)
               {
                toastr()->success('  تم رفض طلب السحب لا يوجد رصيد كافى .');
                return redirect()->route('admin.withdrawal_requests.index');


               }
               $Wallet->balance -= $withdrawal_requests->amount;
               $Wallet->withdrawn_balance += $withdrawal_requests->amount;

               $Wallet->save();

               // تحديث حالة السحب
                $withdrawal_requests->status = 'approved';
                $withdrawal_requests->approved_at = now();
               
                $withdrawal_requests->save();
                // 
                if ($request->hasFile('image_confirm')) {
                    $main_image = $withdrawal_requests->addMedia($request->image_confirm)->toMediaCollection('image');
                    $withdrawal_requests->update(['image_confirm' => $main_image->id . '/' . $main_image->file_name]);
                }
                // 
                Transaction::create([
                    'user_id' => $withdrawal_requests->user_id,
                    'type' => 'withdrawal',
                    'withdrawal_request_id' =>$withdrawal_requests->id,
                    'amount' => $withdrawal_requests->amount,
                    'description' => 'سحب بمقدار ' . $withdrawal_requests->amount . ' عبر ' . $withdrawal_requests->payment_method,
                ]);



        }elseif($request->status=='rejected'){

            $withdrawal_requests->rejected_at = now();
            $withdrawal_requests->save();
            toastr()->success('تم رفض طلب السحب.');

        }

       
        return redirect()->route('admin.withdrawal_requests.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(WithdrawalRequest $withdrawal_requests)
    {
        $withdrawal_requests->delete();
        toastr()->success('تمت العملية بنجاح');
        return redirect()->back();;
    }
}
