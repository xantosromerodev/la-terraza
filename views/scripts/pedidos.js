var tabla;
function init() {
  mostrar_mesas();
  obtener_categoria_menu();
//refrescar_pagina();
 // listar_mesas();
}

// function imprimirTicket() {
//   const contenidoTicket = `
//     <pre>
//     ********* TICKET *********
//     Producto: Pan
//     Precio: $20.00
//     Fecha: sicha
//     </pre>
//   `;

//   // Abrir la ventana de impresión
//   const ventana = window.open("", "", "width=600,height=600");
//   ventana.document.write(contenidoTicket);
//   ventana.document.close();
//   ventana.print();
// }

function imprimirMesa(codigo) {
  // $.ajax({
  // url:url,
  // type:"POST",
  // dataType:"json",
  // data:{id:codigo},
  // success:function(datas){
  // datas.detalles.cantidad="["+datas.detalles.cantidad+"]";

  // var JSONString = JSON.stringify(datas.detalles);
  //FOR PRINT A CADENA OF OBJETS
  //  var json = JSON.parse(JSONString);
  console.log("sicha");
  

  var commandsToPrint1 =
    "<BOLD><CENTER>TU MEJOR OPCION<BR>" +
    "<CENTER>SICHA SOFT<BR>" +
    "<BOLD><CENTER>11111111<BR>" +
    "<BOLD><CENTER>NUMERO<BR>" +
    "<BOLD><CENTER>001<BR>" +
    "<BOLD>  SICHA ROMAN<BR>" +
    "<NORMAL>  MESA: 12<BR>" +
    "<BOLD>  FECHA EMISIÓN: " +
    "<NORMAL>02-02-2025<BR>";

  var commandsToPrint2 = "";
  var commandsToPrint21 = "";
  var commandsToPrint22 = "";
  var commandsToPrint23 = "";

  var separacion =
    "  ----------------------------------------------<BR>" +
    "<BOLD>   [CANT.] DESCRIPCIÓN              P/U  TOTAL<BR>";

  commandsToPrint3 = "";

  //  $.each(json, function(i,item){

  //    //agregar parametro
  //    if(quitar_codigoItem == 'NO'){
  // 		var product = " ["+item.cantidad+" "+item.unidadmedi+"] "+item.codigo+" "+item.descripcion;
  //    }else{
  //    		var product = " ["+item.cantidad+" "+item.unidadmedi+"]  "+item.descripcion;
  //    }

  //    //var product = "  ["+item.cantidad+" "+item.unidadmedi+"] "+""+" "+item.descripcion
  //    var montos =  verMonto(item.valor_unitario)+" "+verMonto(item.subtotal)

  //    // console.log(montos)
  //    var total = 45;

  //       var cantItem = Number(product.length)
  //       var mon = Number(montos.toString().length);
  //       var falta = total - (cantItem + mon)
  //       var espacios = '';

  //       for (var i = 0; i < falta; i++) {
  //          espacios = espacios + ' '
  //       }

  //       commandsToPrint3 +=product.substring(0,34)+" "+espacios+montos+"<BR>";

  //  });
  commandsToPrint3 = "PRUEBA DEMO 1<BR>";

  var commandsToPrint4 =
    "  ----------------------------------------------<BR>" +
    "<CENTER><BOLD>¡PRUEBA!<BR>";

  var commandsToPrint5 =
    "<BR>" + "<BR>" + "<BR>" + "<BR>\n" + "<CUT>\n" + "<DRAWER>\n";

  var textEncoded1 = encodeURI(commandsToPrint1);
  var textEncoded2 = encodeURI(commandsToPrint2);
  commandsToPrint21 = encodeURI(commandsToPrint21);
  commandsToPrint22 = encodeURI(commandsToPrint22);
  commandsToPrint23 = encodeURI(commandsToPrint23);
  var separacion = encodeURI(separacion);
  var textEncoded3 = encodeURI(commandsToPrint3);
  var textEncoded4 = encodeURI(commandsToPrint4);
  var textEncoded5 = encodeURI(commandsToPrint5);

  // window.location.href ="intent://" +    textEncoded1 +    textEncoded2 +    commandsToPrint21 +
  //   commandsToPrint22 +
  //   commandsToPrint23 +
  //   separacion +
  //   textEncoded3 +
  //   textEncoded4 +
  //   textEncoded5 +
  //   "#Intent;scheme=quickprinter;package=pe.diegoveloper.printerserverapp;end;";

  window.location.href = "intent://" + textEncoded1 +  "#Intent;scheme=quickprinter;package=pe.diegoveloper.printerserverapp;end;";
  // }
  // });
}

