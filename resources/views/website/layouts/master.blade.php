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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
    <!-- Owl Carousel -->
    <link rel="stylesheet"
        href="{{ asset('front/AlKout-Resturant/SiteAssets/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('front/AlKout-Resturant/SiteAssets/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css') }}" />

    <!-- include Gallery (lightbox) plugin -->
    <link rel="stylesheet" href="{{ asset('front/AlKout-Resturant/SiteAssets/lightbox/css/lightbox.min.css') }}" />
    <!-- Main Style -->
    @if (app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{ asset('front/AlKout-Resturant/SiteAssets/css/style.css') }}" type="text/css" />
    @else
        <link rel="stylesheet" href="{{ asset('front/AlKout-Resturant/SiteAssets/css/style-EN.css') }}"
            type="text/css" />
    @endif
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
</head>

<body>


    @include('website.layouts.header') {{-- Default Header --}}

    <main>
        @yield('content')
        <section class="before-footer"></section>
    </main>

    <!-- modals -->
    @include('website.layouts.footer')
    @include('website.success-modal')

    <!-- login modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn btn-close text-light" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                {{-- <div id="msg-error" style="display: none;text-align:center" class="message bg-warning p-2 rounded-3">

                </div> --}}
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
                                <p class="text-muted mx-2 branch-address">
                                    {{ $branch->address }}</p>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('front/AlKout-Resturant/SiteAssets/js/jquery-3.6.0.min.js') }}"></script>
    {{-- <script src="{{ asset('front/AlKout-Resturant/SiteAssets/fontawesome-free-5.15.4-web/js/all.min.js') }}"></script> --}}
    <script src="{{ asset('front/AlKout-Resturant/SiteAssets/bootstrap-5.1.3/dist/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('front/AlKout-Resturant/SiteAssets/bootstrap-5.1.3/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('front/AlKout-Resturant/SiteAssets/js/bootstarp-select.js') }}"></script>
    <!-- Main js -->
    <script src="{{ asset('front/AlKout-Resturant/SiteAssets/js/style.js') }}"></script>

    <!-- include Gallery (lightbox) plugin js-->
    <script src="{{ asset('front/AlKout-Resturant/SiteAssets/lightbox/js/lightbox.min.js') }}"></script>

    <!-- include Owl Carousel plugin js-->
    <script src="{{ asset('front/AlKout-Resturant/SiteAssets/OwlCarousel2-2.3.4/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('front/AlKout-Resturant/SiteAssets/aos-master/dist/aos.js') }}"></script>
    <script>
        AOS.init();
    </script>
    <script>
        document.getElementById('productModal_v1').addEventListener('show.bs.modal', function() {
            this.setAttribute('aria-hidden', 'false');
        });

        document.getElementById('productModal_v1').addEventListener('hide.bs.modal', function() {
            this.setAttribute('aria-hidden', 'true');
        });

        // Function to update the cart count
        function fill_cart(id) {
            $.ajax({
                url: "{{ route('cart.dish-detail') }}",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for security
                },
                data: {
                    'id': id
                },
                success: function(data) {
                    let sizesHtml = '',
                        addonsHtml = '',
                        dishHtml = '';
                    var version = data.dish.has_size ? '_v1' : '_v2'

                    let modal = $(`#productModal${version}`);
                    $(`#currency_symbol${version}`).val(data.branch.currency_symbol);
                    // Generate sizes HTML
                    if (data.dish.has_size) {

                        for (const size of data.sizes) {
                            sizesHtml += `
                <div class="form-check">
                    <div>
                        <input class="form-check-input size-option" type="radio" name="size_option" id="size-${size.id}${version}" value="${size.price}" data-id="${size.id}"
                        ${size.default_size ? 'checked' : ''}>
                        <label class="form-check-label" for="size-${size.id}">
                            ${size.name}
                        </label>
                    </div>
                    <span>${size.price} ${data.branch.currency_symbol}</span>
                </div>
            `;
                        }

                    }

                    // Generate addons HTML
                    if (data.has_addon) {

                        for (const addon of data.addons) {
                            addonsHtml += `
                <div class="form-check">
                    <div>
                        <input class="form-check-input addon-option" type="checkbox" name="addons" id="addon-${addon.id}${version}" value="${addon.price}">
                        <label class="form-check-label" for="addon-${addon.id}">
                            ${addon.name}
                        </label>
                    </div>
                    <span>${addon.price} ${data.branch.currency_symbol}</span>
                </div>
            `;
                        }
                    }


                    let dishPrice = parseFloat(data.dish.price);
                    console.log(data.dish);

                    // Generate dish details HTML
                    dishHtml += `
            <h5>${data.dish.name}</h5>
            ${data.dish.mostOrdered ? `
                                                                                                                                                                                                <span class="badge bg-warning text-dark">
                                                                                                                                                                                                    <i class="fas fa-star"></i>
                                                                                                                                                                                                     الاكثر طلبا
                                                                                                                                                                                                </span>
                                                                                                                                                                                            ` : ''}
            <small class="text-muted d-block py-2">${data.dish.description}</small>
            <h4 class="fw-bold">
                <span class="total-price" data-unit-price="${dishPrice}" id="total-price${version}">
                    ${dishPrice.toFixed(2)}
                    ${data.branch.currency_symbol}
                </span>
            </h4>
            <div class="qty mt-3 d-flex justify-content-center align-items-center">
                <span class="pro-dec me-3" onclick="decreaseQuantity(this)">
                    <i class="fa fa-minus" aria-hidden="true"></i>
                </span>
                <span class="num fs-4">1</span>
                <span class="pro-inc ms-3" onclick="increaseQuantity(this)">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </span>
            </div>
        `;

                    // Set dish image and inject HTML
                    modal.find(`#dish-img${version}`).attr('src', data.dish.image);
                    modal.find(`#div-sizes${version}`).html(sizesHtml);
                    modal.find(`#div-addons${version}`).html(addonsHtml);
                    modal.find(`#div-detail${version}`).html(dishHtml);
                    modal.find(`#dish-total${version}`).html(
                        `${dishPrice.toFixed(2)} ${data.branch.currency_symbol}`);
                    modal.find(`#dish_id${version}`).val(data.dish.id);
                    // Function to recalculate total price
                    // Function to recalculate total price
                    function recalculateTotalPrice() {
                        let selectedSizePrice = parseFloat(modal.find('.size-option:checked')
                            .val()) || 0;
                        let price = 0;
                        let addonsPrice = 0;
                        if (selectedSizePrice) {
                            price = selectedSizePrice;
                        } else {
                            price = dishPrice;

                        }
                        // Calculate addons price
                        modal.find('.addon-option:checked').each(function() {
                            addonsPrice += parseFloat($(this).val());
                        });

                        let quantity = parseInt(modal.find('.num').text()) || 1;
                        let newTotalPrice = (price * quantity) + addonsPrice;

                        // Update total price in the total-price span
                        $(`#total-price${version}`).text(
                            `${newTotalPrice.toFixed(2)} ${data.branch.currency_symbol}`);

                        // Update the dish-price span
                        $(`#dish-total${version}`).text(
                            `${newTotalPrice.toFixed(2)} ${data.branch.currency_symbol}`);

                    }

                    // console.log(recalculateTotalPrice);

                    // Event listeners for size changes
                    // Event listeners for size changes
                    modal.find('.size-option').on('change', recalculateTotalPrice);

                    // Event listeners for addon changes
                    modal.find('.addon-option').on('change', recalculateTotalPrice);

                    // Event listeners for quantity changes
                    window.increaseQuantity = function(ele) {

                        let quantityElem = $(ele).siblings('.num');
                        let quantity = parseInt(quantityElem.text()) || 1;
                        quantity++;
                        quantityElem.text(quantity);
                        recalculateTotalPrice();
                    };

                    window.decreaseQuantity = function(ele) {
                        let quantityElem = $(ele).siblings('.num');
                        let quantity = parseInt(quantityElem.text()) || 1;
                        if (quantity > 1) {
                            quantity--;
                            quantityElem.text(quantity);
                            recalculateTotalPrice();
                        }
                    };


                    // Show the modal
                    modal.modal('show');

                },
                error: function(xhr, status, error) {
                    console.error('There was a problem with the AJAX request:', error);
                    alert('Failed to retrieve dish details. Please try again.');
                }
            });
        }
        $('.submit').on('click', function() {

            console.log("Button clicked");

            let id = $(this).attr('id');
            let parts = id.split('_'); // Split the string by the underscore '_'
            let version = '_' + parts[1];

            // Gather selected size
            const selectedSizePrice = $('#div-sizes_v1').find('.size-option:checked').val();

            const selectedSizeLabel = $('#div-sizes_v1').find('.size-option:checked').siblings('label').text();
            const selectedSizeId = $('#div-sizes_v1').find('.size-option:checked').data('id');

            // Gather selected addons
            const selectedAddons = [];
            $(this).find('.addon-option:checked').each(function() {
                selectedAddons.push({
                    id: $(this).attr('id'),
                    name: $(this).siblings('label').text(),
                    price: parseFloat($(this).val())
                });
            });

            // Get quantity
            const quantity = parseInt($('#div-detail_v2').find('.num').text()) || 1;

            // Additional notes
            const notes = $(`#note${version}`).val();
            const currency_symbol = $(`#currency_symbol${version}`).val();


            // Dish name and image
            const dishName = $(`#div-detail${version}`).find('h5').text().trim();
            const dish_id = $(`#dish_id${version}`).val();
            const dishImage = $(`#dish-img${version}`).attr('src');
            const dishPrice = parseFloat($(`#total-price${version}`).text());

            // Check if size is selected
            if (!selectedSizePrice && version === '_v1') {
                alert('Please select a size.');
                return;
            }

            // Create a cart item object
            const cartItem = {
                id: dish_id,
                name: dishName,
                image: dishImage,
                price: dishPrice,
                size: {
                    id: selectedSizeId,
                    price: selectedSizePrice,
                    label: selectedSizeLabel
                },
                addons: selectedAddons,
                quantity: quantity,
                notes: notes,
                totalPrice: dishPrice
            };


            // Get existing cart from localStorage
            let cart = JSON.parse(localStorage.getItem('cart')) || {
                items: [],
                coupon: '',
                coupon_value: 0,
                symbol: currency_symbol
            };

            // Add the new item to the cart's items array
            cart.items.push(cartItem);

            // Update notes (optional if specific to the session)
            cart.notes = notes;


            // Store updated cart in localStorage
            localStorage.setItem('cart', JSON.stringify(cart));

            // Redirect or notify the user
            // alert('Item added to cart!');
            window.location.href = '/cart'; // Change this to your cart page route
        });

        function updateCartCount() {
            // Get cart data from localStorage or default to an empty object
            let cart = JSON.parse(localStorage.getItem('cart')) || {
                items: []
            };
            // Check if cart has an items array and calculate the count
            let items = cart.items || []; // Safely access the items array
            let count = items.length; // Count the total number of items

            // Update the cart count in the DOM
            document.getElementById('cart-count').textContent = count;
        }


        // Call this function whenever the cart changes

        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('branchSearch');
            const branchItems = document.querySelectorAll('.branch-item');

            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.toLowerCase();

                branchItems.forEach((item) => {
                    const name = item.querySelector(
                            '.branch-name').textContent
                        .toLowerCase();
                    const address = item.querySelector(
                            '.branch-address').textContent
                        .toLowerCase();

                    if (name.includes(query) || address
                        .includes(query)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });


            updateCartCount();

        });
    </script>
    @if (session('showModal'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Show the modal
                const confirmOrderModal = new bootstrap.Modal(document.getElementById('successmodal'));
                confirmOrderModal.show();

                // Close the modal after 1 second
                setTimeout(() => {
                    confirmOrderModal.hide();
                }, 1000); // 1000ms = 1 second
            });
        </script>
    @endif
    @stack('scripts')
</body>

</html>
