@extends('website.layouts.master')

@section('content')
<section class="inner-header pt-5 mt-5">
    <div class="container pt-sm-5 pt-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page"> طلباتى</li>
            </ol>
        </nav>
    </div>
</section>
<section class="payment-details">
    <div class="container py-2">
        <h4 class="fw-bold "> طلباتى</h4>
        <div class="card p-4">
            <div class="card-body">
                <div class="d-flex justify-content-between pt-3">
                    <h5 class="fw-bold m-0">
                        8 ديسمبر .8:50 م
                    </h5>
                    <p class="bg-grey text-dark rounded fw-bold p-1 mb-0">يتم تحضير الطلب </p>
                </div>
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header py-2" id="panelsStayOpen-headingOne">
                            <button class="accordion-button p-0" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                aria-controls="panelsStayOpen-collapseOne">
                                <h6 class="fw-bold">
                                    <i class="fas fa-file-alt main-color fa-xs"></i>
                                    تفاصيل الطلب
                                </h6>
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                            aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body p-0">

                                <ul class="list-unstyled p-0 mb-0">
                                    <li class="order-list">
                                        <p class="mb-0 py-1">
                                            1 X مجبوس دجاج
                                        </p>
                                        <p class="fw-bold mb-0 py-1">
                                            142.99 ج .م
                                        </p>
                                    </li>
                                    <li class="order-list">
                                        <small class="text-muted py-1 d-block"> نص فرخة </small>
                                    </li>
                                    <li class="order-list">
                                        <small class="text-muted py-1 d-block"> اضافة ( دقوس ,جبنه)</small>
                                    </li>
                                    <li class="order-list">
                                        <small class="text-muted py-1 d-block"> ملاحظات: بدون اضافة بصل </small>
                                    </li>
                                    <li class="order-list">
                                        <p class="mb-0">
                                            مجموع طلبي
                                        </p>
                                        <p class="mb-0 py-1">
                                            1550 ج.م
                                        </p>
                                    </li>
                                    <li class="order-list">
                                        <p class="mb-0">
                                            رسوم التوصيل
                                        </p>
                                        <p class="mb-0 py-1">
                                            140 ج.م
                                        </p>
                                    </li>
                                    <li class="order-list">
                                        <p class="mb-0">
                                            رسوم الخدمة
                                        </p>
                                        <p class="mb-0 py-1">
                                            220 ج.م
                                        </p>
                                    </li>

                                </ul>
                                <p class="mb-0">
                                    يشتمل على ضريبة القيمة المضافة
                                    <span class="main-color fw-bold"> 14% </span>
                                    بمعنى آخر
                                    29.23EGP
                                </p>
                                <ul class="list-unstyled p-0 mb-0">
                                    <li class="order-list">
                                        <p class="mb-0">
                                            طريقة الدفع
                                        </p>
                                        <p class="mb-0 py-1">
                                            نقدا
                                        </p>
                                    </li>
                                    <li class="order-list">
                                        <p class="mb-0">
                                            وقت التوصيل
                                        </p>
                                        <p class="mb-0 py-1">
                                            38 دقيقة
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
