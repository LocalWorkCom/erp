@extends('website.layouts.master')

@section('content')
    <main>
        <section class="inner-header pt-5 mt-5">
            <div class="container pt-sm-5 pt-4">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cart') }}"> عربة التسوق</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> الدفع </li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="checkout-page">
            <div class="container py-sm-5 py-4">
                <div class="row mx-0">
                    <form action="{{ route('web.order.add') }}" method="POST">
                        @csrf

                        <div class="col-md-8">
                            <div class="card my-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title fw-bold"> عنوان توصيل الطلب </h5>
                                </div>
                                <div class="card-body p-4" id="deliveryAddress">
                                    <!-- Dynamic content will be injected here -->
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title fw-bold"> اختر طريقة الدفع </h5>
                                </div>
                                <div class="card-body p-4">
                                    <div class="form-check">
                                        <label class="form-check-label" for="payment_method">
                                            <img src="SiteAssets/images/pay.png" alt="" />
                                            الدفع عند الاستلام
                                        </label>
                                        <input class="form-check-input" type="radio" value="cash" id="payment_method" name="payment_method"
                                            checked>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title fw-bold"> ملخص الطلب </h5>
                                </div>
                                <div class="card-body p-4" id="orderSummary">
                                    <!-- Dynamic content will be injected here -->
                                </div>
                                <div class="card-footer p-4">
                                    <div class="total">
                                        <p class="fw-bold"> المجموع الكلى </p>
                                        <p class="fw-bold" id="totalAmount">580 ج.م</p>
                                    </div>

                                </div>
                            </div>
                            <input type="hidden" name="cart_data" id="cartDataInput">

                            <button type="submit" class="btn w-100 mt-5">
                                تنفيذ الطلب
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <script>
        let cartData = JSON.parse(localStorage.getItem('cart')) || {};

        console.log(cartData);

        // Fetch cart data from localStorage
        if (cartData) {
            const cart = cartData.items;
            // console.log(cart);
            document.getElementById('cartDataInput').value = JSON.stringify(cartData);


            // Populate delivery address section
            const deliveryAddressContainer = document.getElementById('deliveryAddress');
            deliveryAddressContainer.innerHTML = `
            <input type='hidden' name='address_id' value='{{ $address->id }}'>
        <p class="fw-bold">
            <i class="fas fa-user main-color ms-2"></i>
            {{ auth('client')->user()->name }}
        </p>
        <p class="text-muted">
            <span>رقم الهاتف: </span> {{ $address->address_phone }}
        </p>
        <p class="fw-bold">
            <i class="fas fa-map-marker-alt main-color ms-2"></i>
           {{ $address->address }}
        </p>
        <p class="text-muted">
            {{ $address->building }} مصدق , الدور {{ $address->floor_number }} , شقة {{ $address->apartment_number }}
        </p>
        <p class="text-muted">
            علامة مميزة: {{ $address->notes }}  
        </p>
    `;
            const currency_symbol = cartData.symbol;

            const formatCurrency = (amount) => `${amount.toFixed(2)} ${currency_symbol}`;

            // Populate order summary section
            const orderSummaryContainer = document.getElementById('orderSummary');
            let totalPrice = 0;
            let discount = 0;
            let coupon_code = '';

            cart.forEach(item => {
                const itemAddons = item.addons || [];

                // const addonTotal = itemAddons.reduce((sum, addon) => sum + addon.price, 0);

                totalPrice += parseFloat(item.price * item.quantity);
                // console.log(totalPrice);

            });


            discount = cartData.coupon_value; // Coupon value            
            coupon_code = cartData.coupon; // Coupon value
            const deliveryFee = 0;
            const serviceFee = parseFloat('{{ getSetting('service_fees') }}') || 0;
            const TAX_RATE = parseFloat('{{ getSetting('tax_percentage') }}') / 100; // 14% VAT
            const tax = totalPrice * TAX_RATE;
            // console.log(tax);
            // console.log(currency_symbol);

            const finalTotal = totalPrice + serviceFee + deliveryFee + tax - discount + deliveryFee;



            orderSummaryContainer.innerHTML = `
    <ul class="list-unstyled p-0">
        <li class="order-list">
            <p>مجموع طلبي</p>
            <p class="fw-bold">${totalPrice}${currency_symbol}</p>
        </li>
        ${coupon_code ? `
                            <li class="order-list">
                                <p class="main-color">كوبون خصم
                                    <span id="code">${coupon_code}</span>
                                </p>
                                <p class="fw-bold main-color">${formatCurrency(discount)}</p>
                            </li>` : ''}
        <li class="order-list">
            <p>رسوم التوصيل</p>
            <p class="fw-bold">${formatCurrency(deliveryFee)}</p>
        </li>
        <li class="order-list">
            <p>رسوم الخدمة</p>
            <p class="fw-bold">${formatCurrency(serviceFee)}</p>
        </li>
        <li class="order-list">
            <p class="message bg-warning p-2 rounded-3">
                يشتمل على ضريبة القيمة المضافة %14 بمعني اخر
                <span id="tax">${formatCurrency(tax)}</span>
            </p>
        </li>
    </ul>
`;


            // Update total amount
            document.getElementById('totalAmount').innerText = `${formatCurrency(finalTotal)}`;
        }
    </script>
@endsection
