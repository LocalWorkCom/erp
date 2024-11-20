@extends('layouts.master')

@section('styles')
    <!-- DATA-TABLES CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
@endsection

@section('content')
    <!-- PAGE HEADER -->
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('product.Products')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('sidebar.main')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('product.Products')</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start:: row-4 -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header"
                            style="
                        display: flex;
                        justify-content: space-between;">
                            <div class="card-title">@lang('product.Products')</div>
                            <button type="button" class="btn btn-primary label-btn" onclick="window.location.href='{{ route('product.create') }}'">
                                <i class="fe fe-plus label-btn-icon me-2"></i>
                                @lang('product.Add')
                            </button>
                            
                            
                        </div>
                        <div class="card-body">
                            <table id="file-export" class="table table-bordered text-nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('product.ID')</th>
                                        <th scope="col">@lang('product.Image')</th>
                                        <th scope="col">@lang('product.ArabicName')</th>
                                        <th scope="col">@lang('product.EnglishName')</th>
                                        <th scope="col">@lang('product.Unit')</th>
                                        <th scope="col">@lang('product.Type')</th>
                                        <th scope="col">@lang('product.Category')</th>
                                        <th scope="col">@lang('product.Sku')</th>
                                        <th scope="col">barcode</th>
                                        <th scope="col">code</th>
                                        <th scope="col">is have expired</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td><img src="{{ BaseUrl() . '/' . $product->main_image }}" alt=""></td>
                                            <td>{{ $product->name_ar }}</td>
                                            <td>{{ $product->name_en }}</td>
                                            <td>{{ $product->mainUnit->name_ar }}</td>
                                            <td>{{ $product->type }}</td>
                                            <td>{{ $product->Category->name_ar }}</td>
                                            <td>{{ $product->Sku }}</td>
                                            <td>{{ $product->barcode }}</td>
                                            <td>{{ $product->code }}</td>
                                            <td>{{ $product->is_have_expired ? 'yes' : 'no' }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End:: row-4 -->

        </div>
    </div>
@endsection

@section('scripts')
    <!-- JQUERY CDN -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>

    <!-- DATA-TABLES CDN -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- INTERNAL DATADABLES JS -->
    @vite('resources/assets/js/datatables.js')
@endsection
