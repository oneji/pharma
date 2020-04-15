$(document).ready(function() {
    function generateMedicineAndBrandsSelects() {
        $('.medicine-select2').select2({
            ajax: {
                url: "/medicine/getAll",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: 'Выберите товар',
            language: {
                searching: function() {
                    return 'Идет поиск...';
                }
            }
        });
        
        $('.brands-select2').select2({
            ajax: {
                url: "/brands/getAll",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data
                    };
                },
                cache: true,
            },
            placeholder: 'Выберите производителя',
            language: {
                searching: function() {
                    return 'Идет поиск...';
                }
            }
        });
    }

    generateMedicineAndBrandsSelects();

    let i = 1;
    $('.add-item-btn').click(function() {
        let itemRow = `
            <tr>
                <td class="pl-1">
                    <input hidden type="text" class="center-align item-id browser-default" name="items[${i}][id]">
                    <select name="items[${i}][medicine]" class="medicine-select2 browser-default" required data-error=".medicine-error-${i}"></select>
                    <small class="medicine-error-${i}"></small>
                </td>
                <td>
                    <select name="items[${i}][brand]" class="brands-select2 browser-default"  required data-error=".brands-error-${i}"></select>
                    <small class="brands-error-${i}"></small>
                </td>
                <td>
                    <input name="items[${i}][exp_date]" type="text" class="center-align datepicker browser-default" required data-error=".exp-date-error-${i}">
                    <small class="exp-date-error-${i}"></small>
                </td>
                <td>
                    <input name="items[${i}][price]" type="number" class="center-align browser-default" required data-error=".price-error-${i}">
                    <small class="price-error-${i}"></small>
                </td>
                <td>
                    <input name="items[${i}][quantity]" type="number" class="center-align browser-default" required data-error=".quantity-error-${i}">
                    <small class="quantity-error-${i}"></small>
                </td>
                <td><i class="delete-row-btn material-icons">delete</i></td>
            </tr>
        `
        i++;

        $('#price-list-body').append(itemRow);

        generateMedicineAndBrandsSelects();

        $('.datepicker').datepicker({
            autoClose: !0,
            format: "dd/mm/yyyy",
            container: "body",
            onDraw: function () {
                $(".datepicker-container").find(".datepicker-select").addClass("browser-default");
                $(".datepicker-container .select-dropdown.dropdown-trigger").remove();
            }
        });
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

    $(document).on('click', '.delete-row-btn', function(e) {
        $(this).parent().parent().remove();
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

        return validationRules;
    }

    function generateValidationMessages(controlNames) {
        var validationMessages = {};

        controlNames.map(function(name) {
            validationMessages[name] = { required: 'Обязательное поле.' }
        });

        return validationMessages;
    }
});