var tabla;
function init() {
  $("form").keypress(function (e) {
    var key;
    if (window.event) key = window.event.keyCode; //IE
    else key = e.which; //firefox
    return key != 13;
  });
  mostrar_form(false);

  $.post("../controller/ingreso.php?op=selectTipoDoc", function (r) {
    console.log(r);
    $("#idTipoDoc").html(r);
    $("#idTipoDoc").selectpicker("refresh");
  });
  fecha_actual();
  listar();
}
function listar() {
  tabla = $("#tbllistado")
    .dataTable({
      bLengthChange: true,
      bDestroy: true,
      language: {
        search: "Buscar por",
        lengthMenu: "Mostrar _MENU_ Elementos",
        info: "Mostrando _START_ a _END_ de _TOTAL_ Elementos",
        infoEmpty: "Mostrando 0 registros de 0 registros encontrados",
        paginate: {
          next: "<span>Siguiente</span>",
          previous: "<span>Atras</span>",
        },
      },
      columnDefs: [{ visible: false }],
      responsive: true,
      searching: true,
      ajax: {
        url: "../controller/ingreso.php?op=listar",
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
    })
    .DataTable();
}
function mostrar_form(flag) {
  if (flag == true) {
    $("#form_ingreso").show();
    $("#lista_ingreso").hide();
    $("#btnagregar").hide();

    $("#btnGuardar").hide();
    $("#btnCancelar").show();
    detalles = 0;
  } else {
    $("#form_ingreso").hide();
    $("#lista_ingreso").show();
    $("#btnagregar").show();
  }
}
// buscar proveedor
$("#btn_buscar_ruc_dni").click(function () {
  var dni = $("#nro_documento").val();

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

  $("#exampleModal").modal("show");
});
// fin de la busqueda
// boton para guardar proveedor
$("#btn-guardar_prov").on("click", function () {
  guardaryeditarProv();
});
// metodo para guardar proveedor
function guardaryeditarProv() {
  //e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#frm_proveedor")[0]);
  $.ajax({
    url: "../controller/proveedor.php?op=guardar_proveedor",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      $.notify(datos, "success");
      $("#exampleModal").modal("hide");
      var num_doc = $("#nro_doc").val();
      obtener_proveedor(num_doc);
      console.log(num_doc);
    },
  });
}
//
// obtener datos de proveedor
function obtener_proveedor(nro_doc) {
  $.post(
    "../controller/ingreso.php?op=obtener_proveedor",
    { nro_doc: nro_doc },
    function (data, status) {
      console.log("num_doc.." + nro_doc);
      data = JSON.parse(data);
      console.log(data);

      $("#idproveedor").val(data.idproveedor);
      $("#nro_documento").val(data.nro_documento + "-" + data.razon_social);
      console.log(data.nro_documento + "-" + data.razon_social);
    }
  );
}
// autocompletar proveedor
$("#nro_documento").autocomplete({
  source: function (request, response) {
    $.ajax({
      url: "../controller/ingreso.php?op=autocompleteProveedor",
      type: "GET",
      dataType: "JSON",
      success: function (data) {
        console.log(data);
        aData = $.map(data, function (value, key) {
          return {
            label: value.nro_documento + "-" + value.razon_social,
            idprov: value.idproveedor,
          };
        });
        var result = $.ui.autocomplete.filter(aData, request.term);
        response(result);
      },
    });
  },
  select: function (event, ui) {
    $("#idproveedor").val(ui.item.idprov);
  },
});
// fin de autocompletar productos
$("#cod_prod").autocomplete({
  source: function (request, response) {
    $.ajax({
      url: "../controller/ingreso.php?op=autocomplete_producto",
      type: "GET",
      dataType: "JSON",
      success: function (data) {
        console.log(data);
        aData = $.map(data, function (value, key) {
          return {
            label: value.nombre + " STOCK= " + value.stock,
            idp: value.id,
            nombre_prod: value.nombre,
            stk_prod: value.stock,
            precio_prod: value.precio,
          };
        });
        var result = $.ui.autocomplete.filter(aData, request.term);
        response(result);
      },
    });
  },
  select: function (event, ui) {
    console.log("precio" + ui.item.precio_prod);

    agregarDetalle(ui.item.idp, ui.item.nombre_prod, ui.item.precio_prod);
    setTimeout(function () {
      $("#cod_prod").val("");
    }, 500);
  },
});
// agregar detalle de productos
var cont = 0;
var detalles = 0;
function agregarDetalle(idarticulo, articulo, precio_venta) {
  var cantidad = 1;
  if (idarticulo != "") {
    var subtotal = cantidad * precio_venta;
    // listar_igv();
    var fila =
      '<tr class="filas" id="fila' +
      cont +
      '">' +
      '<td><input type="text" class="form-control form-control-sm" name="cantidad[]" id="cantidad" value="' +
      cantidad +
      '"></td>' +
      '<td><input type="hidden" name="idarticulo[]" value="' +
      idarticulo +
      '">' +
      articulo +
      "</td>" +
      '<td><input type="text" class="form-control form-control-sm" name="precio_venta[]" id="precio_venta"  value="' +
      precio_venta +
      '"></td>' +
      '<td><input type="text"class="form-control form-control-sm" name="total[]" id="total[]" value="' +
      subtotal +
      '"></td>' +
      '<td><div class="form-group"><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' +
      cont +
      ')"><i class="fa fa-trash" aria-hidden="true"></i></button></div> </td>' +
      "</tr>";
    cont++;
    detalles = detalles + 1;
    $("#detalles").append(fila);
    calcular_totales();
  } else {
    alert("Error al ingresar el detalle, revisar los datos del artículo");
  }
}
$(document).on("keyup", "#cantidad", function () {
  calcular_totales();
});
$(document).on("keyup", "#precio_venta", function () {
  calcular_totales();
});
// function para calacular
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
  // total_a_pagar = parseFloat(total_gravada)+parseFloat( igv);
  evaluar();
}
function eliminarDetalle(indice) {
  $("#fila" + indice).remove();
  calcularTotales();
  detalles = detalles - 1;
  evaluar();
}
function evaluar() {
  if (detalles > 0) {
    $("#btnGuardar").show();
  } else {
    $("#btnGuardar").hide();
    cont = 0;
  }
}
function cancelarform() {
  limpiar();
  mostrar_form(false);
}
function limpiar() {
  $("#idproveedor").val("");
  $("#nro_documento").val("");
  $("#proveedor").val("");
  $("#serie_comprobante").val("");
  $("#num_comprobante").val("");
  $(".filas").remove();
  $("#total_compra").val("");
  $(".filas").remove();
  $("#total").html("0");

  //Obtenemos la fecha actual
  fecha_actual();

  //Marcamos el primer tipo_documento
  $("#tipo_comprobante").val("Boleta");
  $("#tipo_comprobante").selectpicker("refresh");
}
function fecha_actual() {
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = now.getFullYear() + "-" + month + "-" + day;
  $("#fecha_hora").val(today);
}
$("#btnGuardar").on("click", function () {
  guardaryeditar();
});
function guardaryeditar() {
  //	e.preventDefault(); //No se activará la acción predeterminada del evento
  //$("#btnGuardar").prop("disabled",true);
  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "../controller/ingreso.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      $.notify(datos, "success");
      console.log(datos);
      mostrar_form(false);
      listar();
    },
    error: function (datos) {
      console.log(datos);
    },
  });
  limpiar();
}
function abrir_detalle(idingreso) {
  $.post("../controller/ingreso.php?op=ingreso_cabecera",{idingreso:idingreso},
    function(data,status){
      dataJson=JSON.parse(data);
      $("#txt_proveedor").val(dataJson.proveedor);
      $("#txt_fecha").val(dataJson.fecha);
      $("#txt_tipo_comprobante").val(dataJson.tipo_comprobante);
      $("#txt_serie").val(dataJson.serie_comprobante);
      $("#txt_numero").val(dataJson.num_comprobante);
      $("#txt_total").val(dataJson.total_compra);
    }
  )
  detalle_ingreso(idingreso);
  $("#mdl_detalle_ingreso").modal("show");
}
function detalle_ingreso(idingreso){
  console.log(idingreso);
$.post("../controller/ingreso.php?op=ingreso_detalle",{idingreso:idingreso},
  function(data,status){
   dataJson=JSON.parse(data);
    console.log(dataJson);
    for(var i=0;i<dataJson.length;i++){
      var fila="<tr>"+
      "<td>"+dataJson[i][0]+"</td>"+
      "<td>"+dataJson[i][1]+"</td>"+
      "<td>"+dataJson[i][2]+"</td>"+
      "<td>"+dataJson[i][3]+"</td>"+
      "</tr>";
      $("#detalles_ingreso").append(fila);
    }
  }
)
}
init();
