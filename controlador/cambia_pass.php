<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $user = new usuario_model();
    $password1 = $_POST['pass1'];
    $password2 = $_POST['pass2'];
    $codusuario = $_POST['codusuario'];

    if ($password1!="" && $password2!="") {
        if ($password1==$password2) {
            $user->actualiza_password($codusuario, $password1);
        }
    }
?>