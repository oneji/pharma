@extends('layouts.main')

@section('title')
    Главная
@endsection

@section('head')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/animate-css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/chartist-js/chartist.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/chartist-js/chartist-plugin-tooltip.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/dashboard.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/dashboard-modern.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="section">
        <div id="card-stats" class="row">
            <div class="col s12 m6 xl3">
                <div class="card">
                    <div class="card-content cyan white-text">
                        <p class="card-stats-title"><i class="material-icons">content_copy</i> Заявки в рассмотрении</p>
                        <h4 class="card-stats-number white-text">{{ $stats['allRequestTypesCount']['underRevision'] }}</h4>
                        <p class="card-stats-compare">
                            <a href="{{ route('requests.getByStatus', [ 'status' => 'under_revision' ]) }}">Просмотреть</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 xl3">
                <div class="card">
                    <div class="card-content red accent-2 white-text">
                        <p class="card-stats-title"><i class="material-icons">content_copy</i> Отправленные заявки</p>
                        <h4 class="card-stats-number white-text">{{ $stats['allRequestTypesCount']['sent'] }}</h4>
                        <p class="card-stats-compare">
                            <a href="{{ route('requests.getByStatus', [ 'status' => 'sent' ]) }}">Просмотреть</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 xl3">
                <div class="card">
                    <div class="card-content orange lighten-1 white-text">
                        <p class="card-stats-title"><i class="material-icons">content_copy</i> Заявки в подготовке</p>
                        <h4 class="card-stats-number white-text">{{ $stats['allRequestTypesCount']['prepared'] }}</h4>
                        <p class="card-stats-compare">
                            <a href="{{ route('requests.getByStatus', [ 'status' => 'prepared' ]) }}">Просмотреть</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 xl3">
                <div class="card">
                    <div class="card-content green lighten-1 white-text">
                        <p class="card-stats-title"><i class="material-icons">content_copy</i> Отгруженные заявки</p>
                        <h4 class="card-stats-number white-text">{{ $stats['allRequestTypesCount']['shipped'] }}</h4>
                        <p class="card-stats-compare">
                            <a href="{{ route('requests.getByStatus', [ 'status' => 'shipped' ]) }}">Просмотреть</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 xl6">
                <div class="card">
                    <div class="card-content blue lighten-1 white-text">
                        <p class="card-stats-title"><i class="material-icons">content_copy</i> Оплаченные заявки</p>
                        <h4 class="card-stats-number white-text">{{ $stats['allRequestTypesCount']['paid'] }}</h4>
                        <p class="card-stats-compare">
                            <a href="{{ route('requests.getByStatus', [ 'status' => 'paid' ]) }}">Просмотреть</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 xl6">
                <div class="card">
                    <div class="card-content red lighten-1 white-text">
                        <p class="card-stats-title"><i class="material-icons">content_copy</i> Отмененные заявки</p>
                        <h4 class="card-stats-number white-text">{{ $stats['allRequestTypesCount']['cancelled'] }}</h4>
                        <p class="card-stats-compare">
                            <a href="{{ route('requests.getByStatus', [ 'status' => 'cancelled' ]) }}">Просмотреть</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!--card stats start-->
        <div id="card-stats" class="pt-0">
            <div class="row">
                <div class="col s12 m6 l6 xl3">
                    <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text animate fadeLeft">
                        <div class="padding-4">
                            <div class="row">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">perm_identity</i>
                                    <p>Пользователи</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h4 class="mb-0 white-text">{{ $stats['usersCount'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col s12 m6 l6 xl3">
                    <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text animate fadeLeft">
                        <div class="padding-4">
                            <div class="row">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">assignment_returned</i>
                                    <p>Заявки</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h4 class="mb-0 white-text">{{ $stats['requestsCount'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col s12 m6 l6 xl3">
                    <div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text animate fadeRight">
                        <div class="padding-4">
                            <div class="row">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">all_inbox</i>
                                    <p>Наименования товаров</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h4 class="mb-0 white-text">{{ $stats['medicineCount'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col s12 m6 l6 xl3">
                    <div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text animate fadeRight">
                        <div class="padding-4">
                            <div class="row">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">all_inbox</i>
                                    <p>Производители</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h4 class="mb-0 white-text">{{ $stats['brandsCount'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--card stats end-->

        
    </div>
</div>
@endsection

@section('scripts')
    @parent

@endsection
