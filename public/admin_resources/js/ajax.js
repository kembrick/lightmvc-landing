function del(id, table, name) {
    $("#delrecname").html(name);
    $("#dialog-confirm").dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
            "Да": function() {
                $(this).dialog("close");
                $.ajax({
                    type: "GET",
                    url: "/admindr/ajax/main.php",
                    data: "do=del" + "&id=" + id + "&table=" + table,
                    success: function() {
                        $("#rec" + id).hide();
                    }
                });
            },
            "Отмена": function() {
                $(this).dialog("close");
            }
        }
    });
}

function delPic(id, table, field) {
    $("#dialog-confirm").attr('title', 'Удаление изображения');
    $("#dialog-confirm").dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
            "Да": function() {
                $(this).dialog("close");
                $.ajax({
                    type: "GET",
                    url: "/admindr/ajax/main.php",
                    data: "do=delPic" + "&id=" + id + "&table=" + table + "&field=" + field,
                    success: function() {
                        $("#pict-" + field).hide();
                    }
                });
            },
            "Отмена": function() {
                $(this).dialog("close");
            }
        }
    });
}

function addMoreFiles(name) {
    $( '<div class="row mb-2"><div class="col"><input name="new---' + name + '[]" type="file"></div></div>' ).insertAfter( "#addmore" );
}

