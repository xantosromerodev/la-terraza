function init() {
mostrar_form(true);
}
function mostrar_form(flag){
    if(flag==true){
        $("#form_ingreso").show();
        $("#lista_ingreso").hide();
    }else{
        $("#form_ingreso").hide();
        $("#lista_ingreso").show();
    }
}
init();