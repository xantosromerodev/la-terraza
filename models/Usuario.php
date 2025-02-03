<?php
require_once '../config/Conexion.php';
class Usuario{
    public function __construct(){
    }
    
    public function listar(){
        $sql="CALL SP_LISTAR_USUARIOS()";
        return ejecutarConsulta($sql);
    }
    public function obtener_perfil(){
        $sql="CALL SP_PBTENER_PERFILES()";
       // echo $sql;
        return ejecutarConsulta($sql);
    }
    public function insertar($datos){
    $sql="CALL SP_INSERTAR_USUARIOS('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]')";
  //  echo $sql;
    return ejecutarConsulta($sql);
}
public function mostrar($id){
    $sql="CALL SP_MOSTRAR_USUARIOS('$id')";
    return ejecutarConsultaSimpleFila($sql);
}
public function actualizar($datos){
    $sql="CALL SP_ACTUALIZAR_USUARIOS('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]')";
    return ejecutarConsulta($sql);
} 
public function eliminar($id){
    $sql="CALL SP_ELIMINAR_USUARIOS('$id')";
    return ejecutarConsulta($sql);
}

//definimos la consulta para que el usuario se loguee
public function login($dni,$clave){
    $sql="CALL SP_LOGIN('$dni','$clave')";
    return ejecutarConsulta($sql);

}
}
?>