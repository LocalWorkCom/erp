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
                <div class="row mx-0">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title fw-bold"> الطلبات</h5>
                                <a href="{{ route('menu') }}" class="btn reversed main-color d-flex fw-bold" type="button">
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
                            <div class="card-body p-4">
                                <div class="notes">
                                    <h4 class="fw-bold">
                                        <i class="fas fa-file-alt main-color fa-xs"></i>
                                        وفرناها عليك
                                    </h4>
                                    <div class="my-3 d-flex ">
                                        <input type="text" class="form-control" placeholder="أدخل كوبون الخصم"
                                            id="coupon">
                                        <button type="submit" class="btn me-4">إضافة</button>
                                    </div>
                                </div>
                                <div class="notes mt-4">
                                    <h4 class="fw-bold">
                                        <i class="fas fa-file-alt main-color fa-xs"></i>
                                        هل لديك اى ملاحظات تود اضافتها ؟
                                    </h4>
                                    <div class="form-floating mt-3">
                                        <textarea class="form-control" placeholder="من فضلك اكتب ملاحظتك" id="floatingTextarea2" style="height: 100px"></textarea>
                                        <label for="floatingTextarea2">من فضلك اكتب ملاحظتك</label>
                                    </div>
                                </div>
                                <div class="my-3 d-flex justify-content-end ">
                                    <button type="submit" class="btn me-4">حفظ</button>
                                </div>
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
                                        <p class="fw-bold" id="total-before-coupon">
                                            550 ج.م
                                        </p>
                                    </li>

                                    <li class="order-list" id="coupon-div" style="display: none">
                                        <p class="main-color">
                                            كوبون خصم </p>
                                        <p class="fw-bold main-color" id="discount-value">
                                            -50 ج.م

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

                            </div>
                            <div class="card-footer p-4">
                                <div class="total">
                                    <p class="fw-bold">
                                        المجموع الكلى
                                    </p>
                                    <p class="fw-bold" id="total">
                                        580 ج.م
                                    </p>
                                </div>
                                <div class="message bg-warning p-2 rounded-3">
                                    <small>
                                        يشتمل على ضريبة القيمة المضافة 14% بمعنى آخر
                                        <span id="tax">
                                            29.23EGP
                                        </span>
                                    </small>
                                </div>

                            </div>
                        </div>
                        <a class="btn w-100 d-flex justify-content-between mt-5" href="{{ route('cart.checkout') }}">
                            <span> تابع الدفع <span class="me-2"> > </span>
                            </span>
                            <span id="total-pay">550 ج . م</span>
                        </a>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const addons = JSON.parse(localStorage.getItem('addons')) || []; // Retrieve the addons
            const cartContainer = document.getElementById('item-list');
            const totalElement = document.getElementById('total-before-coupon');
            const totalPayElement = document.getElementById('total-pay');
            const serviceFeeElement = document.getElementById('service-value');
            const shippingFeeElement = document.getElementById('shipping-value');
            const finalTotalElement = document.getElementById('total');
            const taxElement = document.getElementById('tax');

            const SERVICE_FEES = parseFloat('{{ getSetting('service_fees') }}') ||
                0; // Fetch service fees from settings
            const SHIPPING_FEES = 0; // Adjust this value or retrieve dynamically if needed
            const TAX_RATE = '{{ getSetting('tax_percentage') / 100 }}'; // 14% VAT

            const renderCart = () => {
                cartContainer.innerHTML = '';
                let total = 0;

                if (cart.length === 0) {
                    cartContainer.innerHTML = '<p class="text-center">عربة التسوق فارغة.</p>';
                    totalElement.textContent = '0 ج.م';
                    totalPayElement.textContent = '0 ج.م';
                    serviceFeeElement.textContent = `${SERVICE_FEES.toFixed(2)} ج.م`;
                    shippingFeeElement.textContent = `${SHIPPING_FEES.toFixed(2)} ج.م`;
                    finalTotalElement.textContent = '0 ج.م';
                    taxElement.textContent = '0 ج.م';
                    return;
                }

                cart.forEach((item, index) => {
                    // Calculate the size price and addon price for the item
                    const itemSizePrice = item.size['price'];
                    const itemAddons = item.addons || []; // Retrieve the specific addons for this item
                    let addonTotal = 0;

                    itemAddons.forEach(addon => {
                        addonTotal += addon.price; // Add the addon price
                    });

                    // Total price for the item including both size price and addon prices
                    const itemTotal = (item.quantity * itemSizePrice) + addonTotal;
                    total += itemTotal;

                    cartContainer.innerHTML += `
                <div class="sideCart-plate p-4 mb-4" data-index="${index}">
                    <div class="d-flex">
                        <a href="#">
                            <figure class="sideCart-plate-img m-0">
                                <img src="${item.image}" alt="${item.name}">
                            </figure>
                        </a>
                        <div class="cart-details pe-5">
                            <h5>${item.name}</h5>
                            <small class="text-muted">${item.notes || 'لا توجد ملاحظات'}</small>
                            <p>المقاس<span>${item.size.label}</span></p>
                            <div class="qty mt-3">
                                <span class="dec minus" data-index="${index}">
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </span>
                                <span class="num">${item.quantity}</span>
                                <span class="inc plus" data-index="${index}">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column justify-content-end">
                        <p class="fw-bold">${itemTotal.toFixed(2)} ج.م</p>
                        <div class="btns text-center">
                            <button class="btn reversed main-color mb-2 edit-item" data-index="${index}" type="button">تعديل</button>
                            <button class="btn mb-2 delete-item" data-index="${index}" type="button">حذف</button>
                        </div>
                    </div>
                </div>
            `;
                });

                // Calculate final total
                const tax = total * TAX_RATE;
                const finalTotal = total + SERVICE_FEES + SHIPPING_FEES + tax;

                // Update DOM elements
                totalElement.textContent = `${total.toFixed(2)} ج.م`;
                serviceFeeElement.textContent = `${SERVICE_FEES.toFixed(2)} ج.م`;
                shippingFeeElement.textContent = `${SHIPPING_FEES.toFixed(2)} ج.م`;
                finalTotalElement.textContent = `${finalTotal.toFixed(2)} ج.م`;
                taxElement.textContent = `${tax.toFixed(2)} ج.م`;
                totalPayElement.textContent = `${finalTotal.toFixed(2)} ج.م`;

                attachEventListeners();
            };

            const attachEventListeners = () => {
                document.querySelectorAll('.inc').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = this.getAttribute('data-index');
                        cart[index].quantity++;
                        localStorage.setItem('cart', JSON.stringify(cart));
                        renderCart();
                    });
                });

                document.querySelectorAll('.dec').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = this.getAttribute('data-index');
                        if (cart[index].quantity > 1) {
                            cart[index].quantity--;
                            localStorage.setItem('cart', JSON.stringify(cart));
                            renderCart();
                        }
                    });
                });

                document.querySelectorAll('.delete-item').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = this.getAttribute('data-index');
                        cart.splice(index, 1);
                        localStorage.setItem('cart', JSON.stringify(cart));
                        renderCart();
                    });
                });
            };

            renderCart();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const couponInput = document.getElementById('coupon');
            const applyCouponButton = document.querySelector('.btn[type="submit"]');
            const totalBeforeCouponElement = document.getElementById('total-before-coupon');
            const discountValueElement = document.getElementById('discount-value');
            const couponDiv = document.getElementById('coupon-div');
            const totalPayElement = document.getElementById('total-pay');
            const finalTotalElement = document.getElementById('total');

            applyCouponButton.addEventListener('click', function() {
                const couponCode = couponInput.value.trim();
                const totalBeforeCoupon = parseFloat(totalBeforeCouponElement.textContent);

                if (!couponCode) {
                    alert('Please enter a coupon code.');
                    return;
                }

                fetch('{{ route('cart.coupon-check') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            code: couponCode,
                            amount: totalBeforeCoupon,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const discount = totalBeforeCoupon - data
                            .data; // Assuming `data.data` is the amount after applying the coupon
                            couponDiv.style.display = 'block';
                            discountValueElement.textContent = `-${discount.toFixed(2)} ج.م`;
                            totalPayElement.textContent = `${data.data.toFixed(2)} ج.م`;
                            finalTotalElement.textContent = `${data.data.toFixed(2)} ج.م`;
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while applying the coupon.');
                    });
            });
        });
    </script>
@endpush
