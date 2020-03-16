$(document).ready(function() {
    $('.choose-pl-item').change(function() {
        var totalPrice = 0;
        var discountPrice = 0;
        var discountAmount = 0;
        

        $('.request-pl-table tbody .choose-pl-item:checked').each(function() {
            var itemPrice = Number($(this).data('price'));
            discountAmount = Number($(this).data('discount'))

            totalPrice += Number(itemPrice);
        });

        var totalPriceDiscount = Number((totalPrice * discountAmount) / 100);
        
        $('.request-total-price').html(totalPrice + 'с.');
        $('.request-discount-amount').html('- ' + totalPriceDiscount + 'c.');
        $('.request-total-discount-price').html(Number(totalPrice) - Number(totalPriceDiscount) + 'с.');
        
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

        console.log(formControlsIdsForValidationRules)

        $('#createRequestForm').validate({
            rules: formControlsIdsForValidationRules,
            messages: formControlsIdsForValidationMessages,
            errorPlacement: function (error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $('#createRequestForm').submit();
    });

    $('#createRequestForm').submit(function(e) {
        // e.preventDefault();

        var requestData = [];
        var reqNumber = $('#request-number').val().trim();

        $('.request-pl-table tbody .choose-pl-item:checked').each(function() {
            var itemId = $(this).data('item-id');
            var itemQuantity = $(this).parent().parent().parent().find('.request-pl-item-quantity').val();

            requestData.push({
                id: itemId,
                quantity: itemQuantity
            });
        });

        // $.ajax({
        //     url: '/requests',
        //     type: 'POST',
        //     data: {
        //         _token: $('meta[name="csrf-token"]').attr('content'),
        //         requestNumber: reqNumber,
        //         data: requestData
        //     },
        //     success: function(request){
        //         window.location.href = '/requests/view/' + request.id;
        //     }
        // });
    });

    function collectValidationFields(form) {
        var formControlsIds = [];

        $('.request-pl-table tbody .choose-pl-item:checked').each(function() {
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
            validationMessages[id] = { required: 'Обязательное поле.' }
        });

        return validationMessages;
    }
});