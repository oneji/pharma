$(document).ready(function() {
    $('.select2').select2();

    $('#addUserForm').validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                required: true,
                minlength: 6,
                equalTo: "#password"
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
            email: {
                required: 'Обязательное поле.',
                email: 'Введите действительный email aдрес.'
            },
            password: {
                required: 'Обязательное поле.',
                minlength: 'Введите минимум 6 символов.'
            },
            password_confirmation: {
                required: 'Обязательное поле.',
                minlength: 'Введите минимум 6 символов.',
                equalTo: 'Пароли должны совпадать.'
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

    $("#users-list").DataTable({
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

    $('.tooltipped').tooltip();
}); 