
  <!-- Forget Body -->
  <div class="modal-body forget d-none px-4" id="forgetBody">
    <div class="row">
      <div class="col-12 d-flex justify-content-center">
        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}" alt="Logo" height="110">
      </div>

      <div class="col-md-7 right-side p-3">
        <h2 class="main-color fw-bold py-3">نسيت كلمة المرور؟</h2>
        <h5>لإعادة تعيين كلمة المرور الرجاء ادخال رقم الهاتف</h5>
        <div class="input-group py-md-4 py-sm-2">
          <input type="text" class="form-control py-2" id="phoneInput"
            placeholder="ادخل رقم الهاتف ,مثال01029063398">
          <button class="country-dropdown me-2" data-bs-toggle="dropdown" aria-expanded="false">
            <small>+02</small>
            <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/egypt.png') }}" alt="">
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#"> <small> +02</small> <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/egypt.png') }}"
                  alt=""></a></li>
          </ul>
        </div>
        <button type="submit" class="btn w-100" id="sendForgetButton">ارسال</button>
      </div>
      <div class="col-md-5 login-background">
        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/login-chef-backgound.png') }}" alt="">
      </div>
    </div>
  </div>

  <!-- OTP-sent Body -->
  <div class="modal-body otp-sent d-none px-4" id="otpBody">
    <div class="row">
      <div class="col-12 d-flex justify-content-center">
        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}" alt="Logo" height="110">
      </div>

      <div class="col-md-7 right-side p-3">
        <h2 class="main-color fw-bold py-3">تأكيد رقم الهاتف</h2>
        <h5>تم ارسال كود لرقم الهاتف المسجل لدينا عن طريق الواتس اب</h5>
        <h4 class="main-color fw-bold py-3">+0201165998745</h4>
        <div class="code-input" id="codeInputForm">
          <input class="m-1" type="text" maxlength="1" id="digit1" onkeyup="moveToNext(this, 'digit2')">
          <input class="m-1" type="text" maxlength="1" id="digit2" onkeyup="moveToNext(this, 'digit3')"
            onkeydown="moveToPrevious(event, 'digit1')">
          <input class="m-1" type="text" maxlength="1" id="digit3" onkeyup="moveToNext(this, 'digit4')"
            onkeydown="moveToPrevious(event, 'digit2')">
          <input class="m-1" type="text" maxlength="1" id="digit4" onkeydown="moveToPrevious(event, 'digit3')">
        </div>
        <p class="py-2" id="timer"></p>
        <div class="d-flex justify-content-between flex-wrap">
          <p class="text-muted">لم أتلقى رمز التفعيل ؟</p>
          <a href="#" class="main-color">اعادة ارسال رمز التفعيل</a>
        </div>
        <button type="submit" class="btn w-100" id="sendOtpButton">ارسال</button>
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
        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}" alt="Logo" height="110">
      </div>

      <div class="col-md-7 right-side p-3">
        <h2 class="main-color fw-bold py-3">تأكيد رقم الهاتف</h2>
        <h5>تم ارسال كود لرقم الهاتف المسجل لدينا عن طريق الواتس اب</h5>
        <h4 class="main-color fw-bold py-3">+0201165998745</h4>
        <div class="text-center">
          <img src="./SiteAssets/images/donee.png" alt="" height="100" class="mb-3">
          <p class="fw-bold">تم التحقق بنجاح</p>
        </div>
      </div>
      <div class="col-md-5 login-background">
        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/login-chef-backgound.png') }}" alt="">
      </div>
    </div>
  </div>
  <!-- Reset Body -->
  <div class="modal-body reset-pass d-none px-4" id="resetBody">
    <div class="row">
      <div class="col-12 d-flex justify-content-center">
        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}" alt="Logo" height="110">
      </div>
      <div class="col-md-7 right-side p-3">
        <h2 class="main-color fw-bold py-3">ادخل كلمة مرور جديدة</h2>
        <div class="input-group position-relative mb-3">
          <input type="password" class="form-control" id="passwordInput" placeholder="ادخل كلمة المرور الجديدة">
          <button class="input-group-eye position-absolute" type="button" id="togglePassword">
            <i class="fas fa-eye" id="eyeIcon"></i>
          </button>
        </div>

        <div class="input-group position-relative mb-3">
          <input type="password" class="form-control" id="passwordInput2" placeholder="ادخل كلمة المرور الجديدة">
          <button class="input-group-eye position-absolute" type="button" id="togglePassword2">
            <i class="fas fa-eye" id="eyeIcon2"></i>
          </button>
        </div>

        <button type="submit" class="btn w-100">تأكيد</button>
      </div>
      <div class="col-md-5 login-background">
        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/login-chef-backgound.png') }}" alt="">
      </div>
    </div>
  </div>
