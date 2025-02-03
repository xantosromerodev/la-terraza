
var tabla;
//Función que se ejecuta al inicio
function init(){
    listar();
	llenar_combo_categoria_gen();
}

function llenar_combo_categoria_gen(){
	$.post("../controller/categoria.php?op=obtener_categoria_general",
		function(data,status){
			dataJson=JSON.parse(data);
			for(var i=0; i<dataJson.length; i++){
			$("#id_cate").append("<option value='"+dataJson[i].id_cate+"'>"+dataJson[i].descripcion+"</option>");
		}
	}
	);
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
			 url: '../controller/categoria.php?op=listar',
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
	if($("#idcategoria").val() == ""){
		guardar();
	}else{

		actualizar();	
	}
	//$("#exampleModal").modal("hide");
	
});
function guardar(){
	var nombre = $("#nombre").val();
	var id_cate=$("#id_cate").val();

	$.ajax({
		url: "../controller/categoria.php?op=guardaryeditar",
		type: "POST",
		data: {id_cate:id_cate ,nombre: nombre},
		success: function(data){
			$.notify(data,"success");
			listar();
			limpiar();
		}
	});
}
function actualizar(){
	var id = $("#idcategoria").val();
	var nombre = $("#nombre").val();
	var id_cate=$("#id_cate").val();
	$.ajax({
		url: "../controller/categoria.php?op=guardaryeditar",
		type: "POST",
		data: {idcategoria: id, nombre: nombre, id_cate:id_cate},
		success: function(data){
			console.log(data);
			$.notify(data,"success");
			listar();
			limpiar();
		},
		error: function(data){
			console.log(data.responseText);
		}
	});
}
function mostrar(id){
	$.post("../controller/categoria.php?op=mostrar",{idcategoria : id}, function(data, status){
		data = JSON.parse(data);
		console.log(data);	
		$("#exampleModal").modal("show");
		$("#idcategoria").val(data.id);
		$("#id_cate").val(data.id_cate);
		$("#nombre").val(data.nombre);
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
			$.post("../controller/categoria.php?op=eliminar",{idcategoria : id}, function(e){
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
