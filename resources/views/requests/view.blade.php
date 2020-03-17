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
                                    <div class="row">
                                        <div class="col xl4 m12 display-flex align-items-center">
                                            <h6 class="mr-4">Заявка №{{ $req->request_number }}</h6>
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="col m6 s12 display-flex mt-1 push-m6"></div>
                                        <div class="col m6 s12 pull-m6">
                                            <h4 class="indigo-text">Заявка</h4>
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
                                                <th>Действия</th>
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
                                                    <td>
                                                        <a href="#" data-id="{{ $item->id }}" data-quantity="{{ $item->quantity }}"  class="edit-item-btn"><span><i class="material-icons">edit</i></span></a>
                                                        <a href="#" data-id="{{ $item->id }}" class="remove-item-btn"><span><i class="material-icons">delete_forever</i></span></a>
                                                    </td>
                                                </tr>                                                    
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="divider mt-3 mb-1"></div>

                                    <div class="row">
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
                                                    <form action="{{ route('requests.writeOut', [ 'id' => $req->id ]) }}" method="POST" class="mr-1">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn waves-effect waves-light orange">Выплатить</button>
                                                    </form>
                                                @endif
                                            @endpermission
                                        </div>
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
                            <textarea id="comment" name="comment" class="materialize-textarea" placeholder="Введите комментарий" required></textarea>
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
                            <textarea id="comment" name="comment" class="materialize-textarea" placeholder="Введите комментарий" required></textarea>
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
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('assets/js/custom/create-request.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/advance-ui-modals.min.js') }}"></script>
    
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
            })

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