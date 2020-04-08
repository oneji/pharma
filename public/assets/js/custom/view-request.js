$(document).ready(function() {
    var itemId = null;
    var quantity = null;
    var requestId = $('#request-id').text();

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
        var formData = form.serializeArray();

        var data = {};
        formData.map(d => {
            data[d.name] = d.value
        });
        data['request_id'] = requestId;

        $.ajax({
            url: '/requests/updateItem/' + itemId,
            type: 'PUT',
            data: data,
            success: function(item){

                console.log(item);

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
        var formData = form.serializeArray();

        var data = {};
        formData.map(d => {
            data[d.name] = d.value
        });
        data['request_id'] = requestId;

        $.ajax({
            url: '/requests/removeItem/' + itemId,
            type: 'DELETE',
            data: data,
            success: function(item){
                
                console.log(item);

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

    $('#request_priority').change(function() {
        let priorityVal = $(this).val();

        $.ajax({
            url: '/requests/setPriority/' + requestId,
            type: 'POST',
            data: {
                priority: priorityVal,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result){
                
                if(result.ok) {
                    $('.request-priority-label').remove();

                    if(Number(priorityVal) === 1) {
                        $('.request-title-block').append(`
                            <span class="badge green request-priority-label">Высокий приоритет</span>
                        `);
                    } else if(Number(priorityVal) === 2) {
                        $('.request-title-block').append(`
                            <span class="badge orange request-priority-label">Средний приоритет</span>
                        `);
                    } else if(Number(priorityVal) === 3) {
                        $('.request-title-block').append(`
                            <span class="badge red request-priority-label">Низкий приоритет</span>
                        `);
                    }
                }

            }
        });
    });
});