<?php

require_once "../config/Conexion.php";

class Datos_Comprobante {
    public function __construct(){
      
    }
    public function obtener_empresa(){
        $sql="CALL SP_OBTENER_EMPRESA()";
        return ejecutarConsultaSimpleFila($sql);

    }
}
?>