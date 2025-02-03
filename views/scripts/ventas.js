
var tabla;
var id_mesa;
function init() {
  mostrar_lista(false);
  llenar_combo_doc();
  obtener_modo_pago();
  listar();
  fecha_actual();
 desahabilitar_controles(true)
  //desahabilitar_botones();
  //llenamos combo modo de pago
}
//lista de comprobantes

function listar() {
  tabla = $("#tb_comprobantes").DataTable({
    bLengthChange: true,
    autoWidth: false,
    bDestroy: true,
    language: {
      search: "Buscar por",
      lengthMenu: "Mostrar _MENU_ Elementos",
      info: "Mostrando _START_ a _END_ de _TOTAL_ Elementos",
      infoEmpty: "Mostrando 0 registros de 0 registros encontrados",
      paginate: {
        next: "<span ><i class='fa fa-arrow-right' aria-hidden='true'></span>",
        previous:
          "<span ><i class='fa fa-arrow-left' aria-hidden='true'></i></span>",
      },
    },
    ajax: {
      url: "../controller/ventas.php?op=ventas_del_dia",
      type: "get",
      dataType: "json",
      error: function (e) {
        console.log(e);
      },
    },
    responsive: true,
    searching: true,
  });
}

//fin de la lsista de comprobantes
function llenar_combo_doc() {
  $.post("../controller/ventas.php?op=llenar_combo_doc", function (r) {
    console.log(r);
    var dataJson = JSON.parse(r);
    for (var i = 0; i < dataJson.length; i++) {
      var option =
        "<option value='" +
        dataJson[i].idtipo_documento +
        "'>" +
        dataJson[i].nombre_tipo_doc +
        "</option>";
      $("#tipo_comprobante").append(option);
    }
  });
}

$("#tipo_comprobante").change(marcarImpuesto);
function marcarImpuesto() {
  var tipo_comprobante = $("#tipo_comprobante option:selected").val();
  if (tipo_comprobante == 0) {
    $("#serie_comprobante").val("");
    $("#num_comprobante").val("");
   $("#tb_detalle tbody").empty();
  
  }else if(tipo_comprobante==3){
    alert("hol");
     $("#stotal").hide();
  }else{
  $.post(
    "../controller/ventas.php?op=obtener_series_numero",
    { tipo_comprobante: tipo_comprobante },
    function (data, status) {
  
      resa = JSON.parse(data);
      console.log(resa);
      $("#serie_comprobante").val(resa.num_serie);

      var serie = resa.num_serie;
  
      obtener_generar_correlativo(serie);
    }
  );
}
}
  function obtener_generar_correlativo(serie_comprobante) {
    console.log("metodod_generar " + serie_comprobante);
    $.post(
      "../controller/ventas.php?op=obtener_correlativo_venta",
      { serie_comprobante: serie_comprobante },
      function (data, status) {
        console.log(data);
        numeracion = JSON.parse(data);
        $("#num_comprobante").val(numeracion.nuevo_numero_factura);
      }
    );
  }

function fecha_actual() {
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = now.getFullYear() + "-" + month + "-" + day;

  $("#fecha_emision").val(today);
}


function mostrar_lista(flag) {
  if (flag == true) {
    $("#lista_conetenedora").show();
    $("#ventana_generrar_comprobante").hide();
  } else {
    $("#lista_conetenedora").hide();
    $("#ventana_generrar_comprobante").show();
  }
}
function mostrar_detalle(idmesa) {
  // clearTable();
 desahabilitar_controles(false);
  id_mesa = idmesa;
  console.log("id mesa para librera "+ id_mesa);
  $.ajax({
    url: "../controller/ventas.php?op=obtener_detalle_pedido",
    type: "POST",
    data: { id_mesa: idmesa },
    success: function (data) {
      dataJson = JSON.parse(data);

      for (var i = 0; i < dataJson.length; i++) {
        console.log(dataJson[i]);
        agregarDetalle(
          dataJson[i].id_menu,
          dataJson[i].cantidad,
          dataJson[i].nombre,
          dataJson[i].precio
        );
      }
    },
  });
}
//sus detalles
var impuesto = 18;
var cont = 0;
var detalles = 0;

