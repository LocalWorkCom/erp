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
                    <div id="nameError" class="error-message mb-1 text-danger"></div>

                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <!-- Phone and Country Code -->
                <div class="input-group mb-3">
                    <input type="text" class="form-control  @error('phone') is-invalid @enderror " name="phone"
                        id="phoneInput" placeholder="@lang('auth.phoneplace')" value="{{ old('phone') }}" required>
                    <select id="country" name="country_code" class="selectpicker me-2" data-live-search="true">
                        @foreach (GetCountries() as $country)
                            <option
                                data-content='<img src="{{ $country->flag }}" class="flag-icon"> {{ $country->phone_code }}'
                                value="{{ $country->phone_code }}">{{ $country->phone_code }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div id="phoneError" class="error-message mb-1 text-danger"></div>
                <div id="country_codeError" class="error-message mb-1 text-danger"></div>

                <!-- Email -->
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" id="emailInput"
                        placeholder=" @lang('auth.emailweb')" required>

                </div>
                <div id="emailError" class="error-message mb-1 text-danger"></div>

                <!-- Password -->
                <div class="input-group position-relative mb-3">
                    <input type="password" name="password" class="form-control" id="passwordInput"
                        placeholder=" @lang('auth.passweb') " required>
                    <button class="input-group-eye position-absolute" type="button" id="togglePassword">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>

                </div>
                <div id="passwordError" class="error-message mb-1 text-danger"></div>

                <!-- Date of Birth -->
                <div class="input-group mb-3">
                    <input type="date" name="date_of_birth" class="form-control" id="dateInput"
                        placeholder="@lang('auth.date') ">
                </div>
                <div id="dateError" class="error-message mb-1 text-danger"></div>

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
                const selectedCode = this.getAttribute('data-country-code');
                const selectedFlag = this.getAttribute('data-country-flag');
                document.getElementById('selected-country-code').textContent = selectedCode;
                document.getElementById('selected-flag').src = selectedFlag;
                document.getElementById('countryCodeInput').value = selectedCode;
            });
        });

        document.getElementById('Register').addEventListener('submit', function(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            // Retrieve and parse address data from local storage
            const addressData = localStorage.getItem('addressData');
            if (addressData) {
                formData.append('address', JSON.stringify(addressData));
            }
            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
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
                    } else {}
                });
        });
    </script>
@endpush
