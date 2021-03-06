@extends('layouts.main')

@section('title')
    Создание заявки
@endsection

@section('head')
    @parent

    <style>
        
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
                                <div id="loading">
                                    <div class="preloader-wrapper big active">
                                        <div class="spinner-layer spinner-green-only">
                                            <div class="circle-clipper left">
                                                <div class="circle"></div>
                                            </div>
                                            <div class="gap-patch">
                                                <div class="circle"></div>
                                            </div>
                                            <div class="circle-clipper right">
                                                <div class="circle"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('requests.store') }}" method="POST" id="createRequestForm">
                                    @csrf()
                                    <div class="card-content">
                                        <div class="row display-flex align-items-center mt-1">
                                            <div class="col s12 m8 l8 ml-0">
                                                <h4 class="indigo-text">Создание заявки</h4>
                                            </div>

                                            <div class="col s12 m4 l4 ml-0">
                                                <button type="button" class="btn btn-small indigo waves-effect waves-light show-chosen-btn" style="float: right">Показать выбранные</button>
                                            </div>
                                        </div>
                                        
                                        <div class="divider"></div>
    
                                        <div>
                                            <table class="striped responsive-table request-pl-table">
                                                <thead>
                                                    <tr>
                                                        <th>Продукт</th>
                                                        <th>Производитель</th>
                                                        <th>Срок годности (до)</th>
                                                        <th class="center-align">Кол-во в коробке (шт.)</th>
                                                        <th class="right-center">Цена (с.)</th>
                                                        <th class="center-align">Кол-во коробок (шт.)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($priceList->items as $item)
                                                        <tr>
                                                            <td class="contact-checkbox">
                                                                <label class="checkbox-label">
                                                                    <input
                                                                        type="checkbox" 
                                                                        class="choose-pl-item" 
                                                                        data-price="{{ $item->price }}" 
                                                                        data-discount="{{ Auth::user()->discount_amount }}"
                                                                        data-item-id="{{ $item->id }}"
                                                                    />
                                                                    <span>{{ $item->medicine_name }}</span>
                                                                </label>
                                                            </td>
                                                            <td>{{ $item->brand_name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->exp_date)->locale('ru')->isoFormat('MMMM D, YYYY') }}</td>
                                                            <td class="center-align price-for-one-in-box">{{ $item->quantity }}</td>
                                                            <td class="indigo-text center-align price">
                                                                <span class="badge green">{{ $item->price }}c.</span>
                                                            </td>
                                                            <td style="max-width: 100px; text-align: center">
                                                                <input type="number"  min="0" name="quantity[{{ $item->id }}]" class="request-pl-item-quantity browser-default center-align" data-error=".quantity-{{ $item->id }}">
                                                                <small class="quantity-{{ $item->id }}"></small>
                                                            </td>
                                                        </tr>                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
    
                                        <div class="divider mt-1 mb-1"></div>
    
                                        <div class="row">
                                            <div class="input-field col m5 s12 xl4">
                                                @role('superadministrator|manager|head-manager')
                                                    <select name="user_from" id="user_from">
                                                        <option value="" selected>Не выбран</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <label>Заявка от имени</label>
                                                @endpermission
                                            </div>

                                            <div class="col m7 s12 xl4 offset-xl4">
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