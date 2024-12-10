@extends('layouts.master')

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('branch.EditBranch')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('branch.Branches')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('branch.EditBranch')</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- APP-CONTENT START -->
    <div class="main-content app-content ">
        <div class="container-fluid ">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">
                                @lang('branch.EditBranch')
                            </div>
                        </div>
                        <div class="card-body">
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
                            <form method="POST" action="{{ route('branch.update', $branch->id) }}" class="needs-validation" novalidate>
                                @csrf
                                @method('PUT') <!-- Use PUT or PATCH for updates -->
                                <div class="row gy-4">
                                    <!-- Arabic Name -->
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label class="form-label">@lang('branch.ArabicName')</label>
                                        <input type="text" class="form-control" name="name_ar" value="{{ old('name_ar', $branch->name_ar) }}"
                                               placeholder="@lang('branch.ArabicName')" required>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterArabicName')
                                        </div>
                                    </div>

                                    <!-- English Name -->
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label class="form-label">@lang('branch.EnglishName')</label>
                                        <input type="text" class="form-control" name="name_en" value="{{ old('name_en', $branch->name_en) }}"
                                               placeholder="@lang('branch.EnglishName')" required>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterEnglishName')
                                        </div>
                                    </div>

                                    <!-- Address Arabic -->
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label class="form-label">@lang('branch.ArabicAddress')</label>
                                        <textarea class="form-control" name="address_ar" rows="2">{{ old('address_ar', $branch->address_ar) }}</textarea>
                                    </div>

                                    <!-- Address English -->
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label class="form-label">@lang('branch.EnglishAddress')</label>
                                        <textarea class="form-control" name="address_en" rows="2">{{ old('address_en', $branch->address_en) }}</textarea>
                                    </div>

                                    <!-- Country -->
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <label class="form-label">@lang('branch.Country')</label>
                                        <select class="form-control select2" name="country_id" required>
                                            <option value="" disabled>@lang('branch.SelectCountry')</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ $country->id == old('country_id', $branch->country_id) ? 'selected' : '' }}>
                                                    {{ $country->name_ar ." | ". $country->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterCountry')
                                        </div>
                                    </div>

                                    <!-- Latitude and Longitude -->
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                        <label class="form-label">@lang('branch.Latitude')</label>
                                        <input type="text" class="form-control" name="latitute" value="{{ old('latitute', $branch->latitute) }}">
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                        <label class="form-label">@lang('branch.Longitude')</label>
                                        <input type="text" class="form-control" name="longitute" value="{{ old('longitute', $branch->longitute) }}">
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <label class="form-label">@lang('branch.Phone')</label>
                                        <input type="text" class="form-control" name="phone" value="{{ old('phone', $branch->phone) }}" maxlength="20">
                                    </div>

                                    <!-- Email -->
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <label class="form-label">@lang('branch.Email')</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email', $branch->email) }}">
                                    </div>

                                     <!-- Manager Name -->
                                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <label class="form-label">@lang('branch.ManagerName')</label>
                                        <select class="form-control select2" name="employee_id" id="employee_id" required>
                                            <option value="" disabled selected>@lang('branch.SelectEmployee')</option>
                                            @foreach($employees as $employee)
                                                <option value="{{ $employee->id }}" {{ $employee->id == old('employee_id', $branch->employee_id) ? 'selected' : '' }}>{{ $employee->first_name."  ". $employee->last_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterEmployee')
                                        </div>
                                    </div>

                                    <!-- Opening and Closing Hours -->
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                        <label class="form-label">@lang('branch.OpeningHour')</label>
                                        <input type="time" class="form-control" name="opening_hour" value="{{ old('opening_hour', $branch->opening_hour) }}">
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                        <label class="form-label">@lang('branch.ClosingHour')</label>
                                        <input type="time" class="form-control" name="closing_hour" value="{{ old('closing_hour', $branch->closing_hour) }}">
                                    </div>

                                    <!-- Has Kids Area -->
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <label class="form-label">@lang('branch.HasKidsArea')</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="has_kids_area" value="1"
                                                {{ old('has_kids_area', $branch->has_kids_area) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label">@lang('category.yes')</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="has_kids_area" value="0"
                                                {{ old('has_kids_area', $branch->has_kids_area) == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label">@lang('category.no')</label>
                                        </div>
                                    </div>

                                    <!-- Is Delivery -->
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <label class="form-label">@lang('branch.IsDelivery')</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_delivery" value="1"
                                                {{ old('is_delivery', $branch->is_delivery) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label">@lang('category.yes')</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_delivery" value="0"
                                                {{ old('is_delivery', $branch->is_delivery) == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label">@lang('category.no')</label>
                                        </div>
                                    </div>

                                    <center>
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                            <input type="submit" class="form-control btn btn-primary" id="input-submit"
                                                   value="@lang('category.save')">
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
    <!-- APP-CONTENT CLOSE -->
@endsection

@section('scripts')
    <!-- JQUERY CDN -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>

    <!-- SELECT2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- INETRNAL SELECT2 JS -->
    @vite('resources/assets/js/select2.js')


    <!-- FORM VALIDATION JS -->
    @vite('resources/assets/js/validation.js')
    @vite('resources/assets/js/choices.js')

    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
@endsection
