<?php

require_once '../config/Conexion.php';
Class Perfil{
    public function __construct(){

    }
    public function insertar($nombre){
        $sql="CALL SP_INSERTAR_PERFIL('$nombre')";
        return ejecutarConsulta($sql);

    }
    public function editar($id, $nombre){
        $sql="CALL SP_ACTUALZAR_PERFIL('$id', '$nombre')";
     
        return ejecutarConsulta($sql);
    }
    public function mostrar($id){
        $sql="CALL SP_MOSTRAR_PERFIL('$id')";
        return ejecutarConsultaSimpleFila($sql);
    }
    public function listar(){
        $sql="CALL SP_LISTAR_PERFIL()";
        return ejecutarConsulta($sql);
    }
    public function eliminar($id){
        $sql="CALL SP_ELIMINAR_PERFIL('$id')";
        return ejecutarConsulta($sql);
    }
    

}
?>