@extends('layouts.master')

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('product.CreateProduct')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('product.Products')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('product.CreateProduct')</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- APP-CONTENT START -->
    <div class="main-content app-content ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">@lang('product.CreateProduct')</div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('product.store') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-12">
                                        <p class="mb-2 text-muted">@lang('product.Brand'):</p>
                                        <select name="brand_id" class="js-example-basic-single form-control" required>
                                            <option value="" selected disabled>@lang('product.ChooseBrand')</option>
                                            @foreach ($Brands as $Brand)
                                                <option value="{{ $Brand->id }}">{{ $Brand->name_ar }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">@lang('validation.brand')</div>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="name_ar" class="form-label">Arabic Name</label>
                                        <input type="text" name="name_ar" id="name_ar" class="form-control" placeholder="Arabic Name" required>
                                        <div class="invalid-feedback">@lang('validation.name_ar')</div>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="name_en" class="form-label">English Name</label>
                                        <input type="text" name="name_en" id="name_en" class="form-control" placeholder="English Name">
                                        <div class="invalid-feedback">@lang('validation.name_en')</div>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="description_ar" class="form-label">Arabic Description</label>
                                        <textarea name="description_ar" id="description_ar" class="form-control" rows="2"></textarea>
                                        <div class="invalid-feedback">@lang('validation.desc_ar')</div>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="description_en" class="form-label">English Description</label>
                                        <textarea name="description_en" id="description_en" class="form-control" rows="2"></textarea>
                                        <div class="invalid-feedback">@lang('validation.desc_en')</div>
                                    </div>

                                    <div class="col-xl-4">
                                        <label for="main_image" class="form-label">Product Image</label>
                                        <input type="file" name="main_image" id="main_image" class="form-control" required>
                                        <div class="invalid-feedback">@lang('validation.img')</div>
                                    </div>

                                    <div class="col-xl-4">
                                        <label for="main_unit_id" class="form-label">Unit</label>
                                        <select name="main_unit_id" id="main_unit_id" class="js-example-basic-single form-control" required>
                                            <option value="" selected disabled>@lang('product.ChooseUnit')</option>
                                            @foreach ($Units as $Unit)
                                                <option value="{{ $Unit->id }}">{{ $Unit->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">@lang('validation.unit')</div>
                                    </div>

                                    <div class="col-xl-4">
                                        <label for="currency_code" class="form-label">Currency</label>
                                        <select name="currency_code" id="currency_code" class="js-example-basic-single form-control" required>
                                            <option value="" selected disabled>@lang('product.ChooseCurrency')</option>
                                            @foreach ($Currencies as $index => $Currency)
                                                <option value="{{ $index }}">{{ $Currency }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">@lang('validation.currency')</div>
                                    </div>

                                    <div class="col-xl-4">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select name="category_id" id="category_id" class="js-example-basic-single form-control" required>
                                            <option value="" selected disabled>@lang('product.ChooseCategory')</option>
                                            @foreach ($Categories as $Category)
                                                <option value="{{ $Category->id }}">{{ $Category->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">@lang('validation.category')</div>
                                    </div>

                                    <div class="col-xl-4">
                                        <label for="store_id" class="form-label">Store</label>
                                        <select name="store_id" id="store_id" class="js-example-basic-single form-control" required>
                                            <option value="" selected disabled>@lang('product.ChooseStore')</option>
                                            @foreach ($Stores as $Store)
                                                <option value="{{ $Store->id }}">{{ $Store->name_ar }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">@lang('validation.category')</div>
                                    </div>

                                    <div class="col-xl-4">
                                        <label for="barcode" class="form-label">Barcode</label>
                                        <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode" required>
                                        <div class="invalid-feedback">@lang('validation.enter_barcode')</div>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="sku" class="form-label">Product Code (SKU)</label>
                                        <input type="text" name="sku" id="sku" class="form-control" placeholder="Product Code" required>
                                        <div class="invalid-feedback">@lang('validation.code')</div>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" name="price" id="price" class="form-control" placeholder="Arabic Name" required>
                                        <div class="invalid-feedback">@lang('validation.price')</div>
                                    </div>
                                    <div class="col-xl-6">
                                        <label for="min_limit" class="form-label">min_limit</label>
                                        <input type="number" name="min_limit" id="min_limit" class="form-control" placeholder="Arabic Name" required>
                                        <div class="invalid-feedback">@lang('validation.min_limit')</div>
                                    </div>
                                    <div class="col-xl-6">
                                        <label for="max_limit" class="form-label">max_limit</label>
                                        <input type="number" name="max_limit" id="max_limit" class="form-control" placeholder="Arabic Name" required>
                                        <div class="invalid-feedback">@lang('validation.max_limit')</div>
                                    </div>

                                    <div class="col-xl-4">
                                        <p class="mb-2 text-muted">Type:</p>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="type" value="raw" class="form-check-input" checked required>
                                            <label class="form-check-label">Raw</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="type" value="complete" class="form-check-input" required>
                                            <label class="form-check-label">Complete</label>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <p class="mb-2 text-muted">Have Expiration Date?</p>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="is_have_expired" value="1" class="form-check-input" checked required>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="is_have_expired" value="0" class="form-check-input" required>
                                            <label class="form-check-label">No</label>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <p class="mb-2 text-muted">Remind about product?</p>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="is_remind" value="1" class="form-check-input" checked required>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="is_remind" value="0" class="form-check-input" required>
                                            <label class="form-check-label">No</label>
                                        </div>
                                    </div>

                                    <center>
                                        <div class="col-xl-4">
                                            <button type="submit" class="btn btn-primary form-control">@lang('Submit')</button>
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
    <script>
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