function agregarDetalle(idarticulo,cantidad, articulo, precio_venta) {
  
  if (idarticulo != "") {
    var subtotal = cantidad * precio_venta;
      console.log(subtotal);
    var fila =
      '<tr class="filas" id="fila' +
      cont +
      '">' +
      '<td><input type="text" class="form-control form-control-sm" readonly name="cantidad[]" id="cantidad" value="' +
      cantidad +
      '" ></td>' +
      '<td><input type="hidden" name="idarticulo[]" value="' +
      idarticulo +
      '">' +
      articulo +
      "</td>" +
      '<td><input type="text" class="form-control form-control-sm" readonly name="precio_venta[]" id="precio_venta"  value="' +
      precio_venta +
      '"></td>' +
      '<td><input type="text"class="form-control form-control-sm" readonly name="total[]" id="total" value="' +
      subtotal +
      '"></td>' +
      "</tr>";
    cont++;
    detalles = detalles + 1;
    $("#tb_detalle").append(fila);
    calcular_totales();
  } else {
    alert("Error al ingresar el detalle, revisar los datos del artículo");
  }
}
function calcular_totales() {
  var cant = document.getElementsByName("cantidad[]");
  var prec = document.getElementsByName("precio_venta[]");
  var tot = document.getElementsByName("total[]");

  for (var i = 0; i < cant.length; i++) {
    var cantidad = cant[i];
    var precio = prec[i];
    var total = tot[i];

    total.value = cantidad.value * precio.value;
    // console.log("total gravad" + " "+ total.value)
    document.getElementsByName("total[]")[i].value = total.value;
  }
  calcularTotales();
}
function calcularTotales() {
  var tot = document.getElementsByName("total[]");
  var total = 0.0;

  for (var i = 0; i < tot.length; i++) {
    total += parseFloat(document.getElementsByName("total[]")[i].value) / 1.18;
  }

  $("#total_gravada").val(total.toFixed(2));
  // calculamos el igv y el totala a pagar
  var igv = 0.18;

  var valor_igv = total * igv;
  $("#total_igv").val(valor_igv.toFixed(2));
  var valor_total_pagar = total + valor_igv;
  $("#total_a_pagar").val(valor_total_pagar.toFixed(2));
  total_a_pagar = parseFloat(total_gravada) + parseFloat(igv);
}
function clearTable() {
  var table = document.getElementById("tb_detalle");
  var rowCount = table.rows.length;

  // Elimina todas las filas excepto el encabezado
  for (var i = rowCount - 1; i > 0; i--) {
    table.deleteRow(i);
  }
}
// buscar clientes
$("#btn_buscar_ruc_dni").click(function () {
  var dni = $("#nro_documento").val();
  if (dni.length == 8) {
    $.ajax({
      type: "POST",
      url: "../controller/consultaDni.php",
      data: "dni=" + dni,
      dataType: "json",
      success: function (data) {
        console.log(data);
        if (data.numeroDocumento == dni) {
          $("#idTipoDoc").val(data.tipoDocumento);
          $("#idTipoDoc").selectpicker("refresh");
          $("#nro_doc").val(data.numeroDocumento);
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
          $("#nro_doc").val(data.numeroDocumento);
          $("#razon_social").val(data.nombre);
          $("#direccion").val(data.direccion);
          $("#estado_sunat").val(data.estado);
          console.log(data);
        }
      },
    });
  }
  $("#mdlClientes").modal("show");
});

function insertar_clientes() {
  var formData = new FormData($("#for_clientes")[0]);
  $.ajax({
    type: "POST",
    url: "../controller/clientes.php?op=gaurdar_clientes",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      $.notify(data, "success");
      var num_doc = $("#nro_doc").val();
      obtener_cliente(num_doc);
      $("#mdlClientes").modal("hide");
      reset_form_clientes();
    },
    error: function (xhr, status, error) {
      console.log(xhr.responseText);
    },
  });
}

