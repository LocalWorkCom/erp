@extends('layouts.master')

@section('styles')
    <!-- Add any specific styles here -->
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('offer.Offer Details')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.home') }}">@lang('sidebar.Main')</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="javascript:void(0);"
                           onclick="window.location.href='{{ route('offers.list') }}'">@lang('offer.Offers')</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">@lang('offer.Offer Details')</div>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-solid-danger alert-dismissible fade show">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            @endif

                            <form action="{{ route('offerDetails.save', $offer->id) }}" method="POST">
                                @csrf
                                <div class="col-xl-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>@lang('offer.OfferType')</th>
                                            <th>@lang('offer.TypeName')</th>
                                            <th>@lang('offer.Count')</th>
                                            <th>@lang('offer.Discount')</th>
                                            <th>@lang('offer.Actions')</th>
                                        </tr>
                                        </thead>
                                        <tbody id="offer-details-table" data-detail-count="{{ count($details) }}">
                                        @foreach ($details as $index => $offerDetail)
                                            <tr>
                                                <td>
                                                    <select name="details[{{ $index }}][offer_type]" class="form-control offer-type-select" required>
                                                        <option value="dishes" {{ $offerDetail->offer_type == 'dishes' ? 'selected' : '' }}>@lang('offer.Dishes')</option>
                                                        <option value="addons" {{ $offerDetail->offer_type == 'addons' ? 'selected' : '' }}>@lang('offer.Addons')</option>
                                                        <option value="products" {{ $offerDetail->offer_type == 'products' ? 'selected' : '' }}>@lang('offer.Products')</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="details[{{ $index }}][type_id]" class="form-control type-id-select" required>
                                                        <option value="{{ $offerDetail->type_id }}" selected>{{ $offerDetail->type->name ?? '' }}</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="details[{{ $index }}][count]" class="form-control" value="{{ $offerDetail->count }}" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="details[{{ $index }}][discount]" class="form-control" value="{{ $offerDetail->discount }}" required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove-detail">@lang('offer.Remove')</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" id="add-detail" class="btn btn-success btn-sm">@lang('offer.Add Detail')</button>
                                <button type="submit" class="btn btn-primary mt-3">@lang('offer.Save')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
    </script>
@endsection
