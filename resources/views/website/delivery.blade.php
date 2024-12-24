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
                  <h3 class="text-center fw-bold mb-4"> @lang('header.startorder')</h3>
                  <ul class="nav nav-pills main-pills px-0 mb-3 justify-content-center" id="pills-tab" role="tablist">
                      <li class="nav-item ms-3" role="presentation">
                          <button class="nav-link active" id="pills-delivery-tab" data-bs-toggle="pill"
                              data-bs-target="#pills-delivery" type="button" role="tab"
                              aria-controls="pills-delivery" aria-selected="true">
                              <div class="icon">
                                  <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/delivery-icon.png') }}"
                                      alt="" />
                              </div>
                              <h6 class="me-2"> @lang('header.delivery')</h6>
                          </button>
                      </li>
                      <li class="nav-item ms-3 " role="presentation">
                          <button class="nav-link" id="pills-takeaway-tab" data-bs-toggle="pill"
                              data-bs-target="#pills-takeaway" type="button" role="tab"
                              aria-controls="pills-takeaway" aria-selected="false">
                              <div class="icon">
                                  <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/takeaway-icon.png') }}"
                                      alt="" />
                              </div>
                              <h6 class="me-2"> @lang('header.recive')</h6>
                          </button>
                      </li>

                  </ul>
                  <div class="tab-content" id="pills-tabContent">
                      <div class="tab-pane fade show active" id="pills-delivery" role="tabpanel"
                          aria-labelledby="pills-delivery-tab">
                          <div class="first-phase">
                              <h5 class="fw-bold">
                                  @lang('header.accesLocation') </h5>
                              <div class="search-group ">
                                  <span class="search-icon">
                                      <i class="fas fa-search"></i>
                                  </span>
                                  <input type="text" class="form-control" placeholder="@lang('header.search')" />
                              </div>
                              <div class="map position-relative my-3">
                                  <iframe
                                      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3453.025253043487!2d31.22420217605614!3d30.064810617604635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x145841cef6b62cc1%3A0x31bc8779f7ab8dd5!2z2YXYt9i52YUg2KfZhNmD2YjYqg!5e0!3m2!1sen!2seg!4v1734860419141!5m2!1sen!2seg"
                                      width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                      referrerpolicy="no-referrer-when-downgrade">
                                  </iframe>
                                  <div class="notes">
                                      <small> @lang('header.saveaddress')</small>
                                      <button class="btn"> @lang('header.login')</button>
                                  </div>
                              </div>
                              <div class="tab-footer justify-content-between d-flex align-items-center">
                                  <div>
                                      <h6 class="fw-bold">
                                          @lang('header.deliverylocation') </h6>
                                      <p>
                                          <i class="fas fa-map-marker-alt main-color ms-2"></i>
                                          مصدق الدقى و المهندسين وجيزه
                                      </p>
                                  </div>
                                  <button class="btn reversed main-color fw-bold" type="button">
                                      @lang('header.edit') </button>
                                  <button type="submit" id="saveButton" class="btn" onclick="showSecondPhase()">
                                      @lang('header.confirmeaddress') </button>
                              </div>
                          </div>
                          <div class="second-phase d-none">
                              <h6 class="fw-bold">
                                  @lang('header.deliverylocation') </h6>
                              <div class="d-flex justify-content-between">
                                  <p>
                                      <i class="fas fa-map-marker-alt main-color ms-2"></i>
                                      مصدق الدقى و المهندسين وجيزه
                                  </p>
                                  <button class="btn reversed main-color fw-bold" type="button">
                                      @lang('header.edit') </button>
                              </div>
                              <h6 class="fw-bold mb-3">
                                  @lang('header.locationcomplete') </h6>
                              <ul class="delivery-places nav nav-pills px-0 mb-3" id="pills-tab" role="tablist">
                                  <li class="nav-item" role="presentation">
                                      <button class="nav-link active rounded-pill" id="pills-home-tab"
                                          data-bs-toggle="pill" data-bs-target="#pills-home" type="button"
                                          role="tab" aria-controls="pills-home" aria-selected="true">
                                          <i class="fas fa-city"></i> @lang('header.apartment')
                                      </button>
                                  </li>
                                  <li class="nav-item" role="presentation">
                                      <button class="nav-link rounded-pill" id="pills-villa-tab"
                                          data-bs-toggle="pill" data-bs-target="#pills-villa" type="button"
                                          role="tab" aria-controls="pills-villa" aria-selected="false">
                                          <i class="fas fa-home"></i> @lang('header.villa')
                                      </button>
                                  </li>
                                  <li class="nav-item" role="presentation">
                                      <button class="nav-link rounded-pill" id="pills-work-tab" data-bs-toggle="pill"
                                          data-bs-target="#pills-work" type="button" role="tab"
                                          aria-controls="pills-work" aria-selected="false">
                                          <i class="fas fa-building"></i> @lang('header.office')
                                      </button>
                                  </li>
                              </ul>
                              <form method="POST" action="{{ route('saveAddress') }}" id="addressForm"
                                  onsubmit="saveToLocalStorage(event)">
                                  @csrf
                                  <div class="tab-content" id="pills-tabContent">
                                      <!-- Apartment Tab -->
                                      <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                          aria-labelledby="pills-home-tab">
                                          <input type="hidden" class="form-control" name="apartment" value=""
                                              id="apartment">

                                          <div class="mb-3">
                                              <input type="text" class="form-control" name="nameapart"
                                                  placeholder="@lang('header.nameapart')">
                                          </div>
                                          <div class="mb-3 d-flex">
                                              <input type="text" class="form-control w-50 ms-2" name="numapart"
                                                  placeholder="@lang('header.numapart')">
                                              <input type="text" class="form-control w-50 me-2" name="floor"
                                                  placeholder="@lang('header.Floor')">
                                          </div>
                                          <div class="mb-3">
                                              <input type="text" class="form-control" name="addressdetailapart"
                                                  placeholder="@lang('header.addressdetail')">
                                          </div>
                                          <div class="mb-3">
                                              <input type="text" class="form-control" name="markapart"
                                                  placeholder="@lang('header.mark')">
                                          </div>
                                          <div class="mb-3">
                                              <div class="input-group">
                                                  <input type="text" class="form-control"
                                                      placeholder="@lang('header.phoneenter')" name="phoneapart">
                                                  <select id="country" name="country_code_apart"
                                                      class="selectpicker me-2" data-live-search="true">
                                                      @foreach (GetCountries() as $country)
                                                          <option
                                                              data-content='<img src="{{ $country->flag }}" class="flag-icon"> {{ $country->phone_code }}'
                                                              value="{{ $country->phone_code }}">
                                                              {{ $country->phone_code }}
                                                          </option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                          </div>
                                      </div>

                                      <!-- Villa Tab -->
                                      <div class="tab-pane fade" id="pills-villa" role="tabpanel"
                                          aria-labelledby="pills-villa-tab">
                                          <input type="hidden" class="form-control" name="villa" value=""
                                              id="villa">
                                          <div class="mb-3">
                                              <input type="text" class="form-control" name="namevilla"
                                                  placeholder="@lang('header.namevilla')">
                                          </div>
                                          <div class="mb-3">
                                              <input type="text" class="form-control" name="villanumber"
                                                  placeholder="@lang('header.villanumber')">
                                          </div>
                                          <div class="mb-3">
                                              <input type="text" class="form-control" name="addressdetailvilla"
                                                  placeholder="@lang('header.addressdetail')">
                                          </div>
                                          <div class="mb-3">
                                              <input type="text" class="form-control" name="markvilla"
                                                  placeholder="@lang('header.mark')">
                                          </div>
                                          <div class="mb-3">
                                              <div class="input-group">
                                                  <input type="text" class="form-control" name="phonevilla"
                                                      placeholder="@lang('header.phoneenter')">
                                                  <select id="country" name="country_code_villa"
                                                      class="selectpicker me-2" data-live-search="true">
                                                      @foreach (GetCountries() as $country)
                                                          <option
                                                              data-content='<img src="{{ $country->flag }}" class="flag-icon"> {{ $country->phone_code }}'
                                                              value="{{ $country->phone_code }}">
                                                              {{ $country->phone_code }}
                                                          </option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                          </div>
                                      </div>

                                      <!-- Office Tab -->
                                      <div class="tab-pane fade" id="pills-work" role="tabpanel"
                                          aria-labelledby="pills-work-tab">
                                          <input type="hidden" class="form-control" name="office" value=""
                                              id="office">
                                          <div class="mb-3">
                                              <input type="text" class="form-control" name="nameoffice"
                                                  placeholder="@lang('header.nameoffice')">
                                          </div>
                                          <div class="mb-3">
                                              <input type="text" class="form-control" name="numaoffice"
                                                  placeholder="@lang('header.numaoffice')">
                                          </div>
                                          <div class="mb-3">
                                              <input type="text" class="form-control" name="addressdetailoffice"
                                                  placeholder="@lang('header.addressdetail')">
                                          </div>
                                          <div class="mb-3">
                                              <input type="text" class="form-control" name="markoffice"
                                                  placeholder="@lang('header.mark')">
                                          </div>
                                          <div class="mb-3">
                                              <div class="input-group">
                                                  <input type="text" class="form-control" name="phoneoffice"
                                                      placeholder="@lang('header.phoneenter')">
                                                  <select id="country" name="country_code_office"
                                                      class="selectpicker me-2" data-live-search="true">
                                                      @foreach (GetCountries() as $country)
                                                          <option
                                                              data-content='<img src="{{ $country->flag }}" class="flag-icon"> {{ $country->phone_code }}'
                                                              value="{{ $country->phone_code }}">
                                                              {{ $country->phone_code }}
                                                          </option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="tab-footer justify-content-end d-flex">
                                      <button type="submit" class="btn" onclick="saveAddress(event)">
                                          @lang('header.saveaddressc')
                                      </button>
                                  </div>
                              </form>
                          </div>
                          <div class="third-phase d-none" id="thirdPhase">
                              <div>
                                  <h6 class="fw-bold">
                                      @lang('header.deliverylocation') </h6>
                                  <div class="d-flex justify-content-between">
                                      <p id="addressSummary">
                                          <i class="fas fa-map-marker-alt main-color ms-2"></i>
                                      </p>
                                      <button class="btn reversed main-color fw-bold" type="button"
                                          onclick="editAddress()">
                                          @lang('header.edit')
                                      </button>
                                  </div>

                                  <p class="text-muted" id="detailedAddress">
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
                      <div class="tab-pane fade" id="pills-takeaway" role="tabpanel"
                          aria-labelledby="pills-takeaway-tab">

                          <div class="bg-dark-gray  py-2">
                              <h5 class="text-dark fw-bold text-center">ما هو المطعم الذى تريد الاستلام منه؟</h5>
                          </div>
                          <div class="d-flex justify-content-end my-2">
                              <button class="btn btn-no-modal"> استخدم موقعى </button>
                          </div>
                          <div class="my-2">
                              <h5 class="text-dark fw-bold"> موقع الاستلام</h5>
                              <form class="d-flex mb-1 position-relative search-form">
                                  <input class="form-control search-input" type="search"
                                      placeholder="ابحث عن الفرع المناسب لك" aria-label="Search">
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
                              <button class="btn"> ابدأ طلبك </button>
                          </div>

                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- end delivery details modal -->
  @push('scripts')
      <script>
          function saveAddress(event) {
              event.preventDefault();

              const activeTab = document.querySelector('.tab-pane.active');
              if (!activeTab) {
                  alert("Please fill out the address form.");
                  return;
              }

              // Collect data from active tab inputs
              const inputs = activeTab.querySelectorAll('input, select, textarea');
              const addressData = {};
              inputs.forEach(input => {
                  if (input.name) {
                      addressData[input.name] = input.value;
                  }
              });

              // Save to localStorage
              localStorage.setItem("addressData", JSON.stringify(addressData));

              // Display data in third-phase
              displayAddressInThirdPhase();

              // Hide form sections and show third-phase
              document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.add('d-none'));
              document.getElementById('thirdPhase').classList.remove('d-none');
          }

          function displayAddressInThirdPhase() {
              const addressData = JSON.parse(localStorage.getItem("addressData"));

              if (addressData) {
                  const summary = `${addressData.nameapart || addressData.namevilla || addressData.nameoffice || "Address"}: ${
                addressData.addressdetailapart || addressData.addressdetailvilla || addressData.addressdetailoffice || "Details"
            }`;

                  const detailed = `Floor: ${addressData.floor || "-"}, Apt/Villa/Office: ${addressData.numapart || addressData.villanumber || addressData.numaoffice || "-"}.
            Phone: ${addressData.phoneapart || addressData.phonevilla || addressData.phoneoffice || "-"}, Landmark: ${
                addressData.markapart || addressData.markvilla || addressData.markoffice || "-"
            }`;

                  document.getElementById("addressSummary").innerHTML =
                      `<i class="fas fa-map-marker-alt main-color ms-2"></i> ${summary}`;
                  document.getElementById("detailedAddress").textContent = detailed;
              }
          }

          function editAddress() {
              const addressData = JSON.parse(localStorage.getItem("addressData"));

              if (addressData) {
                  // Populate the second-phase inputs with the data
                  const secondPhase = document.querySelector('.second-phase');
                  const inputs = secondPhase.querySelectorAll('input, select, textarea');
                  inputs.forEach(input => {
                      if (addressData[input.name]) {
                          input.value = addressData[input.name];
                      }
                  });

                  // Hide third-phase and show second-phase
                  document.getElementById('thirdPhase').classList.add('d-none');
                  secondPhase.classList.remove('d-none');
              } else {
                  alert("No saved address data to edit.");
              }
          }
      </script>
  @endpush
