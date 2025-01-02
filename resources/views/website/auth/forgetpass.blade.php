<!-- Forget Body -->
<div class="modal-body forget d-none px-4" id="forgetBody">
    <form method="POST" id="form-forgetBody" action="">
        @csrf
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}" alt="Logo"
                    height="110">
            </div>

            <div class="col-md-7 right-side p-3">
                <h2 class="main-color fw-bold py-3"> @lang('auth.forgetpass') </h2>
                <h5> @lang('auth.forgetmessage') </h5>

                <div class="input-group py-md-4 py-sm-2">
                    <input type="text" class="form-control  @error('phoneforget') is-invalid @enderror "
                        name="phoneforget" id="phoneforgetInput" placeholder="@lang('auth.phoneplace')"
                        value="{{ old('phoneforget') }}" required>
                    <select id="country" name="country_code_forget" class="selectpicker me-2" data-live-search="true"
                        required>
                        @foreach (GetCountries() as $country)
                            <option
                                data-content='<img src="{{ $country->flag }}" class="flag-icon"> {{ $country->phone_code }}'
                                value="{{ $country->phone_code }}">{{ $country->phone_code }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div id="phoneforgetError" class="error-message mb-1 text-danger"style="display:none;"></div>
                <div id="country_code_forgetError" class="error-message mb-1 text-danger"style="display:none;"></div>
                <button type="submit" class="btn w-100"> @lang('auth.send') </button>
            </div>
            <div class="col-md-5 login-background">
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/login-chef-backgound.png') }}"
                    alt="">
            </div>
        </div>
    </form>

</div>

<!-- OTP-sent Body -->
<div class="modal-body otp-sent d-none px-4" id="otpBody">
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}" alt="Logo"
                height="110">
        </div>

        <div class="col-md-7 right-side p-3">
            <h2 class="main-color fw-bold py-3"> @lang('auth.comfirmephone') </h2>
            <h5>@lang('auth.messgesend')</h5>
            <h4 class="main-color fw-bold py-3"> @lang('auth.phone')</h4>
            <div class="code-input" id="codeInputForm">
                <input class="m-1" type="text" maxlength="1" id="digit1" onkeyup="moveToNext(this, 'digit2')">
                <input class="m-1" type="text" maxlength="1" id="digit2" onkeyup="moveToNext(this, 'digit3')"
                    onkeydown="moveToPrevious(event, 'digit1')">
                <input class="m-1" type="text" maxlength="1" id="digit3" onkeyup="moveToNext(this, 'digit4')"
                    onkeydown="moveToPrevious(event, 'digit2')">
                <input class="m-1" type="text" maxlength="1" id="digit4"
                    onkeydown="moveToPrevious(event, 'digit3')">
            </div>
            <p class="py-2" id="timer"></p>
            <div class="d-flex justify-content-between flex-wrap">
                <p class="text-muted">@lang('auth.notrecive')</p>
                <a href="#" class="main-color"> @lang('auth.resend')</a>
            </div>
            <button type="submit" class="btn w-100" id="sendOtpButton"> @lang('auth.send')</button>
        </div>
        <div class="col-md-5 login-background">
            <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/login-chef-backgound.png') }}" alt="">
        </div>
    </div>
</div>

<!-- OTP-done Body -->
<div class="modal-body otp-done d-none px-4" id="otpDoneBody">
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}" alt="Logo"
                height="110">
        </div>

        <div class="col-md-7 right-side p-3">
            <h2 class="main-color fw-bold py-3"> @lang('auth.comfirmephone')</h2>
            <h5>@lang('auth.messgesend')</h5>
            <h4 class="main-color fw-bold py-3"> @lang('auth.phone')</h4>
            <div class="text-center">
                <img src="./SiteAssets/images/donee.png" alt="" height="100" class="mb-3">
                <p class="fw-bold"> @lang('auth.success')</p>
            </div>
        </div>
        <div class="col-md-5 login-background">
            <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/login-chef-backgound.png') }}" alt="">
        </div>
    </div>
</div>
<!-- Reset Body -->
<div class="modal-body reset-pass d-none px-4" id="resetBody">
    <form id="resetPasswordForm" method="POST" action="{{ route('reset.password') }}">
        @csrf
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}"
                    alt="Logo" height="110">
            </div>
            <div class="col-md-7 right-side p-3">
                <h2 class="main-color fw-bold py-3">@lang('auth.newpass')</h2>

                <!-- Password Input -->
                <div class="input-group position-relative mb-3">
                    <input type="password" class="form-control" id="passwordInput" name="passwordforget"
                        placeholder="@lang('auth.newpass')" required>
                    <button class="input-group-eye position-absolute" type="button" id="togglePassword">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>

                <!-- Confirm Password Input -->
                <div class="input-group position-relative mb-3">
                    <input type="password" class="form-control" id="passwordInput2"
                        name="passwordforget_confirmation" placeholder="@lang('auth.newpass')" required>
                    <button class="input-group-eye position-absolute" type="button" id="togglePassword2">
                        <i class="fas fa-eye" id="eyeIcon2"></i>
                    </button>
                </div>

                <!-- Error message -->
                <div id="passwordforgetError" class="text-danger d-none">
                    @lang('auth.password_mismatch')
                </div>
                <input type="hidden" name="phone" id="hidden-phone">
                <div id="resetPasswordErrors" class="alert alert-danger d-none"></div>

                <!-- Submit Button -->
                <button type="submit" class="btn w-100">@lang('auth.confirm')</button>
            </div>

            <!-- Background Image -->
            <div class="col-md-5 login-background">
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/login-chef-backgound.png') }}"
                    alt="">
            </div>
        </div>
    </form>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#forgetBody form').on('submit', function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $('#phoneError').hide().text('');
                // Send the AJAX request for phone validation
                $.ajax({
                    url: '{{ route('check.phone') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#forgetBody').addClass('d-none');
                            $('#resetBody').removeClass('d-none');
                            $('#hidden-phone').prop('value', response.phone);
                        }
                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        if (response.status === 400 || response.status === 422) {
                            var errorMessages = '';
                            $.each(errors, function(key, value) {
                                errorMessages += value.join("\n") + "\n";
                            });
                            $('#phoneforgetError').show().text(errorMessages);
                        } else {}
                    }
                });
            });

            document.querySelector('#resetPasswordForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const errorsDiv = document.querySelector('#resetPasswordErrors');

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'error') {
                            // Show validation errors
                            errorsDiv.classList.remove('d-none');
                            errorsDiv.innerHTML = '';
                            Object.keys(data.errors).forEach(field => {
                                errorsDiv.innerHTML +=
                                    `<p>${data.errors[field].join('<br>')}</p>`;
                            });
                        } else {
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });



        });

        $('#togglePassword, #togglePassword2').on('click', function() {
            var input = $(this).siblings('input');
            var icon = $(this).find('i');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    </script>
@endpush
