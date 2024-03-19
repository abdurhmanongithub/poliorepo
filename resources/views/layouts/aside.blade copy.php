<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <!--begin::Brand-->
    <div class="brand flex-column-auto" id="kt_brand">
        <!--begin::Logo-->
        <a href="" class="brand-logo">
            <img height="55" width="50" alt="Logo" src="{{ asset('assets/ju_logo.png') }}" />
        </a>
        <span class="font-size-h6">Jimma University</span>
        <!--end::Logo-->
        <!--begin::Toggle-->
        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
            <span class="svg-icon svg-icon svg-icon-xl">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                    height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path
                            d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                            fill="#000000" fill-rule="nonzero"
                            transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                        <path
                            d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                            fill="#000000" fill-rule="nonzero" opacity="0.3"
                            transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </button>
        <!--end::Toolbar-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <!--begin::Menu Container-->
        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
            data-menu-dropdown-timeout="500">
            <!--begin::Menu Nav-->
            <ul class="menu-nav">
                <li class="menu-item" aria-haspopup="true">
                    <a href="/" class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                            <i class="fa fa-chart-bar"></i>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item" aria-haspopup="true">
                    <a href="{{ route('hierarchy') }}" class="menu-link">
                        <span class="menu-icon fa fa-tree"></span>
                        <span class="menu-text">Organizational Structure</span>
                    </a>
                </li>
                {{-- START MENU --}}
                <li class="menu-section">
                    <h4 class="menu-text">Menu</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
                @canany(['organization:view', 'branch:view', 'office-type:view', 'measurement-unit:view',
                    'asset-group:view', 'asset-category:view', 'asset-family:view', 'asset-valuation:view',
                    'asset-valuation-with-year:view', 'asset-valuation-with-condition:view',
                    'asset-valuation-with-vehicle:view'])
                    <li class="menu-item menu-item-submenu {{ Str::startsWith(Route::currentRouteName(), ['organization', 'office-type', 'branch', 'measurement', 'group', 'category', 'family', 'valuation']) ? 'menu-item-open ' : '' }} "
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="menu-icon fa fa-cog"></span>
                            <span class="menu-text">Settings</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @can('organization:view')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('organization.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text {{ Str::startsWith(Route::currentRouteName(), 'organization') ? 'text-primary' : '' }}">
                                                Organizations</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('branch:view')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('branch.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text {{ Str::startsWith(Route::currentRouteName(), 'branch') ? 'text-primary' : '' }}">
                                                Branches</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('office-type:view')
                                    <li class="menu-item " aria-haspopup="true">
                                        <a href="{{ route('office-type.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span
                                                class="menu-text {{ Str::startsWith(Route::currentRouteName(), 'office-type') ? 'text-primary' : '' }}">
                                                Office Types</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('measurement-unit:view')
                                    <li class="menu-item " aria-haspopup="true">
                                        <a href="{{ route('measurement-unit.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text {{ Str::startsWith(Route::currentRouteName(), 'measurement') ? 'text-primary' : '' }}">Measurement
                                                Units</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('asset-group:view')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('group.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text {{ Str::startsWith(Route::currentRouteName(), 'group') ? 'text-primary' : '' }}">Asset
                                                Groups</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('asset-category:view')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('category.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text {{ Str::startsWith(Route::currentRouteName(), 'category') ? 'text-primary' : '' }}">Asset
                                                Categories</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('asset-family:view')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('family.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text {{ Str::startsWith(Route::currentRouteName(), 'family') ? 'text-primary' : '' }}">Asset
                                                Families</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('asset-valuation-type:view')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('mainValuation.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text {{ Str::startsWith(Route::currentRouteName(), 'valuationWithCondition') ? 'text-primary' : '' }}">
                                                Valuation Type</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('asset-year-valuation:view')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('valuationWithYear.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text {{ Str::startsWith(Route::currentRouteName(), 'valuationWithYear') ? 'text-primary' : '' }}">Asset
                                                Year Valuation</span>
                                        </a>
                                    </li>
                                @endcan


                                @can('asset-condition-valuation:view')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('valuationWithCondition.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text {{ Str::startsWith(Route::currentRouteName(), 'valuationWithCondition') ? 'text-primary' : '' }}">Asset
                                                Condition Valuation </span>
                                        </a>
                                    </li>
                                @endcan
                                @can('asset-vehicle-valuation:view')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('valuationWithVehicle.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text {{ Str::startsWith(Route::currentRouteName(), 'valuationWithVehicle') ? 'text-primary' : '' }}">Asset
                                                Vehicle Valuation </span>
                                        </a>
                                    </li>
                                </ul>
                            @endcan
                        </div>
                    </li>

                @endcanany
                @canany('user:view')
                    <li class="menu-item menu-item-submenu {{ Str::startsWith(Route::currentRouteName(), ['user', 'role', 'permission']) ? 'menu-item-open ' : '' }} "
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="menu-icon fa fa-users"></span>
                            <span class="menu-text">User Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @can('user:view')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('user.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text {{ Str::startsWith(Route::currentRouteName(), 'user') ? 'text-primary' : '' }}">
                                                Users</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('user:create')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('user.create') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text {{ Str::startsWith(Route::currentRouteName(), 'user/register') ? 'text-primary' : '' }}">
                                                New Users</span>
                                        </a>
                                    </li>
                                @endcan


                                @can('role:view')
                                    <li class="menu-item " aria-haspopup="true">
                                        <a href="{{ route('role.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span
                                                class="menu-text {{ Str::startsWith(Route::currentRouteName(), 'role') ? 'text-primary' : '' }}">
                                                Roles</span>
                                        </a>
                                    </li>
                                @endcan
                                {{-- @can('role:create')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('permission.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text {{ Str::startsWith(Route::currentRouteName(), 'permission') ? 'text-primary' : '' }}">Permissions</span>
                                        </a>
                                    </li>
                                @endcan --}}
                            </ul>
                        </div>
                    </li>
                @endcanany

                @can('office:view')
                    <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'office') === 0 ? 'menu-item-open ' : '' }} "
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="menu-icon fa fa-building"></span>
                            <span class="menu-text">Offices</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">


                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ route('office.index') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text"> Offices</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                @endcan
                @can('store:view-all')
                    <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'store') === 0 ? 'menu-item-open' : '' }} "
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="menu-icon fa fa-store"></span>
                            <span class="menu-text">Store</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ route('store.index') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">All store</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                @endcan

                @can('shelf:view')
                    <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'shelf') === 0 ? 'menu-item-open' : '' }} "
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="menu-icon  fa fa-table "></span>
                            {{-- <i class="menu-icon fa-duotone fa-shelves"></i> --}}
                            <span class="menu-text">Shelf</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ route('shelf.index') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">All Shelves</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('specification:view')
                    <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'specification') === 0 ? 'menu-item-open' : '' }} "
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="menu-icon fas fa-clipboard-list"></span>

                            <span class="menu-text">Specification</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @can('specification:create')
                                    <li class="menu-item " aria-haspopup="true">
                                        <a href="{{ route('specification.create') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">New Specification</span>
                                        </a>
                                    </li>
                                @endcan

                                <li class="menu-item " aria-haspopup="true">
                                    <a href="{{ route('specification.index') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">All Specification</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @canany(['stock:list', 'stock:create', 'stock:recieve-stock'])
                    <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'stock ') === 0 ? 'menu-item-open' : '' }}  "
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="menu-icon fa fa-shopping-basket"></span>
                            <span class="menu-text">Stock</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @can('stock:create')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('stock.create') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">New Stock</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('stock:view')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('stock.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">All Stocks</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('stock:recieve')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('receive-stock') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Receive Stock</span>
                                        </a>
                                    </li>
                                @endcan
                                {{-- @can('stock-acount:list')
                                    <li class="menu-item " aria-haspopup="true">
                                        <a href="{{ route('accounting.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Stock Valuation</span>
                                        </a>
                                    </li>
                                @endcan --}}

                            </ul>
                        </div>
                    </li>
                @endcanany
                @canany('count-session:view')
                    <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'stock-count') === 0 ? 'menu-item-open' : '' }}  "
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="menu-icon fa flaticon2-writing"></span>
                            <span class="menu-text">Stock Count</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @can('count-session:view')
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('count_session.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Count Session</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                @canany(['asset-issue-request:make', 'my-asset-issue-request:view', 'asset-issue-request:approve',
                    'asset-issue-request:show', 'asset-issue-request-to-office:view', 'asset-return-request:view',
                    'approved-asset-issue-request:view', 'model22:view'])
                    <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'model-20') === 0 ? 'menu-item-open' : '' }}  "
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="menu-icon fa fa-shopping-cart"></span>
                            <span class="menu-text">Requests</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @can('asset-issue-request:make')
                                    <li class="menu-item " aria-haspopup="true">
                                        <a href="{{ route('model-20.create') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text">Make Request</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('my-asset-issue-request:view')
                                    <li class="menu-item " aria-haspopup="true">
                                        <a href="{{ route('model-20.myRequests') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text"> My Requests</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('asset-issue-request:approve')
                                    <li class="menu-item " aria-haspopup="true">
                                        <a href="{{ route('model-20.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text">Approve Request</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('asset-issue-request-to-office:view')
                                    <li class="menu-item " aria-haspopup="true">
                                        <a href="{{ route('model-20.showAllRequest') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text"> All Requests to office</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('approved-asset-issue-request:view')
                                    <li class="menu-item " aria-haspopup="true">
                                        <a href="{{ route('model22.model20') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Approved Requests</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('model22:view')
                                    <li class="menu-item " aria-haspopup="true">
                                        <a href="{{ route('model22.index') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text"> All Receipts</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['my-asset:view', 'all-asset:view', 'asset-transfer-request:make',
                    'asset-transfer-request:view', 'asset-transfer-request:approve', 'unknown-price-asset:assign-price',
                    'returned-asset:view', 'stock-accounting:view', 'asset-return-request:view',
                    'approved-asset-return-request:view'])
                    <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'stock-return.index') === 0 || strpos(Route::currentRouteName(), 'fixed_asset') === 0 ? 'menu-item-open' : '' }}  "
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="menu-icon fa flaticon2-writing"></span>
                            <span class="menu-text">Asset</span>
                            <i class="menu-arrow"></i>
                        </a>
                        @can('my-asset:view')
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item" aria-haspopup="true">
                                        <a class="menu-link" href="{{ route('fixed_asset.index') }}">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">My Assets</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        @endcan
                        @can('all-asset:view')
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item" aria-haspopup="true">
                                        <a class="menu-link" href="{{ route('fixed_asset.all_asset') }}">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text"> Assets</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        @endcan
                        @can('asset-transfer-request:view')
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item" aria-haspopup="true">
                                        <a class="menu-link" href="{{ route('fixed_asset.transfer_requests') }}">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text"> Transfer Requests</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        @endcan
                        @can('asset-return-request:view')
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item" aria-haspopup="true">
                                        <a class="menu-link" href="{{ route('stock-return.index') }}">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Return Requests</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        @endcan
                        @can('approved-asset-return-request:view')
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item" aria-haspopup="true">
                                        <a class="menu-link" href="{{ route('stock-return.approve.accept') }}">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Approved Returns</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        @endcan
                        @can('approved-asset-return-request:view')
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a class="menu-link" href="{{ route('stock-return.approved.PropertyOffice') }}">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Receive Returns Store</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    @endcan

                        @can('valuation-type:all-stocks-unknown-price')
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item" aria-haspopup="true">
                                        <a class="menu-link" href="{{ route('valuation.allStocksUnknownPrice') }}">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Unknown Price </span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        @endcan

                        @can('returned-asset:view')
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('all.stock-return') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text"> Returned Assets</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        @endcan



                    </li>
                @endcanany
                {{-- @endcan --}}

                {{-- <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'lab') === 0 ? 'menu-item-open' : '' }} "
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="menu-icon fas fa-flask"></span>
                        <span class="menu-text">Laboratory</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">

                            <li class="menu-item " aria-haspopup="true">
                                <a href="{{ route('lab.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">All laboratory</span>
                                </a>
                            </li>
                            <li class="menu-item " aria-haspopup="true">
                                <a href="{{ route('lab.structure') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Lab Structures</span>
                                </a>
                            </li>
                            <li class="menu-item " aria-haspopup="true">
                                <a href="{{ route('LabService.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Lab Services</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
                @can('stock-accounting:view')
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ route('accounting.index') }}" class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                                <i class="fa fa-chart-bar"></i>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-text">Accounting</span>
                        </a>
                    </li>
                @endcan



            </ul>
            <!--end::Menu Nav-->
        </div>
        <!--end::Menu Container-->
    </div>
    <!--end::Aside Menu-->
</div>
