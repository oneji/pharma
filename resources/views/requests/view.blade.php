@extends('layouts.main')

@section('title')
    Заявка №{{ $req->id }}
@endsection

@section('head')
    @parent
@endsection

@section('content')
    <div class="row">
        <div class="col s12">
            <div class="container">
                <section class="section">
                    <div class="row">
                        <div class="col s12 {{ $req->request_payments->count() > 0 ? 'm9 xl9' : 'm12 xl12' }}">
                            <div class="card">
                                @role('superadministrator')
                                    <div class="card-tabs">
                                        <ul class="tabs tabs-fixed-width">
                                            <li class="tab"><a href="#requestData" class="active">Заявка №{{ $req->id }}</a></li>
                                            <li class="tab"><a href="#requestActions">Логи заявки</a></li>
                                        </ul>
                                    </div>
                                @endrole

                                <div class="card-content">
                                    <div id="requestData" style="display: block;" class="active">
                                        <div class="row">
                                            <div class="col s12 m12 l12">
                                                @foreach ($errors->all() as $error)
                                                    <div class="card-alert card orange m-0">
                                                        <div class="card-content white-text">
                                                            <ul class="m-0">
                                                                <li><i class="material-icons mr-2">warning</i> Ошибка! {{ $error }}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                        {{-- Request title, status and priority --}}
                                        <div class="row display-flex align-items-center mt-1">
                                            <div class="col s12 m6 l6 ml-0 display-flex align-items-center request-title-block">
                                                <h4 class="indigo-text">
                                                    Заявка №<span id="request-id">{{ $req->id }}</span>
                                                </h4>
                                                @if($req->status === 'under_revision')
                                                    <span class="badge blue">В рассмотрении</span>
                                                @endif

                                                @if ($req->status === 'sent')
                                                    <span class="badge green">Отправлена</span>
                                                @endif

                                                @if ($req->status === 'being_prepared')
                                                    <span class="badge orange">Готовится</span>
                                                @endif

                                                @if ($req->status === 'shipped')
                                                    <span class="badge orange">Отгружена</span>
                                                @endif
                                                
                                                @if ($req->status === 'paid')
                                                    <span class="badge green">Оплачена</span>
                                                @endif

                                                @if ($req->status === 'cancelled')
                                                    <span class="badge red">Отменена</span>
                                                @endif

                                                @if($req->priority === 1)
                                                    <span class="badge green request-priority-label">Высокий приоритет</span>
                                                @endif

                                                @if ($req->priority === 2)
                                                    <span class="badge orange request-priority-label">Средний приоритет</span>
                                                @endif

                                                @if ($req->priority === 3)
                                                    <span class="badge red request-priority-label">Низкий приоритет</span>
                                                @endif
                                            </div>

                                            <div class="col s12 m6 l6 ml-0">
                                                @permission('cancel-requests')
                                                    @if ($req->status !== 'cancelled' && $req->status !== 'paid')
                                                        <a href="#cancelRequestModal" class="btn btn-small waves-effect waves-light red mr-1 modal-trigger" style="float: right">Отмена заявки</a>
                                                    @endif
                                                @endpermission

                                                @permission('send-requests')
                                                    @if ($req->status === 'under_revision')
                                                        <form action="{{ route('requests.status', [ 'id' => $req->id, 'status' => 'sent' ]) }}" method="POST" class="mr-1" style="float: right">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-small waves-effect waves-light blue">Отправить на склад</button>
                                                        </form>
                                                    @endif
                                                @endpermission

                                                @permission('prepare-requests')
                                                    @if ($req->status === 'sent')
                                                        <form action="{{ route('requests.status', [ 'id' => $req->id, 'status' => 'being_prepared' ]) }}" method="POST" class="mr-1" style="float: right">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-small waves-effect waves-light green">Готовится</button>
                                                        </form>
                                                    @endif
                                                @endpermission
                                                
                                                @permission('ship-requests')
                                                    @if ($req->status === 'being_prepared')
                                                        <form action="{{ route('requests.status', [ 'id' => $req->id, 'status' => 'shipped' ]) }}" method="POST" class="mr-1" style="float: right">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-small waves-effect waves-light green">Отгрузить</button>
                                                        </form>
                                                    @endif
                                                @endpermission

                                                @permission('pay-requests')
                                                    @if ($req->status === 'shipped')
                                                        @if ((double)$reqPayment !== (double)0)
                                                            <a href="#requestPaymentModal" class="btn btn-small waves-effect waves-light orange modal-trigger mr-1" style="float: right">Выплатить</a>
                                                        @endif
                                                        @if ((double)$reqPayment === (double)0)
                                                            <a href="#" class="btn btn-small waves-effect waves-light green pay-request-btn mr-1" style="float: right">Выплачено</a>

                                                            <form action="{{ route('requests.status', [ 'id' => $req->id, 'status' => 'paid' ]) }}" method="POST" id="setAsPaidForm">
                                                                @csrf
                                                                @method('PUT')
                                                            </form>
                                                        @endif
                                                    @endif
                                                @endpermission
                                                
                                            </div>
                                        </div>

                                        <div class="divider"></div>

                                        <table class="striped responsive-table request-pl-table view-request-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Продукт</th>
                                                    <th>Производитель</th>
                                                    <th>Срок годности (до)</th>
                                                    <th>Кол-во (шт.)</th>
                                                    <th>Коммент</th>
                                                    @if (Auth::user()->hasPermission('update-requests') && $req->status !== 'shipped' && $req->status !== 'being_prepared' && $req->status !== 'paid')
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
                                                        <td class="display-flex align-items-center quantity-cell">
                                                            @if ((int)$item->changed_quantity === 0)
                                                                @if ($req->status === 'sent' || $req->status === 'under_revision' || $req->status === 'being_prepared' || $req->status === 'shipped' || $req->status === 'paid')
                                                                    {{ $item->quantity }}
                                                                @endif
                                                            @endif

                                                            @if ($item->changed_quantity !== 0)
                                                                @if ($req->status === 'under_revision')
                                                                    <span class="badge green m-0">{{ $item->changed_quantity }}</span>
                                                                    <i class="material-icons">{{ $item->quantity > $item->changed_quantity ? 'arrow_downward' : 'arrow_upward' }}</i>
                                                                @endif

                                                                @if ($req->status === 'being_prepared' || $req->status === 'sent')
                                                                    <span class="badge green m-0">{{ $item->changed_quantity }}</span>
                                                                    <i class="material-icons">{{ $item->quantity > $item->changed_quantity ? 'arrow_downward' : 'arrow_upward' }}</i>
                                                                @endif

                                                                @if ($req->status === 'shipped')
                                                                    {{ $item->quantity }}
                                                                @endif

                                                                @if ($req->status === 'paid')
                                                                    {{ $item->changed_quantity }}
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="comment-cell">{{ $item->comment }}</td>
                                                        {{-- Request item actions: edit and delete --}}
                                                        @if (
                                                            Auth::user()->hasPermission('update-requests') 
                                                            && $req->status !== 'shipped' 
                                                            && $req->status !== 'being_prepared' 
                                                            && $req->status !== 'paid')
                                                            <td>
                                                                @if ($item->removed === 0)
                                                                    <a href="#" data-id="{{ $item->id }}" data-quantity="{{ $item->quantity }}"  class="edit-item-btn"><span><i class="material-icons">edit</i></span></a>
                                                                    <a href="#" data-id="{{ $item->id }}" class="remove-item-btn"><span><i class="material-icons">delete_forever</i></span></a>
                                                                @endif
                                                            </td>
                                                        @endif
                                                    </tr>                                                    
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="divider mt-2 mb-2"></div>

                                        @role('superadministrator|manager|head-manager')
                                            @if ($req->status !== 'paid')
                                                <div class="row">
                                                    <div class="input-field col m5 s12 xl4">
                                                        <select name="priority" id="request_priority">
                                                            <option value="1" {{ $req->priority === 1 ? 'selected' : 0 }}>Высокий</option>
                                                            <option value="2" {{ $req->priority === 2 ? 'selected' : 0 }}>Средний</option>
                                                            <option value="3" {{ $req->priority === 3 ? 'selected' : 0 }}>Низкий</option>
                                                        </select>
                                                        <label>Приоритет заявки</label>
                                                    </div>

                                                    <div class="input-field col m5 s12 xl4">
                                                        <input value="{{ \Carbon\Carbon::parse($req->payment_deadline)->locale('ru')->isoFormat('DD/MM/YYYY') }}" name="payment_deadline" id="payment_deadline" type="text" class="datepicker" placeholder="Выберите дату" required>
                                                        <label>Дедлайн заявки</label>
                                                    </div>
                                                </div>
                                            @endif
                                        @endrole
                                   </div>

                                    {{-- Request logs --}}
                                    @role('superadministrator')
                                        <div id="requestActions" style="display: block;">
                                            <table class="striped responsive-table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Лог</th>
                                                        <th>Дата</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($reqActions as $idx => $action)
                                                        <tr>
                                                            <td>{{ $idx + 1 }}</td>
                                                            <td>
                                                                <span style="font-weight: 700">{{ $action->actor_name }}</span> {{ $action->text }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($action->created_at)->locale('ru')->isoFormat('MMMM D, YYYY') }}</td>
                                                        </tr>                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endrole
                                </div>
                            </div>
                        </div>

                        {{-- Request payments --}}
                        @if ($req->request_payments->count() > 0 && Auth::user()->roles->first()->name !== 'logist')
                            <div class="col s12 m3 l3">
                                <div class="card">
                                    <div class="card-content">
                                        <span class="card-title">
                                            История выплат
                                            <span style="float: right">Сумма: {{ $req->payment_amount }}с.</span>
                                        </span>
                                        <div class="links-feed">
                                            @foreach ($req->request_payments as $payment)
                                                <div class="list-feed-item display-flex">
                                                    <span>
                                                        {{ \Carbon\Carbon::parse($payment->created_at)->locale('ru')->isoFormat('D MMMM, YYYY') }}:
                                                        <span class="badge green">{{ $payment->amount }}с.</span>
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if ((double)$reqPayment === (double)0)
                                            <button type="button" class="btn btn-block btn-small green z-depth-1">Все выплаты сделаны</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
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

    <div id="cancelRequestModal" class="modal" style="width: 40%">
        <form action="{{ route('requests.cancel', [ 'id' => $req->id ]) }}" method="POST" id="cancelRequestForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <h5>Отменить заявку</h5>
                    
                <div class="container mt-5">
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea name="cancel_comment" class="materialize-textarea" placeholder="Введите комментарий" required></textarea>
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

    @if ((double)$reqPayment !== (double)0)
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
                                                                <span class="badge green">{{ $payment->amount }}с.</span>
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
    @endif
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('assets/js/scripts/advance-ui-modals.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/view-request.js') }}"></script>
@endsection