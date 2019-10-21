<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $user = new usuario_model();
    $id = $_POST['id'];
    $opt = $_GET['opt'];
    $user->cambia_estado($id,$opt);
?>