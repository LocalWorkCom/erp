@extends('website.layouts.master')

@section('content')
    <main>
        <section class="inner-header pt-5 mt-5">
            <div class="container pt-sm-5 pt-4">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('menu') }}">قائمة الطعام</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> عربة التسوق</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="cart-page">
            <div class="container py-sm-5 py-4">
                <form action="">

                    <div class="row mx-0">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title fw-bold"> الطلبات</h5>
                                    <a href="{{ route('menu') }}" class="btn reversed main-color d-flex fw-bold"
                                        type="button">
                                        <span class="inc ms-2">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </span>
                                        إضافةعنصر
                                    </a>

                                </div>
                                <div class="card-body p-4" id="item-list">

                                </div>
                            </div>
                            <div class="card mt-4">
                                <div class="card-body p-4" id="note-div">
                                    <div class="coupons">
                                        <h4 class="fw-bold">
                                            <i class="fas fa-file-alt main-color fa-xs"></i>
                                            وفرناها عليك
                                        </h4>
                                        <div class="my-3 d-flex">
                                            <input type="text" class="form-control" placeholder="أدخل كوبون الخصم"
                                                id="coupon">
                                            <button type="button" class="btn me-4" id="apply-coupon-btn">إضافة</button>
                                            <button type="button" class="btn btn-danger me-4 d-none"
                                                id="remove-coupon-btn">إزالة</button>
                                        </div>
                                    </div>
                                    <div class="notes mt-4">
                                        <h4 class="fw-bold">
                                            <i class="fas fa-file-alt main-color fa-xs"></i>
                                            هل لديك اى ملاحظات تود اضافتها ؟
                                        </h4>
                                        <div class="form-floating mt-3">
                                            <textarea class="form-control" placeholder="من فضلك اكتب ملاحظتك" id="note-order" style="height: 100px"></textarea>
                                        </div>
                                    </div>
                                    {{-- <div class="my-3 d-flex justify-content-end">
                                        <button type="submit" class="btn me-4">حفظ</button>
                                    </div> --}}
                                </div>
                            </div>



                        </div>
                        <div class="col-md-4">
                            @auth('client')
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title fw-bold"> موقع التوصيل </h5>
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
                            @endauth
                            <div class="card mt-4" id="card-payment">
                                <div class="card-header">
                                    <h5 class="card-title fw-bold"> ملخص الطلب </h5>
                                </div>
                                <div class="card-body p-4">
                                    <ul class="list-unstyled p-0">
                                        <li class="order-list">
                                            <p>
                                                مجموع طلبي
                                            </p>
                                            <p class="fw-bold" id="total-before-coupon">
                                                0 ج.م
                                            </p>
                                        </li>

                                        <li class="order-list d-none" id="coupon-div">
                                            <p class="main-color">
                                                كوبون خصم
                                                <span id="code"></span>
                                            </p>

                                            <p class="fw-bold main-color" id="discount-value">
                                                0 ج.م

                                            </p>
                                        </li>
                                        <li class="order-list" id="shipping-div">
                                            <p>
                                                رسوم التوصيل
                                            </p>
                                            <p class="fw-bold" id="shipping-value">
                                                0 ج.م
                                            </p>
                                        </li>
                                        <li class="order-list" id="">
                                            <p>
                                                رسوم الخدمة
                                            </p>
                                            <p class="fw-bold" id="service-value">
                                                {{ getSetting('service_fees') }} ج.م
                                            </p>
                                        </li>
                                    </ul>
                                    <div class="message bg-warning p-2 rounded-3">
                                        <small>
                                            يشتمل على ضريبة القيمة المضافة 14% بمعنى آخر
                                            <span id="tax">
                                                0 ج.م
                                            </span>
                                        </small>
                                    </div>
                                </div>
                                <div class="card-footer p-4">
                                    <div class="total">
                                        <p class="fw-bold">
                                            المجموع الكلى
                                        </p>
                                        <p class="fw-bold" id="total">
                                            0 ج.م
                                        </p>
                                    </div>


                                </div>
                            </div>
                            <a class="btn w-100 d-flex justify-content-between mt-5" href="#" id="checkout-btn">
                                <span> تابع الدفع <span class="me-2"> > </span>
                                </span>
                                <span id="total-pay"> 0 ج.م
                                </span>
                            </a>
                        </div>

                    </div>
                </form>

            </div>
        </section>
    </main>
    @include('website.cart-modal')
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            let local_storage = JSON.parse(localStorage.getItem('cart')) || {};
            let cart = local_storage.items; // Extract all items from the array

            // const addons = JSON.parse(localStorage.getItem('addons')) || []; // Retrieve addons
            const cartContainer = $('#item-list');
            const totalElement = $('#total-before-coupon');
            const totalPayElement = $('#total-pay');
            const serviceFeeElement = $('#service-value');
            const shippingFeeElement = $('#shipping-value');
            const finalTotalElement = $('#total');
            const taxElement = $('#tax');
            const applyCouponButton = document.getElementById('apply-coupon-btn');
            const couponInput = document.getElementById('coupon');
            const removeCouponBtn = document.getElementById('remove-coupon-btn');
            const couponDiv = document.getElementById('coupon-div');
            const checkoutButton = $('#checkout-btn'); // Replace with your actual checkout button ID
            const SERVICE_FEES = parseFloat('{{ getSetting('service_fees') }}') ||
                0; // Fetch service fees from settings
            const SHIPPING_FEES = 0; // Adjust this value or retrieve dynamically if needed
            const TAX_RATE = parseFloat('{{ getSetting('tax_percentage') }}') / 100; // 14% VAT
            const coupon_application = parseFloat('{{ getSetting('coupon_application') }}') / 100; // 14% VAT

            // Helper function to format numbers
            const formatCurrency = (amount) => `${amount.toFixed(2)} ج.م`;

            // Helper function to render the cart
            const renderCart = () => {
                cartContainer.empty();
                let total = 0;

                if (!Array.isArray(cart) || cart.length === 0) { // Check if cart is a valid array
                    cartContainer.html('<p class="text-center">عربة التسوق فارغة.</p>');
                    updateCartSummary(0);
                    $('#card-payment').addClass('d-none');
                    $('#checkout-btn').addClass('d-none');
                    $('#note-div').addClass('d-none');
                    return;
                }

                cart.forEach((item, index) => {
                    const itemSizePrice = item.size.price;
                    const itemAddons = item.addons || [];
                    const addonTotal = itemAddons.reduce((sum, addon) => sum + addon.price, 0);
                    const itemTotal = (item.quantity * itemSizePrice) + addonTotal;
                    total += itemTotal;

                    cartContainer.append(`
                        <div class="sideCart-plate p-4 mb-4" data-index="${index}">
                            <div class="d-flex">
                                <a href="#">
                                    <figure class="sideCart-plate-img m-0">
                                        <img src="${item.image}" alt="${item.name}">
                                    </figure>
                                </a>
                                <div class="cart-details pe-5">
                                    <h5>${item.name}</h5>
                                    <small class="text-muted d-block"><span>الحجم:</span> ${item.size.label}</small>
                                    <small class="text-muted d-block"><span>إضافة:</span> ${itemAddons.map(addon => addon.name).join(', ') || 'لا يوجد إضافات'}</small>
                                    <small class="text-muted d-block"><span>ملاحظات:</span> ${item.notes || 'لا توجد ملاحظات'}</small>
                                    <div class="qty mt-3">
                                        <span class="dec minus" data-index="${index}"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                        <span class="num">${item.quantity}</span>
                                        <span class="inc plus" data-index="${index}"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-end">
                                <p class="fw-bold">${formatCurrency(itemTotal)}</p>
                                <div class="btns text-center">
                                    <button class="btn reversed main-color mb-2 edit-item" data-index="${index}" type="button">تعديل</button>
                                    <button class="btn mb-2 delete-item" data-index="${index}" type="button">حذف</button>
                                </div>
                            </div>
                        </div>
                    `);
                });

                if (local_storage.coupon) {
                    couponDiv.classList.remove('d-none');
                    couponInput.value = local_storage.coupon;
                    $('#code').html(`${local_storage.coupon}`);
                    applyCouponButton.disabled = true;
                    couponInput.disabled = true;

                    $('#discount-value').text(`-${local_storage.coupon_value.toFixed(2)} ج.م`);

                    removeCouponBtn.classList.remove('d-none');
                }
                if (local_storage.note) {
                    $('note-order').html(local_storage.note);
                }

                updateCartSummary(total, local_storage.coupon_value);
            };

            // Helper function to update the cart summary
            const updateCartSummary = (total, coupon) => {
                let tax = 0;
                // 0 before tax
                // 1 after tax 
                // if (coupon_application) {

                //     tax = (total - coupon) * TAX_RATE;
                // } else {
                tax = total * TAX_RATE;

                // }

                const finalTotal = total - coupon + SERVICE_FEES + SHIPPING_FEES + tax;

                totalElement.text(formatCurrency(total));
                serviceFeeElement.text(formatCurrency(SERVICE_FEES));
                shippingFeeElement.text(formatCurrency(SHIPPING_FEES));
                finalTotalElement.text(formatCurrency(finalTotal));
                taxElement.text(formatCurrency(tax));
                totalPayElement.text(formatCurrency(finalTotal));
            };

            function recalculateTotalPrice() {
                let selectedSizePrice = parseFloat($('#productModal').find('.size-option:checked')
                    .val()) || 0;
                let addonsPrice = 0;

                // Calculate addons price
                $('#productModal').find('.addon-option:checked').each(function() {
                    addonsPrice += parseFloat($(this).val());
                });

                console.log(addonsPrice);

                let quantity = parseInt($('#productModal').find('.num').text()) || 1;
                let newTotalPrice = (selectedSizePrice * quantity) + addonsPrice;

                // Update total price in the total-price span
                $('#total-price').text(newTotalPrice.toFixed(2));

                // Update the dish-price span
                $('#dish-total').text(newTotalPrice.toFixed(2));

            }
            // Helper function to update localStorage and re-render the cart
            const updateCart = () => {
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
            };
            // Attach event listeners
            $(document).on('click', '.inc', function() {

                const index = $(this).data('index');
                cart[index].quantity++;
                updateCart();
            });
            $(document).on('click', '.dec', function() {

                const index = $(this).data('index');
                if (cart[index].quantity > 1) {
                    cart[index].quantity--;
                    updateCart();
                }
            });
            $(document).on('click', '.delete-item', function() {

                const index = $(this).data('index');
                cart.splice(index, 1);
                updateCart();
            });

            $(document).on('click', '.edit-item', function() {

                const index = $(this).data('index');
                const item = cart[index];

                editItem(item, index);
            });
            checkoutButton.on('click', function(e) {
                e.preventDefault(); // Prevent default form submission or navigation
                updateCartBeforeCheckout();
                const isAuthenticated = @json(auth('client')->check());

                // Check if the user is logged in
                if (!isAuthenticated) {
                    // Trigger the login modal if the user is not logged in
                    const loginModal = document.querySelector('#loginModal');
                    if (loginModal) {
                        const modalInstance = new bootstrap.Modal(loginModal);
                        $('#msg-error').show();
                        modalInstance.show();
                    } else {
                        console.error('Login modal not found.');
                    }
                } else {
                    // Redirect to the checkout route if the user is logged in
                    window.location.href = "{{ route('cart.checkout') }}";
                }

            });




            const updateCartBeforeCheckout = () => {
                // Get coupon details
                const couponValueText = $('#discount-value').text().trim();

                const couponCode = couponInput.value.trim() || null;
                const couponValue = couponValueText ?
                    Math.abs(parseFloat(couponValueText.replace(/[^\d.-]/g, ''))) // Extract numeric value
                    :
                    0;
                // Get notes
                const notes = $('#note-order').val().trim();

                // Update cart object with additional data
                const updatedCart = {
                    items: cart, // Existing cart items
                    coupon: couponCode,
                    coupon_value: couponValue,
                    notes: notes,
                };

                // Save updated cart to localStorage
                localStorage.setItem('cart', JSON.stringify(updatedCart));

                console.log('Cart updated before checkout:', updatedCart);
            };

            const removeCoupon = () => {
                // Reset the coupon input field and re-enable it
                couponInput.value = '';
                couponInput.disabled = false;

                // Re-enable the apply coupon button
                applyCouponButton.disabled = false;

                // Hide the remove button
                removeCouponBtn.classList.add('d-none');

                couponDiv.classList.add('d-none');

                renderCart();


                Swal.fire({
                    icon: 'info',
                    title: 'تم الإزالة',
                    text: 'تم إزالة الكوبون وإعادة الحسابات.',
                });
            };
            // AJAX call for editing item
            const editItem = (item, index) => {
                $.ajax({
                    url: "{{ route('cart.dish-detail') }}",
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: item.id
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            const product = data.dish;
                            const dishPrice = parseFloat(item.totalPrice);
                            let dishHtml = `
                        <h5>${product.name}</h5>
                        ${product.mostOrdered ? `<span class="badge bg-warning text-dark"><i class="fas fa-star"></i> الاعلى تقييم</span>` : ''}
                        <small class="text-muted d-block py-2">${product.description}</small>
                        <h4 class="fw-bold">
                            <span class="total-price" data-unit-price="${dishPrice}" id="total-price">${dishPrice.toFixed(2)}</span>
                            ${data.branch.currency_symbol}
                        </h4>
                        <div class="qty mt-3 d-flex justify-content-center align-items-center">
                            <span class="pro-dec me-3" onclick="decreaseQuantity(this)"><i class="fa fa-minus" aria-hidden="true"></i></span>
                            <span class="num fs-4">${item.quantity}</span>
                            <span class="pro-inc ms-3" onclick="increaseQuantity(this)"><i class="fa fa-plus" aria-hidden="true"></i></span>
                        </div>
                    `;
                            $('#dish-id').val(product.id);
                            $('#dish-img').attr('src', product.image);
                            $('#div-detail').html(dishHtml);
                            $('#floatingTextarea2').val(item.notes || '');

                            populateSizes(data.sizes, item, data.branch.currency_symbol);
                            populateAddons(data.addons, item, data.branch.currency_symbol);

                            // const itemTotal = (item.quantity * item.size.price) + item.addons
                            //     .reduce((sum, addon) => sum + addon.price, 0);
                            // $('#dish-total').text(
                            //     `${itemTotal.toFixed(2)} ${data.branch.currency_symbol}`);
                            // $('#dish-quantity').text(`+ أضف إلي العربة (${item.quantity})`);
                            $('#submit').off('click').on('click', function() {
                                saveChanges(index);
                            });
                            $('#productModal').modal('show');
                        } else {
                            alert('Failed to fetch product details.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while fetching the product details.');
                    }
                });
            };
            const applyCoupon = () => {
                const couponCode = $('#coupon').val().trim();
                const totalBeforeCoupon = parseFloat(totalElement.text());

                if (!couponCode) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'من فضلك أدخل كود الكوبون!',
                    });
                    return;
                }
                if (couponCode === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'من فضلك أدخل كود الكوبون!',
                    });
                    return;
                }

                $.ajax({
                    url: '{{ route('cart.coupon-check') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        code: couponCode,
                        amount: totalBeforeCoupon
                    },
                    success: function(data) {
                        if (data.success) {
                            setTimeout(() => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'تم بنجاح!',
                                    text: 'تم تطبيق الكوبون بنجاح!',
                                });

                                // Disable the button after applying the coupon
                                applyCouponButton.disabled = true;
                                couponInput.disabled = true;
                                removeCouponBtn.classList.remove('d-none');

                            }, 500); // Simulate a short delay for user experience

                            const discountedTotal = data.data;
                            const discount = totalBeforeCoupon - discountedTotal;

                            const tax = discountedTotal * TAX_RATE;
                            const finalTotal = discountedTotal + SERVICE_FEES + SHIPPING_FEES + tax;

                            couponDiv.classList.remove('d-none');
                            $('#discount-value').text(`-${discount.toFixed(2)} ج.م`);
                            totalElement.text(`${discountedTotal.toFixed(2)} ج.م`);
                            taxElement.text(`${tax.toFixed(2)} ج.م`);
                            serviceFeeElement.text(`${SERVICE_FEES.toFixed(2)} ج.م`);
                            shippingFeeElement.text(`${SHIPPING_FEES.toFixed(2)} ج.م`);
                            totalPayElement.text(`${finalTotal.toFixed(2)} ج.م`);
                            finalTotalElement.text(`${finalTotal.toFixed(2)} ج.م`);
                        } else {
                            alert(data.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while applying the coupon.');
                    }
                });
            };

            const populateSizes = (sizes, item, currencySymbol) => {
                const sizesContainer = $('#div-sizes');
                sizesContainer.empty();

                sizes.forEach(size => {
                    sizesContainer.append(`
                        <div class="form-check">
                            <input class="form-check-input size-option" type="radio" name="size_option" id="size-${size.id}" value="${size.price}" ${item.size.id === size.id ? 'checked' : ''}>
                                <label class="form-check-label" for="size-${size.id}">${size.name}</label>
                                <span>${size.price} ${currencySymbol}</span>
                            </div>
                    `);
                });

                // Rebind the change event for sizes
                $('#div-sizes .size-option').on('change', recalculateTotalPrice);
            };

            // Helper function to populate addons
            const populateAddons = (addons, item, currencySymbol) => {
                const addonsContainer = $('#div-addons');
                addonsContainer.empty();

                addons.forEach(addon => {
                    const isSelected = item.addons.some(selectedAddon => selectedAddon.id ===
                        `addon-${addon.id}`);

                    addonsContainer.append(`
                        <div class="form-check">
                            <input class="form-check-input addon-option" type="checkbox" id="addon-${addon.id}" value="${addon.price}" ${isSelected ? 'checked' : ''}>
                                <label class="form-check-label" for="addon-${addon.id}">${addon.name}</label>
                                <span>${addon.price} ${currencySymbol}</span>
                            </div>
                    `);
                });

                // Rebind the change event for addons
                $('#div-addons .addon-option').on('change', recalculateTotalPrice);
            };
            // Apply coupon functionality

            const saveChanges = (itemIndex) => {
                const updatedSize = $('#div-sizes .size-option:checked').val();
                const updatedAddons = [];
                $('#div-addons .addon-option:checked').each(function() {
                    updatedAddons.push({
                        id: $(this).attr('id').replace('addon-', ''), // Extract addon ID
                        price: parseFloat($(this).val()),
                        name: $(this).next('label').text()
                    });
                });

                const updatedNotes = $('#floatingTextarea2').val();
                const updatedQuantity = parseInt($('#productModal .num').text()) || 1;

                cart[itemIndex].size.price = parseFloat(updatedSize) || cart[itemIndex].size.price;
                cart[itemIndex].addons = updatedAddons;
                cart[itemIndex].notes = updatedNotes;
                cart[itemIndex].quantity = updatedQuantity;

                // Save to localStorage and re-render the cart
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();

                $('#productModal').modal('hide');
            };
            renderCart();
            removeCouponBtn.addEventListener('click', removeCoupon);
            applyCouponButton.addEventListener('click', applyCoupon);

        });
        // Bind the update function to the checkout button
    </script>
@endpush
