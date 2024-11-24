@extends('layouts.master')

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('branch.ShowBranch')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('branch.Branches')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('branch.ShowBranch')</li>
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
                            <div class="card-title">@lang('branch.ShowBranch')</div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-4">
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('branch.ArabicName')</label>
                                    <p class="form-text">{{ $branch->name_ar }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('branch.EnglishName')</label>
                                    <p class="form-text">{{ $branch->name_en }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('branch.ArabicAddress')</label>
                                    <p class="form-text">{{ $branch->address_ar == null ? __('category.none') :  $branch->address_ar}}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('branch.EnglishAddress')</label>
                                    <p class="form-text">{{ $branch->address_en == null ? __('category.none') :  $branch->address_en}}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('branch.Latitude')</label>
                                    <p class="form-text">{{ $branch->latitute == null ? __('category.none') :  $branch->latitute}}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('branch.Longitude')</label>
                                    <p class="form-text">{{ $branch->longitute == null ? __('category.none') :  $branch->longitute}}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('branch.Country')</label>
                                    <p class="form-text">{{ $branch->country ? $branch->country->name : __('category.none') }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('branch.Phone')</label>
                                    <p class="form-text">{{ $branch->phone == null ? __('category.none') : $branch->phone }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('branch.Email')</label>
                                    <p class="form-text">{{ $branch->email == null ? __('category.none') : $branch->email }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('branch.ManagerName')</label>
                                    <p class="form-text">{{ $branch->manager_name == null ? __('category.none') : $branch->manager_name }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('branch.OpeningHour')</label>
                                    <p class="form-text">{{ $branch->opening_hour == null ? __('category.none') : $branch->opening_hour }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('branch.ClosingHour')</label>
                                    <p class="form-text">{{ $branch->closing_hour == null ? __('category.none') : $branch->closing_hour }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('branch.HasKidsArea')</label>
                                    <p class="form-text">
                                        {{ $branch->has_kids_area ? __('category.yes') : __('category.no') }}
                                    </p>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('branch.IsDelivery')</label>
                                    <p class="form-text">
                                        {{ $branch->is_delivery ? __('category.yes') : __('category.no') }}
                                    </p>
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
