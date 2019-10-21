<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $persona = new usuario_model();
    $num_camp = $_POST['num_camp'];
    $nombre1 = strtoupper($_POST['nombre1']);
    $nombre2 = strtoupper($_POST['nombre2']);
    $apellido1 = strtoupper($_POST['apellido1']);
    $apellido2 = strtoupper($_POST['apellido2']);
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $dni = $_POST['dni'];
    $perfil = $_POST['perfil'];
    $super_adm = $_POST['super_adm'];
    $camp_list = $_POST['campana_list'];
    $cont_camp = $_POST['cont_camp'];

    if ($nombre1!="" && $apellido1!="" && $apellido2!="" && $password1!="" && $password2!="" && $dni!="" && $perfil!="" && $cont_camp!=0) {
        if ($password1==$password2) {
            echo $persona->set_new_user($nombre1, $nombre2, $apellido1, $apellido2, $dni, $perfil, $super_adm, $password1, $camp_list, $num_camp);
        }
    }
?>