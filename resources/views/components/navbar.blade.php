    <!-- Header Section Start -->
    <div class="header-section sticky-header section">
        <div class="header-inner">
            <div class="container position-relative">
                <div class="row justify-content-between align-items-center">
                    <!-- Header Logo Start -->
                    <div class="col-xl-3 col-auto">
                        <div class="header-logo">
                            <a href="{{url('/')}}">
                                <img class="dark-logo" src="{{asset('storage/'.$settings['get_website_logo'])}}" alt="Logo" />
                                <img class="light-logo" src="{{asset('storage/'.$settings['get_website_logo'])}}" alt="Logo" />
                            </a>
                        </div>
                    </div>
                    <!-- Header Logo End -->

                    <!-- Header Main Menu Start -->
                    <div class="col d-none d-xl-block position-static">
                        <nav class="site-main-menu menu-hover-1">
                            <ul>
                                @php
                                $menu = \App\Models\Menu::where('location',"NAVBAR")->with(['links'=>function($q){$q->orderBy('order','ASC');}])->first();
                                @endphp
                                @if($menu !=null)
                                @foreach($menu->links as $link)
                                <li class="position-static  {{ Request::url() == $link->url ? 'current' : '' }}" >
                                    <a href="{{$link->url}}">
                                        <span class="menu-text"></span> {{$link->title}}
                                    </a>
                                </م>
                                @endforeach
                                @endif
                               
                            </ul>
                        </nav>
                    </div>
                    <!-- Header Main Menu End -->

                    <!-- Header Right Start -->
                    <div class="col-xl-3 col-auto">
                        <div class="header-right">
                            <div class="inner">
                                <!-- Header Cart Start -->
                                <!-- Header Login Start -->
                                <div class="header-login">
                                    {{-- <a href="{{route('login')}}"><i class="far fa-user-circle"></i></a> --}}
                                    {{--  --}}
                                    @guest
                                    <a href="{{route('login')}}">
                                        <i class="far fa-user-circle"></i>
                                    </a>
                                    @else
                                    @if(auth()->user()->user_type=='admin')
                                    <a href="{{url('admin')}}">
                                        <i class="far fa-user-circle"></i>
                                    </a>
                                    @elseif(auth()->user()->user_type=='creator')
                                    <a href="{{url('dashboard')}}">
                                        <i class="far fa-user-circle"></i>
                                    </a>
                                    @endif
                
                
                                    @if(auth()->check())
                                        @php
                                        if(session('seen_notifications')==null)
                                            session(['seen_notifications'=>0]);
                                        $notifications=auth()->user()->notifications()->orderBy('created_at','DESC')->limit(50)->get();
                                        $unreadNotifications=auth()->user()->unreadNotifications()->count();
                                        @endphp
                                    @endif
                                    {{-- <div class="btn-group" id="notificationDropdown">
                
                                        <div class="col-12 px-0 d-flex justify-content-center align-items-center " style="width: 55px;height: 55px;cursor: pointer" data-bs-toggle="dropdown" aria-expanded="false" id="dropdown-notifications">
                                            <span class="fal fa-bell font-3 d-inline-block" style="color: var(--color-2);transform: rotate(15deg);"></span>
                                            <span style="position: absolute;min-width: 25px;min-height: 25px;
                                            @if($unreadNotifications!=0)
                                            display: inline-block;
                                            @else
                                            display: none;
                                            @endif
                                            right: 0px;top: 0px;border-radius: 20px;background: #c00;color:#fff;font-size: 14px;" class="text-center" id="dropdown-notifications-icon">{{$unreadNotifications}}</span>
                
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end py-0 rounded-0 border-0 shadow " style="cursor: auto!important;z-index: 20000;width: 350px;height: 450px;">
                                            <div class="col-12 notifications-container" style="height:406px;overflow: auto;">
                                                <x-notifications :notifications="$notifications" />
                                            </div>
                                            <div class="col-12 d-flex border-top" style="border-color: rgb(46 46 46 / 9%)!important;"> 
                                                <a href="{{route('user.notifications')}}" class="d-block py-2 px-3 ">
                                                    <div class="col-12 align-items-center">
                                                      <span class="fal fa-bells"></span>  عرض كل الإشعارات
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 px-0 d-flex justify-content-center align-items-center  dropdown"  style="width: 55px;height: 55px;" >
                                        <div style="width: 55px;height: 55px;cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false" class="d-flex justify-content-center align-items-center cursor-pointer">
                                            <img src="{{auth()->user()->getUserAvatar()}}" style="padding: 10px;border-radius: 50%;width: 55px;height: 55px;" alt="{{auth()->user()->name}}">
                                        </div>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2" aria-labelledby="dropdownMenuButton1" style="top: -3px;">
                                                <li><a class="dropdown-item font-1" href="{{route('user.dashboard')}}" ><span class="fal fa-sliders-h font-1" style="width: 20px;"></span> لوحة التحكم</a></li>
                                                <li><a class="dropdown-item font-1" href="{{route('user.support')}}"><span class="fal fa-comments-alt font-1" style="width: 20px;"></span> الدعم الفني</a></li>
                
                                        
                
                                                <li><a class="dropdown-item font-1" href="{{route('user.profile.edit')}}"><span class="fal fa-wrench font-1" style="width: 20px;"></span> الاعدادات</a></li>
                
                                                <li><a class="dropdown-item font-1" href="{{route('user.notifications')}}"><span class="fal fa-bells font-1" style="width: 20px;"></span> الاشعارات</a></li> 
                                           
                                                <li><hr style="height: 1px;margin: 10px 0px 5px;"></li>
                                                <li><a class="dropdown-item font-1"  onclick="document.getElementById('logout-form').submit();" style="cursor:pointer;"><span class="fal fa-sign-out-alt font-1" style="width: 20px;"></span> تسجيل خروج</a></li>
                                        </ul>
                
                                    </div> --}}
                                    @endguest



                                    {{--  --}}
                                </div>
                                <!-- Header Login End -->
                                <div class="header-cart">
                                    <div class="mini-cart-buttons">
                                        <a href="{{route('join.form')}}" class="btn btn-primary btn-hover-secondary">انضم الآن</a>
                                    </div>
                                </div>
                                <!-- Header Cart End -->
                                <!-- Header Mobile Menu Toggle Start -->
                                <div class="header-mobile-menu-toggle d-xl-none ml-sm-2">
                                    <button class="toggle">
                                        <i class="icon-top"></i>
                                        <i class="icon-middle"></i>
                                        <i class="icon-bottom"></i>
                                    </button>
                                </div>
                                <!-- Header Mobile Menu Toggle End -->
                            </div>
                        </div>
                    </div>
                    <!-- Header Right End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Header Section End -->


    <div id="site-main-mobile-menu" class="site-main-mobile-menu">
        <div class="site-main-mobile-menu-inner">
          <div class="mobile-menu-header">
            <div class="mobile-menu-logo">
              <a href="{{url('/')}}"
                ><img src="{{asset('storage/'.$settings['get_website_logo'])}}" alt=""
              /></a>
            </div>
            <div class="mobile-menu-close">
              <button class="toggle">
                <i class="icon-top"></i>
                <i class="icon-bottom"></i>
              </button>
            </div>
          </div>
          <div class="mobile-menu-content">
            <nav class="site-mobile-menu">
              <ul>
               
                 @if($menu !=null)
                                @foreach($menu->links as $link)
                                <li class="position-static  {{ Request::url() == $link->url ? 'current' : '' }}" >
                                    <a href="{{$link->url}}">
                                        <span class="menu-text"></span> {{$link->title}}
                                    </a>
                                </م>
                                @endforeach
                                @endif
              </ul>
            </nav>
          </div>
        </div>
      </div>
