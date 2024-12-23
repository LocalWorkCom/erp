<div class="modal-body register px-4" id="registerBody">
    <form method="POST" action="{{ route('website.register') }}" id="Register">
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
                    <div id="nameError" class="error-message text-danger"></div>

                </div>

                <!-- Phone and Country Code -->
                <div class="input-group mb-3">
                    <!-- Phone Input -->
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                        id="phoneInput" placeholder="@lang('auth.phoneplace')" value="{{ old('phone') }}" required>
                    <div id="phoneError" class="error-message text-danger"></div>
                    <input type="text" name="country_code" id="countryCodeInput"
                        class="form-control @error('country_code') is-invalid @enderror"
                        value="{{ old('country_code') }}">
                    <div id="country_codeError" class="error-message text-danger"></div>
                    <!-- Country Code Dropdown -->
                    <div class="input-group mb-3">
                        <!-- Display Selected Country Code -->
                        <button class="country-dropdown me-2" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <small id="selected-country-code">{{ old('country_code', '+02') }}</small>
                            <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/egypt.png') }}" alt=""
                                width="20" id="selected-flag">
                        </button>

                        <!-- Country Dropdown List -->
                        <ul class="dropdown-menu">
                            @foreach (GetCountries() as $country)
                                <li>
                                    <a class="dropdown-item country-item" href="#"
                                        data-country-code="{{ $country->phone_code }}"
                                        data-country-flag="{{ asset($country->flag) }}">
                                        {{ $country->phone_code }}
                                        <img src="{{ asset($country->flag) }}" alt="{{ $country->name }}"
                                            width="20px">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Email -->
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" id="emailInput"
                        placeholder=" @lang('auth.emailweb')" required>
                    <div id="emailError" class="error-message text-danger"></div>

                </div>

                <!-- Password -->
                <div class="input-group position-relative mb-3">
                    <input type="password" name="password" class="form-control" id="passwordInput"
                        placeholder=" @lang('auth.passweb') " required>
                    <button class="input-group-eye position-absolute" type="button" id="togglePassword">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                    <div id="passwordError" class="error-message text-danger"></div>

                </div>

                <!-- Date of Birth -->
                <div class="input-group mb-3">
                    <input type="date" name="date_of_birth" class="form-control" id="dateInput"
                        placeholder="@lang('auth.date') ">
                    <div id="dateError" class="error-message text-danger"></div>

                </div>

                <button type="submit" class="btn py-3 mb-2 w-100">@lang('auth.signup')</button>

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
                        <a href="{{ route('privacy') }}" class="main-color text-decoration-underline"
                            aria-label="@lang('auth.privacyweb') ">
                            @lang('auth.privacyweb')
                        </a>
                        <a href="{{ route('terms') }}" class="main-color text-decoration-underline"
                            aria-label="@lang('auth.policeweb') ">
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
@push('scripts')
    <script>
        document.querySelectorAll('.country-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();

                // Update selected country code and flag
                const selectedCode = this.getAttribute('data-country-code');
                const selectedFlag = this.getAttribute('data-country-flag');
                document.getElementById('selected-country-code').textContent = selectedCode;
                document.getElementById('selected-flag').src = selectedFlag;

                // Update hidden input value
                document.getElementById('countryCodeInput').value = selectedCode;
            });
        });

        document.getElementById('Register').addEventListener('submit', function(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => Promise.reject(data));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        window.location.href = "{{ route('home') }}";
                    }
                })
                .catch(error => {
                    if (error.errors) {
                        for (const [field, messages] of Object.entries(error.errors)) {
                            const errorElement = document.getElementById(`${field}Error`);
                            const inputElement = document.querySelector(`[name="${field}"]`);

                            if (errorElement) {
                                errorElement.textContent = messages.join(', ');
                            }

                            if (inputElement) {
                                inputElement.classList.add('is-invalid');
                            }
                        }
                    } else {
                    }
                });
        });
    </script>
@endpush
