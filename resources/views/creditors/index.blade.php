@extends('layouts.main')

@section('title')
    Кредиторы
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
    <div style="bottom: 54px; right: 19px;" class="fixed-action-btn direction-top">
        <a href="#addCreditorModal" class="btn-floating btn-large primary-text gradient-shadow waves-effect waves-light btn green add-btn modal-trigger">
            <i class="material-icons">person_add</i>
        </a>
    </div>

    <div id="addCreditorModal" class="modal" style="width: 40%">
        <form action="{{ route('creditors.store') }}" method="POST" id="addCreditorForm">
            @csrf
            <div class="modal-content">
                <h5>Добавить долг</h5>
                    
                    <div class="container">
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">account_circle</i>
                                <select name="user_id" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <label for="user_id">Пользователь</label>
                            </div>

                            <div class="input-field col s6">
                                <i class="material-icons prefix">filter_1</i>
                                <input id="bill_number" required name="bill_number" type="text" class="validate" placeholder="Введите № накладной">
                                <label for="bill_number">№ накладной</label>
                            </div>

                            <div class="input-field col s6">
                                <i class="material-icons prefix">note</i>
                                <input name="date" type="text" required class="datepicker" placeholder="Выберите дату">
                                <label for="date">Дата</label>
                            </div>

                            <div class="input-field col s6">
                                <i class="material-icons prefix">note</i>
                                <input name="amount" required type="number" class="validate" placeholder="Введите сумму">
                                <label for="amount">Сумма</label>
                            </div>
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

    <!-- Modal Structure -->
    <div id="infoModal" class="modal">
        <div id="loading">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-green-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-content">
            <h5 id="username"></h5>
            <table class="striped responsive-table creditor-info-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>№ накладной</th>
                        <th>Сумма (с.)</th>
                        <th>Дата</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Закрыть</a>
        </div>
    </div>

    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Кредиторы</span></h5>
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Кредиторы</li>
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
                                <table id="users-list" class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ФИО</th>
                                            <th>Имя пользователя</th>
                                            <th>Телефон</th>
                                            <th>Компания</th>
                                            <th>Сумма долга</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($creditors as $idx => $creditor)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $creditor->name }}</td>
                                            <td>{{ $creditor->username }}</td>
                                            <td>{{ $creditor->phone }}</td>
                                            <td>{{ $creditor->company_name }}</td>
                                            <td>
                                                <span class="badge blue">{{ $creditor->total }}с.</span>
                                            </td>
                                            <td>
                                                <a 
                                                    href="#infoModal" 
                                                    class="info-btn modal-trigger" 
                                                    data-user-id="{{ $creditor->user_id }}"
                                                    data-user-name="{{ $creditor->name }}">
                                                    <span><i class="material-icons delete">info</i></span>
                                                </a>
                                            </td>
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
    <script src="{{ asset('assets/js/custom/users.js') }}"></script>
    <script src="{{ asset('assets/js/custom/creditors.js') }}"></script>
@endsection
