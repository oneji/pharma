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
                                            <tbody id="price-list-body">
                                                @foreach ($priceList['items'] as $item)
                                                    <tr>
                                                        <td  class="pl-1" style="min-width: 250px">
                                                            <input hidden type="text" class="center-align item-id browser-default" name="items[{{ $item->id }}][id]" value="{{ $item->id }}">
                                                            <select name="items[{{ $item->id }}][medicine]" class="medicine-select2 browser-default" required data-error=".medicine-error-{{ $item->id }}">
                                                                <option value="{{ $item->medicine_id }}">{{ $item->medicine_name }}</option>
                                                            </select>
                                                            <small class="medicine-error-{{ $item->id }}"></small>
                                                        </td>
                                                        <td>
                                                            <select name="items[{{ $item->id }}][brand]" class="brands-select2 browser-default" required data-error=".brands-error-{{ $item->id }}">
                                                                <option value="{{ $item->brand_id }}">{{ $item->brand_name }}</option>
                                                            </select>
                                                            <small class="brands-error-{{ $item->id }}"></small>
                                                        </td>
                                                        <td>
                                                            <input name="items[{{ $item->id }}][exp_date]" type="text" class="center-align datepicker browser-default" required data-error=".exp-date-error-{{ $item->id }}" value="{{ \Carbon\Carbon::parse($item->exp_date)->format('d/m/Y') }}">
                                                            <small class="exp-date-error-{{ $item->id }}"></small>
                                                        </td>
                                                        <td>
                                                            <input name="items[{{ $item->id }}][price]" type="number" class="center-align browser-default" required data-error=".price-error-{{ $item->id }}" value="{{ $item->price }}">
                                                            <small class="price-error-{{ $item->id }}"></small>
                                                        </td>
                                                        <td>
                                                            <input name="items[{{ $item->id }}][quantity]" type="number" class="center-align browser-default" required data-error=".quantity-error-{{ $item->id }}" value="{{ $item->quantity }}">
                                                            <small class="quantity-error-{{ $item->id }}"></small>
                                                        </td>
                                                        <td><i class="delete-row-btn material-icons">delete</i></td>
                                                    </tr>                                                    
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="input-field display-flex justify-content-end">
                                            <button class="btn blue add-item-btn" data-repeater-create type="button">Добавить товар</button>
                                            <button class="btn green create-price-list-submit-btn ml-1" type="submit">
                                                <span>Изменить</span>
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
    <script src="{{ asset('assets/js/custom/price_lists.js') }}"></script>
@endsection