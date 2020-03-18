@extends('layouts.main')

@section('title')
    Главная
@endsection

@section('head')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/dashboard.min.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="section">
        <!--card stats start-->
        <div id="card-stats" class="pt-0">
            <div class="row">
                <div class="col s12 m6 l6 xl3">
                    <div
                        class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text animate fadeLeft">
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
                    <div
                        class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text animate fadeLeft">
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
                    <div
                        class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text animate fadeRight">
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
                    <div
                        class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text animate fadeRight">
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
