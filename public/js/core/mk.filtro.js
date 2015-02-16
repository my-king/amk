jQuery.fn.toggleText = function(a,b) {
    return this.html(this.html().replace(new RegExp("("+a+"|"+b+")"),function(x){return(x==a)?b:a;}));
}
$(document).ready(function(){
    $("#tb_filtrar").click(function(){
        $("#filtro-elemento").slideToggle("slow");
        $("#filtrar button .label").toggleText('Filtrar','Fechar');
        //$("#filtrar button span i").toggleClass("icon-cancel-2")
    });
});