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
                                    <label class="form-check-label" for="paying">
                                        <img src="SiteAssets/images/pay.png" alt="" />
                                        الدفع عند الاستلام
                                    </label>
                                    <input class="form-check-input" type="radio" value="" id="paying" checked>
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
                        <button class="btn w-100 mt-5" data-bs-toggle="modal" data-bs-target="#confirmOrder">
                            تنفيذ الطلب
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        const formatCurrency = (amount) => `${amount.toFixed(2)} ج.م`;

        // Fetch cart data from localStorage
        const cartData = localStorage.getItem('cart');
        if (cartData) {
            const cart = JSON.parse(cartData);

            // Populate delivery address section
            const deliveryAddressContainer = document.getElementById('deliveryAddress');
            deliveryAddressContainer.innerHTML = `
        <p class="fw-bold">
            <i class="fas fa-user main-color ms-2"></i>
            تقى رأفت
        </p>
        <p class="text-muted">
            <span>رقم الهاتف: </span> 01029061189
        </p>
        <p class="fw-bold">
            <i class="fas fa-map-marker-alt main-color ms-2"></i>
            مصدق الدقى و المهندسين وجيزه
        </p>
        <p class="text-muted">
            121 مصدق , الدور 2 , شقة 12
        </p>
        <p class="text-muted">
            علامة مميزة: امام ماركت الصفا
        </p>
    `;

            // Populate order summary section
            const orderSummaryContainer = document.getElementById('orderSummary');
            let totalPrice = 0;
            let discount = 0;
            let coupon_code = '';

            cart.items.forEach(item => {
                const itemAddons = item.addons || [];

                // const addonTotal = itemAddons.reduce((sum, addon) => sum + addon.price, 0);

                totalPrice += parseFloat(item.totalPrice);
            });

            discount = cart.coupon_value; // Coupon value
            coupon_code = cart.coupon; // Coupon value
            const deliveryFee = 0;
            const serviceFee = parseFloat('{{ getSetting('service_fees') }}') || 0;
            const TAX_RATE = parseFloat('{{ getSetting('tax_percentage') }}') / 100; // 14% VAT
            const tax = totalPrice * TAX_RATE;
            console.log(tax);
            
            const finalTotal = totalPrice + serviceFee + deliveryFee + tax - discount + deliveryFee;



            orderSummaryContainer.innerHTML = `
        <ul class="list-unstyled p-0">
            <li class="order-list">
                <p>مجموع طلبي</p>
                <p class="fw-bold">${totalPrice} ج.م</p>
            </li>
            <li class="order-list">
                <p class="main-color">كوبون خصم
                                                                    <span id="code">${coupon_code}
                                                                        </span>
</p>
                <p class="fw-bold main-color">${discount} ج.م</p>
            </li>
            <li class="order-list">
                <p>رسوم التوصيل</p>
                <p class="fw-bold">${deliveryFee} ج.م</p>
            </li>
            <li class="order-list">
                <p>رسوم الخدمة</p>
                <p class="fw-bold">${serviceFee} ج.م</p>
            </li>
                    <li class="order-list">
                                <p class="message bg-warning p-2 rounded-3"> يشتمل على ضريبة القيمة المضافة %14
                                   بمعني اخر 
                                      <span id="tax">
                                                ${formatCurrency(tax)} ج.م
                                        </span> 
                                </p>
                    </li>
        </ul>
    `;

            // Update total amount
            document.getElementById('totalAmount').innerText = `${finalTotal} ج.م`;
        }
    </script>
@endsection
