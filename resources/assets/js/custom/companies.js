$(document).ready(function() {
    $(".invoice-data-table").DataTable({
        columnDefs: [
            { targets: 0, orderable: 1 }, 
            { targets: 1, orderable: 1 },
            { targets: 2, orderable: !1 },
        ],
        order: [ 0, "asc" ],
        dom: '<"top display-flex  mb-2"<"action-filters"f><"actions action-btns display-flex align-items-center">><"clear">rt<"bottom"p>',
        language: {
            search: "",
            searchPlaceholder: "Поиск",
            lengthMenu: "Показать _MENU_ записей на странице",
            zeroRecords: "Компаний не найдено",
            info: "Страница _PAGE_ из _PAGES_",
            infoEmpty: "Компаний не найдено",
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
    $(".action-btns").append(t);

    var companyId = 0;
    let form = $('#editCompanyForm');
    let modal = $('#editCompanyModal');

    $('.edit-company-btn').click(function(e) {
        e.preventDefault();

        let el = $(this);
        companyId = el.data('id');
        let companyName = el.parent().parent().parent().find('td.company-name').text();
        form.find('input[name="name"]').val(companyName);

        modal.modal('open');
    });

    form.submit(function(e) {
        e.preventDefault();

        let companyName = form.find('input[name="name"]').val();

        $.ajax({
            url: `/companies/${companyId}`,
            type: 'PUT',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                name: companyName
            },
            success: function (data) {
                $(`.companies-table tr[data-id="${companyId}"]`).find('.company-name').text(companyName);
                modal.modal('close');
            }
        });
    });
}); 