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
            <div class="container second-header">
                <a class="navbar-service" href="index.html">
                    <img src="SiteAssets/images/logo-with-white-bg.png">
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
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="shop.html">قائمة الطعام</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./contact-us.html">تواصل معنا</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link cart-icon" href="cart.html">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                En
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  align-items-center" data-bs-toggle="modal"
                                data-bs-target="#profileModal"><i class="fas fa-user-circle main-color"></i>
                                <span>سارة عامر </span>
                            </a>
                        </li>


                    </ul>
                </div>


            </div>
        </nav>
        <div class="mobNav d-lg-none d-block ">
            <div id="sidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <div class="overlay-content">
                    <a href="index.html"> الرئيسية</a>
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
        <section class="inner-header pt-5 mt-5">
            <div class="container pt-sm-5 pt-4">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="shop.html">قائمة الطعام</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> عربة التسوق</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="cart-page">
            <div class="container py-sm-5 py-4">
                <div class="row mx-0">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title fw-bold"> الطلبات</h5>
                                <a href="shop.html" class="btn reversed main-color d-flex fw-bold" type="button">
                                    <span class="inc ms-2">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </span>
                                    إضافةعنصر
                                </a>

                            </div>
                            <div class="card-body p-4">
                                <div class="sideCart-plate p-4 mb-4">
                                    <div class="d-flex">
                                        <a href="#">
                                            <figure class="sideCart-plate-img m-0">
                                                <img src="SiteAssets/images/plate1.png" alt="">
                                            </figure>
                                        </a>
                                        <div class="cart-details pe-5">
                                            <h5>كبسة فراخ </h5>
                                            <small class="text-muted">نص فرخة , دقوس ,كولا</small>
                                            <div class="qty mt-3">
                                              <span class="dec minus">
                                                  <!-- <i class="fa fa-trash" aria-hidden="true"></i> -->
                                                  <i class="fa fa-minus" aria-hidden="true"></i>

                                              </span>
                                              <span class="num">
                                                  0
                                              </span>
                                              <span class="inc plus">
                                                  <i class="fa fa-plus" aria-hidden="true"></i>
                                              </span>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column justify-content-end">
                                        <p class="fw-bold"> 300 ج . م</p>
                                        <div class="btns text-center">
                                            <button class="btn reversed main-color mb-2" type="button">تعديل</button>
                                            <button class="btn mb-2" type="button">حذف</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="sideCart-plate p-4 mb-4">
                                    <div class="d-flex">
                                        <a href="#">
                                            <figure class="sideCart-plate-img m-0">
                                                <img src="SiteAssets/images/plate1.png" alt="">
                                            </figure>
                                        </a>
                                        <div class="cart-details pe-5">
                                            <h5>كبسة فراخ </h5>
                                            <small class="text-muted">نص فرخة , دقوس ,كولا</small>
                                            <div class="qty mt-3">
                                                <span class="dec minus">
                                                    <!-- <i class="fa fa-trash" aria-hidden="true"></i> -->
                                                    <i class="fa fa-minus" aria-hidden="true"></i>

                                                </span>
                                                <span class="num">
                                                    0
                                                </span>
                                                <span class="inc plus">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column justify-content-end">
                                        <p class="fw-bold"> 300 ج . م</p>
                                        <div class="btns text-center">
                                            <button class="btn reversed main-color mb-2" type="button">تعديل</button>
                                            <button class="btn mb-2" type="button">حذف</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="sideCart-plate p-4 mb-4">
                                    <div class="d-flex">
                                        <a href="#">
                                            <figure class="sideCart-plate-img m-0">
                                                <img src="SiteAssets/images/plate1.png" alt="">
                                            </figure>
                                        </a>
                                        <div class="cart-details pe-5">
                                            <h5>كبسة فراخ </h5>
                                            <small class="text-muted">نص فرخة , دقوس ,كولا</small>
                                            <div class="qty mt-3">
                                              <span class="dec minus">
                                                  <i class="fa fa-minus" aria-hidden="true"></i>

                                              </span>
                                              <span class="num">
                                                  0
                                              </span>
                                              <span class="inc plus">
                                                  <i class="fa fa-plus" aria-hidden="true"></i>
                                              </span>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column justify-content-end">
                                        <p class="fw-bold"> 300 ج . م</p>
                                        <div class="btns text-center">
                                            <button class="btn reversed main-color mb-2" type="button">تعديل</button>
                                            <button class="btn mb-2" type="button">حذف</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-4">
                            <div class="card-body p-4">
                                <div class="notes">
                                    <h4 class="fw-bold">
                                        <i class="fas fa-file-alt main-color fa-xs"></i>
                                        وفرناها عليك
                                    </h4>
                                    <form>
                                        <div class="my-3 d-flex ">
                                            <input type="text" class="form-control" placeholder="أدخل كوبون الخصم"
                                                id="coupon">
                                            <button type="submit" class="btn me-4">إضافة</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="notes mt-4">
                                    <h4 class="fw-bold">
                                        <i class="fas fa-file-alt main-color fa-xs"></i>
                                        هل لديك اى ملاحظات  تود اضافتها ؟
                                    </h4>
                                    <div class="form-floating mt-3">
                                        <textarea class="form-control" placeholder="من فضلك اكتب ملاحظتك"
                                            id="floatingTextarea2" style="height: 100px"></textarea>
                                        <label for="floatingTextarea2">من فضلك اكتب ملاحظتك</label>
                                    </div>
                                </div>
                                <form>
                                  <div class="my-3 d-flex justify-content-end ">
                                      <button type="submit" class="btn me-4">حفظ</button>
                                  </div>
                              </form>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title fw-bold"> موقعي الحالي </h5>
                                <button class="btn reversed main-color fw-bold" type="button">
                                    تعديل
                                </button>

                            </div>
                            <div class="card-body p-4">
                                <p class="fw-bold">
                                    <i class="fas fa-map-marker-alt main-color ms-2"></i>
                                    مصدق الدقى و المهندسين وجيزه
                                </p>

                                <small class="text-muted">121 مصدق , الدور 2 , شقة 12 </small>
                            </div>
                        </div>
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title fw-bold"> ملخص الطلب </h5>
                            </div>
                            <div class="card-body p-4">
                                <ul class="list-unstyled p-0">
                                    <li class="order-list">
                                        <p>
                                            مجموع طلبي
                                        </p>
                                        <p class="fw-bold">
                                            550 ج.م
                                        </p>
                                    </li>
                                    <li class="order-list">
                                        <p class="main-color">
                                            كوبون خصم </p>
                                        <p class="fw-bold main-color">
                                            -50 ج.م
                                        </p>
                                    </li>
                                    <li class="order-list">
                                        <p>
                                            رسوم التوصيل
                                        </p>
                                        <p class="fw-bold">
                                            40 ج.م
                                        </p>
                                    </li>
                                    <li class="order-list">
                                        <p>
                                            رسوم الخدمة
                                        </p>
                                        <p class="fw-bold">
                                            40 ج.م
                                        </p>
                                    </li>
                                </ul>

                            </div>
                            <div class="card-footer p-4">
                                <div class="total">
                                    <p class="fw-bold">
                                        المجموع الكلى
                                    </p>
                                    <p class="fw-bold">
                                        580 ج.م
                                    </p>
                                </div>
                                <div class="message bg-warning p-2 rounded-3">
                                    <small>
                                        يشتمل على ضريبة القيمة المضافة 14% بمعنى آخر 29.23EGP
                                    </small>
                                </div>

                            </div>
                        </div>
                        <a class="btn w-100 d-flex justify-content-between mt-5" href="checkout.html">
                            <span> تابع الدفع <span class="me-2"> > </span>
                            </span>
                            <span>550 ج . م</span>
                        </a>
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
          <div class="col-md-3" data-aos="zoom-in">
            <h4 class="footer-title"> تواصل معنا </h4>
            <ul class="list-unstyled px-0 pt-4">
              <li>
                <ul class="list-unstyled social-media p-0">
                  <li>
                    <a href="#" class="ms-3">
                      <i class="fab fa-facebook"></i>
                    </a>
                  </li>
                  <li>
                    <a href="#" class="ms-3">
                      <i class="fab fa-snapchat"></i>
                    </a>
                  </li>
                  <li>
                    <a href="#" class="ms-3">
                      <i class="fab fa-instagram"></i>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="d-flex align-items-center">
                <span class="icon ms-2">
                  <i class="fas fa-phone"></i>
                </span>
                <a >
                  010265899887
                </a>
              </li>
              <li class="d-flex align-items-center">
                <span class="icon ms-2">
                  <i class="fas fa-phone"></i>
                </span>
                <a >
                  010265899887
                </a>
              </li>
            </ul>
          </div>
          <div class="col-md-3" data-aos="zoom-in">
            <h4 class="footer-title">روابط سريعة </h4>
            <ul class="list-unstyled px-0 pt-4">
              <li><a href="shop.html"> القائمة الرئيسية</a></li>
              <li><a data-bs-toggle="modal" data-bs-target="#productModal">العروض</a></li>
              <li><a  data-bs-toggle="modal" data-bs-target="#branchesModal">فروعنا</a></li>
              <li><a href="policy.html">الشروط والاحكام</a></li>
            </ul>
          </div>
          <div class="col-md-3" data-aos="zoom-in">
            <h4 class="footer-title">المساعدة</h4>
            <ul class="list-unstyled px-0 pt-4">
              <li><a href="contact-us.html"> خدمة العملاء </a></li>
              <li><a href="policy.html">سياسة الاسترجاع</a></li>
              <li><a href="privacy.html">سياسة الخصوصية</a></li>
            </ul>
          </div>
          <div class="col-md-3" data-aos="zoom-in">
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
  <!-- modals -->

  <!-- login modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header border-0">
          <button type="button" class="btn btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- body-register  -->
        <div class="modal-body register px-4" id="registerBody">
          <div class="row">
            <div class="col-12 d-flex justify-content-center">
              <img src="./SiteAssets/images/logo-with-white-bg.png" alt="Logo" height="110">
            </div>

            <div class="col-md-7 right-side p-3">
              <h2 class="main-color fw-bold">مرحبا بك!</h2>
              <h5> يمكنك انشاء حساب بكل سهولة</h5>

              <div class="input-group mb-3">
                <input type="text" class="form-control" id="nameInput" placeholder="ادخل الاسم كامـلا ,مثال سارة عامر">
              </div>

              <div class="input-group mb-3">
                <input type="text" class="form-control" id="phoneInput" placeholder="ادخل رقم الهاتف ,مثال01029063398">
                <button class="country-dropdown me-2" data-bs-toggle="dropdown" aria-expanded="false"> +02 <img
                    src="./SiteAssets/images/egypt.png" alt=""></button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#"> <small> +02</small> <img src="./SiteAssets/images/egypt.png"
                        alt=""></a></li>
                </ul>
              </div>

              <div class="input-group mb-3">
                <input type="email" class="form-control" id="emailInput"
                  placeholder="ادخل البريد الالكترونى ,مثال saamer2019@gmail.com">
              </div>

              <div class="input-group position-relative mb-3">
                <input type="password" class="form-control" id="passwordInput" placeholder="ادخل كلمة المرور">
                <button class="input-group-eye position-absolute" type="button" id="togglePassword">
                  <i class="fas fa-eye" id="eyeIcon"></i>
                </button>
              </div>


              <button type="submit" class="btn mb-2 w-100">انشاء حساب</button>

              <p class="text-center">
                <small>
                  هل لديك حساب بالفعل؟
                  <a href="#" class="main-color text-decoration-underline" id="showLoginLink"
                    aria-label="تسجيل الدخول">تسجيل دخول</a>
                </small>
              </p>

              <p class="text-center">
                <small>
                  <span class="text-muted">عند انشاء حساب انت توافق علي</span>

                  <a class="main-color text-decoration-underline" href="./privacy.html">سياسة الخصوصية</a> و <a
                    class="main-color text-decoration-underline" href="./policy.html"> الشروط و الاحكام</a>

                </small>
              </p>
            </div>

            <div class="col-md-5 login-background">
              <img src="./SiteAssets/images/login-chef-backgound.png" alt="">
            </div>
          </div>
        </div>
        <!-- body-login  -->
        <div class="modal-body login d-none px-4" id="loginBody">
          <div class="row">
            <div class="col-12 d-flex justify-content-center">
              <img src="./SiteAssets/images/logo-with-white-bg.png" alt="Logo" height="110">
            </div>

            <div class="col-md-7 right-side p-3">
              <h2 class="main-color fw-bold">مرحبا بك!</h2>
              <h5>تسجيل الدخول لتستمتع بتجربة طلب معدة خصيصا لك </h5>

              <div class="input-group mb-3">
                <input type="text" class="form-control" id="phoneInput" placeholder="ادخل رقم الهاتف ,مثال01029063398">
                <button class="country-dropdown me-2" data-bs-toggle="dropdown" aria-expanded="false"><small>
                    +02</small> <img src="./SiteAssets/images/egypt.png" alt=""></button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#"> +02 <img src="./SiteAssets/images/egypt.png" alt=""></a></li>
                </ul>
              </div>

              <div class="input-group position-relative mb-3">
                <input type="password" class="form-control" id="passwordInput" placeholder="ادخل كلمة المرور الجديدة">
                <button class="input-group-eye position-absolute" type="button" id="togglePassword">
                  <i class="fas fa-eye" id="eyeIcon"></i>
                </button>
              </div>



              <a id="showforgetLink"> <small> هل نسيت كلمة المرور؟ </small></a>

              <button type="submit" class="btn  my-2 w-100"> تسجيل الدخول</button>

              <p class="text-center">
                <small>
                  تسجيل الدخول باستخدام شبكات التواصل

                </small>
              </p>

              <div class="d-flex justify-content-center gap-lg-3">
                <a class="social-media-btn d-flex align-items-center " href="#">
                  <img src="./SiteAssets/images/facebook-icon.png" alt="Facebook" class="ms-2" height="20">
                  <span>فيس بوك</span>
                </a>

                <a class="social-media-btn d-flex align-items-center " href="#">
                  <img src="./SiteAssets/images/google-icon.png" alt="Google" class="ms-2" height="20">
                  <span>جوجل</span>
                </a>
              </div>
              <p class="text-center">
                <small>
                  <span class="text-dark"> مستخدم جديد؟ </span>
                  <a href="#" class="main-color text-decoration-underline" id="showRegisterLink"
                    aria-label="تسجيل حساب">تسجيل حساب</a>

                </small>
              </p>
            </div>

            <div class="col-md-5 login-background">
              <img src="./SiteAssets/images/login-chef-backgound.png" alt="">
            </div>
          </div>
        </div>
        <!-- Forget Body -->
        <div class="modal-body forget d-none px-4" id="forgetBody">
          <div class="row">
            <div class="col-12 d-flex justify-content-center">
              <img src="./SiteAssets/images/logo-with-white-bg.png" alt="Logo" height="110">
            </div>

            <div class="col-md-7 right-side p-3">
              <h2 class="main-color fw-bold py-3">نسيت كلمة المرور؟</h2>
              <h5>لإعادة تعيين كلمة المرور الرجاء ادخال رقم الهاتف</h5>
              <div class="input-group py-md-4 py-sm-2">
                <input type="text" class="form-control py-2" id="phoneInput"
                  placeholder="ادخل رقم الهاتف ,مثال01029063398">
                <button class="country-dropdown me-2" data-bs-toggle="dropdown" aria-expanded="false">
                  <small>+02</small>
                  <img src="./SiteAssets/images/egypt.png" alt="">
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#"> <small> +02</small> <img src="./SiteAssets/images/egypt.png"
                        alt=""></a></li>
                </ul>
              </div>
              <button type="submit" class="btn w-100" id="sendForgetButton">ارسال</button>
            </div>
            <div class="col-md-5 login-background">
              <img src="./SiteAssets/images/login-chef-backgound.png" alt="">
            </div>
          </div>
        </div>

        <!-- OTP-sent Body -->
        <div class="modal-body otp-sent d-none px-4" id="otpBody">
          <div class="row">
            <div class="col-12 d-flex justify-content-center">
              <img src="./SiteAssets/images/logo-with-white-bg.png" alt="Logo" height="110">
            </div>

            <div class="col-md-7 right-side p-3">
              <h2 class="main-color fw-bold py-3">تأكيد رقم الهاتف</h2>
              <h5>تم ارسال كود لرقم الهاتف المسجل لدينا عن طريق الواتس اب</h5>
              <h4 class="main-color fw-bold py-3">+0201165998745</h4>
              <div class="code-input" id="codeInputForm">
                <input class="m-1" type="text" maxlength="1" id="digit1" onkeyup="moveToNext(this, 'digit2')">
                <input class="m-1" type="text" maxlength="1" id="digit2" onkeyup="moveToNext(this, 'digit3')"
                  onkeydown="moveToPrevious(event, 'digit1')">
                <input class="m-1" type="text" maxlength="1" id="digit3" onkeyup="moveToNext(this, 'digit4')"
                  onkeydown="moveToPrevious(event, 'digit2')">
                <input class="m-1" type="text" maxlength="1" id="digit4" onkeydown="moveToPrevious(event, 'digit3')">
              </div>
              <p class="py-2" id="timer"></p>
              <div class="d-flex justify-content-between flex-wrap">
                <p class="text-muted">لم أتلقى رمز التفعيل ؟</p>
                <a href="#" class="main-color">اعادة ارسال رمز التفعيل</a>
              </div>
              <button type="submit" class="btn w-100" id="sendOtpButton">ارسال</button>
            </div>
            <div class="col-md-5 login-background">
              <img src="./SiteAssets/images/login-chef-backgound.png" alt="">
            </div>
          </div>
        </div>

        <!-- OTP-done Body -->
        <div class="modal-body otp-done d-none px-4" id="otpDoneBody">
          <div class="row">
            <div class="col-12 d-flex justify-content-center">
              <img src="./SiteAssets/images/logo-with-white-bg.png" alt="Logo" height="110">
            </div>

            <div class="col-md-7 right-side p-3">
              <h2 class="main-color fw-bold py-3">تأكيد رقم الهاتف</h2>
              <h5>تم ارسال كود لرقم الهاتف المسجل لدينا عن طريق الواتس اب</h5>
              <h4 class="main-color fw-bold py-3">+0201165998745</h4>
              <div class="text-center">
                <img src="./SiteAssets/images/donee.png" alt="" height="100" class="mb-3">
                <p class="fw-bold">تم التحقق بنجاح</p>
              </div>
            </div>
            <div class="col-md-5 login-background">
              <img src="./SiteAssets/images/login-chef-backgound.png" alt="">
            </div>
          </div>
        </div>
        <!-- Reset Body -->
        <div class="modal-body reset-pass d-none px-4" id="resetBody">
          <div class="row">
            <div class="col-12 d-flex justify-content-center">
              <img src="./SiteAssets/images/logo-with-white-bg.png" alt="Logo" height="110">
            </div>
            <div class="col-md-7 right-side p-3">
              <h2 class="main-color fw-bold py-3">ادخل كلمة مرور جديدة</h2>
              <div class="input-group position-relative mb-3">
                <input type="password" class="form-control" id="passwordInput" placeholder="ادخل كلمة المرور الجديدة">
                <button class="input-group-eye position-absolute" type="button" id="togglePassword">
                  <i class="fas fa-eye" id="eyeIcon"></i>
                </button>
              </div>

              <div class="input-group position-relative mb-3">
                <input type="password" class="form-control" id="passwordInput2" placeholder="ادخل كلمة المرور الجديدة">
                <button class="input-group-eye position-absolute" type="button" id="togglePassword2">
                  <i class="fas fa-eye" id="eyeIcon2"></i>
                </button>
              </div>

              <button type="submit" class="btn w-100">تأكيد</button>
            </div>
            <div class="col-md-5 login-background">
              <img src="./SiteAssets/images/login-chef-backgound.png" alt="">
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- end login modal -->
  <!-- product details modal -->
  <div class="modal fade" tabindex="-1" id="productModal" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header border-0">
          <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h2 class="text-center mb-4"> من فضلك قم بتخصيص وجبتك </h2>
          <div class="row mx-0">
            <div class="col-md-6">
              <div class="product-details ">
                <h4>اختيارات من الحجم
                </h4>
                <div class="choices my-3">
                  <form>
                    <div class="form-check">
                      <div>
                        <input class="form-check-input" type="radio" name="options" id="option1" value="option1">
                        <label class="form-check-label" for="option1">
                          ربع فرخة
                        </label>
                      </div>
                      <span>100 ج.م</span>

                    </div>
                    <div class="form-check">
                      <div>
                        <input class="form-check-input" type="radio" name="options" id="option2" value="option2">
                        <label class="form-check-label" for="option2">
                          نص فرخة
                        </label>
                      </div>
                      <span>200 ج.م</span>
                    </div>
                    <div class="form-check">
                      <div>
                        <input class="form-check-input" type="radio" name="options" id="option3" value="option3">
                        <label class="form-check-label" for="option3">
                          فرخة كاملة
                        </label>
                      </div>
                      <span>400 ج.م</span>

                    </div>
                  </form>
                </div>
                <h4> اضافات
                </h4>
                <div class="choices my-3">
                  <form>
                    <div class="form-check">
                      <div>
                        <input class="form-check-input" type="checkbox" name="options" id="option11" value="option11">

                        <label class="form-check-label" for="option11">
                          دقوس </label>
                      </div>
                      <span>100 ج.م</span>

                    </div>
                    <div class="form-check">
                      <div>
                        <input class="form-check-input" type="checkbox" name="options" id="option22" value="option22">
                        <label class="form-check-label" for="option22">
                          جمبري
                        </label>
                      </div>
                      <span>200 ج.م</span>
                    </div>
                    <div class="form-check">
                      <div>
                        <input class="form-check-input" type="checkbox" name="options" id="option33" value="option33">
                        <label class="form-check-label" for="option33">
                          رز
                        </label>
                      </div>
                      <span>400 ج.م</span>

                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="product">
                <figure class="product-img m-0">
                  <img src="SiteAssets/images/plate1.png" alt="">
                  <figcaption class="pt-3">
                    <h5>كبسة فراخ </h5>
                    <span class="badge bg-warning text-dark">
                      <i class="fas fa-star"></i>
                      الاعلى تقييم
                    </span>
                    <small class="text-muted d-block py-2">
                      عيش مع نصف دجاجه يقدم مع معبوج أخضر ومعبوج أحمر ودقوس او مرق باميه
                    </small>
                    <h4 class="fw-bold"> 300 ج . م</h4>
                    <div class="qty mt-3 d-flex justify-content-center align-items-center">
                      <span class="pro-dec me-3" onclick="decreaseQuantity()">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                      </span>
                      <span class="num fs-4" id="quantity">1</span>
                      <span class="pro-inc ms-3" onclick="increaseQuantity()">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                      </span>
                    </div>


                  </figcaption>
                </figure>
              </div>
              <div class="notes my-3">
                <h4>
                  <i class="fas fa-file-alt main-color fa-xs"></i>
                  لديك اى ملاحظات اضافيه؟
                </h4>
                <div class="form-floating mt-3">
                  <textarea class="form-control" placeholder="من فضلك اكتب ملاحظتك" id="floatingTextarea2"
                    style="height: 100px"></textarea>
                  <label for="floatingTextarea2">من فضلك اكتب ملاحظتك</label>
                </div>
              </div>
              <button class="btn w-100 d-flex justify-content-between mt-3">
                <span> + أضف الي العربة
                  (1)</span>
                <span>300 ج . م</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end product details modal -->
  <!-- delivery details modal -->
  <div class="delivery-modal modal fade" tabindex="-1" id="deliveryModal" aria-labelledby="deliveryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-lg">
      <div class="modal-content">
        <div class="modal-header border-0">
          <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"
            onclick="showFirstPhase()"></button>
        </div>
        <div class="modal-body">
          <h3 class="text-center fw-bold mb-4"> ابدأ طلبك الان </h3>
          <ul class="nav nav-pills main-pills px-0 mb-3 justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item ms-3" role="presentation">
              <button class="nav-link active" id="pills-delivery-tab" data-bs-toggle="pill"
                data-bs-target="#pills-delivery" type="button" role="tab" aria-controls="pills-delivery"
                aria-selected="true">
                <div class="icon">
                  <img src="SiteAssets/images/delivery-icon.png" alt="" />
                </div>
                <h6 class="me-2">التوصيل</h6>
              </button>
            </li>
            <li class="nav-item ms-3 " role="presentation">
              <button class="nav-link" id="pills-takeaway-tab" data-bs-toggle="pill" data-bs-target="#pills-takeaway"
                type="button" role="tab" aria-controls="pills-takeaway" aria-selected="false">
                <div class="icon">
                  <img src="SiteAssets/images/takeaway-icon.png" alt="" />
                </div>
                <h6 class="me-2">الإستلام</h6>
              </button>
            </li>

          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-delivery" role="tabpanel"
              aria-labelledby="pills-delivery-tab">
              <div class="first-phase">
                <h5 class="fw-bold">
                  تحديد موقع التوصيل
                </h5>
                <div class="search-group ">
                  <span class="search-icon">
                    <i class="fas fa-search"></i>
                  </span>
                  <input type="text" class="form-control" placeholder="ابحث عن الموقع" />
                </div>
                <div class="map position-relative my-3">
                  <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3453.025253043487!2d31.22420217605614!3d30.064810617604635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x145841cef6b62cc1%3A0x31bc8779f7ab8dd5!2z2YXYt9i52YUg2KfZhNmD2YjYqg!5e0!3m2!1sen!2seg!4v1734860419141!5m2!1sen!2seg"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                  </iframe>
                  <div class="notes">
                    <small> تسجيل الدخول لاستخدام عناوينك المحفوظة</small>
                    <button class="btn"> تسجيل الدخول</button>
                  </div>
                </div>
                <div class="tab-footer justify-content-between d-flex align-items-center">
                  <div>
                    <h6 class="fw-bold">
                      موقع التوصيل
                    </h6>
                    <p>
                      <i class="fas fa-map-marker-alt main-color ms-2"></i>
                      مصدق الدقى و المهندسين وجيزه
                    </p>
                  </div>
                  <button class="btn reversed main-color fw-bold" type="button">
                    تعديل
                  </button>
                  <button type="submit" class="btn" onclick="showSecondPhase()">تأكيد العنوان</button>
                </div>
              </div>
              <div class="second-phase d-none">
                <h6 class="fw-bold">
                  موقع التوصيل
                </h6>
                <div class="d-flex justify-content-between">
                  <p>
                    <i class="fas fa-map-marker-alt main-color ms-2"></i>
                    مصدق الدقى و المهندسين وجيزه
                  </p>
                  <button class="btn reversed main-color fw-bold" type="button">
                    تعديل
                  </button>
                </div>
                <h6 class="fw-bold mb-3">
                  أكمل موقع التوصيل
                </h6>
                <ul class="delivery-places nav nav-pills px-0 mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill" id="pills-home-tab" data-bs-toggle="pill"
                      data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                      aria-selected="true">
                      <i class="fas fa-city"></i> شقة
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill" id="pills-villa-tab" data-bs-toggle="pill"
                      data-bs-target="#pills-villa" type="button" role="tab" aria-controls="pills-villa"
                      aria-selected="false">
                      <i class="fas fa-home"></i> فيلا
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill" id="pills-work-tab" data-bs-toggle="pill"
                      data-bs-target="#pills-work" type="button" role="tab" aria-controls="pills-work"
                      aria-selected="false">
                      <i class="fas fa-building"></i> مكتب
                    </button>
                  </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                    aria-labelledby="pills-home-tab">
                    <form>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="اسم  الفيلا, مثال فيلا شاهين">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="رقم الفيلا ,مثال  فيلا 12">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder=" 121 مصدق الدقي ,المهندسين  الجيزه">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="علامة مميزة (اختيارى)">
                      </div>
                      <div class="mb-3">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="  ادخل رقم الهاتف  ,مثال01029063398">
                          <select class="form-select country-dropdown me-3" style="max-width: 100px;">
                            <option value="eg" selected>+20</option>
                            <option value="ae">+971</option>
                            <option value="jo">+962</option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane fade" id="pills-villa" role="tabpanel" aria-labelledby="pills-villa-tab">
                    <form>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="اسم  الفيلا, مثال فيلا شاهين">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="رقم الفيلا ,مثال  فيلا 12">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder=" 121 مصدق الدقي ,المهندسين  الجيزه">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="علامة مميزة (اختيارى)">
                      </div>
                      <div class="mb-3">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="  ادخل رقم الهاتف  ,مثال01029063398">
                          <select class="form-select country-dropdown me-3" style="max-width: 100px;">
                            <option value="eg" selected>+20</option>
                            <option value="ae">+971</option>
                            <option value="jo">+962</option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane fade" id="pills-work" role="tabpanel" aria-labelledby="pills-work-tab">
                    <form>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="اسم  الفيلا, مثال فيلا شاهين">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="رقم الفيلا ,مثال  فيلا 12">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder=" 121 مصدق الدقي ,المهندسين  الجيزه">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="علامة مميزة (اختيارى)">
                      </div>
                      <div class="mb-3">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="  ادخل رقم الهاتف  ,مثال01029063398">
                          <select class="form-select country-dropdown me-3" style="max-width: 100px;">
                            <option value="eg" selected>+20</option>
                            <option value="ae">+971</option>
                            <option value="jo">+962</option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="tab-footer justify-content-end d-flex">
                  <button type="submit" class="btn" onclick="showThirdPhase()">حفظ العنوان</button>
                </div>
              </div>
              <div class="third-phase d-none">
                <div>
                  <h6 class="fw-bold">
                    موقع التوصيل
                  </h6>
                  <div class="d-flex justify-content-between">
                    <p>
                      <i class="fas fa-map-marker-alt main-color ms-2"></i>
                      مصدق الدقى و المهندسين وجيزه
                    </p>
                    <button class="btn reversed main-color fw-bold" type="button">
                      تعديل
                    </button>
                  </div>

                  <p class="text-muted">
                    121 مصدق , الدور 2 , شقة 12 ,رقم الهاتف: 01029061189 ,علامة مميزة: امام ماركت الصفا
                  </p>

                </div>
              </div>
              <!-- <div class="fourth-phase">
                <h5 class="fw-bold">
                  تحديد موقع التوصيل
                </h5>
                <div class="search-group ">
                  <span class="search-icon">
                    <i class="fas fa-search"></i>
                  </span>
                  <input type="text" class="form-control" placeholder="ابحث عن الموقع" />
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <h4 class="my-4 fw-bold">عناويني</h4>
                  <button class="btn fw-bold" type="button">
                    <span>+</span> أضف عنوان
                  </button>
                </div>
                <ul class="list-unstyled px-0">
                  <li class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                      <h5>
                        <i class="fas fa-city text-muted fa-xs ms-2"></i>
                        شقة
                      </h5>
                      <small class="text-muted">
                        250 معادى السريات-قسم المعادى-محافظة القاهرة
                      </small>
                    </div>
                    <div class="dropdown">
                      <a id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                          <button class="dropdown-item w-100">تعديل </button>
                        </li>
                        <li>
                          <button class="dropdown-item w-100"> حذف</button>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <li class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                      <h5>
                        <i class="fas fa-city text-muted fa-xs ms-2"></i>
                        فيلا
                      </h5>
                      <small class="text-muted">
                        250 معادى السريات-قسم المعادى-محافظة القاهرة
                      </small>
                    </div>
                    <div class="dropdown">
                      <a id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                          <button class="dropdown-item w-100">تعديل </button>
                        </li>
                        <li>
                          <button class="dropdown-item w-100"> حذف</button>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <li class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                      <h5>
                        <i class="fas fa-city text-muted fa-xs ms-2"></i>
                        شركة
                      </h5>
                      <small class="text-muted">
                        250 معادى السريات-قسم المعادى-محافظة القاهرة
                      </small>
                    </div>
                    <div class="dropdown">
                      <a id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                          <button class="dropdown-item w-100">تعديل </button>
                        </li>
                        <li>
                          <button class="dropdown-item w-100"> حذف</button>
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
                <div class="tab-footer justify-content-between d-flex align-items-center">
                  <div>
                    <h6 class="fw-bold">
                      موقع التوصيل
                    </h6>
                    <p>
                      <i class="fas fa-map-marker-alt main-color ms-2"></i>
                      مصدق الدقى و المهندسين وجيزه
                    </p>
                  </div>
                  <button class="btn reversed main-color fw-bold" type="button">
                    تعديل
                  </button>
                  <button type="submit" class="btn" onclick="showSecondPhase()">تأكيد العنوان</button>
                </div>
              </div> -->
            </div>
            <div class="tab-pane fade" id="pills-takeaway" role="tabpanel" aria-labelledby="pills-takeaway-tab">
             
            <div class="bg-dark-gray  py-2">
              <h5 class="text-dark fw-bold text-center">ما هو المطعم الذى تريد الاستلام منه؟</h5>
            </div>
               <div class="d-flex justify-content-end my-2">
                  <button class="btn btn-no-modal"> استخدم موقعى </button>
                </div> 
                 <div class="my-2">
              <h5 class="text-dark fw-bold"> موقع الاستلام</h5>
              <form class="d-flex mb-1 position-relative search-form">
                <input class="form-control search-input" type="search" placeholder="ابحث عن الفرع المناسب لك"
                  aria-label="Search">
                <i class="fas fa-search search-icon"></i>
              </form>
            </div>
   
                <div class="location border-bottom mb-1">
                  <div class="d-flex justify-content-between">
                    <h6 class="fw-bold mt-2">
                      <i class="fas fa-map-marker-alt main-color mx-2"></i>فرع المهندسين ممشى اهل مصر
                    </h6>
                    <span class="badge text-success mt-2">مفتوح</span>
                  </div>
                  <p class="text-muted mx-2">12 ممشى اهل مصر12 بجوار كريو كافيه</p>
                  <p class="main-color fw-bold">
                    <i class="fas fa-phone mx-2"></i>0123698745269
                  </p>
                </div>
                <div class="location mb-1">
                  <div class="d-flex justify-content-between">
                    <h6 class="fw-bold mt-2">
                      <i class="fas fa-map-marker-alt main-color mx-2"></i>فرع المهندسين ممشى اهل مصر
                    </h6>
                    <span class="badge text-muted mt-2">مغلق</span>
                  </div>
                  <p class="text-muted mx-2">12 ممشى اهل مصر12 بجوار كريو كافيه</p>
                  <p class="main-color fw-bold">
                    <i class="fas fa-phone mx-2"></i>0123698745269
                  </p>
                </div>

                <div class="location border-red mb-1">
                  <div class="d-flex justify-content-between">
                    <h6 class="fw-bold mt-2">
                      <i class="fas fa-map-marker-alt main-color mx-2"></i>فرع المهندسين ممشى اهل مصر
                    </h6>
                    <span class="badge text-success mt-2">مفتوح</span>
                  </div>
                  <p class="text-muted mx-2">12 ممشى اهل مصر12 بجوار كريو كافيه</p>
                  <p class="main-color fw-bold">
                    <i class="fas fa-phone mx-2"></i>0123698745269
                  </p>
                </div>
                <div class="d-flex justify-content-end my-2">
                  <button class="btn">  ابدأ طلبك </button>
                </div> 
           
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end delivery details modal -->
  <!-- branches  modal -->
  <div class="branches-modal modal fade" tabindex="-1" id="branchesModal" aria-labelledby="branchesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- <div class="modal-header border-0">
            <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div> -->
        <div class="modal-body">
          <form class="d-flex mb-1 position-relative search-form">
            <input class="form-control search-input" type="search" placeholder="ابحث عن الفرع المناسب لك"
              aria-label="Search">
            <i class="fas fa-search search-icon"></i>
          </form>

          <div class="location border-bottom mb-1">
            <div class="d-flex justify-content-between">
              <h6 class="fw-bold mt-2">
                <i class="fas fa-map-marker-alt main-color mx-2"></i>فرع المهندسين ممشى اهل مصر
              </h6>
              <span class="badge text-success mt-2">مفتوح</span>
            </div>
            <p class="text-muted mx-2">12 ممشى اهل مصر12 بجوار كريو كافيه</p>
            <p class="main-color fw-bold">
              <i class="fas fa-phone mx-2"></i>0123698745269
            </p>
          </div>
          <div class="location mb-1">
            <div class="d-flex justify-content-between">
              <h6 class="fw-bold mt-2">
                <i class="fas fa-map-marker-alt main-color mx-2"></i>فرع المهندسين ممشى اهل مصر
              </h6>
              <span class="badge text-muted mt-2">مغلق</span>
            </div>
            <p class="text-muted mx-2">12 ممشى اهل مصر12 بجوار كريو كافيه</p>
            <p class="main-color fw-bold">
              <i class="fas fa-phone mx-2"></i>0123698745269
            </p>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-no-modal"> استخدم موقعى </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- end branches details modal -->
  <!-- Profile modal -->
  <div class="modal fade" tabindex="-1" id="profileModal" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
      <div class="modal-content">
        <div class="modal-header border-0">
          <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex justify-content-between align-items-start border-bottom pb-2">
            <div>
              <h5 class="fw-bold mb-3">
                <i class="fas fa-user-circle main-color"></i>
                <span>سارة عامر </span>
              </h5>
              <small class="text-muted" dir="ltr">
                <img src="SiteAssets/images/egypt.png" alt="" />
                <span>+20-1029061193</span>
              </small>
              <small class="text-muted d-block">
                saamer2019@gmail.com
              </small>
            </div>
            <a class="btn reversed main-color" href="profile.html">تعديل الملف الشخصى </a>
          </div>
          <ul class="profile-list list-unstyled px-0 pt-4">
            <li>
              <a href="">
                <h6 class="fw-bold">
                  <i class="fas fa-clipboard-list main-color ms-2"></i>
                  الطلبات السابقة
                </h6>
              </a>
            </li>
            <li>
              <a href="follow-request.html">
                <h6 class="fw-bold">
                  <i class="fas fa-map-marked-alt main-color ms-2"></i>
                  تتبع الطلب
                </h6>
              </a>
            </li>
            <li>
              <a href="addresses.html">
                <h6 class="fw-bold">
                  <i class="fas fa-map-marker-alt main-color ms-2"></i>
                  عناوينى
                </h6>
              </a>
            </li>
            <li>
              <a href="comment-rate.html">
                <h6 class="fw-bold">
                  <i class="fas fa-star main-color ms-2"></i>
                  قيم تجربتك
                </h6>
              </a>
            </li>
            <li>
              <a href="favourites.html">
                <h6 class="fw-bold">
                  <i class="fas fa-heart main-color ms-2"></i>
                  مفضلاتى
                </h6>
              </a>
            </li>
            <li>
              <a href="">
                <h6 class="fw-bold">
                  <i class="fas fa-bell main-color ms-2"></i>
                  اشعارات التسويق
                </h6>
              </a>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
              </div>
            </li>
            <li>
              <a href="questions.html">
                <h6 class="fw-bold">
                  <i class="fas fa-file-alt main-color ms-2"></i>
                  الاسئلة المتكررة
                </h6>
              </a>
            </li>
            <li>
              <a href="policy.html">
                <h6 class="fw-bold">
                  <i class="fas fa-file-alt main-color ms-2"></i>
                  الشروط والاحكام
                </h6>
              </a>
            </li>
            <li>
              <a href="privacy.html">
                <h6 class="fw-bold">
                  <i class="fas fa-clipboard-list main-color ms-2"></i>
                  سياسة الخصوصيه
                </h6>
              </a>
            </li>
            <li>
              <a href="">
                <h6 class="fw-bold">
                  <i class="fas fa-headset main-color ms-2"></i>
                  الدعم
                </h6>
              </a>
              <img src="SiteAssets/images/logos_whatsapp-icon.png" />
            </li>
            <li>
              <a href="">
                <h6 class="fw-bold">
                  <i class="fas fa-sign-out-alt main-color ms-2"></i>
                  تسجيل خروج
                </h6>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <script src="SiteAssets/js/jquery-3.6.0.min.js"></script>
  <script src="SiteAssets/bootstrap-5.1.3/dist/js/bootstrap.min.js"></script>
  <script src="SiteAssets/fontawesome-free-5.15.4-web/js/all.min.js"></script>

  <!-- Main js -->
  <script src="./SiteAssets/js/style.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

  <!-- include Gallery (lightbox) plugin js-->
  <script src="SiteAssets/lightbox/js/lightbox.min.js"></script>

  <!-- include Owl Carousel plugin js-->
  <script src="SiteAssets/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
  <script src="SiteAssets/aos-master/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

</body>

</html>