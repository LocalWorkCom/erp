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
@auth('client')
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
                                <span>{{ Auth::guard('client')->user()->name }}</span>
                            </h5>
                            <small class="text-muted" dir="ltr">
                                <img src="SiteAssets/images/egypt.png" alt="" />
                                <span>{{ Auth::guard('client')->user()->phone }} </span>
                            </small>
                            <small class="text-muted d-block">
                                {{ Auth::guard('client')->user()->email ?? '' }}
                            </small>
                        </div>
                        <button class="btn reversed main-color" type="button">
                            @lang('header.editprofile')
                        </button>
                    </div>
                    <ul class="profile-list list-unstyled px-0 pt-4">
                        <li>
                            <a href="">
                                <h6 class="fw-bold">
                                    <i class="fas fa-clipboard-list main-color ms-2"></i>

                                    @lang('header.previousorder')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <h6 class="fw-bold">
                                    <i class="fas fa-map-marked-alt main-color ms-2"></i>

                                    @lang('header.trackorder')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="addresses.html">
                                <h6 class="fw-bold">
                                    <i class="fas fa-map-marker-alt main-color ms-2"></i>

                                    @lang('header.myaddress')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <h6 class="fw-bold">
                                    <i class="fas fa-star main-color ms-2"></i>
                                    @lang('header.rate')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('show.favorites') }}">
                                <h6 class="fw-bold">
                                    <i class="fas fa-heart main-color ms-2"></i>
                                    @lang('header.favorite')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <h6 class="fw-bold">
                                    <i class="fas fa-bell main-color ms-2"></i>
                                    @lang('header.notification')

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
                                    @lang('header.questions')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="policy.html">
                                <h6 class="fw-bold">
                                    <i class="fas fa-file-alt main-color ms-2"></i>
                                    @lang('header.policy')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="privacy.html">
                                <h6 class="fw-bold">
                                    <i class="fas fa-clipboard-list main-color ms-2"></i>
                                    @lang('header.privacy')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <h6 class="fw-bold">
                                    <i class="fas fa-headset main-color ms-2"></i>
                                    @lang('header.support')

                                </h6>
                            </a>
                            <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logos_whatsapp-icon.png') }} " />
                        </li>
                        <li>
                            <form method="POST" action="{{ route('website.logout') }}" id="logoutForm">
                                @csrf
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                    <h6 class="fw-bold">
                                        <i class="fas fa-sign-out-alt main-color ms-2"></i>
                                        @lang('header.logout')
                                    </h6>
                                </a>
                            </form>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
@endauth
