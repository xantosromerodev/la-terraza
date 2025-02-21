var tabla;
function init() {
  listar();
  llenar_combo_documento();
}

function llenar_combo_documento() {
  $.post("../controller/proveedor.php?op=llenar_combo_documento", function (r) {
    $("#idTipoDoc").html(r);
    $("#idTipoDoc").selectpicker("refresh");
  });
}
function open_modal() {
  limpiar();
  $("#exampleModal").modal("show");
}
function close_modal() {
  limpiar();
  $("#exampleModal").modal("hide");
}
function listar() {
  tabla = $("#tbl_proveedor").DataTable({
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
      url: "../controller/proveedor.php?op=listar_proveedor",
      type: "GET",
      datatype: "json",
      error: function (e) {
        console.log(e.responseText);
      },
    },

    responsive: true,
    searching: true,
  });
}
$("#btn_buscar_ruc_dni").click(function () {
  var dni = $("#nro_doc").val();
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
          //$("#nroDoc").val(data.numeroDocumento);
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
          //$("#nroDoc").val(data.numeroDocumento);
          $("#razon_social").val(data.nombre);
          $("#direccion").val(data.direccion);
          $("#estado_sunat").val(data.estado);
          console.log(data);
        }
      },
    });
  }
});
$("#btn-guardar").click(function () {
  insertar_proveedor();
});
function insertar_proveedor(e) {
  //e.preventDefault();
  var form_data = new FormData($("#frm_proveedor")[0]);
  $.ajax({
    type: "POST",
    url: "../controller/proveedor.php?op=guardar_proveedor",
    data: form_data,
    contentType: false,
    processData: false,
    success: function (datos) {
      console.log(datos);
      $.notify(datos, "success");
      listar();
      limpiar();
    },
    error: function (datos) {
      console.log(datos);
    },
  });
}
function mostrar(idproveedor) {
  $.post(
    "../controller/proveedor.php?op=mostrar_proveedor",
    { idProveedor: idproveedor },
    function (data, status) {
      data = JSON.parse(data);
      $("#exampleModal").modal("show");
      $("#idTipoDoc").val(data.cod_tipo_doc);
      $("#idTipoDoc").selectpicker("refresh");
      $("#ruc").val(data.nro_documento);
      $("#razon_social").val(data.razon_social);
      $("#direccion").val(data.direccion);
      $("#telefono").val(data.telefono);
      $("#estado_sunat").val(data.estado_sunat);
      $("#idProveedor").val(data.idproveedor);
    }
  );
}
function eliminar(idProveedor)
{
  Swal.fire({
  title: "EASTA SEGURO DE ELIMINAR PROVEEDOR ?",
  text: "eliminar",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Confirmar"
}).then((result) => {
  if (result.isConfirmed) {
    $.post("../controller/proveedor.php?op=eliminar_proveedor",{idProveedor:idProveedor},
    function(data, status){
    	$.notify(data,"success");
    	tabla.ajax.reload();
    })
  }
});
	limpiar();
}
function limpiar() {
  $("#idTipoDoc").selectpicker("val", "");
  $("#idProveedor").val("");
  $("#ruc").val("");
  $("#razon_social").val("");
  $("#direccion").val("");
  $("#telefono").val("");
  $("#estado_sunat").val("");
}
init();
