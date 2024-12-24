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
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    @if (Request::routeIs('home'))
        @include('website.layouts.home-header') {{-- Home Page Header --}}
    @else
        @include('website.layouts.header') {{-- Default Header --}}
    @endif

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

    <div class="branches-modal modal fade" tabindex="-1" id="branchesModal" aria-labelledby="branchesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="d-flex mb-1 position-relative search-form">
                        <input id="branchSearch" class="form-control search-input" type="search"
                            placeholder="ابحث عن الفرع المناسب لك" aria-label="Search">
                        <i class="fas fa-search search-icon"></i>
                    </form>

                    <div id="branchList">
                        @foreach ($branches as $branch)
                            @php
                                try {
                                    $currentTime = \Carbon\Carbon::now();
                                    $openingTime = \Carbon\Carbon::parse($branch->opening_hour);
                                    $closingTime = \Carbon\Carbon::parse($branch->closing_hour);
                                    $isOpen = $currentTime->between($openingTime, $closingTime);
                                } catch (\Exception $e) {
                                    $isOpen = false;
                                    $openingTime = $closingTime = null;
                                }
                            @endphp
                            <div class="location border-bottom mb-1 branch-item">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-bold mt-2 branch-name">
                                        <i class="fas fa-map-marker-alt main-color mx-2"></i>{{ $branch->name }}
                                    </h6>
                                    <span class="badge {{ $isOpen ? 'text-success' : 'text-muted' }} mt-2">
                                        {{ $isOpen ? 'مفتوح' : 'مغلق' }}
                                    </span>
                                </div>
                                <p class="text-muted mx-2 branch-address">{{ $branch->address }}</p>
                                <p class="main-color fw-bold">
                                    <i class="fas fa-phone mx-2"></i>{{ $branch->phone }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-no-modal"> استخدم موقعى </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('website.user-modal')

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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('branchSearch');
            const branchItems = document.querySelectorAll('.branch-item');

            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.toLowerCase();

                branchItems.forEach((item) => {
                    const name = item.querySelector('.branch-name').textContent.toLowerCase();
                    const address = item.querySelector('.branch-address').textContent.toLowerCase();

                    if (name.includes(query) || address.includes(query)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
  
    @stack('scripts')
</body>

</html>
