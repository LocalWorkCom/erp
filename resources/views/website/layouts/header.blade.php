<header class="fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light ">
        <div class="container  @if(Request::routeIs("home"))   @else second-header  @endif">

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
                                <span><i class="fas fa-map-marker-alt ms-2"></i>
                                    @lang('header.deliveryTo')
                                </span>
                                <span class="select-sm">
                                    @lang('header.choose')
                                </span>
                            </button>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::routeIs('home') ? 'active' : '' }}" aria-current="page">
                        <a class="nav-link " href="{{ route('home') }}">
                            @lang('header.home')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="modal" data-bs-target="#branchesModal">
                            @lang('header.branches')</a>
                    </li>
                    <li class="nav-item {{ Request::routeIs('menu') ? 'active' : '' }}">
                        <a class="nav-link " href="{{ route('menu') }}">
                            @lang('header.menu')
                        </a>
                    </li>
                    <li class="nav-item {{ Request::routeIs('contactUs') ? 'active' : '' }}">
                        <a class="nav-link " href="{{ route('contactUs') }}">
                            @lang('header.contactUs')
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link cart-icon" href="{{ route('cart') }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span id="cart-count" class="badge bg-danger rounded-pill">0</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        @if (session('locale') == 'ar')
                            <a class="nav-link" href="{{ route('set-locale', 'en') }}">
                                @lang('header.en')

                            </a>
                        @else
                            <a class="nav-link" href="{{ route('set-locale', 'ar') }}">
                                @lang('header.ar')

                            </a>
                        @endif
                    </li>

                    @auth('client')
                        @if (Auth::guard('client')->user()->flag == 'client')
                            <li class="nav-item">
                                <a class="nav-link  align-items-center" data-bs-toggle="modal"
                                    data-bs-target="#profileModal"><i class="fas fa-user-circle main-color"></i>
                                    <span>{{ Auth::guard('client')->user()->name }} </span>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link btn align-items-center" data-bs-toggle="modal"
                                    data-bs-target="#loginModal">
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
                </ul>
            </div>


        </div>
    </nav>
    <div class="mobNav d-lg-none d-block ">
        <div id="sidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="overlay-content">
                <a href="#"> @lang('header.home') </a>
                <a href="#"> @lang('header.menue') </a>
                <a href="#"> @lang('header.contactUs') </a>
                <a href="#"> <i class="fas fa-shopping-cart"></i>
                </a>
                <a href="#">
                    @if (session('locale') == 'ar')
                        <a class="nav-link" href="{{ route('set-locale', 'en') }}">
                            @lang('header.en')

                        </a>
                    @else
                        <a class="nav-link" href="{{ route('set-locale', 'ar') }}">
                            @lang('header.ar')

                        </a>
                    @endif
                </a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"> @lang('header.login')
                </a>
            </div>
        </div>
    </div>

</header>
