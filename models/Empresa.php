<?php
    require_once "../config/Conexion.php";

    class empresa{
        public function __construct(){
            
        }

        public function insertar($datos){
            $sql = "CALL SP_CREAR_EMPRESA(
            '$datos[0]', 
            '$datos[1]', 
            '$datos[2]', 
            '$datos[3]', 
            '$datos[4]', 
            '$datos[5]', 
            '$datos[6]',
            '$datos[7]',
            '$datos[8]',
            '$datos[9]',
            '$datos[10]',
            '$datos[11]',
            '$datos[12]',
            '$datos[13]'
            )";
            echo $sql;
            return ejecutarConsulta($sql);
        }

        public function editar($idempresa, $ruc, $nempresa, $domicilio, $celular, $correo, $logo){
            $sql = "call sp_modificar_empresa('$idempresa', '$ruc', '$nempresa', '$domicilio', '$celular', '$correo', '$logo')";
           //echo $sql;
            return ejecutarConsulta($sql);
        }

        public function eliminar($idempresa){
            $sql = "call sp_eliminar_empresa('$idempresa')";
            return ejecutarConsulta($sql);
        }

        public function mostrar($idempresa){
            $sql = "call sp_mostrar_empresa('$idempresa')";
            // echo ($sql);
            return ejecutarConsultaSimpleFila($sql);
        }

        public function listar(){
            $sql = "CALL SP_LISTAR_EMPRESA()";
            return ejecutarConsulta($sql);
        }
        public function obtener_region(){
            $sql = "CALL SP_OBTENER_REGION()";
            return ejecutarConsulta($sql);
        }
        public function obtener_ubigeo($idubigeo){
            $sql = "CALL SP_OBTENER_UBIGEO('$idubigeo')";
            return ejecutarConsultaSimpleFila($sql);
        }

    }
?>