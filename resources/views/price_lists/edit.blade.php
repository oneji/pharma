@extends('layouts.main')

@section('title')
    Изменить прайс лист
@endsection

@section('head')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/select2-materialize.css') }}">
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

                                    {{-- Data sources: Medicine and Brands --}}
                                    <span style="display: none" id="brands-source">@json($brands)</span>
                                    <span style="display: none" id="medicine-source">@json($medicine)</span>

                                    <form action="{{ route('price_lists.update', [ 'id' => $priceList['id'] ]) }}" method="POST" class="form invoice-item-repeater" id="createPriceListForm">
                                        @csrf
                                        @method('PUT')
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
                                            <tbody data-repeater-list="price_list_data" id="price-list-body">
                                                @foreach ($priceList['items'] as $item)
                                                    <tr data-repeater-item>
                                                        <td  class="pl-1">
                                                            <input hidden type="text" class="center-align item-id browser-default" name="id" value="{{ $item->id }}">
                                                            <select class="medicine-select2 browser-default" name="medicine[]" required></select>
                                                        </td>
                                                        <td>
                                                            <select class="brands-select2 browser-default" name="brand[]" required></select>
                                                        </td>
                                                        <td>
                                                            <input name="exp_date[]" type="text" class="center-align datepicker browser-default" value="{{ \Carbon\Carbon::parse($item->exp_date)->format('d/m/Y') }}" required>
                                                        </td>
                                                        <td>
                                                            <input class="center-align browser-default" name="price[]" type="number" value="{{ $item->price }}" required>
                                                        </td>
                                                        <td>
                                                            <input class="center-align browser-default" name="quantity[]" type="number" value="{{ $item->quantity }}" required>
                                                        </td>
                                                        <td><i data-repeater-delete class="delete-row-btn material-icons">delete</i></td>
                                                    </tr>                                                    
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="input-field display-flex justify-content-end">
                                            <button class="btn blue add-item-btn" data-repeater-create type="button">Добавить товар</button>
                                            <button class="btn green create-price-list-submit-btn ml-1" type="submit">
                                                <span>Сохранить изменения</span>
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
    <script src="{{ asset('assets/vendors/form_repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/price_lists.js') }}"></script>
@endsection