<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\Earning;
use App\Models\Transaction;
use App\Models\Article;
use App\Models\RateLimitDetail;
use Carbon\Carbon;
use App\Models\User;

use Illuminate\Support\Facades\DB;


use App\Http\Controllers\Controller;


class EditorProfileController extends Controller
{
    public function dashboard(Request $request)
    {
        $totalEarnings=Transaction::where('user_id',Auth()->user()->id)->where('type','deposit')->sum('amount');
        $toDayEarnings = Transaction::where('user_id',Auth()->user()->id)->where('type','deposit')
        ->whereDate('created_at', today())
        ->sum('amount');
        


        $articles = Article::where('is_approved', 1)
        ->where('user_id', Auth()->user()->id)
        ->orderBy('views', 'desc')
        ->take(10)
        ->get(); 
        $days = $request->input('days', 7); // إذا لم يتم تحديد شيء، يكون الافتراضي 7

        
        $revenueData =Transaction::where('user_id',Auth()->user()->id)->where('type','deposit')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total_earnings'))
        ->whereDate('created_at', '>=', Carbon::now()->subDays($days)) // تغيير عدد الأيام إلى 30
        ->groupBy(DB::raw('DATE(created_at)')) // التجميع حسب التاريخ فقط بدون الوقت
        ->orderBy('date', 'asc')
        ->get();

        return view('editor.index',compact('totalEarnings','articles','toDayEarnings','revenueData','days'));

    }
    public function balances(Request $request)
    {
        return view('editor.user.balances');
    }
    public function support(Request $request)
    {
        return view('editor.user.support');
    }
    public function create_ticket(Request $request)
    {
        return view('editor.user.create-ticket');
    }
    public function store_ticket(Request $request)
    {
        $ticket = \App\Models\Contact::create([
            'user_id'=>auth()->user()->id,
            'name'=>auth()->user()->name,
            'email'=>auth()->user()->email,
            'message'=>$request->message
        ]);
        if($request->files !=null){
            foreach($request->files as $file){
                $ticket->addMedia($file)->toMediaCollection();
            }
        }
        return redirect()->route('user.ticket',$ticket);
    }
    
    public function ticket(Request $request,Contact $ticket)
    {
        return view('front.user.ticket',compact('ticket'));
    }
    public function reply_ticket(Request $request)
    {
        $request->validate([
            'message'=>"required|string|min:10|max:1000",
        ]);
        $ticket = \App\Models\Contact::where('user_id',auth()->user()->id)->where('id',$request->ticket_id)->firstOrFail();
        ContactReply::create([
            'user_id'=>auth()->user()->id,
            'is_support_reply'=>0,
            'contact_id'=>$ticket->id,
            'content'=>$request->message
        ]);
        return redirect()->back()->with([
            'message'=>"تم ارسال رسالتك بنجاح",
            'alert-type'=>"warning"
        ]);
        
    }
    public function notifications(Request $request)
    {
        return view('front.user.notifications');
    }
    public function profile_edit(Request $request)
    {
        return view('editor.user.settings');
    }
    public function profile_update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name'=>"nullable|max:190",
            'phone'=>"nullable|max:190",
            'bio'=>"nullable|max:5000",
          
        ]);
        $user->update([
            "name"=>$request->name,
            "phone"=>$request->phone,
            "bio"=>$request->bio,
           
            
        ]);
       

      
        if($request->hasFile('avatar')){
            $avatar = $user->addMedia($request->avatar)->toMediaCollection('avatar');
            $user->update(['avatar'=>$avatar->id.'/'.$avatar->file_name]);
        }

        toastr()->success('تم تحديث الكاتب بنجاح','عملية ناجحة');
        return back();
    }
    public function profile_update_password(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed', // This checks if password matches password_confirmation
        ]);

        // Find the authenticated user
        $user = auth()->user();

        // Check if the old password matches
        if (Hash::check($validatedData['old_password'], $user->password)) {
            // Update the user's password
            $user->password = Hash::make($validatedData['password']);
            $user->save();

            toastr()->success(__('utils/toastr.article_update_success_message'), __('تم التحديث بنجاح'));
            return back();

        } else {
            toastr()->success(__('utils/toastr.article_update_success_message'), __('خطأ  فى البريد الاكترونى'));
            return back();

        }
    }
    
    public function profile_update_email(Request $request)
    {
        $validatedData = $request->validate([
            'old_email' => 'required|email',
            'email' => 'required|email|confirmed', // This checks if email matches email_confirmation
        ]);
        $user = User::where('email', $validatedData['old_email'])->first();
        if ($user) {
            // Update the email if the old email matches
            $user->email = $validatedData['email'];
            $user->save();

            toastr()->success(__('utils/toastr.article_update_success_message'), __('تم التحديث بنجاح'));
            return back();


        } else {
            toastr()->success(__('utils/toastr.article_update_success_message'), __('خطأ  فى البريد الاكترونى'));
            return back();


        }


    }

}
