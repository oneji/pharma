@extends('layouts.main')

@section('title')
    Изменить прайс лист
@endsection

@section('head')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/select2.min.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/select2-materialize.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/app-invoice.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/form-select2.min.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col s12">
            <div class="container">
                <section class="section">
                    <div class="row">
                        <div class="col xl12 m12 s12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="row mb-1">
                                        <div class="col s12 m12 xl12">
                                            <h4 class="indigo-text">Изменить прайс лист</h4>
                                        </div>
                                    </div>
                                    <div class="">
                                        <form action="{{ route('price_lists.update', [ 'id' => $priceList['id'] ]) }}" method="POST" class="form invoice-item-repeater" id="createPriceListForm">
                                            @csrf
                                            @method('PUT')
                                            <table class="striped responsive-table price-list-table">
                                                <thead>
                                                    <tr>
                                                        <th class="center-align">#</th>
                                                        <th>Продукт</th>
                                                        <th>Производитель</th>
                                                        <th>Срок годности (до)</th>
                                                        <th class="center-align">Цена</th>
                                                        <th class="center-align">Кол-во в коробке (шт.)</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody data-repeater-list="price_list_data">
                                                    @foreach ($priceList['items'] as $item)
                                                        <tr data-repeater-item>
                                                            <td>
                                                                <input style="width: 50px;" class="center-align item-id" name="id" readonly value="{{ $item->id }}" />
                                                            </td>
                                                            <td>
                                                                <select class="select2 browser-default" name="medicine_id" required>
                                                                    @foreach ($medicine as $idx => $med)
                                                                        <option {{ $med->id === $item->medicine_id ? 'selected' : null }} value="{{ $med->id }}">{{ $med->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="select2 browser-default" name="brand_id" required>
                                                                    @foreach ($brands as $idx => $brand)
                                                                        <option {{ $brand->id === $item->brand_id ? 'selected' : null }} value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input name="exp_date" type="text" class="center-align datepicker" value="{{ \Carbon\Carbon::parse($item->exp_date)->format('d/m/Y') }}" required>
                                                            </td>
                                                            <td>
                                                                <input class="center-align" name="price" type="number" placeholder="Цена" value="{{ $item->price }}" required>
                                                            </td>
                                                            <td>
                                                                <input class="center-align" name="quantity" type="number" placeholder="Кол-во" value="{{ $item->quantity }}" required>
                                                            </td>
                                                            <td>
                                                                <span data-repeater-delete class="delete-row-btn">
                                                                    <i class="material-icons">delete</i>
                                                                </span>
                                                            </td>
                                                        </tr>                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="input-field display-flex justify-content-end">
                                                <button class="btn blue" data-repeater-create type="button">
                                                    <i class="material-icons left">add</i>
                                                    <span>Добавить товар</span>
                                                </button>
                                                <button class="btn green create-price-list-submit-btn ml-1" type="submit">
                                                    <span>Сохранить изменения</span>
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
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection