@extends('layouts.main')

@section('title')
    {{ $userProfile['user']->name }} | Профиль
@endsection

@section('head')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/user-profile-page.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/dashboard-modern.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/page-users.min.css') }}">
@endsection

@section('content')
    <div class="breadcrumbs-dark pb-0 pt-2" id="breadcrumbs-wrapper">
        <!-- Search for small screen-->
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0">
                        <span class="display-flex align-items-center"><i class="material-icons mr-1">account_circle</i>{{ $userProfile['user']->name }}</span>
                    </h5>
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Профиль пользователя</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="row user-profile mt-1 ml-0 mr-0">
                    <div class="user-profile-bg"></div>
                </div>
                <div class="section" id="user-profile">
                    <div class="row">
                        <!-- User Post Feed -->
                        <div class="col s12 m8 l9">
                            <div class="row">
                                <section class="users-list-wrapper section">
                                    <div class="users-list-table">
                                        <div class="card">
                                            <div class="card-tabs">
                                                <ul class="tabs tabs-fixed-width">
                                                    <li class="tab"><a href="#requests" class="active">Заявки</a></li>
                                                    <li class="tab"><a href="#debits">Кредиты</a></li>
                                                </ul>
                                            </div>
                                            <div class="card-content">
                                                <div id="requests" class="active responsive-table">
                                                    <table id="requests-list" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th class="center-align">№ заявки</th>
                                                                <th>Сумма долга</th>
                                                                <th>Статус</th>
                                                                <th>Приоритет</th>
                                                                <th>Дедлайн оплаты</th>
                                                                <th>Действия</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($userProfile['user']->requests as $idx => $req)
                                                            <tr>
                                                                <td class="center-align"><a href="{{ route('requests.view', [ 'id' => $req->id ]) }}">#{{ $req->id }}</a></td>
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
                                                                <td>
                                                                    @if($req->priority === 1)
                                                                        <span class="badge green">Высокий</span>
                                                                    @endif
                    
                                                                    @if ($req->priority === 2)
                                                                        <span class="badge orange">Средний</span>
                                                                    @endif
                    
                                                                    @if ($req->priority === 3)
                                                                        <span class="badge red">Низкий</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($req->payment_deadline)->locale('ru')->isoFormat('MMMM D, YYYY') }}</td>
                                                                <td>
                                                                    <a href="{{ route('requests.view', [ 'id' => $req->id ]) }}"><span><i class="material-icons">remove_red_eye</i></span></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div id="debits" class="active responsive-table">
                                                    <table id="credits-list" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>№ накладной</th>
                                                                <th>Сумма</th>
                                                                <th>Дата</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($userProfile['credits']['items'] as $idx => $credit)
                                                                <tr>
                                                                    <td>{{ $idx + 1 }}</td>
                                                                    <td>#{{ $credit->bill_number }}</td>
                                                                    <td>{{ $credit->amount }} с.</td>
                                                                    <td>{{ \Carbon\Carbon::parse($credit->date)->locale('ru')->isoFormat('MMMM D, YYYY') }}</td>
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
                        <!-- Today Highlight -->
                        <div class="col s12 m12 l3 hide-on-med-and-down">
                            <div class="row">
                                <div class="col s12">
                                    <div id="profile-card" class="card animate fadeRight">
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <img class="activator" src="{{ asset('assets/images/gallery/3.png') }}" alt="user bg" />
                                        </div>
                                        <div class="card-content">
                                            <img src="{{ asset('assets/images/user/user.png') }}" alt="" class="circle responsive-img card-profile-image padding-2" />
                                            <h5 class="card-title activator grey-text text-darken-4">{{ $userProfile['user']->name }}</h5>
                                            <p><i class="material-icons profile-card-i">account_circle</i>{{ $userProfile['user']->roles->first()->display_name }}</p>
                                            <p><i class="material-icons profile-card-i">perm_phone_msg</i>{{ $userProfile['user']->phone }}</p>
                                            <p><i class="material-icons profile-card-i">person</i>{{ $userProfile['user']->username }}</p>
                                            <p><i class="material-icons profile-card-i">attach_money</i>Общий долг: {{ (double)$userProfile['user']->debt_amount + (double)$userProfile['user']->paid_amount }} с.</p>
                                            <p><i class="material-icons profile-card-i">euro</i>Текущий долг: {{ $userProfile['user']->debt_amount }} с.</p>
                                            <p><i class="material-icons profile-card-i">money_off</i>Оплачено: {{ $userProfile['user']->paid_amount }} с.</p>
                                            <p><i class="material-icons profile-card-i">receipt</i>Приход: {{ $userProfile['credits']['total']->total }} с.</p>
                                        </div>
                                    </div>
                                    <hr class="mt-5">
                                    <div class="card recent-buyers-card animate fadeUp">
                                        <div class="card-content">
                                            <h4 class="card-title mb-0">Последние выплаты по заявкам</h4>
                                            <ul class="collection mb-0">
                                                @foreach ($userProfile['user']->request_payments as $payment)
                                                    <li class="collection-item avatar">
                                                        <img src="{{ asset('assets/images/icon/printer.png') }}" alt="" class="circle" />
                                                        <p class="font-weight-600">Заявка №{{ $payment->request_id }}</p>
                                                        <p class="medium-small">{{ \Carbon\Carbon::parse($payment->created_at)->locale('ru')->isoFormat('MMMM D, YYYY') }}</p>
                                                        <p class="secondary-content">+{{ $payment->amount }}c.</p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    @parent

    <script src="{{ asset('assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.tooltipped').tooltip();

            $("#requests-list, #credits-list").DataTable({
                language: {
                    search: "",
                    searchPlaceholder: "Поиск",
                    lengthMenu: "Показать _MENU_ записей на странице",
                    zeroRecords: "Ничего не найдено",
                    info: "Страница _PAGE_ из _PAGES_",
                    infoEmpty: "Производителей не найдено",
                    infoFiltered: "(filtered from _MAX_ total records)",
                    paginate: {
                        first: "Первая",
                        last: "Последняя",
                        next: "След",
                        previous: "Пред"
                    }
                }
            }).order([ 0, 'desc' ]).draw();
        });
    </script>
@endsection
