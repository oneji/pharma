<!DOCTYPE html>
<html class="loading">
  <!-- BEGIN: Head-->
  
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Kamilov T">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@section('title')@show</title>

    @section('head')
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo/logo.ico') }}" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/vendors.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/vertical-modern-menu-template/materialize.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/vertical-modern-menu-template/style.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom/custom.css') }}">
    @show
    
</head>
<!-- END: Head-->
<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-modern-menu" data-col="2-columns">
    <!-- BEGIN: Header-->
    <header class="page-topbar" id="header">
        <div class="navbar navbar-fixed"> 
            <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark gradient-45deg-indigo-light-blue no-shadow">
                <div class="nav-wrapper">
                    <ul class="navbar-list right">
                        <li class="hide-on-med-and-down"><a class="waves-effect waves-block waves-light toggle-fullscreen" href="javascript:void(0);"><i class="material-icons">settings_overscan</i></a></li>
                        <li><a class="waves-effect waves-block waves-light notification-button" href="javascript:void(0);" data-target="notifications-dropdown"><i class="material-icons">notifications_none<small class="notification-badge">{{ Auth::user()->unreadNotifications->count() }}</small></i></a></li>
                        <li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown"><span class="avatar-status avatar-online"><img src="{{ asset('assets/images/user/user.png') }}" alt="avatar"><i></i></span></a></li>
                    </ul>
                    <!-- notifications-dropdown-->
                    <ul class="dropdown-content" id="notifications-dropdown">
                        <li>
                            <h6>Уведомления<span class="badge green">{{ Auth::user()->unreadNotifications->count() }} новое</span></h6>
                        </li>
                        <li class="divider"></li>
                        @foreach (Auth::user()->notifications as $notification)
                            <li>
                                <a class="black-text" href="#!">
                                    <span class="material-icons icon-bg-circle cyan small">star</span> {{ $notification->data['message'] }}
                                </a>
                                <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">{{ $notification->created_at }}</time>
                            </li>                            
                        @endforeach
                    </ul>
                    <!-- profile-dropdown-->
                    <ul class="dropdown-content" id="profile-dropdown">
                        <li><a class="grey-text text-darken-1" href="{{ route('password.edit') }}"><i class="material-icons">person_outline</i> Изменить пароль</a></li>
                        <li class="divider"></li>
                        <li>
                            <a 
                                class="grey-text text-darken-1" 
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();"
                            >
                                <i class="material-icons">keyboard_tab</i> 
                                Выйти
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!-- END: Header-->
    
    <!-- BEGIN: SideNav-->
    <aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square">
        <div class="brand-sidebar">
            <div class="logo-wrapper">
                <a class="brand-logo darken-1" href="{{ route('home') }}">
                    <img class="hide-on-med-and-down" src="{{ asset('assets/images/logo/logo') }}.png" alt="Sifat logo" />
                    {{-- <span class="logo-text hide-on-med-and-down">Главная</span> --}}
                </a>
                <a class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a>
            </div>
        </div>
        <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
            <li class="bold active"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">list_alt</i><span class="menu-title" data-i18n="Dashboard">Справочники</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                        @permission('read-acl')
                            <li><a class="{{ Route::currentRouteName() === 'acl.index' ? 'gradient-45deg-indigo-blue active' : null }}" href="{{ route('acl.index') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Modern">Права доступа и роли</span></a></li>
                        @endpermission

                        @permission('read-users')
                            <li><a class="{{ Route::currentRouteName() === 'users.index' ? 'gradient-45deg-indigo-blue active' : null }}" href="{{ route('users.index') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Modern">Пользователи</span></a></li>
                        @endpermission

                        <li><a class="{{ Route::currentRouteName() === 'users.clients' ? 'gradient-45deg-indigo-blue active' : null }}" href="{{ route('users.clients') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Modern">Клиенты</span></a></li>

                        @permission('read-brands')
                            <li><a class="{{ Route::currentRouteName() === 'brands.index' ? 'gradient-45deg-indigo-blue active' : null }}" href="{{ route('brands.index') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="eCommerce">Производители</span></a></li>
                        @endpermission
                        
                        @permission('read-medicines')
                            <li><a class="{{ Route::currentRouteName() === 'medicine.index' ? 'gradient-45deg-indigo-blue active' : null }}" href="{{ route('medicine.index') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Analytics">Товары</span></a></li>
                        @endpermission

                        <li><a class="{{ Route::currentRouteName() === 'companies.index' ? 'gradient-45deg-indigo-blue active' : null }}" href="{{ route('companies.index') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Analytics">Компании</span></a></li>
                    </ul>
                </div>
            </li>
            @permission('read-price-lists')
                <li class="bold">
                    <a class="{{ Route::currentRouteName() === 'price_lists.index' ? 'gradient-45deg-indigo-blue active' : null }}" href="{{ route('price_lists.index') }}">
                        <i class="material-icons">list_alt</i>
                        <span class="menu-title" data-i18n="Kanban">Прайс лист</span>
                    </a>
                </li>
            @endpermission
            
            @permission('read-requests')
                <li class="bold">
                    <a class="{{ Route::currentRouteName() === 'requests.index' ? 'gradient-45deg-indigo-blue active' : null }}" href="{{ route('requests.index') }}">
                        <i class="material-icons">assignment_returned</i>
                        <span class="menu-title" data-i18n="Kanban">Заявки</span>
                    </a>
                </li>
            @endpermission
            
            @permission('read-debtors')
                <li class="bold">
                    <a class="{{ Route::currentRouteName() === 'users.debtors' ? 'gradient-45deg-indigo-blue active' : null }}" href="{{ route('users.debtors') }}">
                        <i class="material-icons">attach_money</i>
                        <span class="menu-title" data-i18n="Kanban">Дебиторы</span>
                    </a>
                </li>
            @endpermission

            @permission('read-creditors')
                <li class="bold">
                    <a class="{{ Route::currentRouteName() === 'creditors.index' ? 'gradient-45deg-indigo-blue active' : null }}" href="{{ route('creditors.index') }}">
                        <i class="material-icons">receipt</i>
                        <span class="menu-title" data-i18n="Kanban">Кредиторы</span>
                    </a>
                </li>
            @endpermission

            @permission('read-new-clients')
                <li class="bold">
                    <a class="{{ Route::currentRouteName() === 'newClients.index' ? 'gradient-45deg-indigo-blue active' : null }}" href="{{ route('newClients.index') }}">
                        <i class="material-icons">people</i>
                        <span class="menu-title" data-i18n="Kanban">Новые клиенты</span>
                    </a>
                </li>
            @endpermission
        </ul>
        <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
    </aside>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            @if (Route::currentRouteName() !== 'home')
                <div class="content-wrapper-before gradient-45deg-indigo-light-blue"></div>
            @endif
            
            @yield('content')
        </div>
    </div>
    <!-- END: Page Main-->
    
    <!-- BEGIN: Footer-->
    <footer class="page-footer footer footer-static footer-dark gradient-45deg-indigo-light-blue gradient-shadow navbar-border navbar-shadow">
        <div class="footer-copyright">
            <div class="container">
                <span>2020 &copy; Все права защищены.</span>
            </div>
        </div>
    </footer>
    <!-- END: Footer-->

    @section('scripts')
        <script src="{{ asset('assets/js/vendors.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.min.js') }}"></script>
        <script src="{{ asset('assets/js/search.min.js') }}"></script>
    @show
  </body>
</html>