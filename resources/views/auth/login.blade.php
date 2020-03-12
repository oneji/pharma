<!DOCTYPE html>
<html class="loading" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Kamilov T">
    <title>Войти</title>
    {{-- <link rel="apple-touch-icon" href="{{ asset('assets/images/favicon/apple-touch-icon-152x152.png') }}"> --}}
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon/favicon-32x32.png') }}"> --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/vendors.min.css') }}">
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/vertical-modern-menu-template/materialize.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/vertical-modern-menu-template/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/login.css') }}">
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom/custom.css') }}">
    <!-- END: Custom CSS-->
</head>
  <!-- END: Head-->
<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 1-column login-bg   blank-page blank-page" data-open="click" data-menu="vertical-modern-menu" data-col="1-column">
    <div class="row">
        <div class="col s12">
            <div class="container">
                <div id="login-page" class="row">
                    <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
                        <form class="login-form" method="POST" action="{{ route('login') }}" id="formValidate">
                            @csrf
                            <div class="row">
                                <div class="input-field col s12">
                                    <h5 class="ml-4">Вход</h5>
                                </div>
                            </div>
                            <div class="row margin">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix pt-2">person_outline</i>
                                    <input id="email" type="text" name="email" value="{{ old('email') }}">
                                    <label for="email" class="center-align">Email</label>
                                </div>
                            </div>
                            <div class="row margin">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix pt-2">lock_outline</i>
                                    <input id="password" type="password" name="password" value="{{ old('password') }}">
                                    <label for="password">Пароль</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 m12 l12 ml-2 mt-1">
                                    <p>
                                        <label>
                                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                            <span>Запомнить меня</span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="input-field col s12">
                                    <button type="submit" class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">Войти</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="content-overlay"></div>
        </div>
    </div>

    <!-- BEGIN VENDOR JS-->
    <script src="{{ asset('assets/js/vendors.min.js') }}"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN THEME  JS-->
    <script src="{{ asset('assets/js/plugins.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/search.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/custom-script.min.js') }}"></script> --}}
    <!-- END THEME  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <!-- END PAGE LEVEL JS-->
    <script src="{{ asset('assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            $("#formValidate").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 5
                    }
                },
                //For custom messages
                messages: {
                    email: {
                        required: 'Поле "Email" обязательное.',
                    },
                    password: {
                        required: 'Поле "Пароль" обязательное.',
                        minlength: "Введите минимум 6 символов."
                    },
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    var placement = $(element).data('error');
                    if (placement) {
                        $(placement).append(error)
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


        });
    </script>
</body>
</html>
