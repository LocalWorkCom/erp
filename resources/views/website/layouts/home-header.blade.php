<header class="fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light ">
        <div class="container">
            <a class="navbar-service" href="{{ route('home') }}">
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo.png') }}">
            </a>
            <button class="navbar-toggler" type="button" onclick="openNav()">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <button class="btn white fw-bold d-flex justify-content-between" data-bs-toggle="modal"
                                data-bs-target="#deliveryModal">
                                <span><i class="fas fa-map-marker-alt ms-2 main-color"></i> ابدأ طلبك </span>
                                <span class="select-sm"> اختر </span>
                            </button>
                        </a>
                    </li>
                    <li class="nav-item active" aria-current="page">
                        <a class="nav-link" href="{{ route('home') }}">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="modal" data-bs-target="#branchesModal"> الفروع</a>
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
                            <a class="nav-link" href="{{ route('set-locale', 'en') }}">En</a>
                        @else
                            <a class="nav-link" href="{{ route('set-locale', 'ar') }}">Ar</a>
                        @endif
                    </li>
                    <li class="nav-item">
                        @auth('client')
                            @if (Auth::guard('client')->user()->flag == 'client')
                        <li class="nav-item">
                            <a class="nav-link  align-items-center" data-bs-toggle="modal" data-bs-target="#profileModal"><i
                                    class="fas fa-user-circle main-color"></i>
                                <span>{{ Auth::guard('client')->user()->name }} </span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link btn align-items-center" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="fas fa-user-circle"></i>
                                <span>@lang('header.login')</span>
                            </a>
                        </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link btn align-items-center" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="fas fa-user-circle"></i>
                                <span>@lang('header.login')</span>
                            </a>
                        </li>
                    @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

