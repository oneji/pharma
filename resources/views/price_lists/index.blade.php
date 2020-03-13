@extends('layouts.main')

@section('title')
    Прайс листы
@endsection

@section('head')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/app-invoice.min.css') }}">
@endsection

@section('content')
    <div class="col s12">
        <div class="container">

            <section class="invoice-list-wrapper section">
                <!-- create brand button-->
                <div class="invoice-create-btn">
                    <a href="{{ route('price_lists.create') }}"
                        class="btn waves-effect waves-light border-round z-depth-1 modal-trigger">
                        <i class="material-icons">add</i>
                        <span class="hide-on-small-only">Добавить прайс лист</span>
                    </a>
                </div>
                <div class="responsive-table">
                    <table class="table invoice-data-table white border-radius-4 pt-1">
                        <thead>
                            <tr>
                                <th class="center-align">#</th>
                                <th>ID</th>
                                <th>Дата</th>
                                <th>Кол-во продукции</th>
                                <th>Действия</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($priceLists as $idx => $list)
                                <tr>
                                    <td class="center-align">{{ $idx + 1 }}</td>
                                    <td><span class="chip lighten-5 green green-text">{{ $list->id }}</span></td>
                                    <td>{{ $list->created_at }}</td>
                                    <td>{{ $list->price_list_items->count() }}шт.</td>
                                    <td>
                                        <div class="invoice-action">
                                            <a href="{{ route('price_lists.view', [ 'id' => $list->id ]) }}" class="invoice-action-edit">
                                                <i class="material-icons">remove_red_eye</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/data-tables/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/data-tables/js/datatables.checkboxes.min.js') }}"></script>

    <script src="{{ asset('assets/js/scripts/advance-ui-modals.min.js') }}"></script>


    <script>
        $(document).ready(function() {
            $(".invoice-data-table").DataTable({
                columnDefs: [
                    { targets: 0, orderable: 1 }, 
                    { targets: 1, orderable: 1 },
                    { targets: 3, orderable: !1 },
                    { targets: 4, orderable: !1 }
                ],
                order: [ 0, "asc" ],
                dom: '<"top display-flex  mb-2"<"action-filters"f><"actions action-btns display-flex align-items-center">><"clear">rt<"bottom"p>',
                language: {
                    search: "",
                    searchPlaceholder: "Поиск по производителю",
                    lengthMenu: "Display _MENU_ записей на странице",
                    zeroRecords: "Ничего не найдено",
                    info: "Страница _PAGE_ из _PAGES_",
                    infoEmpty: "Производителей не найдено",
                    infoFiltered: "(filtered from _MAX_ total records)",
                    paginate: {
                        first: "Первая",
                        last: "Последняя",
                        next: "След",
                        previous: "Пред"
                    }
                },
                select: {
                    style: "multi",
                    selector: "td:first-child>",
                    items: "row"
                },
                responsive: {
                    details: {
                        type: "column",
                        target: 0
                    }
                },
            });

            var t = $(".invoice-create-btn");
            $(".action-btns").append(t)
        }); 
    </script>
@endsection
