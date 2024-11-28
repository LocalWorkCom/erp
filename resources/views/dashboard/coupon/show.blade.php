@extends('layouts.master')

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('coupon.ShowCoupon')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('coupon.Coupons')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('coupon.ShowCoupon')</li>
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
                            <div class="card-title">@lang('coupon.ShowCoupon')</div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-4">
                                <!-- Coupon Code -->
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('coupon.Code')</label>
                                    <p class="form-text">{{ $coupon->code }}</p>
                                </div>

                                <!-- Discount Value -->
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('coupon.Value')</label>
                                    <p class="form-text">{{ $coupon->value }}</p>
                                </div>

                                <!-- Minimum Spend -->
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('coupon.MinimumSpend')</label>
                                    <p class="form-text">{{ $coupon->minimum_spend ?? __('category.none') }}</p>
                                </div>

                                <!-- Usage Limit -->
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('coupon.UsageLimit')</label>
                                    <p class="form-text">{{ $coupon->usage_limit ?? __('category.none') }}</p>
                                </div>

                                <!-- Start Date -->
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('coupon.StartDate')</label>
                                    <p class="form-text">{{ $coupon->start_date ? \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d H:i') : __('category.none') }}</p>
                                </div>

                                <!-- End Date -->
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('coupon.EndDate')</label>
                                    <p class="form-text">{{ $coupon->end_date ? \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d H:i') : __('category.none') }}</p>
                                </div>

                                <!-- Discount Type -->
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('coupon.Type')</label>
                                    <p class="form-text">
                                        {{ $coupon->type == 'percentage' ? __('coupon.Percentage') : __('coupon.Fixed') }}
                                    </p>
                                </div>

                                <!-- Is Active -->
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('coupon.IsActive')</label>
                                    <p class="form-text">{{ $coupon->is_active ? __('category.yes') : __('category.no') }}</p>
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
