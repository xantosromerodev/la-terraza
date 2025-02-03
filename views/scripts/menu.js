
var tabla;
//Función que se ejecuta al inicio
function init(){
    listar();

    $.post("../controller/menu.php?op=llenar", function (r) {
        $("#idcategoria").html(r);
        $('#idcategoria').selectpicker('refresh');
       });
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
			 next: "<span><i class='fa fa-arrow-right' aria-hidden='true'></span>",
			 previous: "<span><i class='fa fa-arrow-left' aria-hidden='true'></i></span>",
		   },
		 },

		 ajax: {
			 url: '../controller/menu.php?op=listar',
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
$("#btn-guardar").click(function(e){
	e.preventDefault();
	if($("#idmenu").val() == ""){
		guardar();
	}else{

		actualizar();	
	}
	$("#exampleModal").modal("hide");
	
});
function guardar(){
	var nombre = $("#nombre").val();
	var precio = $("#precio").val();
	var idcategoria = $("#idcategoria").val();
	var data_menu={
		nombre:nombre,
		precio:precio,
		idcategoria:idcategoria	
	}
console.log(data_menu);
	$.ajax({
		url: "../controller/menu.php?op=guardaryeditar",
		type: "POST",
		data: data_menu,
		success: function(data){
			mensaje(data,"","success");
			listar();
			limpiar();
		}
	});
}
function actualizar(){
	var id = $("#idmenu").val();
	var nombre = $("#nombre").val();
    var precio = $("#precio").val();
	var idcategoria = $("#idcategoria").val();
	var data_menu={
		idmenu:id,
		nombre:nombre,
		precio:precio,
		idcategoria:idcategoria
	}
	$.ajax({
		url: "../controller/menu.php?op=guardaryeditar",
		type: "POST",
		data: data_menu,
		success: function(data){
			mensaje(data,"","success");
			listar();
			limpiar();
		},
		error: function(data){
			console.log(data.responseText);
		}
	});
}
function mostrar(id){
	$.post("../controller/menu.php?op=mostrar",{idmenu : id}, function(data, status){
		data = JSON.parse(data);
		console.log(data);	
		$("#exampleModal").modal("show");
		$("#idmenu").val(data.id);
		$("#nombre").val(data.nombre);
        $("#precio").val(data.precio);
        $("#idcategoria").val(data.categoria_id);
		$('#idcategoria').selectpicker('refresh');
		/*$("#id").val(data.id);
		$("#nombre").val(data.nombre);
		*/
	});
}
function eliminar(id){
	Swal.fire({
		title: 'Estas seguro de eliminar?',	
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',	
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, eliminar',
		cancelButtonText: 'Cancelar'
	  }).then((result) => {
		if (result.isConfirmed) {
			$.post("../controller/menu.php?op=eliminar",{idmenu : id}, function(e){
				mensaje(e,"","success");
				listar();
				limpiar();
			});
			
		};

});
}

function limpiar(){
$("#formulario")[0].reset();
}

function mensaje(title, text, icon){
	Swal.fire({
		title: title,
		text: text,
		icon: icon
	  });
}
init();
