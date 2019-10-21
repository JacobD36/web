<?php 
    session_start();
    require_once("../configuracion/database.php");
    require_once("../modelo/app_model.php");
    $m_audio = new app_model();
    $proyecto = $_POST['proy'];
    $res = $m_audio->migra_audios($proyecto);
    echo $res;
?>