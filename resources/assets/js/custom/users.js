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

    $("#users-list").DataTable();

    $('.tooltipped').tooltip();
}); 