@extends('layouts.main')

@section('title')
    Пользователи
@endsection

@section('head')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/flag-icon/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables') }}.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/app-sidebar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/app-contacts.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2-materialize.css') }}" type="text/css">
    
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/form-select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/page-users.min.css') }}">

@endsection

@section('content')
    <div id="addClientModal" class="modal" style="width: 40%">
        <form action="{{ route('users.store') }}" method="POST" id="addClientForm">
            @csrf
            <div class="modal-content">
                <h5>Добавить пользователя</h5>
                <div class="container mt-4">
                    <div class="card-alert card blue">
                        <div class="card-content white-text">
                            <p><i class="material-icons">info</i> Для нового пользователя сгенерирован случайный пароль!</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">perm_identity</i>
                            <input id="name" name="name" type="text" class="validate" placeholder="Введите ФИО">
                            <label for="name">ФИО</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix">perm_identity</i>
                            <input id="username" name="username" type="text" class="validate" placeholder="Введите логин">
                            <label for="username">Логин</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix">lock</i>
                            <input id="password" name="password" type="text" class="validate" placeholder="Введите пароль">
                            <label for="password">Пароль</label>
                        </div>                                   

                        <div class="input-field col s6">
                            <i class="material-icons prefix">call</i>
                            <input name="phone" type="text" class="validate" placeholder="Введите телефон">
                            <label for="phone">Телефон</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix">business</i>
                            <select name="company_id" id="company_id">
                                <option value="" selected>Не выбран</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                            <label for="role">Компания</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix">note</i>
                            <input name="note" type="text" class="validate" placeholder="Введите заметки">
                            <label for="note">Заметки</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix">replay_10</i>
                            <input name="discount_amount" type="number" min="0" max="100" class="validate" value="0" placeholder="Введите процент скидки">
                            <label for="discount_amount">Скидка %</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_circle</i>
                            <select id="role" name="role">
                                @foreach ($roles as $idx => $role)
                                    <option {{ $idx === 0 ? 'selected' : null }} value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                            <label for="role">Роли</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_circle</i>
                            <select name="responsible_manager_id">
                                <option value="" selected>Не выбран</option>
                                @foreach ($managers as $manager)
                                    <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                @endforeach
                            </select>
                            <label for="role">Ответственный менеджер</label>
                        </div>

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="waves-effect waves-light btn green">
                    <span>Добавить</span>
                </button>
            </div>
        </form>
    </div>

    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Список новых клиентов</span></h5>
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Список новых клиентов</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col s12">
        <div class="container">
            <section class="users-list-wrapper section">
                <div class="users-list-table">
                    <div class="card">
                        <div class="card-content">
                            <div class="responsive-table">
                                <table id="clients-list" class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ФИО</th>
                                            <th>Телефон</th>
                                            <th>Компания</th>
                                            <th>Дата заявки</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($newClients as $idx => $client)
                                        <tr data-company-id="{{ $client->company_id }}" data-client-name="{{ $client->name }}" data-client-phone="{{ $client->phone }}">
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $client->name }}</td>
                                            <td>{{ $client->phone }}</td>
                                            <td>{{ $client->company_name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($client->created_at)->locale('ru')->isoFormat('MMMM D, YYYY') }}</td>
                                            <td><a href="#" class="add-new-client-btn"><span><i class="material-icons delete">person_add</i></span></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/app-contacts.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/new-clients.js') }}"></script>
@endsection
