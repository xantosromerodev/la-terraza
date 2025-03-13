var tabla;

function init() {
    listar();
}
function listar()
{
	tabla = $("#tbla_cajas").DataTable({
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
			 url: '../controller/cajas.php?op=listar_caja',
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
$("#btn-guardar").click(function(){
	if($("#idcaja").val()==""){
		guardar_caja();
	}else{	
		editar_caja();
	}
})
function guardar_caja(){
	var data_caja={
		nombre_caja:$("#nombre_caja").val()
	}
	$.ajax({
		url: '../controller/cajas.php?op=guardar_caja',
		type: 'POST',
		data: data_caja,
		success: function(e){
			$.notify(e,"success");
			listar();
			limpiar();
			$("#modal_cajas").modal('hide');
		}
	})
	
}
function editar_caja(){
	var data_caja={
		idcaja:$("#idcaja").val(),
		nombre_caja:$("#nombre_caja").val()
	}
	$.ajax({
		url: '../controller/cajas.php?op=editar_caja',
		type: 'POST',
		data: data_caja,
		success: function(e){
			$.notify(e,"success");
			listar();
			limpiar();
			$("#modal_cajas").modal('hide');
		}
	})
	
}
function limpiar(){
	$("#idcaja").val("");
	$("#nombre_caja").val("");
}
function cancelar(){
	limpiar();
	listar();
}
function mostrar(idcaja){
     console.log(idcaja);
    $.ajax({
        url: '../controller/cajas.php?op=mostrar',
        type: 'POST',
        
        data: {idcaja:idcaja},
        success: function(e){
   datosJson=JSON.parse(e);
   console.log(datosJson);

           $("#modal_cajas").modal("show");
           $("#idcaja").val(datosJson.id_caja);
           $("#nombre_caja").val(datosJson.nombre_caja);
        }
    });
}
function eliminar_caja(idcaja){
	Swal.fire({
		title: 'Estas seguro de eliminar?',
		text: "No podras revertir esto!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, eliminar',
		cancelButtonText: 'Cancelar'
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: '../controller/cajas.php?op=eliminar_caja',
				type: 'POST',
				data: {idcaja:idcaja},
				success: function(e){
					$.notify(e,"success");
					listar();
				}
			})
		}else{
			limpiar();
		}
	})
	
}
init();