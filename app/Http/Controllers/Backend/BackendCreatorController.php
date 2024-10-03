<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class BackendCreatorController extends Controller
{


    public function __construct()
    {
        $this->middleware('can:users-create', ['only' => ['create','store']]);
        $this->middleware('can:users-read',   ['only' => ['show', 'index']]);
        $this->middleware('can:users-update',   ['only' => ['edit','update']]);
        $this->middleware('can:users-delete',   ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        
        $users =  User::where('user_type','creator')->where(function($q)use($request){
            if($request->id!=null)
                $q->where('id',$request->id);
            if($request->q!=null)
                $q->where('name','LIKE','%'.$request->q.'%')->orWhere('phone','LIKE','%'.$request->q.'%')->orWhere('email','LIKE','%'.$request->q.'%');
        })->withCount(['logs','articles_creator','contacts','comments'])->with(['roles'])->orderBy('last_activity','DESC')->orderBy('id','DESC')->paginate();

        return view('admin.creators.index',compact('users'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.creators.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>"nullable|max:190",
            'phone'=>"nullable|max:190",
            'bio'=>"nullable|max:5000",
            'blocked'=>"required|in:0,1",
            'email'=>"required|unique:users,email",
            'password'=>"required|min:8|max:190",
            'followers' => 'required|integer',
            'platform_link' => 'required|url',
            'youtube_link' => 'nullable|url',
            'facebook_link' => 'nullable|url',
            'tiktok_link' => 'nullable|url',
        ]);
        $user = User::create([
            "name"=>$request->name,
            "phone"=>$request->phone,
            "bio"=>$request->bio,
            "blocked"=>$request->blocked,
            "email"=>$request->email,
            "password"=>\Hash::make($request->password),
            'user_type'=>'creator',
            "followers"=>$request->followers,
            "platform_link"=>$request->platform_link,
            "facebook_link"=>$request->facebook_link,
            "tiktok_link"=>$request->tiktok_link,
            "youtube_link"=>$request->youtube_link,

        ]);
        // 
        Wallet::create([
            'user_id' => $user->id, // ربط المحفظة بالمستخدم
            'balance' => 0, // يمكنك ضبط الرصيد الابتدائي كما تريد
        ]);

        // 
        // if(auth()->user()->can('user-roles-update')){
        //     $request->validate([
        //         'roles'=>"required|array",
        //         'roles.*'=>"required|exists:roles,id",
        //     ]);
        //     $user->syncRoles(array_map('intval',$request->roles));
        // }

        if($request->hasFile('avatar')){
            $avatar = $user->addMedia($request->avatar)->toMediaCollection('avatar');
            $user->update(['avatar'=>$avatar->id.'/'.$avatar->file_name]);
        }

        toastr()->success('تم إضافة صاحب محتوى بنجاح','عملية ناجحة');
        return redirect()->route('admin.creators.index');
            
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::findOrFail($id);

        return view('admin.creators.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::find($id);

        // $roles = Role::get();
        return view('admin.creators.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $user=User::findOrFail($id);
        $request->validate([
            'name'=>"nullable|max:190",
            'phone'=>"nullable|max:190",
            'bio'=>"nullable|max:5000",
            'blocked'=>"required|in:0,1",
            'email'=>"required|unique:users,email,".$user->id,
            'password'=>"nullable|min:8|max:190",
            'followers' => 'required|integer',
            'platform_link' => 'required|url',
            'youtube_link' => 'nullable|url',
            'facebook_link' => 'nullable|url',
            'tiktok_link' => 'nullable|url',
        ]);
        $user->update([
            "name"=>$request->name,
            "phone"=>$request->phone,
            "bio"=>$request->bio,
            "blocked"=>$request->blocked,
            "email"=>$request->email,
            "followers"=>$request->followers,
            "platform_link"=>$request->platform_link,
            "facebook_link"=>$request->facebook_link,
            "tiktok_link"=>$request->tiktok_link,
            "youtube_link"=>$request->youtube_link,
            
        ]);
        // if(auth()->user()->can('user-roles-update')){
        //     $request->validate([
        //         'roles'=>"required|array",
        //         'roles.*'=>"required|exists:roles,id",
        //     ]);
        //     $user->syncRoles($request->roles);
        // }

        if($request->password!=null){
            $user->update([
                "password"=>\Hash::make($request->password)
            ]);
        }
        if($request->hasFile('avatar')){
            $avatar = $user->addMedia($request->avatar)->toMediaCollection('avatar');
            $user->update(['avatar'=>$avatar->id.'/'.$avatar->file_name]);
        }

        toastr()->success('تم تحديث صاحب المحتوى بنجاح','عملية ناجحة');
        return redirect()->route('admin.creators.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!auth()->user()->can('users-delete'))abort(403);
        $user=User::findOrFail($id);

        $user->delete();
        toastr()->success('تم حذف صاحب المحتوى بنجاح','عملية ناجحة');
        return redirect()->route('admin.creators.index');
    }

    public function access(Request $request,User $user){
        if(auth()->user()->hasRole('superadmin')){
            auth()->logout();
            auth()->loginUsingId($user->id);
            return redirect('/');
        }
    }
}
