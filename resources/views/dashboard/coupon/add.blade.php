@extends('layouts.master')

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('coupon.AddCoupon')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('coupon.Coupons')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('coupon.AddCoupon')</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">@lang('coupon.AddCoupon')</div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('coupon.store') }}" class="needs-validation" novalidate>
                                @csrf
                                <div class="row gy-4">
                                    <!-- Coupon Code -->
                                    <div class="col-xl-6">
                                        <label for="code" class="form-label">@lang('coupon.Code')</label>
                                        <input type="text" name="code" id="code" class="form-control" placeholder="@lang('coupon.Code')" required>
                                        <div class="invalid-feedback">@lang('validation.Entercode')</div>
                                    </div>

                                    <!-- Discount Value -->
                                    <div class="col-xl-6">
                                        <label for="value" class="form-label">@lang('coupon.Value')</label>
                                        <input type="number" step="0.01" name="value" id="value" class="form-control" placeholder="@lang('coupon.Value')" required>
                                        <div class="invalid-feedback">@lang('validation.EnterDiscountValue')</div>
                                    </div>


                                    <!-- Minimum Spend -->
                                    <div class="col-xl-6">
                                        <label for="minimum_spend" class="form-label">@lang('coupon.MinimumSpend')</label>
                                        <input type="number" step="0.01" name="minimum_spend" id="minimum_spend" class="form-control" placeholder="@lang('coupon.MinimumSpend')" required>
                                        <div class="invalid-feedback">@lang('validation.EnterMinimumSpend')</div>
                                    </div>

                                    <!-- Usage Limit -->
                                    <div class="col-xl-6">
                                        <label for="usage_limit" class="form-label">@lang('coupon.UsageLimit')</label>
                                        <input type="number" name="usage_limit" id="usage_limit" class="form-control" placeholder="@lang('coupon.UsageLimit')" required>
                                        <div class="invalid-feedback">@lang('validation.EnterUsageLimit')</div>
                                    </div>

                                    <!-- Start Date -->
                                    <div class="col-xl-6">
                                        <label for="start_date" class="form-label">@lang('coupon.StartDate')</label>
                                        <input type="datetime-local" name="start_date" id="start_date" class="form-control" required>
                                        <div class="invalid-feedback">@lang('validation.EnterStartDate')</div>
                                    </div>

                                    <!-- End Date -->
                                    <div class="col-xl-6">
                                        <label for="end_date" class="form-label">@lang('coupon.EndDate')</label>
                                        <input type="datetime-local" name="end_date" id="end_date" class="form-control" required>
                                        <div class="invalid-feedback">@lang('validation.EnterEndDate')</div>
                                    </div>

                                    <!-- Discount Type -->
                                    <div class="col-xl-6">
                                        <p class="mb-2 text-muted">@lang('coupon.Type')</p>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="type" value="percentage" class="form-check-input" checked required>
                                            <label class="form-check-label">@lang('coupon.Percentage')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="type" value="fixed" class="form-check-input" required>
                                            <label class="form-check-label">@lang('coupon.Fixed')</label>
                                        </div>
                                    </div>

                                    <!-- Is Active -->
                                    <div class="col-xl-6">
                                        <p class="mb-2 text-muted">@lang('coupon.IsActive')</p>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="is_active" value="1" class="form-check-input" checked required>
                                            <label class="form-check-label">@lang('coupon.Active')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="is_active" value="0" class="form-check-input" required>
                                            <label class="form-check-label">@lang('coupon.Inactive')</label>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <center>
                                        <div class="col-xl-4">
                                            <button type="submit" class="btn btn-primary form-control">@lang('category.save')</button>
                                        </div>
                                    </center>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- JQUERY CDN -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>
    <!-- SELECT2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Custom JS -->
    @vite('resources/assets/js/validation.js')
@endsection
