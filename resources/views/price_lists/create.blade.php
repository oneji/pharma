@extends('layouts.main')

@section('title')
    Прайс листы
@endsection

@section('head')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/select2.min.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/select2-materialize.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/app-invoice.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/form-select2.min.css') }}">

    <style>
        .invoice-edit-wrapper .invoice-item .invoice-item-filed {
            padding: 0 10px;
        }

        .my-10 {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .error {
            color: red;
        }
    </style>

@endsection

@section('content')
    <div class="row">
        <div class="col s12">
            <div class="container">
                <section class="invoice-edit-wrapper section">
                    <div class="row">
                        <!-- invoice view page -->
                        <div class="col xl12 m12 s12">
                            <div class="card">
                                <div class="card-content">
                                    <!-- logo and title -->
                                    <div class="row mb-3">
                                        <div class="col m6 s12 invoice-logo display-flex pt-1 push-m6"></div>
                                        <div class="col m3 s12 pull-m6">
                                            <h4 class="indigo-text">Создать прайс лист</h4>
                                            <input name="pl_created_at" type="text" class="datepicker mr-2 mb-1" placeholder="Выберите дату прайс листа">
                                        </div>
                                    </div>
                                    <!-- product details table-->
                                    <div class="invoice-product-details mb-3">
                                        <form action="{{ route('price_lists.store') }}" method="POST" class="form invoice-item-repeater" id="createPriceListForm">
                                            @csrf
                                            <div data-repeater-list="price_list_data">
                                                <!-- invoice Titles -->
                                                <div class="row mb-1">
                                                    <div class="col s3 m3">
                                                        <h6 class="m-0">Товар</h6>
                                                    </div>
                                                    <div class="col s3 m3">
                                                        <h6 class="m-0">Производитель</h6>
                                                    </div>
                                                    <div class="col s3 m2">
                                                        <h6 class="m-0">Срок годности</h6>
                                                    </div>
                                                    <div class="col s3 m2">
                                                        <h6 class="m-0">Цена</h6>
                                                    </div>
                                                    <div class="col s3 m2">
                                                        <h6 class="m-0">Кол-во</h6>
                                                    </div>
                                                </div>
                                                <div class="invoice-item display-flex mb-1" data-repeater-item>
                                                    <div class="invoice-item-filed row" style="width: 100%">
                                                        <div class="col s12 m3 my-10">
                                                            <select class="select2 browser-default" name="medicine_id" required>
                                                                @foreach ($medicine as $idx => $med)
                                                                    <option {{ $idx === 0 ? 'selected' : null }} value="{{ $med->id }}">{{ $med->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col s12 m3 my-10">
                                                            <select class="select2 browser-default" name="brand_id" required>
                                                                @foreach ($brands as $idx => $brand)
                                                                    <option {{ $idx === 0 ? 'selected' : null }} value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col s12 m2 my-10">
                                                            <input name="exp_date" type="text" class="datepicker" required>
                                                        </div>
                                                        <div class="col s12 m2 my-10">
                                                            <input name="price" type="text" placeholder="Введите цену" required>
                                                        </div>
                                                        <div class="col s12 m2 my-10">
                                                            <input name="quantity" type="number" placeholder="Введите количество" required>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="invoice-icon display-flex flex-column justify-content-between">
                                                        <span data-repeater-delete class="delete-row-btn">
                                                            <i class="material-icons">clear</i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-field">
                                                <button class="btn invoice-repeat-btn blue" data-repeater-create type="button">
                                                    <i class="material-icons left">add</i>
                                                    <span>Добавить товар</span>
                                                </button>
                                                <button class="btn green create-price-list-submit-btn" type="submit">
                                                    <span>Создать</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
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
    <script src="{{ asset('assets/vendors/form_repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/price_lists.js') }}"></script>
@endsection