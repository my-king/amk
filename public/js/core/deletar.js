$(document).ready(function(){
    
     $('.delete').click(function(event) {
        var apagar = confirm('Deseja realmente excluir esta informação?');
        if (!apagar) {
            event.preventDefault();
        }
    });
    
}); 