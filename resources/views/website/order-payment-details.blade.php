@extends('website.layouts.master')

@section('content')
    <section class="inner-header pt-5 mt-5">
        <div class="container pt-sm-5 pt-4">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('header.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> @lang('header.myorder')</li>
                </ol>
            </nav>
        </div>
    </section>
    <section class="payment-details">
        <div class="container py-2">
            <h4 class="fw-bold "> @lang('header.myorder')</h4>
            <div class="card p-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between pt-3">
                        <h5 class="fw-bold m-0">
                            {{ $order->created_at->translatedFormat('j F .g:i A') }} </h5>
                        @if ($order->status == 'completed')
                            <p class="bg-warning text-dark rounded fw-bold p-1 mb-0">@lang('header.completed')</p>
                        @elseif ($order->status == 'cancelled')
                            <p class="bg-danger text-dark rounded fw-bold p-1 mb-0"> @lang('header.cancelled')</p>
                        @elseif ($order->status == 'pending')
                            <p class="bg-danger text-dark rounded fw-bold p-1 mb-0"> @lang('header.pending')</p>
                        @elseif ($order->status == 'inprogress')
                            <p class="bg-danger text-dark rounded fw-bold p-1 mb-0"> @lang('header.inprogress')</p>
                        @endif
                    </div>
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header py-2" id="panelsStayOpen-headingOne">
                                <button class="accordion-button p-0" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne">
                                    <h6 class="fw-bold">
                                        <i class="fas fa-file-alt main-color fa-xs"></i>
                                        تفاصيل الطلب @lang('header.orderdetails')
                                    </h6>
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body p-0">

                                    <ul class="list-unstyled p-0 mb-0">
                                        @foreach ($order->orderDetails as $detail)
                                            <li class="order-list">
                                                <p class="mb-0 py-1">
                                                    {{ $detail->quantity }} X {{ $detail->dish?->name ?? 'N/A' }}
                                                </p>
                                                @foreach ($order->orderAddons as $addon)
                                                    <small>
                                                        {{ $addon->Addon?->addons?->name ?? __('header.noaddons') }}
                                                    </small>
                                                @endforeach
                                                <p class="fw-bold mb-0 py-1">
                                                    {{ $order->total_price_after_tax }}
                                                    {{ $order->Branch->country->currency_symbol }} </p>
                                            </li>

                                        @endforeach

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
