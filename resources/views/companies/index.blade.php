@extends('layouts.main')

@section('title')
    Компании
@endsection

@section('head')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/app-invoice.min.css') }}">
@endsection

@section('content')

    <div id="addCompanyModal" class="modal" style="width: 40%">
        <form action="{{ route('companies.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <h5>Добавить компанию</h5>
                    
                <div class="container">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">all_inbox</i>
                            <input required name="name" type="text" class="validate" placeholder="Введите компанию">
                            <label for="name" data-error="wrong" data-success="right">Название компании</label>
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

    <div id="editCompanyModal" class="modal" style="width: 40%">
        <form method="PUT" id="editCompanyForm">
            @csrf
            <div class="modal-content">
                <h5>Изменить компанию</h5>
                    
                <div class="container">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">all_inbox</i>
                            <input required name="name" type="text" class="validate" placeholder="Введите компанию">
                            <label for="name" data-error="wrong" data-success="right">Название компании</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="waves-effect waves-light btn green">
                    <span>Изменить</span>
                </button>
            </div>
        </form>
    </div>

    <div class="col s12">
        <div class="container">

            <section class="invoice-list-wrapper section">
                <!-- create company button-->
                <div class="invoice-create-btn">
                    <a href="#addCompanyModal"
                        class="btn waves-effect waves-light border-round z-depth-1 modal-trigger">
                        <i class="material-icons">add</i>
                        <span class="hide-on-small-only">Добавить компанию</span>
                    </a>
                </div>
                <div class="responsive-table">
                    <table class="table companies-table invoice-data-table white border-radius-4 pt-1">
                        <thead>
                            <tr>
                                <th class="center-align">#</th>
                                <th>Компания</th>
                                <th>Действия</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($companies as $idx => $company)
                                <tr data-id="{{ $company->id }}">
                                    <td class="center-align">{{ $idx + 1 }}</td>
                                    <td class="company-name">{{ $company->name }}</td>
                                    <td>
                                        <div class="invoice-action">
                                            <a href="#" class="edit-company-btn" data-id="{{ $company->id }}">
                                                <i class="material-icons">edit</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/data-tables/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/advance-ui-modals.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/companies.js') }}"></script>
@endsection
