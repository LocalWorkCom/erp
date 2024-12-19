<div class="modal-body register px-4" id="registerBody">
    <form method="POST" action="{{ route('website.register') }}">
        @csrf
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}" alt="Logo"
                    height="110">
            </div>

            <div class="col-md-7 right-side p-3">
                <h2 class="main-color fw-bold"> @lang('auth.welcome')</h2>
                <h5> @lang('auth.canregister')</h5>

                <!-- Name -->
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" id="nameInput"
                        placeholder=" @lang('auth.nameweb') " required>
                </div>

                <!-- Phone and Country Code -->
                <div class="input-group mb-3">
                    <!-- Phone Input -->
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                        id="phoneInput" placeholder="@lang('auth.phoneplace')" value="{{ old('phone') }}" required>

                    <!-- Country Code Dropdown -->
                    <button class="country-dropdown me-2" data-bs-toggle="dropdown" aria-expanded="false">
                        <small id="selected-country-code">+02</small>
                        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/egypt.png') }}" alt=""
                            width="20">
                    </button>

                    <ul class="dropdown-menu">
                        @foreach (GetCountries() as $country)
                            <li>
                                <a class="dropdown-item country-item" href="#"
                                    data-country-code="{{ $country->phone_code }}"
                                    data-country-flag="{{ asset($country->flag) }}">
                                    {{ $country->phone_code }}
                                    <img src="{{ asset($country->flag) }}" alt="{{ $country->name }}" width="20px">
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Hidden Input for Country Code -->
                    <input type="hidden" name="country_code" id="countryCodeInput"
                        value="{{ old('country_code', '+02') }}">

                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" id="emailInput"
                        placeholder=" @lang('auth.emailweb')" required>
                </div>

                <!-- Password -->
                <div class="input-group position-relative mb-3">
                    <input type="password" name="password" class="form-control" id="passwordInput"
                        placeholder=" @lang('auth.passweb') " required>
                    <button class="input-group-eye position-absolute" type="button" id="togglePassword">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>

                <!-- Date of Birth -->
                <div class="input-group mb-3">
                    <input type="date" name="date_of_birth" class="form-control" id="dobInput"
                        placeholder="@lang('auth.date') ">
                </div>

                <button type="submit" class="btn py-3 mb-2 w-100">@lang('auth.newuser')</button>

                <p class="text-center">
                    <small>
                        @lang('auth.isexist')
                        <a href="#" class="main-color text-decoration-underline" id="showLoginLink"
                            aria-label="@lang('auth.login')">@lang('auth.login')</a>
                    </small>
                </p>

                <p class="text-center">
                    <small>

                        <span class="text-muted">@lang('auth.police')</span>
                        <a href="{{ route('privacy') }}" class="main-color text-decoration-underline" aria-label="@lang('auth.privacyweb') ">
                            @lang('auth.privacyweb')
                        </a> 
                        <a href="{{ route('terms') }}" class="main-color text-decoration-underline" aria-label="@lang('auth.policeweb') ">
                            @lang('auth.policeweb')
                        </a>

                    </small>
                </p>
            </div>

            <div class="col-md-5 login-background">
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/login-chef-backgound.png') }}"
                    alt="">
            </div>
        </div>
    </form>
</div>
<script>
    // Handle the country selection from the dropdown
    document.querySelectorAll('.country-item').forEach(item => {
        item.addEventListener('click', function() {
            var countryCode = this.getAttribute('data-country-code');
            var countryFlag = this.getAttribute('data-country-flag');

            // Update the country code and flag display
            document.getElementById('selected-country-code').innerText = countryCode;
            document.getElementById('countryCodeInput').value = countryCode;

            // Optional: Update the flag displayed on the button
            document.querySelector('.country-dropdown img').src = countryFlag;
        });
    });
</script>
