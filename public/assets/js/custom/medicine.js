$(document).ready(function() {
    $(".invoice-data-table").DataTable({
        columnDefs: [
            { targets: 0, orderable: 1 }, 
            { targets: 1, orderable: 1 },
            { targets: 2, orderable: 1 },
            { targets: 3, orderable: !1 }
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