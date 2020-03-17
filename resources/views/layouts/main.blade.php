<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
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
        {{-- <link rel="apple-touch-icon" href="../../../app-assets/images/favicon/apple-touch-icon-152x152.png"> --}}
        {{-- <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/favicon/favicon-32x32.png"> --}}
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/vendors.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/vertical-modern-menu-template/materialize.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/vertical-modern-menu-template/style.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom/custom.css') }}">
        <style>
            .sidenav li a.active {
                box-shadow: none;
            }
            .modal {
                overflow: visible;
            }
        </style>
    @show
    
</head>
<!-- END: Head-->
<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-modern-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <header class="page-topbar" id="header">
        <div class="navbar navbar-fixed"> 
            <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark gradient-45deg-indigo-light-blue no-shadow">
                <div class="nav-wrapper">
                    <div class="header-search-wrapper hide-on-med-and-down">
                        <input class="header-search-input z-depth-2" type="text" value="{{ Auth::user()->name }}">
                    </div>
                    <ul class="navbar-list right">
                        <li class="hide-on-med-and-down"><a class="waves-effect waves-block waves-light toggle-fullscreen" href="javascript:void(0);"><i class="material-icons">settings_overscan</i></a></li>
                        <li><a class="waves-effect waves-block waves-light notification-button" href="javascript:void(0);" data-target="notifications-dropdown"><i class="material-icons">notifications_none<small class="notification-badge">5</small></i></a></li>
                        <li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown"><span class="avatar-status avatar-online"><img src="{{ asset('assets/images/user/user.png') }}" alt="avatar"><i></i></span></a></li>
                    </ul>
                    <!-- notifications-dropdown-->
                    <ul class="dropdown-content" id="notifications-dropdown">
                        <li>
                            <h6>NOTIFICATIONS<span class="new badge">5</span></h6>
                        </li>
                        <li class="divider"></li>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle cyan small">add_shopping_cart</span> A new order has been placed!</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">2 hours ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle red small">stars</span> Completed the task</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">3 days ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle teal small">settings</span> Settings updated</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">4 days ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle deep-orange small">today</span> Director meeting started</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">6 days ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle amber small">trending_up</span> Generate monthly report</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">1 week ago</time>
                        </li>
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

    <ul class="display-none" id="default-search-main">
        <li class="auto-suggestion-title">
            <a class="collection-item" href="#">
                <h6 class="search-title">FILES</h6>
            </a>
        </li>

        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img src="{{ asset('assets/images/icon/pdf-image.png') }}" width="24" height="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Two new item submitted</span><small class="grey-text">Marketing Manager</small></div>
                    </div>
                    <div class="status"><small class="grey-text">17kb</small></div>
                </div>
            </a>
        </li>

        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                    <div class="avatar"><img src="{{ asset('assets/images/icon/doc-image.png') }}" width="24" height="30" alt="sample image"></div>
                    <div class="member-info display-flex flex-column"><span class="black-text">52 Doc file Generator</span><small class="grey-text">FontEnd Developer</small></div>
                    </div>
                    <div class="status"><small class="grey-text">550kb</small></div>
                </div>
            </a>
        </li>

        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                    <div class="avatar"><img src="{{ asset('assets/images/icon/xls-image.png') }}" width="24" height="30" alt="sample image"></div>
                    <div class="member-info display-flex flex-column"><span class="black-text">25 Xls File Uploaded</span><small class="grey-text">Digital Marketing Manager</small></div>
                    </div>
                    <div class="status"><small class="grey-text">20kb</small></div>
                </div>
            </a>
        </li>

        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                    <div class="avatar"><img src="{{ asset('assets/images/icon/jpg-image.png') }}" width="24" height="30" alt="sample image"></div>
                    <div class="member-info display-flex flex-column"><span class="black-text">Anna Strong</span><small class="grey-text">Web Designer</small></div>
                    </div>
                    <div class="status"><small class="grey-text">37kb</small></div>
                </div>
            </a>
        </li>

        <li class="auto-suggestion-title">
            <a class="collection-item" href="#">
                <h6 class="search-title">MEMBERS</h6>
            </a>
        </li>
        
        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                    <div class="avatar"><img class="circle" src="{{ asset('assets/images/avatar/avatar-7.png') }}" width="30" alt="sample image"></div>
                    <div class="member-info display-flex flex-column"><span class="black-text">John Doe</span><small class="grey-text">UI designer</small></div>
                    </div>
                </div>
            </a>
        </li>

        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                    <div class="avatar"><img class="circle" src="{{ asset('assets/images/avatar/avatar-8.png') }}" width="30" alt="sample image"></div>
                    <div class="member-info display-flex flex-column"><span class="black-text">Michal Clark</span><small class="grey-text">FontEnd Developer</small></div>
                    </div>
                </div>
            </a>
        </li>

        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                    <div class="avatar"><img class="circle" src="{{ asset('assets/images/avatar/avatar-10.png') }}" width="30" alt="sample image"></div>
                    <div class="member-info display-flex flex-column"><span class="black-text">Milena Gibson</span><small class="grey-text">Digital Marketing</small></div>
                    </div>
                </div>
            </a>
        </li>

        <li class="auto-suggestion">
            <a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                    <div class="avatar"><img class="circle" src="{{ asset('assets/images/avatar/avatar-12.png') }}" width="30" alt="sample image"></div>
                    <div class="member-info display-flex flex-column"><span class="black-text">Anna Strong</span><small class="grey-text">Web Designer</small></div>
                    </div>
                </div>
            </a>
        </li>
    </ul>

    <ul class="display-none" id="page-search-title">
        <li class="auto-suggestion-title">
            <a class="collection-item" href="#">
                <h6 class="search-title">PAGES</h6>
            </a>
        </li>
    </ul>

    <ul class="display-none" id="search-not-found">
        <li class="auto-suggestion">
            <a class="collection-item display-flex align-items-center" href="#">
                <span class="material-icons">error_outline</span><span class="member-info">No results found.</span>
            </a>
        </li>
    </ul>

    <!-- BEGIN: SideNav-->
    <aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square">
        <div class="brand-sidebar">
            <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="{{ route('home') }}"><img class="hide-on-med-and-down" src="{{ asset('assets/images/logo/materialize-logo-color') }}.png" alt="materialize logo"/><img class="show-on-medium-and-down hide-on-med-and-up" src="{{ asset('assets/images/logo/materialize-logo.png') }}" alt="materialize logo"/><span class="logo-text hide-on-med-and-down">Materialize</span></a><a class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a></h1>
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

                        <li><a class="{{ Route::currentRouteName() === 'brands.index' ? 'gradient-45deg-indigo-blue active' : null }}" href="{{ route('brands.index') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="eCommerce">Производители</span></a></li>
                        <li><a class="{{ Route::currentRouteName() === 'medicine.index' ? 'gradient-45deg-indigo-blue active' : null }}" href="{{ route('medicine.index') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Analytics">Товары</span></a></li>
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
        </ul>
        <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
    </aside>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="content-wrapper-before gradient-45deg-indigo-light-blue"></div>
            
            @yield('content')
        </div>
    </div>
    <!-- END: Page Main-->
    
    <!-- BEGIN: Footer-->
    <footer class="page-footer footer footer-static footer-dark gradient-45deg-indigo-light-blue gradient-shadow navbar-border navbar-shadow">
        <div class="footer-copyright">
            <div class="container">
                <span>2020 &copy; All rights reserved.</span>
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