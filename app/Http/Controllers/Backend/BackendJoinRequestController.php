<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\JoinRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use Hash;


class BackendJoinRequestController extends Controller
{


    public function __construct()
    {
        $this->middleware('can:join-requests-create', ['only' => ['create', 'store']]);
        $this->middleware('can:join-requests-read', ['only' => ['show', 'index']]);
        $this->middleware('can:join-requests-update', ['only' => ['edit', 'update', 'resolve']]);
        $this->middleware('can:join-requests-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        if (!auth()->user()->can('join-requests-read'))
            abort(403);
        $joinRequests = JoinRequest::where(function ($q) use ($request) {
            if ($request->id != null)
                $q->where('id', $request->id);
            if ($request->user_id != null)
                $q->where('user_id', $request->user_id);
            if ($request->q != null)
                $q->where('name', 'LIKE', '%' . $request->q . '%')->orWhere('phone', 'LIKE', '%' . $request->q . '%')->orWhere('email', 'LIKE', '%' . $request->q . '%')->orWhere('status', 'LIKE', '%' . $request->q . '%')->orWhere('notes', 'LIKE', '%' . $request->q . '%');
        })->orderBy('id', 'DESC')->paginate(25);

        return view('admin.joinRequests.index', compact('joinRequests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JoinRequest  $joinRequest
     * @return \Illuminate\Http\Response
     */
    public function show(JoinRequest $joinRequest)
    {
        if (!auth()->user()->can('join-requests-read'))
            abort(403);
        return view('admin.joinRequests.show', compact('joinRequest'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JoinRequest  $JoinRequest
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JoinRequest  $JoinRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JoinRequest $JoinRequest)
    {
        if (!auth()->user()->can('join-requests-update'))
            abort(403);
        if ($request->status == 'approved') {
            $request = $JoinRequest;

            $existingUser = User::where('email', $request->email)->first();

            if ($existingUser) {
                return back()->with('error', 'البريد الإلكتروني مستخدم بالفعل.');
            }

            // إنشاء مستخدم جديد
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make('12345678'),
                'user_type'=>'creator',
                "followers"=>$request->followers,
                "platform_link"=>$request->platform_link,
                "facebook_link"=>$request->facebook_link,
                "tiktok_link"=>$request->tiktok_link,
                "youtube_link"=>$request->youtube_link,


            ]);

            // إرسال بريد إلكتروني لإعادة تعيين كلمة المرور
            // Password::sendResetLink(['email' => $user->email]);

            // تحديث حالة طلب الانضمام
            $request->update(['status' => 'approved']);

            return back()->with('success', 'تمت الموافقة على الطلب وتم إنشاء حساب المستخدم، وتم إرسال رابط تعيين كلمة المرور.');

        } else {
            $JoinRequest->update([
                "status" => $request->status,
            ]);

        }
       


        return redirect()->route('admin.join-requests.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JoinRequest  $JoinRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(JoinRequest $JoinRequest)
    {
        if (!auth()->user()->can('join-requests-delete'))
            abort(403);
            $JoinRequest->delete();

            return back()->with('success', 'تم مسح طلب اللإنضمام بنجاح');
    }

    public function resolve(Request $request)
    {
        if (!auth()->user()->can('join-request-update'))
            abort(403);
        $JoinRequest = \App\Models\JoinRequest::where('id', $request->contact_id)->firstOrFail();
        $JoinRequest->update(['status' => $JoinRequest->status == "pending" ? "approved" : "pending"]);
        return 1;
    }
}
