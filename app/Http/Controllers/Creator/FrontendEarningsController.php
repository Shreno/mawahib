<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use Illuminate\Http\Request;

class FrontendEarningsController extends Controller
{
    
    public function __construct()
    {
       
    }

    public function index(Request $request)
    {
        $earnings = Earning::where(function($q) use ($request) {
            // Filter earnings based on the article's creator ID
            $q->whereHas('article', function($query) {
                $query->where('creator_id', Auth()->user()->id);
            });
        
            // Filter by earning ID if provided
            if ($request->id != null) {
                $q->where('id', $request->id);
            }
        
            // Search for articles by title, slug, description, or meta description
            if ($request->q != null) {
                $q->whereHas('article', function($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->q . '%')
                          ->orWhere('slug', 'like', '%' . $request->q . '%')
                          ->orWhere('description', 'like', '%' . $request->q . '%')
                          ->orWhere('meta_description', 'like', '%' . $request->q . '%');
                });
            }
        })->orderBy('id', 'DESC')->paginate(100);
        return view('creator.earnings.index',compact('earnings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Update the specified resource in storage.
     *
   
     */
    public function destroy(Earning $earnings)
    {
        $earnings->delete();
        toastr()->success('تمت العملية بنجاح');
        return redirect()->back();;
    }
}
