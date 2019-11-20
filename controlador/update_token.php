<?php 
    require_once("../configuracion/database.php");
    $stmt = database::conexion()->prepare("truncate table bayental_app.audios;");
    $stmt->execute();
?>