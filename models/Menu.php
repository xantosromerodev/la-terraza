<?php
    require_once "../config/Conexion.php";

    class menu{
        public function __construct(){
            
        }

        public function insertar($nombre, $precio, $idcategoria){
            $sql = "call sp_crear_menu('$nombre', '$precio', '', '$idcategoria')";
           // // echo $sql;
            return ejecutarConsulta($sql);
        }

        public function editar($idmenu, $nombre, $precio, $idcategoria){
            $sql = "call sp_actualizar_menu('$idmenu', '$nombre', '$precio', '$idcategoria')";
          // echo $sql;
            return ejecutarConsulta($sql);
        }

        public function eliminar($idmenu){
            $sql = "call sp_eliminar_menu('$idmenu')";
            return ejecutarConsulta($sql);
        }

        public function mostrar($idmenu){
            $sql = "call sp_mostrar_menu('$idmenu')";
            return ejecutarConsultaSimpleFila($sql);
        }

        public function listar(){
            $sql = "call sp_listar_menu()";
            return ejecutarConsulta($sql);
        }

        public function llenarLista(){
            $sql = "call sp_llenar_lista_categoria_menu()";
            return ejecutarConsulta($sql);
        }
    }
?>