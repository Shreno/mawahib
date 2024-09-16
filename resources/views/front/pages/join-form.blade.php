@extends('layouts.app', ['page_title' => 'أنضم إلينا'])
@section('content')
    <!-- Page Title Section Start -->
    <div class="page-title-section section section-padding-top-0" data-bg-color="#3F3A64">
        <div class="page-breadcrumb position-static">
            <div class="container">
                <ul class="breadcrumb light">
                    <li><a href="{{url('/')}}">الرئيسية</a></li>
                    <li class="current">كيفية الانضمام</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Title Section End -->

    <!-- CTA Section Start -->
    <div class="cta-section section" data-bg-color="#3F3A64">
        <div class="container animation-shape">
            <div class="row">
                <div class="col-12">
                    <div class="cta-content-area">
                        <!-- Section Title Start -->
                        <div class="section-title text-center mb-0" data-aos="fade-up">
                            <h2 class="title light max-mb-30">
                                استمارة الانضمام إلى منصة مواهب.
                            </h2>
                        </div>
                        <!-- Section Title End -->
                    </div>
                </div>
            </div>

            <!-- Animation Shape Start -->
            <div class="shape shape-1 scene">
                <span data-depth="4">shape 1</span>
            </div>
            <div class="shape shape-2 scene">
                <span data-depth="4"></span>
            </div>
            <div class="shape shape-3 scene">
                <span data-depth="4"></span>
            </div>
            <div class="shape shape-4 scene">
                <span data-depth="4"></span>
            </div>
            <div class="shape shape-5 scene">
                <span data-depth="4"></span>
            </div>
            <div class="shape shape-6 scene">
                <span data-depth="4"></span>
            </div>
            <!-- Animation Shape End -->
        </div>
    </div>
    <!-- CTA Section End -->

    <!-- Funfact Section Start -->
    <div class="funfact-section section section-padding-bottom-120" data-bg-color="#3F3A64">
    </div>
    <!-- Funfact Section End -->

    <!-- Hero Image Section Start -->
    <div class="hero-image-section section position-relative" data-bg-color="#f5f5f5">
        <div class="container">
            <!-- About Me Video Wrapper Start -->
            <div class="hero-image-wrapper" data-aos="fade-up">
                <img class="image" src="{{ asset('front/assets/images/hero-image/hero-image.png') }}" alt="" />
            </div>
            <!-- About Me Video Wrapper End -->
        </div>

        <!-- Section Bottom Shape Start -->
        <div class="section-bottom-shape d-md-block d-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none" height="100">
                <path class="elementor-shape-fill" d="M 0 0 L0 100 L100 100 L100 0 Q 50 200 0 0"></path>
            </svg>
        </div>
        <!-- Section Bottom Shape End -->
    </div>
    <!-- Hero Image Section End -->

    <!-- Gradation Process Section End -->
    <div class="gradation-process-section section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="ht-gradation style-01">
                        <!-- Single item gradation Start -->
                        <div class="item item-1" data-aos="fade-up">
                            <div class="line"></div>
                            <div class="circle-wrap">
                                <div class="mask">
                                    <div class="wave-pulse wave-pulse-1"></div>
                                    <div class="wave-pulse wave-pulse-2"></div>
                                    <div class="wave-pulse wave-pulse-3"></div>
                                </div>

                                <h6 class="circle">1</h6>
                            </div>

                            <div class="content-wrap">
                                <h5 class="heading">
                                    ما هي منصة مواهب ؟
                                </h5>
                                <div class="text">
                                    <p>منصة مواهب هي منصة تمكن مواهب المحتوى العرب من الاستفادة المادية من المحتوى المقدم من
                                        خلالهم على المنصة عبر عرض اعلانات على الموقع وعلى المقالات وبالتالي يمكن الاستفادة
                                        مادياً من المحتوى المقدم، عبر خدمة مشاركة الأرباح وهي خدمة مقدمة من المنصة، تقوم
                                        الفكرة الخاصة بمشاركة الأرباح عبر منصة مواهب بأن تقوم بوضع الرابط الخاص بالمقال
                                        الخاص بك على منصة مواهب في وصف الفيديو المقدم من خلالك على مواقع التواصل الاجتماعي
                                        أو تيك توك أو يوتيوب أو غيرها من المنصات التي تقدم محتوى من خلالها للجمهور الخاص بك،
                                    </p>
                                    <p>بمجرد وضع الرابط الخاص بالمقال في وصف الفيديو يمكن للزوار الضغط على الرابط وبالتالي
                                        الدخول إلى المقال وقراءته بشكل تفصيلي وبالتالي الحصول على مزيد من الأرباح مقابل ظهور
                                        الاعلانات على الموقع، يمكنك من خلال المنصة كتابة مقال مباشرةً من خلالك أو حتى يمكنك
                                        طلب كتابة مقال من فريق الكتابة، بعد تقديم الطلب الخاص بك إلى فريق الكتابة سيقوم أحد
                                        أعضاء الفريق بالبدء في كتابة المقال الذي قمت بطلبه وسوف يصلك اشعار بمجرد البدء في
                                        الكتابة وكذلك يصلك اشعار بمجرد الانتهاء من كتابة المقال الذي قمت بطلبه
                                    </p>
                                    <p>
                                        و الان بعد ان تعرفنا علي موقع مواهب و اصبحت تعرف وظيفه هذا الموقع الان سوف نتحدث عن
                                        الاقسام الخاصه بالموقع و التي تجعل الموقع اكثر تميزا عن باقي المواقع من نفس الفئة
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Single item gradation End -->

                        <!-- Single item gradation Start -->
                        <div class="item item-1" data-aos="fade-up">
                            <div class="line"></div>
                            <div class="circle-wrap">
                                <div class="mask">
                                    <div class="wave-pulse wave-pulse-1"></div>
                                    <div class="wave-pulse wave-pulse-2"></div>
                                    <div class="wave-pulse wave-pulse-3"></div>
                                </div>

                                <h6 class="circle">2</h6>
                            </div>

                            <div class="content-wrap">
                                <h5 class="heading">
                                    مزايا الانضمام
                                </h5>

                                <div class="text">
                                    <p>- بعد الانضمام والموافقة على حسابك تظهر لك احصائيات لحظية بجميع الأرباح التي قمت
                                        بتحقيقها على المنصة</p>
                                    <p class="highlighted">- يمكنك بكل بساطة سحب جميع الأرباح المتاحة في حسابك بدأً من <span
                                            class="highlight">1 دولار</span> فقط لا يوجد حد أدنى للسحب</p>
                                    <p class="mb-0">- يمكنك طلب كتابة مقال عن أي موضوع ستقوم بعمل فيديو عنه وسيتم كتابته
                                        من خلال فريق الكتابة وسيصلك اشعار</p>
                                    <p class="mr-10"> بمجرد الانتهاء منه ويمكنك مشاركة الرابط مع المتابعين الخاصين بك
                                        والبدء في تلقي الأرباح</p>
                                    <p>- دعم فني على مدار الساعة اذا احتجت أي مساعدة</p>
                                    <p>- نقوم باقتراح مواضيع رائعة بناءً على تحليلات جوجل لمساعدتك في انشاء فيديو خطاف</p>
                                    <p>بعد الدخول إلى لوحة التحكم الخاصة بك يظهر لك أرباحك بشكل لحظي طبقاً للمبلغ المكتسب من
                                        Google Adsense</p>
                                    <img src="{{ asset('front/assets/images/courses/1_63cdcf9a83c23_1674432410_515.webp') }}"
                                        alt="user-img">
                                </div>
                            </div>
                        </div>
                        <!-- Single item gradation End -->

                        <!-- Single item gradation Start -->
                        <div class="item item-1" data-aos="fade-up">
                            <div class="line"></div>
                            <div class="circle-wrap">
                                <div class="mask">
                                    <div class="wave-pulse wave-pulse-1"></div>
                                    <div class="wave-pulse wave-pulse-2"></div>
                                    <div class="wave-pulse wave-pulse-3"></div>
                                </div>

                                <h6 class="circle">3</h6>
                            </div>

                            <div class="content-wrap">
                                <h5 class="heading">
                                    كيف يمكن لصانع محتوي الاستفاده من مواهب؟
                                </h5>
                                <div class="text">
                                    <p>يمكن للعديد من مواهب المحتوي الاستفادة من منصبه مواهب من خلال جوجل ادسنس حيث يطلب
                                        صانع المحتوي مقال عن الشئ الذي يرغب فيه و يضع لينك المقال عنده و عندما يتم زياره
                                        المقال من خلال هذا اللينك يتم احتساب نسبه الربح الي صانع المحتوي ولاكن هناك شروط
                                        للربح من خلال جوجل ادسنس ويجب ان يتم الحفاظ عليها حتي يتم احتساب الربح يمكنك ان تطلع
                                        علي شروط جوجل ادسنس من
                                        <a class="text-link" target="_blank"
                                            href="https://support.google.com/adsense/answer/48182?hl=ar">هنا</a>
                                    </p>
                                    <p>و يتم عمليه طلب المقال بسهوله حيث يكون هناك حساب خاص بصانع المحتوي و يمكنه بكل سهوله
                                        ان يطلب مقال عن اي شئ يرغب فيه و يشرح فيه الشئ الذي يريد كتابه المقال فيه و يضع جميع
                                        البيانات ثم يأخد الكاتب المقال و يبداء في كتابته كما يريد صانع المحتوي و بعد ان
                                        ينتهي يسلم المقال ثم تتم مراجعه المقال جيده للتاكد من عدم وجود اي اخطاء فيه ثم يتم
                                        تسليمه لصانع المحتوي الذي يمكنه ان يعدل عليه ما يرغب و بعدها يتم نشره في المنصه</p>
                                    <p>و هنا قد اصبحت تعرف ما هي منصه مواهب و كيفية للاستفاده منها اذا كنت صانع محتوي او
                                        كاتب او حتي قارئ المقالات.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Single item gradation End -->

                        <!-- Single item gradation Start -->
                        <div class="item item-1" data-aos="fade-up">
                            <div class="line"></div>
                            <div class="circle-wrap">
                                <div class="mask">
                                    <div class="wave-pulse wave-pulse-1"></div>
                                    <div class="wave-pulse wave-pulse-2"></div>
                                    <div class="wave-pulse wave-pulse-3"></div>
                                </div>

                                <h6 class="circle">4</h6>
                            </div>

                            <div class="content-wrap">
                                <h5 class="heading">
                                    كيف أنضم؟
                                </h5>

                                <div class="text">
                                    <p>يمكنك بكل بساطة تقديم طلب انضمام عبر الرابط التالي في حالة كان لديك 10000 متابع أو
                                        أكثر على أي منصة من منصات مواقع التواصل الاجتماعي فيسبوك - تيك توك - انستجرام -
                                        يوتيوب وغيرها</p>
                                    <p>في منصة مواهب نلتزم تماماً بكامل شروط
                                        <a class="text-link" target="_blank"
                                            href="https://support.google.com/adsense/answer/48182?hl=ar">Google Adsense</a>
                                        يمكنك الاطلاع عليها جيداً
                                    </p>
                                    <p>
                                        وللإنضمام قم بملئ النموذج التالي
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Single item gradation End -->
                    </div>
                </div>
                <div class="col-xl-8 mx-auto">
                    <!-- Instructor Register From Start -->
                    <div class="instructor-register-from">
                        <h4 class="title">استمارة الانضمام</h4>
                        <form action="{{ route('join.submit') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12 mb-15">
                                    <input  type="text" placeholder="الاسم كامل *" name="name"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-12 mb-15">
                                    <input value="{{ old('phone') }}" type="text" placeholder="رقم الهاتف *" name="phone" required>
                                    @error('phone')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="col-md-6 col-12 mb-15">
                                    <input value="{{ old('email') }}" type="email" placeholder="الايميل *" name="email" required>
                                    @error('email')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="col-md-6 col-12 mb-15">
                                    <input value="{{ old('followers') }}" type="text" placeholder="عدد المتابعين الاجمالى فى كل المنصات *"
                                        name="followers" required>
                                        @error('followers')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-12 mb-15">
                                    <input value="{{ old('platform_link') }}" type="text" placeholder="رابط حسابك على أكبر منصة لديك متابعين بها *"
                                        name="platform_link">
                                        @error('platform_link')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-12 mb-15">
                                    <input type="text" value="{{ old('youtube_link') }}" placeholder="رابط حسابك على يوتيوب (اختيارى)" name="youtube_link">
                                    @error('youtube_link')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="col-md-6 col-12 mb-15">
                                    <input type="text"  value="{{ old('tiktok_link') }}" placeholder="رابط حسابك على تيك توك (اختيارى) "
                                        name="tiktok_link">
                                        @error('tiktok_link')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-12 mb-15">
                                    <input type="text" value="{{ old('facebook_link') }}" placeholder="رابط حسابك على فيسبوك (اختيارى) "
                                        name="facebook_link">
                                        @error('facebook_link')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12 mb-15">
                                    <textarea name="notes" placeholder="ملاحظات (اختيارى) ">{{ old('notes') }}</textarea>
                                    @error('notes')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-hover-secondary">
                                        طلب الانضمام
                                    </button>
                                </div>
                                <p class="pt-30 mb-0">* برجاء مراجعة كامل بياناتك قبل الارسال </p>
                                <p class="mr-5">كما أن طلب انضمامك يعني موافقتك على شروط استخدام <a class="text-link"
                                        href="{{url('/page/terms')}}">منصة {{$settings['website_name']}}.</a></p>
                            </div>
                        </form>
                    </div>
                    <!-- Instructor Register From End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Gradation Process Section End -->
@endsection
