   <!-- Latest Topics Start -->
   <div class="topics section section-padding">
    <div class="container">
      <!-- Section Title Start -->
      <div class="section-title text-center" data-aos="fade-up">
        <h2 class="title">أحدث مواضيع الأعضاء</h2>
      </div>
      <!-- Section Title End -->

      <!-- Topics Wrapper Start -->
      <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 max-mb-n30">
        @php
        $articles = \App\Models\Article::orderBy('id','DESC')->take(12)->get();
        @endphp
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
  </div>
  </div>
  <!-- Latest Topics End -->