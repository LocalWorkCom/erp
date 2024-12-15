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
                                <h4> @lang('order.order_details')</h4>
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
                                <h4>@lang('order.client_details')</h4>
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
                                <h4>@lang('order.address_details')</h4>
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


                                <h4> @lang('order.payment_details')</h4>
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

                                <h4>@lang('order.dish_details')</h4>
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

                                <h4>@lang('order.order_details')</h4>
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
                            
                            <div class="main-content app-content">
                                <h4>@lang('order.order_trackings')</h4>
                                <div class="container-fluid">

                                    <div class="row justify-content-center">
                                        <div class="col-xxl-9 col-xl-10 col-sm-12">
                                            <ul class="timeline list-unstyled">
                                                @foreach ($order['tracking'] as $tracking)
                                                    <li>
                                                        <div class="timeline-time text-end">
                                                            <span
                                                                class="time d-inline-block">{{ date('Y-m-d', strtotime($tracking->created_at)) }}</span>
                                                        </div>
                                                        <div class="timeline-icon">
                                                            <a href="javascript:void(0);"></a>
                                                        </div>
                                                        <div class="timeline-body">
                                                            <div class="d-flex align-items-top timeline-main-content mt-0">
                                                                <div class="flex-fill">
                                                                    <div class="align-items-center">
                                                                        <div class="mt-sm-0 mt-2">
                                                                            <p class="mb-0 fs-14 fw-semibold">@lang('order.' . $tracking->order_status)
                                                                            </p>
                                                                            {{-- <p class="mb-0 text-muted">
                                                                                Changed the password
                                                                                of
                                                                                gmail 4 hrs ago. <span
                                                                                    class="badge bg-secondary">Update</span>
                                                                            </p> --}}
                                                                        </div>
                                                                        <div class="ms-auto">
                                                                            <span
                                                                                class="float-end badge bg-light text-muted timeline-badge mt-2 rounded-1">
                                                                                {{ date('H:i a', strtotime($tracking->time)) }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach


                                            </ul>
                                        </div>
                                    </div>

                                </div>
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
