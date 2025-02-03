<?php
    require_once "../config/Conexion.php";

    class mesa{
        public function __construct(){
            
        }

        public function insertar($nombre){
            $sql = "call sp_crear_mesa('$nombre')";
            return ejecutarConsulta($sql);
        }

        public function editar($idmesa, $nombre){
            $sql = "call sp_actualizar_mesa('$idmesa', '$nombre')";
           // echo $sql;
            return ejecutarConsulta($sql);
        }

        public function eliminar($idmesa){
            $sql = "call sp_eliminar_mesa('$idmesa')";
            return ejecutarConsulta($sql);
        }

        public function mostrar($idmesa){
            $sql = "call sp_mostrar_filtro_mesa('$idmesa')";
            return ejecutarConsultaSimpleFila($sql);
        }

        public function listar(){
            $sql = "call sp_listar_mesa()";
            return ejecutarConsulta($sql);
        }
    }
?>