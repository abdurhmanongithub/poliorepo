<html lang="en">
<!--begin::Head-->

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <meta name="description" content="Page with empty content" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->

    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset('assets/css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/brand/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/aside/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
    <!--end::Layout Themes-->
    @stack('css')
    <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/js/pages/crud/forms/widgets/select2.min.js') }}">
    <style>
        .modal-content .select2-container {
            width: 100% !important;
        }

        .modal-content .select2-dropdown {
            width: 100% !important;
        }

        <style>

        /* Custom CSS to wrap long text in select2 options */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            white-space: normal;
            word-wrap: break-word;
        }

        .select2-results__option {
            white-space: normal;
            word-wrap: break-word;
        }
    </style>



    </style>

</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="page-loading">

    <!--begin::Main-->
    <!--begin::Header Mobile-->
    <div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
        <!--begin::Logo-->
        <a href="/">
            <img alt="Logo" src="{{ asset('assets/logo.png') }}" width="40" />
        </a>
        <!--end::Logo-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Aside Mobile Toggle-->
            <button class="p-0 btn burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
                <span></span>
            </button>
            <!--end::Aside Mobile Toggle-->
            <!--begin::Header Menu Mobile Toggle-->
            <button class="p-0 ml-4 btn burger-icon" id="kt_header_mobile_toggle">
                <span></span>
            </button>
            <!--end::Header Menu Mobile Toggle-->
            <!--begin::Topbar Mobile Toggle-->
            <button class="p-0 ml-2 btn btn-hover-text-primary" id="kt_header_mobile_topbar_toggle">
                <span class="svg-icon svg-icon-xl">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path
                                d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                fill="#000000" fill-rule="nonzero" opacity="0.3" />
                            <path
                                d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </button>
            <!--end::Topbar Mobile Toggle-->
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">
        <div class="flex-row d-flex flex-column-fluid page">

            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" style="padding-top: 50px;" id="kt_wrapper">

                <!--begin::Entry-->
                <div class="p-5 flex-column-fluid">
                    <!--begin::Container-->
                    <div class="container mt-6">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <p><strong>Oops Something went wrong</strong></p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @yield('content')

                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Entry-->
            </div>
            <!--end::Content-->
        </div>
        <!--begin::Footer-->
        <div class="py-4 bg-white footer d-flex flex-lg-column" id="kt_footer">
            <!--begin::Container-->
            <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                <!--begin::Copyright-->
                <div class="order-2 text-dark order-md-1">
                    <span class="mr-2 text-muted font-weight-bold">2022 &copy;</span>
                    <a href="#" target="_blank" class="text-dark-75 text-hover-primary">Jimma
                        University</a>
                </div>
                <!--end::Copyright-->
                <!--begin::Nav-->
                <div class="nav nav-dark">
                    <a href="#" target="_blank" class="pl-0 pr-5 nav-link">About</a>
                    <a href="#" target="_blank" class="pl-0 pr-5 nav-link">Team</a>
                    <a href="#" target="_blank" class="pl-0 pr-0 nav-link">Contact</a>
                </div>
                <!--end::Nav-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Footer-->
    </div>
    </div>
    <!--end::Aside-->
    </div>

    <!--end::Main-->
    <!-- begin::User Panel-->
    <div id="kt_quick_user" class="p-10 offcanvas offcanvas-right">
        <!--begin::Header-->
        <div class="pb-5 offcanvas-header d-flex align-items-center justify-content-between">
            <h3 class="m-0 font-weight-bold">User Profile
                <small class="ml-2 text-muted font-size-sm"></small>
            </h3>
            <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
                <i class="ki ki-close icon-xs text-muted"></i>
            </a>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="pr-5 offcanvas-content mr-n5">
            <!--begin::Header-->
            <div class="mt-5 d-flex align-items-center">
                <div class="mr-5 symbol symbol-100">
                    {{-- <div class="symbol-label" style="background-image:url({{ Auth::user()->photo }})"></div> --}}
                    <i class="symbol-badge bg-success"></i>
                </div>
                <div class="d-flex flex-column">
                    {{-- <a href="#"
                        class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{ Auth::user()->name() }}</a> --}}
                    <div class="mt-1 text-muted"></div>
                    <div class="mt-2 navi">
                        <a href="#" class="navi-item">
                            <span class="p-0 pb-2 navi-link">
                                <span class="mr-1 navi-icon">
                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                        <i class="fal fa-id-card-alt"></i>
                                    </span>
                                    {{-- </span>
                                <span class="navi-text text-muted text-hover-primary">{{ Auth::user()->uid }}</span> --}}
                                </span>
                        </a>
                    </div>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Separator-->
            <div class="mt-8 mb-5 separator separator-dashed"></div>
            <!--end::Separator-->
            <!--begin::Nav-->
            <div class="p-0 navi navi-spacer-x-0">
                <!--begin::Item-->
                <a href="#" class="navi-item">
                    <div class="navi-link">
                        <div class="mr-3 symbol symbol-40 bg-light">
                            <div class="symbol-label">
                                <span class="svg-icon svg-icon-md svg-icon-success">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg-->
                                    <i class="far fa-id-card-alt"></i>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                        </div>
                        <div class="navi-text">
                            <a href="{{ 'profile.show' }}">

                                <div class="font-weight-bold">My Profile</div>
                                <div class="text-muted">Account settings and more
                                    <span class="label label-light-danger label-inline font-weight-bold"></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </a>
                <!--end:Item-->
                <!--begin::Item-->
                <form action="{{ 'logout' }}" id="logoutForm" method="POST">@csrf</form>
                <a href="#" onclick="event.preventDefault();$('#logoutForm').submit()" class="navi-item">
                    <div class="navi-link">
                        <div class="mr-3 symbol symbol-40 bg-light">
                            <div class="symbol-label">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
                                    <i class="fal fa-sign-out-alt"></i>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                        </div>
                        <div class="navi-text">
                            <div class="font-weight-bold">Logout</div>
                            <div class="text-muted"></div>
                        </div>
                    </div>
                </a>
                <!--end:Item-->
            </div>
            <!--end::Nav-->
            <!--begin::Separator-->
            <div class="separator separator-dashed my-7"></div>
            <!--end::Separator-->
        </div>
        <!--end::Content-->
    </div>
    <!-- end::User Panel-->
    {{-- <script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script> --}}
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1200
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#6993FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#F3F6F9",
                        "dark": "#212121"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1E9FF",
                        "secondary": "#ECF0F3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#212121",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#ECF0F3",
                    "gray-300": "#E5EAEE",
                    "gray-400": "#D6D6E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#80808F",
                    "gray-700": "#464E5F",
                    "gray-800": "#1B283F",
                    "gray-900": "#212121"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--end::Global Config-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/pages/crud/forms/widgets/select2.min.js') }}"></script>
    <script>
        $('.select2').select2({});
    </script>
    @stack('js')
    <script>
        @if (Session::has('message') && !Session::has('error'))
            $(function() {
                toastr.success(
                    '{{ Session::get('
                                                                                                message ') }}'
                    );
            })
        @endif


        @if (Session::has('success') && !Session::has('error'))
            $(function() {
                // toastr.success('{{ Session::get('
                                                                                    //     success ') }}');
                swal.fire("succcess!", "{{ session('warning') }}", "success");


            })
        @endif
        @if (session('warning'))
            $(function() {
                swal.fire("Error!", "{{ session('warning') }}", "warning");
            })
        @endif

        @if (session('error'))
            $(function() {
                swal.fire("Error!", "{{ session('error') }}", "error");
            })
        @endif
    </script>
</body>

</html>
