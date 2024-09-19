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
                المقالات المتاحة <span>{{$articles->total()}}</span> 
              </p>
            </div>
            <div class="col-sm-auto col-12 max-mb-10">
              <form method="get" action="{{route('articles')}}"
              <select class="sort-by" name="sort" id="sort-by">
                  <option value="latest" selected="selected">الأحدث أولاً</option>
                  <option value="popularity">الأكثر شعبية</option>
                  {{-- <option value="rate">الأعلى تقييمًا</option> --}}
                  <option value="comment">الأكثر تعليقًا</option>
                  <option value="oldest">الأقدم أولاً</option>
              </select>
              </form>
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
              <img class="small-thum"  src="{{$article->creator->getUserAvatar() ? asset('storage/' . $article->creator->getUserAvatar()) : asset('storage/'.$settings['get_website_logo']) }}" alt="{{$article->creator->name}}">

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
ppppp
@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
      const sortBy = document.querySelector('#sort-by');
      
      sortBy.addEventListener('change', function () {
          const sortValue = this.value;
          alert(sortValue);
          fetchArticles(sortValue);
      });

      function fetchArticles(sortValue) {
            $.ajax({
                url: "{{ route('articles') }}", // Ensure this route points to your index method
                type: 'GET',
                data: {
                    sort: sortValue
                },
                success: function (data) {
                    // Replace the content with the updated articles list
                    $('.articles').html($(data).find('.articles').html());
                },
                error: function (xhr) {
                    console.error('Error:', xhr);
                }
            });
        }
  });
</script>



@endsection