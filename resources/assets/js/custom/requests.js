$(document).ready(function() {
    $('.select2').select2();

    $("#requests-list").DataTable({
        language: {
            search: "",
            searchPlaceholder: "Поиск",
            lengthMenu: "Показать _MENU_ записей на странице",
            zeroRecords: "Ничего не найдено",
            info: "Страница _PAGE_ из _PAGES_",
            infoEmpty: "Производителей не найдено",
            infoFiltered: "(filtered from _MAX_ total records)",
            paginate: {
                first: "Первая",
                last: "Последняя",
                next: "След",
                previous: "Пред"
            }
        }
    });
}); 