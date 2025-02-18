
var tabla;
//Función que se ejecuta al inicio
function init(){
    listar_platillos(2);
	listar_bebidas(1);
	listar_insumos(3);
//llenar_combo_categoria(1);
    
}
function generar_codigo_producto(){
	$.post("../controller/menu.php?op=codigo_producto", function (r) {
		datosJson=JSON.parse(r);
		$("#codigo_producto").val(datosJson.nuevo_codigo);
	});
}
function llenar_combo_categoria(id_cate){
	///$("#idcategoria").empty();
	
$.post("../controller/menu.php?op=llenar", { p_idcate :id_cate}, function (r) {
  //jsonData = JSON.parse(r);
  $("#idcategoria").html(r);
  $("#idcategoria").selectpicker('refresh');
 /*for (var i = 0; i < jsonData.length; i++) {
    var option =
      "<option value='" +
      jsonData[i].id +
      "'>" +
      jsonData[i].nombre +
      "</option>";
    $("#idcategoria").append(option);
  }
	*/
});

}

function listar_platillos(id_cate)
{

	tabla = $("#datatable-responsive").DataTable({
    bLengthChange: true,
    autoWidth: false,
    bDestroy: true,
    language: {
      search: "Buscar por",
      lengthMenu: "Mostrar _MENU_ Elementos",
      info: "Mostrando _START_ a _END_ de _TOTAL_ Elementos",
      infoEmpty: "Mostrando 0 registros de 0 registros encontrados",
      paginate: {
        next: "<span><i class='fa fa-arrow-right' aria-hidden='true'></span>",
        previous:
          "<span><i class='fa fa-arrow-left' aria-hidden='true'></i></span>",
      },
    },

    ajax: {
      url: "../controller/menu.php?op=listar",
      type: "GET",
      data: { p_id_cate: id_cate },
      datatype: "json",
      error: function (e) {
        console.log(e.responseText);
      },
    },

    responsive: true,
    searching: true,
  });
}
function listar_bebidas(id_cate) {
  tabla = $("#tbl_bebidas").DataTable({
    bLengthChange: true,
    autoWidth: false,
    bDestroy: true,
    language: {
      search: "Buscar por",
      lengthMenu: "Mostrar _MENU_ Elementos",
      info: "Mostrando _START_ a _END_ de _TOTAL_ Elementos",
      infoEmpty: "Mostrando 0 registros de 0 registros encontrados",
      paginate: {
        next: "<span><i class='fa fa-arrow-right' aria-hidden='true'></span>",
        previous:
          "<span><i class='fa fa-arrow-left' aria-hidden='true'></i></span>",
      },
    },

    ajax: {
      url: "../controller/menu.php?op=listar",
      type: "GET",
      data: { p_id_cate: id_cate },
      datatype: "json",
      error: function (e) {
        console.log(e.responseText);
      },
    },

    responsive: true,
    searching: true,
  });
}
function listar_insumos(id_cate) {
	tabla = $("#tbl_insumos").DataTable({
	  bLengthChange: true,
	  autoWidth: false,
	  bDestroy: true,
	  language: {
		search: "Buscar por",
		lengthMenu: "Mostrar _MENU_ Elementos",
		info: "Mostrando _START_ a _END_ de _TOTAL_ Elementos",
		infoEmpty: "Mostrando 0 registros de 0 registros encontrados",
		paginate: {
		  next: "<span><i class='fa fa-arrow-right' aria-hidden='true'></span>",
		  previous:
			"<span><i class='fa fa-arrow-left' aria-hidden='true'></i></span>",
		},
	  },
  
	  ajax: {
		url: "../controller/menu.php?op=listar",
		type: "GET",
		data: { p_id_cate: id_cate },
		datatype: "json",
		error: function (e) {
		  console.log(e.responseText);
		},
	  },
  
	  responsive: true,
	  searching: true,
	});
  }
$("#btn-guardar").click(function(e){
	e.preventDefault();
	if ($("#idcategoria").val() == 0) {
    $.notify("Seleccione una categoria", "error");

    return false;
  }else if ($("#nombre").val() == "") {
	$("#idcategoria").remove("is-invalid");
	$.notify("Ingrese el nombre del producto", "error");
	$("#nombre").addClass("is-invalid");
	$("#nombre").focus();
	 return false;
  }else if ($("#precio").val() == "") {
	$("#nombre").addClass("is-invalid");
	$.notify("Ingrese el precio del producto", "error");
	$("#precio").addClass("is-invalid");
	return false;
  }else  if ($("#idmenu").val() == "") {
      guardar();
    } else {
      actualizar();
    }
///$("#exampleModal").modal("hide");
	
});
function guardar(){
	var codigo_producto = $("#codigo_producto").val();
	var idcategoria = $("#idcategoria").val();
	var nombre = $("#nombre").val();
	var stk = $("#stk").val();
	var precio = $("#precio").val();
	
	var data_menu={
		codigo_producto:codigo_producto,
		idcategoria:idcategoria,
		nombre:nombre,
		stk:stk,
		precio:precio,
		
	}
console.log(data_menu);
	$.ajax({
		url: "../controller/menu.php?op=guardaryeditar",
		type: "POST",
		data: data_menu,
		success: function(data){
			$.notify(data,"success");
			console.log(data);
			generar_codigo_producto();
			listar_platillos(2);	
			listar_bebidas(1);
			listar_insumos(3);
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
		$("#idcategoria").selectpicker('refresh');
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
$("#btn_cancelar").click(function(e){
	e.preventDefault();
	$("#exampleModal").modal("hide");
	limpiar();
});
function open_modal_menu(id_cate){
	generar_codigo_producto();
	llenar_combo_categoria(id_cate);
	$("#exampleModal").modal("show");
}

init();
