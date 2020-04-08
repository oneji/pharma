$(document).ready(function() {
    $('.tooltipped').tooltip();
    $('.select2').select2();

    $('#addClientForm').validate({
        rules: {
            name: {
                required: true
            },
            username: {
                required: true
            },
            password: {
                required: true,
                minlength: 6
            },
            role: {
                required: true,
            },
        },
        //For custom messages
        messages: {
            name: {
                required: 'Обязательное поле.'
            },
            username: {
                required: 'Обязательное поле.'
            },
            password: {
                required: 'Обязательное поле.',
                minlength: 'Введите минимум 6 символов.'
            },
            role: {
                required: 'Обязательное поле.'
            },
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });

    $("#clients-list").DataTable({
        language: {
            search: "",
            searchPlaceholder: "Поиск",
            lengthMenu: "Показать _MENU_ записей на странице",
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
        }
    });

    $('.add-new-client-btn').click(function(e) {
        e.preventDefault();

        let modal = $('#addClientModal');
        let form = $('#addClientForm');

        let clientName = $(this).parent().parent().data('client-name');
        let clientPhone = $(this).parent().parent().data('client-phone');
        let clientCompany = Number($(this).parent().parent().data('company-id'));
        let randomPassword = Math.random().toString(36).slice(-8);

        form.find('input[name="name"]').val(clientName);
        form.find('input[name="phone"]').val(clientPhone);
        form.find('input[name="password"]').val(randomPassword);
        
        modal.modal('open');
    });
}); 