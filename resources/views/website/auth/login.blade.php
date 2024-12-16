
                <!-- body-login  -->
                <div class="modal-body login d-none px-4" id="loginBody">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}" alt="Logo" height="110">
                        </div>

                        <div class="col-md-7 right-side p-3">
                            <h2 class="main-color fw-bold">مرحبا بك!</h2>
                            <h5>تسجيل الدخول لتستمتع بتجربة طلب معدة خصيصا لك </h5>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="phoneInput"
                                    placeholder="ادخل رقم الهاتف ,مثال01029063398">
                                <button class="country-dropdown me-2" data-bs-toggle="dropdown"
                                    aria-expanded="false"><small> +02</small> <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/egypt.png') }}"
                                        alt=""></button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"> +02 <img
                                                src="{{ asset('front/AlKout-Resturant/SiteAssets/images/egypt.png') }}" alt=""></a></li>
                                </ul>
                            </div>

                            <div class="input-group position-relative mb-3">
                                <input type="password" class="form-control" id="passwordInput"
                                    placeholder="ادخل كلمة المرور الجديدة">
                                <button class="input-group-eye position-absolute" type="button" id="togglePassword">
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>

                            <a href="./forget-pass.html"> <small> هل نسيت كلمة المرور؟ </small></a>

                            <button type="submit" class="btn py-3 my-2 w-100"> تسجيل الدخول</button>

                            <p class="text-center">
                                <small>
                                    تسجيل الدخول باستخدام شبكات التواصل

                                </small>
                            </p>

                            <div class="d-flex justify-content-center gap-lg-3">
                                <a class="social-media-btn d-flex align-items-center " href="#">
                                    <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}" alt="Facebook" class="ms-2"
                                        height="20">
                                    <span>فيس بوك</span>
                                </a>

                                <a class="social-media-btn d-flex align-items-center " href="#">
                                    <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/google-icon.png') }}" alt="Google" class="ms-2"
                                        height="20">
                                    <span>جوجل</span>
                                </a>
                            </div>
                            <p class="text-center">
                                <small>
                                    <span class="text-dark"> مستخدم جديد؟ </span>
                                    <a href="#" class="main-color text-decoration-underline"
                                        id="showRegisterLink" aria-label="تسجيل حساب">تسجيل حساب</a>

                                </small>
                            </p>
                        </div>

                        <div class="col-md-5 login-background">
                            <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/login-chef-backgound.png') }}" alt="">
                        </div>
                    </div>
                </div>
