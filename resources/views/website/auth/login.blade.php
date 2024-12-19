<div class="modal-body login d-none px-4" id="loginBody">
    <form method="POST" action="{{ route('website.login') }}">
        @csrf
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}" alt="Logo" height="110">
            </div>

            <div class="col-md-7 right-side p-3">
                <h2 class="main-color fw-bold">@lang('auth.welcome')</h2>
                <h5>@lang('auth.getlogin')</h5>

                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="phone" id="phoneInput" placeholder="@lang('auth.phoneplace')" value="{{ old('phone') }}">
                    <button class="country-dropdown me-2" data-bs-toggle="dropdown" aria-expanded="false">
                        <small>+02</small>
                        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/egypt.png') }}" alt="">
                    </button>
                    <ul class="dropdown-menu">
                        @foreach (GetCountries() as $country)
                            <li>
                                <a class="dropdown-item" href="#">{{ $country->phone_code }}
                                    <img src="{{ $country->flag }}" alt="" width="50px">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>



                <div class="input-group position-relative mb-3">
                    <input type="password" class="form-control" name="password" id="passwordInput" placeholder="@lang('auth.passplace')">
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
                        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}" alt="Facebook" class="ms-2" height="20">
                        <span>@lang('auth.facebook')</span>
                    </a>

                    <a class="social-media-btn d-flex align-items-center" href="#">
                        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/google-icon.png') }}" alt="Google" class="ms-2" height="20">
                        <span>@lang('auth.google')</span>
                    </a>
                </div>

                <p class="text-center">
                    <small>
                        <span class="text-dark">@lang('auth.newuser')</span>
                        <a href="#" class="main-color text-decoration-underline" id="showRegisterLink" aria-label="@lang('auth.signup')">@lang('auth.signup')</a>
                    </small>
                </p>
            </div>

            <div class="col-md-5 login-background">
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/login-chef-backgound.png') }}" alt="">
            </div>
        </div>
    </form>
</div>
<script
>
document.querySelectorAll('.dropdown-item').forEach(item => {
    item.addEventListener('click', function () {
        const countryCode = this.getAttribute('data-country-code');
        const phoneInput = document.getElementById('phoneInput');
        const countryDropdown = document.querySelector('.country-dropdown small');

        // Set the country code to the button text
        countryDropdown.textContent = `+${countryCode}`;

        // Optionally, you can set the country code in a hidden input or the phone field itself
        document.getElementById('countryCode').textContent = `+${countryCode}`;  // Update the display
    });
});

</script>
