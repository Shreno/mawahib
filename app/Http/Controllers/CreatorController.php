<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\models\Article;



class CreatorController extends Controller
{
    
    public function index()
    {
        $creators=User::where('user_type','creator')->paginate(24);
        return view('front.pages.creators',compact(var_name: 'creators'));
    }

    public function show($id){
        $creator=User::where('user_type','creator')->where('id',$id)->first();
        $articles=  Article::where('is_approved',1)->with('categories', 'creator')->where('creator_id',$id)->withCount('comments')->orderBy('views','DESC')->paginate(24); // Count the comments

        return view('front.pages.creator', compact('creator', 'articles'));


    }
    
    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'followers' => 'required|integer',
            'platform_link' => 'required|url',
            'youtube_link' => 'nullable|url',
            'facebook_link' => 'nullable|url',
            'tiktok_link' => 'nullable|url',
            'notes' => 'nullable|string',
        ]);
    
        // احفظ البيانات أو قم بمعالجتها هنا
        JoinRequest::create($validated);

    
        return back()->with('success', 'تم إرسال الطلب بنجاح.');
    }
    
 
}

