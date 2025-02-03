
var tabla;
//Función que se ejecuta al inicio
function init(){
	
    listar();
}


function listar()
{
	tabla = $("#datatable-responsive").DataTable({
		bLengthChange: true,
		autoWidth: false,
		 bDestroy: true,
		 language: {
		   search: "Buscar por",
		   lengthMenu:    "Mostrar _MENU_ Elementos",
		   info:           "Mostrando _START_ a _END_ de _TOTAL_ Elementos",
		   infoEmpty:      "Mostrando 0 registros de 0 registros encontrados",
		   paginate: {
			 next: "<span ><i class='fa fa-arrow-right' aria-hidden='true'></span>",
			 previous: "<span ><i class='fa fa-arrow-left' aria-hidden='true'></i></span>",
		   },
		 },
		 "ajax":{
			url: '../controller/perfil.php?op=listar',
						type : "get",
						dataType : "json",						
						error: function(e){
							console.log(e.responseText);	
						}
		},
		 responsive: true,
		 searching: false,
	 });
}
$("#btn-guardarP").on("click",function(e){
	e.preventDefault();
	if($("#id_profile").val()==""){
		guardar();
	}else{
		editar();
	}
	
})
function guardar(){
	var nombre_profile=$("#nombre_profile").val();
	$.post("../controller/perfil.php?op=guardar",{nombre_profile:nombre_profile},
		function(data, status){
			
			$.notify(data, "success");
			$("#exampleModal").modal('hide');
			limpiar();
			listar();
		}
	)
	

}
function mostrar(id_profile){
	$.post("../controller/perfil.php?op=mostrar",{id_profile:id_profile},
		function(data,status){
			json_data=JSON.parse(data);
			console.log(json_data);
			$("#exampleModal").modal('show');
			$("#id_profile").val(json_data.id);
			$("#nombre_profile").val(json_data.nombre);
		}
	)
}
function editar(){
	var data_perfil={
		id_profile:$("#id_profile").val(),
		nombre_profile:$("#nombre_profile").val()
	}
	$.post("../controller/perfil.php?op=guardar",data_perfil,
		function(data,status){
			console.log(data)
			$.notify(data, "success");
			$("#exampleModal").modal('hide');
			limpiar();
			listar();
		}
	)
}
function eliminar(id_profile){
	$.post("../controller/perfil.php?op=eliminar",{id_profile:id_profile},
		function(data, status){
			console.log(data);
			if(data){
				$.notify(data, "success");
				listar();
				limpiar();
			}else{
				$.notify(data, "error");
				listar();
				limpiar();
			}
		}
	)
	
}
function limpiar(){
	$("#frm_perfil").get(0).reset() 
}
init();
