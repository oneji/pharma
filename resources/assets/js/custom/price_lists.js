$(document).ready(function() {
    let medicineSource = JSON.parse($('#medicine-source').text());
    let brandsSource = JSON.parse($('#brands-source').text());

    $('.medicine-select2').select2({ data: medicineSource });
    $('.brands-select2').select2({ data: brandsSource });

    // $(".invoice-item-repeater").repeater({
    //     show: function () {
    //         $('.datepicker').datepicker({
    //             autoClose: !0,
    //             format: "dd/mm/yyyy",
    //             container: "body",
    //             onDraw: function () {
    //                 $(".datepicker-container").find(".datepicker-select").addClass("browser-default");
    //                 $(".datepicker-container .select-dropdown.dropdown-trigger").remove();
    //             }
    //         })

    //         $(this).slideDown();
    //     },
    //     hide: function (e) {
    //         $(this).slideUp(e)
    //     }
    // })

    $('.add-item-btn').click(function() {
        console.log('...');

        let itemRow = `
            <tr>
                <td class="pl-1">
                    <input hidden type="text" class="center-align item-id browser-default" name="id">
                    <select class="medicine-select2 browser-default" name="medicine[]" required></select>
                </td>
                <td>
                    <select class="brands-select2 browser-default" name="brands[]" required></select>
                </td>
                <td>
                    <input name="exp_date[]" type="text" class="center-align datepicker browser-default" required>
                </td>
                <td>
                    <input class="center-align browser-default" name="price[]" type="number" required>
                </td>
                <td>
                    <input class="center-align browser-default" name="quantity[]" type="number" required>
                </td>
                <td><i data-repeater-delete class="delete-row-btn material-icons">delete</i></td>
            </tr>
        `

        $('#price-list-body').append(itemRow);

        $('.medicine-select2').select2();
        $('.brands-select2').select2();

        $('.datepicker').datepicker({
            autoClose: !0,
            format: "dd/mm/yyyy",
            container: "body",
            onDraw: function () {
                $(".datepicker-container").find(".datepicker-select").addClass("browser-default");
                $(".datepicker-container .select-dropdown.dropdown-trigger").remove();
            }
        })

    });

    $('.create-price-list-submit-btn').click(function(e) {
        e.preventDefault();

        formControlsNames = collectValidationFields($("#createPriceListForm"));
        formControlsNamesForValidationRules = generateValidationRules(formControlsNames);
        formControlsNamesForValidationMessages = generateValidationMessages(formControlsNames);
        
        $('#createPriceListForm').validate({
            rules: formControlsNamesForValidationRules,
            messages: formControlsNamesForValidationMessages,
            errorElement: 'div',
            errorPlacement: function (error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $("#createPriceListForm").submit();
    });

    function collectValidationFields(form) {
        var formControlsNames = [];

        form.each(function() {
            $(this).find(':input').each(function() {
                var controlName = $(this).attr('name');
                var inputHasId = $(this).hasClass('item-id');
                if(controlName !== undefined && controlName !== '_token' && !inputHasId) {
                    formControlsNames.push($(this).attr('name'));
                }
            });
        });

        return formControlsNames;
    }

    function generateValidationRules(controlNames) {
        var validationRules = {};

        controlNames.map(function(name) {
            validationRules[name] = { required: true }
        });

        console.log(validationRules);

        return validationRules;
    }

    function generateValidationMessages(controlNames) {
        var validationMessages = {};

        controlNames.map(function(name) {
            validationMessages[name] = { required: 'Обязательное поле.' }
        }); 

        console.log(validationMessages);

        return validationMessages;
    }
});