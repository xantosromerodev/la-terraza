function init() {
  total_ventas_hoy();
  total_dinero_hoy();
  total_delivery_hoy();
}

function total_ventas_hoy() {
  $.post("../controller/home.php?op=total_ventas_hoy", function (data) {
        dataJson=JSON.parse(data);
        $("#total_ventas_hoy").html(dataJson.TOTAL);
    }
  );
}

function total_dinero_hoy() {
    $.post("../controller/home.php?op=total_dinero_hoy", function (data) {
        dataJson=JSON.parse(data);
        $("#total_dinero_hoy").html('S/. ' + dataJson.TOTAL_DINERO);
    }
  );
}

function total_delivery_hoy() {
    $.post("../controller/home.php?op=total_delivery_hoy", function (data) {
        dataJson=JSON.parse(data);
        $("#total_delivery_hoy").html(dataJson.TOTAL_DELIVERY);
    }
  );
}

init();
