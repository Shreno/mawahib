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
                                {{-- <img class="light-logo" src="{{asset('storage/'.$settings['get_website_logo'])}}" alt="Logo" /> --}}
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
                                  
                                    @guest
                                    <div class="header-login">

                                    <a href="{{route('login')}}">
                                        <i class="far fa-user-circle"></i>
                                    </a>
                                    </div>
                                    @else
                                    <div class="header-login in">
                                        <a href="#"
                                          ><i class="far fa-user-circle"></i
                                        ></a>
                                      </div>
                                      <div class="header-login logged">
                                        <div class="avatars-box d-flex align-items-center">
                                            <div class="images flex-none">
                                                <img src="{{ Auth()->user()->getUserAvatar() ? asset('storage/' . Auth()->user()->getUserAvatar()) : asset('storage/'.$settings['get_website_logo']) }}" alt="">
                                            </div>
                                            <div class="title-avatar fw-6">
                                                <a href="#" id="toggle-menu">{{Auth()->user()->name}}<i class="fas fa-angle-down"></i></a>
                                            </div>
                                        </div>
                                        <div id="dropdown-menu" class="dropdown-menu">
                                            @if(Auth()->user()->user_type=='admin')
                                             <a href="{{route('admin.index')}}" class="dropdown-item">
                                                <i class="fas fa-desktop"></i> لوحة التحكم
                                            </a>
                                           
                                            <a onclick="document.getElementById('logout-form').submit();" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                                            </a>


                                            
                                            @elseif(Auth()->user()->user_type=='editor')
                                            <a href="{{route('editor.dashboard')}}" class="dropdown-item">
                                                <i class="fas fa-desktop"></i> لوحة التحكم
                                            </a>
                                             <a href="{{route('editor.profile.edit')}}" class="dropdown-item">
                                                <i class="fas fa-cog"></i> اعدادات الملف الشخصى
                                            </a>
                                           
                                            <a onclick="document.getElementById('logout-form').submit();" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                                            </a>

                                            @else
                                            <a href="{{route('user.dashboard')}}" class="dropdown-item">
                                                <i class="fas fa-desktop"></i> لوحة التحكم
                                            </a>
                                          
                                            <a href="{{route('user.profile.edit')}}" class="dropdown-item">
                                                <i class="fas fa-cog"></i> اعدادات الملف الشخصى
                                            </a>
                                            <a onclick="document.getElementById('logout-form').submit();" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                                            </a>


                                            @endif
                                           
                                        </div>
                                    </div>
                                    @endguest



                                    {{--  --}}
                                @guest
                                <!-- Header Login End -->
                                <div class="header-cart">
                                    <div class="mini-cart-buttons">
                                        <a href="{{route('join.form')}}" class="btn btn-primary btn-hover-secondary">انضم الآن</a>
                                    </div>
                                </div>
                                @endguest
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
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>