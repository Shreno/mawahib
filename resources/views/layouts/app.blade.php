<!DOCTYPE html>
<html class="no-js" dir="rtl" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>{{$settings['website_name']}}</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}">  

    @include('seo.index')
    
    

    {!!$settings['header_code']!!}
    @livewireStyles
    @if(auth()->check())
        @php
        if(session('seen_notifications')==null)
            session(['seen_notifications'=>0]);
        $notifications=auth()->user()->notifications()->orderBy('created_at','DESC')->limit(50)->get();
        $unreadNotifications=auth()->user()->unreadNotifications()->count();
        @endphp
    @endif
    {{-- @vite('resources/css/app.css') --}}
 <!-- Favicon -->
 <link
 rel="shortcut icon"
 type="image/x-icon"
 href="assets/images/favicon.png"
/>

<!-- CSS
============================================ -->

<!-- Vendor CSS (Bootstrap & Icon Font) -->
<link rel="stylesheet" href="{{asset('front/assets/css/vendor/bootstrap.min.css')}}" />
<link rel="stylesheet" href="{{asset('front/assets/css/vendor/font-awesome.min.css')}}" />

<!-- Plugins CSS (All Plugins Files) -->
<link rel="stylesheet" href="{{asset('front/assets/css/plugins/aos.min.css')}}" />
<link rel="stylesheet" href="{{asset('front/assets/css/plugins/animate.css')}}" />
<link
 rel="stylesheet"
 href="{{asset('front/assets/css/plugins/jquery.animatedheadline.css')}}"
/>
<link rel="stylesheet" href="{{asset('front/assets/css/plugins/justifiedGallery.min.css')}}" />
<link rel="stylesheet" href="{{asset('front/assets/css/plugins/swiper.min.css')}}" />
<link rel="stylesheet" href="{{asset('front/assets/css/plugins/nice-select.css')}}" />
<link rel="stylesheet" href="{{asset('front/assets/css/plugins/ion.rangeSlider.min.css')}}" />
<link rel="stylesheet" href="{{asset('front/assets/css/plugins/magnific-popup.css')}}" />

<!-- Main Style CSS -->
<link rel="stylesheet" href="{{asset('front/assets/css/style.css')}}" />   
    @yield('styles')
</head>
<body >
    
    @yield('after-body')
    <div id="app">

        {{-- <div class="page-loader"></div> --}}
        {{-- <div id="body-overlay"onclick="document.getElementById('aside-menu').classList.toggle('active');document.getElementById('body-overlay').classList.toggle('active');"></div> --}}
        <x-navbar />
        <main class="p-0 font-2">
            @yield('content')
        </main>
        <x-footer />
    </div>





    @vite('resources/js/app.js')
     <!-- Vendors JS -->
     <script src="{{asset('front/assets/js/vendor/modernizr-3.6.0.min.js')}}')}}"></script>
     <script src="{{asset('front/assets/js/vendor/jquery-3.6.0.min.js')}}"></script>
     <script src="{{asset('front/assets/js/vendor/jquery-migrate-3.3.2.min.js')}}"></script>
     <script src="{{asset('front/assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
 
     <!-- Plugins JS -->
     <script src="{{asset('front/assets/js/plugins/aos.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/countdown.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/jquery.ajaxchimp.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/ion.rangeSlider.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/imagesloaded.pkgd.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/isotope.pkgd.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/parallax.min.js')}}"></script>
     <script src="{{asset('front//js/plugins/Jarallax.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/masonry.pkgd.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/jquery.justifiedGallery.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/rellax.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/waypoints.min.js')}}')}}"></script>
     <script src="{{asset('front/assets/js/plugins/jquery.ajaxchimp.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/jquery.animatedheadline.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/jquery.counterup.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/jquery.magnific-popup.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/jquery.selectric.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/sticky-sidebar.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/svg-inject.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/swiper.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/vivus.min.js')}}"></script>
 
     <!-- Use the minified version files listed below for better performance and remove the files listed above -->
     <!-- <script src="assets/js/vendor/vendor.min.js')}}"></script>
     <script src="{{asset('front/assets/js/plugins/plugins.min.js')}}"></script> -->
 
     <!-- Main Activation JS -->
     <script src="{{asset('front/assets/js/main.js')}}"></script>
    @livewireScripts
    @include('layouts.scripts')
    @auth
    <script type="module">
        var favicon = new Favico({bgColor: '#dc0000',textColor: '#fff',animation: 'slide',fontStyle: 'bold',fontFamily: 'sans',type: 'circle'});
        function get_website_title(){
            return $('meta[name="title"]').attr('content');
        }
        var notificationDropdown = document.getElementById('notificationDropdown')
        notificationDropdown.addEventListener('show.bs.dropdown', function() {
            $.ajax({
                method: "POST",
                url: "{{route('admin.notifications.see')}}",
                data: { _token: "{{csrf_token()}}" }
            }).done(function(res) {
                $('#dropdown-notifications-icon').fadeOut();
                favicon.badge(0);
            });
        });
        function append_notification_notifications(msg) {
            if (msg.count_unseen_notifications > 0) {
                $('#dropdown-notifications-icon').fadeIn(0);
                $('#dropdown-notifications-icon').text(msg.count_unseen_notifications);
            } else {
                $('#dropdown-notifications-icon').fadeOut(0);
                favicon.badge(0);
            }
            $('.notifications-container').empty();
            $('.notifications-container').append(msg.response);
            $('.notifications-container a').on('click', function() { window.location.href = $(this).attr('href'); });
        } 
        function get_notifications() {
            $.ajax({
                method: "GET",
                url: "{{route('admin.notifications.ajax')}}", 
                success: function(data, textStatus, xhr) {

                    favicon.badge(data.notifications.response.count_unseen_notifications);

                    if (data.alert) {
                        var audio = new Audio('{{asset("/sounds/notification.wav")}}');
                        audio.play();
                    }  
                    append_notification_notifications(data.notifications.response); 
                    if (data.notifications.response.count_unseen_notifications > 0) {
                        $('title').text('(' + parseInt(data.notifications.response.count_unseen_notifications) + ')' + " " +  
                        get_website_title());

                    } else {
                        $('title').text(get_website_title());
                    }
                }
            });
        } 
        window.focused = 25000;
        window.onfocus = function() {
            get_notifications(); 
            window.focused = 25000;
        };
        window.onblur = function() {
            window.focused = 60000;
        }; 
        function get_nots() {
            setTimeout(function() { 
                get_notifications();
                get_nots();
            }, window.focused);
        }
        get_nots();

        @if($unreadNotifications!=session('seen_notifications') && $unreadNotifications!=0)
            @php
            session(['seen_notifications'=>$unreadNotifications]);
            @endphp
            var audio = new Audio('{{asset("/sounds/notification.wav")}}');
            audio.play();
        @endif
    </script>
    @endauth
    @yield('scripts')
    {!!$settings['footer_code']!!}
</body>
</html>
