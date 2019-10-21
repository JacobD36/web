<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $data = new usuario_model();
    $nombre = $_GET['nombre'];
    $perfil = $_GET['perfil'];
    $elem = $data->get_all_users($nombre,$perfil);
    if ($elem!=null) {
        foreach ($elem as $lista) {
            $campanas = $data->get_all_user_campaign($lista['id']);
            $persona = $data->get_personal_info($lista['id']);
            $nombre = $persona[0]['nombre1']." ".$persona[0]['nombre2']." ".$persona[0]['apellido1']." ".$persona[0]['apellido2'];
            $perfil = $data->get_user_perfil($lista['idperfil']);
            if ($lista['estado']==0) {
                $btn_editar = "<a href='javascript:void(0)' style='text-decoration:none;'><button type='button' class='btn btn-success btn-sm' disabled><i class='glyphicon glyphicon-pencil'></i></button></a>";
                $btn_eliminar = "<a href='javascript:void(0)' style='text-decoration:none;'><button type='button' class='btn btn-success btn-sm' onclick='activa_usuario(".$lista['id'].")'><i class='glyphicon glyphicon-ok'></i></button></a>";
            } else {
                $btn_editar = "<a href='javascript:void(0)' data-toggle='modal' data-target='#myModal' onclick='edita_contacto(".$lista['id'].");' style='text-decoration:none;'><button type='button' class='btn btn-success btn-sm'><i class='glyphicon glyphicon-pencil'></i></button></a>";
                $btn_eliminar = "<a href='javascript:void(0)' style='text-decoration:none;'><button type='button' class='btn btn-danger btn-sm' onclick='desactiva_usuario(".$lista['id'].")'><i class='glyphicon glyphicon-ban-circle'></i></button></a>";
            }
            $arreglo["data"][] = array($nombre,$perfil[0]['descripcion'],$lista['codusuario'],$lista['estado'],$campanas,$btn_editar." ".$btn_eliminar);
        }
    } else {
        $arreglo["data"][] = array('SIN REGISTROS','','',3,'','');
    }
    echo json_encode($arreglo,JSON_UNESCAPED_UNICODE|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_ERROR_UTF8|JSON_ERROR_RECURSION);
?>