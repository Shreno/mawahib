<div class="flat-alpum section">
  <div class="container">
      <div class="row">
          <div class="col-lg-12">
              <div class="section-title text-center" data-aos="fade-up">
                  <h2 class="title">نفتخر بأعضائنا</h2>
                  <h4>نرحب بك كعضو جديد في مجتمعنا، وسنسعد بانضمامك إلينا</h4>
              </div>

              <!-- Fetching users dynamically from the database -->
              @php
                  $users = \App\Models\User::where('user_type', 'creator')->orderBy('id', 'DESC')->get();
                  $defaultLogo =  '/front/assets/images/logo/WhatsApp_Image_2024-09-10_at_22.20.30_373f182c_76x52.jpg';

              @endphp

              <!-- Swiper Container -->
              <div class="swiper-container carousel-5">
                  <div class="swiper-wrapper">
                      @foreach($users as $i=>$user)
                          <div class="swiper-slide">
                              <div class="slogan-logo">
                                  <a href="{{ route('creators.show', $user->id) }}">
                                    <img src="{{ $user->getUserAvatar() ? asset('storage/' . $user->getUserAvatar()) : asset( $defaultLogo) }}" alt="{{ $user->name }}">
                                  </a>
                              </div>

                          </div>
                      @endforeach
                  </div>
              </div>

              <!-- Button to Show All Creators -->
              <div class="text-center mt-5 col-lg-7 mx-auto">
                  <a href="{{ route('creators') }}" class="btn btn-primary btn-hover-secondary">
                      شاهد الكل
                  </a>
              </div>
          </div>
      </div>
  </div>
</div>