$(document).ready(function () {
    //buttonSalvarDisabled();
});

/* Habilitar um button */
function buttonSalvarEnabled() {
    $('#salvar').removeAttr("class");
    $('#salvar').attr("class", "btn btn-primary");
    $('#salvar').removeAttr("disabled");
}

/* Desabilitar um button */
function buttonSalvarDisabled() {
    $('#salvar').removeAttr("class");
    $('#salvar').attr("class", "btn disabled");
    $('#salvar').attr("disabled", "disabled");
}

function excluirProjeto(name) {
    if (confirm('Confirme para excluir o projeto.')) {
        var result = AjaxPost({objeto: "Database", method: "ExcluirSistemaFromDatabase", name: name});
        if (result === 1) {
            alert('Projeto removido com sucesso');
            $("#ref_" + name).remove();
        } else {
            alert('Error ao tentar excluir o Projeto');
        }
    }
}