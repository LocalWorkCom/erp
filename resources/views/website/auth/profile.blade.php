@extends('website.layouts.master')

@section('content')
    <section class="inner-header pt-5 mt-5">
        <div class="container pt-sm-5 pt-4">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('/') }}"> @lang('auth.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> @lang('auth.myacount')</li>
                </ol>
            </nav>
        </div>

    </section>
    <section class="profile">
        <div class="container pb-sm-5 pb-4">
            <h4 class="my-4 fw-bold">  @lang('auth.profile')</h4>
            <div class="row justify-content-between">
                <div class="col-lg-3">
                    <div class="card p-3">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-profile" type="button" role="tab"
                                aria-controls="v-pills-profile" aria-selected="false">   @lang('auth.editprofile')</button>
                            <button class="nav-link " id="v-pills-pass-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-pass" type="button" role="tab" aria-controls="v-pills-pass"
                                aria-selected="true"> @lang('auth.editpass')</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="card p-4">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                                aria-labelledby="v-pills-profile-tab">
                                <form method="POST" action="{{ route('website.profile.update') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="text" id="name" name="name" class="form-control"
                                            placeholder="{{ Auth::guard('client')->user()->name }}"
                                            value="{{ old('name', Auth::guard('client')->user()->name) }}" required>
                                        @error('name')
                                            <div id="nameError" class="error-message mb-1 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <div class="input-group">
                                            <input type="text" id="mobile" name="phone" class="form-control"
                                                placeholder="{{ Auth::guard('client')->user()->phone }}"
                                                value="{{ old('phone', Auth::guard('client')->user()->phone) }}" required>
                                            <select id="country" name="country_code_profile" class="selectpicker me-2"
                                                data-live-search="true" required>
                                                @foreach (GetCountries() as $country)
                                                    <option
                                                        data-content='<img src="{{ $country->flag }}" class="flag-icon"> {{ $country->phone_code }}'
                                                        value="{{ $country->phone_code }}" @if (old('country_code_profile', Auth::guard('client')->user()->country_code) == $country->phone_code) selected @endif>
                                                        {{ $country->phone_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('phone')
                                            <div id="phoneError" class="error-message mb-1 text-danger">{{ $message }}</div>
                                        @enderror
                                        @error('country_code_profile')
                                            <div id="country_code_profileError" class="error-message mb-1 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 position-relative">
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="{{ Auth::guard('client')->user()->email ?? null }}"
                                            value="{{ old('email', Auth::guard('client')->user()->email ?? null) }}" required>
                                        <i class="fas fa-envelope form-icon"></i>
                                        @error('email')
                                            <div id="emailError" class="error-message mb-1 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 position-relative">
                                        <input type="text" id="birthday" name="birth_date" class="form-control"
                                            placeholder="{{ Auth::guard('client')->user()->birth_date ?? null }}"
                                            value="{{ old('birth_date', Auth::guard('client')->user()->birth_date ?? null) }}">
                                        <i class="fas fa-calendar-alt form-icon"></i>
                                        @error('birth_date')
                                            <div id="dateError" class="error-message mb-1 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Buttons -->
                                    <div class="mt-4">
                                        <button type="button" class="btn reversed main-color w-25 ms-3"> @lang('auth.cancel')</button>
                                        <button type="submit" class="btn w-25"> @lang('auth.save')</button>
                                    </div>
                                </form>

                            </div>
                            <div class="tab-pane fade" id="v-pills-pass" role="tabpanel"
                                aria-labelledby="v-pills-pass-tab">
                                <form method="POST" action="{{ route('reset.password') }}">
                                    @csrf
                                    <div class="mb-3 position-relative">
                                        <input type="password" class="form-control" name="password" id="passwordInput"
                                        placeholder="@lang('auth.newpass')">
                                        <i class="fas fa-eye form-icon"></i>
                                    </div>

                                    <div class="mb-3 position-relative">
                                        <input type="password" class="form-control" name="password_confirmation" id="passwordInput"
                                        placeholder="@lang('auth.newpass')">
                                        <i class="fas fa-eye-slash form-icon"></i>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="mt-4">
                                        <button type="button" class="btn reversed main-color w-25 ms-3"> @lang('auth.cancel')</button>
                                        <button type="submit" class="btn w-25"> @lang('auth.save')</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
