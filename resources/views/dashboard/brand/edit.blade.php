@extends('layouts.master')

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('brand.EditBrand')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('brand.Brands')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('brand.EditBrand')</li>
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
                                @lang('brand.EditBrand')
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
                            <form method="POST" action="{{ route('brand.update', $brand->id) }}" class="needs-validation" novalidate enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- Use PUT or PATCH for updates -->
                                <div class="row gy-4">
                                    <!-- Arabic Name -->
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label class="form-label">@lang('brand.ArabicName')</label>
                                        <input type="text" class="form-control" name="name_ar" value="{{ old('name_ar', $brand->name_ar) }}"
                                               placeholder="@lang('brand.ArabicName')" required>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterArabicName')
                                        </div>
                                    </div>

                                    <!-- English Name -->
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label class="form-label">@lang('brand.EnglishName')</label>
                                        <input type="text" class="form-control" name="name_en" value="{{ old('name_en', $brand->name_en) }}"
                                               placeholder="@lang('brand.EnglishName')" required>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterEnglishName')
                                        </div>
                                    </div>

                                    <!-- Address Arabic -->
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label class="form-label">@lang('brand.ArabicDesc')</label>
                                        <textarea class="form-control" name="description_ar" rows="2">{{ old('description_ar', $brand->description_ar) }}</textarea>
                                    </div>

                                    <!-- Address English -->
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label class="form-label">@lang('brand.EnglishDesc')</label>
                                        <textarea class="form-control" name="description_en" rows="2">{{ old('description_en', $brand->description_en) }}</textarea>
                                    </div>


                                    <div class="col-xl-4">
                                        <label for="logo_path" class="form-label">@lang('brand.Image')</label>
                                        <input type="file" name="logo_path" id="logo_path" class="form-control" required>
                                        <div class="invalid-feedback">@lang('validation.EnterImage')</div>
                                    </div>

                                    <center>
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                            <input type="submit" class="form-control btn btn-primary" id="input-submit"
                                                   value="@lang('brand.Save')">
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