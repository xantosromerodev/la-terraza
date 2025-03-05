<?php
    require_once "../config/Conexion.php";

    class Home{
        public function __construct(){
            
        }
        public function total_ventas_hoy(){
            $sql = "CALL SP_TOTAL_VENTAS_HOY()";
            return ejecutarConsultaSimpleFila($sql);
        }
        public function total_dinero_hoy(){
            $sql = "CALL SP_TOTAL_DINERO_HOY()";
            return ejecutarConsultaSimpleFila($sql);
        }
        public function total_delivery_hoy(){
            $sql = "CALL SP_TOTAL_DELIVERY_HOY()";
            return ejecutarConsultaSimpleFila($sql);
        }
    }
?>