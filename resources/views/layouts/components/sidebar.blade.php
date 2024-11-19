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
                <li class="slide__category"><span class="category-name">{{ trans('lang.main') }}</span></li>
                <!-- End::slide__category -->

                <li class="slide">
                    <a href="{{ url('Dashboards') }}" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-desktop'></i>
                        </span>
                        <span class="side-menu__label">{{ trans('lang.Dashboards') }}</span>
                    </a>
                </li>
                <!-- End::slide -->
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">{{ trans('lang.Client_side') }}</span></li>
                <!-- End::slide__category -->
                <li class="slide">
                    <a href="{{ url('Dashboards') }}" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-desktop'></i>
                        </span>
                        <span class="side-menu__label">{{ trans('lang.Clients') }}</span>
                    </a>
                </li>
                <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-food-menu'></i>
                        </span>
                        <span class="side-menu__label">{{ trans('lang.Resturants') }}</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                {{ trans('lang.Branches') }}
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide has-sub">
                                    <a href="javascript:void(0);" class="side-menu__item">{{ trans('lang.Floors') }}
                                        <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                    <ul class="slide-menu child2">
                                        <li class="slide has-sub">
                                            <a href="javascript:void(0);"
                                                class="side-menu__item">{{ trans('lang.Positions') }}
                                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                            <ul class="slide-menu child3">
                                                <li class="slide">
                                                    <a href="javascript:void(0);"
                                                        class="side-menu__item">{{ trans('lang.Tables') }}</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">{{ trans('lang.Dishes') }}
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}"
                                        class="side-menu__item">{{ trans('lang.Cuisines') }}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}"
                                        class="side-menu__item">{{ trans('lang.Dishes') }}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}"
                                        class="side-menu__item">{{ trans('lang.DishesCategory') }}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}"
                                        class="side-menu__item">{{ trans('lang.Recipes') }}</a>
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
                        <span class="side-menu__label">{{ trans('lang.HR SYSTEM') }}</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">{{ trans('lang.HR SYSTEM') }}</a>
                        </li>
                        <!-- Start::slide -->
                        <li class="slide">
                            <a href="{{ url('Employee') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.Employee') }}</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Positions') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.Positions') }}</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Departments') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.Departments') }}</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Shifts') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.Shifts') }}</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('TimeTables') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.TimeTables') }}</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Scheduled') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.Scheduled') }}</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Attendance') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.Attendance') }}</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('FingerDevice') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.FingerDevice') }}</span>
                            </a>
                        </li>
                        <!-- End::slide -->

                        <!-- Start::slide -->
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-food-menu'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.excuses') }}</span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>

                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{{ url('blog') }}"
                                        class="side-menu__item">{{ trans('lang.excuses') }}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-details') }}"
                                        class="side-menu__item">{{ trans('lang.excusesReport') }}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}"
                                        class="side-menu__item">{{ trans('lang.excuseslogs') }}</a>
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
                                <span class="side-menu__label">{{ trans('lang.Vacation') }}</span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>

                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{{ url('blog') }}"
                                        class="side-menu__item">{{ trans('lang.Vacation') }}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-details') }}"
                                        class="side-menu__item">{{ trans('lang.VacationReport') }}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}"
                                        class="side-menu__item">{{ trans('lang.VacationTypes') }}</a>
                                </li>
                            </ul>
                        </li>
                        <!-- End::slide -->
                    </ul>
                </li>

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">{{ trans('lang.Store') }}</span></li>
                <!-- End::slide__category -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">{{ trans('lang.Store') }}</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">{{ trans('lang.Store') }}</a>
                        </li>

                        <!-- Start::slide -->
                        <li class="slide">
                            <a href="{{ url('OppeningBalance') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.OppeningBalance') }}</span>
                            </a>
                        </li>

                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                {{ trans('lang.Lines') }}
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide has-sub">
                                    <a href="javascript:void(0);"
                                        class="side-menu__item">{{ trans('lang.Division') }}
                                        <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                    <ul class="slide-menu child3">
                                        <li class="slide">
                                            <a href="javascript:void(0);"
                                                class="side-menu__item">{{ trans('lang.Shilves') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!-- End::slide -->
                </li>


                <li class="slide__category"><span class="category-name">{{ trans('lang.Invoices') }}</span>
                </li>

                <!-- End::slide__category -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">{{ trans('lang.Invoices') }}</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">{{ trans('lang.Invoices') }}</a>
                        </li>


                        <!-- Start::slide  Invoices-->
                        <li class="slide">
                            <a href="{{ url('orders') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.orders') }}</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Products') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.Products') }}</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Category') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.Category') }}</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Brand') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.Brand') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="slide__category"><span class="category-name">{{ trans('lang.Purchase') }}</span>
                </li>

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">{{ trans('lang.Purchase') }}</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">{{ trans('lang.Purchase') }}</a>
                        </li>

                        <!-- Start::slide  Purchase-->
                        <li class="slide">
                            <a href="{{ url('Purchase') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.Purchase') }}</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Vendors') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.Vendors') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End::Purchase -->
                <li class="slide__category"><span
                        class="category-name">{{ trans('lang.Offers/Discounts') }}</span></li>


                <!-- End::slide__category -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">{{ trans('lang.Offers/Discounts') }}</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">{{ trans('lang.Offers && Discounts') }}</a>
                        </li>



                        <!-- Start::slide  Purchase-->
                        <li class="slide">
                            <a href="{{ url('Coupon') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.Coupon') }}</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Discount') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.Discount') }}</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Offers') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.Offers') }}</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Gifts') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.Gifts') }}</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('lolaityPoint') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">{{ trans('lang.lolaityPoint') }}</span>
                            </a>
                        </li>
                        <!-- End::Purchase -->
                    </ul>
                </li>
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">{{ trans('lang.Transactions') }}</span></li>
                <!-- End::slide__category -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">{{ trans('lang.Transactions') }}</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">{{ trans('lang.Transactions') }}</a>
                        </li>

                        <!-- Start::slide -->
                        <ul>
                            <li class="slide">
                                <a href="{{ url('accordions-collapse') }}"
                                    class="side-menu__item">{{ trans('lang.StoreTransactions') }}</a>
                            </li>
                            <li class="slide">
                                <a href="{{ url('accordions-collapse') }}"
                                    class="side-menu__item">{{ trans('lang.ProductTransactions') }}</a>
                            </li>
                            <li class="slide">
                                <a href="{{ url('carousel') }}"
                                    class="side-menu__item">{{ trans('lang.OrderTransactions') }}</a>
                            </li>

                        </ul>
                        <!-- End::slide -->
                    </ul>
                </li>

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">{{ trans('lang.Setting') }}</span>
                </li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">{{ trans('lang.Setting') }}</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">{{ trans('lang.Setting') }}</a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('accordions-collapse') }}"
                                class="side-menu__item">{{ trans('lang.countries') }}</a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('carousel') }}" class="side-menu__item">{{ trans('lang.colors') }}</a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('draggable-cards') }}"
                                class="side-menu__item">{{ trans('lang.size') }}</a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('modals-closes') }}"
                                class="side-menu__item">{{ trans('lang.Units') }}</a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('Point_system') }}"
                                class="side-menu__item">{{ trans('lang.Point_system') }}</a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('Notification') }}"
                                class="side-menu__item">{{ trans('lang.Notification') }}</a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('ExcusesSetting') }}"
                                class="side-menu__item">{{ trans('lang.ExcusesSetting') }}</a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('invoiceSetting') }}"
                                class="side-menu__item">{{ trans('lang.invoiceSetting') }}</a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('leaveSetting') }}"
                                class="side-menu__item">{{ trans('lang.leaveSetting') }}</a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('leaveNationals') }}"
                                class="side-menu__item">{{ trans('lang.leaveNationals') }}</a>
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
