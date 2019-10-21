<?php
    $nombre= $_GET['nombre'];
    //$enlace ='../phocadownload/'.$nombre;
    $enlace = $nombre;
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($enlace).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($enlace));
    readfile($enlace);
    exit;
?>