function open_modal_pedidos(id_mesa,mesa) {

  $("#modal_pedidos").modal("show");

  $("#id_mesa").val(id_mesa);
   $("#mesa_select").html(mesa);

  limpiarTabla();
}


function obtener_categoria_menu() {
  $.ajax({
    url: "../controller/pedidos.php?op=mostrar_categoria_menu",
    type: "POST",
    success: function (data) {
      jsonData = JSON.parse(data);
     
      for (var i = 0; i < jsonData.length; i++) {
        console.log(jsonData[i].nombre);
        console.log(jsonData[i].id);
        $("#lcategorias_m").append(
          '<a  style="cursor:pointer"  onclick="obtener_menu(' +
          jsonData[i].id +
          ')" class="list-group-item list-group-item-action">' +
          jsonData[i].nombre +
          "</a>"
        );
      }
    },
  });
}
function mostrar_mesas() {
  $.ajax({
    url: "../controller/pedidos.php?op=mostrar_mesas",
    type: "POST",
    success: function (data) {
      jsonData = JSON.parse(data);
     
      for (var i = 0; i < jsonData.length; i++) {
        console.log(jsonData[i].numero);
        $("#lmesas").append(
          "<button class='btn btn-success p-2'>" +
          jsonData[i].numero +
          "</button>"
        );
      }
    },
  });
}
var cont = 0;
var detalles = 0;
function obtener_menu(categoria) {
  $.ajax({
    url: "../controller/pedidos.php?op=mostrar_menu",
    type: "POST",
    data: { idcategoria: categoria },
    success: function (data) {
      jsonData = JSON.parse(data);

      limpiarTabla();
      for (var i = 0; i < jsonData.length; i++) {
        var mensaje = jsonData[i].nombre;
        var menu = jsonData[i].menu;
        if (typeof mensaje === "undefined") {
          mensaje = jsonData[i].msm;
          menu = "0.00";
        } else {
          mensaje = jsonData[i].nombre;
          menu = jsonData[i].menu;
        }

        var nueva_fila = `<tr class="filas" id="fila" ${cont}>
        <td>
        ${mensaje}
        </td>
        <td>
        ${menu}
        </td>
        <td><button class="btn btn-success" onclick="agregar_detalle(${jsonData[i].id}, '${jsonData[i].nombre}',${jsonData[i].menu});"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
        </tr>`;
        cont++;

        $("#tb_menu").append(nueva_fila);
      }
    },
  });
}
function limpiarTabla() {
  $("#tb_menu tbody").empty();
  
}
cont_detalle=0;
detalle_detalle=0;

function agregar_detalle(idmenu, menu, precio) {
  
  var cantidad = 1;
  importe = cantidad * precio;
  var nueva_fila = `<tr class="filas" id="fila_detalle '${cont_detalle}'">
        <td><input class="form-control form-control-sm" type="text" name="cantidad[]" id="cantidad" value="${cantidad}"></td>
        <td><input class="form-control form-control-sm" type="hidden" name="idmenu[]" value="${idmenu}">${menu}</td>
        <td><input class="form-control form-control-sm"  type="text" name="precio_venta[]" id="precio_venta" value="${precio.toFixed(2)}"></td>
        <td><input class="form-control form-control-sm"  type="text" name="total[]" id="total[]" value="${importe.toFixed(2)}"></td>
        <td><button type="button"  class="btn btn-danger btn-sm" onclick="eliminarDetalle(${cont_detalle})"> <i class="fa fa-times" aria-hidden="true"></i></button></td>
        
        </tr>`;
  cont_detalle++;
  detalle_detalle=detalle_detalle+1;
  $("#tb_detalle").append(nueva_fila);
  $.notify("Pedido Agregado","success")
  calcular_totales();
}

function eliminarDetalle(indice) {
	$("#fila_detalle"+indice).remove();
	calcularTotales();
	detalle_detalle=detalle_detalle-1;
}

