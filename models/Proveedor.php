<?php
require '../config/Conexion.php';
class Proveedor{
 public function __construct(){

 }
 function llenar_combo_documento(){
  $sql="CALL SP_OBTENER_TIPO_DOC_CONT()";
  return ejecutarConsulta($sql);
 }
 function listar(){
  $sql="CALL   SP_LISTAR_PROVEEDOR()";
  return ejecutarConsulta($sql);
 }
 function insertar($datos){
  $sql="CALL SP_INSERTAR_PROVEEDOR('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]')";
  //echo $sql;
  return ejecutarConsulta($sql);
 }
 function mostrar($idproveedor){
  $sql="CALL SP_MOSTRAR_PROVEEDOR('$idproveedor')";
  return ejecutarConsultaSimpleFila($sql);
 }
 function editar($datos){
  $sql="CALL SP_ACTUALIZAR_PROVEEDOR('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]')";
  return ejecutarConsulta($sql);
 }
 function eliminar($idproveedor){
  $sql="CALL SP_ELIMINAR_PROVEEDOR('$idproveedor')";
  return ejecutarConsulta($sql);
 }
 function verificar_existencia($num_doc){
    $sql="SELECT * FROM proveedor WHERE  nro_documento='$num_doc'";
    return ejecutarConsulta($sql);
}

}
?>