@extends('layouts.main')

@section('title')
    Товары
@endsection

@section('head')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/app-invoice.min.css') }}">
@endsection

@section('content')
    <div style="bottom: 54px; right: 19px;" class="fixed-action-btn direction-top">
        <a class="btn-floating btn-large primary-text gradient-shadow modal-trigger waves-effect waves-light btn green"
            href="#addMedicineModal">
            <i class="material-icons">add</i>
        </a>
    </div>

    <div id="addMedicineModal" class="modal" style="width: 40%">
        <form action="{{ route('medicine.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <h5>Добавить наименование</h5>
                    
                <div class="container">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">playlist_add</i>
                            <input required name="name" type="text" class="validate" placeholder="Введите наименование">
                            <label for="name" data-error="wrong" data-success="right">Наименование</label>
                        </div>

                        <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <select id="brand_id" name="brand_id">
                                @foreach ($brands as $idx => $brand)
                                    <option {{ $idx === 0 ? 'selected' : null }} value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            <label for="brand_id">Производитель</label>
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

    <div class="col s12">
        <div class="container">

            <section class="invoice-list-wrapper section">
                <!-- create brand button-->
                <div class="invoice-create-btn">
                    <a href="#addMedicineModal"
                        class="btn waves-effect waves-light border-round z-depth-1 modal-trigger">
                        <i class="material-icons">add</i>
                        <span class="hide-on-small-only">Добавить наименование</span>
                    </a>
                </div>
                <div class="responsive-table">
                    <table class="table invoice-data-table white border-radius-4 pt-1">
                        <thead>
                            <tr>
                                <th class="center-align">#</th>
                                <th>Наименование</th>
                                <th>Производитель</th>
                                <th>Действия</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($medicine as $idx => $med)
                                <tr>
                                    <td class="center-align">{{ $idx + 1 }}</td>
                                    <td>{{ $med->medicine_name }}</td>
                                    <td>{{ $med->brand_name }}</td>
                                    <td>
                                        <div class="invoice-action">
                                            <a href="app-invoice-edit.html" class="invoice-action-edit">
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
    <script src="{{ asset('assets/js/custom/medicine.js') }}"></script>
@endsection
