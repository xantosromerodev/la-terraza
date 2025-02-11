<?php
 require 'header.php';
?>

<style>
.ft-icon {
    font-size: 25px;
}
</style>

<div class="right_col" role="main">
    <div class="row">
        <!-- total de pedidos -->
        <div class="col-md-4">
            <div class="card shadow-sm m-4">
                <div class="card-body bg-primary text-white">
                    <h5 class="card-title font-weight-bold">Total pedidos por mesa</h5>
                    <h2 class="fw-bold text-right h2 font-weight-bold">350</h2>
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="fa fa-cutlery ft-icon"></i>
                        <p class="card-text h6">+25% más que ayer</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- total recaudado -->
        <div class="col-md-4">
            <div class="card shadow-sm m-4">
                <div class="card-body bg-success text-white">
                    <h5 class="card-title font-weight-bold">Total dinero</h5>
                    <h2 class="fw-bold text-right h2 font-weight-bold">$1,530</h2>
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="fa fa-money ft-icon"></i>
                        <p class="card-text h6">+15% más que ayer</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- total de clientes -->
        <div class="col-md-4">
            <div class="card shadow-sm m-4">
                <div class="card-body bg-danger text-white">
                    <h5 class="card-title font-weight-bold">Total pedidos por delivery</h5>
                    <h2 class="fw-bold text-right h2 font-weight-bold">50</h2>
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="fa fa-motorcycle ft-icon"></i>
                        <p class="card-text h6">+5% más que ayer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
 include '../views/footer.php';
?>