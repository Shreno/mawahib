<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class BackendEditorController extends Controller
{


    public function __construct()
    {
        $this->middleware('can:editor-create', ['only' => ['create','store']]);
        $this->middleware('can:editor-read',   ['only' => ['show', 'index']]);
        $this->middleware('can:editor-update',   ['only' => ['edit','update']]);
        $this->middleware('can:editor-delete',   ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        
        $users =  User::where('user_type','editor')->where(function($q)use($request){
            if($request->id!=null)
                $q->where('id',$request->id);
            if($request->q!=null)
                $q->where('name','LIKE','%'.$request->q.'%')->orWhere('phone','LIKE','%'.$request->q.'%')->orWhere('email','LIKE','%'.$request->q.'%');
        })->withCount(['logs','articles_creator','contacts','comments'])->with(['roles'])->orderBy('last_activity','DESC')->orderBy('id','DESC')->paginate();

        return view('admin.editors.index',compact('users'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.editors.create');
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
           
        ]);
        $user = User::create([
            "name"=>$request->name,
            "phone"=>$request->phone,
            "bio"=>$request->bio,
            "blocked"=>$request->blocked,
            "email"=>$request->email,
            "password"=>\Hash::make($request->password),
            'user_type'=>'editor',
          

        ]);
        // 
        Wallet::create([
            'user_id' => $user->id, // ربط المحفظة بالمستخدم
            'balance' => 0, // يمكنك ضبط الرصيد الابتدائي كما تريد
        ]);

       

        if($request->hasFile('avatar')){
            $avatar = $user->addMedia($request->avatar)->toMediaCollection('avatar');
            $user->update(['avatar'=>$avatar->id.'/'.$avatar->file_name]);
        }

        toastr()->success('تم إضافة الكاتب  بنجاح','عملية ناجحة');
        return redirect()->route('admin.editors.index');
            
        
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

        return view('admin.editors.show',compact('user'));
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
        return view('admin.editors.edit',compact('user'));
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
           
        ]);
        $user->update([
            "name"=>$request->name,
            "phone"=>$request->phone,
            "bio"=>$request->bio,
            "blocked"=>$request->blocked,
            "email"=>$request->email,
          
            
        ]);
       

        if($request->password!=null){
            $user->update([
                "password"=>\Hash::make($request->password)
            ]);
        }
        if($request->hasFile('avatar')){
            $avatar = $user->addMedia($request->avatar)->toMediaCollection('avatar');
            $user->update(['avatar'=>$avatar->id.'/'.$avatar->file_name]);
        }

        toastr()->success('تم تحديث  الكاتب بنجاح','عملية ناجحة');
        return redirect()->route('admin.editors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!auth()->user()->can('editor-delete'))abort(403);
        $user=User::findOrFail($id);

        $user->delete();
        toastr()->success('تم حذف  الكاتب بنجاح','عملية ناجحة');
        return redirect()->route('admin.editors.index');
    }

    public function access(Request $request,User $user){
        if(auth()->user()->hasRole('superadmin')){
            auth()->logout();
            auth()->loginUsingId($user->id);
            return redirect('/');
        }
    }
}
