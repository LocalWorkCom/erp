@extends('website.layouts.master')

@section('content')
    <section class="intro">
        <div class="container py-sm-5 py-4">
            <div class=" py-5 owl-slider owl-carousel owl-theme">
                @foreach ($sliders as $slider)
                    <div class="item">
                        <div class="row m-0 justify-content-center align-items-center">
                            <div class="col-md-6">
                                <h1 class="slide-title">{{ $slider->name_ar }}</h1>
                                <p class="slide-text my-5 ">
                                    {{ $slider->description_ar }}
                                </p>
                                <a href="#" class="btn">اطلب الان</a>
                            </div>
                            <div class="col-md-6">
                                <figure class="intro-img">
                                    <img src="{{ asset($slider->image ?? 'front\AlKout-Resturant\SiteAssets\images\logo-with-white-bg.png') }}"
                                        alt="">
                                </figure>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        <div class="container overflow-plates ">
            <div class="d-flex justify-content-between">

                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/overflow-left.png') }}" class="small-img right"
                    data-aos="zoom-in" />
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/overflow-plate.png') }}" class="big-img"
                    data-aos="zoom-in" />
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/overflow-right.png') }}" class="small-img left"
                    data-aos="zoom-in" />
            </div>
        </div>
    </section>
    <section class="categories pt-5">
        <div class="container px-0 py-sm-5 py-4">
            <div class="section-titles d-flex justify-content-between" data-aos="fade-down">
                <h2 class="fw-bold">استكشف القائمة</h2>
                <div class="section-btn">
                    <span class="ms-2">عرض الكل</span>
                    <span class="icon">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                </div>
            </div>
            <div class="categories-slider owl-carousel owl-theme">
                @foreach ($menuCategories as $menuCategory)
                    @if ($menuCategory->is_active && $menuCategory->dish_categories && $menuCategory->dish_categories->is_active)
                        <div class="item mb-4 category position-relative" data-aos="zoom-in">
                            <a href="#">
                                <figure class="category-img m-0">
                                    <img src="{{ asset($menuCategory->dish_categories->image_path ?? 'front\AlKout-Resturant\SiteAssets\images\logo-with-white-bg.png') }}"
                                        alt="{{ $menuCategory->dish_categories->name_ar }}">
                                    <figcaption class="pt-4">
                                        <h5>{{ $menuCategory->dish_categories->name_ar }}</h5>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    <section class="offers">
        <div class="container py-sm-5 py-4">
            <div class="section-titles d-flex justify-content-end mb-2" data-aos="fade-down">
                <a href="{{ route('menu') }}" class="section-btn text-decoration-none">
                    <span class="ms-2">عرض الكل</span>
                    <span class="icon">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                </a>
            </div>


            <div class="offers-slider owl-carousel owl-theme">
                @foreach ($discounts as $discount)
                    <div class="item mb-4 category position-relative" data-aos="zoom-in">
                        <div class="item three row mx-0 p-4" data-aos="zoom-in">
                            <div class="col-md-5">
                                <img class="offer-img"
                                    src="{{ asset($discount->dish->image ?? 'front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}"
                                    alt="">
                            </div>
                            <div class="col-md-7">
                                <h2 class="main-color fw-bold">خصم
                                    {{ $discount->discount->type == 'percentage' ? '%' : 'جنيه' }}{{ (int) $discount->discount->value }}
                                </h2>
                                <h5 class=" pb-4">{{ $discount->dish->name_ar }}</h5>
                                <a href="#" class="btn ">
                                    <h4 class="fw-bold">اطلب الان</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="plates">
        <div class="container py-sm-5 py-4">
            <h2 class="fw-bold" data-aos="fade-down">اشهر اطباقنا</h2>
            <p class="text-muted pt-4" data-aos="fade-down">
                وجبات متنوعه من المأكولات الكويتية يمكنك الطلب منها بكل سهولة
            </p>
            <div class="plates-slider owl-carousel owl-theme">
                @foreach ($popularDishes as $dish)
                    <div class="item mb-4" data-aos="zoom-in">
                        <div class="plate">
                            <a href="#">
                                <figure class="plate-img m-0">
                                    <img src="{{ asset($dish->image ?? 'front\AlKout-Resturant\SiteAssets\images\logo-with-white-bg.png') }}"
                                        alt="{{ $dish->name_ar }}">
                                </figure>
                            </a>
                            <div class="fav">
                                <form action="{{ route('add.favorite') }}" method="POST" class="favorite-form">
                                    @csrf
                                    <input type="hidden" name="dish_id" value="{{ $dish->id }}">
                                    <button type="submit" class="btn">
                                        <i class="{{ in_array($dish->id, $userFavorites) ? 'fas' : 'far' }} fa-heart"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="text-center pt-4">
                                <h5>{{ $dish->name_ar }}</h5>
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-star"></i>
                                    الاعلى تقييم
                                </span>
                                <div class="d-flex justify-content-between pt-4">
                                    <button class="btn add-to-cart-btn"onclick="fill_cart('{{ $dish->id }}')">
                                        + أضف الي العربة
                                    </button>
                                    <span> {{ $dish->price }} ج . م</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="info">
        <div class="container py-sm-5 py-4">
            <div class="row m-0 justify-content-cennter align-items-center">
                <div class="col-md-5 offset-md-1" data-aos="fade-left">
                    <h1 class="fw-bold">يمكنك الطلب اونلاين الان بكل سهولة</h1>
                    <p class="text-muted my-5 ">
                        في خلال بضعة دقائق ستتمكن من عمل طلبك وتتبعه من خلال موقعنا
                    </p>
                    <a href="#" class="btn btn-lg">اطلب الان</a>
                </div>
                <div class="col-md-6" data-aos="fade-right">
                    <figure class="info-img">
                        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/info.png') }}" alt="">
                    </figure>
                </div>
            </div>
        </div>

    </section>
    <section class="apps">
        <div class="container pt-sm-5 pt-4">
            <div class="row m-0 justify-content-cennter align-items-center text-center">
                <div class="col-md-6" data-aos="fade-left">
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
                <div class="col-md-6" data-aos="fade-right">
                    <img class="apps-img" src="{{ asset('front/AlKout-Resturant/SiteAssets/images/apps-img.png') }}" />
                </div>
            </div>
        </div>
    </section>
    @include('website.cart-modal')
