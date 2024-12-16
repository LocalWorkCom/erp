<!-- body-register  -->
<div class="modal-body register px-4" id="registerBody">
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}" alt="Logo" height="110">
        </div>

        <div class="col-md-7 right-side p-3">
            <h2 class="main-color fw-bold">مرحبا بك!</h2>
            <h5> يمكنك انشاء حساب بكل سهولة</h5>

            <div class="input-group mb-3">
                <input type="text" class="form-control" id="nameInput"
                    placeholder="ادخل الاسم كامـلا ,مثال سارة عامر">
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control" id="phoneInput"
                    placeholder="ادخل رقم الهاتف ,مثال01029063398">
                <button class="country-dropdown me-2" data-bs-toggle="dropdown"
                    aria-expanded="false"> +02 <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/egypt.png') }}"
                        alt=""></button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"> <small> +02</small> <img
                                src="{{ asset('front/AlKout-Resturant/SiteAssets/images/egypt.png') }}" alt=""></a></li>
                </ul>
            </div>

            <div class="input-group mb-3">
                <input type="email" class="form-control" id="emailInput"
                    placeholder="ادخل البريد الالكترونى ,مثال saamer2019@gmail.com">
            </div>

            <div class="input-group position-relative mb-3">
                <input type="password" class="form-control" id="passwordInput"
                    placeholder="ادخل كلمة المرور">
                <button class="input-group-eye position-absolute" type="button" id="togglePassword">
                    <i class="fas fa-eye" id="eyeIcon"></i>
                </button>
            </div>

            <button type="submit" class="btn py-3 mb-2 w-100">انشاء حساب</button>

            <p class="text-center">
                <small>
                    هل لديك حساب بالفعل؟
                    <a href="#" class="main-color text-decoration-underline" id="showLoginLink"
                        aria-label="تسجيل الدخول">تسجيل دخول</a>
                </small>
            </p>

            <p class="text-center">
                <small>
                    <span class="text-muted">عند انشاء حساب انت توافق علي</span>
                    <a href="#" class="main-color text-decoration-underline"
                        aria-label="سياسة الخصوصية والشروط والأحكام">
                        سياسة الخصوصية و الشروط و الاحكام
                    </a>
                </small>
            </p>
        </div>

        <div class="col-md-5 login-background">
            <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/login-chef-backgound.png') }}" alt="">
        </div>
    </div>
</div>