$("#nro_documento").autocomplete({
  source: function (request, response) {
    $.ajax({
      url: "../controller/ventas.php?op=auto_complete_cliente",
      type: "GET",
      dataType: "JSON",
      success: function (data) {
        console.log(data);
        aData = $.map(data, function (value, key) {
          return {
            label: value.num_documento + "-" + value.razon_social,
            idc: value.idcliente,
          };
        });
        var result = $.ui.autocomplete.filter(aData, request.term);
        response(result);
      },
    });
  },
  select: function (event, ui) {
    $("#idcliente").val(ui.item.idc);
    console.log(ui.item.idc);
  },
});

function obtener_cliente(nro_doc) {
  $.post(
    "../controller/ventas.php?op=obtener_cliente",
    { nro_doc: nro_doc },
    function (data, status) {
      console.log("num_doc.." + nro_doc);
      data = JSON.parse(data);
      console.log(data);
      $("#idcliente").val(data.idcliente);
      $("#nro_documento").val(data.num_documento + "-" + data.razon_social);
      console.log(data.num_documento + "-" + data.razon_social);
    }
  );
}
function obtener_modo_pago() {
  $("#modo_pago").val(0);
  $.post("../controller/ventas.php?op=modo_pago", function (r) {
    var dataJson = JSON.parse(r);
    for (var i = 0; i < dataJson.length; i++) {
      var option =
        "<option value='" +
        dataJson[i].id_modo_pago +
        "'>" +
        dataJson[i].modo_pago_desc +
        "</option>";
      $("#modo_pago").append(option);
    }
  });
}
function reset_form_clientes() {
  $("#for_clientes")[0].reset();
  $("#idTipoDoc").selectpicker({
    noneSelectedText: "Seleccione", // Texto en blanco para ocultar el mensaje por defecto
  });
}
// funcion para guardar en la base de datos
$("#btn_guardar_venta").click(function () {
  validar_ingreso();
 
});
function guardar_venta() {
  var formData = new FormData($("#form_venta")[0]);
  
  $.ajax({
    type: "POST",
    url: "../controller/ventas.php?op=guardar_venta",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
    $.notify(data, "success");
    liberar_mesa();
     location.reload();
     desahabilitar_controles(true);
    
//  for (var pair of formData.entries()) {
//    console.log(pair[0] + ": " + pair[1]);
//  }
    }
})

}
function liberar_mesa() {
  $.post("../controller/ventas.php?op=liberar_mesa", { id_mesa: id_mesa }, function (data) {
    $.notify(data, "success");
    console.log(data);
    
  });
}
function desahabilitar_controles(flag) {
  if (flag == true) {
    $("#btn_guardar_venta").prop("disabled", true);
    $("#tipo_comprobante").prop("disabled", true);
    $("#nro_documento").prop("disabled", true);
    $("#btn_buscar_ruc_dni").prop("disabled", true);
    $("#modo_pago").prop("disabled", true);
  } else {
    $("#btn_guardar_venta").prop("disabled", false);
    $("#tipo_comprobante").prop("disabled", false);
    $("#nro_documento").prop("disabled", false);
    $("#btn_buscar_ruc_dni").prop("disabled", false);
    $("#modo_pago").prop("disabled", false);
  }
}
function validar_ingreso() {
  var tipo_comprobante = $("#tipo_comprobante").val();
  var nro_documento = $("#nro_documento").val();
  var modo_pago = $("#modo_pago").val();
  if (tipo_comprobante == 0) {
    $.notify("Seleccione el tipo de comprobante", "error");
    return false;
  }else if (nro_documento == "") {
    $.notify("Ingrese el numero de documento", "error");
    return false;
  }else if (modo_pago == 0) {
    $.notify("Seleccione el modo de pago", "error");
    return false;
  }else{
    guardar_venta();
  }
  

}
function open_pdf_prueba() {
  var url = "../controller/pdf_ticket.php";
  window.open(url, "_blank");
}

init();
