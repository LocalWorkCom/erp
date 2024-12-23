  <!-- delivery details modal -->
  <div class="delivery-modal modal fade" tabindex="-1" id="deliveryModal" aria-labelledby="deliveryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-lg">
      <div class="modal-content">
        <div class="modal-header border-0">
          <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"
            onclick="showFirstPhase()"></button>
        </div>
        <div class="modal-body">
          <h3 class="text-center fw-bold mb-4"> ابدأ طلبك الان </h3>
          <ul class="nav nav-pills main-pills px-0 mb-3 justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item ms-3" role="presentation">
              <button class="nav-link active" id="pills-delivery-tab" data-bs-toggle="pill"
                data-bs-target="#pills-delivery" type="button" role="tab" aria-controls="pills-delivery"
                aria-selected="true">
                <div class="icon">
                  <img src="SiteAssets/images/delivery-icon.png" alt="" />
                </div>
                <h6 class="me-2">التوصيل</h6>
              </button>
            </li>
            <li class="nav-item ms-3 " role="presentation">
              <button class="nav-link" id="pills-takeaway-tab" data-bs-toggle="pill" data-bs-target="#pills-takeaway"
                type="button" role="tab" aria-controls="pills-takeaway" aria-selected="false">
                <div class="icon">
                  <img src="SiteAssets/images/takeaway-icon.png" alt="" />
                </div>
                <h6 class="me-2">الإستلام</h6>
              </button>
            </li>

          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-delivery" role="tabpanel"
              aria-labelledby="pills-delivery-tab">
              <div class="first-phase">
                <h5 class="fw-bold">
                  تحديد موقع التوصيل
                </h5>
                <div class="search-group ">
                  <span class="search-icon">
                    <i class="fas fa-search"></i>
                  </span>
                  <input type="text" class="form-control" placeholder="ابحث عن الموقع" />
                </div>
                <div class="map position-relative my-3">
                  <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3453.025253043487!2d31.22420217605614!3d30.064810617604635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x145841cef6b62cc1%3A0x31bc8779f7ab8dd5!2z2YXYt9i52YUg2KfZhNmD2YjYqg!5e0!3m2!1sen!2seg!4v1734860419141!5m2!1sen!2seg"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                  </iframe>
                  <div class="notes">
                    <small> تسجيل الدخول لاستخدام عناوينك المحفوظة</small>
                    <button class="btn"> تسجيل الدخول</button>
                  </div>
                </div>
                <div class="tab-footer justify-content-between d-flex align-items-center">
                  <div>
                    <h6 class="fw-bold">
                      موقع التوصيل
                    </h6>
                    <p>
                      <i class="fas fa-map-marker-alt main-color ms-2"></i>
                      مصدق الدقى و المهندسين وجيزه
                    </p>
                  </div>
                  <button class="btn reversed main-color fw-bold" type="button">
                    تعديل
                  </button>
                  <button type="submit" class="btn" onclick="showSecondPhase()">تأكيد العنوان</button>
                </div>
              </div>
              <div class="second-phase d-none">
                <h6 class="fw-bold">
                  موقع التوصيل
                </h6>
                <div class="d-flex justify-content-between">
                  <p>
                    <i class="fas fa-map-marker-alt main-color ms-2"></i>
                    مصدق الدقى و المهندسين وجيزه
                  </p>
                  <button class="btn reversed main-color fw-bold" type="button">
                    تعديل
                  </button>
                </div>
                <h6 class="fw-bold mb-3">
                  أكمل موقع التوصيل
                </h6>
                <ul class="delivery-places nav nav-pills px-0 mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill" id="pills-home-tab" data-bs-toggle="pill"
                      data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                      aria-selected="true">
                      <i class="fas fa-city"></i> شقة
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill" id="pills-villa-tab" data-bs-toggle="pill"
                      data-bs-target="#pills-villa" type="button" role="tab" aria-controls="pills-villa"
                      aria-selected="false">
                      <i class="fas fa-home"></i> فيلا
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill" id="pills-work-tab" data-bs-toggle="pill"
                      data-bs-target="#pills-work" type="button" role="tab" aria-controls="pills-work"
                      aria-selected="false">
                      <i class="fas fa-building"></i> مكتب
                    </button>
                  </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                    aria-labelledby="pills-home-tab">
                    <form>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="اسم  الفيلا, مثال فيلا شاهين">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="رقم الفيلا ,مثال  فيلا 12">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder=" 121 مصدق الدقي ,المهندسين  الجيزه">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="علامة مميزة (اختيارى)">
                      </div>
                      <div class="mb-3">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="  ادخل رقم الهاتف  ,مثال01029063398">
                          <select class="form-select country-dropdown me-3" style="max-width: 100px;">
                            <option value="eg" selected>+20</option>
                            <option value="ae">+971</option>
                            <option value="jo">+962</option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane fade" id="pills-villa" role="tabpanel" aria-labelledby="pills-villa-tab">
                    <form>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="اسم  الفيلا, مثال فيلا شاهين">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="رقم الفيلا ,مثال  فيلا 12">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder=" 121 مصدق الدقي ,المهندسين  الجيزه">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="علامة مميزة (اختيارى)">
                      </div>
                      <div class="mb-3">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="  ادخل رقم الهاتف  ,مثال01029063398">
                          <select class="form-select country-dropdown me-3" style="max-width: 100px;">
                            <option value="eg" selected>+20</option>
                            <option value="ae">+971</option>
                            <option value="jo">+962</option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane fade" id="pills-work" role="tabpanel" aria-labelledby="pills-work-tab">
                    <form>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="اسم  الفيلا, مثال فيلا شاهين">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="رقم الفيلا ,مثال  فيلا 12">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder=" 121 مصدق الدقي ,المهندسين  الجيزه">
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="علامة مميزة (اختيارى)">
                      </div>
                      <div class="mb-3">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="  ادخل رقم الهاتف  ,مثال01029063398">
                          <select class="form-select country-dropdown me-3" style="max-width: 100px;">
                            <option value="eg" selected>+20</option>
                            <option value="ae">+971</option>
                            <option value="jo">+962</option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="tab-footer justify-content-end d-flex">
                  <button type="submit" class="btn" onclick="showThirdPhase()">حفظ العنوان</button>
                </div>
              </div>
              <div class="third-phase d-none">
                <div>
                  <h6 class="fw-bold">
                    موقع التوصيل
                  </h6>
                  <div class="d-flex justify-content-between">
                    <p>
                      <i class="fas fa-map-marker-alt main-color ms-2"></i>
                      مصدق الدقى و المهندسين وجيزه
                    </p>
                    <button class="btn reversed main-color fw-bold" type="button">
                      تعديل
                    </button>
                  </div>

                  <p class="text-muted">
                    121 مصدق , الدور 2 , شقة 12 ,رقم الهاتف: 01029061189 ,علامة مميزة: امام ماركت الصفا
                  </p>

                </div>
              </div>
              <!-- <div class="fourth-phase">
                <h5 class="fw-bold">
                  تحديد موقع التوصيل
                </h5>
                <div class="search-group ">
                  <span class="search-icon">
                    <i class="fas fa-search"></i>
                  </span>
                  <input type="text" class="form-control" placeholder="ابحث عن الموقع" />
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <h4 class="my-4 fw-bold">عناويني</h4>
                  <button class="btn fw-bold" type="button">
                    <span>+</span> أضف عنوان
                  </button>
                </div>
                <ul class="list-unstyled px-0">
                  <li class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                      <h5>
                        <i class="fas fa-city text-muted fa-xs ms-2"></i>
                        شقة
                      </h5>
                      <small class="text-muted">
                        250 معادى السريات-قسم المعادى-محافظة القاهرة
                      </small>
                    </div>
                    <div class="dropdown">
                      <a id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                          <button class="dropdown-item w-100">تعديل </button>
                        </li>
                        <li>
                          <button class="dropdown-item w-100"> حذف</button>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <li class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                      <h5>
                        <i class="fas fa-city text-muted fa-xs ms-2"></i>
                        فيلا
                      </h5>
                      <small class="text-muted">
                        250 معادى السريات-قسم المعادى-محافظة القاهرة
                      </small>
                    </div>
                    <div class="dropdown">
                      <a id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                          <button class="dropdown-item w-100">تعديل </button>
                        </li>
                        <li>
                          <button class="dropdown-item w-100"> حذف</button>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <li class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                      <h5>
                        <i class="fas fa-city text-muted fa-xs ms-2"></i>
                        شركة
                      </h5>
                      <small class="text-muted">
                        250 معادى السريات-قسم المعادى-محافظة القاهرة
                      </small>
                    </div>
                    <div class="dropdown">
                      <a id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                          <button class="dropdown-item w-100">تعديل </button>
                        </li>
                        <li>
                          <button class="dropdown-item w-100"> حذف</button>
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
                <div class="tab-footer justify-content-between d-flex align-items-center">
                  <div>
                    <h6 class="fw-bold">
                      موقع التوصيل
                    </h6>
                    <p>
                      <i class="fas fa-map-marker-alt main-color ms-2"></i>
                      مصدق الدقى و المهندسين وجيزه
                    </p>
                  </div>
                  <button class="btn reversed main-color fw-bold" type="button">
                    تعديل
                  </button>
                  <button type="submit" class="btn" onclick="showSecondPhase()">تأكيد العنوان</button>
                </div>
              </div> -->
            </div>
            <div class="tab-pane fade" id="pills-takeaway" role="tabpanel" aria-labelledby="pills-takeaway-tab">

            <div class="bg-dark-gray  py-2">
              <h5 class="text-dark fw-bold text-center">ما هو المطعم الذى تريد الاستلام منه؟</h5>
            </div>
               <div class="d-flex justify-content-end my-2">
                  <button class="btn btn-no-modal"> استخدم موقعى </button>
                </div>
                 <div class="my-2">
              <h5 class="text-dark fw-bold"> موقع الاستلام</h5>
              <form class="d-flex mb-1 position-relative search-form">
                <input class="form-control search-input" type="search" placeholder="ابحث عن الفرع المناسب لك"
                  aria-label="Search">
                <i class="fas fa-search search-icon"></i>
              </form>
            </div>

                <div class="location border-bottom mb-1">
                  <div class="d-flex justify-content-between">
                    <h6 class="fw-bold mt-2">
                      <i class="fas fa-map-marker-alt main-color mx-2"></i>فرع المهندسين ممشى اهل مصر
                    </h6>
                    <span class="badge text-success mt-2">مفتوح</span>
                  </div>
                  <p class="text-muted mx-2">12 ممشى اهل مصر12 بجوار كريو كافيه</p>
                  <p class="main-color fw-bold">
                    <i class="fas fa-phone mx-2"></i>0123698745269
                  </p>
                </div>
                <div class="location mb-1">
                  <div class="d-flex justify-content-between">
                    <h6 class="fw-bold mt-2">
                      <i class="fas fa-map-marker-alt main-color mx-2"></i>فرع المهندسين ممشى اهل مصر
                    </h6>
                    <span class="badge text-muted mt-2">مغلق</span>
                  </div>
                  <p class="text-muted mx-2">12 ممشى اهل مصر12 بجوار كريو كافيه</p>
                  <p class="main-color fw-bold">
                    <i class="fas fa-phone mx-2"></i>0123698745269
                  </p>
                </div>

                <div class="location border-red mb-1">
                  <div class="d-flex justify-content-between">
                    <h6 class="fw-bold mt-2">
                      <i class="fas fa-map-marker-alt main-color mx-2"></i>فرع المهندسين ممشى اهل مصر
                    </h6>
                    <span class="badge text-success mt-2">مفتوح</span>
                  </div>
                  <p class="text-muted mx-2">12 ممشى اهل مصر12 بجوار كريو كافيه</p>
                  <p class="main-color fw-bold">
                    <i class="fas fa-phone mx-2"></i>0123698745269
                  </p>
                </div>
                <div class="d-flex justify-content-end my-2">
                  <button class="btn">  ابدأ طلبك </button>
                </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end delivery details modal -->
