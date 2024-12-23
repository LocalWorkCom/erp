<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session('direction', 'rtl') }}">

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:url" content="" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:image" content="" />
    <title>@lang('website/home.title')</title>

    <link rel="shortcut icon" href="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo.png') }}" sizes="25x25" />

    <!-- Stylesheets -->
    <link rel="stylesheet"
        href="{{ asset('front/AlKout-Resturant/SiteAssets/bootstrap-5.1.3/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('front/AlKout-Resturant/SiteAssets/fontawesome-free-5.15.4-web/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('front/AlKout-Resturant/SiteAssets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/AlKout-Resturant/SiteAssets/aos-master/dist/aos.css') }}">

    <!-- Owl Carousel -->
    <link rel="stylesheet"
        href="{{ asset('front/AlKout-Resturant/SiteAssets/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('front/AlKout-Resturant/SiteAssets/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css') }}" />

    <!-- include Gallery (lightbox) plugin -->
    <link rel="stylesheet" href="{{ asset('front/AlKout-Resturant/SiteAssets/lightbox/css/lightbox.min.css') }}" />
    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('front/AlKout-Resturant/SiteAssets/css/style.css') }}" type="text/css" />
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
</head>

<body>

    @include('website.layouts.header')

    <main>
        @yield('content')
    </main>
    <!-- modals -->
    @include('website.layouts.footer')

    <!-- login modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn btn-close text-light" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                @include('website.auth.login')
                @include('website.auth.register')
                @include('website.auth.forgetpass')
            </div>
        </div>
    </div>
    <!-- end login modal -->
    @include('website.delivery')
    @include('website.location')

    <script src="{{ asset('front/AlKout-Resturant/SiteAssets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('front/AlKout-Resturant/SiteAssets/bootstrap-5.1.3/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/AlKout-Resturant/SiteAssets/fontawesome-free-5.15.4-web/js/all.min.js') }}"></script>

    <!-- Main js -->
    <script src="{{ asset('front/AlKout-Resturant/SiteAssets/js/style.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <!-- include Gallery (lightbox) plugin js-->
    <script src="{{ asset('front/AlKout-Resturant/SiteAssets/lightbox/js/lightbox.min.js') }}"></script>

    <!-- include Owl Carousel plugin js-->
    <script src="{{ asset('front/AlKout-Resturant/SiteAssets/OwlCarousel2-2.3.4/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('front/AlKout-Resturant/SiteAssets/aos-master/dist/aos.js') }}"></script>
    <script>
        AOS.init();
    </script>
    <!--
  <script>
      $('.owl-slider').owlCarousel({
          items: 1,
          loop: true,
          dots: true,
          nav: true,
          autoplay: true,
          smartSpeed: 450,
          rtl: true,
      });

      $('.categories-slider').owlCarousel({
          items: 5,
          loop: true,
          dots: true,
          nav: true,
          margin: 15,
          pagination: false,
          autoplay: false,
          autoplaySpeed: 1000,
          autoplayTimeout: 3000,
          rtl: true,
          responsive: {
              0: {
                  items: 1,
                  nav: true,
                  dots: false
              },

              600: {
                  items: 2,
                  nav: true
              },

              900: {
                  items: 3,
                  nav: true
              },

              1200: {
                  items: 5,
                  nav: true
              }
          }
      });
      $('.plates-slider').owlCarousel({
          items: 4,
          loop: false,
          dots: true,
          nav: true,
          margin: 15,
          pagination: false,
          autoplay: false,
          autoplaySpeed: 1000,
          autoplayTimeout: 3000,
          rtl: true,
          responsive: {
              0: {
                  items: 1,
                  nav: true,
                  dots: false
              },

              600: {
                  items: 2,
                  nav: true
              },

              900: {
                  items: 3,
                  nav: true
              },

              1200: {
                  items: 4,
                  nav: true
              }
          }
      });
      $(".owl-prev > span").html('<i class="fas fa-arrow-right"></i>');
      $(".owl-next > span").html('<i class="fas fa-arrow-left"></i>');
  </script> -->
    @stack('scripts')
</body>

</html>
