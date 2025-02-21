function init() {
  mostrar_form(true);

  $.post("../controller/ingreso.php?op=selectTipoDoc", function (r) {
    console.log(r);
    $("#idTipoDoc").html(r);
    $("#idTipoDoc").selectpicker("refresh");
  });
}
function mostrar_form(flag) {
  if (flag == true) {
    $("#form_ingreso").show();
    $("#lista_ingreso").hide();
  } else {
    $("#form_ingreso").hide();
    $("#lista_ingreso").show();
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
      obtener_proveedor(num_doc)
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
              label: value.nombre+" STOCK= "+value.stock,
              idp: value.id,
              nombre_prod:value.nombre,
              stk_prod:value.stock,
              precio_prod:value.precio,
            };
          });
          var result = $.ui.autocomplete.filter(aData, request.term);
          response(result);
        },
      });
    },
    select: function (event, ui) {
      console.log("precio"+ui.item.precio_prod);
  
    agregarDetalle(ui.item.idp,ui.item.nombre_prod,ui.item.precio_prod);
  setTimeout(function () {
    $("#cod_prod").val("");
  }, 500);
     
    },
  });
  // agregar detalle de productos
  var cont=0;
var detalles=0;
  function agregarDetalle(idarticulo,articulo,precio_venta)
  {
  	var cantidad=1;
    if (idarticulo!="")
    {
    	var subtotal=cantidad*precio_venta;
	//	listar_igv();
    	var fila =
        '<tr class="filas" id="fila' +
        cont +
        '">' +
        '<td><input type="hidden" name="idarticulo[]" value="' +
        idarticulo +
        '">' +
        articulo +
        "</td>" +
        '<td><input type="number" class="form-control" name="cantidad[]" id="cantidad" value="' +
        cantidad +
        '"></td>' +
        '<td><input type="text" class="form-control" name="precio_venta[]" id="precio_venta"  value="' +
        precio_venta +
        '"></td>' +
        '<td><input type="text"class="form-control" name="total[]" id="total[]" value="' +
        subtotal +
        '"></td>' +
        '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' +
        cont +
        ')">X</button></td>' +
        "</tr>";
    	cont++;
    	detalles=detalles+1;
    	$('#detalles').append(fila);
    	calcular_totales();
		
    }
    else
    {
    	alert("Error al ingresar el detalle, revisar los datos del artículo");
    }
  }
  // function para calacular
  function calcular_totales()
  {
  	var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_venta[]");
    var tot = document.getElementsByName("total[]");

    for (var i = 0; i <cant.length; i++) {
    	var cantidad=cant[i];
    	var precio=prec[i];
    	var total=tot[i];
  
    	total.value=(cantidad.value * precio.value);
     // console.log("total gravad" + " "+ total.value)
    	document.getElementsByName("total[]")[i].value = total.value;
    }
   calcularTotales();

  }
  function calcularTotales(){
    var tot = document.getElementsByName("total[]");
    var total = 0.0;

    for (var i = 0; i <tot.length; i++) {
      total +=parseFloat(document.getElementsByName("total[]")[i].value) / 1.18;
  }


  $("#total_gravada").val(total.toFixed(2));
  // calculamos el igv y el totala a pagar
  var igv=0.18
  
  
var valor_igv= total*igv;
$("#total_igv").val(valor_igv.toFixed(2));
var valor_total_pagar=total+valor_igv;
  $("#total_a_pagar").val(valor_total_pagar.toFixed(2));
 // total_a_pagar = parseFloat(total_gravada)+parseFloat( igv);
  


 
}
init();
