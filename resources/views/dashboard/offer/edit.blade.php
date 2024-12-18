@extends('layouts.master')

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('offer.EditOffer')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('offers.list')}}">@lang('offer.Offeres')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('offer.EditOffer')</li>
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
                                @lang('offer.EditOffer')
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
                            <form method="POST" action="{{ route('offer.update', $offer->id) }}" class="needs-validation" novalidate>
                                @csrf
                                @method('PUT') <!-- Use PUT or PATCH for updates -->
                                <div class="row gy-4">
                                    <!-- Arabic Name -->
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label class="form-label">@lang('offer.ArabicName')</label>
                                        <input type="text" class="form-control" name="name_ar" value="{{ old('name_ar', $offer->name_ar) }}"
                                               placeholder="@lang('offer.ArabicName')" required>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterArabicName')
                                        </div>
                                    </div>

                                    <!-- English Name -->
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label class="form-label">@lang('offer.EnglishName')</label>
                                        <input type="text" class="form-control" name="name_en" value="{{ old('name_en', $offer->name_en) }}"
                                               placeholder="@lang('offer.EnglishName')" required>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterEnglishName')
                                        </div>
                                    </div>

{{--                                    <!-- Country -->--}}
{{--                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">--}}
{{--                                        <label class="form-label">@lang('offer.Country')</label>--}}
{{--                                        <select class="form-control select2" name="country_id" required>--}}
{{--                                            <option value="" disabled>@lang('offer.SelectCountry')</option>--}}
{{--                                            @foreach($countries as $country)--}}
{{--                                                <option value="{{ $country->id }}" {{ $country->id == old('country_id', $offer->country_id) ? 'selected' : '' }}>--}}
{{--                                                    {{ $country->name_ar ." | ". $country->name_en }}--}}
{{--                                                </option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        <div class="invalid-feedback">--}}
{{--                                            @lang('validation.EnterCountry')--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <!-- Opening and Closing Hours -->--}}
{{--                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">--}}
{{--                                        <label class="form-label">@lang('offer.OpeningHour')</label>--}}
{{--                                        <input type="time" class="form-control" name="opening_hour" value="{{ old('opening_hour', $offer->opening_hour) }}">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">--}}
{{--                                        <label class="form-label">@lang('offer.ClosingHour')</label>--}}
{{--                                        <input type="time" class="form-control" name="closing_hour" value="{{ old('closing_hour', $offer->closing_hour) }}">--}}
{{--                                    </div>--}}

{{--                                    <!-- Is Delivery -->--}}
{{--                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">--}}
{{--                                        <label class="form-label">@lang('offer.IsDelivery')</label>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="radio" name="is_delivery" value="1"--}}
{{--                                                {{ old('is_delivery', $offer->is_delivery) == 1 ? 'checked' : '' }}>--}}
{{--                                            <label class="form-check-label">@lang('category.yes')</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="radio" name="is_delivery" value="0"--}}
{{--                                                {{ old('is_delivery', $offer->is_delivery) == 0 ? 'checked' : '' }}>--}}
{{--                                            <label class="form-check-label">@lang('category.no')</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

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
