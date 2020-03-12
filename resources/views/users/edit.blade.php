@extends('layouts.main')

@section('title')
    Изменить пользователя
@endsection

@section('head')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/page-users.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2-materialize.css') }}" type="text/css">
    
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/form-select2.min.css') }}">
@endsection

@section('content')
    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
        <!-- Search for small screen-->
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Users edit</span></h5>
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">User</a>
                        </li>
                        <li class="breadcrumb-item active">Users Edit
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col s12">
        <div class="container">
            <!-- users edit start -->
            <div class="section users-edit">
                <div class="card">
                    <div class="card-content">
                        <!-- <div class="card-body"> -->
                        <ul class="tabs mb-2 row">
                            <li class="tab">
                                <a class="display-flex align-items-center active" id="account-tab" href="#account">
                                    <i class="material-icons mr-1">person_outline</i><span>Account</span>
                                </a>
                            </li>
                        </ul>
                        <div class="divider mb-3"></div>
                        <div class="row">
                            <div class="col s12" id="account">
                                <!-- users edit media object start -->
                                <div class="media display-flex align-items-center mb-2">
                                    <a class="mr-2" href="#">
                                        <img src="{{ asset('assets/images/user/user.png') }}" alt="users avatar"
                                            class="z-depth-1 circle" height="64" width="64">
                                    </a>
                                    <div class="media-body">
                                        <h5 class="media-heading mt-0">{{ $user->name }}</h5>
                                    </div>
                                </div>
                                <!-- users edit media object ends -->
                                <!-- users edit account form start -->
                                <form action="{{ route('users.update', [ 'user' => $user->id ]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col s12 m6">
                                            <div class="row">
                                                <div class="col s12 input-field">
                                                    <input id="name" name="name" type="text" class="validate"
                                                        value="{{ $user->name }}" data-error=".errorTxt2">
                                                    <label for="name">ФИО</label>
                                                    <small class="errorTxt2"></small>
                                                </div>
                                                <div class="col s12 input-field">
                                                    <input id="email" name="email" type="email" class="validate"
                                                        value="{{ $user->email }}" data-error=".errorTxt3">
                                                    <label for="email">E-mail</label>
                                                    <small class="errorTxt3"></small>
                                                </div>
                                                <div class="col s12 input-field">
                                                    <input id="phone" name="phone" type="text" class="validate"
                                                        value="{{ $user->phone }}" data-error=".errorTxt3">
                                                    <label for="phone">Телефон</label>
                                                    <small class="errorTxt3"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6">
                                            <div class="row">
                                                <div class="col s12 input-field">
                                                    <select name="role">
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <label>Role</label>
                                                </div>
                                                <div class="col s12 input-field">
                                                    <select name="status">
                                                        <option {{ $user->status === 1 ? 'selected' : null }} value="1">Активный</option>
                                                        <option {{ $user->status === 0 ? 'selected' : null }} value="0">Не активный</option>
                                                    </select>
                                                    <label>Статус</label>
                                                </div>
                                                <div class="col s12 input-field">
                                                    <input id="note" name="note" type="text" class="validate" value="{{ $user->note }}">
                                                    <label for="note">Записи</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 display-flex justify-content-end mt-3">
                                            <button type="submit" class="waves-effect waves-light btn green">Сохранить</button>
                                        </div>
                                    </div>
                                </form>
                                <!-- users edit account form ends -->
                            </div>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
            <!-- users edit ends -->
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('assets/vendors/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/page-users.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // $('#addUserForm').validate({
            //     rules: {
            //         name: {
            //             required: true
            //         },
            //         email: {
            //             required: true,
            //             email: true
            //         },
            //         password: {
            //             required: true,
            //             minlength: 6
            //         },
            //         password_confirmation: {
            //             required: true,
            //             minlength: 6,
            //             equalTo: "#password"
            //         },
            //         role: {
            //             required: true,
            //         },
            //     },
            //     //For custom messages
            //     messages: {
            //         name: {
            //             required: 'Обязательное поле.'
            //         },
            //         email: {
            //             required: 'Обязательное поле.',
            //             email: 'Введите действительный email aдрес.'
            //         },
            //         password: {
            //             required: 'Обязательное поле.',
            //             minlength: 'Введите минимум 6 символов.'
            //         },
            //         password_confirmation: {
            //             required: 'Обязательное поле.',
            //             minlength: 'Введите минимум 6 символов.',
            //             equalTo: 'Пароли должны совпадать.'
            //         },
            //         role: {
            //             required: 'Обязательное поле.'
            //         },
            //     },
            //     errorElement : 'div',
            //     errorPlacement: function(error, element) {
            //         var placement = $(element).data('error');
            //         if (placement) {
            //             $(placement).append(error)
            //         } else {
            //             error.insertAfter(element);
            //         }
            //     }
            // });
        }); 
    </script>
@endsection
