/* Globais */
var key_atributos;
var key_OneToMany;
var TOneToMany;
var key_ManyToMany;
var TManyToMany;
var colmap = [];

$(document).ready(function() {
    apenasNumeros('.so_numeros');
    $("#addAtributo,.deleteButton").click(function(event) {
        event.preventDefault();
    });

    $('#syncAtributos').on('click', syncAtributos);
    $('#fCadastrar').validate();

});

/* Exibi as paginas com as colmaps não adicionada */
function syncAtributos() {
    dialogFlatIframe('Sincronizar Colmaps', '<i class="icon-loading-2 fg-blue"></i>', 'index.php?Entity/listColmaps');
}


/* executar após carregamento da pagina */
window.onload = function() {
    setVariaveisGlobais();
    setColmapGlobal();
};


function setColmapGlobal() {
    $('.colmaps').each(function() {
        addColmap($(this).val());
    });
}

function getColmaps() {
    return colmap;
}

function getDal() {
    return $('#dal').val();
}

function getSchema() {
    return $('#schema').val();
}

function getTable() {
    return $('#table').val();
}

function removeColmap(coluna) {
    var index = colmap.indexOf(coluna);
    colmap.splice(index, 1);
}

function addColmap(coluna) {
    colmap.push(coluna);
}

function setVariaveisGlobais() {
    key_atributos = $(".tAtributos").length;
    key_OneToMany = $(".tOneToMany").length;
    key_ManyToMany = $(".tManyToMany").length;
    TOneToMany = key_OneToMany;
    TManyToMany = key_ManyToMany;
}

function deleteAtributo(id) {
    if (confirm('Confirme para excluir este atributo?')) {
        var coluna = $('#colmap_' + id).val();
        var idTable = '#div_atributo_' + id;
        $(idTable).fadeOut('slow', function() {
            $(idTable).remove();
        });
        removeColmap(coluna);
    }
}

function deleteOneToMany(id) {
    if (confirm('Confirme para excluir o relacionamento OneToMany?')) {
        TOneToMany--;
        var idTable = '#' + id;
        $(idTable).fadeOut('slow', function() {
            $(idTable).remove();
        });
        if (TOneToMany === 0) {
            var notice = '';
            notice += '<div class="notice bg-amber" id="noticeOneToMany">';
            notice += '<div class="fg-white">';
            notice += '<h2>Não existe relacionamentos do tipo OneToMany.</h2>';
            notice += '</div>';
            notice += '</div>';
            $('#listOneToMany').html(notice).show();
        }
    }
}

function deleteManyToMany(id) {
    if (confirm('Confirme para excluir o relacionamento ManyToMany?')) {
        TManyToMany--;
        var idTable = '#' + id;
        $(idTable).fadeOut('slow', function() {
            $(idTable).remove();
        });
        if (TManyToMany === 0) {
            var notice = '';
            notice += '<div class="notice bg-amber" id="noticeManyToMany">';
            notice += '<div class="fg-white">';
            notice += '<h2>Não existe relacionamentos do tipo ManyToMany.</h2>';
            notice += '</div>';
            notice += '</div>';
            notice += '<br />';
            $('#listManyToMany').html(notice).show();
        }
    }
}

function adicionarAtributoFromDatabase(atributos) {
    $.each(atributos, function(key, value) {
        
        addColmap(value);
        
        /* id do atributo */
        var idForm = '#div_atributo_' + key_atributos;
        /* obter html do form */
        var htmlImputAtributo = htmlFormAtributo(value);
        /* adicionar o html em um espaço temporario */
        $('#tmp_html').html(htmlImputAtributo).show();
        /* clonar o html */
        $(idForm).clone().appendTo("#listAtributos");
        /* eliminar o temp */
        $('#tmp_html').html('');
        /* Ir para div */
        $('html,body').animate({scrollTop: $(idForm).offset().top}, 'slow');
        /* add + 1 a key*/
        key_atributos++;
        
    });
}

