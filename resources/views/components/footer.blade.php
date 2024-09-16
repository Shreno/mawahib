 <!-- Latest Topics End -->
 <div class="footer-section section">
  <div class="container">
    <!-- Footer Top Widgets Start -->
    <div class="row">
      <!-- Footer Widget Start -->
      <div class="col-xl-6 col-md-5 col-12 max-mb-50">
        <div class="footer-widget">
          <h4 class="footer-widget-title">منصة {{$settings['website_name']}}</h4>
          <div class="footer-widget-content">
            <div class="content">
              <p>
                {{$settings['website_bio']}}
              </p>
            </div>
            <div class="footer-social-inline">
             
              @if($settings['twitter_link']!=null)
              <a href="{{$settings['twitter_link']}}"><i class="fab fa-twitter"></i></a>
              @endif
              @if($settings['facebook_link']!=null)
              <a href="{{$settings['facebook_link']}}"><i class="fab fa-facebook-f"></i></a>
              @endif
              @if($settings['instagram_link']!=null)
              <a href="{{$settings['instagram_link']}}"><i class="fab fa-instagram"></i></a>
              @endif
              @if($settings['youtube_link']!=null)
              <a href="{{$settings['youtube_link']}}"><i class="fab fa-youtube"></i></a>
              @endif
            </div>
          </div>
        </div>
      </div>
      <!-- Footer Widget End -->

      <!-- Footer Widget Start -->
      <div class="col-xl-3 col-md-4 col-sm-7 col-12 max-mb-50">
        <div class="footer-widget">
          <h4 class="footer-widget-title">روابط</h4>
          <div class="footer-widget-content">
            <ul class="column-2">
              {{-- <li><i class="fas fa-home"></i><a href="#">الرئيسية</a></li>
              <li><i class="fas fa-mobile-alt"></i><a href="#">تطبيقات</a></li>
              <li><i class="fas fa-gamepad"></i><a href="#">ألعاب</a></li>
              <li><i class="fas fa-globe"></i><a href="#">مواقع</a></li>
              <li><i class="fas fa-laptop"></i><a href="#">هارد وير</a></li>
              <li><i class="fas fa-film"></i><a href="#">افلام</a></li> --}}
              @php
              $footer_menu = \App\Models\Menu::where('location',"FOOTER")->with(['links'=>function($q){$q->orderBy('order','ASC');}])->first();
              @endphp

              @if($footer_menu !=null)
                @foreach($footer_menu->links as $link)
                <li><i class="{{$link->icon}}"></i><a href="{{$link->url}}">{{$link->title}}</a></li>
                @endforeach
              @endif
            </ul>
          </div>
        </div>
      </div>
      <!-- Footer Widget End -->

      <!-- Footer Widget Start -->
      {{-- <div class="col-xl-3 col-md-3 col-sm-5 col-12 max-mb-50">
        <div class="footer-widget">
          <h4 class="footer-widget-title">مواقع مفيدة</h4>
          <div class="footer-widget-content">
            <ul>
              <li><a href="https://followers-store.com">متجر المتابعين</a></li>
              <li><a href="https://alsaraha.com">موقع الصراحة</a></li>
              <li><a href="https://gamezfactory.com">مصنع الألعاب</a></li>
              <li><a href="https://mobilawy.com">موبايلاوي</a></li>
            </ul>
          </div>
        </div>
      </div> --}}
      <!-- Footer Widget End -->
    </div>
    <!-- Footer Top Widgets End -->

    <!-- Footer Copyright Start -->
    <div class="row max-mt-20">
      <div class="col">
        <p class="copyright">
          &copy; {{$settings['website_name']}} {{date('Y')}}.
          <a href="{{url('page/privacy')}}">جميع الحقوق محفوظة ©</a>
        </p>
      </div>
    </div>
    <!-- Footer Copyright End -->
  </div>
</div>

<!-- Scroll Top Start -->
<a href="#" class="scroll-top" id="scroll-top">
  <i class="arrow-top fas fa-arrow-up"></i>
  <i class="arrow-bottom fas fa-arrow-up"></i>
</a>
<!-- Scroll Top End -->