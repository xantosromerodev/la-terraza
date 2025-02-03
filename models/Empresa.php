<?php
    require_once "../config/Conexion.php";

    class empresa{
        public function __construct(){
            
        }

        public function insertar($ruc, $nempresa, $domicilio, $celular, $correo, $logo){
            $sql = "call sp_crear_empresa('$ruc', '$nempresa', '$domicilio', '$celular', '$correo', '$logo')";
            //echo $sql;
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
            $sql = "call sp_listar_empresa()";
            return ejecutarConsulta($sql);
        }

    }
?>