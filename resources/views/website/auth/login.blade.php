<div class="modal-body login d-none px-4" id="loginBody">
    <form method="POST" id="loginForm" action="{{ route('website.login') }}">
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
                    <input type="text" class="form-control @error('email_or_phone') is-invalid @enderror"
                        name="email_or_phone" id="phoneInput" placeholder="@lang('auth.phoneplace')"
                        value="{{ old('email_or_phone') }}" required>
                    @error('email_or_phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

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
                    <input type="text" name="country_code" id="countryCodeInput"
                        value="{{ old('country_code', '+02') }}">

                    @error('country_code')
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

                <a id="showforgetLink">
                    <small>@lang('auth.forgetpass')</small>
                </a>

                <button type="submit" class="btn py-3 my-2 w-100">@lang('auth.login')</button>

                <p class="text-center">
                    <small>@lang('auth.loginsocial')</small>
                </p>

                <div class="d-flex justify-content-center gap-lg-3">
                    <a class="social-media-btn d-flex align-items-center" href="#">
                        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/facebook-icon.png') }}"
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
@section('scripts')
<script>
$(document).ready(function() {
    //debugger;
    $('#loginForm').on('submit', function(event) {
        event.preventDefault();

        // Get form data
        var formData = $(this).serialize();
       // debugger;
        // Send the AJAX request
        $.ajax({
            url: '{{ route('website.login') }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    // Show success message inside the modal
                    $('#loginBody').html(`
                        <div class="text-center">
                            <h3>Login successful!</h3>
                            <p>Welcome, ${response.data.user.name}!</p>
                            <button class="btn btn-primary" onclick="window.location.href='/home'">Go to Dashboard</button>
                        </div>
                    `);

                    // Optionally, set a delay before redirecting to home
                    setTimeout(function() {
                        window.location.href = '/';  // Adjust the redirect path as needed
                    }, 2000);  // Redirect after 2 seconds (optional)
                }
            },
            error: function(response) {
                var errors = response.responseJSON.errors;

                if (response.status === 400 || response.status === 403) {
                    // Handle validation errors
                    var errorMessages = '';
                    $.each(errors, function(key, value) {
                        errorMessages += value.join("\n") + "\n";
                    });

                    // Display the error messages inside the modal
                    $('#loginBody').prepend(`
                        <div class="alert alert-danger">
                            ${errorMessages}
                        </div>
                    `);
                } else {
                    alert('An unexpected error occurred!');
                }
            }
        });
    });
});


</script>
@endsection
