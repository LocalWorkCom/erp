<aside class="app-sidebar" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ url('index') }}" class="header-logo">
            <img src="{{ asset('build/assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('build/assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('build/assets/images/brand-logos/desktop-dark.png') }}" alt="logo"
                class="desktop-dark">
            <img src="{{ asset('build/assets/images/brand-logos/toggle-dark.png') }}" alt="logo"
                class="toggle-dark">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">@lang('dashboard.main')</span></li>
                <!-- End::slide__category -->

                <li class="slide">
                    <a href="{{ url('Dashboards') }}" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-desktop'></i>
                        </span>
                        <span class="side-menu__label">@lang('dashboard.Dashboards')</span>
                    </a>
                </li>
                <!-- End::slide -->
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">@lang('dashboard.client_side')</span></li>
                <!-- End::slide__category -->
                <li class="slide">
                    <a href="{{ url('Dashboards') }}" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-desktop'></i>
                        </span>
                        <span class="side-menu__label">@lang('dashboard.clients')</span>
                    </a>
                </li>
                <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-food-menu'></i>
                        </span>
                        <span class="side-menu__label">@lang('dashboard.Resturants') </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                @lang('dashboard.Branches')
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide has-sub">
                                    <a href="javascript:void(0);" class="side-menu__item">@lang('dashboard.Floors')
                                        <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                    <ul class="slide-menu child2">
                                        <li class="slide has-sub">
                                            <a href="javascript:void(0);"
                                                class="side-menu__item">@lang('dashboard.Positions')
                                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                            <ul class="slide-menu child3">
                                                <li class="slide">
                                                    <a href="javascript:void(0);"
                                                        class="side-menu__item">@lang('dashboard.Tables') </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">@lang('dashboard.Dishes')
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}"
                                        class="side-menu__item">@lang('dashboard.Cuisines') </a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}"
                                        class="side-menu__item">@lang('dashboard.Dishes') </a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}"
                                        class="side-menu__item">@lang('dashboard.DishesCategory') </a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}"
                                        class="side-menu__item">@lang('dashboard.Recipes') </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- End::slide -->

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">HR SYSTEM</span></li>
                <!-- End::slide__category -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">@lang('dashboard.HR SYSTEM')</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">@lang('dashboard.HR SYSTEM') </a>
                        </li>
                        <!-- Start::slide -->
                        <li class="slide">
                            <a href="{{ url('Employee') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Employee') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Positions') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Positions') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Departments') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Departments') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Shifts') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Shifts') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('TimeTables') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.TimeTables') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Scheduled') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Scheduled') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Attendance') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Attendance') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('FingerDevice') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.FingerDevice') </span>
                            </a>
                        </li>
                        <!-- End::slide -->

                        <!-- Start::slide -->
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-food-menu'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.excuses') </span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>

                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{{ url('blog') }}"
                                        class="side-menu__item">@lang('dashboard.excuses') </a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-details') }}"
                                        class="side-menu__item">@lang('dashboard.excusesReport') </a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}"
                                        class="side-menu__item">@lang('dashboard.excuseslogs') </a>
                                </li>
                            </ul>
                        </li>

                        <!-- End::slide -->

                        <!-- Start::slide -->
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-food-menu'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Vacation') </span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>

                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{{ url('blog') }}"
                                        class="side-menu__item">@lang('dashboard.Vacation') </a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-details') }}"
                                        class="side-menu__item">@lang('dashboard.VacationReport') </a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}"
                                        class="side-menu__item">@lang('dashboard.VacationTypes') </a>
                                </li>
                            </ul>
                        </li>
                        <!-- End::slide -->
                    </ul>
                </li>

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">@lang('dashboard.Store') </span></li>
                <!-- End::slide__category -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">@lang('dashboard.Store') </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">@lang('dashboard.Store') </a>
                        </li>

                        <!-- Start::slide -->
                        <li class="slide">
                            <a href="{{ url('OppeningBalance') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.OppeningBalance') </span>
                            </a>
                        </li>

                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                @lang('dashboard.Lines') }}
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide has-sub">
                                    <a href="javascript:void(0);"
                                        class="side-menu__item">@lang('dashboard.Division') }}
                                        <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                    <ul class="slide-menu child3">
                                        <li class="slide">
                                            <a href="javascript:void(0);"
                                                class="side-menu__item">@lang('dashboard.Shilves') </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!-- End::slide -->
                </li>


                <li class="slide__category"><span class="category-name">@lang('dashboard.Invoices') </span>
                </li>

                <!-- End::slide__category -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">@lang('dashboard.Invoices') </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">@lang('dashboard.Invoices') </a>
                        </li>


                        <!-- Start::slide  Invoices-->
                        <li class="slide">
                            <a href="{{ url('orders') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.orders') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Products') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Products') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Category') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Category') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Brand') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Brand') </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="slide__category"><span class="category-name">@lang('dashboard.Purchase') </span>
                </li>

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">@lang('dashboard.Purchase') </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">@lang('dashboard.Purchase') </a>
                        </li>

                        <!-- Start::slide  Purchase-->
                        <li class="slide">
                            <a href="{{ url('Purchase') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Purchase') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Vendors') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Vendors') </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End::Purchase -->
                <li class="slide__category"><span
                        class="category-name">@lang('dashboard.Offers/Discounts') </span></li>


                <!-- End::slide__category -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">@lang('dashboard.Offers/Discounts') </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">@lang('dashboard.Offers && Discounts') </a>
                        </li>



                        <!-- Start::slide  Purchase-->
                        <li class="slide">
                            <a href="{{ url('Coupon') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Coupon') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Discount') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Discount') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Offers') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Offers') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Gifts') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.Gifts') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('lolaityPoint') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('dashboard.lolaityPoint') </span>
                            </a>
                        </li>
                        <!-- End::Purchase -->
                    </ul>
                </li>
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">@lang('dashboard.Transactions') </span></li>
                <!-- End::slide__category -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">@lang('dashboard.Transactions') </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">@lang('dashboard.Transactions') </a>
                        </li>

                        <!-- Start::slide -->
                        <ul>
                            <li class="slide">
                                <a href="{{ url('accordions-collapse') }}"
                                    class="side-menu__item">@lang('dashboard.StoreTransactions') </a>
                            </li>
                            <li class="slide">
                                <a href="{{ url('accordions-collapse') }}"
                                    class="side-menu__item">@lang('dashboard.ProductTransactions') </a>
                            </li>
                            <li class="slide">
                                <a href="{{ url('carousel') }}"
                                    class="side-menu__item">@lang('dashboard.OrderTransactions') </a>
                            </li>

                        </ul>
                        <!-- End::slide -->
                    </ul>
                </li>

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">@lang('dashboard.Setting') </span>
                </li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">@lang('dashboard.Setting') </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">@lang('dashboard.Setting') </a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('accordions-collapse') }}"
                                class="side-menu__item">@lang('dashboard.countries') </a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('carousel') }}" class="side-menu__item">@lang('dashboard.colors') </a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('draggable-cards') }}"
                                class="side-menu__item">@lang('dashboard.size') </a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('modals-closes') }}"
                                class="side-menu__item">@lang('dashboard.Units') </a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('Point_system') }}"
                                class="side-menu__item">@lang('dashboard.Point_system') </a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('Notification') }}"
                                class="side-menu__item">@lang('dashboard.Notification') </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('ExcusesSetting') }}"
                                class="side-menu__item">@lang('dashboard.ExcusesSetting') </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('invoiceSetting') }}"
                                class="side-menu__item">@lang('dashboard.invoiceSetting') </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('leaveSetting') }}"
                                class="side-menu__item">@lang('dashboard.leaveSetting') </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('leaveNationals') }}"
                                class="side-menu__item">@lang('dashboard.leaveNationals') </a>
                        </li>
                    </ul>
                </li>
                <!-- End::slide -->
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
