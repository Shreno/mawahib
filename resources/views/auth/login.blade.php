@extends('layouts.app')
@section('content')


<div class="container p-0">
    <div class="col-12 p-0 row d-flex">
        <div class="col-12 col-lg-6 text-center p-0" style="">
            <div class="col-12 p-2 p-lg-4 align-items-center justify-content-center d-flex row" style="min-height:70vh">
                <div class="col-12 p-3 p-lg-4" style="background:#fff;border-radius: 10px;">
                    <form method="POST" action="{{ route('login') }}" class="row m-0">
                        @csrf
                       
                        <div class="col-12 p-0 mb-5 mt-3" style="width: 550px;max-width: 100%;margin: 0px auto;">
                            <h3 class="mb-4 font-4">{{ __('lang.login') }}</h3>
                             
                        </div>

                        

                        @if(env('GOOGLE_CLIENT_ID')!=null)
                        <div class="col-6 py-2 px-2">
                            <div class="col-12 p-0">
                                <a href="/login/google/redirect" style="border:2px solid #51c75b;color:inherit;box-shadow: 0px 6px 10px rgb(52 52 52 / 12%);" class="col-12 d-flex p-3 align-items-center justify-content-center btn">
                                 دخول عبر <img src="/images/icons/google.png" style="width:30px" class="mx-2" />
                                </a>
                            </div>
                        </div>
                        @endif
                        @if(env('FACEBOOK_CLIENT_ID')!=null)
                        <div class="col-6 py-2 px-2">
                            <div class="col-12 p-0">
                                <a href="/login/facebook/redirect" style="border:2px solid #3f71cd;color:inherit;box-shadow: 0px 6px 10px rgb(52 52 52 / 12%);background: #3f71cd;color:#fff" class="col-12 d-flex p-3 align-items-center justify-content-center btn">
                                 دخول عبر  <span class="fab fa-facebook-f mx-2" style="color:#fff"></span>
                                </a>
                            </div>
                        </div>
                        @endif
                        

                        <div class=" row" style="">
                     

                        <div class="form-group  mb-4 col-12 col-lg-6 px-0 pt-2 ">
                            <div class="col-md-12 px-2 pt-4" style="position: relative;">
                                <label for="email" class="col-form-label text-md-right mb-1 font-small px-2 py-1 d-inline" style="background:#f4f4f4;position: absolute;top: 17px;right: 20px; border-radius: 3px!important">البريد الالكتروني</label>
                                <input id="email" type="email" class="form-control mt-2 d-inline-block @error('email') is-invalid @enderror" name="email" value="" required="" autocomplete="off" autofocus="" style=";height: 42px;border-color: #eaedf1;border-radius: 3px!important" value="{{ old('email') }}">
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group  mb-4 col-12 col-lg-6   px-0 pt-2 ">
                            <div class="col-md-12 px-2 pt-4" style="position: relative;">
                                <label for="password" class="col-form-label text-md-right mb-1 font-small px-2 py-1 d-inline" style="background:#f4f4f4;position: absolute;top: 17px;right: 20px;border-radius: 3px!important">كلمة المرور</label>
                                <input id="password" type="password" class="form-control mt-2 d-inline-block @error('password') is-invalid @enderror" name="password" value="" required="" autocomplete="off" autofocus="" style=";height: 42px;border-color: #eaedf1;border-radius: 3px!important" minlength="6" aria-invalid="true">
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>






                        <div class="row">
                            <div class="mb-4 col-12 col-lg-6   px-0 pt-2">
                                <div class="form-group  ">
                                    <div class="col-12 p-0">
                                        <input class="form-check-input ms-2 me-0" type="checkbox" name="remember" id="remember" {{ old('remember')||old('remember')==null ? 'checked' : '' }} style="position:relative;height: 20px;width: 20px;cursor: pointer;">

                                        <label class="form-check-label" for="remember" style="position:relative;cursor: pointer;">
                                            {{ __('lang.remember_me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 col-12 col-lg-6   px-0 pt-2 ">
                                <div class="form-group  mb-0 ">
                                    <div class="col-12 p-0 d-flex justify-content-lg-end">
                                        <button type="submit" class="btn btn-success font-1">
                                            {{ __('lang.login') }}
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        

 
                        

                        <div class="col-12 px-4 py-2">
                            <div class="col-12 px-0 mb-2">
                            مساعدة
                            </div>
                            <ul style="list-style:none;" class="p-0 m-0">
                                @if (Route::has('join.form'))
                                <li class=" d-block"><a href="{{route('join.form')}}" class="naskh py-2 d-block" style="text-decoration: none!important;"><span class="fas fa-circle font-small" ></span> لا أملك حساب بعد</a></li>
                                @endif
                                @if (Route::has('password.request'))
                                <li class="d-block"><a href="{{ route('password.request') }}" class="naskh py-2 d-block" style="text-decoration: none!important;"><span class="fas fa-circle font-small" ></span> نسيت كلمة المرور</a></li>
                                @endif
                            </ul>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-none d-lg-flex text-center p-0 d-flex align-items-center justify-content-center row position-relative" style="">
            <div class="overlap-grid overlap-grid-2">
                <div class="item mx-auto">
                    <div class="shape bg-dot primary rellax w-16 h-20" data-rellax-speed="1" style="top: 3rem; left: 5.5rem"></div>
                    <div class="col-12 p-0 align-items-center py-5 justify-content-center d-flex svg-animation" style="background-image: url('{{$settings['get_website_logo']}}');background-size: cover;padding-top: 57%;background-position: center;height: 342px;z-index: 1;position: relative;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
