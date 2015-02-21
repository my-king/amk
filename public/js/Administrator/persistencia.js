$(document).ready(function(){});
function excluirPersistencia(name) {
    if (confirm('Confirme para excluir a persistência.')) {
        var result = AjaxPost({objeto: "Database", method: "ExcluirPersistenciaFromDatabase", name: name});
        if (result === 1) {
            alert('Persistência removida com sucesso');
            var n = $( ".listPersistencia tr" ).length;
            if(n === 1){
                location.reload(true);
            }else{
                $("#ref_" + name).remove();
            }
            
        } else {
            alert('Error ao tentar excluir a Persistência');
        }
    }
}