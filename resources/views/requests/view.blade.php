@extends('layouts.main')

@section('title')
    Заявка №{{ $req->request_number }}
@endsection

@section('head')
    @parent

    <style>
        .request-pl-table td {
            padding: 10px 5px;
        }
        
        .removed-item {
            text-decoration: line-through;
            color: #ccc;
        }

        .list-feed-item {
            position: relative;
            padding-bottom: 1.25rem;
            padding-left: 1.75rem;
        }

        .list-feed-item:before {
            content: '';
            position: absolute;
            left: 0;
            top: .31252rem;
            background-color: #fff;
            display: inline-block;
            border: 2px solid #607d8b;
            z-index: 3;
            width: .5rem;
            height: .5rem;
            border-radius: 50%;
        }

        .list-feed-item:first-child:after {
            top: .5rem;
        }

        .list-feed-item:after {
            content: '';
            position: absolute;
            top: .31252rem;
            left: .1875rem;
            bottom: -.43752rem;
            width: 0;
            border-left: 1px solid #607d8b;
            border-right: 1px solid #607d8b;
            z-index: 2;
        }

        .list-feed-item:last-child {
            padding-bottom: 0;
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
                                <div class="card-content">
                                    <div class="row display-flex align-items-center mt-1">
                                        <div class="col s12 m8 l8 ml-0">
                                            <h4 class="indigo-text">Заявка №{{ $req->request_number }}</h4>
                                        </div>

                                        <div class="col s12 m4 l4 ml-0">
                                            @permission('send-requests')
                                                @if ($req->sent === 0)
                                                    <form action="{{ route('requests.send', [ 'id' => $req->id ]) }}" method="POST" class="mr-1" style="float: right">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn waves-effect waves-light blue">Отправить на склад</button>
                                                    </form>
                                                @endif
                                            @endpermission

                                            @permission('write-out-requests')
                                                @if ($req->written_out === 0 && $req->sent !== 0)
                                                    <form action="{{ route('requests.writeOut', [ 'id' => $req->id ]) }}" method="POST" class="mr-1" style="float: right">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn waves-effect waves-light green">Выписать</button>
                                                    </form>
                                                @endif
                                            @endpermission

                                            @permission('pay-requests')
                                                @if ($req->written_out === 1)
                                                    <a href="#requestPaymentModal" class="btn waves-effect waves-light orange modal-trigger" style="float: right">Выплатить</a>
                                                    <a href="#" class="btn waves-effect waves-light green pay-request-btn mr-1" style="float: right">Выплачено</a>
                                                @endif
                                            @endpermission
                                        </div>
                                    </div>

                                    <div class="divider"></div>
                                    <table class="striped responsive-table request-pl-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Продукт</th>
                                                <th>Производитель</th>
                                                <th>Срок годности (до)</th>
                                                {{-- <th class="right-center">Цена (с.)</th> --}}
                                                <th>Кол-во (шт.)</th>
                                                <th>Коммент</th>
                                                @if ($req->sent !== 1)
                                                    <th>Действия</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($req->request_items as $idx => $item)
                                                <tr data-id="{{ $item->id }}" class="{{ $item->removed === 1 ? 'removed-item' : 0 }}">
                                                    <td>{{ $idx + 1 }}</td>
                                                    <td>{{ $item->medicine_name }}</td>
                                                    <td>{{ $item->brand_name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->exp_date)->locale('ru')->isoFormat('MMMM D, YYYY') }}</td>
                                                    {{-- <td class="indigo-text center-align price">
                                                        <span class="badge green">{{ $item->price }}</span>
                                                    </td> --}}
                                                    <td class="display-flex align-items-center quantity-cell">
                                                        @if ($req->sent === 0 && $item->changed_quantity !== 0)
                                                            <span class="badge green m-0">{{ $item->changed_quantity }}</span>
                                                            <i class="material-icons">{{ $item->quantity > $item->changed_quantity ? 'arrow_downward' : 'arrow_upward' }}</i>
                                                        @endif

                                                        @if ($req->sent === 1 && $item->changed_quantity !== 0)
                                                            {{ $item->changed_quantity }}
                                                        @endif

                                                        @if ($req->sent === 1 && $item->changed_quantity === 0)
                                                            {{ $item->quantity }}
                                                        @endif

                                                        @if ($req->sent === 0 && $item->changed_quantity === 0)
                                                            {{ $item->quantity }}
                                                        @endif

                                                    </td>
                                                    <td class="comment-cell">{{ $item->comment }}</td>
                                                    @if ($req->sent !== 1)
                                                        <td>
                                                            <a href="#" data-id="{{ $item->id }}" data-quantity="{{ $item->quantity }}"  class="edit-item-btn"><span><i class="material-icons">edit</i></span></a>
                                                            <a href="#" data-id="{{ $item->id }}" class="remove-item-btn"><span><i class="material-icons">delete_forever</i></span></a>
                                                        </td>
                                                    @endif
                                                </tr>                                                    
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- <div class="divider mt-3 mb-1"></div> --}}

                                    {{-- <div class="row">
                                        <div class="col s12 m12 l12 display-flex align-items-center justify-content-flex-end">
                                            @permission('send-requests')
                                                @if ($req->sent === 0)
                                                    <form action="{{ route('requests.send', [ 'id' => $req->id ]) }}" method="POST" class="mr-1">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn waves-effect waves-light blue">Отправить на склад</button>
                                                    </form>
                                                @endif
                                            @endpermission
                                            
                                            @permission('write-out-requests')
                                                @if ($req->written_out === 0 && $req->sent !== 0)
                                                    <form action="{{ route('requests.writeOut', [ 'id' => $req->id ]) }}" method="POST" class="mr-1">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn waves-effect waves-light green">Выписать</button>
                                                    </form>
                                                @endif
                                            @endpermission

                                            @permission('pay-requests')
                                                @if ($req->written_out === 1)
                                                    <a href="#requestPaymentModal" class="btn waves-effect waves-light orange modal-trigger">Выплатить</a>
                                                    <a href="#" class="btn waves-effect waves-light green pay-request-btn ml-1">Выплачено</a>
                                                @endif
                                            @endpermission
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div id="editRequestItemModal" class="modal" style="width: 40%">
        <form action="#" method="POST" id="editRequestItemForm">
            @csrf
            <div class="modal-content">
                <h5>Изменить</h5>
                    
                <div class="container">
                    <div class="row">
                        <div class="input-field col s12">
                            <div class="card-alert card green">
                                <div class="card-content white-text">
                                    <p ><i class="material-icons mr-2">check</i><span class="current-quantity"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <input name="changed_quantity" type="number" min="0" class="validate" placeholder="Введите количество" required>
                            <label for="changed_quantity">Количество</label>
                        </div>

                        <div class="input-field col s12">
                            <textarea name="comment" class="materialize-textarea" placeholder="Введите комментарий" required></textarea>
                            <label for="comment">Комментарий</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="waves-effect waves-light btn green">
                    <span>Сохранить</span>
                </button>
            </div>
        </form>
    </div>

    <div id="removeRequestItemModal" class="modal" style="width: 40%">
        <form action="#" method="POST" id="removeRequestItemForm">
            @csrf
            <div class="modal-content">
                <h5>Удалить из списка</h5>
                    
                <div class="container mt-5">
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea name="comment" class="materialize-textarea" placeholder="Введите комментарий" required></textarea>
                            <label for="comment">Комментарий</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="waves-effect waves-light btn green">
                    <span>Сохранить</span>
                </button>
            </div>
        </form>
    </div>

    <div id="requestPaymentModal" class="modal" style="width: 40%">
        <form action="{{ route('requests.pay', [ 'id' => $req->id ]) }}" method="POST" id="requestPaymentForm">
            @csrf
            <div class="modal-content">
                <h5>Выплата</h5>
                    
                <div class="container">
                    <div class="row">
                        <div class="col s6 p-0">
                            <div class="row">
                                <div class="col s12">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="links-feed">
                                                @foreach ($req->request_payments as $payment)
                                                    <div class="list-feed-item display-flex flex-nowrap">
                                                        <span class="mr-3">
                                                            {{ \Carbon\Carbon::parse($payment->created_at)->locale('ru')->isoFormat('D MMMM, YYYY') }}:
                                                            <span class="badge green">{{ $payment->amount }}с</span>
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="row">
                                <div class="input-field col s12">
                                    <div class="card-alert card green m-0">
                                        <div class="card-content white-text">
                                            <ul class="m-0">
                                                <li><i class="material-icons mr-2">check</i>Общая сумма: {{ $req->payment_amount }}с.</li>
                                                <li><i class="material-icons mr-2">check</i>Сумма долга: {{ $reqPayment }}с.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-field col s12 mt-8">
                                    <input name="amount" type="text" min="0" class="validate" placeholder="Введите сумму" required>
                                    <label for="amount">Сумма выплаты</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="waves-effect waves-light btn green">
                    <span>Сохранить</span>
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('assets/js/custom/create-request.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/advance-ui-modals.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert/sweetalert.min.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            var itemId = null;
            var quantity = null;

            $('.edit-item-btn').click(function(e) {
                e.preventDefault();

                itemId = $(this).data('id');
                quantity = $(this).data('quantity');

                $('#editRequestItemModal .current-quantity').text('Текущее количество: ' + quantity);

                // Show modal
                $('#editRequestItemModal').modal('open');
            });

            $('.remove-item-btn').click(function(e) {
                e.preventDefault();
                
                itemId = $(this).data('id');

                // Show modal
                $('#removeRequestItemModal').modal('open');
            });

            $('#editRequestItemForm').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var formData = form.serialize();

                $.ajax({
                    url: '/requests/updateItem/' + itemId,
                    type: 'PUT',
                    data: formData,
                    success: function(item){

                        $('.request-pl-table').find(`tr[data-id=${itemId}]`).find('.quantity-cell').html(generateChangedQuantityMarkup(item));
                        $('.request-pl-table').find(`tr[data-id=${itemId}]`).find('.comment-cell').html(item.comment);

                        // Show modal
                        $('#editRequestItemModal').modal('close');
                    }
                });
            });

            $('#removeRequestItemForm').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var formData = form.serialize();

                $.ajax({
                    url: '/requests/removeItem/' + itemId,
                    type: 'DELETE',
                    data: formData,
                    success: function(item){

                        $('.request-pl-table').find(`tr[data-id=${itemId}]`).addClass('removed-item');
                        $('.request-pl-table').find(`tr[data-id=${itemId}]`).find('.comment-cell').html(item.comment);

                        // Show modal
                        $('#removeRequestItemModal').modal('close');
                    }
                });
            });

            $('.pay-request-btn').click(function(e) {
                e.preventDefault();

                swal({
                    title: "Закрыть долг по заявке?",
                    text: "Закрыть долг значит, что все выплаты были сделаны.",
                    icon: "warning",
                    buttons: {
                        cancel: 'Отмена',
                        delete: 'Выплачено'
                    },
                }).then(function(e) {
                    if(e) {
                        // ...
                    } else {

                    }
                });
            });

            function generateChangedQuantityMarkup(item) {
                var icon = item.quantity > item.changed_quantity ? 'arrow_downward' : 'arrow_upward';
                return `
                    <span class="badge green m-0">${item.changed_quantity}</span>
                    <i class="material-icons">${icon}</i>
                `;
            }
        });
    </script>
@endsection