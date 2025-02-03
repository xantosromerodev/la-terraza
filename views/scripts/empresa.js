
var tabla;
//Función que se ejecuta al inicio
function init(){
   listar();
   llenar_combo_region();
}


//API SUNAT
function obtenerRuc(){
	var ruc = $('#ruc').val();
	console.log(ruc);
	$.ajax({
      type: "POST",
      url: "../controller/consultaRuc.php",
      data: "ruc=" + ruc,
      dataType: "json",
      success: function (data) {
		console.log(data);
      	$('#razon_social').val(data.nombre);
		$("#nombre_comercial").val(data.nombre);

      	$('#domicilio_fiscal').val(data.direccion);
		$("#estado_sunat").val(data.estado);

		//$("#deparatamento_provicia_distrito").append(data.departamento + " - " + data.provincia + " - " + data.distrito);
      	// $('#estado').val(data.estado);
        // console.log(data);
      }
	});
}
function llenar_combo_region() {
  $.post("../controller/empresa.php?op=obtener_region", function (r) {
    
    var dataJson = JSON.parse(r);
    for (var i = 0; i < dataJson.length; i++) {
      var option =
        "<option value='" +
        dataJson[i].id_ubigeo +
        "'>" +
        dataJson[i].region +
        "</option>";
      $("#id_ubigeo").append(option);
    }
  });
}
$("#id_ubigeo").change(function () {
  var opcionSeleccionada = $(this).val();
 $.post("../controller/empresa.php?op=obtener_ubigeo",{id_ubigeo:opcionSeleccionada},
	function(data,status){
		data=JSON.parse(data);
		$("#ubigeo").val(data.codigo_ubigeo);
	}
 )
});
$('#btn_buscar_ruc').on('click', function(){
	
	obtenerRuc();
});


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
			 url: '../controller/empresa.php?op=listar',
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
	if ($("#idempresa").val() == "") {
    guardar();
    listar();
    limpiar();
  } else {
    actualizar();
    listar();
    limpiar();
  }
	$("#exampleModal").modal("hide");
	
});

function guardar(){

var form_data = new FormData($("#frm_empresa")[0])
 //console.log(form_data);

$.ajax({
    type: "POST",
    url: "../controller/empresa.php?op=guardaryeditar",
    data: form_data,
    contentType: false,
    processData: false,
    success: function (datos) {
      console.log(datos);
    },
    error:function(datos){
    	console.log(datos);
    }
  });


}
function actualizar(){
	
	var form_data = new FormData($("#frm_empresa")[0])

	$.ajax({
		url: "../controller/empresa.php?op=guardaryeditar",
		type: "POST",
		data: form_data,
		contentType: false,
    	processData: false,
		success: function(data){
			console.log(data);
			mensaje(data,"","success");
			listar();
			limpiar();
		
		
		},
		error: function(data){
			console.log(data.responseText);
		}
	});
}
function mostrar(idempresa){
	$.post("../controller/empresa.php?op=mostrar",{idempresa : idempresa}, function(data, status){
		data = JSON.parse(data);
		console.log(data);	
		$("#exampleModal").modal("show");
		$("#idempresa").val(data.id);
		$("#ruc").val(data.ruc);
		$("#nempresa").val(data.nempresa);
		$("#domicilio").val(data.domicilio);
		$("#celular").val(data.telmovil);
		$("#correo").val(data.correo);
		$("#logotext").val(data.logo);
	});
}
function eliminar(idempresa){
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
			$.post("../controller/empresa.php?op=eliminar",{idempresa: idempresa}, function(e){
				mensaje(e,"","success");
				listar();
				limpiar();
			});
			
		};

});
}

function limpiar(){
$("#frm_empresa")[0].reset();
}

function mensaje(title, text, icon){
	Swal.fire({
		title: title,
		text: text,
		icon: icon
	  });
}
$("#imagen").change(function () {
  var reader = new FileReader();
  reader.onload = function (e) {
    $("#imagenmuestra").attr("src", e.target.result);
  };
  reader.readAsDataURL(this.files[0]);
});
init();
