var tabla;
var idMesa = 0;
var nom_mesa = "";
var total_a_pagar = 0;
var mesa = "";
function init() {
  mostrar_mesas();
  listar_subcategorias(2);
  //obtener_cabecra_pedido();
  //obtener_detalle_pedido()
  $("#ticket").hide();
  //obtener_categoria_menu();
  //refrescar_pagina();
  // listar_mesas();
}
$("#btn_imprimir_deta").on("click", function (e) {
  e.preventDefault();
  imprimirTicket_cuenta(idMesa);
  //imprimirTicket_cuenta_categoria(idMesa,1)
  //imprimirMesa("")


});
function imprimirTicket_cuenta(id_mesa) {
  console.log("imprimirTicket_cuenta " + id_mesa);
  $.post("../controller/pedidos.php?op=listar_pedido", { id_mesa: id_mesa },
    function (data, status) {
      let $pre = $("<pre>").appendTo("body");
      jsonData = JSON.parse(data);
      console.log(jsonData)

      let ticketText = "";
      ticketText += "--------------------------------------------------\n"
      ticketText += "          " + nom_mesa + "              \n"
      ticketText += "-----------------------------------------------\n";
      ticketText += "CANT.  DESCRIPCION                   PRECIO  IMPORTE\n";
      let total = 0;
      jsonData.forEach(element => {
        let descripcionFormateada = element[1];
        if (descripcionFormateada.length > 30) {
          descripcionFormateada = descripcionFormateada.substring(0, 27) + '...'; // Limitar longitud de la descripción
        }
        importe = element[0] * element[2];
        let line = ` ${element[0].toString().padEnd(4)}${descripcionFormateada.padEnd(30)}${element[2].padStart(7)}${importe.toFixed(2).padStart(7)} \n`;
        ticketText += line;
        total += element[0] * element[2];
      });
      ticketText += "----------------------\n";
      ticketText += "Total: $" + total.toFixed(2) + "\n";
      ticketText += "----------------------\n";
      // $pre.text(ticketText);
      console.log(ticketText);
      imprimirTicket_c(ticketText)
    }
  )
  /*
   let ticket="";
     $.ajax({
       url: "../controller/pedidos.php?op=listar_pedido",
       type: "POST",
       data: { id_mesa: id_mesa },
       success: function (datos) {
        dataJson = JSON.parse(datos);
         ticket+=
        `<h3 style="text-align:center; margin-bottom:0px">${nom_mesa}</h3> 
        <table style="width:100%; font-size:12px;padding:0px;margin:0px;">
        <thead>
        <th  style="width:5%">Cant</th>
         <th align="left" >Descripción</th>
         <th style="width:5%">Precio</th>
          <th style="width:5%">Importe</th>
        </thead>
        </table>  `;
         dataJson.forEach(element => {
          ticket+= 
          `<table  style="width:100%; font-size:12px;padding:1px;margin:0px;">
            <tr style="padding:2px;"> 
            <td  align="center" style="width:5%">  ${element[0]}</td>
             <td align="left">${element[1]}</td>
             <td  style="width:7%">${element[2]}</td>
            <td  style="width:7%">${element[3]}</td>
            </tr>
           
          </table>`;
        
         });
         ticket+= `TOTAL A PAGAR S/.${total_a_pagar}`
         let preTag = document.getElementById("ticket");
         preTag.textContent = ticket;
  
         // Ajustar tamaño del ticket en pantalla
         preTag.style.fontFamily = "Consolas, monospace";
         preTag.style.fontSize = "14px";
         preTag.style.padding = "0px";
         preTag.style.border = "1px solid black";
         preTag.style.backgroundColor = "#f8f8f8";
         preTag.style.width = "280px"; // Ajustar ancho del ticket
         preTag.style.whiteSpace = "pre-wrap";
  
         let printWindow = window.open('', '', 'width=280,height=600');
  
         // Definir tamaño de página al imprimir
         let customStyle = `
             <style>
                 @page { 
                     size: 80mm 200mm; /* Ancho de ticket de 80mm y altura dinámica */
  /*        margin: 0;
      }
      pre {
          font-size: 14px;
          px;
          width: 280px;
          font-family: Consolas, monospace;
          padding: 5px;
      }
  </style>
`;
   printWindow.document.write(customStyle + '<pre>' + ticket + '</pre>');
   printWindow.document.close();
   printWindow.print();
   printWindow.close();
 
}
});
*/
}
function imprimirTicket_cuenta_categoria(id_mesa, id_categoria) {
  console.log("imprimirTicket_cuenta " + id_mesa);
  $.post("../controller/pedidos.php?op=listar_pedido_detalle_categoria", { id_mesa: id_mesa, id_cate: id_categoria },
    function (data, status) {
      let $pre = $("<pre>").appendTo("body");
      jsonData = JSON.parse(data);
      console.log(jsonData)

      let ticketText = "";
      ticketText += "--------------------------------------------------\n"
      ticketText += "          " + nom_mesa + "              \n"
      ticketText += "-----------------------------------------------\n";
      ticketText += "CANT.  DESCRIPCION                   PRECIO  IMPORTE\n";
      let total = 0;
      jsonData.forEach(element => {
        let descripcionFormateada = element[1];
        if (descripcionFormateada.length > 30) {
          descripcionFormateada = descripcionFormateada.substring(0, 27) + '...'; // Limitar longitud de la descripción
        }
        importe = element[0] * element[2];
        let line = ` ${element[0].toString().padEnd(4)}${descripcionFormateada.padEnd(30)}${element[2].padStart(7)}${importe.toFixed(2).padStart(7)} \n`;
        ticketText += line;
        total += element[0] * element[2];
      });
      ticketText += "----------------------\n";
      ticketText += "Total: $" + total.toFixed(2) + "\n";
      ticketText += "----------------------\n";
      // $pre.text(ticketText);
      console.log(ticketText);
      imprimirTicket_c(ticketText)
    }
  )

}
function imprimirTicket_c(ticketText) {
  var S = "#Intent;scheme=rawbt;";
  var P = "package=ru.a402d.rawbtprinter;end;";
  var textEncoded = encodeURI(ticketText);
  window.location.href = "intent:" + textEncoded + S + P;
}

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
  console.log(commandsToPrint1);
  // window.location.href = "intent://" + textEncoded1 +  "#Intent;scheme=quickprinter;package=pe.diegoveloper.printerserverapp;end;";
  // }
  // });
}

