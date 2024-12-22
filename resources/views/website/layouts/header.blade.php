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
                        <a class="nav-link" href="#">تواصل معنا</a>
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
                    @auth('web')
                        @if (auth()->user()->flag == 'client')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn align-items-center" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i>
                                    <span>{{ auth()->user()->name }}</span>
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
                            </li>
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
                            <a class="nav-link btn align-items-center" data-bs-toggle="modal" data-bs-target="#loginModal">
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
