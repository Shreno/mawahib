@extends('layouts.app',['page_title'=>'المقالات'])
@section('content')


    <!-- Page Title Section Start -->
    <div class="page-title-section section">
        <div class="page-title">
          <div class="container">
            <h1 class="title">المقالات</h1>
          </div>
        </div>
        <div class="page-breadcrumb">
          <div class="container">
            <ul class="breadcrumb">
              <li><a href="{{url('/')}}">الرئيسية</a></li>
              <li class="current">المقالات</li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Page Title Section End -->

      <!-- Course Section Start -->
      <div class="articles section section-padding-bottom">
        <div class="container">
          <!-- Course Top Bar Start -->
          <div class="row justify-content-between align-items-center max-mb-20">
            <div class="col-sm-auto col-12 max-mb-10">
              <p class="result-count">
                المقالات المتاحة <span>{{$articlesCount}}</span> 
              </p>
            </div>
            <div class="col-sm-auto col-12 max-mb-10">
              <select class="sort-by">
                <option selected="selected">الأحدث أولاً</option>
                <option value="popularity">الأكثر شعبية</option>
                <option value="rate">الأعلى تقييمًا</option>
                <option value="comment">الأكثر تعليقًا</option>
                <option value="oldest">الأقدم أولاً</option>
              </select>
            </div>
          </div>
          <!-- Course Top Bar End -->

          <!-- Courses Wrapper Start -->
          <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 max-mb-n30">

             @foreach($articles as $article)
        <div class="col max-mb-30" data-aos="fade-up">
          <div class="course-2">
            <div class="thumbnail">
              <a href="{{route('article.show',$article)}}" class="image"
                ><img
                  src="{{asset('storage'.$article->main_image())}}"
                  alt="Course Image"
              /></a>
            </div>
            <div class="info">
              <img class="small-thum" src="{{asset('storage'.$article->creator->getUserAvatar())}}" alt="thum-img">
              <h4 class="title">
                <a href="{{route('article.show',$article)}}"
                  >{{$article->title}}</a
                >
              </h4>
              <span class="category">
                @foreach($article->categories as $article_category)
                @if($loop->index<3)
                  <a href="{{route('category.show',$article_category)}}" class="hover" rel="category">{{$article_category->title}}</a>
                @endif
              @endforeach
              </span>
              <span class="date"> <i class="far fa-clock"></i>  {{\Carbon::parse($article->created_at)->diffForHumans()}} </i></span>
            </div>
          </div>
        </div>
        @endforeach

          
        </div>
          <!-- Courses Wrapper End -->

          {{ $articles->links('vendor.pagination.custom') }}

        </div>
      </div>
      <!-- Course Section End -->




@endsection