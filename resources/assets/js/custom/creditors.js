$(document).ready(function() {
    
    $('.info-btn').click(function(e) {
        e.preventDefault();

        let el = $(this);
        let modal = $('#infoModal');

        let user = {
            id: el.data('user-id'),
            name: el.data('user-name')
        };

        modal.find('#username').text(user.name);
        $('#loading').css('display', 'flex');

        // Get creditor info
        $.ajax({
            url: `/creditors/${user.id}`,
            type: 'GET',
            success: function (data) {
                console.log(data);
                
                if(data.ok) {
                    $('.creditor-info-table tbody').html('');
                    for (let i = 0; i < data.creditor.length; i++) {
                        const item = data.creditor[i];
                        
                        $('.creditor-info-table tbody').append(generateCreditorInfoTableHTML(item, i + 1));
                    }
                } 

                $('#loading').hide();
            }
        });
        
        modal.modal('open');
    });
});

function generateCreditorInfoTableHTML(info, idx) {
    return `
        <tr>
            <td>${idx}</td>
            <td><span class="badge green">${info.bill_number}</span></td>
            <td><span class="badge green">${info.amount}с.</span></td>
            <td>${info.date}</td>
        </tr>
    `
}