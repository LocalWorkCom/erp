@extends('layouts.master')

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('order.show')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('order.orders')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('order.show')</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- APP-CONTENT START -->
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Start:: row-1 -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>تفاصيل الطلب</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-4">
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('order.date')</label>
                                    <p class="form-text">{{ $order->date }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.order_number')</label>
                                    <p class="form-text">{{ $order->order_number }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.invoice_num')</label>
                                    <p class="form-text">{{ $order->invoice_number }}</p>
                                </div>

                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('order.branch')</label>
                                    <p class="form-text">{{ $order->branch->name_ar }}</p>
                                </div>

                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('order.type')</label>
                                    <p class="form-text"> <span class="badge bg-primary-transparent">
                                            @lang('order.' . strtolower($order->type))</span></p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('order.status')</label>
                                    <p class="form-text"> <span class="badge bg-warning-transparent">
                                            @lang('order.' . strtolower($order->status))</span></p>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.total_price')</label>
                                    <p class="form-text">{{ $order->total_price_after_tax }}</p>
                                </div>
                                <h4>تفاصيل العميل</h4>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('order.client')</label>
                                    <p class="form-text">{{ $order->client->name }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('order.phone')</label>
                                    <p class="form-text">{{ $order->client->phone }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('order.email')</label>
                                    <p class="form-text">{{ $order->client->email }}</p>
                                </div>
                                <h4>تفاصيل العنوان</h4>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('order.city')</label>
                                    <p class="form-text">{{ $order->address->city }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('order.state')</label>
                                    <p class="form-text">{{ $order->address->state }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('order.address')</label>
                                    <p class="form-text">{{ $order->address->address }}</p>
                                </div>


                                <h4>تفاصيل الدفع </h4>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.status_paid')</label>
                                    <p class="form-text"> <span class="badge bg-primary-transparent">
                                            @lang('order.' . strtolower($order['transaction']['payment_status']))</span></p>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.payment_method')</label>
                                    <p class="form-text"> <span class="badge bg-primary-transparent">
                                            @lang('order.' . strtolower($order['transaction']['payment_method']))</span></p>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.paid')</label>
                                    <p class="form-text"> <span class="badge bg-primary-transparent">
                                            {{ $order['transaction']['paid'] }}</span></p>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.status_paid')</label>
                                    <p class="form-text">
                                        <span class="badge bg-primary-transparent">
                                            {{ $order['transaction']['is_refund'] ? __('order.refund') : __('order.purchase') }}
                                        </span>
                                    </p>
                                </div>

                                <h4>الاطباق</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>@lang('order.dish')</th>
                                            <th>@lang('order.total_before_tax')</th>
                                            <th>@lang('order.tax')</th>
                                            <th>@lang('order.total_after_tax')</th>
                                            <th>@lang('order.total_price')</th>
                                            <th>@lang('order.quantity')</th>
                                            <th>@lang('order.status')</th>
                                            <th>@lang('order.note')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order['details'] as $detail)
                                            <tr>
                                                <td>{{ $detail->dish->dish_id }}</td>
                                                <td>{{ $detail->price_befor_tax }}</td>
                                                <td>{{ $detail->tax_value }}</td>
                                                <td>{{ $detail->price_after_tax }}</td>
                                                <td>{{ $detail->total }}</td>
                                                <td>{{ $detail->quantity }}</td>
                                                <td>@lang('order.' . strtolower($detail->status))</td>
                                                <td>{{ $detail->note }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                
                                <h4>تفاصيل الاضافاات</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>@lang('order.name')</th>
                                            <th>@lang('order.price')</th>
                                            <th>@lang('order.quantity')</th>
                                            <th>@lang('order.total_before_tax')</th>
                                            <th>@lang('order.total_after_tax')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order['addons'] as $addon)
                                            <tr>
                                                <td>{{ $addon->Addon->addons->name_ar }}</td>
                                                <td>{{ $addon->price }}</td>
                                                <td>{{ $addon->quantity }}</td>
                                                <td>{{ $addon->price_before_tax }}</td>
                                                <td>{{ $addon->price_after_tax }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End:: row-1 -->
        </div>
    </div>
    <!-- APP-CONTENT CLOSE -->
@endsection

@section('scripts')
    <!-- JQUERY CDN -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>

    <!-- SELECT2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
