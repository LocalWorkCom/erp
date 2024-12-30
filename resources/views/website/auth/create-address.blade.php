@extends('website.layouts.master')

@section('content')
    <section class="inner-header pt-5 mt-5">
        <div class="container pt-sm-5 pt-4">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('auth.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('showAddress') }}"> @lang('header.myaddress')</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> @lang('header.addaddress')</li>
                </ol>
            </nav>
        </div>

    </section>
    <section class="addresses">
        <div class="container pb-sm-5 pb-4">
            <div class="d-flex justify-content-betw
        een align-items-center">
                <h4 class="my-4 fw-bold">
                    {{ $address ? __('Edit Address') : __('Add Address') }}
                </h4>
            </div>
            <div class="card p-5 mt-3 mb-5">
                <div class="first-phase">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h5 class="fw-bold">
                        @lang('header.deliverylocation') </h5>
                    <div class="search-group ">
                        <span class="search-icon">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="  @lang('header.searchlocation')" />
                    </div>
                    <div class="map position-relative my-3">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3453.025253043487!2d31.22420217605614!3d30.064810617604635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x145841cef6b62cc1%3A0x31bc8779f7ab8dd5!2z2YXYt9i52YUg2KfZhNmD2YjYqg!5e0!3m2!1sen!2seg!4v1734860419141!5m2!1sen!2seg"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <div class="tab-footer justify-content-between d-flex align-items-center">
                        <div>

                        </div>
                        <button type="submit" class="btn" onclick="showSecondPhase()">@lang('header.locationcomplete') </button>
                    </div>
                </div>
                <div class="second-phase d-none">
                    <form action="{{ route('handle.Address') }}"
                        method="POST">
                        @csrf
                        <h6 class="fw-bold mb-3">
                            @lang('header.locationcomplete')
                        </h6>
                        <input type="hidden" name="id" value="{{ $address ? $address->id : null }}">
                        <div class="delivery-places px-0 mb-3">
                            <div class="btn-group" role="group" aria-label="Delivery Place Selector">
                                <!-- Apartment Radio Button -->
                                <input type="radio" class="btn-check" name="deliveryPlace" id="radio-home"
                                    autocomplete="off"
                                    {{ old('deliveryPlace', 'apartment') === 'apartment' ? 'checked' : '' }}
                                    value="apartment">
                                <label class="nav-link rounded-pill" for="radio-home">
                                    <i class="fas fa-city"></i> @lang('header.apartment')
                                </label>

                                <!-- Villa Radio Button -->
                                <input type="radio" class="btn-check"
                                    {{ old('deliveryPlace', '') === 'villa' ? 'checked' : '' }} name="deliveryPlace"
                                    value="villa" id="radio-villa" autocomplete="off">
                                <label class="nav-link rounded-pill" for="radio-villa">
                                    <i class="fas fa-home"></i> @lang('header.villa')
                                </label>

                                <!-- Office Radio Button -->
                                <input type="radio" class="btn-check"
                                    {{ old('deliveryPlace', $address ? $address->address_type : '') === 'office' ? 'checked' : '' }}
                                    name="deliveryPlace" value="office" id="radio-work" autocomplete="off">

                                <label class="nav-link rounded-pill" for="radio-work">
                                    <i class="fas fa-building"></i> @lang('header.office')
                                </label>
                            </div>
                        </div>

                        <div class="delivery-content">
                            <div
                                class="delivery-section home-section {{ old('deliveryPlace', $address ? $address->address_type : 'apartment') === 'apartment' ? '' : 'd-none' }}">

                                <div class="mb-3">
                                    <input type="text" class="form-control" name="nameapart"
                                        value="{{ old('nameapart', $address && $address->address_type === 'apartment' ? $address->building : null) }}"
                                        placeholder="@lang('header.nameapart')">
                                    @error('nameapart')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 d-flex ">
                                    <input type="text" class="form-control "
                                        value="{{ old('numapart', $address && $address->address_type === 'apartment' ? $address->apartment_number : null) }}"
                                        name="numapart" placeholder="@lang('header.numapart')">
                                    @error('numapart')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <input type="text" class="form-control me-4"
                                        value="{{ old('floor', $address && $address->address_type === 'apartment' ? $address->floor_number : null) }}"
                                        name="floor" placeholder="@lang('header.Floor')">
                                    @error('floor')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        value="{{ old('addressdetailapart', $address && $address->address_type === 'apartment' ? $address->address : null) }}"
                                        name="addressdetailapart" placeholder="@lang('header.addressdetail')">
                                    @error('addressdetailapart')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        value="{{ old('markapart', $address && $address->address_type === 'apartment' ? $address->notes : null) }}"
                                        name="markapart" placeholder="@lang('header.mark')">
                                    @error('markapart')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                            value="{{ old('phoneapart', $address && $address->address_type === 'apartment' ? $address->address_phone : null) }}"
                                            placeholder="@lang('header.phoneenter')" name="phoneapart">
                                        <select id="country" name="country_code_apart" class="selectpicker me-2"
                                            data-live-search="true">
                                            @foreach (GetCountries() as $country)
                                                <option
                                                    data-content='<img src="{{ $country->flag }}" class="flag-icon"> {{ $country->phone_code }}'
                                                    value="{{ $country->phone_code }}" @if ($address && $address->address_type === 'apartment' && $country->phone_code == $address->country_code)
                                                    selected
                                            @endif>
                                            {{ $country->phone_code }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('phoneenter')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @error('country_code_apart')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div
                                class="delivery-section villa-section {{ old('deliveryPlace', $address ? $address->address_type : '') === 'villa' ? '' : 'd-none' }}">

                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        value="{{ old('namevilla', $address && $address->address_type === 'villa' ? $address->building : null) }}"
                                        name="namevilla" placeholder="@lang('header.namevilla')">
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        value="{{ old('villanumber', $address && $address->address_type === 'villa' ? $address->apartment_number : null) }}"
                                        name="villanumber" placeholder="@lang('header.villanumber')">
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        value="{{ old('addressdetailvilla', $address && $address->address_type === 'villa' ? $address->address : null) }}"
                                        name="addressdetailvilla" placeholder="@lang('header.addressdetail')">
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        value="{{ old('markvilla', $address && $address->address_type === 'villa' ? $address->notes : null) }}"
                                        name="markvilla" placeholder="@lang('header.mark')">
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="phonevilla"
                                            value="{{ old('phonevilla', $address && $address->address_type === 'villa' ? $address->address_phone : null) }}"
                                            placeholder="@lang('header.phoneenter')">
                                        <select id="country" name="country_code_villa" class="selectpicker me-2"
                                            data-live-search="true">
                                            @foreach (GetCountries() as $country)
                                                <option
                                                    data-content='<img src="{{ $country->flag }}" class="flag-icon"> {{ $country->phone_code }}'
                                                    value="{{ $country->phone_code }}" @if ($address && $address->address_type === 'villa' && $country->phone_code == $address->country_code)
                                                    selected
                                            @endif>
                                            {{ $country->phone_code }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div
                                class="delivery-section office-section  work-section {{ old('deliveryPlace', $address ? $address->address_type : '') === 'office' ? '' : 'd-none' }}">

                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        value="{{ old('nameoffice', $address && $address->address_type === 'office' ? $address->building : null) }}"
                                        name="nameoffice" placeholder="@lang('header.nameoffice')">
                                </div>
                                <div class="mb-3 d-flex ">
                                    <input type="text" class="form-control "
                                        value="{{ old('numaoffice', $address && $address->address_type === 'office' ? $address->apartment_number : null) }}"
                                        name="numaoffice" placeholder="@lang('header.numaoffice')">
                                    <input type="text" class="form-control me-4"
                                        value="{{ old('floor', $address && $address->address_type === 'office' ? $address->floor_number : null) }}"
                                        name="floor" placeholder="@lang('header.Floor')">

                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        value="{{ old('addressdetailoffice', $address && $address->address_type === 'office' ? $address->address : null) }}"
                                        name="addressdetailoffice" placeholder="@lang('header.addressdetail')">
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                        value="{{ old('markoffice', $address && $address->address_type === 'office' ? $address->notes : null) }}"
                                        name="markoffice" placeholder="@lang('header.mark')">
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                            value="{{ old('phoneoffice', $address && $address->address_type === 'office' ? $address->address_phone : null) }}"
                                            name="phoneoffice" placeholder="@lang('header.phoneenter')">
                                        <select id="country" name="country_code_office" class="selectpicker me-2"
                                            data-live-search="true">
                                            @foreach (GetCountries() as $country)
                                                <option
                                                    data-content='<img src="{{ $country->flag }}" class="flag-icon"> {{ $country->phone_code }}'
                                                    value="{{ $country->phone_code }}" @if ($address && $address->address_type === 'office' && $country->phone_code == $address->country_code)
                                                    selected
                                            @endif> {{ $country->phone_code }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-footer justify-content-end d-flex">
                            <button type="submit" class="btn"> @lang('header.saveaddressc')</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>

@endsection
@push('scripts')
    <script>
        document.querySelectorAll('.btn-check').forEach((radio) => {
            radio.addEventListener('change', () => {
                document.querySelectorAll('.delivery-section').forEach((section) => {
                    section.classList.add('d-none');
                });

                if (radio.id === 'radio-home') {
                    document.querySelector('.home-section').classList.remove('d-none');
                } else if (radio.id === 'radio-villa') {
                    document.querySelector('.villa-section').classList.remove('d-none');
                } else if (radio.id === 'radio-work') {
                    document.querySelector('.work-section').classList.remove('d-none');
                }
            });
        });
    </script>
@endpush