function adicionarOneToMany() {
    if (confirm('Desejá adicionar um novo relacionamento OneToMany')) {
        TOneToMany++;
        /* id do atributo */
        var idForm = '#div_OneToMany_' + key_OneToMany;
        /* obter html do form */
        var htmlImput = htmlFormOneToMany();
        /* adicionar o html em um espaço temporario */
        $('#tmp_html').html(htmlImput).show();
        /* limpar notice se existir */
        if (TOneToMany === 1) {
            $("#noticeOneToMany").remove();
        }
        /* clonar o html */
        $(idForm).clone().appendTo("#listOneToMany");
        /* eliminar o temp */
        $('#tmp_html').html('');
        /* Ir para div */
        $('html,body').animate({scrollTop: $(idForm).offset().top}, 'slow');
        /* add + 1 a key*/
        key_OneToMany++;
    }
}
function adicionarManyToMany() {
    if (confirm('Desejá adicionar um novo relacionamento ManyToMany')) {
        TManyToMany++;
        /* id do atributo */
        var idForm = '#div_ManyToMany_' + key_ManyToMany;
        /* obter html do form */
        var htmlImput = htmlFormManyToMany();
        /* adicionar o html em um espaço temporario */
        $('#tmp_html').html(htmlImput).show();
        /* limpar notice se existir */
        if (TManyToMany === 1) {
            $("#listManyToMany").html('');
        }
        /* clonar o html */
        $(idForm).clone().appendTo("#listManyToMany");
        /* eliminar o temp */
        $('#tmp_html').html('');
        /* Ir para div */
        $('html,body').animate({scrollTop: $(idForm).offset().top}, 'slow');
        /* add + 1 a key*/
        key_ManyToMany++;
    }
}

function htmlFormAtributo(atributo) {

    var html = '<div class="grid fluid" style="padding: 10px;background: #F0EEEE; border: 1px solid #E0DDDD;" id="div_atributo_' + key_atributos + '">';

    html += '<div class="row">';
        html += '<div class="span12">';
            html += '<div class="toolbar transparent link place-right">';
                html += '<a><button class="bt-frame fg-red deleteButton" style="margin-top: -20px;" onclick="deleteAtributo(\'' + key_atributos + '\')"><i class="icon-cancel"></i></button></a>';
            html += '</div>';
        html += '</div>';
    html += '</div>';

    html += '<div class="row">';

    html += '<div class="span4">';
        html += '<h2>Atributo <b class="fg-red">*</b></h2>';
        html += '<div class="input-control text" data-role="input-control">';
            html += '<input type="text" name="dados[' + key_atributos + '][atributo]" id="atributo_' + key_atributos + '" required="" />';
            html += '<button class="btn-clear" tabindex="-1" type="button"></button>';
        html += '</div>';
    html += '</div>';

    html += '<div class="span4">';
        html += '<h2>Colmap <b class="fg-red">*</b></h2>';
        html += '<div class="input-control text" data-role="input-control">';
            html += '<input class="colmaps" type="hidden" name="dados[' + key_atributos + '][colmap]" id="colmap_' + key_atributos + '" value="'+atributo+'" required="" />';
            html += '<input type="text" name="vcolmap_' + key_atributos + '" id="vcolmap_' + key_atributos + '" value="'+atributo+'" disabled="" />';
            html += '<button class="btn-clear" tabindex="-1" type="button"></button>';
        html += '</div>';
    html += '</div>';

    html += '<div class="span4">';
        html += '<h2>OneToOne ( Objeto )</h2>';
        html += '<div class="input-control select" data-role="input-control" >';
            html += '<select name="dados[' + key_atributos + '][OneToOne]" id="OneToOne_' + key_atributos + '">';
                html += $('#OneToOne_0').html();
            html += '</select>';
        html += '</div>';
    html += '</div>';

    html += '</div>';

    html += '<div class="row">';

    html += '<div class="span2">';
    html += '<h2>Type <b class="fg-red">*</b></h2>';
    html += '<div class="input-control select" data-role="input-control" >';
    html += '<select name="dados[' + key_atributos + '][type]" id="type_' + key_atributos + '"  required="">';
    html += optionType();
    html += '</select>';
    html += '</div>';
    html += '</div>';

    html += '<div class="span2">';
    html += '<h2>Mask</h2>';
    html += '<div class="input-control select" data-role="input-control" >';
    html += '<select name="dados[' + key_atributos + '][mask]" id="mask_' + key_atributos + '">';
    html += optionMask();
    html += '</select>';
    html += '</div>';
    html += '</div>';

    html += '<div class="span2">';
    html += '<h2>NotNull</h2>';
    html += '<div class="input-control select" data-role="input-control" >';
    html += '<select name="dados[' + key_atributos + '][NotNull]" id="NotNull_' + key_atributos + '">';
    html += optionNotNull();
    html += '</select>';
    html += '</div>';
    html += '</div>';

    html += '<div class="span2">';
    html += '<h2>MinSize</h2>';
    html += '<div class="input-control text" data-role="input-control">';
    html += '<input type="text" name="dados[' + key_atributos + '][MinSize]" id="MinSize_' + key_atributos + '" />';
    html += '<button class="btn-clear" tabindex="-1" type="button"></button>';
    html += '</div>';
    html += '</div>';

    html += '<div class="span2">';
    html += '<h2>MaxSize</h2>';
    html += '<div class="input-control text" data-role="input-control">';
    html += '<input type="text" name="dados[' + key_atributos + '][MaxSize]" id="MaxSize_' + key_atributos + '" />';
    html += '<button class="btn-clear" tabindex="-1" type="button"></button>';
    html += '</div>';
    html += '</div>';

    html += '<div class="span2">';
    html += '<h2>Size</h2>';
    html += '<div class="input-control text" data-role="input-control">';
    html += '<input type="text" name="dados[' + key_atributos + '][size]" id="size_' + key_atributos + '" />';
    html += '<button class="btn-clear" tabindex="-1" type="button"></button>';
    html += '</div>';
    html += '</div>';

    html += '</div>';

    html += '</div>';

    return html;

}

