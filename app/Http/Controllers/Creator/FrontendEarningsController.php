<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\Article;
use Illuminate\Http\Request;
use DB;

class FrontendEarningsController extends Controller
{
    
    public function __construct()
    {
       
    }

    public function index(Request $request)
    {
              // 
        $earnings = Earning::select(
            'article_id',
            DB::raw('SUM(total_revenue) as total_revenue'),
            DB::raw('SUM(creator_share) as creator_share'),
            DB::raw('SUM(site_share) as site_share'),
        )
       ->where(function($q) use ($request) {
            // Filter earnings based on the article's creator ID
            $q->whereHas('article', function($query) {
                $query->where('creator_id', Auth()->user()->id);
            });
            if ($request->id != null) {
                $q->where('id', $request->id);
            }
            if ($request->q != null) {
                $q->whereHas('article', function($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->q . '%')
                          ->orWhere('slug', 'like', '%' . $request->q . '%')
                          ->orWhere('description', 'like', '%' . $request->q . '%')
                          ->orWhere('meta_description', 'like', '%' . $request->q . '%');
                });
            }
        })
        ->groupBy('article_id')
        ->orderBy('last_earning', 'DESC')
        ->paginate(100);



        // 
        return view('creator.earnings.index',compact('earnings'));
    }
    public function show($slug){

        $article=Article::where('slug',$slug)->first();
        $earnings = Earning::where('article_id',$article->id)->paginate(100);
        return view('creator.earnings.show', compact('earnings'));


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
