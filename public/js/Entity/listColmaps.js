$(document).ready(function() {

    /* Ocultar tabela*/
    var dados = {
        objeto: 'Dbm',
        method: 'IsColmaps',
        dal: window.parent.getDal(),
        schema: window.parent.getSchema(),
        table: window.parent.getTable(),
        colmaps: window.parent.getColmaps()
    };

    var isColmap = AjaxPost(dados);

    if (isColmap === true) {

        $("#isColmap").css("display", "block");
        $("#amberColmap").css("display", "none");

        var listColmaps = AjaxPost({
            objeto: 'Dbm',
            method: 'ListColmaps',
            dal: window.parent.getDal(),
            schema: window.parent.getSchema(),
            table: window.parent.getTable(),
            colmaps: window.parent.getColmaps()
        });

        var html = '';
        $.each(listColmaps, function(key) {
            html += '<tr>';
            html += '<td><b>' + listColmaps[key].colmap + '</b></td>';
            html += '<td><input type="checkbox" value="' + listColmaps[key].colmap + '"></td>';
            html += '</tr>';
        });

        $('#listColmaps tbody').append(html);
        $("#adicionar").on("click", adicionarAtributos);
    } else {
        $("#isColmap").css("display", "none");
        $("#amberColmap").css("display", "block");
    }


});

function adicionarAtributos() {

    var selected = [];
    $('input:checked').each(function() {
        selected.push($(this).val());
    });

    if (selected.length > 0) {
        if (confirm('Realmente deseja adicionar a(s) colmap(s) selecionada(s) à Entitity ?')) {
            window.parent.adicionarAtributoFromDatabase(selected);
            window.parent.closeDialogFlatIframe();
        }
    } else {
        alert("Selecione pelo menos uma colmap!!!");
    }
}