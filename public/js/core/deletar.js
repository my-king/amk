$(document).ready(function(){
    
     $('.delete').click(function(event) {
        var apagar = confirm('Deseja realmente excluir esta informa��o?');
        if (!apagar) {
            event.preventDefault();
        }
    });
    
}); 