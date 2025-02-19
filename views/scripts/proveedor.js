var tabla;
function init() {
    listar();
    llenar_combo_documento();
    $('.selectpicker').selectpicker({
        noneSelectedText: 'Seleccione una opción'
    });
}
$('.selectpicker').on('loaded.bs.select', function() {
    $(this).val($(this).find('option:first').val());
    $(this).selectpicker('refresh');
});
function llenar_combo_documento(){
    $("#idTipoDoc").val("Seleccione");
    $.post("../controller/proveedor.php?op=llenar_combo_documento", function (r) {
      $("#idTipoDoc").html(r);
      $("#idTipoDoc").selectpicker('refresh');
    });
  
 
}
function open_modal(){
    $("#exampleModal").modal("show");
}
function listar(){
    tabla = $("#tbl_proveedor").DataTable({
		bLengthChange: true,
		autoWidth: false,
		 bDestroy: true,
		 language: {
		   search: "Buscar por",
		   lengthMenu:    "Mostrar _MENU_ Elementos",
		   info:           "Mostrando _START_ a _END_ de _TOTAL_ Elementos",
		   infoEmpty:      "Mostrando 0 registros de 0 registros encontrados",
		   paginate: {
			 next: "<span><i class='fa fa-arrow-right' aria-hidden='true'></span>",
			 previous: "<span><i class='fa fa-arrow-left' aria-hidden='true'></i></span>",
		   },
		 },

		 ajax: {
			 url: '../controller/proveedor.php?op=listar_proveedor',
			 type: 'GET',
			 datatype: "json",
			 error: function(e){
				 console.log(e.responseText);
			 }
		 },
	  
		 responsive: true,
		 searching: true,
		
	 
	 });
}
$("#btn_buscar_ruc_dni").click(function () {
    alert("Buscar por RUC");
    var dni = $("#ruc").val();
    if (dni.length == 8) {
      $.ajax({
        type: "POST",
        url: "../controller/consultaDni.php",
        data: "dni=" + dni,
        dataType: "json",
        success: function (data) {
          if (data.numeroDocumento == dni) {
            $("#idTipoDoc").val(data.tipoDocumento);
            $("#idTipoDoc").selectpicker("refresh");
            $("#nroDoc").val(data.numeroDocumento);
            $("#razon_social").val(data.nombre);
            $("#direccion").val(data.direccion);
            $("#estado_sunat").val(data.estado);
            console.log(data);
          }
        },
      });
    } else if (dni.length == 11) {
      $.ajax({
        type: "POST",
        url: "../controller/consultaRuc.php",
        data: "ruc=" + dni,
        dataType: "json",
        success: function (data) {
          if (data.numeroDocumento == dni) {
            $("#idTipoDoc").val(data.tipoDocumento);
            $("#idTipoDoc").selectpicker("refresh");
            $("#nroDoc").val(data.numeroDocumento);
            $("#razon_social").val(data.nombre);
            $("#direccion").val(data.direccion);
            $("#estado_sunat").val(data.estado);
            console.log(data);
          }
        },
      });
    }
  
  });
init();