$(document).ready(function() {
    $.ajax({
        url: "ticket.php",
        method: "GET",
        dataType: "json",
        success: function(data) {
            if (data.error) {
                alert(data.error);
                return;
            }

            let ticketText = "\n📜 TICKET DE COMPRA\n";
            ticketText += "Fecha: " + data[0].fecha + "\n";
            ticketText += "Cliente: " + data[0].cliente + "\n";
            ticketText += "----------------------\n";
            ticketText += "CANT  PRODUCTO   PRECIO\n";

            let total = 0;
            data.forEach(producto => {
                let line = `${producto.cantidad}x ${producto.nombre}  $${producto.precio}\n`;
                ticketText += line;
                total += producto.precio * producto.cantidad;
            });

            ticketText += "----------------------\n";
            ticketText += "Total: $" + total.toFixed(2) + "\n";
            ticketText += "----------------------\n";
            ticketText += "Gracias por su compra!\n";

            // Botón de impresión con RawBT
            $("<button>")
                .text("🖨️ Imprimir Ticket")
                .click(function() {
                    let rawBTURL = "intent://com.rawbt.printconsole#Intent;scheme=rawbt;package=com.rawbt.client;S.text=" + encodeURIComponent(ticketText) + ";end;";
                    window.location.href = rawBTURL;
                })
                .appendTo("body");
        }
    });
});
