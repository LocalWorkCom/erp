<div class="modal-body login d-none px-4" id="loginBody">
    <form method="POST" action="{{ route('website.login') }}">
        @csrf
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}" alt="Logo"
                    height="110">
            </div>

            <div class="col-md-7 right-side p-3">
                <h2 class="main-color fw-bold">@lang('auth.welcome')</h2>
                <h5>@lang('auth.getlogin')</h5>

                <!-- Phone Input -->
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
                    <input type="hidden" name="phone_code" id="countryCodeInput"
                        value="{{ old('phone_code', '+02') }}">

                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="input-group position-relative mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        id="passwordInput" placeholder="@lang('auth.passplace')" required>
                    <button class="input-group-eye position-absolute" type="button" id="togglePassword">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <a href="./forget-pass.html">
                    <small>@lang('auth.forgetpass')</small>
                </a>

                <button type="submit" class="btn py-3 my-2 w-100">@lang('auth.login')</button>

                <p class="text-center">
                    <small>@lang('auth.loginsocial')</small>
                </p>

                <div class="d-flex justify-content-center gap-lg-3">
                    <a class="social-media-btn d-flex align-items-center" href="#">
                        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}"
                            alt="Facebook" class="ms-2" height="20">
                        <span>@lang('auth.facebook')</span>
                    </a>

                    <a class="social-media-btn d-flex align-items-center" href="#">
                        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/google-icon.png') }}"
                            alt="Google" class="ms-2" height="20">
                        <span>@lang('auth.google')</span>
                    </a>
                </div>

                <p class="text-center">
                    <small>
                        <span class="text-dark">@lang('auth.newuser')</span>
                        <a href="#" class="main-color text-decoration-underline" id="showRegisterLink"
                            aria-label="@lang('auth.signup')">@lang('auth.signup')</a>
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
<script>
  $('form').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Get form data
    var formData = new FormData(this);

    // Send the AJAX request
    $.ajax({
        url: "{{ route('website.login') }}",  // Route for login
        method: "POST",
        data: formData,
        processData: false,  // Don't process the data
        contentType: false,  // Don't set content-type, let jQuery handle it
        success: function(response) {
            if (response.status) {
                // Redirect to the appropriate page
                window.location.href = response.redirect_url; // Redirect based on role
            }
        },
        error: function(xhr) {
            // If validation errors occur
            var errors = xhr.responseJSON.errors;

            // Reset previous error messages
            $('.is-invalid').removeClass('is-invalid');
            $('.text-danger').remove();

            // Loop through errors and display them on the respective input fields
            $.each(errors, function(field, messages) {
                var inputField = $('input[name="' + field + '"]');
                inputField.addClass('is-invalid');  // Add class to show the error
                inputField.after('<span class="text-danger">' + messages[0] + '</span>'); // Display error message
            });
        }
    });
});

</script>