function optionType() {
    var option = '';
    option += '<option value="" selected=""></option>';
    option += '<option value="Serial">Serial</option>';
    option += '<option value="inteiro">Inteiro</option>';
    option += '<option value="monetario">Monetario</option>';
    option += '<option value="decimal">Decimal</option>';
    option += '<option value="data">Data</option>';
    option += '<option value="hora">Hora</option>';
    option += '<option value="texto">Texto</option>';
    option += '<option value="email">E-mail</option>';
    option += '<option value="senha">Senha</option>';
    option += '<option value="cpf">CPF</option>';
    option += '<option value="cnpj">CNPJ</option>';
    option += '<option value="telefone">Telefone</option>';
    option += '<option value="cep">CEP</option>';
    return option;
}

function optionMask() {
    var option = '';
    option += '<option selected="" value="">S/Mascara</option>';
    option += '<option value="cpf">CPF</option>';
    option += '<option value="cnpj">CNPJ</option>';
    option += '<option value="data">Data</option>';
    option += '<option value="hora">Hora</option>';
    option += '<option value="telefone">Telefone</option>';
    option += '<option value="monetario">Monetario</option>';
    return option;
}

function optionNotNull() {
    var option = '';
    option += '<option value="NO">NotNull ( true )</option>';
    option += '<option selected="" value="YES">NotNull ( false )</option>';
    return option;
}

function htmlFormOneToMany() {

    var html = '<div class="grid fluid tOneToMany" style="padding: 10px;background: #F0EEEE; border: 1px solid #E0DDDD;" id="div_OneToMany_' + key_OneToMany + '">';

    html += '<div class="row">';
    html += '<div class="span12">';
    html += '<div class="toolbar transparent link place-right">';
    html += '<a><button class="bt-frame fg-red deleteButton" style="margin-top: -20px;" onclick="deleteOneToMany(\'div_OneToMany_' + key_OneToMany + '\')"><i class="icon-cancel"></i></button></a>';
    html += '</div>';
    html += '</div>';
    html += '</div>';

    html += '<div class="row">';

    html += '<div class="span4">';
    html += '<h2>Atributo <b class="fg-red">*</b></h2>';
    html += '<div class="input-control text" data-role="input-control">';
    html += '<input type="text" name="OneToMany[' + key_OneToMany + '][atributo]" id="OneToMany_atributo_' + key_OneToMany + '" required="" />';
    html += '<button class="btn-clear" tabindex="-1" type="button"></button>';
    html += '</div>';
    html += '</div>';

    html += '<div class="span4">';
    html += '<h2>Objeto <b class="fg-red">*</b></h2>';
    html += '<div class="input-control select" data-role="input-control" >';
    html += '<select name="OneToMany[' + key_OneToMany + '][objeto]" id="OneToMany_objeto_' + key_OneToMany + '"  required="" >';
    html += $('#OneToOne_0').html();
    html += '</select>';
    html += '</div>';
    html += '</div>';

    html += '<div class="span4">';
    html += '<h2>Coluna</h2>';
    html += '<div class="input-control text" data-role="input-control">';
    html += '<input type="text" name="OneToMany[' + key_OneToMany + '][coluna]" id="OneToMany_coluna_' + key_OneToMany + '" placeholder="Objeto -> Colmap" />';
    html += '<button class="btn-clear" tabindex="-1" type="button"></button>';
    html += '</div>';
    html += '</div>';

    html += '</div>';

    html += '</div>';

    return html;

}

