$(document).ready(function() {
    
    /* SELECT2 */
    $("#dal").select2({
        placeholder: 'Selecione uma instancia de conex�o.'
    });
    
    $("#schema").select2({
        placeholder: 'Selecione uma instancia de conex�o.'
    });
    
    $("#table").select2({
        placeholder: 'Selecione um Schema.'
    });

    $("#identificador").select2({
        placeholder: 'Selecione uma tabela.'
    });
    
    $("#dal").on('change',listSelect2DalFromSchema);
    $("#schema").on('change',listSelect2TableFromSchema);
    $("#table").on('change',listSelect2ColmapFromTable);
    /* Validate */
    $('#fConexao').validate();

});

function listSelect2DalFromSchema() {
    var DAL = $(this).val();
    /* Configurar a requisi��o ajax*/
    var AjaxParams = {objeto: 'Dbm', method: 'ListSelect2SchemaFromDal', dal: DAL};
    /* Configurar o retorno do objeto no html*/
    var fromObject = {
        id: '#schema',
        object: $('div[id="s2id_schema"] a:first'),
        msgEmpty: 'Selecione uma instancia de conex�o.',
        msgSuccess: 'Selecione um Schema.',
        msgError: 'A instancia escolhida n�o possue schemas associados.'
    };

    /* Exibir dados na tela com os options encontrados */
    ListSelect2Option(DAL, fromObject, AjaxParams);
}

function listSelect2TableFromSchema() {
    var DAL = $('#dal').val();
    var SCHEMA = $(this).val();
    /* Configurar a requisi��o ajax*/
    var AjaxParams = {objeto: 'Dbm', method: 'ListSelect2TableFromSchema', dal: DAL, schema: SCHEMA};
    /* Configurar o retorno do objeto no html*/
    var fromObject = {
        id: '#table',
        object: $('div[id="s2id_table"] a:first'),
        msgEmpty: 'Selecione um schema.',
        msgSuccess: 'Selecione uma tabela.',
        msgError: 'O Schema escolhido n�o possue tabelas associadas.'
    };

    /* Exibir dados na tela com os options encontrados */
    ListSelect2Option(SCHEMA, fromObject, AjaxParams);
}

function listSelect2ColmapFromTable() {
    
    var DAL = $('#dal').val();
    var SCHEMA = $('#schema').val();
    var TABLE = $(this).val();
    
    /* Configurar a requisi��o ajax*/
    var AjaxParams = {objeto: 'Dbm', method: 'ListSelect2ColmapFromTable', dal: DAL, schema: SCHEMA, table: TABLE};
    /* Configurar o retorno do objeto no html*/
    var fromObject = {
        id: '#identificador',
        object: $('div[id="s2id_identificador"] a:first'),
        msgEmpty: 'Selecione uma tabela.',
        msgSuccess: 'Selecione uma referencia.',
        msgError: 'A tabela escolhida n�o possue colmaps.'
    };

    /* Exibir dados na tela com os options encontrados */
    ListSelect2Option(TABLE, fromObject, AjaxParams);
}