<!DOCTYPE html>
<html dir="rtl" lang="ar">

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
  <title>مطعم الكوت</title>

  <link rel="shortcut icon" href="SiteAssets/images/logo.png" sizes="25x25" />

  <!-- Stylesheets -->
  <link rel="stylesheet" href="SiteAssets/bootstrap-5.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="SiteAssets/fontawesome-free-5.15.4-web/css/all.min.css">
  <link rel="stylesheet" href="SiteAssets/css/animate.min.css">
  <link rel="stylesheet" href="SiteAssets/aos-master/dist/aos.css">

  <!-- Owl Carousel -->
  <link rel="stylesheet" href="SiteAssets/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css" />
  <link rel="stylesheet" href="SiteAssets/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css" />

  <!-- include Gallery (lightbox) plugin -->
  <link rel="stylesheet" href="SiteAssets/lightbox/css/lightbox.min.css" />
  <!-- Main Style -->
  <link rel="stylesheet" href="SiteAssets/css/style.css" type="text/css" />
  <!-- fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
</head>

<body>

  <header class="fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light ">
      <div class="container">
        <a class="navbar-service" href="index.html">
          <img src="SiteAssets/images/logo.png">
        </a>
        <button class="navbar-toggler" type="button" onclick="openNav()">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-center">
            <li class="nav-item">
              <a class="nav-link" href="#">
                <button class="btn white fw-bold d-flex justify-content-between">
                  <span><i class="fas fa-map-marker-alt ms-2"></i>
                    التوصيل الي
                  </span>
                  <span class="select-sm">
                    اختر
                  </span>
                </button>
              </a>
            </li>
            <li class="nav-item active" aria-current="page">
              <a class="nav-link" href="index.html">الرئيسية</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">قائمة الطعام</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">تواصل معنا</a>
            </li>

            <li class="nav-item">
              <a class="nav-link cart-icon" href="#">
                <i class="fas fa-shopping-cart"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                En
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn" href="#"> تسجيل الدخول </a>
            </li>


          </ul>
        </div>


      </div>
    </nav>
    <div class="mobNav d-lg-none d-block ">
      <div id="sidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="overlay-content">
          <a href="#"> الرئيسية</a>
          <a href="#">قائمة الطعام</a>
          <a href="#">تواصل معنا</a>
          <a href="#"> <i class="fas fa-shopping-cart"></i>
          </a>
          <a href="#"> En</a>
          <a href="#"> تسجيل الدخول </a>
        </div>
      </div>
    </div>

  </header>
  <main>
    <section class="location-pop-up">
          <div id="modal" class="modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header border-0">
            <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <h2>السماح للموقع  بتحديد موقعك؟</h2>
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
          <div class="item">
            <div class="row m-0 justify-content-center align-items-center">
              <div class="col-md-6">
                <h1 class="slide-title">استمتع بتجربة رائعة لدينا</h1>
                <p class="slide-text my-5 ">
                  يمكنك طلب افضل انواع المأكولات واشهر الاطباق من خلال موقعنا واستمتع بتجربة مميزه لك
                </p>
                <a href="#" class="btn">اطلب الان</a>
                <a href="#" class="c me-3"> استكشف القائمة</a>

              </div>
              <div class="col-md-6">
                <figure class="intro-img">
                  <img src="SiteAssets/images/intro-plate.png" alt="">
                </figure>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="row m-0 justify-content-center align-items-center">
              <div class="col-md-6">
                <h1 class="slide-title">استمتع بتجربة رائعة لدينا</h1>
                <p class="slide-text my-5 ">
                  يمكنك طلب افضل انواع المأكولات واشهر الاطباق من خلال موقعنا واستمتع بتجربة مميزه لك
                </p>
                <a href="#" class="btn">اطلب الان</a>
                <a href="#" class="btn reversed me-3"> استكشف القائمة</a>

              </div>
              <div class="col-md-6">
                <figure class="intro-img">
                  <img src="SiteAssets/images/intro-plate.png" alt="">
                </figure>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="intro-curve"></div>
      <div class="container">
        <div class="overflow-plates d-flex justify-content-between">
          
          <img src="SiteAssets/images/overflow-left.png" class="img-fluid" />
          <img src="SiteAssets/images/overflow-plate.png"class="img-fluid" />
          <img src="SiteAssets/images/overflow-right.png"class="img-fluid" />
        </div> -->
      </div>
    </section>
    <section class="categories">
      <div class="container py-sm-5 py-4">
        <div class="section-titles d-flex justify-content-between">
          <h3>استكشف القائمة</h3>
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
                <img src="SiteAssets/images/plate1.png" alt="">
                <figcaption class="pt-4">
                  <h5>اطباق رئيسية</h5>
                </figcaption>
              </figure>
            </a>
          </div>
          <div class="item mb-4 category position-relative" data-aos="zoom-in">
            <a href="#">
              <figure class="category-img m-0">
                <img src="SiteAssets/images/plate2.png" alt="">
                <figcaption class="pt-4">
                  <h5>اطباق جانبية</h5>
                </figcaption>
              </figure>
            </a>
          </div>
          <div class="item mb-4 category position-relative" data-aos="zoom-in">
            <a href="#">
              <figure class="category-img m-0">
                <img src="SiteAssets/images/plate3.png" alt="">
                <figcaption class="pt-4">
                  <h5> مقبلات</h5>
                </figcaption>
              </figure>
            </a>
          </div>
          <div class="item mb-4 category position-relative" data-aos="zoom-in">
            <a href="#">
              <figure class="category-img m-0">
                <img src="SiteAssets/images/plate4.png" alt="">
                <figcaption class="pt-4">
                  <h5> اطباق سلطات</h5>
                </figcaption>
              </figure>
            </a>
          </div>
          <div class="item mb-4 category position-relative" data-aos="zoom-in">
            <a href="#">
              <figure class="category-img m-0">
                <img src="SiteAssets/images/plate5.png" alt="">
                <figcaption class="pt-4">
                  <h5> مشروبات</h5>
                </figcaption>
              </figure>
            </a>
          </div>
          <div class="item mb-4 category position-relative" data-aos="zoom-in">
            <a href="#">
              <figure class="category-img m-0">
                <img src="SiteAssets/images/plate1.png" alt="">
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
          <div class="col-md-4">
            <div class="item one row mx-0 p-4" data-aos="zoom-in">
              <div class="col-md-5">
                <img class="offer-img" src="SiteAssets/images/plate1.png" alt="">
              </div>
              <div class="col-md-7">
                <h2 class="main-color fw-bold "> خصم 20%</h2>
                <h5 class="text-white pb-4">كبسة عربى بالفراخ</h5>
                <a href="#" class="btn white">
                  <h4 class="fw-bold">اطلب الان</h4>
                </a>
              </div>

            </div>
          </div>
          <div class="col-md-4">
            <div class="item two row mx-0 p-4" data-aos="zoom-in">
              <div class="col-md-5">
                <img class="offer-img" src="SiteAssets/images/offer-2.png" alt="">
              </div>
              <div class="col-md-7">
                <h2 class="text-white fw-bold"> خصم 30%</h2>
                <h5 class="text-white pb-4"> زبيق مقلي</h5>
                <a href="#" class="btn white">
                  <h4 class="fw-bold">اطلب الان</h4>
                </a>
              </div>

            </div>
          </div>
          <div class="col-md-4">
            <div class="item three row mx-0 p-4" data-aos="zoom-in">
              <div class="col-md-5">
                <img class="offer-img" src="SiteAssets/images/offer-3.png" alt="">
              </div>
              <div class="col-md-7">
                <h2 class="main-color fw-bold "> خصم 25%</h2>
                <h5 class="pb-4"> وجبه كفته كبير</h5>
                <a href="#" class="btn ">
                  <h4 class="fw-bold">اطلب الان</h4>
                </a>
              </div>

            </div>
          </div>
        </div>

    </section>

    <section class="plates">
      <div class="container py-sm-5 py-4">
        <h3> اشهر اطباقنا</h3>
        <p class="text-muted pt-4">
          وجبات متنوعه من المأكولات الكويتية يمكنك الطلب منها بكل سهولة
        </p>
        <div class="plates-slider owl-carousel owl-theme">
          <div class="item mb-4 plate position-relative" data-aos="zoom-in">
            <a href="#">
              <figure class="plate-img m-0">
                <img src="SiteAssets/images/plate1.png" alt="">
                <figcaption class="pt-4 text-center">
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
                </figcaption>
              </figure>
            </a>
          </div>


        </div>
      </div>
    </section>

    <section class="info">
      <div class="container py-sm-5 py-4">
        <div class="row m-0 justify-content-cennter align-items-center">
          <div class="col-md-5 offset-md-1 ">
            <h1 class="fw-bold">يمكنك الطلب اونلاين الان بكل سهولة</h1>
            <p class="text-muted my-5 ">
              في خلال بضعة دقائق ستتمكن من عمل طلبك وتتبعه من خلال موقعنا
            </p>
            <a href="#" class="btn btn-lg">اطلب الان</a>
          </div>
          <div class="col-md-6">
            <figure class="info-img">
              <img src="SiteAssets/images/info.png" alt="">
            </figure>
          </div>
        </div>
      </div>

    </section>
    <section class="apps">
      <div class="container py-sm-5 py-4">
        <div class="row m-0 justify-content-cennter align-items-center text-center">
          <div class="col-md-6">
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
          <div class="col-md-6">
            <img class="apps-img" src="SiteAssets/images/app-img1.png" />
          </div>
        </div>
      </div>
    </section>
    
  </main>
  <footer>
    <div class="footer-curve"></div>
    <div class="container ">
      <figure class="footer-logo">
        <img src="SiteAssets/images/logo-with-white-bg.png" />
      </figure>
    </div>
    <div class="footer">
      <div class="container py-sm-5 p-4">
        <div class=" row m-0">
          <div class="col-md-3">
            <h4 class="footer-title"> تواصل معنا </h4>
            <ul class="list-unstyled px-0 pt-4">
              <li><a href="#"> القائمة الرئيسية</a></li>
              <li><a href="#">العروض</a></li>
              <li><a href="#">فروعنا</a></li>
              <li><a href="#">الشروط والاحكام</a></li>
            </ul>
          </div>
          <div class="col-md-3">
            <h4 class="footer-title">روابط سريعة </h4>
            <ul class="list-unstyled px-0 pt-4">
              <li><a href="#"> القائمة الرئيسية</a></li>
              <li><a href="#">العروض</a></li>
              <li><a href="#">فروعنا</a></li>
              <li><a href="#">الشروط والاحكام</a></li>
            </ul>
          </div>
          <div class="col-md-3">
            <h4 class="footer-title">المساعدة</h4>
            <ul class="list-unstyled px-0 pt-4">
              <li><a href="#"> خدمة العملاء </a></li>
              <li><a href="#">سياسة الاسترجاع</a></li>
              <li><a href="#">سياسة الخصوصية</a></li>
            </ul>
          </div>
          <div class="col-md-3">
            <h4 class="footer-title mb-4">مواعيد عمل المطعم</h4>
            <p>الاحد الى الخميس من الساعه 10صباحا الى 10 مساء</p>
            <p>الجمعة الي االسبت من الساعة 1 مساء الي 12 صباحا</p>
          </div>
        </div>

      </div>
      <div class="copywrite">

        <p class="m-0">جميع الحقوق محفوظة لصالح <a href="#">الكوت</a> 2024</p>
      </div>
    </div>
  </footer>
  <script src="SiteAssets/js/jquery-3.6.0.min.js"></script>
  <script src="SiteAssets/bootstrap-5.1.3/dist/js/bootstrap.min.js"></script>
  <script src="SiteAssets/fontawesome-free-5.15.4-web/js/all.min.js"></script>

  <!-- Main js -->
  <script src="SiteAssets/js/style.js"></script>

  <!-- include Gallery (lightbox) plugin js-->
  <script src="SiteAssets/lightbox/js/lightbox.min.js"></script>

  <!-- include Owl Carousel plugin js-->
  <script src="SiteAssets/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
  <script src="SiteAssets/aos-master/dist/aos.js"></script>
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

</body>

</html>