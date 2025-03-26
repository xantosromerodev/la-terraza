var tabla;
var idMesa=0;
var nom_mesa="";
var total_a_pagar=0;
var mesa="";
function init() {
  listar_subcategorias_del(2);

  //obtener_detalle_pedido()

  //obtener_categoria_menu();
//refrescar_pagina();
 // listar_mesas();
}
var cont = 0;
var detalles = 0;

function limpiarTabla_() {
  $("#tb_menu_delivery tbody").empty();
  
}
cont_detalle=0;
detalle_detalle_1=0;
cont_detalle_dlivery=0;




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





$("#btn_enviar_pedido").on("click",function(e){
  e.preventDefault();

  // imprimirMesa('12');
  insertar_pedido_();
  //imprimirTicket();
});
function limpiarTabla() {
  $("#tb_menu tbody").empty();
  
}
function reset_form(){
  $("#frm_delivery").get(0).reset(); 
  $("#tb_detalle tbody").empty();
  $("#mesa_name").text("")
}
function insertar_pedido_(){
  var formData = new FormData($("#frm_delivery")[0]);
  $.ajax({
    url: "../controller/delivery.php?op=insertar_pedido",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      console.log("delivery " +datos);
      $.notify(datos, "success");
      generar_ticket();
      reset_form();
      cambiar_estado_();
      limpiar();
      //location.reload();
      
    },
  });
}
function cambiar_estado_(){
$.post(
  "../controller/delivery.php?op=actualizar_estado",
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
  $("#tb_detalle_delivery tbody").empty();
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

// funciones para craer ticket de pedidos
/*
function obtener_cabecra_pedido(){
  $.post("../controller/pedidos.php?op=obtener_pedido_cabecera",
    function(data,status){
      dataJson=JSON.parse(data);
      mesa=dataJson.numero;
      console.log(dataJson);
    }
  )
}
*/
function generar_ticket(){
  $.post("../controller/pedidos.php?op=obtener_pedido_detalle",
    function(data,status){
      dataJson=JSON.parse(data);
      console.log(dataJson);
      let $pre=$("<pre>").appendTo($("body"));

      let ticketText ="     "+ mesa + "\n";
               
                ticketText += "----------------------\n";
                ticketText += "CANT       DESCRIPCION   \n";
             for (var i = 0; i < dataJson.length; i++) {
               let line=` ${dataJson[i][0]}         ${dataJson[i][1]} \n`;
               ticketText += line;
             }
            // $pre.text(ticketText);
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
$("#btn_agregar_menu").on("click",function(e){
  e.preventDefault();
  $("#modal_pedidos_delivery").modal("show");
 
})
$("#btn_platillos_dl").on("click",function(e){
  e.preventDefault();
   $("#lcategorias_m_delivery").empty();
   listar_subcategorias_del(2);
});
$("#btn_bebidas_del").on("click", function (e) {
  e.preventDefault();
    $("#lcategorias_m_delivery").empty();
    listar_subcategorias_del(1);
});
function listar_subcategorias_del(id_categoria) {
  $.ajax({
    url: "../controller/pedidos.php?op=listar_subcategorias",
    type: "POST",
    data: { idcategoria: id_categoria },
    success: function (data, status) {
     // console.log(data);
      dataJson = JSON.parse(data);
      for(var i=0; i<dataJson.length;i++){
        console.log(dataJson[i])
         $("#lcategorias_m_delivery").append(
           '<a  style="cursor:pointer"  onclick="obtener_menu_(' +
             dataJson[i].id +
             ')" class="list-group-item list-group-item-action">' +
             dataJson[i].nombre +
             "</a>"
         );
      }
    },
  });
}
function obtener_menu_(categoria) {
  $.ajax({
    url: "../controller/pedidos.php?op=mostrar_menu",
    type: "POST",
    data: { idcategoria: categoria },
    success: function (data) {
      jsonData = JSON.parse(data);

      limpiarTabla_();
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
        <td><button class="btn btn-success" onclick="agregar_detalle_delivery(${jsonData[i].id}, '${jsonData[i].nombre}',${jsonData[i].menu});"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
        </tr>`;
        cont++;

        $("#tb_menu_delivery").append(nueva_fila);
      }
    },
  });
}
function agregar_detalle_delivery(idmenu, menu, precio) {
  
  var cantidad = 1;
  importe = cantidad * precio;
  var nueva_fila = `<tr class="filas" id="fila_detalle ${cont_detalle}">
        <td><input class="form-control form-control-sm" type="text" name="cantidad_[]" id="cantidad_" value="${cantidad}"></td>
        <td><input class="form-control form-control-sm" type="hidden" name="idmenu_[]" value="${idmenu}">${menu}</td>
        <td><input class="form-control form-control-sm"  type="text" name="precio_venta_[]" id="precio_venta_" value="${precio.toFixed(2)}"></td>
        <td><input class="form-control form-control-sm"  type="text" name="total_[]" id="total_[]" value="${importe.toFixed(2)}"></td>
        <td><button type="button" id="del"  class="btn btn-danger btn-sm"> <i class="fa fa-times" aria-hidden="true"></i></button></td>
        
        </tr>`;
  cont_detalle++;
  detalle_detalle_1=detalle_detalle_1+1;
  $("#tb_detalle_delivery").append(nueva_fila);
  $.notify("Pedido Agregado","success")
  calcular_totales_();
}
$(document).ready(function() {
  // Evento click para el botón de eliminar
  $('#tb_detalle_delivery').on('click', '#del', function() {
      $(this).closest('tr').remove();
      calcular_totales_();
  });
});
function calcular_totales_() {
  var cant = document.getElementsByName("cantidad_[]");
  var prec = document.getElementsByName("precio_venta_[]");
  var tot = document.getElementsByName("total_[]");

  for (var i = 0; i < cant.length; i++) {
    var cantidad = cant[i];
    var precio = prec[i];
    var total = tot[i];

    total.value = cantidad.value * precio.value;
    console.log("total gravad" + " " + total.value);
    parseFloat((document.getElementsByName("total_[]")[i].value = total.value));
  }
  calcularTotales_();
}

function calcularTotales_() {
  var tot = document.getElementsByName("total_[]");
  var total = 0.0;

  for (var i = 0; i < tot.length; i++) {
    total += parseFloat(document.getElementsByName("total_[]")[i].value);
  }
 
  $("#lbl_total_").val(total.toFixed(2));
}

$(document).on("keyup", "#cantidad_", function () {
  calcular_totales_();
});
$(document).on("keyup", "#precio_venta_", function () {
  calcular_totales_();
});

init();
