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

    $('.create-request-btn').click(function(e) {
        e.preventDefault();

        var requestData = [];
        var reqNumber = $('#request-number').val();

        $('.request-pl-table tbody .choose-pl-item:checked').each(function() {
            var itemId = $(this).data('item-id');
            var itemQuantity = $(this).parent().parent().parent().find('.request-pl-item-quantity').val();

            requestData.push({
                id: itemId,
                quantity: itemQuantity
            });
        });

        console.log(requestData);

        $.ajax({
            url: '/requests',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                requestNumber: reqNumber,
                data: requestData
            },
            success: function(request){
                window.location.href = '/requests/view/' + request.id;
            }
        });
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
});