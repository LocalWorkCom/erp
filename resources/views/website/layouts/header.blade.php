<header class="fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light ">
        <div class="container">
            <a class="navbar-service" href="index.html">
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo.png') }}">
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
                        <a class="nav-link" href="{{ route('home') }}">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('menu') }}">قائمة الطعام</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contactUs') }}">تواصل معنا</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link cart-icon" href="#">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        @if (session('locale') == 'ar')
                            <a class="nav-link" href="{{ route('set-locale', 'en') }}">
                                En
                            </a>
                        @else
                            <a class="nav-link" href="{{ route('set-locale', 'ar') }}">
                                Ar
                            </a>
                        @endif

                    </li>
                    {{-- {{ dd(Auth::check()) }} --}}
                    @auth('client')
                        @if (Auth::guard('client')->user()->flag == 'client')
                            <li class="nav-item">
                                <a class="nav-link  align-items-center" data-bs-toggle="modal"
                                    data-bs-target="#profileModal"><i class="fas fa-user-circle main-color"></i>
                                    <span>{{ Auth::guard('client')->user()->name }} </span>
                                </a>
                            </li>
                            <div class="modal fade" tabindex="-1" id="profileModal" aria-labelledby="profileModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered ">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div
                                                class="d-flex justify-content-between align-items-start border-bottom pb-2">
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
                                                <button class="btn reversed main-color" type="button">تعديل الملف الشخصى
                                                </button>
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
                                                    <a href="">
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
                                                    <a href="">
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
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="flexSwitchCheckDefault">
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
                                                            <form method="POST" action="{{ route('website.logout') }}">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item">
                                                                    @lang('auth.logout')
                                                                </button>
                                                            </form>

                                                        </h6>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle btn align-items-center" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i>
                                    <span>{{ Auth::guard('client')->user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('website.profile.view') }}">
                                            <i class="fas fa-user"></i> @lang('auth.profile')
                                        </a>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('website.logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                @lang('auth.logout')
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li> --}}
                        @else
                            <li class="nav-item">
                                <a class="nav-link btn align-items-center" data-bs-toggle="modal"
                                    data-bs-target="#loginModal">
                                    <i class="fas fa-user-circle"></i>
                                    <span>@lang('auth.login')</span>
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link btn align-items-center" data-bs-toggle="modal"
                                data-bs-target="#loginModal">
                                <i class="fas fa-user-circle"></i>
                                <span>@lang('auth.login')</span>
                            </a>
                        </li>
                    @endauth





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
                <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"> تسجيل الدخول </a>
            </div>
        </div>
    </div>

</header>
