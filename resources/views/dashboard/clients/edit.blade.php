@extends('layouts.master')

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('client.edit')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('client.Categories')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('client.edit')</li>
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
                                @lang('client.edit')
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('client.update', $client->id) }}" class="needs-validation"
                                enctype="multipart/form-data" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="row gy-4">
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="first_name" class="form-label">@lang('client.firstName')</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            value="{{ old('first_name', $client->clientDetails->first_name) }}"
                                            placeholder="@lang('client.firstName')" required>
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterFirstName')</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="last_name" class="form-label">@lang('client.lastName')</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            value="{{ old('last_name', $client->clientDetails->last_name) }}"
                                            placeholder="@lang('client.lastName')" required>
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterLastName')</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="email" class="form-label">@lang('client.email')</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email', $client->email) }}" placeholder="@lang('client.email')"
                                            required>
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterValidEmail')</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="phone" class="form-label">@lang('client.phone')</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ old('phone', $client->phone) }}" placeholder="@lang('client.phone')"
                                            required>
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterValidPhone')</div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <label for="image" class="form-label">@lang('client.Image')</label>

                                        <!-- Show current image if exists -->
                                        @if ($client->clientDetails && $client->clientDetails->image)
                                            <div class="mb-3">
                                                <img src="{{ asset($client->clientDetails->image) }}" alt="Client Image"
                                                    width="150" height="150">
                                            </div>
                                            <!-- Hidden field to submit current image -->
                                            <input type="hidden" name="image" value="{{ $client->clientDetails->image }}">
                                        @endif

                                        <input class="form-control" type="file" id="image" name="image">
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterImage')</div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <label for="address" class="form-label">@lang('client.address')</label>
                                        <input type="text" class="form-control" id="address"
                                            name="addresses[0][address]"
                                            value="{{ old('addresses.0.address', $client->clientAddresses->first()->address ?? '') }}"
                                            placeholder="@lang('client.address')" required>
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterAddress')</div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <label for="city" class="form-label">@lang('client.city')</label>
                                        <input type="text" class="form-control" id="city"
                                            name="addresses[0][city]"
                                            value="{{ old('addresses.0.city', $client->clientAddresses->first()->city ?? '') }}"
                                            placeholder="@lang('client.city')" required>
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterCity')</div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <label for="state" class="form-label">@lang('client.state')</label>
                                        <input type="text" class="form-control" id="state"
                                            name="addresses[0][state]"
                                            value="{{ old('addresses.0.state', $client->clientAddresses->first()->state ?? '') }}"
                                            placeholder="@lang('client.state')" required>
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterState')</div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <label for="postal_code" class="form-label">@lang('client.postalCode')</label>
                                        <input type="text" class="form-control" id="postal_code"
                                            name="addresses[0][postal_code]"
                                            value="{{ old('addresses.0.postal_code', $client->clientAddresses->first()->postal_code ?? '') }}"
                                            placeholder="@lang('client.postalCode')">
                                        <div class="valid-feedback">@lang('validation.Correct')</div>
                                        <div class="invalid-feedback">@lang('validation.EnterPostalCode')</div>
                                    </div>
                                    <center>
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                            <input type="submit" class="form-control btn btn-primary" id="input-submit"
                                                value="@lang('client.save')">
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
