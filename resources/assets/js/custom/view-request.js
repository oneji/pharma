$(document).ready(function() {
    var itemId = null;
    var quantity = null;

    $('.edit-item-btn').click(function(e) {
        e.preventDefault();

        itemId = $(this).data('id');
        quantity = $(this).data('quantity');

        $('#editRequestItemModal .current-quantity').text('Текущее количество: ' + quantity);
        $('#editRequestItemModal input[name=changed_quantity]').val(quantity);

        // Show modal
        $('#editRequestItemModal').modal('open');
    });

    $('.remove-item-btn').click(function(e) {
        e.preventDefault();
        
        itemId = $(this).data('id');

        // Show modal
        $('#removeRequestItemModal').modal('open');
    });

    $('#editRequestItemForm').submit(function(e) {
        e.preventDefault();

        var form = $(this);
        var formData = form.serialize();

        $.ajax({
            url: '/requests/updateItem/' + itemId,
            type: 'PUT',
            data: formData,
            success: function(item){

                $('.request-pl-table').find(`tr[data-id=${itemId}]`).find('.quantity-cell').html(generateChangedQuantityMarkup(item));
                $('.request-pl-table').find(`tr[data-id=${itemId}]`).find('.comment-cell').html(item.comment);

                // Show modal
                $('#editRequestItemModal').modal('close');
            }
        });
    });

    $('#removeRequestItemForm').submit(function(e) {
        e.preventDefault();

        var form = $(this);
        var formData = form.serialize();

        $.ajax({
            url: '/requests/removeItem/' + itemId,
            type: 'DELETE',
            data: formData,
            success: function(item){

                $('.request-pl-table').find(`tr[data-id=${itemId}]`).addClass('removed-item');
                $('.request-pl-table').find(`tr[data-id=${itemId}]`).find('.comment-cell').html(item.comment);

                // Show modal
                $('#removeRequestItemModal').modal('close');
            }
        });
    });

    $('.pay-request-btn').click(function(e) {
        e.preventDefault();

        swal({
            title: "Закрыть долг по заявке?",
            text: "Закрыть долг значит, что все выплаты были сделаны.",
            icon: "warning",
            buttons: {
                cancel: 'Отмена',
                delete: 'Выплачено'
            },
        }).then(function(e) {
            if(e) {
                $('#setAsPaidForm').submit();
            } else {

            }
        });
    });

    function generateChangedQuantityMarkup(item) {
        var icon = item.quantity > item.changed_quantity ? 'arrow_downward' : 'arrow_upward';
        return `
            <span class="badge green m-0">${item.changed_quantity}</span>
            <i class="material-icons">${icon}</i>
        `;
    }
});