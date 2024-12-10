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
                <li class="slide__category"><span class="category-name">@lang('sidebar.Main')</span></li>
                <!-- End::slide__category -->

                <li class="slide">
                    <a href="{{ route('home') }}" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-desktop'></i>
                        </span>
                        <span class="side-menu__label">@lang('sidebar.Dashboards')</span>
                    </a>
                </li>
                <!-- End::slide -->
                <!-- Start::slide__category -->
                {{-- <li class="slide__category"><span class="category-name">@lang('sidebar.client_side')</span></li> --}}
                <!-- End::slide__category -->
                <li class="slide">
                    <a href="{{ route('client.index') }}" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-desktop'></i>
                        </span>
                        <span class="side-menu__label">@lang('sidebar.clients')</span>
                    </a>
                </li>
                <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-food-menu'></i>
                        </span>
                        <span class="side-menu__label">@lang('sidebar.Resturants') </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                @lang('sidebar.Branches')
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{{ route('branches.list') }}" class="side-menu__item">@lang('sidebar.Branches')
                                    </a>
                                </li>
                                <li class="slide has-sub">
                                    <a href="javascript:void(0);" class="side-menu__item">@lang('sidebar.Floors')
                                        <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                    <ul class="slide-menu child2">
                                        <li class="slide">
                                            <a href="{{ route('floors.list') }}"
                                                class="side-menu__item">@lang('sidebar.Floors') </a>
                                        </li>
                                        <li class="slide has-sub">
                                            <a href="javascript:void(0);" class="side-menu__item">@lang('sidebar.FloorPartition')
                                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                            <ul class="slide-menu child3">
                                                <li class="slide">
                                                    <a href="{{ route('floorPartitions.list') }}"
                                                        class="side-menu__item">@lang('sidebar.FloorPartition') </a>
                                                </li>
                                                <li class="slide">
                                                    <a href="{{ route('tables.list') }}"
                                                        class="side-menu__item">@lang('sidebar.Tables') </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">@lang('sidebar.Dishes')
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}" class="side-menu__item">@lang('sidebar.Cuisines') </a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}" class="side-menu__item">@lang('sidebar.Dishes') </a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}" class="side-menu__item">@lang('sidebar.DishesCategory') </a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}" class="side-menu__item">@lang('sidebar.Recipes') </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </li>
                <!-- End::slide -->

                <!-- Start::slide__category -->
                {{-- <li class="slide__category"><span class="category-name">@lang('sidebar.HR SYSTEM')</span></li> --}}
                <!-- End::slide__category -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">@lang('sidebar.HR SYSTEM')</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">@lang('sidebar.HR SYSTEM') </a>
                        </li>
                        <!-- Start::slide -->
                        <li class="slide">
                            <a href="{{ url('Employee') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Employee') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ route('positions.list') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Positions') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Departments') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Departments') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Shifts') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Shifts') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('TimeTables') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.TimeTables') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Scheduled') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Scheduled') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Attendance') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Attendance') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('FingerDevice') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.FingerDevice') </span>
                            </a>
                        </li>
                        <!-- End::slide -->

                        <!-- Start::slide -->
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-food-menu'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.excuses') </span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>

                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{{ url('blog') }}" class="side-menu__item">@lang('sidebar.excuses') </a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-details') }}" class="side-menu__item">@lang('sidebar.excusesReport')
                                    </a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}" class="side-menu__item">@lang('sidebar.excuseslogs')
                                    </a>
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
                                <span class="side-menu__label">@lang('sidebar.Vacation') </span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>

                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{{ url('blog') }}" class="side-menu__item">@lang('sidebar.Vacation') </a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-details') }}" class="side-menu__item">@lang('sidebar.VacationReport')
                                    </a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('blog-create') }}" class="side-menu__item">@lang('sidebar.VacationTypes')
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- End::slide -->
                    </ul>
                </li>

                <!-- Start::slide__category -->
                {{-- <li class="slide__category"><span class="category-name">@lang('sidebar.Store') </span></li> --}}
                <!-- End::slide__category -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">@lang('sidebar.Store') </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">@lang('sidebar.Store') </a>
                        </li>

                        <!-- Start::slide -->
                        <li class="slide">
                            <a href="{{ url('OppeningBalance') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.OppeningBalance') </span>
                            </a>
                        </li>

                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                @lang('sidebar.Lines')
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="#" class="side-menu__item">@lang('sidebar.Lines')</a>
                                </li>
                                <li class="slide has-sub">
                                    <a href="javascript:void(0);" class="side-menu__item">@lang('sidebar.Division')
                                        <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                    <ul class="slide-menu child3">
                                        <li class="slide">
                                            <a href="#" class="side-menu__item">@lang('sidebar.Division')</a>
                                        </li>
                                        <li class="slide">
                                            <a href="javascript:void(0);" class="side-menu__item">@lang('sidebar.Shilves')
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!-- End::slide -->
                </li>


                {{-- <li class="slide__category"><span class="category-name">@lang('sidebar.Invoices') </span> --}}
                </li>

                <!-- End::slide__category -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">@lang('sidebar.Invoices') </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">@lang('sidebar.Invoices') </a>
                        </li>


                        <!-- Start::slide  Invoices-->
                        <li class="slide">
                            <a href="{{ url('orders') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.orders') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ route('products.list') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Products') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ route('categories.list') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Category') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ route('brands.list') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Brand') </span>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="slide__category"><span class="category-name">@lang('sidebar.Purchase') </span> --}}
                {{-- </li> --}}

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">@lang('sidebar.Purchase') </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">@lang('sidebar.Purchase') </a>
                        </li>

                        <!-- Start::slide  Purchase-->
                        <li class="slide">
                            <a href="{{ url('Purchase') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Purchase') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Vendors') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Vendors') </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End::Purchase -->
                {{-- <li class="slide__category"><span class="category-name">@lang('sidebar.Offers/Discounts') </span></li> --}}


                <!-- End::slide__category -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">@lang('sidebar.Offers/Discounts') </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">@lang('sidebar.Offers && Discounts') </a>
                        </li>



                        <!-- Start::slide  Purchase-->
                        <li class="slide">
                            <a href="{{ route('coupons.list') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Coupon') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Discount') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Discount') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('Offers') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Offers') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ route('gifts.list') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Gifts') </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('lolaityPoint') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.lolaityPoint') </span>
                            </a>
                        </li>
                        <!-- End::Purchase -->
                    </ul>
                </li>
                <!-- Start::slide__category -->
                {{-- <li class="slide__category"><span class="category-name">@lang('sidebar.Transactions') </span></li> --}}
                <!-- End::slide__category -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">@lang('sidebar.Transactions') </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">@lang('sidebar.Transactions') </a>
                        </li>

                        <!-- Start::slide -->
                        <ul>
                            <li class="slide">
                                <a href="{{ url('accordions-collapse') }}" class="side-menu__item">@lang('sidebar.StoreTransactions')
                                </a>
                            </li>
                            <li class="slide">
                                <a href="{{ url('accordions-collapse') }}" class="side-menu__item">@lang('sidebar.ProductTransactions')
                                </a>
                            </li>
                            <li class="slide">
                                <a href="{{ url('carousel') }}" class="side-menu__item">@lang('sidebar.OrderTransactions') </a>
                            </li>

                        </ul>
                        <!-- End::slide -->
                    </ul>
                </li>

                <!-- Start::slide__category -->
                {{-- <li class="slide__category"><span class="category-name">@lang('sidebar.Setting') </span>
                </li> --}}
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class=" side-menu__icon">
                            <i class='bx bx-cube'></i>
                        </span>
                        <span class="side-menu__label">@lang('sidebar.Setting') </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">@lang('sidebar.Setting') </a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('countries') }}" class="side-menu__item">@lang('sidebar.countries') </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('colors.list') }}" class="side-menu__item">@lang('sidebar.colors') </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('sizes.list') }}" class="side-menu__item">@lang('sidebar.size') </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('units.list') }}" class="side-menu__item">@lang('sidebar.Units') </a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('Point_system') }}" class="side-menu__item">@lang('sidebar.Point_system') </a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('Notification') }}" class="side-menu__item">@lang('sidebar.Notification') </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('ExcusesSetting') }}" class="side-menu__item">@lang('sidebar.ExcusesSetting') </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('invoiceSetting') }}" class="side-menu__item">@lang('sidebar.invoiceSetting') </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('leaveSetting') }}" class="side-menu__item">@lang('sidebar.leaveSetting') </a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('leaveNationals') }}" class="side-menu__item">@lang('sidebar.leaveNationals') </a>
                        </li>
                    </ul>
                </li>
                <!-- End::slide -->
                <li class="slide__category"><span class="category-name">@lang('sidebar.website') </span>
                </li>
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
