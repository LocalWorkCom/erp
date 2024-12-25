@extends('website.layouts.master')

@section('content')

<section class="inner-header pt-5 mt-5">
    <div class="container pt-sm-5 pt-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">حسابي </li>
            </ol>
        </nav>
    </div>

</section>
<section class="profile">
    <div class="container pb-sm-5 pb-4">
        <h4 class="my-4 fw-bold">الملف الشخصي </h4>
        <div class="row justify-content-between">
            <div class="col-lg-3">
                <div class="card p-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-profile" type="button" role="tab"
                            aria-controls="v-pills-profile" aria-selected="false">تعديل الملف الشخصى</button>
                        <button class="nav-link " id="v-pills-pass-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-pass" type="button" role="tab" aria-controls="v-pills-pass"
                            aria-selected="true">تعديل كلمة المرور</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card p-4">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                            aria-labelledby="v-pills-profile-tab">
                            <form>
                                <div class="mb-3">
                                    <input type="text" id="name" class="form-control" placeholder="سارة عامر">
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="text" id="mobile" class="form-control"
                                            placeholder="01029063398 ">
                                        <select class="form-select country-dropdown me-3" style="max-width: 100px;">
                                            <option value="eg" selected>+20</option>
                                            <option value="ae">+971</option>
                                            <option value="jo">+962</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 position-relative">
                                    <input type="email" id="email" class="form-control"
                                        placeholder="saamer2019@gmail.com ">
                                    <i class="fas fa-envelope form-icon"></i>
                                </div>

                                <div class="mb-3 position-relative">
                                    <input type="text" id="birthday" class="form-control"
                                        placeholder="تاريخ الميلاد ,مثال 6-11-1999 ">
                                    <i class="fas fa-calendar-alt form-icon"></i>
                                </div>

                                <!-- Buttons -->
                                <div class="mt-4">
                                    <button type="button" class="btn reversed main-color w-25 ms-3">إلغاء</button>
                                    <button type="submit" class="btn w-25">حفظ </button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-pass" role="tabpanel"
                            aria-labelledby="v-pills-pass-tab">
                            <form>
                                <div class="mb-3 position-relative">
                                    <input type="password" class="form-control" id="passwordInput" placeholder="ادخل كلمة المرور الجديدة">
                                      <i class="fas fa-eye form-icon"></i>
                                  </div>

                                  <div class="mb-3 position-relative">
                                    <input type="password" class="form-control" id="passwordInput" placeholder="تأكيد كلمة المرور الجديدة">
                                      <i class="fas fa-eye-slash form-icon"></i>
                                  </div>

                                <!-- Buttons -->
                                <div class="mt-4">
                                    <button type="button" class="btn reversed main-color w-25 ms-3">إلغاء</button>
                                    <button type="submit" class="btn w-25">حفظ </button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
