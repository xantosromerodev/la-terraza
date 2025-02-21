<?php

require_once "../config/Conexion.php";

class Ingreso {
    //Implementamos nuestro constructor
    public function __construct()
    {
    }
    function llenar_combo_documento(){
        $sql="CALL SP_OBTENER_TIPO_DOC_CONT()";
        return ejecutarConsulta($sql);
       }
       function obtener_proveedores($documento){
		$sql="SELECT
		idproveedor,
		cod_tipo_doc,
		nro_documento,
		razon_social,
		direccion,
		telefono,
		estado_sunat	
		 FROM proveedor WHERE nro_documento='$documento'";
		return ejecutarConsultaSimpleFila ($sql);
       }
public function obtener_menu_autocompletado($nombre){
 $sql="CALL SP_OBTENER_MENU_AUTOCOMPLETADO('$nombre')";
  return ejecutarConsulta($sql);
}
function autocomplet_Prov($nombre){
		$sql="select idproveedor,nro_documento,razon_social from  proveedor where nro_documento like '%$nombre%' or razon_social like '%$nombre%' ";
		return ejecutarConsulta($sql);
}
}

?>