@extends('layouts.app',['page_title'=>"تواصل معنا"])
@section('content')
      <!-- Page Title Section Start -->
      <div class="page-title-section section pb-0">
        <div class="page-breadcrumb">
          <div class="container">
            <ul class="breadcrumb">
              <li><a href="{{route('home')}}">الرئيسية</a></li>
              <li class="current">صانع المحتوى</li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Page Title Section End -->
      
      <div class="creator-info">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
            <div class="profile-card">
              <img src="{{asset('storage/'.$creator->getUserAvatar())}}" alt="صورة شخصية" class="profile-image">
              <h1 class="name">{{$creator->name}}</h1>
              
              <div class="bio text-center">
                  <p>{{$creator->bio}}</p>
              </div>
             
          </div>
          </div>
        </div>
      </div>
      </div>

      <div class="latest-posts section section-padding-bottom">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
            <h3 class="title">اخر المشاركات</h3>
            <div class="row row-cols-lg-4 row-cols-md-3 row-cols-2">
            @foreach($articles as $article)
              <div class="col max-mb-30" data-aos="fade-up">
                <div class="posts">
                  <div class="thumbnail">
                    <a href="{{route('article.show',$article)}}" class="image"
                      ><img
                        src="{{asset('storage'.$article->main_image())}}"
                        alt="Course Image"
                    /></a>
                  </div>
                  <div class="info">
                    <h5 class="title">
                      <a href="{{route('article.show',$article)}}"
                        >{{$article->title}}</a
                      >
                    </h5>
                    <div class="details">
                        @foreach($article->categories as $article_category)
                @if($loop->index<3)
                   <span class="category"> <a href="{{route('category.show',$article_category)}}" class="hover" rel="category">{{$article_category->title}}</a>
                </span>
                @endif
              @endforeach
                    <span class="date"> <i class="far fa-clock"></i>  {{\Carbon::parse($article->created_at)->diffForHumans()}} </i></span>
                  </div>
                  </div>
                </div>
              </div>
            @endforeach
            
           
            </div>
          </div>
          </div>
        </div>
      </div>
  
      </div>

@endsection