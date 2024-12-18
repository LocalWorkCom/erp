@extends('website.layouts.master')

@section('content')
<section class="location-pop-up">
    <div id="modal" class="modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header border-0">
            <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <h2>السماح للموقع بتحديد موقعك؟</h2>
          </div>
          <div class="modal-footer d-flex flex-column border-0">
            <button type="button" class="btn" data-bs-dismiss="modal">سماح</button>
            <button type="button" class="btn reversed main-color">حدد على الخريطة </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="intro">
    <div class="container py-sm-5 py-4">
      <div class=" py-5 owl-slider owl-carousel owl-theme">
          @foreach($sliders as $slider)
              <div class="item">
                  <div class="row m-0 justify-content-center align-items-center">
                      <div class="col-md-6">
                          <h1 class="slide-title">{{$slider->name_ar}}</h1>
                          <p class="slide-text my-5 ">
                              {{$slider->description_ar}}
                          </p>
                          <a href="#" class="btn">اطلب الان</a>
                      </div>
                      <div class="col-md-6">
                          <figure class="intro-img">
                              <img src="{{ asset($slider->image) }}" alt="">
                          </figure>
                      </div>
                  </div>
              </div>
          @endforeach
{{--        <div class="item">--}}
{{--          <div class="row m-0 justify-content-center align-items-center">--}}
{{--            <div class="col-md-6">--}}
{{--              <h1 class="slide-title">استمتع بتجربة رائعة لدينا</h1>--}}
{{--              <p class="slide-text my-5 ">--}}
{{--                يمكنك طلب افضل انواع المأكولات واشهر الاطباق من خلال موقعنا واستمتع بتجربة مميزه لك--}}
{{--              </p>--}}
{{--              <a href="#" class="btn">اطلب الان</a>--}}
{{--            </div>--}}
{{--            <div class="col-md-6">--}}
{{--              <figure class="intro-img">--}}
{{--                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/intro-plate.png') }}" alt="">--}}
{{--              </figure>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
      </div>
    </div>
    <!-- <div class="intro-curve"></div>
    <div class="container">
      <div class="overflow-plates d-flex justify-content-between">

        <img src="SiteAssets/images/overflow-left.png" class="img-fluid" />
        <img src="SiteAssets/images/overflow-plate.png"class="img-fluid" />
        <img src="SiteAssets/images/overflow-right.png"class="img-fluid" />
      </div> -->
{{--    </div>--}}
      <div class="container overflow-plates ">
          <div class="d-flex justify-content-between">

              <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/overflow-left.png') }}" class="small-img right" data-aos="zoom-in" />
              <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/overflow-plate.png') }}" class="big-img" data-aos="zoom-in" />
              <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/overflow-right.png') }}" class="small-img left" data-aos="zoom-in" />
          </div>
      </div>
  </section>
  <section class="categories pt-5">
    <div class="container px-0 py-sm-5 py-4">
      <div class="section-titles d-flex justify-content-between" data-aos="fade-down">
        <h2 class="fw-bold">استكشف القائمة</h2>
        <div class="section-btn">
          <span class="ms-2">عرض الكل</span>
          <span class="icon">
            <i class="fas fa-arrow-left"></i>
          </span>
        </div>
      </div>
      <div class="categories-slider owl-carousel owl-theme">
        <div class="item mb-4 category position-relative" data-aos="zoom-in">
          <a href="#">
            <figure class="category-img m-0">
              <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/plate1.png') }}" alt="">
              <figcaption class="pt-4">
                <h5>اطباق رئيسية</h5>
              </figcaption>
            </figure>
          </a>
        </div>
        <div class="item mb-4 category position-relative" data-aos="zoom-in">
          <a href="#">
            <figure class="category-img m-0">
              <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/plate2.png') }}" alt="">
              <figcaption class="pt-4">
                <h5>اطباق جانبية</h5>
              </figcaption>
            </figure>
          </a>
        </div>
        <div class="item mb-4 category position-relative" data-aos="zoom-in">
          <a href="#">
            <figure class="category-img m-0">
              <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/plate3.png') }}" alt="">
              <figcaption class="pt-4">
                <h5> مقبلات</h5>
              </figcaption>
            </figure>
          </a>
        </div>
        <div class="item mb-4 category position-relative" data-aos="zoom-in">
          <a href="#">
            <figure class="category-img m-0">
              <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/plate4.png') }}" alt="">
              <figcaption class="pt-4">
                <h5> اطباق سلطات</h5>
              </figcaption>
            </figure>
          </a>
        </div>
        <div class="item mb-4 category position-relative" data-aos="zoom-in">
          <a href="#">
            <figure class="category-img m-0">
              <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/plate5.png') }}" alt="">
              <figcaption class="pt-4">
                <h5> مشروبات</h5>
              </figcaption>
            </figure>
          </a>
        </div>
        <div class="item mb-4 category position-relative" data-aos="zoom-in">
          <a href="#">
            <figure class="category-img m-0">
              <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/plate1.png') }}" alt="">
              <figcaption class="pt-4">
                <h5>اطباق رئيسية</h5>
              </figcaption>
            </figure>
          </a>
        </div>
      </div>
  </section>
  <section class="offers">
    <div class="container py-sm-5 py-4">
      <div class="row mx-0">
          @foreach($discounts as $discount)
              <div class="col-md-4">
                  <div class="item one row mx-0 p-4" data-aos="zoom-in">
                      <div class="col-md-5">
                          <img class="offer-img" src="{{ asset($discount->dish->image) }}" alt="">
                      </div>
                      <div class="col-md-7">
                          <h2 class="main-color fw-bold ">  خصم {{$discount->discount->type == 'percentage'?'%':'جنيه' }}{{ (int) $discount->discount->value }}</h2>
                          <h5 class="text-white pb-4">{{$discount->dish->name_ar}}</h5>
                          <a href="#" class="btn white">
                              <h4 class="fw-bold">اطلب الان</h4>
                          </a>
                      </div>

                  </div>
              </div>
          @endforeach
{{--        <div class="col-md-4">--}}
{{--          <div class="item two row mx-0 p-4" data-aos="zoom-in">--}}
{{--            <div class="col-md-5">--}}
{{--              <img class="offer-img" src="{{ asset('front/AlKout-Resturant/SiteAssets/images/offer-2.png') }}" alt="">--}}
{{--            </div>--}}
{{--            <div class="col-md-7">--}}
{{--              <h2 class="text-white fw-bold"> خصم 30%</h2>--}}
{{--              <h5 class="text-white pb-4"> زبيق مقلي</h5>--}}
{{--              <a href="#" class="btn white">--}}
{{--                <h4 class="fw-bold">اطلب الان</h4>--}}
{{--              </a>--}}
{{--            </div>--}}

{{--          </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-4">--}}
{{--          <div class="item three row mx-0 p-4" data-aos="zoom-in">--}}
{{--            <div class="col-md-5">--}}
{{--              <img class="offer-img" src="{{ asset('front/AlKout-Resturant/SiteAssets/images/offer-3.png') }}" alt="">--}}
{{--            </div>--}}
{{--            <div class="col-md-7">--}}
{{--              <h2 class="main-color fw-bold "> خصم 25%</h2>--}}
{{--              <h5 class="pb-4"> وجبه كفته كبير</h5>--}}
{{--              <a href="#" class="btn ">--}}
{{--                <h4 class="fw-bold">اطلب الان</h4>--}}
{{--              </a>--}}
{{--            </div>--}}

{{--          </div>--}}
{{--        </div>--}}
      </div>

  </section>

  <section class="plates">
    <div class="container py-sm-5 py-4">
      <h2 class="fw-bold" data-aos="fade-down"> اشهر اطباقنا</h2>
      <p class="text-muted pt-4" data-aos="fade-down">
        وجبات متنوعه من المأكولات الكويتية يمكنك الطلب منها بكل سهولة
      </p>
      <div class="plates-slider owl-carousel owl-theme">
        <div class="item mb-4" data-aos="zoom-in">
          <div class="plate">
            <a href="#">
              <figure class="plate-img m-0">
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/plate1.png') }}" alt="">
              </figure>
            </a>
            <div class="fav">
              <a href=""><i class="far fa-heart"></i></a>
            </div>
            <div class="text-center pt-4">
              <h5>كبسة فراخ </h5>
              <span class="badge bg-warning text-dark">
                <i class="fas fa-star"></i>
                الاعلى تقييم
              </span>

              <div class="d-flex justify-content-between pt-4">
                <button class="btn">
                  + أضف الي العربة</button>
                <span> 300 ج . م</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="info">
    <div class="container py-sm-5 py-4">
      <div class="row m-0 justify-content-cennter align-items-center">
        <div class="col-md-5 offset-md-1" data-aos="fade-left">
          <h1 class="fw-bold">يمكنك الطلب اونلاين الان بكل سهولة</h1>
          <p class="text-muted my-5 ">
            في خلال بضعة دقائق ستتمكن من عمل طلبك وتتبعه من خلال موقعنا
          </p>
          <a href="#" class="btn btn-lg">اطلب الان</a>
        </div>
        <div class="col-md-6" data-aos="fade-right">
          <figure class="info-img">
            <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/info.png') }}" alt="">
          </figure>
        </div>
      </div>
    </div>

  </section>
  <section class="apps">
    <div class="container pt-sm-5 pt-4">
      <div class="row m-0 justify-content-cennter align-items-center text-center">
        <div class="col-md-6" data-aos="fade-left">
          <h3 class="mb-5"> يمكنك تحميل تطبيقنا الان بكل سهوله من خلال </h3>

          <a href="#" class="app-store-btn">
            <div>
              <small>Download on the</small>
              <h5>App Store</h5>
            </div>
            <i class="fab fa-apple"></i>
          </a>
          <a href="#" class="google-play-btn">
            <div>
              <small>Get it on</small>
              <h5>Google Play</h5>
            </div>
            <i class="fab fa-google-play"></i>
          </a>
        </div>
        <div class="col-md-6" data-aos="fade-right">
          <img class="apps-img" src="{{ asset('front/AlKout-Resturant/SiteAssets/images/apps-img.png') }}" />
        </div>
      </div>
    </div>
  </section>
@endsection
