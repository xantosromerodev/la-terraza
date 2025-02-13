<?php
 require 'header.php';
?>

<!-- libreria chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.ft-icon {
    font-size: 25px;
}

.ft-dark-icon {
    font-size: 20px;
    color: #333;
}
</style>


<main class="right_col" role="main">
    <!-- tarjetas -->
    <div class="row">
        <!-- pedidos completados -->
        <div class="col-md-4 mt-2">
            <div class="card shadow-sm">
                <div class="card-body bg-primary text-white">
                    <h5 class="card-title font-weight-bold text-start">Pedidos completados</h5>
                    <h2 class="fw-bold h2 font-weight-bold text-right">350</h2>
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="fa fa-cutlery ft-icon"></i>
                        <p class="card-text h6">+5% más que ayer</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- dinero recaudado -->
        <div class="col-md-4 mt-2">
            <div class="card shadow-sm">
                <div class="card-body bg-success text-white">
                    <h5 class="card-title font-weight-bold">Dinero recaudado</h5>
                    <h2 class="fw-bold text-right h2 font-weight-bold">$1,530</h2>
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="fa fa-money ft-icon"></i>
                        <p class="card-text h6">+10% más que ayer</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- deliverys entregados -->
        <div class="col-md-4 mt-2">
            <div class="card shadow-sm">
                <div class="card-body bg-danger text-white">
                    <h5 class="card-title font-weight-bold">Delivery entregados</h5>
                    <h2 class="fw-bold text-right h2 font-weight-bold">50</h2>
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="fa fa-motorcycle ft-icon"></i>
                        <p class="card-text h6">+3% más que ayer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- grafico -->
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-bar-chart ft-dark-icon"> </i>
                    <span class="h6 text-body font-weight-bold ml-2">Seguimiento de pedidos</span>
                </div>
                <div class="card-body">
                    <canvas id="pedidosChart"></canvas>
                </div>
            </div>
        </div>
        <!-- notificaciones -->
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header d-flex">
                    <i class="fa fa-bell ft-dark-icon"></i> <span class="h6 text-body font-weight-bold ml-2">Notificaciones</span>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center text-body">
                        <i class="fa fa-inbox"></i> Pedido entregado
                        <span class="text-body">Hace 1 minuto</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center text-body">
                        <i class="fa fa-inbox"></i> Pedido entregado
                        <span class="text-body">Hace 2 minutos</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center text-body">
                        <i class="fa fa-inbox"></i> Delivery entregado
                        <span class="text-body">Hace 5 minutos</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center text-body">
                        <i class="fa fa-inbox"></i> Delivery entregado
                        <span class="text-body">Hace 7 minutos</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center text-body">
                        <i class="fa fa-inbox"></i> Pedido entregado
                        <span class="text-body">Hace 10 minutos</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center text-body">
                        <i class="fa fa-inbox"></i> Pedido entregado
                        <span class="text-body">Hace 15 minutos</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
    // Datos de pedidos
    var pedidosData = {
        labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
        datasets: [{
            label: 'Total ($)',
            data: [150, 200, 180, 220, 250, 300, 190], // Ventas de cada día
            backgroundColor: 'rgba(0, 123, 255, 0.8)', // Color de las barras
            borderColor: 'rgba(0, 123, 255, 1)', // Color del borde
            borderWidth: 1
        }]
    };

    // Opciones del gráfico
    var pedidosOptions = {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 50
                }
            }
        }
    };

    // Crear gráfico
    var ctx = document.getElementById('pedidosChart').getContext('2d');
    var pedidosChart = new Chart(ctx, {
        type: 'bar', // Tipo de gráfico (barras)
        data: pedidosData,
        options: pedidosOptions
    });
    </script>


    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>

</main>
<?php
 include '../views/footer.php';
?>