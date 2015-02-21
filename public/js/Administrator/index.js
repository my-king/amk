$(document).ready(function(){});
function excluirProjeto(name) {
    if (confirm('Confirme para excluir o projeto.')) {
        var result = AjaxPost({objeto: "Database", method: "ExcluirSistemaFromDatabase", name: name});
        if (result === 1) {
            alert('Projeto removido com sucesso');
            var n = $( ".listProjetos tr" ).length;
            if(n === 1){
                location.reload(true);
            }else{
                $("#ref_" + name).remove();
            }
            
        } else {
            alert('Error ao tentar excluir o Projeto');
        }
    }
}