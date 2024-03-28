$(function() {

    $('.form-select').select2({
        theme: 'bootstrap-5'
    });

    let default_options = {
        "order": [],
        "pageLength": 25,
        "columnDefs": [
            {
                "orderable": false,
                "targets": -1,
            }
        ],
        "oLanguage": {
            "sLengthMenu": "Отображать по _MENU_ записей",
            "sSearch": "Поиск:",
            "sZeroRecords": "Ничего не найдено",
            "sInfo": "Показано с _START_ по _END_ из _TOTAL_ записей",
            "sInfoEmpty": "Показано с 0 по 0 из 0 записей",
            "sInfoFiltered": "(отфильтровано из _MAX_ записей)",
            "sEmptyTable": "Нет данных для отображения",
        },
    };
    $('#datable').DataTable(default_options);

    /** EDIT MODE */
    $('.editImage').on('click', function () {
        $('#' + $(this).data('id')).removeClass('d-none');
        $(this).addClass('d-none');
    });

    $('.addMoreFiles').on('click', function () {
        $( '<input class="form-control mb-3" name="' + $(this).data('id') + '[]" type="file" accept=".png, .jpg, .jpeg, .webp">').insertAfter(".addMoreFiles");
    });

});

const translit = str => {
    const keys = {
        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd',
        'е': 'e', 'ё': 'e', 'ж': 'zh', 'з': 'z', 'и': 'i',
        'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
        'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u',
        'ф': 'f', 'х': 'kh', 'ц': 'ts', 'ч': 'ch','ш': 'sh',
        'щ': 'sch', 'ы': 'y', 'э': 'e', 'ю': 'u', 'я': 'ya',
        'ь': '', 'ъ': '', 'й': 'i',
        'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D',
        'Е': 'E', 'Ё': 'E', 'Ж': 'ZH', 'З': 'Z', 'И': 'I',
        'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O',
        'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U',
        'Ф': 'F', 'Х': 'KH', 'Ц': 'TS', 'Ч': 'Ch','Ш': 'SH',
        'Щ': 'SCH', 'Ы': 'Y', 'Э': 'E', 'Ю': 'U', 'Я': 'YA',
        'Ь': '', 'Ъ': '', 'Й': 'I',
        ' ': '-', '"': '', "'": '', '&': '-', '!': '', '?': '',
    }
    return str.split("").map(char => typeof keys[char] === "undefined" ? char : keys[char]).join("");
}

$(".doTranslit").on("keyup", function() {
    let target = $(this).data('target');
    let text = $(this).val();
    $('input[name="' + target + '"]').val(translit(text));
});

/** Ajax */
let modalConfirm = function(callback) {
    let id, table, mode;
    $(".btn-confirm").on("click", function() {
        id = $(this).data('id');
        table = $(this).data('table');
        mode = $(this).data('mode');
        let title = $(this).data('title');
        $("#confirmModal .modal-body").text(title);
        $("#confirmModal").modal('show');
    });
    $("#modal-btn-yes").on("click", function() {
        callback(true, id, table, mode);
        $("#confirmModal").modal('hide');
    });
    $("#modal-btn-no").on("click", function() {
        callback(false, id, table, mode);
        $("#confirmModal").modal('hide');
    });
};

modalConfirm(function(confirm, id, table, mode) {
    if (confirm) {
        $.ajax({
            type: "GET",
            url: "/" + admDir + "/deleterow/" + table + "/" + id + "/" + mode,
            success: function() {
                $("#rec" + id).hide();
            }
        });
    } else {
        // Cancel
    }
});