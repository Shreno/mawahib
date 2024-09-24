<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class EditorArticalController extends Controller
{
    
    public function __construct()
    {
       
    }


    public function index(Request $request)
    {
        if(auth()->user()->hasrole('editor'))
        { $articles = Article::where('user_id',auth()->user()->id)->where(function ($q) use ($request) {
            if ($request->id != null)
                $q->where('id', $request->id);
            if ($request->q != null)
                $q->where('title', 'LIKE', '%' . $request->q . '%')->orWhere('description', 'LIKE', '%' . $request->q . '%');
        })->orderBy('id', 'DESC')->paginate();

        }else{
            $articles = Article::where(function ($q) use ($request) {
                if ($request->id != null)
                    $q->where('id', $request->id);
                if ($request->q != null)
                    $q->where('title', 'LIKE', '%' . $request->q . '%')->orWhere('description', 'LIKE', '%' . $request->q . '%');
            })->orderBy('id', 'DESC')->paginate();
        }
       
        return view('editor.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::get();
        $categories = Category::orderBy('id', 'DESC')->get();
        $creators = User::where('user_type', 'creator')->orderBy('id', 'DESC')->get();

        return view('editor.articles.create', compact('categories', 'tags', 'creators'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'slug' => \MainHelper::slug($request->slug)
        ]);
        $request->validate([
            'slug' => "required|max:190|unique:articles,slug",
            'category_id' => "required|array",
            'category_id.*' => "required|exists:categories,id",
            'creator_id' => "required|exists:users,id",
            'is_featured' => "required|in:0,1",
            'title' => "required|max:190",
            'description' => "nullable|max:100000",
            'meta_description' => "nullable|max:10000",
            'app_name' => 'nullable|string|max:255',
            'app_description' => 'nullable|string',
            'app_link' => 'nullable|url',
            'download_count' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'rating' => 'nullable|numeric|min:0|max:5',
            'developer' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'version' => 'nullable|string|max:255',
        ]);
        $article = Article::create([
            'user_id' => auth()->user()->id,
            'creator_id' => $request->creator_id,
            "slug" => $request->slug,
            "is_featured" => $request->is_featured == 1 ? 1 : 0,
            "title" => $request->title,
            "description" => $request->description,
            "meta_description" => $request->meta_description,
            'app_name' => $request->app_name,
            'app_description' => $request->app_description,
            'app_link' => $request->app_link,
            'download_count' => $request->download_count,
            'price' => $request->price,
            'rating' => $request->rating,
            'developer' => $request->developer,
            'category' => $request->category,
            'version' => $request->version,
        ]);
        if(auth()->user()->hasrole('editor'))
        {
            // 1. إضافة رصيد إلى المحفظة
            $this->addToWallet(auth()->user(), $article);

           // 2. تسجيل المعاملة
           $this->createTransaction(auth()->user(), $article);
        }

        $article->categories()->sync($request->category_id);
        $article->tags()->sync($request->tag_id);
        \MainHelper::move_media_to_model_by_id($request->temp_file_selector, $article, "description");
        if ($request->hasFile('main_image')) {
            $main_image = $article->addMedia($request->main_image)->toMediaCollection('image');
            $article->update(['main_image' => $main_image->id . '/' . $main_image->file_name]);
        }
        toastr()->success(__('utils/toastr.article_store_success_message'), __('utils/toastr.successful_process_message'));
        return redirect()->route('editor.articles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $this->authorize('view', $article);

        $tags = Tag::get();
        $categories = Category::orderBy('id', 'DESC')->get();
        $creators = User::where('user_type', 'creator')->orderBy('id', 'DESC')->get();

        return view('editor.articles.edit', compact('article', 'categories', 'tags', 'creators'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $request->merge([
            'slug' => \MainHelper::slug($request->slug)
        ]);

        $request->validate([
            'slug' => "required|max:190|unique:articles,slug," . $article->id,
            'category_id' => "required|array",
            'category_id.*' => "required|exists:categories,id",
            'creator_id' => "required|exists:users,id",

            'is_featured' => "required|in:0,1",
            'title' => "required|max:190",
            'description' => "nullable|max:100000",
            'meta_description' => "nullable|max:10000",
            'app_name' => 'nullable|string|max:255',
            'app_description' => 'nullable|string',
            'app_link' => 'nullable|url',
            'download_count' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'rating' => 'nullable|numeric|min:0|max:5',
            'developer' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'version' => 'nullable|string|max:255',
        ]);
        $article->update([
            'user_id' => auth()->user()->id,
            'creator_id' => $request->creator_id,

            "slug" => $request->slug,
            "is_featured" => $request->is_featured == 1 ? 1 : 0,
            "title" => $request->title,
            "description" => $request->description,
            "meta_description" => $request->meta_description,
            'app_name' => $request->app_name,
            'app_description' => $request->app_description,
            'app_link' => $request->app_link,
            'download_count' => $request->download_count,
            'price' => $request->price,
            'rating' => $request->rating,
            'developer' => $request->developer,
            'category' => $request->category,
            'version' => $request->version,
        ]);
        $article->categories()->sync($request->category_id);
        $article->tags()->sync($request->tag_id);
        \MainHelper::move_media_to_model_by_id($request->temp_file_selector, $article, "description");
        if ($request->hasFile('main_image')) {
            $main_image = $article->addMedia($request->main_image)->toMediaCollection('image');
            $article->update(['main_image' => $main_image->id . '/' . $main_image->file_name]);
        }
        toastr()->success(__('utils/toastr.article_update_success_message'), __('utils/toastr.successful_process_message'));
        return redirect()->route('editor.articles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
        toastr()->success(__('utils/toastr.article_destroy_success_message'), __('utils/toastr.successful_process_message'));
        return redirect()->route('editor.articles.index');
    }

    protected function addToWallet(User $user, Article $article)
{
    // هنا يمكنك تحديد المبلغ الذي تريد إضافته
    $amount = 1; // مثال، المبلغ الثابت الذي سيتم إضافته
    $wallet = Wallet::where('user_id', $user->id)->first();
    if ($wallet) 
    {
        

            $wallet->balance += $amount;
            $wallet->last_earning = $amount;
            $wallet->save();
        
    } else {
        // إذا لم تكن المحفظة موجودة، إنشاء محفظة جديدة
        $wallet = Wallet::create([
            'user_id' => $article->user_id,
            'balance' => $amount,
            'last_earning' => $amount, // تخزين آخر مكسب
        ]);
    }
}

protected function createTransaction(User $user, Article $article)
{
    // إنشاء معاملة جديدة
    $transaction = new Transaction();
    $transaction->user_id = $user->id;
    $transaction->article_id = $article->id;
    $transaction->amount = 1; // المبلغ الذي تمت إضافته
    $transaction->type = 'deposit'; // نوع المعاملة "ربح"
    $transaction->description= ' أضافة  بمقدار ' . 1 . ' لكتابة مقال  ' . $article->title;
    $transaction->save();

}
}