function open_modal_pedidos(id_mesa, mesa) {

  $("#modal_pedidos").modal("show");

  $("#id_mesa").val(id_mesa);
  $("#mesa_select").html(mesa);

  limpiarTabla();
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
  console.log("categoria");
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
cont_detalle = 0;
detalle_detalle_1 = 0;
cont_detalle_dlivery = 0;
function agregar_detalle(idmenu, menu, precio) {

  var cantidad = 1;
  importe = cantidad * precio;
  var nueva_fila = `<tr class="filas" id="fila_detalle ${cont_detalle}">
        <td><input class="form-control form-control-sm" type="text" name="cantidad[]" id="cantidad" value="${cantidad}"></td>
        <td><input class="form-control form-control-sm" type="hidden" name="idmenu[]" value="${idmenu}">${menu}
        </td>
        <td><input class="form-control form-control-sm"  type="text" name="precio_venta[]" id="precio_venta" value="${precio.toFixed(2)}"></td>
        <td><input class="form-control form-control-sm"  type="text" name="total[]" id="total[]" value="${importe.toFixed(2)}"></td>
        <td><button type="button" id="del"  class="btn btn-danger btn-sm"> <i class="fa fa-times" aria-hidden="true"></i></button></td>
        
        </tr>
        
        `;
  cont_detalle++;
  detalle_detalle_1 = detalle_detalle_1 + 1;
  $("#tb_detalle").append(nueva_fila);
  $.notify("Pedido Agregado", "success")
  calcular_totales();
}


$(document).ready(function () {
  // Evento click para el botón de eliminar
  $('#tb_detalle').on('click', '#del', function () {
    $(this).closest('tr').remove();
    calcular_totales();
  });
});


$(document).on("keyup", "#cantidad", function () {
  calcular_totales();
});
$(document).on("keyup", "#precio_venta", function () {
  calcular_totales();
});

// para delivery calculos

// fin-----
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


$("#btn_comandar").on("click", function (e) {
  e.preventDefault();

  // imprimirMesa('12');
  insertar_pedido();
  //imprimirTicket();
});

function insertar_pedido() {
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
      $("#mdl_print").modal("show");
      

      
      limpiar();
      // location.reload();

    },
  });
}
function cambiar_estado() {
  var id_mesa = $("#id_mesa").val();
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
$("#btn_cocina").on("click", function (e) {
  generar_ticket_pedido(2)
});
$("#btn_print_bebidas").on("click", function (e) {
  generar_ticket_pedido(1)
});
function close_print_pedido(){
  $("#mdl_print").modal("hide");
  location.reload();
}

function obtener_idpedido(mesa_id, mesa) {
  $("#id_mesa").val(mesa_id);
  $("#mesa_select").html(mesa);
  console.log("id obrenido " + mesa_id);
  $.post("../controller/pedidos.php?op=obtener_id_pedido", { id_mesa: mesa_id },
    function (data, status) {
      console.log(data);
      jsonPedido = JSON.parse(data);
      console.log(jsonPedido)
      $("#modal_pedidos").modal("show");
      console.log(jsonPedido.id_pedido)
      $("#id_pedido").val(jsonPedido.id_pedido);

    })
}
function reset_form() {
  $("#form_detalle").get(0).reset();
  $("#tb_detalle tbody").empty();
  $("#mesa_name").text("")
}
function pedido_cabecera(id_mesa) {

  $.post("../controller/pedidos.php?op=pedido_cabecera", { id_mesa: id_mesa },
    function (data, status) {
      dataJson = JSON.parse(data);
      console.log(dataJson);
      total_a_pagar = dataJson.total;
      $(".subtotal").html("S/. " + dataJson.total);
      $("#id_fecha").html(dataJson.fecha);
      /*dataJson=JSON.parse(data);
    	
  	
      //$("#subtotal").html(dataJson.total);
     console.log(dataJson)
     */
    })
}
cont_2 = 0;
function mostrar_modalDetalle(id_mesa, mesa) {

  idMesa = id_mesa;
  $("#tb_detalle_pedido tbody").empty();
  pedido_cabecera(id_mesa)
  nom_mesa = mesa;
  $("#mesa_select").html(mesa);
  $("#mesa_name").html(mesa)
  $.ajax({
    url: "../controller/pedidos.php?op=listar_pedido",
    type: "POST",
    data: { id_mesa: id_mesa },
    success: function (datos) {
      console.log("detalle" + datos)
      var dataJson = JSON.parse(datos)
      console.log(dataJson)
      for (var i = 0; i < dataJson.length; i++) {
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
function refrescar_pagina() {
  setInterval(function () {
    location.reload();
  }, 5000);
}
function limpiar() {
  document.getElementById("mesa_select").innerHTML = 'Sin Seleccionar';

}
$("#btn_platillos").on("click", function (e) {
  e.preventDefault();
  $("#lcategorias_m").empty();
  listar_subcategorias(2);
});
$("#btn_bebidas").on("click", function (e) {
  e.preventDefault();
  $("#lcategorias_m").empty();
  listar_subcategorias(1);
});

// funcion para obtener las subacategorias
function listar_subcategorias(id_categoria) {
  $.ajax({
    url: "../controller/pedidos.php?op=listar_subcategorias",
    type: "POST",
    data: { idcategoria: id_categoria },
    success: function (data, status) {
      // console.log(data);
      dataJson = JSON.parse(data);
      for (var i = 0; i < dataJson.length; i++) {
        console.log(dataJson[i])
        $("#lcategorias_m").append(
          '<a  style="cursor:pointer"  onclick="obtener_menu(' +
          dataJson[i].id +
          ')" class="list-group-item list-group-item-action">' +
          dataJson[i].nombre +
          "</a>"
        );
      }
    },
  });
}
// funcion para autocompletar menus

// funciones para craer ticket de pedidos


function generar_ticket_pedido(idcate) {
  var id_pedido = $("#id_pedido").val();
  obtener_cabecra_pedido(id_pedido);
  $.post("../controller/pedidos.php?op=obtener_pedido_detalle", { id_pedido: id_pedido, idcate: idcate },
    function (data, status) {
      dataJson = JSON.parse(data);
      console.log(dataJson);

      let $pre = $("<pre>").appendTo($("body"));

      let ticketText = "     " + mesa + "\n";

      ticketText += "----------------------\n";
      ticketText += "CANT       DESCRIPCION   \n";
      for (var i = 0; i < dataJson.length; i++) {
        let line = ` ${dataJson[i][0]}          ${dataJson[i][1]} \n`;
        ticketText += line;
      }
      //$pre.text(ticketText);
      console.log(ticketText);
      imprimirTicket_pedido(ticketText);
      
    }
  )
}
function imprimirTicket_pedido(ticketText) {
  var S = "#Intent;scheme=rawbt;";
  var P = "package=ru.a402d.rawbtprinter;end;";
  var textEncoded = encodeURI(ticketText);
  window.location.href = "intent:" + textEncoded + S + P;
}
function obtener_cabecra_pedido(id_pedido) {
  // console.log("id pedido obtenida " +id_pedido);
  $.post("../controller/pedidos.php?op=obtener_pedido_cabecera", { id_pedido: id_pedido },
    function (data, status) {
      dataJson = JSON.parse(data);
      mesa = dataJson.numero;

      console.log("mesa obtenida " + dataJson.numero);
    }
  )
}
init();
