<?php
    require_once("../configuracion/database.php");
    require_once("../modelo/app_model.php");
    date_default_timezone_set("America/Lima");
    $carga = new app_model();
    $fecha_carga = date("Y-m-d");
    $hora_carga = date("H:i:s");
    $titulo = $_POST['titulo'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $proyecto = $_POST['proyecto'];
    $id = $_POST['id'];
    $id_sub = $_POST['id_sub'];
    $cat_carga = $_POST['cat_carga'];
    $subcat_carga = $_POST['subcat_carga'];
    $id_usuario = $_POST['id_usuario'];
    $fecha_upload="";
    $ruta="";
    $confirm=1;
    $error_extension=0;

    $docs = $carga->document_confirm(1,$cat_carga);
    if($subcat_carga!=""){$docs = $carga->document_confirm(2,$subcat_carga);}

    if($subcat_carga==""){
        if($carga->get_subcat($cat_carga)!=null){
            $confirm=0;
        }
        $subcat_carga=0;
    }

    if ($fecha!='') {
        $f_parts = explode("/", $fecha);
        $fecha_carga = $f_parts[2].'-'.$f_parts[1].'-'.$f_parts[0];
        $fecha_upload = $f_parts[2].$f_parts[1].$f_parts[0];
    }

    $proyecto_nombre = $carga->get_nombre_campana($proyecto);
    $ruta1 = strtoupper($proyecto_nombre[0]['descripcion']);
    
    if ($confirm==1) {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $file = $_FILES['archivo']['name'];
            if ($file!='') {
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $alias = pathinfo($file,  PATHINFO_FILENAME);
                if($docs[0]['docs']==1 && $extension=='mp3'){$error_extension=1;}
                if($docs[0]['docs']==0 && $extension!='mp3'){$error_extension=1;}

                if ($error_extension==0) {
                    if (!is_dir("../phocadownload/userupload/".$ruta1."/")) {
                        mkdir("../phocadownload/userupload/".$ruta1."/", 0777);
                        if (!is_dir("../phocadownload/userupload/".$ruta1."/".$fecha_upload."/")) {
                            mkdir("../phocadownload/userupload/".$ruta1."/".$fecha_upload."/", 0777);
                            $ruta="../phocadownload/userupload/".$ruta1."/".$fecha_upload."/";
                            $ruta_x="/web/phocadownload/userupload/".$ruta1."/".$fecha_upload."/";
                        }
                    } else {
                        if (!is_dir("../phocadownload/userupload/".$ruta1."/".$fecha_upload."/")) {
                            mkdir("../phocadownload/userupload/".$ruta1."/".$fecha_upload."/", 0777);
                            $ruta="../phocadownload/userupload/".$ruta1."/".$fecha_upload."/";
                            $ruta_x="/web/phocadownload/userupload/".$ruta1."/".$fecha_upload."/";
                        } else {
                            $ruta="../phocadownload/userupload/".$ruta1."/".$fecha_upload."/";
                            $ruta_x="/web/phocadownload/userupload/".$ruta1."/".$fecha_upload."/";
                        }
                    }

                    if (!file_exists($ruta.$file)) {
                        if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta.$file)) {
                            if ($docs[0]['docs']==0) {
                                $carga->set_file($proyecto, $cat_carga, $fecha_carga, $titulo, $alias, $ruta_x.$file, $ruta_x.$file, $subcat_carga, 1, $id_usuario, $descripcion);
                            } else {
                                $carga->set_file($proyecto, $cat_carga, $fecha_carga, $titulo, $alias, $ruta_x.$file, '', $subcat_carga, 0, $id_usuario, $descripcion);
                            }
                            echo "Exito";
                        }
                    } else {
                        echo "Existe";
                    }
                } else {
                    echo "Error_Extension";
                }
            } else {
                echo "Error";
            }
        } else {
            throw new Exception("Error Processing Request", 1);
        }
    } else {
        echo "Error_Cat";
    }
?>