function htmlFormManyToMany() {

    var html = '<div class="grid fluid tManyToMany" style="padding: 10px;background: #F0EEEE; border: 1px solid #E0DDDD;" id="div_ManyToMany_' + key_ManyToMany + '">';

    html += '<div class="row">';
    html += '<div class="span12">';
    html += '<div class="toolbar transparent link place-right">';
    html += '<a><button class="bt-frame fg-red deleteButton" style="margin-top: -20px;" onclick="deleteManyToMany(\'div_ManyToMany_' + key_ManyToMany + '\')"><i class="icon-cancel"></i></button></a>';
    html += '</div>';
    html += '</div>';
    html += '</div>';

    html += '<div class="row">';

    html += '<div class="span4">';
    html += '<h2>Atributo <b class="fg-red">*</b></h2>';
    html += '<div class="input-control text" data-role="input-control">';
    html += '<input type="text" name="ManyToMany[' + key_ManyToMany + '][atributo]" id="ManyToMany_atributo_' + key_ManyToMany + '" required="" />';
    html += '<button class="btn-clear" tabindex="-1" type="button"></button>';
    html += '</div>';
    html += '</div>';

    html += '<div class="span4">';
    html += '<h2>Objeto <b class="fg-red">*</b></h2>';
    html += '<div class="input-control select" data-role="input-control" >';
    html += '<select name="ManyToMany[' + key_ManyToMany + '][objeto]" id="ManyToMany_objeto_' + key_ManyToMany + '"  required="" >';
    html += $('#OneToOne_0').html();
    html += '</select>';
    html += '</div>';
    html += '</div>';

    html += '<div class="span4">';
    html += '<h2>Coluna</h2>';
    html += '<div class="input-control text" data-role="input-control">';
    html += '<input type="text" name="ManyToMany[' + key_ManyToMany + '][coluna]" id="ManyToMany_coluna_' + key_ManyToMany + '" placeholder="Objeto -> Colmap" />';
    html += '<button class="btn-clear" tabindex="-1" type="button"></button>';
    html += '</div>';
    html += '</div>';

    html += '</div>';


    html += '<div class="row">';

    html += '<div class="span6">';
    html += '<h2>Schema</h2>';
    html += '<div class="input-control text" data-role="input-control">';
    html += '<input type="text" name="ManyToMany[' + key_ManyToMany + '][schema]" id="ManyToMany_schema_' + key_ManyToMany + '" placeholder="Schema do banco de dados" />';
    html += '<button class="btn-clear" tabindex="-1" type="button"></button>';
    html += '</div>';
    html += '</div>';

    html += '<div class="span6">';
    html += '<h2>Table <b class="fg-red">*</b></h2>';
    html += '<div class="input-control text" data-role="input-control">';
    html += '<input type="text" name="ManyToMany[' + key_ManyToMany + '][table]" id="ManyToMany_table_' + key_ManyToMany + '" required="" placeholder="Tabela do banco de dados" />';
    html += '<button class="btn-clear" tabindex="-1" type="button"></button>';
    html += '</div>';
    html += '</div>';

    html += '</div>';

    html += '</div>';

    return html;

}