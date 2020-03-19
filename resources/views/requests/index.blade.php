@extends('layouts.main')

@section('title')
    Заявки
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

    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Список заявок</span></h5>
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Список заявок</li>
                    </ol>
                </div>

                <div class="col s2 m6 l6">
                    <a class="btn waves-effect waves-light breadcrumbs-btn right green" href="{{ route('requests.create') }}">
                        <i class="material-icons hide-on-med-and-up">add</i>
                        <span class="hide-on-small-onl">Создать заявку</span>
                    </a>
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
                                <table id="requests-list" class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Номер заявки №</th>
                                            <th>Сумма долга</th>
                                            <th>Статус</th>
                                            <th>Создал</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($requests as $idx => $req)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>
                                                <a href="{{ route('requests.view', [ 'id' => $req->id ]) }}">#{{ $req->request_number }}</a>
                                            </td>
                                            <td><span class="badge green">{{ $req->payment_amount }}c.</span></td>
                                            <td>
                                                @if($req->status === 'under_revision')
                                                    <span class="badge blue">В рассмотрении</span>
                                                @endif

                                                @if ($req->status === 'sent')
                                                    <span class="badge green">Отправлена</span>
                                                @endif

                                                @if ($req->status === 'written_out')
                                                    <span class="badge orange">Выписана</span>
                                                @endif

                                                @if ($req->status === 'being_prepared')
                                                    <span class="badge orange">Готовится</span>
                                                @endif

                                                @if ($req->status === 'shipped')
                                                    <span class="badge orange">Отгружена</span>
                                                @endif
                                                
                                                @if ($req->status === 'paid')
                                                    <span class="badge green">Оплачена</span>
                                                @endif

                                                @if ($req->status === 'cancelled')
                                                    <span class="badge red">Отменена</span>
                                                @endif
                                            </td>
                                            <td>{{ $req->username }}</td>
                                            <td>
                                                <a href="{{ route('requests.view', [ 'id' => $req->id ]) }}"><span><i class="material-icons">remove_red_eye</i></span></a>
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
    <script src="{{ asset('assets/js/custom/requests.js') }}"></script>
@endsection
