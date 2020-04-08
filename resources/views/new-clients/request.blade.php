<!DOCTYPE html>
<html class="loading" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Kamilov T">
    <title>Оставить заявку</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo/logo.ico') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/vertical-modern-menu-template/materialize.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/vertical-modern-menu-template/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/login.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom/custom.css') }}">
</head>
  <!-- END: Head-->
<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 1-column login-bg   blank-page blank-page" data-open="click" data-menu="vertical-modern-menu" data-col="1-column">
    <div class="row">
        <div class="col s12">
            <div class="container">
                <div id="login-page" class="row">
                    <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
                        <form class="login-form" method="POST" action="{{ route('newClients.saveRequest') }}" id="formValidate">
                            @csrf
                            <div class="row">
                                <div class="input-field col s12">
                                    <h5 class="ml-4">Оставьте заявку</h5>
                                </div>
                            </div>
                            <div class="row margin">
                                <div class="card-alert card green">
                                    @if (Session::has('success'))
                                        <div class="card-content white-text">
                                            <p>
                                                <i class="material-icons">check</i> {{ Session::get('success') }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row margin">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix pt-2">person_outline</i>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Введите ФИО">
                                    <label for="name" class="center-align">ФИО</label>
                                </div>

                                <div class="input-field col s12">
                                    <i class="material-icons prefix pt-2">phone</i>
                                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="Введите номер телефона">
                                    <label for="phone">Номер телефона</label>
                                </div>

                                <div class="input-field col s12">
                                    <i class="material-icons prefix pt-2">phone</i>
                                    <select name="company_id">
                                        <option value="" selected>Нет компании</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="phone">Компания</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="input-field col s12">
                                    <button type="submit" class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">Отправить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="content-overlay"></div>
        </div>
    </div>

    <script src="{{ asset('assets/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            $("#formValidate").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    phone: {
                        required: true,
                    }
                },
                //For custom messages
                messages: {
                    name: {
                        required: 'Поле "ФИО" обязательное.',
                    },
                    phone: {
                        required: 'Поле "Номер телефона" обязательное.',
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
