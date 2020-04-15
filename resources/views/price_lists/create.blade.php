@extends('layouts.main')

@section('title')
    Создать прайс лист
@endsection

@section('head')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/select2-materialize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/app-invoice.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/form-select2.min.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col s12">
            <div class="container">
                <section class="section">
                    <div class="row">
                        <!-- invoice view page -->
                        <div class="col xl12 m12 s12">
                            <div class="card">
                                <div class="card-content">
                                    <!-- logo and title -->
                                    <div class="row mb-1">
                                        <div class="col s12 m12 l12">
                                            <h4 class="indigo-text">Создать прайс лист</h4>
                                        </div>
                                    </div>
                                    <form action="{{ route('price_lists.store') }}" method="POST" class="form" id="createPriceListForm">
                                        @csrf
                                        <table class="striped responsive-table price-list-table">
                                            <thead>
                                                <tr>
                                                    <th>Продукт</th>
                                                    <th>Производитель</th>
                                                    <th class="center-align">Срок годности (до)</th>
                                                    <th class="center-align">Цена (с.)</th>
                                                    <th class="center-align">Кол-во в коробке (шт.)</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="price-list-body">
                                                <tr>
                                                    <td  class="pl-1" style="min-width: 250px">
                                                        <select name="items[0][medicine]" class="medicine-select2 browser-default" required data-error=".medicine-error"></select>
                                                        <small class="medicine-error"></small>
                                                    </td>
                                                    <td>
                                                        <select name="items[0][brand]" class="brands-select2 browser-default" required data-error=".brands-error"></select>
                                                        <small class="brands-error"></small>
                                                    </td>
                                                    <td>
                                                        <input name="items[0][exp_date]" type="text" class="center-align datepicker browser-default" required data-error=".exp-date-error">
                                                        <small class="exp-date-error"></small>
                                                    </td>
                                                    <td>
                                                        <input name="items[0][price]" type="number" class="center-align browser-default" required data-error=".price-error">
                                                        <small class="price-error"></small>
                                                    </td>
                                                    <td>
                                                        <input name="items[0][quantity]" type="number" class="center-align browser-default" required data-error=".quantity-error">
                                                        <small class="quantity-error"></small>
                                                    </td>
                                                    <td><i class="delete-row-btn material-icons">delete</i></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="input-field display-flex justify-content-end">
                                            <button class="btn blue add-item-btn" type="button">Добавить товар</button>
                                            <button class="btn green create-price-list-submit-btn ml-1" type="submit">
                                                <span>Создать</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="{{ asset('assets/vendors/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/create-price-list.js') }}"></script>
@endsection