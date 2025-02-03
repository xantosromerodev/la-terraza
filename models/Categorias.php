<?php
    require_once "../config/Conexion.php";

    class categoria{
        public function __construct(){
            
        }

        public function insertar($nombre){
            $sql = "call sp_crear_categoria_menu('$nombre')";
            return ejecutarConsulta($sql);
        }

        public function editar($idcategoria, $nombre){
            $sql = "call sp_actualizar_categoria_menu('$idcategoria', '$nombre')";
           // echo $sql;
            return ejecutarConsulta($sql);
        }

        public function eliminar($idcategoria){
            $sql = "call sp_eliminar_categoria_menu('$idcategoria')";
            return ejecutarConsulta($sql);
        }

        public function mostrar($idcategoria){
            $sql = "call sp_mostrar_categoria_menu('$idcategoria')";
            return ejecutarConsultaSimpleFila($sql);
        }

        public function listar(){
            $sql = "call sp_listar_categoria_menu()";
            return ejecutarConsulta($sql);
        }
    }
?>