$(document).on("keyup", "#cantidad", function () {
  calcular_totales();
});
$(document).on("keyup", "#precio_venta", function () {
  calcular_totales();
});
function calcular_totales() {
  var cant = document.getElementsByName("cantidad[]");
  var prec = document.getElementsByName("precio_venta[]");
  var tot = document.getElementsByName("total[]");

  for (var i = 0; i < cant.length; i++) {
    var cantidad = cant[i];
    var precio = prec[i];
    var total = tot[i];

    total.value = cantidad.value * precio.value;
    console.log("total gravad" + " " + total.value);
    parseFloat((document.getElementsByName("total[]")[i].value = total.value));
  }
  calcularTotales();
}
function calcularTotales() {
  var tot = document.getElementsByName("total[]");
  var total = 0.0;

  for (var i = 0; i < tot.length; i++) {
    total += parseFloat(document.getElementsByName("total[]")[i].value);
  }
 
  $("#lbl_total").val(total.toFixed(2));
}





$("#btn_comandar").on("click",function(e){
  e.preventDefault();
  conectar();
  // imprimirMesa('12');
  // insertar_pedido();
});

function insertar_pedido(){
  var formData = new FormData($("#form_detalle")[0]);
  $.ajax({
    url: "../controller/pedidos.php?op=insertar_pedido",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      $.notify(datos, "success");
      reset_form();
      cambiar_estado();
      limpiar();
      location.reload();
      
    },
  });
}
function cambiar_estado(){
 var id_mesa= $("#id_mesa").val();
$.post(
  "../controller/pedidos.php?op=actualizar_estado",
  { id_mesa: id_mesa },
  function (data, status) {
    if (data != null) {
      console.log(data)
      $("#dropdownMenuButton").addClass("btn-danger");
    }
  }
);
}
function obtener_idpedido(mesa_id,mesa){
	 $("#id_mesa").val(mesa_id);
	 $("#mesa_select").html(mesa);
	console.log("id obrenido " +mesa_id);
	$.post("../controller/pedidos.php?op=obtener_id_pedido",{id_mesa:mesa_id},
	function(data, status){
		console.log(data);
		jsonPedido=JSON.parse(data);
		console.log(jsonPedido)
		$("#modal_pedidos").modal("show");
		console.log(jsonPedido.id_pedido)
		$("#id_pedido").val(jsonPedido.id_pedido);
		
	})
}
function reset_form(){
  $("#form_detalle").get(0).reset(); 
  $("#tb_detalle tbody").empty();
  $("#mesa_name").text("")
}
function pedido_cabecera(id_mesa){

	$.post("../controller/pedidos.php?op=pedido_cabecera",{id_mesa:id_mesa},
	function(data, status){
   dataJson=JSON.parse(data);
   console.log(dataJson);
	$(".subtotal").html("S/. " + dataJson.total);
  $("#id_fecha").html(dataJson.fecha);
		/*dataJson=JSON.parse(data);
		
	
		//$("#subtotal").html(dataJson.total);
	 console.log(dataJson)
   */
	})
}
cont_2=0;
function mostrar_modalDetalle(id_mesa,mesa){
	$("#tb_detalle_pedido tbody").empty();
	pedido_cabecera(id_mesa)
  $("#mesa_select").html(mesa);
  $("#mesa_name").html(mesa)
 $.ajax({
    url: "../controller/pedidos.php?op=listar_pedido",
    type: "POST",
    data: {id_mesa:id_mesa},
    success: function (datos) {
      console.log("detalle" +datos)
    	var dataJson=JSON.parse(datos)
      console.log(dataJson)
    for(var i=0; i<dataJson.length;i++){
    	//console.log(dataJson[i][4])
      var nueva_fila = `<tr class="filas" id="filas_1 ${cont_2}">
        <td>${dataJson[i][0]}</td>
        <td>${dataJson[i][1]}</td>
        <td>${dataJson[i][2]}</td>
        <td>${dataJson[i][3]}</td>
      
        
        </tr>`

         cont_2++;
 // detalles++;
  $("#tb_detalle_pedido").append(nueva_fila);
    }
    },
  });
  
  $("#modal_detalle_pedidos").modal('show');
  
}
function refrescar_pagina(){
  setInterval(function () {
   location.reload();
  }, 5000);
}
function limpiar(){
document.getElementById("mesa_select").innerHTML='Sin Seleccionar';
	
}


init();
