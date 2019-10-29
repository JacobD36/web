<?php
    $nombre= $_GET['nombre'];
    $nombre1 = explode("/",$nombre);
    $nombre2 = "..";
    for($i=2;$i<=(count($nombre1)-1);$i++){
		$nombre2.="/".$nombre1[$i];
	}
    //$enlace ='../phocadownload/userupload/'.$nombre1;
    $enlace = $nombre2;
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