@extends('layouts.main')

@section('title')
    {{ $userProfile['user']->name }} | Профиль
@endsection

@section('head')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/user-profile-page.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/dashboard-modern.css') }}">
    <style>
        .user-profile-bg {
            height: 150px;
            width: 100%;
            background-position: center center;
            background-size: cover;
            background-image: url('../../assets/images/gallery/flat-bg.jpg');
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
        <!-- Search for small screen-->
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Профиль пользователя</span></h5>
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
                    <div class="user-profile-bg">
                        {{-- <img class="responsive-img" alt="" src="{{ asset('assets/images/gallery/flat-bg.jpg') }}"> --}}
                    </div>
                </div>
                <div class="section" id="user-profile">
                    <div class="row">
                        <!-- User Profile Feed -->
                        <div class="col s12 m4 l3 user-section-negative-margin">
                            <div class="row">
                                <div class="col s12 center-align">
                                    <img class="responsive-img circle z-depth-5" width="120"
                                        src="{{ asset('assets/images/user/6.jpg') }}" alt="">
                                    <br>
                                </div>
                            </div>
                            <hr>
                            <div id="profile-card" class="card animate fadeRight">
                                <div class="card-image waves-effect waves-block waves-light">
                                    <img class="activator" src="{{ asset('assets/images/gallery/3.png') }}" alt="user bg" />
                                </div>
                                <div class="card-content">
                                    <img src="{{ asset('assets/images/user/user.png') }}" alt="" class="circle responsive-img card-profile-image padding-2" />
                                    <h5 class="card-title activator grey-text text-darken-4">{{ $userProfile['user']->name }}</h5>
                                    <p><i class="material-icons profile-card-i">perm_identity</i>Project Manager</p>
                                    <p><i class="material-icons profile-card-i">perm_phone_msg</i>{{ $userProfile['user']->phone }}</p>
                                    <p><i class="material-icons profile-card-i">person</i>{{ $userProfile['user']->username }}</p>
                                </div>
                            </div>
                            <hr class="mt-5">
                            <div class="row">
                                <div class="col s12">
                                    <p class="m-0">Заявки</p>
                                    <p class="m-0">{{ $userProfile['paidRequests']->count() }} из {{ $userProfile['user']->requests->count() }} оплачены</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row user-projects">
                                <h6 class="col s12">Оплаченные заявки</h6>
                                @foreach ($userProfile['paidRequests'] as $request)
                                    <div class="col s3">
                                        <a class="tooltipped" href="{{ route('requests.view', [ 'id' => $request->id ]) }}" data-position="bottom" data-tooltip="Заявка №{{ $request->id }}">
                                            <img class="responsive-img photo-border mt-10" alt="" src="{{ asset('assets/images/icon/printer.png') }}">
                                        </a>
                                    </div>                                    
                                @endforeach
                            </div>
                            <hr class="mt-5">
                        </div>
                        <!-- User Post Feed -->
                        <div class="col s12 m8 l6">
                            <div class="row">
                                <div class="card user-card-negative-margin z-depth-0" id="feed">
                                    <div class="card-content card-border-gray">
                                        <div class="row">
                                            <div class="col s12">
                                                <h5>{{ $userProfile['user']->name }}</h5>
                                                <p>{{ $userProfile['user']->roles->first()->display_name }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s12">
                                                <ul class="tabs card-border-gray mt-4">
                                                    <li class="tab col m3 s6 p-0">
                                                        <a href="#req_under_revision" class="active">
                                                            <i class="material-icons vertical-align-middle">crop_portrait</i>
                                                            В рассмотрении
                                                        </a>
                                                    </li>
                                                    <li class="tab col m3 s6 p-0">
                                                        <a href="#req_sent">
                                                            <i class="material-icons vertical-align-middle">crop_portrait</i>
                                                            Отправлены
                                                        </a>
                                                    </li>
                                                    <li class="tab col m3 s6 p-0">
                                                        <a href="#req_being_prepared">
                                                            <i class="material-icons vertical-align-middle">crop_portrait</i>
                                                            Готовятся
                                                        </a>
                                                    </li>
                                                    <li class="tab col m3 s6 p-0">
                                                        <a href="#req_shipped">
                                                            <i class="material-icons vertical-align-middle">crop_portrait</i>
                                                            Отгруженные
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div id="req_under_revision" class="recent-buyers-card">
                                            @foreach ($userProfile['user']->requests as $request)
                                                @if ($request->status === 'under_revision')
                                                    <ul class="collection mb-0">
                                                        <li class="collection-item avatar">
                                                            <img src="{{ asset('assets/images/icon/printer.png') }}" alt="" class="circle" />
                                                            <p class="font-weight-600">Заявка №{{ $request->id }}</p>
                                                            <p class="medium-small">{{ \Carbon\Carbon::parse($request->created_at)->locale('ru')->isoFormat('MMMM D, YYYY') }}</p>
                                                        </li>
                                                    </ul>                                          
                                                @endif
                                            @endforeach
                                        </div>
                                        <hr class="mt-5">
                                        <div id="req_sent">
                                            @foreach ($userProfile['user']->requests as $request)
                                                @if ($request->status === 'sent')
                                                    <div class="row mt-5">
                                                        <div class="col s1 pr-0 circle">
                                                            <a href="#"><img class="responsive-img circle" src="{{ asset('assets/images/icon/printer.png') }}" alt=""></a>
                                                        </div>
                                                        <div class="col s11">
                                                            <a href="#">
                                                                <p class="m-0">Заявка №{{ $request->id }} <span><i class="material-icons vertical-align-bottom">access_time</i> {{ $request->created_at }}</span></p>
                                                            </a>
                                                        </div>
                                                    </div>                                                
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Today Highlight -->
                        <div class="col s12 m12 l3 hide-on-med-and-down">
                            <div class="row mt-5">
                                <div class="col s12">
                                    <h6>Today Highlight</h6>
                                    <img class="responsive-img card-border z-depth-2 mt-2"
                                        src="{{ asset('assets/images/gallery/post-3') }}.png" alt="">
                                    <p><a href="#">Meeting with clients</a></p>
                                    <p>Crediting isn’t required, but is appreciated and allows photographers to gain
                                        exposure. Copy the text
                                        below or embed a credit badge</p>
                                </div>
                            </div>
                            <hr class="mt-5">
                            <div class="row">
                                <div class="col s12">
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
    <script>
        $(document).ready(function(){
            $('.tooltipped').tooltip();
        });
    </script>
@endsection
