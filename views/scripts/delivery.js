var tabla;
var idMesa=0;
var nom_mesa="";
var total_a_pagar=0;
var mesa="";
function init() {


  //obtener_detalle_pedido()

  //obtener_categoria_menu();
//refrescar_pagina();
 // listar_mesas();
}
var cont = 0;
var detalles = 0;

function limpiarTabla() {
  $("#tb_menu tbody").empty();
  
}
cont_detalle=0;
detalle_detalle_1=0;
cont_detalle_dlivery=0;

function agregar_detalle_delivery(idmenu, menu, precio) {
  
  var cantidad = 1;
  importe = cantidad * precio;
  var nueva_fila = `<tr class="filas" id="fila_detalle ${cont_detalle_dlivery}">
        <td><input class="form-control form-control-sm" type="text" name="cantidad_d[]" id="cantidad_d" value="${cantidad}"></td>
        <td><input class="form-control form-control-sm" type="hidden" name="idmenu_d[]" value="${idmenu}">${menu}</td>
        <td><input class="form-control form-control-sm"  type="text" name="precio_venta_d[]" id="precio_venta_d" value="${precio}"></td>
        <td><input class="form-control form-control-sm"  type="text" name="total_d[]" id="total_d[]" value="${importe.toFixed(2)}"></td>
        <td><button type="button" id="delete_fila"  class="btn btn-danger btn-sm"> <i class="fa fa-times" aria-hidden="true"></i></button></td>
        
        </tr>`;
        cont_detalle_dlivery++;

  $("#tb_detalle_delivery").append(nueva_fila);
  $.notify("Pedido Agregado","success")
  calcular_totales_delivery();
}


$('#tb_detalle_delivery').on('click', '#delete_fila', function() {
  $(this).closest('tr').remove();
  calcular_totales_delivery();
});



// para delivery calculos
$(document).on("keyup", "#cantidad_d", function () {
  calcular_totales_delivery();
});
$(document).on("keyup", "#precio_venta_d", function () {
  calcular_totales_delivery();
});
// fin-----

function calcular_totales_delivery() {
  var cant = document.getElementsByName("cantidad_d[]");
  var prec = document.getElementsByName("precio_venta_d[]");
  var tot = document.getElementsByName("total_d[]");

  for (var i = 0; i < cant.length; i++) {
    var cantidad = cant[i];
    var precio = prec[i];
    var total = tot[i];

    total.value = cantidad.value * precio.value;
    console.log("total gravad" + " " + total.value);
    parseFloat((document.getElementsByName("total_d[]")[i].value = total.value));
  }
  calcularTotales_delivery();
}

function calcularTotales_delivery() {
  var tot = document.getElementsByName("total_d[]");
  var total = 0.0;

  for (var i = 0; i < tot.length; i++) {
    total += parseFloat(document.getElementsByName("total_d[]")[i].value);
  }
 
  $("#lbl_total_del").val(total.toFixed(2));
}




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
      obtener_detalle_pedido();
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
   total_a_pagar=dataJson.total;
	$(".subtotal").html("S/. " + dataJson.total);
  $("#id_fecha").html(dataJson.fecha);
		/*dataJson=JSON.parse(data);
		
	
		//$("#subtotal").html(dataJson.total);
	 console.log(dataJson)
   */
	})
}
cont_2=0;



// funcion para obtener las subacategorias
$("#producto").autocomplete({
  
  source: function (request, response) {

    $.ajax({
      url: "../controller/pedidos.php?op=auto_complete_menu",
      type: "GET",
      dataType: "JSON",
      success: function (data) {
        console.log(data);
        aData = $.map(data, function (value, key) {
          return {
            label: value.nombre,
            idc: value.id,
            descripcion: value.nombre,
            precio: value.precio,
          };
        });
        var result = $.ui.autocomplete.filter(aData, request.term);
        response(result);
      },
    });
  },
  select: function (event, ui) {
    agregar_detalle_delivery(ui.item.idc,ui.item.descripcion,ui.item.precio);
    setTimeout(function () {
      $("#producto").val("");
    }, 500);
    console.log(ui.item.precio);
  },
});
// funciones para craer ticket de pedidos
function obtener_cabecra_pedido(){
  $.post("../controller/pedidos.php?op=obtener_pedido_cabecera",
    function(data,status){
      dataJson=JSON.parse(data);
      mesa=dataJson.numero;
      console.log(dataJson);
    }
  )
}

function obtener_detalle_pedido(){
  $.post("../controller/pedidos.php?op=obtener_pedido_detalle",
    function(data,status){
      dataJson=JSON.parse(data);
      console.log(dataJson);
      let $pre=$("<pre>").appendTo($("body"));

      let ticketText ="     "+ mesa + "\n";
               
                ticketText += "----------------------\n";
                ticketText += "CANT       DESCRIPCION   \n";
             for (var i = 0; i < dataJson.length; i++) {
               let line=` ${dataJson[i][0]}       ${dataJson[i][1]} \n`;
               ticketText += line;
             }
             $pre.text(ticketText);
                console.log(ticketText);
              imprimirTicket(ticketText);
    }
  )
}
function imprimirTicket(ticketText) {
  var S = "#Intent;scheme=rawbt;";
  var P =  "package=ru.a402d.rawbtprinter;end;";
  var textEncoded = encodeURI(ticketText);
   window.location.href="intent:"+textEncoded+S+P;
}
init();
