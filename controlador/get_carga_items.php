<?php 
    session_start();
    require_once("../configuracion/database.php");
    require_once("../modelo/app_model.php");
    $data = new app_model();
    $id = $_POST['id'];
    $items = $data->get_carga_items($id,$_SESSION['perfil']);
    if ($items!="") {
        echo $items[0]['id']."|".$items[0]['estado']."|".$items[0]['ruta']."|".$items[0]['unico']."|".$items[0]['docs'];
    } else {
        echo "";
    }
?>