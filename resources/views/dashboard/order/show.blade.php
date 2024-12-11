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
                            <div class="card-title">@lang('order.show')</div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-4">
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('order.ArabicName')</label>
                                    <p class="form-text">{{ $order->name_ar }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('order.EnglishName')</label>
                                    <p class="form-text">{{ $order->name_en }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('order.ArabicDesc')</label>
                                    <p class="form-text">{{ $order->description_ar == null ? __('category.none') :  $order->description_ar }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('order.EnglishDesc')</label>
                                    <p class="form-text">{{ $order->description_en == null ? __('category.none') :  $order->description_en }}</p>
                                </div>
                              

                            
                                {{-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.Price')</label>
                                    <p class="form-text">{{ $order->price }}</p>
                                </div> --}}
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.Currency')</label>
                                    <p class="form-text">{{ $Currencies[$order->currency_code] ?? __('category.none') }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.Barcode')</label>
                                    <p class="form-text">{{ $order->barcode }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.Unit')</label>
                                    <p class="form-text">{{ $order->mainUnit->name_ar ?? __('category.none') }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.Brand')</label>
                                    <p class="form-text">{{ $order->brand->name_ar . ' | ' . $order->brand->name_en ?? __('category.none') }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.Store')</label>
                                    @if ($order->orderLimit->isNotEmpty())
                                        <ul>
                                            @foreach ($order->orderLimit as $limit)
                                                <li>{{ $limit->store->name_ar." | ".$limit->store->name_en }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="form-text">@lang('category.none')</p>
                                    @endif
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.Category')</label>
                                    <p class="form-text">{{ $order->category->name_ar . ' | ' . $order->category->name_en ?? __('category.none') }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.Type')</label>
                                    <p class="form-text">{{ $order->type == 'raw' ? __('order.Raw') : __('order.Complete') }}</p>
                                </div>
                                {{-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.ExpiryDate')</label>
                                    <p class="form-text">{{ $order->expiry_date ?? __('category.none') }}</p>
                                </div> --}}
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.IsHaveExpired')</label>
                                    <p class="form-text">{{ $order->is_have_expired ? __('category.yes') : __('category.no') }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label class="form-label">@lang('order.Remind')</label>
                                    <p class="form-text">{{ $order->is_remind ? __('category.yes') : __('category.no') }}</p>
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
