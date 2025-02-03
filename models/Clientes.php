<?php
require '../config/Conexion.php';
class Clientes{

	public function __construct(){

	}
    public function insertar($datos){
        $sql="CALL SP_INSERTAR_CLIENTES('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]')";
        return ejecutarConsulta($sql);
    }
    public function obtener_tipo_doc_cont(){
        $sql="CALL SP_OBTENER_TIPO_DOC_CONT()";
        return ejecutarConsulta($sql);
    }

}

?>