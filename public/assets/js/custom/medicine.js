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
            searchPlaceholder: "Поиск",
            lengthMenu: "Показать _MENU_ записей на странице",
            zeroRecords: "Ничего не найдено",
            info: "Страница _PAGE_ из _PAGES_",
            infoEmpty: "Наименований не найдено",
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

    var form = $('#editMedicineForm');
    var modal = $('#editMedicineModal');
    var medicineId = '';
    var medicineName = '';

    $('.edit-medicine-btn').click(function(e) {
        e.preventDefault();        
        // Get the medicine id
        let el = $(this);
        medicineId = el.data('id');
        // Put the data into the form
        medicineName = el.parent().parent().parent().find('.medicine-name').text();
        form.find('input[name="name"]').val(medicineName);
        // Open modal
        modal.modal('open');
    });

    form.submit(function(e) {
        e.preventDefault();

        let medicineName = form.find('input[name="name"]').val();

        $.ajax({
            url: `/medicine/${medicineId}`,
            type: 'PUT',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                name: medicineName
            },
            success: function (data) {
                $(`.medicine-table tr[data-id="${medicineId}"]`).find('.medicine-name').text(medicineName);
                modal.modal('close');
            }
        });
    });
}); 