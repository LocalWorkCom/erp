<aside class="app-sidebar" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ route('dashboard.home') }}" class="header-logo">
            <img src="{{ asset('build/assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('build/assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('build/assets/images/brand-logos/desktop.png') }}" alt="logo" class="desktop-dark">
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
                @can('view dashboard')
                    <li class="slide">
                        <a href="{{ route('dashboard.home') }}" class="side-menu__item">
                            <span class=" side-menu__icon">
                                <i class='bx bx-desktop'></i>
                            </span>
                            <span class="side-menu__label">@lang('sidebar.Dashboards')</span>
                        </a>
                    </li>
                @endcan

                @can('view users')
                    <li class="slide">
                        <a href="{{ route('client.index') }}" class="side-menu__item">
                            <span class=" side-menu__icon">
                                <i class='bi bi-person'></i>
                            </span>
                            <span class="side-menu__label">@lang('sidebar.clients')</span>
                        </a>
                    </li>
                @endcan
                @if (auth()->user()->can('view branches') ||
                        auth()->user()->can('view floors') ||
                        auth()->user()->can('view floor_partitions') ||
                        auth()->user()->can('view Tables') ||
                        auth()->user()->can('view cuisines') ||
                        auth()->user()->can('view dishes') ||
                        auth()->user()->can('view dish_categories') ||
                        auth()->user()->can('view recipes'))
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <span class=" side-menu__icon">
                                <i class='bi bi-shop'></i>
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
                                    @can('view branches')
                                        <li class="slide">
                                            <a href="{{ route('branches.list') }}" class="side-menu__item">@lang('sidebar.Branches')
                                            </a>
                                        </li>
                                    @endcan


                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">@lang('sidebar.Floors')
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            @can('view floors')
                                                <li class="slide">
                                                    <a href="{{ route('floors.list') }}"
                                                        class="side-menu__item">@lang('sidebar.Floors') </a>
                                                </li>
                                            @endcan


                                            <li class="slide has-sub">
                                                <a href="javascript:void(0);" class="side-menu__item">@lang('sidebar.FloorPartition')
                                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                                <ul class="slide-menu child3">
                                                    @can('view floor_partitions')
                                                        <li class="slide">
                                                            <a href="{{ route('floorPartitions.list') }}"
                                                                class="side-menu__item">@lang('sidebar.FloorPartition') </a>
                                                        </li>
                                                    @endcan

                                                    @can('view Tables')
                                                        <li class="slide">
                                                            <a href="{{ route('tables.list') }}"
                                                                class="side-menu__item">@lang('sidebar.Tables') </a>
                                                        </li>
                                                    @endcan

                                                </ul>
                                            </li>

                                        </ul>
                                    </li>

                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">@lang('sidebar.branchMenus')
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            @can('view branch_menu_categories')
                                                <li class="slide">
                                                    <a href="{{ route('branch.categories.list') }}"
                                                        class="side-menu__item">@lang('sidebar.branchMenuCategory') </a>
                                                </li>
                                            @endcan

                                            @can('view branch_menus')
                                                <li class="slide">
                                                    <a href="{{ route('branch.menus.list') }}"
                                                        class="side-menu__item">@lang('sidebar.branchMenu') </a>
                                                </li>
                                            @endcan

                                            @can('view branch_menu_addons')
                                                <li class="slide">
                                                    <a href="{{ route('branch.menu.addons.list') }}"
                                                        class="side-menu__item">@lang('sidebar.branchMenuAddon') </a>
                                                </li>
                                            @endcan

                                            @can('view branch_menu_sizes')
                                                <li class="slide">
                                                    <a href="{{ route('branch.menu.sizes.list') }}"
                                                        class="side-menu__item">@lang('sidebar.branchMenuSize') </a>
                                                </li>
                                            @endcan


                                            <!-- <li class="slide has-sub">
                                                <a href="javascript:void(0);" class="side-menu__item">@lang('sidebar.FloorPartition')
                                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                                <ul class="slide-menu child3">
                                                    @can('view floor_partitions')
                                                        <li class="slide">
                                                            <a href="{{ route('floorPartitions.list') }}"
                                                                class="side-menu__item">@lang('sidebar.FloorPartition') </a>
                                                        </li>
                                                    @endcan

                                                    @can('view Tables')
                                                        <li class="slide">
                                                            <a href="{{ route('tables.list') }}"
                                                                class="side-menu__item">@lang('sidebar.Tables') </a>
                                                        </li>
                                                    @endcan

                                                </ul>
                                            </li> -->

                                        </ul>
                                    </li>


                                </ul>
                            </li>
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">@lang('sidebar.Dishes')
                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                <ul class="slide-menu child2">
                                    @can('view cuisines')
                                        <li class="slide">
                                            <a href="{{ route('dashboard.cuisines.index') }}"
                                                class="side-menu__item">@lang('sidebar.Cuisines')
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view dishes')
                                        <li class="slide">
                                            <a href="{{ route('dashboard.dishes.index') }}"
                                                class="side-menu__item">@lang('sidebar.Dishes')
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view dish_categories')
                                        <li class="slide">
                                            <a href="{{ route('dashboard.dish-categories.index') }}"
                                                class="side-menu__item">@lang('sidebar.DishesCategory')
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view recipes')
                                        <li class="slide">
                                            <a href="{{ route('dashboard.recipes.index') }}"
                                                class="side-menu__item">@lang('sidebar.Recipes')
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view recipes')
                                        <li class="slide">
                                            <a href="{{ route('dashboard.addons.index') }}"
                                                class="side-menu__item">@lang('sidebar.Addons')
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view recipes')
                                        <li class="slide">
                                            <a href="{{ route('dashboard.addon_categories.index') }}"
                                                class="side-menu__item">@lang('sidebar.AddonCategories')
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        </ul>

                    </li>
                @endif
                <!-- End::slide -->
                <!-- End::slide__category -->
                @if (auth()->user()->can('view employees') ||
                        auth()->user()->can('view positions') ||
                        auth()->user()->can('view departments') ||
                        auth()->user()->can('view shifts') ||
                        auth()->user()->can('view timetables') ||
                        auth()->user()->can('view excuses') ||
                        auth()->user()->can('view leave_requests') ||
                        auth()->user()->can('view leave_types'))
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <span class=" side-menu__icon">
                                <i class="bi bi-person-badge"></i>
                            </span>
                            <span class="side-menu__label">@lang('sidebar.HR SYSTEM')</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">@lang('sidebar.HR SYSTEM') </a>
                            </li>
                            <!-- Start::slide -->
                            @can('view employees')
                                <li class="slide">
                                    <a href="{{ route('employees.list') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.Employee') </span>
                                    </a>
                                </li>
                            @endcan
                            @can('view positions')
                                <li class="slide">
                                    <a href="{{ route('positions.index') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.Positions') </span>
                                    </a>
                                </li>
                            @endcan
                            @can('view departments')
                                <li class="slide">
                                    <a href="{{ route('departments.list') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.Departments') </span>
                                    </a>
                                </li>
                            @endcan
                            @can('view shifts')
                                <li class="slide">
                                    <a href="{{ url('Shifts') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.Shifts') </span>
                                    </a>
                                </li>
                            @endcan
                            @can('view timetables')
                                <li class="slide">
                                    <a href="{{ url('TimeTables') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.TimeTables') </span>
                                    </a>
                                </li>
                            @endcan

                            @can('view timetables')
                                <li class="slide">
                                    <a href="{{ url('Scheduled') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.Scheduled') </span>
                                    </a>
                                </li>
                            @endcan
                            @can('view timetables')
                                <li class="slide">
                                    <a href="{{ url('Attendance') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.Attendance') </span>
                                    </a>
                                </li>
                            @endcan

                            <li class="slide">
                                <a href="{{ url('FingerDevice') }}" class="side-menu__item">
                                    <span class="side-menu__label">@lang('sidebar.FingerDevice') </span>
                                </a>
                            </li>

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class="side-menu__label">@lang('sidebar.excuses') </span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>

                                <ul class="slide-menu child2">
                                    @can('view excuses')
                                        <li class="slide">
                                            <a href="{{ url('blog') }}" class="side-menu__item">@lang('sidebar.excuses') </a>
                                        </li>

                                        <li class="slide">
                                            <a href="{{ url('blog-details') }}"
                                                class="side-menu__item">@lang('sidebar.excusesReport')
                                            </a>
                                        </li>

                                        <li class="slide">
                                            <a href="{{ url('blog-create') }}" class="side-menu__item">@lang('sidebar.excuseslogs')
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class="side-menu__label">@lang('sidebar.Vacation') </span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>

                                <ul class="slide-menu child2">
                                    @can('view leave_requests')
                                        <li class="slide">
                                            <a href="{{ url('blog') }}" class="side-menu__item">@lang('sidebar.Vacation') </a>
                                        </li>

                                        <li class="slide">
                                            <a href="{{ url('blog-details') }}"
                                                class="side-menu__item">@lang('sidebar.VacationReport')
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view leave_types')
                                        <li class="slide">
                                            <a href="{{ route('leave-types.list') }}" class="side-menu__item">@lang('sidebar.VacationTypes')
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view leave_settings')
                                        <li class="slide">
                                            <a href="{{ route('leave-settings.list') }}" class="side-menu__item">@lang('sidebar.VacationSettings')
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                            <!-- End::slide -->
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('view stores') ||
                        auth()->user()->can('view opening_balance') ||
                        auth()->user()->can('view lines') ||
                        auth()->user()->can('view divisions') ||
                        auth()->user()->can('view shelves'))
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <span class=" side-menu__icon">
                                <i class="bi bi-shop-window"></i> </span>
                            <span class="side-menu__label">@lang('sidebar.Store') </span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            @can('view stores')
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">@lang('sidebar.Store') </a>
                                </li>
                            @endcan
                            @can('view opening_balance')
                                <li class="slide">
                                    <a href="{{ url('OppeningBalance') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.OppeningBalance') </span>
                                    </a>
                                </li>
                            @endcan

                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    @lang('sidebar.Lines')
                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                <ul class="slide-menu child2">
                                    @can('view lines')
                                        <li class="slide">
                                            <a href="#" class="side-menu__item">@lang('sidebar.Lines')</a>
                                        </li>
                                    @endcan

                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">@lang('sidebar.Division')
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child3">
                                            @can('view divisions')
                                                <li class="slide">
                                                    <a href="#" class="side-menu__item">@lang('sidebar.Division')</a>
                                                </li>
                                            @endcan

                                            @can('view shelves')
                                                <li class="slide">
                                                    <a href="javascript:void(0);"
                                                        class="side-menu__item">@lang('sidebar.Shilves')
                                                    </a>
                                                </li>
                                            @endcan

                                        </ul>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                        <!-- End::slide -->
                    </li>
                @endif

                @if (auth()->user()->can('view einvoices') ||
                        auth()->user()->can('view orders') ||
                        auth()->user()->can('view products') ||
                        auth()->user()->can('view categories') ||
                        auth()->user()->can('view brands'))
                    <!-- End::slide__category -->
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <span class=" side-menu__icon">
                                <i class="bi bi-receipt"></i> </span>
                            <span class="side-menu__label">@lang('sidebar.Invoices') </span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            @can('view einvoices')
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">@lang('sidebar.Invoices') </a>
                                </li>
                            @endcan
                            @can('view orders')
                                <li class="slide">
                                    <a href="{{ url('dashboard/orders') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.orders') </span>
                                    </a>
                                </li>
                            @endcan

                            @can('view products')
                                <li class="slide">
                                    <a href="{{ route('products.list') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.Products') </span>
                                    </a>
                                </li>
                            @endcan

                            @can('view categories')
                                <li class="slide">
                                    <a href="{{ route('categories.list') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.Category') </span>
                                    </a>
                                </li>
                            @endcan
                            @can('view brands')
                                <li class="slide">
                                    <a href="{{ route('brands.list') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.Brand') </span>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endif

                @if (auth()->user()->can('view purchase_invoices') || auth()->user()->can('view vendors'))
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <span class=" side-menu__icon">
                                <i class="bi bi-wallet2"></i> </span>
                            <span class="side-menu__label">@lang('sidebar.Purchase') </span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            @can('view purchase_invoices')
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">@lang('sidebar.Purchase') </a>
                                </li>
                                <li class="slide">
                                    <a href="{{ route('purchases.index') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.Purchase') </span>
                                    </a>
                                </li>
                            @endcan

                            @can('view vendors')
                                <li class="slide">
                                    <a href="{{ route('vendors.index') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.Vendors') </span>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('view coupons') ||
                        auth()->user()->can('view discounts') ||
                        auth()->user()->can('view offers') ||
                        auth()->user()->can('view gifts') ||
                        auth()->user()->can('view point_systems'))
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <span class=" side-menu__icon">
                                <i class="bi bi-gift"></i>                            </span>
                            <span class="side-menu__label">@lang('sidebar.Offers/Discounts') </span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">@lang('sidebar.Offers && Discounts') </a>
                            </li>
                            @can('view offers')
                                <li class="slide">
                                    <a href="{{ route('offers.list') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.Offers') </span>
                                    </a>
                                </li>
                            @endcan

                            @can('view coupons')
                                <li class="slide">
                                    <a href="{{ route('coupons.list') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.Coupon') </span>
                                    </a>
                                </li>
                            @endcan

                            @can('view discounts')
                                <li class="slide">
                                    <a href="{{ route('discounts.list') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.Discount') </span>
                                    </a>
                                </li>
                            @endcan

                            @can('view gifts')
                                <li class="slide">
                                    <a href="{{ route('gifts.list') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.Gifts') </span>
                                    </a>
                                </li>
                            @endcan

                            @can('view point_systems')
                                <li class="slide">
                                    <a href="{{ url('lolaityPoint') }}" class="side-menu__item">
                                        <span class="side-menu__label">@lang('sidebar.lolaityPoint') </span>
                                    </a>
                                </li>
                            @endcan
                            <!-- End::Purchase -->
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('view store_transactions') ||
                        auth()->user()->can('view product_transactions') ||
                        auth()->user()->can('view order_transactions'))
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <span class=" side-menu__icon">
                                <i class="bi bi-arrow-left-right"></i>                            </span>
                            <span class="side-menu__label">@lang('sidebar.Transactions') </span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">@lang('sidebar.Transactions') </a>
                            </li>

                            <!-- Start::slide -->
                            <ul>
                                @can('view store_transactions')
                                    <li class="slide">
                                        <a href="{{ url('accordions-collapse') }}"
                                            class="side-menu__item">@lang('sidebar.StoreTransactions')
                                        </a>
                                    </li>
                                @endcan
                                @can('view product_transactions')
                                    <li class="slide">
                                        <a href="{{ url('accordions-collapse') }}"
                                            class="side-menu__item">@lang('sidebar.ProductTransactions')
                                        </a>
                                    </li>
                                @endcan

                                @can('view order_transactions')
                                    <li class="slide">
                                        <a href="{{ url('carousel') }}" class="side-menu__item">@lang('sidebar.OrderTransactions') </a>
                                    </li>
                                @endcan

                            </ul>
                            <!-- End::slide -->
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->can('view countries') ||
                        auth()->user()->can('view colors') ||
                        auth()->user()->can('view size') ||
                        auth()->user()->can('view units') ||
                        auth()->user()->can('view point_systems') ||
                        auth()->user()->can('view Notification') ||
                        auth()->user()->can('view excuse_settings') ||
                        auth()->user()->can('view einvoice_settings') ||
                        auth()->user()->can('view leave_settings') ||
                        auth()->user()->can('view leave_nationals'))
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <span class=" side-menu__icon">
                                <i class="bi bi-gear"></i>                            </span>
                            <span class="side-menu__label">@lang('sidebar.Setting') </span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">@lang('sidebar.Setting') </a>
                            </li>
                            @can('view countries')
                                <li class="slide">
                                    <a href="{{ route('countries.list') }}" class="side-menu__item">@lang('sidebar.countries')
                                    </a>
                                </li>
                            @endcan
                            @can('view colors')
                                <li class="slide">
                                    <a href="{{ route('colors.list') }}" class="side-menu__item">@lang('sidebar.colors') </a>
                                </li>
                            @endcan
                            @can('view sizes')
                                <li class="slide">
                                    <a href="{{ route('sizes.list') }}" class="side-menu__item">@lang('sidebar.size') </a>
                                </li>
                            @endcan

                            @can('view units')
                                <li class="slide">
                                    <a href="{{ route('units.list') }}" class="side-menu__item">@lang('sidebar.Units') </a>
                                </li>
                            @endcan
                            @can('view roles')
                                <li class="slide">
                                    <a href="{{ route('roles.list') }}" class="side-menu__item">@lang('sidebar.roles') </a>
                                </li>
                            @endcan
                            @can('view permissions')
                                <li class="slide">
                                    <a href="{{ route('permissions.list') }}" class="side-menu__item">@lang('sidebar.permissions')
                                    </a>
                                </li>
                            @endcan
                            {{-- @can('view Notification')
                            {{-- @can('view Notification')
                                <li class="slide">
                                    <a href="{{ url('Notification') }}" class="side-menu__item">@lang('sidebar.Notification') </a>
                                </li>
                            @endcan
                            @can('view excuse_settings')
                                <li class="slide">
                                    <a href="{{ url('ExcusesSetting') }}" class="side-menu__item">@lang('sidebar.ExcusesSetting') </a>
                                </li>
                            @endcan
                            @can('view einvoice_settings')
                                <li class="slide">
                                    <a href="{{ url('invoiceSetting') }}" class="side-menu__item">@lang('sidebar.invoiceSetting') </a>
                                </li>
                            @endcan
                            @can('view leave_settings')
                                <li class="slide">
                                    <a href="{{ url('leaveSetting') }}" class="side-menu__item">@lang('sidebar.leaveSetting') </a>
                                </li>
                            @endcan
                            @can('view leave_nationals')
                                <li class="slide">
                                    <a href="{{ url('leaveNationals') }}" class="side-menu__item">@lang('sidebar.leaveNationals') </a>
                                </li>
                            @endcan --}}
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('view logos') ||
                        auth()->user()->can('view sliders') ||
                        auth()->user()->can('view terms') ||
                        auth()->user()->can('view privacies') ||
                        auth()->user()->can('view returns'))
                    <!-- website -->
                    <li class="slide__category"><span class="category-name">@lang('sidebar.website') </span>
                    </li>
                    @can('view logos')
                        <li class="slide">
                            <a href="{{ route('logos.list') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Logo')</span>
                            </a>
                        </li>
                    @endcan

                    @can('view sliders')
                        <li class="slide">
                            <a href="{{ route('sliders.list') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Slider')</span>
                            </a>
                        </li>
                    @endcan
                    @can('view terms')
                        <li class="slide">
                            <a href="{{ route('terms.list') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Terms')</span>
                            </a>
                        </li>
                    @endcan
                    @can('view privacies')
                        <li class="slide">
                            <a href="{{ route('privacies.list') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Privacy')</span>
                            </a>
                        </li>
                    @endcan
                    @can('view returns')
                        <li class="slide">
                            <a href="{{ route('returns.list') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.Return')</span>
                            </a>
                        </li>
                    @endcan
                    @can('view faqs')
                        <li class="slide">
                            <a href="{{ route('faqs.list') }}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class='bx bx-desktop'></i>
                                </span>
                                <span class="side-menu__label">@lang('sidebar.FAQ')</span>
                            </a>
                        </li>
                    @endcan
                @endif
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
