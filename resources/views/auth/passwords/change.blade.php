@extends('layouts.main')

@section('title')
    Изменить пароль
@endsection

@section('head')
    @parent

@endsection

@section('content')
    <div class="row">
        <div class="col s12">
            <div class="container">
                <section class="invoice-edit-wrapper section">
                    <div class="row">
                        <div class="col xl12 m12 s12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="row mb-3">
                                        <div class="col m12 s12">
                                            <h4 class="indigo-text">Изменить пароль</h4>
                                        </div>
                                    </div>
                                    <form action="{{ route('password.change') }}" method="POST" id="changePasswordForm">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            @if ($errors->any())
                                                <div class="col m12 s12">
                                                    <div class="card-alert card red">
                                                        <div class="card-content white-text">
                                                            @foreach ($errors->all() as $error)
                                                                <p><i class="material-icons">error</i> {{ $error }}</p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if (Session::has('password.success'))
                                                <div class="col m12 s12">
                                                    <div class="card-alert card green">
                                                        <div class="card-content white-text">
                                                            <p><i class="material-icons">check</i> {{ Session::get('password.success') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="col m12 s12">
                                                <div class="input-field">
                                                    <input placeholder="Введите старый пароль" name="old_password" type="password" required>
                                                    <label for="old_password">Старый пароль</label>
                                                </div>
                                            </div>
                                            <div class="col m12 s12">
                                                <div class="input-field">
                                                    <input id="password" placeholder="Введите новый пароль" name="password" type="password" required>
                                                    <label for="password">Новый пароль</label>
                                                </div>
                                            </div>
                                            <div class="col m12 s12">
                                                <div class="input-field">
                                                    <input placeholder="Подтвердите новый пароль" name="password_confirmation" type="password" required>
                                                    <label for="password_confirmation">Подтверждение нового пароля</label>
                                                </div>
                                            </div>
                                            <div class="col m12 s12">
                                                <div class="input-field display-flex justify-content-end">
                                                    <button type="submit" class="btn green">Изменить</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="{{ asset('assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#changePasswordForm').validate({
                rules: {
                    old_password: {
                        required: true,
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 6,
                        equalTo: "#password"
                    }
                }
            });
        });
    </script>
@endsection