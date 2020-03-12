@extends('layouts.main')

@section('title')
Производители
@endsection

@section('head')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/flag-icon/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/data-tables/css/select.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/data-tables.min.css') }}">
    <style>
        .addBrandForm {
            float: right;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection

@section('content')
    <div style="bottom: 54px; right: 19px;" class="fixed-action-btn direction-top">
        <a class="btn-floating btn-large primary-text gradient-shadow modal-trigger waves-effect waves-light btn green"
            href="#addBrandModal">
            <i class="material-icons">add</i>
        </a>
    </div>

    <div id="addBrandModal" class="modal" style="width: 40%">
        <form action="{{ route('brands.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <h5>Добавить производителя</h5>
                    
                <div class="container">
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field m-0">
                                <i class="material-icons prefix">playlist_add</i>
                                <input required name="name" type="text" class="validate">
                                <label for="name" data-error="wrong" data-success="right">Название</label>
                            </div>
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

    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
        <!-- Search for small screen-->
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>DataTable</span></h5>
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Table</a>
                        </li>
                        <li class="breadcrumb-item active">DataTable
                        </li>
                    </ol>
                </div>
                <div class="col s2 m6 l6"><a
                        class="btn dropdown-settings waves-effect waves-light breadcrumbs-btn right" href="#!"
                        data-target="dropdown1"><i class="material-icons hide-on-med-and-up">settings</i><span
                            class="hide-on-small-onl">Settings</span><i
                            class="material-icons right">arrow_drop_down</i></a>
                    <ul class="dropdown-content" id="dropdown1" tabindex="0">
                        <li tabindex="0"><a class="grey-text text-darken-2" href="user-profile-page.html">Profile<span
                                    class="new badge red">2</span></a></li>
                        <li tabindex="0"><a class="grey-text text-darken-2" href="app-contacts.html">Contacts</a></li>
                        <li tabindex="0"><a class="grey-text text-darken-2" href="page-faq.html">FAQ</a></li>
                        <li class="divider" tabindex="-1"></li>
                        <li tabindex="0"><a class="grey-text text-darken-2" href="user-login.html">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="col s12">
        <div class="container">
            <div class="section section-data-tables">

                <div class="row">
                    <div class="col s12">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Список производителей</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="page-length-option" class="display">
                                            <thead>
                                                <tr>
                                                    <th>Название</th>
                                                    <th>Действия</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($brands as $idx => $brand)
                                                    <tr>
                                                        <td>{{ $brand->name }}</td>
                                                        <td>
                                                            <a href="#" style="color: green">
                                                                <span><i class="material-icons delete">edit</i></span>
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
    <script src="{{ asset('assets/vendors/data-tables/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/advance-ui-modals.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#page-length-option").DataTable({
                responsive: !0,
                lengthMenu: [ [ 10, 25, 50, -1 ], [ 10, 25, 50, "All" ] ]
            });
        }); 
    </script>
@endsection