@endsection
@push('scripts')
    <script>
        //test
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

                    // Generate sizes HTML
                    for (const size of data.sizes) {
                        sizesHtml += `
                <div class="form-check">
                    <div>
                        <input class="form-check-input size-option" type="radio" name="size_option" id="size-${size.id}" value="${size.price}" data-id="${size.id}"
                        ${size.default_size ? 'checked' : ''}>
                        <label class="form-check-label" for="size-${size.id}">
                            ${size.name}
                        </label>
                    </div>
                    <span>${size.price} ${data.branch.currency_symbol}</span>
                </div>
            `;
                    }

                    // Generate addons HTML
                    for (const addon of data.addons) {
                        addonsHtml += `
                <div class="form-check">
                    <div>
                        <input class="form-check-input addon-option" type="checkbox" name="addons" id="addon-${addon.id}" value="${addon.price}">
                        <label class="form-check-label" for="addon-${addon.id}">
                            ${addon.name} 
                        </label>
                    </div>
                    <span>${addon.price} ${data.branch.currency_symbol}</span>
                </div>
            `;
                    }

                    let dishPrice = parseFloat(data.dish.price);

                    // Generate dish details HTML
                    dishHtml += `
            <h5>${data.dish.name}</h5>
            ${data.dish.mostOrdered ? `
                                                            <span class="badge bg-warning text-dark">
                                                                <i class="fas fa-star"></i>
                                                                الاعلى تقييم
                                                            </span>
                                                        ` : ''}
            <small class="text-muted d-block py-2">${data.dish.description}</small>
            <h4 class="fw-bold">
                <span class="total-price" data-unit-price="${dishPrice}" id="total-price">
                    ${dishPrice.toFixed(2)}
                </span>
                ${data.branch.currency_symbol}
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
                    $('#productModal').find('#dish-img').attr('src', data.dish.image);
                    $('#productModal').find('#div-sizes').html(sizesHtml);
                    $('#productModal').find('#div-addons').html(addonsHtml);
                    $('#productModal').find('#div-detail').html(dishHtml);
                    $('#productModal').find('#dish-total').html(dishPrice.toFixed(2));
                    $('#productModal').find('#dish_id').val(data.dish.id);
                    // Function to recalculate total price
                    // Function to recalculate total price
                    function recalculateTotalPrice() {
                        let selectedSizePrice = parseFloat($('#productModal').find('.size-option:checked')
                            .val()) || 0;
                        let addonsPrice = 0;

                        // Calculate addons price
                        $('#productModal').find('.addon-option:checked').each(function() {
                            addonsPrice += parseFloat($(this).val());
                        });

                        let quantity = parseInt($('#productModal').find('.num').text()) || 1;
                        let newTotalPrice = (selectedSizePrice * quantity) + addonsPrice;

                        // Update total price in the total-price span
                        $('#total-price').text(newTotalPrice.toFixed(2));

                        // Update the dish-price span
                        $('#dish-total').text(newTotalPrice.toFixed(2));

                    }

                    // console.log(recalculateTotalPrice);

                    // Event listeners for size changes
                    // Event listeners for size changes
                    $('#productModal').find('.size-option').on('change', recalculateTotalPrice);

                    // Event listeners for addon changes
                    $('#productModal').find('.addon-option').on('change', recalculateTotalPrice);

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
                    $('#productModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('There was a problem with the AJAX request:', error);
                    alert('Failed to retrieve dish details. Please try again.');
                }
            });
        }
    </script>
@endpush
@push('scripts')
    <script>
        $('#submit').on('click', function() {

            // Gather selected size
            const selectedSizePrice = $('#productModal').find('.size-option:checked').val();
            const selectedSizeLabel = $('#productModal').find('.size-option:checked').siblings('label')
                .text();
            const selectedSizeId = $('#productModal').find('.size-option:checked').data('id');
            // Gather selected addons
            const selectedAddons = [];
            $('#productModal').find('.addon-option:checked').each(function() {
                selectedAddons.push({
                    id: $(this).attr('id'),
                    name: $(this).siblings('label').text(),
                    price: parseFloat($(this).val())
                });
            });

            // Get quantity
            const quantity = parseInt($('#productModal').find('.num').text()) || 1;

            // Additional notes
            const notes = $('#floatingTextarea2').val();

            // Dish name and image
            const dishName = $('#productModal').find('h5').text();
            const dish_id = $('#dish_id').val();
            const dishImage = $('#productModal').find('#dish-img').attr('src');
            const dishPrice = parseFloat($('#total-price').text());

            // Check if size is selected
            if (!selectedSizePrice) {
                alert('Please select a size.');
                return;
            }

            // Create a cart item object
            const cartItem = {
                id: dish_id, // Unique identifier for the item
                name: dishName,
                image: dishImage,
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
            const updatedCart = {
                items: cartItem, // Existing cart items
                coupon: '',
                coupon_value: 0,
                notes: notes,
            };

            // Get existing cart from localStorage
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Add the new item to the cart
            cart.push(updatedCart);

            // Store updated cart in localStorage
            localStorage.setItem('cart', JSON.stringify(cart));

            // Redirect or notify the user
            // alert('Item added to cart!');
            window.location.href = '/cart'; // Change this to your cart page route
        });
    </script>
@endpush
