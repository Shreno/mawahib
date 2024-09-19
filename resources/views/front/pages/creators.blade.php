@extends('layouts.app',['page_title'=>"صناع المحتوى"])
@section('content')

      <!-- Page Title Section Start -->
      <div class="page-title-section section">
        <div class="page-title">
          <div class="container">
            <h1 class="title">صناع المحتوى</h1>
          </div>
        </div>
        <div class="page-breadcrumb">
          <div class="container">
            <ul class="breadcrumb">
              <li><a href="{{url('/')}}">الرئيسية</a></li>
              <li class="current">صناع المحتوى</li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Page Title Section End -->

      <!-- Shop Product Section Start -->
      <div class="section section-padding-bottom">
        <div class="container">
          <div class="row max-mb-n50">
            <div class="col-12 mx-auto max-mb-50">
              <!-- Product Wrapper Start -->
              <div
                class="row row-cols-xl-4 row-cols-lg-3 row-cols-sm-2 row-cols-1 max-mb-n40"
                >
                @foreach($creators as $creator)
                <!-- Card Start -->
                <div class="col mb-xs-0 max-mb-40" data-aos="fade-up">
                  <div class="card-box">
                    <div class="thumb mx-auto position-relative rounded-circle">
                      <a href="{{route('creators.show',$creator->id)}}" class="image">
                      <img style="width: 90px!important;height:90px" class="rounded-circle mx-auto" src="{{$creator->getUserAvatar() ? asset('storage/' . $creator->getUserAvatar()) : asset('storage/'.$settings['get_website_logo']) }}" alt="">
                      <span class="online"></span>
                      </a>
                    </div>
                      <div class="info">
                        <div class="name">
                          <a href="{{route('creators.show',$creator->id)}}">{{$creator->name}}<i class="fas fa-check-circle"></i> </a>
                        </div>
                        <div class="icons">
                          <span class="topics"><i class="fas fa-paper-plane"></i><span class="number">{{count($creator->articles_creator)}}</span>مواضيع </span>
                          {{-- <span class="country"><i class="fas fa-map-marker-alt"></i> مصر</span> --}}
                        </div>
                        <hr>
                        <div class="btn-100">
                          <a href="{{route('creators.show',$creator->id)}}" class="btn-width-100 btn-lg">الملف الشخصى<i class="fas fa-arrow-left-long"></i></a>
                        </div>
                      </div>
                      @if($creator->facebook_link!=null)
                    <div class="actions">
                      <a
                        href="{{$creator->facebook_link}}"
                        data-toggle="modal"
                        class="action hintT-right hintT-primary"
                        data-hint="Facebook"
                        ><i class="fab fa-facebook"></i
                      ></a>
                      @endif
                      {{-- <a
                        href="{{$creator->platform_link}}"
                        class="action hintT-right hintT-primary"
                        data-hint="Instagram"
                        ><i class="fab fa-instagram"></i
                      ></a> --}}
                      @if($creator->youtube_link!=null)
                      <a
                        href="{{$creator->youtube_link}}"
                        class="action hintT-right hintT-primary"
                        data-hint="Youtube"
                        ><i class="fab fa-youtube"></i
                      ></a>
                      @endif
                      @if($creator->tiktok_link!=null)
                      <a
                        href="{{$creator->tiktok_link}}"
                        class="action hintT-right hintT-primary"
                        data-hint="Tiktok"
                        ><i class="fab fa-tiktok"></i
                      ></a>
                      @endif
                      {{-- <a
                        href="JavaScript:Void(0);"
                        class="action hintT-right hintT-primary"
                        data-hint="Whatsapp"
                        ><i class="fab fa-whatsapp"></i
                      ></a> --}}
                      {{-- <a
                        href="JavaScript:Void(0);"
                        class="action hintT-right hintT-primary"
                        data-hint="Telegram"
                        ><i class="fab fa-telegram"></i
                      ></a> --}}
                      {{-- <a
                        href="JavaScript:Void(0);"
                        class="action hintT-right hintT-primary"
                        data-hint="X"
                        ><i class="fab fa-twitter"></i
                      ></a> --}}
                      {{-- <a
                        href="JavaScript:Void(0);"
                        class="action hintT-right hintT-primary"
                        data-hint="Linkedin"
                        ><i class="fab fa-linkedin"></i
                      ></a> --}}
                      {{-- <a
                        href="JavaScript:Void(0);"
                        class="action hintT-right hintT-primary"
                        data-hint="Site"
                        ><i class="fas fa-globe"></i
                      ></a> --}}
                    </div>
                  </div>
                </div>
                <!-- Card End -->
                @endforeach
             
        
               
           
         
             
              </div>
              <!-- Product Wrapper End -->

              <!-- Pagination Start -->
              {{ $creators->links('vendor.pagination.custom') }}

              <!-- Pagination End -->
            </div>
          </div>
        </div>
      </div>
     @endsection