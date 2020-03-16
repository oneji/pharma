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
    {{-- <div class="col s12">
        <div class="container">
            <div class="contact-overlay"></div>
            <div style="bottom: 54px; right: 19px;" class="fixed-action-btn direction-top">
                <a class="btn-floating btn-large primary-text gradient-shadow modal-trigger waves-effect waves-light btn green"
                    href="#addUserModal">
                    <i class="material-icons">person_add</i>
                </a>
            </div>

            <div class="sidebar-left sidebar-fixed">
                <div class="sidebar">
                    <div class="sidebar-content">
                        <div class="sidebar-header">
                            <div class="sidebar-details">
                                <h5 class="m-0 sidebar-title"><i
                                        class="material-icons app-header-icon text-top">perm_identity</i> Пользователи
                                </h5>
                                <div class="mt-10 pt-2">
                                    <p class="m-0 subtitle font-weight-700">Общее количество пользователей</p>
                                    <p class="m-0 text-muted">{{ $users->count() < 5 ? $users->count() . ' пользователя' : $users->count() . ' пользователей' }}</p>
                                </div>
                            </div>
                        </div>
                        <div id="sidebar-list"
                            class="sidebar-menu list-group position-relative animate fadeLeft delay-1">
                            <div class="sidebar-list-padding app-sidebar sidenav" id="contact-sidenav">
                                <ul class="contact-list display-grid">
                                    <li class="sidebar-title">Filters</li>
                                    <li class="active"><a href="javascript:void(0)" class="text-sub"><i
                                                class="material-icons mr-2">
                                                perm_identity </i> All
                                            Contact</a></li>
                                    <li><a href="javascript:void(0)" class="text-sub"><i
                                                class="material-icons mr-2"> history </i> Frequent</a>
                                    </li>
                                    <li><a href="javascript:void(0)" class="text-sub"><i
                                                class="material-icons mr-2"> star_border </i> Starred
                                            Contacts</a></li>
                                    <li class="sidebar-title">Options</li>
                                    <li><a href="javascript:void(0)" class="text-sub"><i
                                                class="material-icons mr-2"> keyboard_arrow_down </i>
                                            Import</a></li>
                                    <li><a href="javascript:void(0)" class="text-sub"><i
                                                class="material-icons mr-2"> keyboard_arrow_up </i>
                                            Export</a></li>
                                    <li><a href="javascript:void(0)" class="text-sub"><i
                                                class="material-icons mr-2"> print </i> Print</a></li>
                                    <li class="sidebar-title">Department</li>
                                    <li><a href="javascript:void(0)" class="text-sub"><i
                                                class="purple-text material-icons small-icons mr-2">
                                                fiber_manual_record </i> Engineering</a></li>
                                    <li><a href="javascript:void(0)" class="text-sub"><i
                                                class="amber-text material-icons small-icons mr-2">
                                                fiber_manual_record </i> Sales</a></li>
                                    <li><a href="javascript:void(0)" class="text-sub"><i
                                                class="light-green-text material-icons small-icons mr-2">
                                                fiber_manual_record </i> Support</a></li>
                                </ul>
                            </div>
                        </div>
                        <a href="#" data-target="contact-sidenav" class="sidenav-trigger hide-on-large-only"><i
                                class="material-icons">menu</i></a>
                    </div>
                </div>
            </div>

            <div class="content-area content-right">
                <div class="app-wrapper">
                    <div class="datatable-search">
                        <i class="material-icons mr-2 search-icon">search</i>
                        <input type="text" placeholder="Найти пользователя" class="app-filter" id="global_filter">
                    </div>
                    <div id="button-trigger" class="card card card-default scrollspy border-radius-6 fixed-width">
                        <div class="card-content p-0">
                            <table id="data-table-contact" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="background-image-none center-align">
                                            <label>
                                                <input type="checkbox" onClick="toggle(this)" />
                                                <span></span>
                                            </label>
                                        </th>
                                        <th>ФИО</th>
                                        <th>Email</th>
                                        <th>Телефона</th>
                                        <th>Заметки</th>
                                        <th>Роль</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="center-align contact-checkbox">
                                                <label class="checkbox-label">
                                                    <input type="checkbox" name="foo" />
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ $user->note }}</td>
                                            <td><span class="badge blue">{{ $user->roles->first()->display_name }}</span></td>
                                            <td>
                                                <a href="{{ route('users.edit', [ 'user' => $user->id ]) }}"><span><i class="material-icons delete">edit</i></span></a>

                                                @if ($user->status === 0)
                                                    <a href="#" onclick="event.preventDefault(); document.getElementById('active-form').submit();">
                                                        <span><i class="material-icons delete">lock_open</i></span>
                                                    </a>
                                                    <form id="active-form" action="{{ route('users.status', [ 'user' => $user->id, 'status' => 1 ]) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>
                                                    
                                                @else
                                                    <a href="#" onclick="event.preventDefault(); document.getElementById('deactive-form').submit();">
                                                        <span><i class="material-icons delete">lock</i></span>
                                                    </a>
                                                    <form id="deactive-form" action="{{ route('users.status', [ 'user' => $user->id, 'status' => 0 ]) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="addUserModal" class="modal" style="width: 40%">
                <form action="{{ route('users.store') }}" method="POST" id="addUserForm">
                    @csrf
                    <div class="modal-content">
                        <h5>Добавить пользователя</h5>
                            
                            <div class="container">
                                <div class="row">
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">perm_identity</i>
                                        <input id="name" name="name" type="text" class="validate">
                                        <label for="name">ФИО</label>
                                    </div>

                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">email</i>
                                        <input id="email" name="email" type="email" class="validate">
                                        <label for="email">Email</label>
                                    </div>

                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">lock</i>
                                        <input id="password" name="password" type="password" class="validate">
                                        <label for="password">Пароль</label>
                                    </div>

                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">lock</i>
                                        <input id="password_confirmation" name="password_confirmation" type="password" class="validate">
                                        <label for="password_confirmation">Подтвердите пароль</label>
                                    </div>                                      

                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">call</i>
                                        <input name="phone" type="text" class="validate">
                                        <label for="phone">Телефон</label>
                                    </div>

                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">note</i>
                                        <input name="note" type="text" class="validate">
                                        <label for="note">Заметки</label>
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

                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </div>
                            </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="waves-effect waves-light btn green">
                            <span>Добавить пользователя</span>
                        </button>
                    </div>
                </form>
            </div>
            
            <aside id="right-sidebar-nav">
                <div id="slide-out-right" class="slide-out-right-sidenav sidenav rightside-navigation">
                    <div class="row">
                        <div class="slide-out-right-title">
                            <div class="col s12 border-bottom-1 pb-0 pt-1">
                                <div class="row">
                                    <div class="col s2 pr-0 center">
                                        <i class="material-icons vertical-text-middle"><a href="#"
                                                class="sidenav-close">clear</a></i>
                                    </div>
                                    <div class="col s10 pl-0">
                                        <ul class="tabs">
                                            <li class="tab col s4 p-0">
                                                <a href="#messages" class="active">
                                                    <span>Messages</span>
                                                </a>
                                            </li>
                                            <li class="tab col s4 p-0">
                                                <a href="#settings">
                                                    <span>Settings</span>
                                                </a>
                                            </li>
                                            <li class="tab col s4 p-0">
                                                <a href="#activity">
                                                    <span>Activity</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slide-out-right-body row pl-3">
                            <div id="messages" class="col s12 pb-0">
                                <div class="collection border-none mb-0">
                                    <input class="header-search-input mt-4 mb-2" type="text" name="Search"
                                        placeholder="Search Messages" />
                                    <ul class="collection right-sidebar-chat p-0 mb-0">
                                        <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0"
                                            data-target="slide-out-chat">
                                            <span class="avatar-status avatar-online avatar-50"><img
                                                    src="{{ asset('assets/images/avatar/avatar-7.png') }}"
                                                    alt="avatar" />
                                                <i></i>
                                            </span>
                                            <div class="user-content">
                                                <h6 class="line-height-0">Elizabeth Elliott</h6>
                                                <p class="medium-small blue-grey-text text-lighten-3 pt-3">Thank you
                                                </p>
                                            </div>
                                            <span class="secondary-content medium-small">5.00 AM</span>
                                        </li>
                                        <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0"
                                            data-target="slide-out-chat">
                                            <span class="avatar-status avatar-online avatar-50"><img
                                                    src="{{ asset('assets/images/avatar/avatar-1.png') }}"
                                                    alt="avatar" />
                                                <i></i>
                                            </span>
                                            <div class="user-content">
                                                <h6 class="line-height-0">Mary Adams</h6>
                                                <p class="medium-small blue-grey-text text-lighten-3 pt-3">Hello Boo
                                                </p>
                                            </div>
                                            <span class="secondary-content medium-small">4.14 AM</span>
                                        </li>
                                        <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0"
                                            data-target="slide-out-chat">
                                            <span class="avatar-status avatar-off avatar-50"><img
                                                    src="{{ asset('assets/images/avatar/avatar-2.png') }}"
                                                    alt="avatar" />
                                                <i></i>
                                            </span>
                                            <div class="user-content">
                                                <h6 class="line-height-0">Caleb Richards</h6>
                                                <p class="medium-small blue-grey-text text-lighten-3 pt-3">Hello Boo
                                                </p>
                                            </div>
                                            <span class="secondary-content medium-small">4.14 AM</span>
                                        </li>
                                        <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0"
                                            data-target="slide-out-chat">
                                            <span class="avatar-status avatar-online avatar-50"><img
                                                    src="{{ asset('assets/images/avatar/avatar-3.png') }}"
                                                    alt="avatar" />
                                                <i></i>
                                            </span>
                                            <div class="user-content">
                                                <h6 class="line-height-0">Caleb Richards</h6>
                                                <p class="medium-small blue-grey-text text-lighten-3 pt-3">Keny !
                                                </p>
                                            </div>
                                            <span class="secondary-content medium-small">9.00 PM</span>
                                        </li>
                                        <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0"
                                            data-target="slide-out-chat">
                                            <span class="avatar-status avatar-online avatar-50"><img
                                                    src="{{ asset('assets/images/avatar/avatar-4.png') }}"
                                                    alt="avatar" />
                                                <i></i>
                                            </span>
                                            <div class="user-content">
                                                <h6 class="line-height-0">June Lane</h6>
                                                <p class="medium-small blue-grey-text text-lighten-3 pt-3">Ohh God
                                                </p>
                                            </div>
                                            <span class="secondary-content medium-small">4.14 AM</span>
                                        </li>
                                        <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0"
                                            data-target="slide-out-chat">
                                            <span class="avatar-status avatar-off avatar-50"><img
                                                    src="{{ asset('assets/images/avatar/avatar-5.png') }}"
                                                    alt="avatar" />
                                                <i></i>
                                            </span>
                                            <div class="user-content">
                                                <h6 class="line-height-0">Edward Fletcher</h6>
                                                <p class="medium-small blue-grey-text text-lighten-3 pt-3">Love you
                                                </p>
                                            </div>
                                            <span class="secondary-content medium-small">5.15 PM</span>
                                        </li>
                                        <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0"
                                            data-target="slide-out-chat">
                                            <span class="avatar-status avatar-online avatar-50"><img
                                                    src="{{ asset('assets/images/avatar/avatar-6.png') }}"
                                                    alt="avatar" />
                                                <i></i>
                                            </span>
                                            <div class="user-content">
                                                <h6 class="line-height-0">Crystal Bates</h6>
                                                <p class="medium-small blue-grey-text text-lighten-3 pt-3">Can we
                                                </p>
                                            </div>
                                            <span class="secondary-content medium-small">8.00 AM</span>
                                        </li>
                                        <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0"
                                            data-target="slide-out-chat">
                                            <span class="avatar-status avatar-off avatar-50"><img
                                                    src="{{ asset('assets/images/avatar/avatar-7.png') }}"
                                                    alt="avatar" />
                                                <i></i>
                                            </span>
                                            <div class="user-content">
                                                <h6 class="line-height-0">Nathan Watts</h6>
                                                <p class="medium-small blue-grey-text text-lighten-3 pt-3">Great!
                                                </p>
                                            </div>
                                            <span class="secondary-content medium-small">9.53 PM</span>
                                        </li>
                                        <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0"
                                            data-target="slide-out-chat">
                                            <span class="avatar-status avatar-off avatar-50"><img
                                                    src="{{ asset('assets/images/avatar/avatar-8.png') }}"
                                                    alt="avatar" />
                                                <i></i>
                                            </span>
                                            <div class="user-content">
                                                <h6 class="line-height-0">Willard Wood</h6>
                                                <p class="medium-small blue-grey-text text-lighten-3 pt-3">Do it</p>
                                            </div>
                                            <span class="secondary-content medium-small">4.20 AM</span>
                                        </li>
                                        <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0"
                                            data-target="slide-out-chat">
                                            <span class="avatar-status avatar-online avatar-50"><img
                                                    src="{{ asset('assets/images/avatar/avatar-1.png') }}"
                                                    alt="avatar" />
                                                <i></i>
                                            </span>
                                            <div class="user-content">
                                                <h6 class="line-height-0">Ronnie Ellis</h6>
                                                <p class="medium-small blue-grey-text text-lighten-3 pt-3">Got that
                                                </p>
                                            </div>
                                            <span class="secondary-content medium-small">5.20 AM</span>
                                        </li>
                                        <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0"
                                            data-target="slide-out-chat">
                                            <span class="avatar-status avatar-online avatar-50"><img
                                                    src="{{ asset('assets/images/avatar/avatar-9.png') }}"
                                                    alt="avatar" />
                                                <i></i>
                                            </span>
                                            <div class="user-content">
                                                <h6 class="line-height-0">Daniel Russell</h6>
                                                <p class="medium-small blue-grey-text text-lighten-3 pt-3">Thank you
                                                </p>
                                            </div>
                                            <span class="secondary-content medium-small">12.00 AM</span>
                                        </li>
                                        <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0"
                                            data-target="slide-out-chat">
                                            <span class="avatar-status avatar-off avatar-50"><img
                                                    src="{{ asset('assets/images/avatar/avatar-10.png') }}"
                                                    alt="avatar" />
                                                <i></i>
                                            </span>
                                            <div class="user-content">
                                                <h6 class="line-height-0">Sarah Graves</h6>
                                                <p class="medium-small blue-grey-text text-lighten-3 pt-3">Okay you
                                                </p>
                                            </div>
                                            <span class="secondary-content medium-small">11.14 PM</span>
                                        </li>
                                        <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0"
                                            data-target="slide-out-chat">
                                            <span class="avatar-status avatar-off avatar-50"><img
                                                    src="{{ asset('assets/images/avatar/avatar-11.png') }}"
                                                    alt="avatar" />
                                                <i></i>
                                            </span>
                                            <div class="user-content">
                                                <h6 class="line-height-0">Andrew Hoffman</h6>
                                                <p class="medium-small blue-grey-text text-lighten-3 pt-3">Can do
                                                </p>
                                            </div>
                                            <span class="secondary-content medium-small">7.30 PM</span>
                                        </li>
                                        <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0"
                                            data-target="slide-out-chat">
                                            <span class="avatar-status avatar-online avatar-50"><img
                                                    src="{{ asset('assets/images/avatar/avatar-12.png') }}"
                                                    alt="avatar" />
                                                <i></i>
                                            </span>
                                            <div class="user-content">
                                                <h6 class="line-height-0">Camila Lynch</h6>
                                                <p class="medium-small blue-grey-text text-lighten-3 pt-3">Leave it
                                                </p>
                                            </div>
                                            <span class="secondary-content medium-small">2.00 PM</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="settings" class="col s12">
                                <p class="setting-header mt-8 mb-3 ml-5 font-weight-900">GENERAL SETTINGS</p>
                                <ul class="collection border-none">
                                    <li class="collection-item border-none">
                                        <div class="m-0">
                                            <span>Notifications</span>
                                            <div class="switch right">
                                                <label>
                                                    <input checked type="checkbox" />
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item border-none">
                                        <div class="m-0">
                                            <span>Show recent activity</span>
                                            <div class="switch right">
                                                <label>
                                                    <input type="checkbox" />
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item border-none">
                                        <div class="m-0">
                                            <span>Show recent activity</span>
                                            <div class="switch right">
                                                <label>
                                                    <input type="checkbox" />
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item border-none">
                                        <div class="m-0">
                                            <span>Show Task statistics</span>
                                            <div class="switch right">
                                                <label>
                                                    <input type="checkbox" />
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item border-none">
                                        <div class="m-0">
                                            <span>Show your emails</span>
                                            <div class="switch right">
                                                <label>
                                                    <input type="checkbox" />
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item border-none">
                                        <div class="m-0">
                                            <span>Email Notifications</span>
                                            <div class="switch right">
                                                <label>
                                                    <input checked type="checkbox" />
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <p class="setting-header mt-7 mb-3 ml-5 font-weight-900">SYSTEM SETTINGS</p>
                                <ul class="collection border-none">
                                    <li class="collection-item border-none">
                                        <div class="m-0">
                                            <span>System Logs</span>
                                            <div class="switch right">
                                                <label>
                                                    <input type="checkbox" />
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item border-none">
                                        <div class="m-0">
                                            <span>Error Reporting</span>
                                            <div class="switch right">
                                                <label>
                                                    <input type="checkbox" />
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item border-none">
                                        <div class="m-0">
                                            <span>Applications Logs</span>
                                            <div class="switch right">
                                                <label>
                                                    <input checked type="checkbox" />
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item border-none">
                                        <div class="m-0">
                                            <span>Backup Servers</span>
                                            <div class="switch right">
                                                <label>
                                                    <input type="checkbox" />
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item border-none">
                                        <div class="m-0">
                                            <span>Audit Logs</span>
                                            <div class="switch right">
                                                <label>
                                                    <input type="checkbox" />
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div id="activity" class="col s12">
                                <div class="activity">
                                    <p class="mt-5 mb-0 ml-5 font-weight-900">SYSTEM LOGS</p>
                                    <ul class="widget-timeline mb-0">
                                        <li class="timeline-items timeline-icon-green active">
                                            <div class="timeline-time">Today</div>
                                            <h6 class="timeline-title">Homepage mockup design</h6>
                                            <p class="timeline-text">Melissa liked your activity.</p>
                                            <div class="timeline-content orange-text">Important</div>
                                        </li>
                                        <li class="timeline-items timeline-icon-cyan active">
                                            <div class="timeline-time">10 min</div>
                                            <h6 class="timeline-title">Melissa liked your activity Drinks.</h6>
                                            <p class="timeline-text">Here are some news feed interactions concepts.
                                            </p>
                                            <div class="timeline-content green-text">Resolved</div>
                                        </li>
                                        <li class="timeline-items timeline-icon-red active">
                                            <div class="timeline-time">30 mins</div>
                                            <h6 class="timeline-title">12 new users registered</h6>
                                            <p class="timeline-text">Here are some news feed interactions concepts.
                                            </p>
                                            <div class="timeline-content">
                                                <img src="{{ asset('assets/images/icon/pdf.png') }}" alt="document"
                                                    height="30" width="25" class="mr-1">Registration.doc
                                            </div>
                                        </li>
                                        <li class="timeline-items timeline-icon-indigo active">
                                            <div class="timeline-time">2 Hrs</div>
                                            <h6 class="timeline-title">Tina is attending your activity</h6>
                                            <p class="timeline-text">Here are some news feed interactions concepts.
                                            </p>
                                            <div class="timeline-content">
                                                <img src="{{ asset('assets/images/icon/pdf.png') }}" alt="document"
                                                    height="30" width="25" class="mr-1">Activity.doc
                                            </div>
                                        </li>
                                        <li class="timeline-items timeline-icon-orange">
                                            <div class="timeline-time">5 hrs</div>
                                            <h6 class="timeline-title">Josh is now following you</h6>
                                            <p class="timeline-text">Here are some news feed interactions concepts.
                                            </p>
                                            <div class="timeline-content red-text">Pending</div>
                                        </li>
                                    </ul>
                                    <p class="mt-5 mb-0 ml-5 font-weight-900">APPLICATIONS LOGS</p>
                                    <ul class="widget-timeline mb-0">
                                        <li class="timeline-items timeline-icon-green active">
                                            <div class="timeline-time">Just now</div>
                                            <h6 class="timeline-title">New order received urgent</h6>
                                            <p class="timeline-text">Melissa liked your activity.</p>
                                            <div class="timeline-content orange-text">Important</div>
                                        </li>
                                        <li class="timeline-items timeline-icon-cyan active">
                                            <div class="timeline-time">05 min</div>
                                            <h6 class="timeline-title">System shutdown.</h6>
                                            <p class="timeline-text">Here are some news feed interactions concepts.
                                            </p>
                                            <div class="timeline-content blue-text">Urgent</div>
                                        </li>
                                        <li class="timeline-items timeline-icon-red">
                                            <div class="timeline-time">20 mins</div>
                                            <h6 class="timeline-title">Database overloaded 89%</h6>
                                            <p class="timeline-text">Here are some news feed interactions concepts.
                                            </p>
                                            <div class="timeline-content">
                                                <img src="{{ asset('assets/images/icon/pdf.png') }}" alt="document"
                                                    height="30" width="25" class="mr-1">Database-log.doc
                                            </div>
                                        </li>
                                    </ul>
                                    <p class="mt-5 mb-0 ml-5 font-weight-900">SERVER LOGS</p>
                                    <ul class="widget-timeline mb-0">
                                        <li class="timeline-items timeline-icon-green active">
                                            <div class="timeline-time">10 min</div>
                                            <h6 class="timeline-title">System error</h6>
                                            <p class="timeline-text">Melissa liked your activity.</p>
                                            <div class="timeline-content red-text">Error</div>
                                        </li>
                                        <li class="timeline-items timeline-icon-cyan">
                                            <div class="timeline-time">1 min</div>
                                            <h6 class="timeline-title">Production server down.</h6>
                                            <p class="timeline-text">Here are some news feed interactions concepts.
                                            </p>
                                            <div class="timeline-content blue-text">Urgent</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ul id="slide-out-chat" class="sidenav slide-out-right-sidenav-chat">
                    <li class="center-align pt-2 pb-2 sidenav-close chat-head">
                        <a href="#!"><i class="material-icons mr-0">chevron_left</i>Elizabeth Elliott</a>
                    </li>
                    <li class="chat-body">
                        <ul class="collection">
                            <li class="collection-item display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                <span class="avatar-status avatar-online avatar-50"><img
                                        src="{{ asset('assets/images/avatar/avatar-7.png') }}" alt="avatar" />
                                </span>
                                <div class="user-content speech-bubble">
                                    <p class="medium-small">hello!</p>
                                </div>
                            </li>
                            <li class="collection-item display-flex avatar justify-content-end pl-5 pb-0"
                                data-target="slide-out-chat">
                                <div class="user-content speech-bubble-right">
                                    <p class="medium-small">How can we help? We're here for you!</p>
                                </div>
                            </li>
                            <li class="collection-item display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                <span class="avatar-status avatar-online avatar-50"><img
                                        src="{{ asset('assets/images/avatar/avatar-7.png') }}" alt="avatar" />
                                </span>
                                <div class="user-content speech-bubble">
                                    <p class="medium-small">I am looking for the best admin template.?</p>
                                </div>
                            </li>
                            <li class="collection-item display-flex avatar justify-content-end pl-5 pb-0"
                                data-target="slide-out-chat">
                                <div class="user-content speech-bubble-right">
                                    <p class="medium-small">Materialize admin is the responsive materializecss admin
                                        template.</p>
                                </div>
                            </li>

                            <li class="collection-item display-grid width-100 center-align">
                                <p>8:20 a.m.</p>
                            </li>

                            <li class="collection-item display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                <span class="avatar-status avatar-online avatar-50"><img
                                        src="{{ asset('assets/images/avatar/avatar-7.png') }}" alt="avatar" />
                                </span>
                                <div class="user-content speech-bubble">
                                    <p class="medium-small">Ohh! very nice</p>
                                </div>
                            </li>
                            <li class="collection-item display-flex avatar justify-content-end pl-5 pb-0"
                                data-target="slide-out-chat">
                                <div class="user-content speech-bubble-right">
                                    <p class="medium-small">Thank you.</p>
                                </div>
                            </li>
                            <li class="collection-item display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                <span class="avatar-status avatar-online avatar-50"><img
                                        src="{{ asset('assets/images/avatar/avatar-7.png') }}" alt="avatar" />
                                </span>
                                <div class="user-content speech-bubble">
                                    <p class="medium-small">How can I purchase it?</p>
                                </div>
                            </li>

                            <li class="collection-item display-grid width-100 center-align">
                                <p>9:00 a.m.</p>
                            </li>

                            <li class="collection-item display-flex avatar justify-content-end pl-5 pb-0"
                                data-target="slide-out-chat">
                                <div class="user-content speech-bubble-right">
                                    <p class="medium-small">From ThemeForest.</p>
                                </div>
                            </li>
                            <li class="collection-item display-flex avatar justify-content-end pl-5 pb-0"
                                data-target="slide-out-chat">
                                <div class="user-content speech-bubble-right">
                                    <p class="medium-small">Only $24</p>
                                </div>
                            </li>
                            <li class="collection-item display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                <span class="avatar-status avatar-online avatar-50"><img
                                        src="{{ asset('assets/images/avatar/avatar-7.png') }}" alt="avatar" />
                                </span>
                                <div class="user-content speech-bubble">
                                    <p class="medium-small">Ohh! Thank you.</p>
                                </div>
                            </li>
                            <li class="collection-item display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                <span class="avatar-status avatar-online avatar-50"><img
                                        src="{{ asset('assets/images/avatar/avatar-7.png') }}" alt="avatar" />
                                </span>
                                <div class="user-content speech-bubble">
                                    <p class="medium-small">I will purchase it for sure.</p>
                                </div>
                            </li>
                            <li class="collection-item display-flex avatar justify-content-end pl-5 pb-0"
                                data-target="slide-out-chat">
                                <div class="user-content speech-bubble-right">
                                    <p class="medium-small">Great, Feel free to get in touch on</p>
                                </div>
                            </li>
                            <li class="collection-item display-flex avatar justify-content-end pl-5 pb-0"
                                data-target="slide-out-chat">
                                <div class="user-content speech-bubble-right">
                                    <p class="medium-small">https://pixinvent.ticksy.com/</p>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="center-align chat-footer">
                        <form class="col s12" onsubmit="slideOutChat()" action="javascript:void(0);">
                            <div class="input-field">
                                <input id="icon_prefix" type="text" class="search" />
                                <label for="icon_prefix">Type here..</label>
                                <a onclick="slideOutChat()"><i class="material-icons prefix">send</i></a>
                            </div>
                        </form>
                    </li>
                </ul>
            </aside>
        </div>
        <div class="content-overlay"></div>
    </div> --}}

    <div style="bottom: 54px; right: 19px;" class="fixed-action-btn direction-top">
        <a class="btn-floating btn-large primary-text gradient-shadow modal-trigger waves-effect waves-light btn green"
            href="#addUserModal">
            <i class="material-icons">person_add</i>
        </a>
    </div>

    <div id="addUserModal" class="modal" style="width: 40%">
        <form action="{{ route('users.store') }}" method="POST" id="addUserForm">
            @csrf
            <div class="modal-content">
                <h5>Добавить пользователя</h5>
                    
                    <div class="container">
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">perm_identity</i>
                                <input id="name" name="name" type="text" class="validate">
                                <label for="name">ФИО</label>
                            </div>

                            <div class="input-field col s6">
                                <i class="material-icons prefix">email</i>
                                <input id="email" name="email" type="email" class="validate">
                                <label for="email">Email</label>
                            </div>

                            <div class="input-field col s6">
                                <i class="material-icons prefix">lock</i>
                                <input id="password" name="password" type="password" class="validate">
                                <label for="password">Пароль</label>
                            </div>

                            <div class="input-field col s6">
                                <i class="material-icons prefix">lock</i>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="validate">
                                <label for="password_confirmation">Подтвердите пароль</label>
                            </div>                                      

                            <div class="input-field col s6">
                                <i class="material-icons prefix">call</i>
                                <input name="phone" type="text" class="validate">
                                <label for="phone">Телефон</label>
                            </div>

                            <div class="input-field col s6">
                                <i class="material-icons prefix">note</i>
                                <input name="note" type="text" class="validate">
                                <label for="note">Заметки</label>
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
                                <label for="role">Роли</label>
                            </div>

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="waves-effect waves-light btn green">
                    <span>Добавить пользователя</span>
                </button>
            </div>
        </form>
    </div>

    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Список пользователей</span></h5>
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Список пользователей</li>
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
                                            <th>Email</th>
                                            <th>Телефона</th>
                                            <th>Заметки</th>
                                            <th>Роль</th>
                                            <th>Пароль</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $idx => $user)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ $user->note }}</td>
                                            <td><span class="badge blue">{{ $user->roles->first()->display_name }}</span></td>
                                            <td><span class="badge {{ $user->password_changed === 1 ? 'green' : 'orange' }}">{{ $user->password_changed === 1 ? 'Изменил' : 'Не изменял'}}</span></td>
                                            <td>
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
@endsection
