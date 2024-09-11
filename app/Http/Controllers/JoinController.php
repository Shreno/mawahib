<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Contact;
use App\Models\JoinRequest;



class JoinController extends Controller
{
    
    public function showForm()
    {
        return view('front.pages.join-form');
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

