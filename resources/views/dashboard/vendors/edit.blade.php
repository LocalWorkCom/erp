@extends('layouts.master')

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('vendor.edit')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('vendors.index') }}">@lang('vendor.vendors')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('vendor.edit')</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- APP-CONTENT START -->
    <div class="main-content app-content ">
        <div class="container-fluid ">

            <!-- Start:: row-1 -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">
                                @lang('vendor.edit')
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('message'))
                                <div class="alert alert-solid-info alert-dismissible fade show">
                                    {{ session('message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            @endif
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-solid-danger alert-dismissible fade show">
                                        {{ $error }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                            <form method="POST" action="{{ route('vendor.update', $vendor->id) }}" class="needs-validation"
                                enctype="multipart/form-data" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="row gy-4">
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="name_ar" class="form-label">@lang('vendor.arabicName')</label>
                                        <input type="text" class="form-control" id="name_ar" name="name_ar"
                                            value="{{ $vendor->name_ar }}" placeholder="@lang('vendor.arabicName')">
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterArabicName')</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="name_en" class="form-label">@lang('vendor.englishName')</label>
                                        <input type="text" class="form-control" id="name_en" name="name_en"
                                            value="{{ $vendor->name_en }}" placeholder="@lang('vendor.englishName')">
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterEnglishName')</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="contact_person" class="form-label">@lang('vendor.contactPerson')</label>
                                        <input type="text" class="form-control" id="contact_person" name="contact_person"
                                            value="{{ $vendor->contact_person }}"
                                            placeholder="@lang('vendor.contactPerson')">
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterContactPerson')</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="phone" class="form-label">@lang('vendor.phone')</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ $vendor->phone }}" placeholder="@lang('vendor.phone')">
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterValidPhone')</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="email" class="form-label">@lang('vendor.email')</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $vendor->email }}" placeholder="@lang('vendor.email')">
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterValidEmail')</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <p class="mb-2 text-muted">@lang('vendor.country')</p>
                                        <select name="country_id" class="js-example-basic-single form-control">
                                            <option value="" disabled>@lang('vendor.chooseCountry')</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ $country->id == $vendor->country_id ? 'selected' : '' }}>
                                                    {{ $country->name_ar . ' | ' . $country->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">@lang('validation.EnterBrand')</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="address_en" class="form-label">@lang('vendor.englishAddress')</label>
                                        <input type="text" class="form-control" id="address_en" name="address_en"
                                            value="{{ $vendor->address_en}}"
                                            placeholder="@lang('vendor.englishAddress')">
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterAddress')</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="address_ar" class="form-label">@lang('vendor.arabicAddress')</label>
                                        <input type="text" class="form-control" id="address_ar" name="address_ar"
                                            value="{{ $vendor->address_ar}}"
                                            placeholder="@lang('vendor.arabicAddress')">
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterAddress')</div>
                                    </div>
                                    <center>
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                            <input type="submit" class="form-control btn btn-primary" id="input-submit"
                                                value="@lang('vendor.save')">
                                        </div>
                                    </center>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-1 -->
    </div>
    <!-- APP-CONTENT CLOSE -->
@endsection

@section('scripts')
    <!-- JQUERY CDN -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>

    <!-- SELECT2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- INTERNAL SELECT2 JS -->
    @vite('resources/assets/js/select2.js')

    <!-- FORM VALIDATION JS -->
    @vite('resources/assets/js/validation.js')
    @vite('resources/assets/js/choices.js')
@endsection
