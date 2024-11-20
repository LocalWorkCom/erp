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
        <h4 class="fw-medium mb-0">@lang('country.Countries')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('sidebar.Main')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('country.Countries')</li>
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
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title">@lang('country.Countries')</div>
                            <div class="card-text">
                                <button type="button" class="btn btn-primary label-btn">
                                    <i class="fe fe-plus label-btn-icon me-2"></i>
                                    @lang('Country.Add')
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="file-export" class="table table-bordered text-nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('country.id')</th>
                                        <th scope="col">@lang('country.name_ar')</th>
                                        <th scope="col">@lang('country.name_en')</th>
                                        <th scope="col">@lang('country.currency_ar')</th>
                                        <th scope="col">@lang('country.currency_en')</th>
                                        <th scope="col">@lang('country.currency_code')</th>
                                        <th scope="col">@lang('country.code')</th>
                                        <th scope="col">@lang('country.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($countries as $country)
                                        <tr>
                                            <td>{{ $country->id }}</td>
                                            <td>{{ $country->name_ar }}</td>
                                            <td>{{ $country->name_en }}</td>
                                            <td>{{ $country->currency_ar }}</td>
                                            <td>{{ $country->currency_en }}</td>
                                            <td>{{ $country->currency_code }}</td>
                                            <td>{{ $country->code }}</td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-info-light btn-wave">@lang('country.show')</button>
                                                <button type="button"
                                                    class="btn btn-orange-light btn-wave">@lang('country.edit')</button>
                                                <button type="button"
                                                    class="btn btn-danger-light btn-wave">@lang('country.delete')</button>

                                            </td>
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
@endsection
