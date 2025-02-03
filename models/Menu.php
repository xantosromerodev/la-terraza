<?php
    require_once "../config/Conexion.php";

    class menu{
        public function __construct(){
            
        }
        public function codigo_producto(){
            $sql="CALL SP_GENERAR_CODIGO_PRODUCTO()";
            return ejecutarConsultaSimpleFila($sql);

        }
        public function insertar($datos){
            $sql = "CALL SP_CREAR_MENU('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]')";
           // echo $sql;
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

        public function listar($id_cate){
            $sql = "call sp_listar_menu('$id_cate')";
            return ejecutarConsulta($sql);
        }

        public function llenarLista($id_cate){
            $sql = "call sp_llenar_lista_categoria_menu('$id_cate')";
            return ejecutarConsulta($sql);
        }
    }
?>