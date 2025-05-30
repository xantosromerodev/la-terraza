var tabla;
function init() {
    listar();
    total_general_ventas();
    
    // Set current date as default for date inputs
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = now.getFullYear() + "-" + month + "-" + day;
  
  $("#fecha_inicial").val(today);
  $("#fecha_final").val(today);
}
$("#fecha_inicial, #fecha_final").change(function() {
  if ($("#fecha_inicial").val() && $("#fecha_final").val()) {
      listar();
  }
});
function listar() {
  var fecha_inicial = $("#fecha_inicial").val();
  var fecha_final = $("#fecha_final").val();
  
  if (!fecha_inicial || !fecha_final) {
      $.notify("Por favor seleccione ambas fechas", "error");
      return;
  }
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
          next: "<span ><i class='fa fa-arrow-right' aria-hidden='true'></span>",
          previous:
            "<span ><i class='fa fa-arrow-left' aria-hidden='true'></i></span>",
        },
      },
      ajax: {
        url: "../controller/ventas.php?op=reporte_por_fechas",
        data:{fecha_inicial:fecha_inicial,fecha_final:fecha_final},
        type: "get",
        dataType: "json",
        error: function (e) {
          //alert(fecha_inicial);
          console.log(e);
        },
      },
      responsive: true,
      searching: true,
    });
  }
  function open_pdf_prueba(idventa) {

    $("#pdf_container").attr( "src","../controller/enviar_sunat.php?idventa=" + idventa+"&op=imprime_ticket");
    $("#mdl_pdf").modal("show");
   /*var url = "../controller/enviar_sunat.php?idventa=" + idventa+"&op=imprime_ticket";
    window.open(url, "_blank");
    */
    
  }
  function cerrar_pdf() {
    $("#mdl_pdf").modal("hide");
    location.reload();
  }
  function total_general_ventas() {
    $.ajax({
      url: "../controller/ventas.php?op=total_general_ventas",
      type: "POST",
      dataType: "json",
      success: function (data) {
        $("#total_general").html("TOTAL VENTAS: S/."+" " +data.total);
      },
    });
  }
  
  init();