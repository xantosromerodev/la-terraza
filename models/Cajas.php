<?php
require_once '../config/Conexion.php';
class Cajas{
    function __construct(){

    }
    function listar_caja(){
        $sql="CALL SP_LISTAR_CAJAS()";
        return ejecutarConsulta($sql);

    }  
    function insertar_caja($datos){
        $sql="CALL SP_INSERTAR_CAJA('$datos[0]','$datos[1]')";  
        return ejecutarConsulta($sql,$datos);
    }  
    function mostrar_caja($id){
        $sql="CALL SP_MOOSTRAR_CAJA('$id')";
       // echo $sql;
        return ejecutarConsultaSimpleFila($sql);
    }
    function editar_caja($datos){
        $sql="CALL SP_ACTUALIZAR_CAJA('$datos[0]','$datos[1]')";
        //echo $sql;
        return ejecutarConsulta($sql);
    }
}

?>