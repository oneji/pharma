@extends('layouts.main')

@section('title')
    Дебиторы
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
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Дебиторы</span></h5>
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Дебиторы</li>
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
                                            <th>Компания</th>
                                            <th>Скидка (%)</th>
                                            <th>Общая сумма долга</th>
                                            <th>Оплаченая сумма</th>
                                            <th>Дедлайн оплаты</th>
                                            {{-- <th>Действия</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($debtors as $idx => $debtor)
                                        <tr class="{{ $debtor->payment_deadline < \Carbon\Carbon::now() ? 'payment-deadline-expired' : null }} ">
                                            <td>{{ $idx + 1 }}</td>
                                            <td>
                                                
                                                <a href="{{ route('users.show', [ 'id' => $debtor->id ]) }}">{{ $debtor->name }}</a>
                                            </td>
                                            <td>{{ $debtor->company_name }}</td>
                                            <td>{{ $debtor->discount_amount }}%</td>
                                            <td>
                                                <span class="badge blue">{{ $debtor->debt_amount }}с.</span>
                                            </td>
                                            <td>
                                                <span class="badge green">{{ $debtor->paid_amount }}с.</span>
                                            </td>
                                            <td>
                                                @if ($debtor->payment_deadline < \Carbon\Carbon::now())
                                                    <span class="badge red">{{ \Carbon\Carbon::parse($debtor->payment_deadline)->locale('ru')->isoFormat('MMMM D, YYYY') }}</span>
                                                @else
                                                    {{ \Carbon\Carbon::parse($debtor->payment_deadline)->locale('ru')->isoFormat('MMMM D, YYYY') }}
                                                @endif
                                            </td>
                                            {{-- <td>
                                                <a href="{{ route('users.edit', [ 'user' => $user->id ]) }}"><span><i class="material-icons delete">edit</i></span></a>

                                                @if ($user->status === 0)
                                                    <a href="#" class="tooltipped" onclick="event.preventDefault(); document.getElementById('active-form-{{ $user->id }}').submit();" data-position="bottom" data-tooltip="Активировать">
                                                        <span><i class="material-icons delete">lock_open</i></span>
                                                    </a>
                                                    <form id="active-form-{{ $user->id }}" action="{{ route('users.status', [ 'user' => $user->id, 'status' => 1 ]) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>
                                                    
                                                @else
                                                    <a href="#" class="tooltipped" onclick="event.preventDefault(); document.getElementById('deactive-form-{{ $user->id }}').submit();" data-position="bottom" data-tooltip="Деактивировать">
                                                        <span><i class="material-icons delete">lock</i></span>
                                                    </a>
                                                    <form id="deactive-form-{{ $user->id }}" action="{{ route('users.status', [ 'user' => $user->id, 'status' => 0 ]) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>
                                                @endif
                                            </td> --}}
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
@endsection
