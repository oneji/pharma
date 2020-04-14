$(document).ready(function() {

    $('.add-btn').click(function(e) {
        e.preventDefault();

        let el = $(this);
        let modal = $('#addCreditorModal');
        let type = el.data('type');
        
        // if(type !== 'new') {
        //     let form = $('#addCreditorForm');
        //     let user = el.data('user');

        //     form.find('select[name="user_id"] option').each(function() {
        //         if(Number($(this).val()) === Number(user)) {
        //             $(this).attr('selected', 'selected');
        //             console.log($(this).val(), user);
        //         }
        //     });
        // }

        modal.modal('open');
    });

});