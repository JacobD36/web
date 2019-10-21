<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $persona = new usuario_model();
    $num_camp = $_POST['num_camp'];
    $id_usuario = $_POST['id_usuario'];
    $id_persona = $_POST['id_persona'];
    $nombre1 = strtoupper($_POST['nombre1']);
    $nombre2 = strtoupper($_POST['nombre2']);
    $apellido1 = strtoupper($_POST['apellido1']);
    $apellido2 = strtoupper($_POST['apellido2']);
    $dni = $_POST['dni'];
    $perfil = $_POST['perfil'];
    $super_adm = $_POST['super_adm'];
    $camp_list = $_POST['campana_list'];
    $cont_camp = $_POST['cont_camp'];

    if ($nombre1!="" && $apellido1!="" && $apellido2!="" && $dni!="" && $perfil!="" && $cont_camp!=0) {
        $persona->update_user($id_usuario,$id_persona,$nombre1,$nombre2,$apellido1,$apellido2,$dni,$perfil,$super_adm);
        $persona->clear_acceso($id_usuario);
        for($i=0;$i<=($num_camp-1);$i++){
            //$persona->set_acceso($id_usuario,($i+1),$camp_list[$i]);
            $persona->set_acceso($id_usuario,$camp_list[$i]);
        }
    }
?>