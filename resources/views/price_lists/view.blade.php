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
    </style>

@endsection

@section('content')
    <div class="row">
        <div class="col s12">
            <div class="container">
                <section class="invoice-view-wrapper section">
                    <div class="row">
                        <!-- invoice view page -->
                        <div class="col xl9 m8 s12">
                            <div class="card">
                                <div class="card-content invoice-print-area">
                                    <!-- header section -->
                                    <div class="row invoice-date-number">
                                        <div class="col xl4 s12">
                                            <span class="invoice-number mr-1">Прайс лист от:</span>
                                            <span>{{ $priceList['created_at'] }}</span>
                                        </div>
                                    </div>
                                    <!-- logo and title -->
                                    <div class="row mt-3 invoice-logo-title">
                                        <div class="col m6 s12 display-flex invoice-logo mt-1 push-m6"></div>
                                        <div class="col m6 s12 pull-m6">
                                            <h4 class="indigo-text">Прайс лист</h4>
                                        </div>
                                    </div>
                                    <div class="divider mb-3 mt-3"></div>
                                    <!-- product details table-->
                                    <div class="invoice-product-details">
                                        <table class="striped responsive-table">
                                            <thead>
                                                <tr>
                                                    <th>Продукт</th>
                                                    <th>Производитель</th>
                                                    <th>Срок годности</th>
                                                    <th>Кол-во (шт.)</th>
                                                    <th class="right-align">Цена (с.)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($priceList['items'] as $item)
                                                    <tr>
                                                        <td>{{ $item->medicine_name }}</td>
                                                        <td>{{ $item->brand_name }}</td>
                                                        <td>{{ $item->exp_date }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td class="indigo-text right-align">${{ $item->price }}</td>
                                                    </tr>                                                    
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- invoice action  -->
                        <div class="col xl3 m4 s12">
                            <div class="card invoice-action-wrapper">
                                <div class="card-content">
                                    <div class="invoice-action-btn">
                                        <a href="#"
                                            class="btn indigo waves-effect waves-light display-flex align-items-center justify-content-center">
                                            <i class="material-icons mr-4">check</i>
                                            <span class="text-nowrap">Создать заявку</span>
                                        </a>
                                    </div>
                                    <div class="invoice-action-btn">
                                        <a href="#"
                                            class="btn-block btn btn-light-indigo waves-effect waves-light invoice-print">
                                            <span>Распечатать</span>
                                        </a>
                                    </div>
                                    <div class="invoice-action-btn">
                                        <a href="app-invoice-edit.html"
                                            class="btn-block btn btn-light-indigo waves-effect waves-light">
                                            <span>Изменить прайс лист</span>
                                        </a>
                                    </div>
                                    {{-- <div class="invoice-action-btn">
                                        <a href="#"
                                            class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
                                            <i class="material-icons mr-3">attach_money</i>
                                            <span class="text-nowrap">Add Payment</span>
                                        </a>
                                    </div> --}}
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

    <script src="{{ asset('assets/vendors/formatter/jquery.formatter.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/select2/select2.full.min.js') }}"></script>
    
    <script src="{{ asset('assets/vendors/form_repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/app-invoice.min.js') }}"></script>

    <script src="{{ asset('assets/js/scripts/form-masks.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(".select2").select2({
                dropdownAutoWidth: !0,
                width: "100%"
            });
        });
    </script>

@endsection