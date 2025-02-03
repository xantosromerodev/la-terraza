<?php
    require_once "../config/Conexion.php";

    class categoria{
        public function __construct(){
            
        }
        public function obtener_categorias(){
            $sql = "CALL SP_OBETENER_CATEGORIA_MENU_GENERAL()";
            return ejecutarConsulta($sql);
        }

        public function insertar($datos){
            $sql = "CALL SP_CREAR_CATEGORIA_MENU('$datos[0]','$datos[1]')";
            return ejecutarConsulta($sql);
        }

        public function editar($datos){
            $sql = "call sp_actualizar_categoria_menu('$datos[0]', '$datos[1]',$datos[2])";
            echo $sql;
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