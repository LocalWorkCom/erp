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
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title fw-bold"> تفاصيل الدفع </h5>
                                <button class="btn reversed main-color fw-bold" type="button">
                                    تعديل
                                </button>
                            </div>
                            <div class="card-body p-4">
                                <h5 class="fw-bold">
                                    <i class="fas fa-user main-color ms-2"></i>
                                    تقى رأفت
                                </h5>
                                <p class="text-muted">
                                    <span>رقم الهاتف:
                                    </span> 01029061189
                                </p>
                            </div>
                        </div>
                        <div class="card my-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title fw-bold"> عنوان توصيل الطلب </h5>
                                <button class="btn reversed main-color fw-bold" type="button">
                                    تعديل
                                </button>
                            </div>
                            <div class="card-body p-4">
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

                                    <input class="form-check-input" type="radio" value="" id="paying">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title fw-bold"> ملخص الطلب </h5>
                            </div>
                            <div class="card-body p-4">
                                <ul class="list-unstyled p-0">
                                    <li class="order-list">
                                        <p>
                                            مجموع طلبي
                                        </p>
                                        <p class="fw-bold">
                                            550 ج.م
                                        </p>
                                    </li>
                                    <li class="order-list">
                                        <p class="main-color">
                                            كوبون خصم </p>
                                        <p class="fw-bold main-color">
                                            -50 ج.م
                                        </p>
                                    </li>
                                    <li class="order-list">
                                        <p>
                                            رسوم التوصيل
                                        </p>
                                        <p class="fw-bold">
                                            40 ج.م
                                        </p>
                                    </li>
                                    <li class="order-list">
                                        <p>
                                            رسوم الخدمة
                                        </p>
                                        <p class="fw-bold">
                                            40 ج.م
                                        </p>
                                    </li>
                                </ul>

                            </div>
                            <div class="card-footer p-4">
                                <div class="total">
                                    <p class="fw-bold">
                                        المجموع الكلى
                                    </p>
                                    <p class="fw-bold">
                                        580 ج.م
                                    </p>
                                </div>
                                <div class="message bg-warning p-2 rounded-3">
                                    <small>
                                        يشتمل على ضريبة القيمة المضافة 14% بمعنى آخر 29.23EGP
                                    </small>
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
@endsection
