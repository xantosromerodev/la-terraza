    <?php
require '../models/Perfil.php';

 $id_prfile=isset($_POST['id_profile'])?limpiarCadena($_POST['id_profile']):"";
 $nombre_prfile=isset($_POST['nombre_profile'])?limpiarCadena($_POST['nombre_profile']):"";
 $perfil=new Perfil();
 
 switch($_GET['op']){
    case 'guardar':
        if(empty($id_prfile)){
            $rpta=$perfil->insertar($nombre_prfile);
            echo $rpta ?"Perfil Registrado":"Ocurrio un error al registrar";
        }else{
            $rpta=$perfil->editar($id_prfile,$nombre_prfile);
            echo $rpta ?"Perfil Actualizado":"Ocurrio un error al actualizar";
        }
    break;
    case 'mostrar':
        $rpta=$perfil->mostrar($id_prfile);
        echo json_encode($rpta);
    break;
    case 'eliminar':
        $rpta=$perfil->eliminar($id_prfile);
        echo $rpta ?"Perfil Eliminado":"Ocurrio un error al eliminar";
        break;
    case 'listar':
        $rpta=$perfil->listar();
        $data=array();
        while($reg=$rpta->fetch_object()){
            $data[]=array(
                "0"=>$reg->nro,
                "1"=>$reg->nombre,
                "2"=>'<span class="badge badge-primary  text-center"><a style="color:white;cursor:pointer"  onclick="mostrar('.$reg->id.')"><i class="fa fa-edit"></i></a></span>'." ".
                    '<span class="badge badge-danger  text-center"><a style="color:white;cursor:pointer"  onclick="eliminar('.$reg->id.')"><i class="fa fa-trash" aria-hidden="true"></i></a></span>'

            );
        }
        $results=array(
            "sEcho"=>1,
            "iTotalRecords"=>count($data),
            "iTotalDisplayRecords"=>count($data),
            "aaData"=>$data
        );
        echo json_encode($results);
    break;
 }
 ?>