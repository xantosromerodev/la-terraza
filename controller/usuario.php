<?php
ob_start();
if (strlen(session_id()) < 1){
	session_start();//Validamos si existe o no la sesión
}
require_once '../models/Usuario.php';
$usuario = new Usuario();

$id_user = isset($_POST["id_user"]) ? limpiarCadena($_POST["id_user"]) : "";
$dni_user = isset($_POST["dni_user"]) ? limpiarCadena($_POST["dni_user"]) : "";
$nombre_user = isset($_POST["nombre_user"]) ? limpiarCadena($_POST["nombre_user"]) : "";
$correo_user = isset($_POST["correo_user"]) ? limpiarCadena($_POST["correo_user"]) : "";
$celular_user = isset($_POST["celular_user"]) ? limpiarCadena($_POST["celular_user"]) : "";
$direccion_user = isset($_POST["direccion_user"]) ? limpiarCadena($_POST["direccion_user"]) : "";
$rol_user = isset($_POST["rol_user"]) ? limpiarCadena($_POST["rol_user"]) : "";
$contraseña_user = isset($_POST["contraseña_user"]) ? limpiarCadena($_POST["contraseña_user"]) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($id_user)) {
            $data=array(
                "0"=>$dni_user,
                "1"=>$nombre_user,
                "2"=>$correo_user,
                "3"=>$celular_user,
                "4"=>$direccion_user,
                "5"=>$rol_user,
                "6"=>$contraseña_user
            );
           
            $respuesta = $usuario->insertar($data);
            echo $respuesta ? "Usuario registrado" : "Usuario no se pudo registrar";
        } else {
            $data=array(
                "0"=>$id_user,
                "1"=>$dni_user,
                "2"=>$nombre_user,
                "3"=>$correo_user,
                "4"=>$celular_user,
                "5"=>$direccion_user,
                "6"=>$rol_user,
                "7"=>$contraseña_user
            );
            $respuesta = $usuario->actualizar($data);
            echo $respuesta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
        }
        break;
    case 'eliminar':
        $respuesta = $usuario->eliminar($id_user);
        echo $respuesta ? "Usuario eliminado" : "Usuario no se pudo eliminar";
        break;
    case 'mostrar':
        $respuesta = $usuario->mostrar($id_user);
        echo json_encode($respuesta);
        break;
    case 'listar':
        $respuesta = $usuario->listar();
        $data = Array();
        while ($reg = $respuesta->fetch_object()) {
            $data[] = array(
                "0" => $reg->nro,
                "1" => $reg->dni,
                "2" => $reg->nombre_ape,
                "3" => $reg->correo,
                "4" => $reg->celular,
                "5" => $reg->direccion,
                "6" => $reg->rol,
                "7" => '<span class="badge badge-primary  text-center"><a style="color:white;cursor:pointer"  onclick="mostrar('.$reg->id.')"><i class="fa fa-edit"></i></a></span>'." ".
                    '<span class="badge badge-danger  text-center"><a style="color:white;cursor:pointer"  onclick="eliminar('.$reg->id.')"><i class="fa fa-trash" aria-hidden="true"></i></a></span>'
            );
        }
        $results = array(
            "sEcho" => 1, //Informacion para el datatables
            "iTotalRecords" => count($data), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;
    case 'selectPerfil':
        $respuesta = $usuario->obtener_perfil();
        echo '<option value="0">Seleccione</option>';
        while ($reg = $respuesta->fetch_object()) {
            echo '<option value=' . $reg->id . '>' . $reg->nombre . '</option>';
        }
        break;
        case 'login':
            $dni = isset($_POST["dni"]) ? limpiarCadena($_POST["dni"]) : "";
            $clave = isset($_POST["password"]) ? limpiarCadena($_POST["password"]) : "";
            $respuesta = $usuario->login($dni, $clave);
            $fetch = $respuesta->fetch_object();
            if (isset($fetch)) {
                $_SESSION['id'] = $fetch->id;
                $_SESSION['dni'] = $fetch->dni;
                $_SESSION['nombre'] = $fetch->nombre_ape;
                $_SESSION['email'] = $fetch->correo;
                $_SESSION['rol'] = $fetch->rol;
            }
            echo json_encode($fetch);
            break;
        case 'salir':
		//Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");

	break;
    ob_end_flush();
    }