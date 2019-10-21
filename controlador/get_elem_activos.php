<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/app_model.php");
    require_once("../modelo/usuario_model.php");
    $new_data = new app_model();
    $usr = new usuario_model();
    $filtro1 = $_GET['filtro1'];
    $filtro2 = $_GET['filtro2'];
    $filtro3 = $_GET['filtro3'];
    $proyecto = $_GET['proy'];
    $tipo="";
    $elem = $new_data->get_all_audios($filtro1,$filtro2,$filtro3,$proyecto);
    if ($elem!=null) {
        foreach ($elem as $lista) {
            $extension = strtolower(pathinfo($lista['filename'], PATHINFO_EXTENSION));
            if ($extension=='mp3') {
                $tipo="<span class='label label-success'>AUDIO</span>";
            } else {
                if ($extension=='pdf' || $extension=='xlsx' || $extension=='xls' || $extension=='csv' || $extension=='docx' || $extension=='doc') {
                    $tipo="<span class='label label-default'>DOCUMENTO</span>";
                } else {
                    $tipo="<span class='label label-primary'>OTROS</span>";
                }
            }
            $fecha = explode("-",$lista['fecha_audio']);
            $fecha_carga = $fecha[2]."/".$fecha[1]."/".$fecha[0];
            $usr_name = $usr->get_username($lista['id_usuario']);
            $campana = $new_data->get_nombre_campana($lista['id_campana']);
            $cat = $new_data->get_nombre_categoria($lista['id_menu']);
            $arreglo["data"][] = array($lista['title'],$campana[0]['descripcion'],$tipo,$cat[0]['descripcion'],$fecha_carga,$lista['estado'],$usr_name[0]['codusuario']);
        }
    } else {
        $arreglo["data"][] = array('SIN REGISTROS','','');
    }
    echo json_encode($arreglo,JSON_UNESCAPED_UNICODE|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_ERROR_UTF8|JSON_ERROR_RECURSION);
?>