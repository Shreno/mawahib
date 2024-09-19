@extends('layouts.app', ['page_title' => $article->title, 'page_description' => $article->meta_description, 'page_image' => $article->main_image()])
@section('content')
    <!-- Page Title Section Start -->
    <div class="page-title-section section">
        <div class="page-title">
            <div class="container">
                <h1 class="title">المقال</h1>
            </div>
        </div>
        <div class="page-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{route('home')}}">الرئيسية</a></li>
                    <li class="current">المقال</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Title Section End -->

    <!-- Course Details Section Start -->
    <div class="section">
        <div class="container">
            <div class="row max-mb-n50">
                <div class="col-12 col-lg-10 col-xl-8 mx-auto max-mb-50">
                    <!-- Course Details Wrapper Start -->
                    <div class="course-details-wrapper">
                        <div class="overview-article-img">
                            <img src="{{asset('storage/'.$article->main_image())}}" alt="">
                        </div>
                        <div class="course-nav-tab">
                            <ul class="nav">
                                <li>
                                    @foreach($article->categories as $article_category)
                            @if($loop->index<5) <a href="{{route('category.show',$article_category)}}" class="hover pe-2" rel="category">{{$article_category->title}}</a>
                                @endif
                                @endforeach
                                </li>
                            </ul>
                        </div>
                        <h1 class="font-3 font-lg-5 mb-4 ">{{$article->title}}</h1>
                        <ul class="post-meta mb-5">
                            <li class="post-date font-1"><i class="fal fa-calendar-alt"></i><span> {{\Carbon::parse($article->created_at)->diffForHumans()}}</span></li>
                            <li class="post-author font-1"><a href="{{route('blog',['user_id'=>$article->creator->id])}}" class="font-1"><i class="fal fa-user"></i><span> {{$article->creator->name}}</span></a></li>
                            @if($article->comments_count!=0)
                            <li class="post-comments"><a href="#comments"><i class="fal fa-comment"></i> {{$article->comments_count}}<span> تعليقات</span></a></li>
                            @endif
                            @if($article->views!=0)
                            <li class="post-comments"><a href="#comments"><i class="fas fa-fa-thin fa-eyes"></i> {{$article->views}}<span> مشاهدة</span></a></li>
                            @endif
                        </ul>

                        <div class="tab-content">
                            <div id="overview" class="tab-pane fade show active">
                                @if($article->app_name!=null)

                                <div class="sidebar-entry-course-info">
                                    <div class="course-meta">
                                        <div class="course-instructor">
                                            <span class="meta-label">
                                                <i class="fas fa-chalkboard-teacher"></i>
                                                الاسم
                                            </span>
                                            <span class="meta-value title">{{$article->app_name}}</span>
                                        </div>
                                        <div class="course-price">
                                            <span class="meta-label">
                                                <i class="meta-icon fas fa-money-bill-wave"></i>
                                                السعر
                                            </span>
                                            <span class="meta-value">
                                                <span class="price">{{$article->price}}</span>
                                            </span>
                                        </div>
                                        <div class="course-duration">
                                            <span class="meta-label">
                                                <i class="fas fa-download"></i>
                                                التحميلات
                                            </span>
                                            <span class="meta-value">أكثر من +{{$article->download_count}} تحميل</span>
                                        </div>
                                        <div class="course-lectures">
                                            <span class="meta-label">
                                                <i class="fas fa-star"></i>
                                                التقييمات
                                            </span>
                                            <span class="meta-value">{{$article->rating}}
                                                @for ($i = 0; $i <= $article->rating; $i++)
                                                <i class="fas fa-star"></i>

                                                @endfor
                                               
                                            </span>
                                        </div>

                                        <div class="course-students">
                                            <span class="meta-label">
                                                <i class="fas fa-shield-virus"></i>
                                                الحماية
                                            </span>
                                            <span class="meta-value">خالي من الفيروسات
                                            </span>
                                        </div>

                                    </div>
                                  

                                </div>
                                @endif

                                <div class="course-overview">

                                    <article class="post">
                                        {!!$article->description!!}
                                    </article>


                                    
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-form-section section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-10 col-xl-8 mx-auto">
                    <div class="contact-title max-width-600">
                        <h2 class="title">
                            شاركنا رأيك
                        </h2>
                        <p class="pt-4">لن يتم نشر بريدك</p>
                    </div>
                    <div class="contact-form">
                        <form action="{{route('comment-post')}}" method="POST" id="contact-form" >
                            @csrf
                            <input type="hidden" name="article_id" value="{{$article->id}}">
                            <div class="row max-mb-n30">
                                @guest

                                <div class="col-12 max-mb-30">
                                    <input type="text" placeholder="الاسم *" name="adder_name" />
                                </div>
                                <div class="col-12 max-mb-30">
                                    <input type="text" placeholder="البريد الإلكتروني*" name="adder_email" />
                                </div>
                                @endguest

                                <div class="col-12 max-mb-30">
                                    <textarea name="content" placeholder="أضـف تعليـق"></textarea>
                                </div>
                                <div class="col-12 text-center max-mb-30">
                                    <button type="submit" class="btn btn-primary btn-hover-secondary btn-width-180 btn-height-60">
                                        إرسال
                                    </button>
                                </div>
                            </div>
                        </form>
                        <p class="form-messege"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Courses Section Start -->
    <div class="related-articles-section section section-padding-bottom">
        <div class="container">
            <!-- Section Title Start -->
            <div class="section-title text-center" data-aos="fade-up">
                <h2 class="title">مقالات مقترحة</h2>
            </div>
            <!-- Section Title End -->

            <!-- Topics Wrapper Start -->
            <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 max-mb-n30">
                @foreach ($articles as $article)
                    <div class="col max-mb-30" data-aos="fade-up">
                        <div class="course-2">
                            <div class="thumbnail">
                                <a href="{{ route('article.show', $article) }}" class="image"><img
                                        src="{{ asset('storage' . $article->main_image()) }}" alt="Course Image" /></a>
                            </div>
                            <div class="info">
                                <img class="small-thum" src="{{ asset('storage' . $article->creator->getUserAvatar()) }}"
                                    alt="thum-img">
                                <h4 class="title">
                                    <a href="{{ route('article.show', $article) }}">{{ $article->title }}</a>
                                </h4>
                                <span class="category">
                                    @foreach ($article->categories as $article_category)
                                        @if ($loop->index < 3)
                                            <a href="{{ route('category.show', $article_category) }}" class="hover"
                                                rel="category">{{ $article_category->title }}</a>
                                        @endif
                                    @endforeach
                                </span>
                                <span class="date"> <i class="far fa-clock"></i>
                                    {{ \Carbon::parse($article->created_at)->diffForHumans() }} </i></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Related Courses Section End -->
@endsection
