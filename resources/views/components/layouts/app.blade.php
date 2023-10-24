<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>Sales Admin</title>
    <link rel="icon" type="image/x-icon" href="../src/assets/img/favicon.ico" />
    <link href="../layouts/vertical-light-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/vertical-light-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="../layouts/vertical-light-menu/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


    <link href="../layouts/vertical-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/vertical-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    @livewireStyles
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="../src/assets/css/light/components/list-group.css" rel="stylesheet" type="text/css">
    <link href="../src/assets/css/light/dashboard/dash_2.css" rel="stylesheet" type="text/css" />

    <link href="../src/assets/css/dark/components/list-group.css" rel="stylesheet" type="text/css">
    <link href="../src/assets/css/dark/dashboard/dash_2.css" rel="stylesheet" type="text/css" />


    <link href="assets/css/apps/scrumboard.css" rel="stylesheet" type="text/css">
    <link href="assets/css/apps/notes.css" rel="stylesheet" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">

    <link href="{{ asset('plugins/font-icons/fontawesome/css/fontawesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/css/elements/avatar.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/widgets/modules-widgets.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}" />

    <link href="{{ asset('assets/css/apps/scrumboard.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/apps/notes.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css"
        class="dashboard-sales" />
    <style>
        aside {
            display: none|important;
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #3b3f5c;
            border-color: #3b3f5c;
        }

        @media (max-width: 480px) {
            .mtmobile {
                margin-bottom: 20px|important;
            }

            .mbmobile {
                margin-bottom: 10px|important;
            }

            .hideonsm {
                display: none|important;
            }

            .inblock {
                display: block;
            }
        }

        .sidebar-theme #compactSidebar {
            background: #191e3a !important;
        }

        .header-container .sidebar-Collapse {
            color: #3B3F5C !important;
        }

        .navbar .navbar-item .nav-item form.form-inline input.search-form-control {
            font-size: 15px;
            background-color: #3B3F5C !important;
            padding-right: 40px;
            padding-top: 12px;
            border: none;
            color: #fff;
            back-shadow: none;
            border-radius: 30px;
        }
    </style>


    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

</head>

<body class=" layout-boxed">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    @include('components.layouts.navbar')
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container " id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        @include('components.layouts.sidebar')
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">


            <!--  BEGIN BREADCRUMBS  -->
            @include('components.layouts.breadcrumbs')

            <!--  END BREADCRUMBS  -->

            <div class="mt-4">
                @yield('content') @if (isset($slot))
                    {{ $slot }}
                @endif
            </div>
            <!--  BEGIN FOOTER  -->
            <div class="d-flex justify-content-center footer-wrapper">
                <div class="footer-section d-flex justify-content-center f-section-1">
                    <p class="d-flex justify-content-center">Copyright Nesgc 2023,
                        All rights reserved.</p>
                </div>

            </div>
            <!--  END CONTENT AREA  -->
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN MODAL -->



    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    @livewireScripts


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <script src="../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../src/plugins/src/waves/waves.min.js"></script>
    <script src="../layouts/vertical-light-menu/app.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>


    <script src="../src/plugins/keypress-2.1.5.min.js"></script>
    <script src="{{ asset('plugins/notification/snackbar/snackbar.min.js') }}"></script>

    <script>
        document.addEventListener('livewire:initialized', () => {

            function noty(msg, option = 1) {
                Snackbar.show({
                    text: msg.toUpperCase(),
                    actionText: 'CERRAR',
                    actionTextColor: '#fff',
                    backgroundColor: option == 1 ? '#3b3f5c' : '#e7515a',
                    pos: 'top-right'
                });
            }

        });
    </script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="https://kit.fontawesome.com/8ec20c0fa9.js" crossorigin="anonymous"></script>
</body>

</html>
