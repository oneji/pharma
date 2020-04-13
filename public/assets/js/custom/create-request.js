$(document).ready(function() {
    $('.choose-pl-item').change(function() {
        $('.request-pl-item-quantity').removeAttr('required');
    });

    $('.show-chosen-btn').click(function() {
        $('.request-pl-table tbody .choose-pl-item:not(:checked)').each(function() {
            $(this).parent().parent().parent().slideToggle(100);
        });

        var btnText = $(this).text().toLowerCase();

        if(btnText === 'Показать выбранные'.toLowerCase()) {
            $(this).text('Показать все');
        } else if(btnText === 'Показать все'.toLowerCase()) {
            $(this).text('Показать выбранные');
        }
    });

    $('.create-request-btn').click(function(e) {
        e.preventDefault();

        var formControlsIds = collectValidationFields($("#createRequestForm"));
        var formControlsIdsForValidationRules = generateValidationRules(formControlsIds);
        var formControlsIdsForValidationMessages = generateValidationMessages(formControlsIds);

        $('#createRequestForm').validate({
            rules: formControlsIdsForValidationRules,
            messages: formControlsIdsForValidationMessages,
            errorElement: 'div',
            errorPlacement: function (error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                $('#loading').css('display', 'flex');

                var requestData = [];

                $('.request-pl-table tbody .choose-pl-item:checked').each(function() {
                    console.log('2', $(this))
                    var itemId = $(this).data('item-id');
                    var itemQuantity = $(this).parent().parent().parent().find('.request-pl-item-quantity').val();

                    $(this).parent().parent().parent().find('.request-pl-item-quantity').attr('required', 'required');

                    requestData.push({
                        id: itemId,
                        quantity: itemQuantity
                    });
                });


                $.ajax({
                    url: '/requests',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        data: requestData,
                        priority: $('#request_priority').val(),
                        payment_deadline: $('#payment_deadline').val()
                    },
                    success: function (data) {
                        $('#loading').hide();
                        if(data.ok) {
                            window.location.href = '/requests/view/' + data.request.id;
                        } else {
                            alert(data.message)
                        }
                    }
                });
            }
        });


        $('#createRequestForm').submit();
    });

    function collectValidationFields(form) {
        var formControlsIds = [];

        $('.request-pl-table tbody .choose-pl-item:checked').each(function() {
            console.log($(this))
            var controlId = $(this).data('item-id');
            if(controlId !== undefined && controlId !== '_token') {
                formControlsIds.push(controlId);
            }
        });

        return formControlsIds;
    }

    function generateValidationRules(controlIds) {
        var validationRules = {};

        controlIds.map(function(id) {
            validationRules[`quantity[${id}]`] = { required: true }
        });

        return validationRules;
    }

    function generateValidationMessages(controlIds) {
        var validationMessages = {};

        controlIds.map(function(id) {
            validationMessages[`quantity[${id}]`] = { required: 'Обязательное поле.' }
        });

        return validationMessages;
    }

    $('.request-pl-item-quantity').focus(function() {
        $('.request-pl-item-quantity').removeAttr('required');
        
        $(this).parent().parent().find('.choose-pl-item').attr('checked', 'checked');

        $('.request-pl-table tbody .choose-pl-item:checked').each(function() {
            $(this).parent().parent().parent().find('.request-pl-item-quantity').attr('required', 'required');
        }); 
    });

    $('.request-pl-item-quantity').change(function() {
        
        var totalPrice = 0;
        var discountPrice = 0;
        var discountAmount = 0;

        $('.request-pl-table tbody .choose-pl-item:checked').each(function() {
            var itemPrice = Number($(this).data('price'));
            let desiredBoxNumber = Number($(this).parent().parent().parent().find('.request-pl-item-quantity').val());
            let priceForOneInBox = Number($(this).parent().parent().parent().find('.price-for-one-in-box').text());
            discountAmount = Number($(this).data('discount'));

            $(this).parent().parent().parent().find('.request-pl-item-quantity').attr('required', 'required');

            totalPrice += Number(itemPrice * desiredBoxNumber * priceForOneInBox);
        });

        var totalPriceDiscount = Number((totalPrice * discountAmount) / 100);
        
        $('.request-total-price').html(totalPrice + 'с.');
        $('.request-discount-amount').html('- ' + totalPriceDiscount + 'c.');
        $('.request-total-discount-price').html(Number(totalPrice) - Number(totalPriceDiscount) + 'с.');
        
    });
});