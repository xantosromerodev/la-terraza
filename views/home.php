<?php
 require 'header.php';
?>

<!-- libreria chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<main class="right_col" role="main">
    <!-- tarjetas -->
    <div class="row">
        <!-- total ventas -->
        <section class="col-md-4 mt-2">
            <div class="card shadow-sm">
                <div class="card-body bg-primary text-white">
                    <h5 class="card-title font-weight-bold text-start">Total ventas hoy</h5>
                    <h2 class="fw-bold h2 font-weight-bold text-right">350</h2>
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="fa fa-cutlery ft-icon"></i>
                        <p class="card-text h6">+5% más que ayer</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- dinero recaudado -->
        <section class="col-md-4 mt-2">
            <div class="card shadow-sm">
                <div class="card-body bg-success text-white">
                    <h5 class="card-title font-weight-bold">Total dinero hoy</h5>
                    <h2 class="fw-bold text-right h2 font-weight-bold">$1,530</h2>
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="fa fa-money ft-icon"></i>
                        <p class="card-text h6">+10% más que ayer</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- deliverys entregados -->
        <section class="col-md-4 mt-2">
            <div class="card shadow-sm">
                <div class="card-body bg-danger text-white">
                    <h5 class="card-title font-weight-bold">Total delivery hoy</h5>
                    <h2 class="fw-bold text-right h2 font-weight-bold">50</h2>
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="fa fa-motorcycle ft-icon"></i>
                        <p class="card-text h6">+3% más que ayer</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="row">
        <!-- grafico -->
        <section class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-bar-chart ft-dark-icon"> </i>
                    <span class="h6 text-body font-weight-bold ml-2">Ventas de la semana</span>
                </div>
                <div class="card-body">
                    <canvas id="pedidosChart"></canvas>
                </div>
            </div>
        </section>

        <!-- tabla ordenes -->
        <section class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-bell ft-dark-icon"></i> <span class="h6 text-body font-weight-bold ml-2">Ordenes
                        recientes</span>
                </div>
                <!-- tabla -->
                <table class="table table-hover">
                    <tbody>
                        <tr data-toggle="modal" data-target="#modalInfo">
                            <td><i class="fa fa-inbox"></i></td>
                            <td>Nueva orden solicitada</td>
                            <td>Hace un instante</td>
                        </tr>
                        <tr data-toggle="modal" data-target="#modalInfo">
                            <td><i class="fa fa-inbox"></i></td>
                            <td>Nueva orden solicitada</td>
                            <td>Hace 02 minutos</td>
                        </tr>
                        <tr data-toggle="modal" data-target="#modalInfo">
                            <td><i class="fa fa-inbox"></i></td>
                            <td>Nueva orden solicitada</td>
                            <td>Hace 03 minutos</td>
                        </tr>
                        <tr data-toggle="modal" data-target="#modalInfo">
                            <td><i class="fa fa-inbox"></i></td>
                            <td>Nueva orden solicitada</td>
                            <td>Hace 04 minutos</td>
                        </tr>
                        <tr data-toggle="modal" data-target="#modalInfo">
                            <td><i class="fa fa-inbox"></i></td>
                            <td>Nueva orden solicitada</td>
                            <td>Hace 05 minutos</td>
                        </tr>
                        <tr data-toggle="modal" data-target="#modalInfo">
                            <td><i class="fa fa-inbox"></i></td>
                            <td>Nueva orden solicitada</td>
                            <td>Hace 06 minutos</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- detalle ordenes -->
        <div class="modal" id="modalInfo">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title">Detalle de la orden</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Comanda</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Detalles</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>P001</td>
                                    <td>Yuquitas fritas</td>
                                    <td>2</td>
                                    <td>Bien fritas, con sal y para llevar.</td>
                                    <td><span class="badge badge-danger">Pendiente</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
        // Datos de pedidos
        var pedidosData = {
            labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
            datasets: [{
                label: 'Total de ventas ($)',
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