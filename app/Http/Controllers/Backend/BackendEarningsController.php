<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\Article;
use Illuminate\Http\Request;
use DB;

class BackendEarningsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('can:earnings-create', ['only' => ['create','store']]);
        $this->middleware('can:earnings-read',   ['only' => ['show', 'index']]);
        $this->middleware('can:earnings-update',   ['only' => ['edit','update']]);
        $this->middleware('can:earnings-delete',   ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $earnings = Earning::select(
                'article_id',
                DB::raw('SUM(total_revenue) as total_revenue'),
                DB::raw('SUM(creator_share) as creator_share'),
                DB::raw('SUM(site_share) as site_share'),
            )
            ->where(function($q) use ($request) {
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
    
        return view('admin.earnings.index', compact('earnings'));
    }
    public function show($slug){

        $article=Article::where('slug',$slug)->first();
        $earnings = Earning::where('article_id',$article->id)->paginate(100);
        return view('admin.earnings.show', compact('earnings'));


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
