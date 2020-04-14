$(document).ready(function() {

    $('.select2').select2();

    $(".invoice-item-repeater").repeater({
        show: function () {
            $('.datepicker').datepicker({
                autoClose: !0,
                format: "dd/mm/yyyy",
                container: "body",
                onDraw: function () {
                    $(".datepicker-container").find(".datepicker-select").addClass("browser-default");
                    $(".datepicker-container .select-dropdown.dropdown-trigger").remove();
                }
            })

            $(this).slideDown();
        },
        hide: function (e) {
            $(this).slideUp(e)
        }
    })

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