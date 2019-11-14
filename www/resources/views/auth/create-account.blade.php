<!DOCTYPE html>

<html lang="en" class="material-style">

<head>
    <title>{{ config('app.name') }}</title>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('assets/logos/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/logos/favicon.ico') }}" type="image/x-icon">
    <link rel="manifest" href="{{ asset('assets/ico/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/ico/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#292929">
    <meta name="theme-color" content="#292929">
    <link href="https://unpkg.com/ionicons@4.5.5/dist/css/ionicons.min.css" rel="stylesheet">

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
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/authentication.css') }}">
</head>

<body>
<div class="page-loader">
    <div class="bg-primary"></div>
</div>

<!-- Content -->

<div class="authentication-wrapper authentication-3">
    <div class="authentication-inner">

        <!-- Side container -->
        <!-- Do not display the container on extra small, small and medium screens -->
        <div class="d-none d-lg-flex col-lg-8 align-items-center ui-bg-cover ui-bg-overlay-container p-5"
             style="background-image: url({{ asset('assets/img/backgrounds/thomas-kvistholt-191153-unsplash.jpg') }});">
            <div class="ui-bg-overlay bg-dark opacity-50"></div>

            <!-- Text -->
            <div class="w-100 text-white px-5">
                <h1 class="display-2 font-weight-bolder mb-4">METIS<br>NETWORK</h1>
                <div id="auth-quote" class="text-large font-weight-light">"Would you like me to give you a formula for success?
                    It's quite simple, really: Double your rate of failure. You are thinking of failure as the enemy of success.
                    But it isn't at all. You can be discouraged by failure or you can learn from it, so go ahead and make mistakes.
                    Make all you can. Because remember that's where you will find success."</div>
                <div id="auth-quote-origin" class="h1 italic ml-24 mt-6">— <span>Thomas J. Watson</span></div>
            </div>
            <!-- /.Text -->
        </div>
        <!-- / Side container -->

        <!-- Form container -->
        <div class="d-flex col-lg-4 align-items-center bg-white p-5">
            <!-- Inner container -->
            <!-- Have to add `.d-flex` to control width via `.col-*` classes -->
            <div class="d-flex col-sm-7 col-md-5 col-lg-12 px-0 px-xl-4 mx-auto">
                <div class="w-100">

                    <!-- Logo -->
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="w-75">
                            <div class="w-100 position-relative" >
                                <img class="bg-overlay w-100" src="{{ asset('assets/logos/mc-nb-logo.png') }}" alt="MetisNet">
                            </div>
                        </div>
                    </div>
                    <!-- / Logo -->

                    <h4 class="text-center text-dark font-weight-normal mt-3 mb-0">Create an Account</h4>

                    <!-- Form -->
                    <form id="create-account-form" class="my-5" autocomplete="off" action="{{ route('post-create-account') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" name="phone">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-4">Sign Up</button>
                        <div class="text-light small mt-4">
                            By clicking "Sign Up", you agree to our
                            <a href="javascript:void(0)">terms of service and privacy policy</a>. We’ll occasionally send you account related emails.
                        </div>
                    </form>
                    <!-- / Form -->

                    <div class="text-center text-muted">
                        Already have an account? <a href="{{ route('get-sign-in') }}">Sign In</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- / Form container -->

    </div>
</div>

<!-- / Content -->

<!-- Core scripts -->
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/jquery-validation/dist/additional-methods.min.js') }}"></script>
<script src="{{ asset('assets/vendor/js/sidenav.js') }}"></script>

<!-- Libs -->
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<!-- Demo -->
<script src="{{ asset('assets/js/demo.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    let createAccountForm = $("#create-account-form");
    createAccountForm.validate({
        rules: {
            name: 'required',
            email: {
                email: true,
                required: true
            },
            phone: 'required',
            password: 'required'
        },
        errorPlacement: function errorPlacement(error, element) {
            let $parent = $(element).parents('.form-group');

            // Do not duplicate errors
            if ($parent.find('.jquery-validation-error').length) { return; }

            $parent.append(
                error.addClass('jquery-validation-error small form-text invalid-feedback')
            );
        },
        highlight: function(element) {
            let $el = $(element);
            let $parent = $el.parents('.form-group');

            $el.addClass('is-invalid');

            // Select2 and Tagsinput
            if ($el.hasClass('select2-hidden-accessible') || $el.attr('data-role') === 'tagsinput') {
                $el.parent().addClass('is-invalid');
            }
        },
        unhighlight: function(element) {
            $(element).parents('.form-group').find('.is-invalid').removeClass('is-invalid');
        },
        submitHandler: (form) => {
            let data = $(form).serialize();
            axios.post($(form).attr('action'), data)
                .then((res) => {
                    const data = res.data;
                    console.log(data);
                    if (data.success) {
                        window.location.href = '/home';
                    }
                }).catch((err) => {
                    console.log(err);
            });
        }
    })
</script>
</body>

</html>