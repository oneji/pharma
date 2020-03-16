@extends('layouts.main')

@section('title')
    Создание заявки
@endsection

@section('head')
    @parent

    <style>
        .request-pl-table td {
            padding: 10px 5px;
        }
    </style>

@endsection

@section('content')
    <div class="row">
        <div class="col s12">
            <div class="container">
                <section class="section">
                    <div class="row">
                        <div class="col xl12 m12 s12">
                            <div class="card">
                                <form action="{{ route('requests.store') }}" method="POST" id="createRequestForm">
                                    @csrf()
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" id="request-number" name="request_number">
                                                <label class="active">Номер заявки</label>
                                            </div>
                                        </div>
    
                                        <div class="row display-flex align-items-center mt-1">
                                            <div class="col s12 m8 l8 ml-0">
                                                <h4 class="indigo-text">Создание заявки</h4>
                                            </div>
    
                                            <div class="col s12 m4 l4 ml-0">
                                                <button class="btn btn-small indigo waves-effect waves-light show-chosen-btn" style="float: right">Показать выбранные</button>
                                            </div>
                                        </div>
                                        
                                        <div class="divider"></div>
    
                                        <div>
                                            <table class="striped responsive-table request-pl-table">
                                                <thead>
                                                    <tr>
                                                        <th class="background-image-none center-align">
                                                            <i class="material-icons">check</i>
                                                        </th>
                                                        <th>Продукт</th>
                                                        <th>Производитель</th>
                                                        <th>Срок годности (до)</th>
                                                        <th class="right-center">Цена (с.)</th>
                                                        <th>Кол-во (шт.)</th>
                                                        {{-- <th>Коммент</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($priceList->items as $item)
                                                        <tr>
                                                            <td class="center-align contact-checkbox">
                                                                <label class="checkbox-label">
                                                                    <input
                                                                        type="checkbox" 
                                                                        class="choose-pl-item" 
                                                                        data-price="{{ $item->price }}" 
                                                                        data-discount="{{ Auth::user()->discount_amount }}"
                                                                        data-item-id="{{ $item->id }}"
                                                                    />
                                                                    <span></span>
                                                                </label>
                                                            </td>
                                                            <td>{{ $item->medicine_name }}</td>
                                                            <td>{{ $item->brand_name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->exp_date)->locale('ru')->isoFormat('MMMM D, YYYY') }}</td>
                                                            <td class="indigo-text center-align price">
                                                                <span class="badge green">{{ $item->price }}c.</span>
                                                            </td>
                                                            <td style="max-width: 100px;">
                                                                <input type="number"  min="0" name="quantity[{{ $item->id }}]" class="request-pl-item-quantity">
                                                            </td>
                                                            {{-- <td>
                                                                <input type="text" class="request-pl-item-comment">
                                                            </td> --}}
                                                        </tr>                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
    
                                        <div class="divider mt-3"></div>
    
                                        <div class="row">
                                            <div class="col xl4 m7 s12 offset-xl8">
                                                <ul>
                                                    <li class="display-flex justify-content-between">
                                                        <span class="request-subtotal-title">Общая цена</span>
                                                        <h6 class="request-total-price">0с.</h6>
                                                    </li>
                                                    <li class="display-flex justify-content-between">
                                                        <span class="request-subtotal-title">Процент скидки</span>
                                                        <h6 class="request-subtotal-value">{{ Auth::user()->discount_amount }}%</h6>
                                                    </li>
                                                    <li class="display-flex justify-content-between">
                                                        <span class="request-subtotal-title">Сумма скидки</span>
                                                        <h6 class="request-discount-amount">- 0с.</h6>
                                                    </li>
                                                    <li>
                                                        <div class="divider mt-2 mb-2"></div>
                                                    </li>
                                                    <li class="display-flex justify-content-between">
                                                        <span class="request-subtotal-title">Цена со скидкой</span>
                                                        <h6 class="request-total-discount-price">0с.</h6>
                                                    </li>
                                                    <li class=" mt-2">
                                                        <button type="submit" class="btn btn-block waves-effect waves-light green create-request-btn">Создать заявку</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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

    <script src="{{ asset('assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/create-request.js') }}"></script>
@endsection