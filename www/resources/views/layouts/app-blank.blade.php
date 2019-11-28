<!DOCTYPE html>

<html lang="en" class="default-style">

<head>
    <title>@yield('title', config('app.name'))</title>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('assets/logos/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/logos/favicon.ico') }}" type="image/x-icon">
    <link rel="manifest" href="{{ asset('assets/ico/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/ico/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#292929">
    <meta name="theme-color" content="#292929">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">

    <!-- Icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/open-iconic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/pe-icon-7-stroke.css') }}">

    <!-- Core stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/bootstrap-material.css') }}" class="theme-settings-bootstrap-css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/appwork-material.css') }}" class="theme-settings-appwork-css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-corporate-material.css') }}" class="theme-settings-theme-css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/colors-material.css') }}" class="theme-settings-colors-css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/uikit.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
@yield('styles')

<!-- Load polyfills -->
    <script src="{{ asset('assets/vendor/js/polyfills.js') }}"></script>
    <script>document['documentMode']===10&&document.write('<script src="https://polyfill.io/v3/polyfill.min.js?features=Intl.~locale.en"><\/script>')</script>

    <script src="{{ asset('assets/vendor/js/material-ripple.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/layout-helpers.js') }}"></script>

    <!-- Theme settings -->
    <!-- This file MUST be included after core stylesheets and layout-helpers.js in the <head> section -->
    <script src="{{ asset('assets/vendor/js/theme-settings.js') }}"></script>
    <script>
        /*window.themeSettings = new ThemeSettings({
            cssPath: 'assets/vendor/css/rtl/',
            themesPath: 'assets/vendor/css/rtl/'
        });*/
    </script>

    <!-- Core scripts -->
    <script src="{{ asset('assets/vendor/js/pace.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Libs -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">


</head>

<body>
<div class="page-loader">
    <div class="bg-primary"></div>
</div>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-2">
    <div class="layout-inner">

    <!-- Layout container -->
        <div class="layout-container">


        <!-- Layout content -->
            <div class="layout-content">

                <!-- Content -->
                <div class="container-fluid flex-grow-1 container-p-y">

                    @yield('content')

                </div>
                <!-- / Content -->

            </div>
            <!-- Layout content -->

        </div>
        <!-- / Layout container -->

    </div>

</div>
<!-- / Layout wrapper -->

<!-- Core scripts -->
<script src="{{ asset('assets/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/jquery-validation/dist/additional-methods.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/js/sidenav.js') }}"></script>

<!-- Libs -->
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/chartjs/chartjs.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>


<!-- Demo -->
<script src="{{ asset('assets/js/demo.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>

</html>