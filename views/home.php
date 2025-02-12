<?php
 require 'header.php';
?>

<style>
.ft-icon {
    font-size: 25px;
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
        <div class="col-md-6">

        </div>
        <!-- notificaciones -->
        <div class="col-md-6">

        </div>
    </div>


</main>
<?php
 include '../views/footer.php';
?>