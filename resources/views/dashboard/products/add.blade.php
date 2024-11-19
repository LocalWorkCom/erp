@extends('layouts.master')

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">Create Product</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">create Product</li>
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
                                Create Product
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-4">
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <p class="mb-2 text-muted">Brand:</p>
                                    <select class="js-example-placeholder-single js-states form-control">
                                        <option value="st-1" selected>Texas</option>
                                        <option value="st-2">Georgia</option>
                                        <option value="st-3">California</option>
                                        <option value="st-4">Washington D.C</option>
                                        <option value="st-5">Virginia</option>
                                    </select>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="input-placeholder" class="form-label">Arabic Name</label>
                                    <input type="text" class="form-control" id="input-placeholder"
                                        placeholder="Arabic Name">
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="input-placeholder" class="form-label">English Name</label>
                                    <input type="text" class="form-control" id="input-placeholder"
                                        placeholder="English Name">
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label for="input-text" class="form-label">Arabic Description</label>
                                    <input type="text" class="form-control" id="input-text" placeholder="Text">
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label for="input-text" class="form-label">English Description</label>
                                    <input type="text" class="form-control" id="input-text" placeholder="Text">
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="input-file" class="form-label">Product Image</label>
                                    <input class="form-control" type="file" id="input-file">
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <p class="mb-2 text-muted">Unit:</p>
                                    <select class="js-example-placeholder-single js-states form-control">
                                        <option value="st-1" selected>Texas</option>
                                        <option value="st-2">Georgia</option>
                                        <option value="st-3">California</option>
                                        <option value="st-4">Washington D.C</option>
                                        <option value="st-5">Virginia</option>
                                    </select>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <p class="mb-2 text-muted">Currency:</p>
                                    <select class="js-example-placeholder-single js-states form-control">
                                        <option value="st-1" selected>Texas</option>
                                        <option value="st-2">Georgia</option>
                                        <option value="st-3">California</option>
                                        <option value="st-4">Washington D.C</option>
                                        <option value="st-5">Virginia</option>
                                    </select>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <p class="mb-2 text-muted">Category:</p>
                                    <select class="js-example-placeholder-single js-states form-control">
                                        <option value="st-1" selected>Texas</option>
                                        <option value="st-2">Georgia</option>
                                        <option value="st-3">California</option>
                                        <option value="st-4">Washington D.C</option>
                                        <option value="st-5">Virginia</option>
                                    </select>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="input-placeholder" class="form-label">Barcode</label>
                                    <input type="text" class="form-control" id="input-placeholder" placeholder="Barcode">
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="input-placeholder" class="form-label">Product Code</label>
                                    <input type="text" class="form-control" id="input-placeholder"
                                        placeholder="Product Code">
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <p class="mb-2 text-muted">Type:</p>
                                    <div class="form-check form-check-md form-check-inline">
                                        <input class="form-check-input" type="radio" name="Radio" id="Radio-md">
                                        <label class="form-check-label" for="Radio-md">
                                            Raw
                                        </label>
                                    </div>
                                    <div class="form-check form-check-md form-check-inline">
                                        <input class="form-check-input" type="radio" name="Radio" id="Radio-md" checked>
                                        <label class="form-check-label" for="Radio-md">
                                            Complete
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <p class="mb-2 text-muted">Is valid?</p>
                                    <div class="form-check form-check-md form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="Radio-md">
                                        <label class="form-check-label" for="Radio-md">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check form-check-md form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="Radio-md" checked>
                                        <label class="form-check-label" for="Radio-md">
                                            No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <p class="mb-2 text-muted">Have Expiration Date?</p>
                                    <div class="form-check form-check-md form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions-1" id="Radio-md">
                                        <label class="form-check-label" for="Radio-md">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check form-check-md form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions-1" id="Radio-md" checked>
                                        <label class="form-check-label" for="Radio-md">
                                            No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 d-flex justify-content-center">
                                    <input type="submit" class="form-control btn btn-primary " id="input-submit" value="Submit">
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

    <!-- INETRNAL SELECT2 JS -->
    @vite('resources/assets/js/select2.js')
@endsection
