<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/app_model.php");
    $new_data = new app_model();
    $proyecto = $_GET['proy'];
    $id_menu = $_GET['id_menu'];
    $id_submenu = $_GET['id_submenu'];
    $docs = $_GET['docs'];
    $fecha_1 = "";
    $fecha_2 = "";
    $f1 = $_GET['fech1'];
    $f2 = $_GET['fech2'];
    $cond = "";
    if($f1!=""){
        $f1_val = explode("/", $f1);
        $fecha_1 = $f1_val[2].'-'.$f1_val[1].'-'.$f1_val[0];
    }
    if ($f2!="") {
        $f2_val = explode("/", $f2);
        $fecha_2 = $f2_val[2].'-'.$f2_val[1].'-'.$f2_val[0];
    }
    $texto = $_GET['texto'];

    if($docs==1){$cond=" and audio=0 ";}

    if($fecha_1!="" or $texto!="") {
        try {
            $stmt = "";
            if($texto!=""){
                if($fecha_1!="" and $fecha_2==""){
                    $stmt = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and fecha_audio>='".$fecha_1."' and title like '%".$texto."%'".$cond." order by id desc limit 500;");
                }
                if($fecha_1!="" and $fecha_2!=""){
                    $stmt = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and title like '%".$texto."%' and".$cond." fecha_audio between '".$fecha_1."' and '".$fecha_2."' order by id desc limit 500;");
                }
                if($fecha_1=="" and $fecha_2==""){
                    $stmt = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and title like '%".$texto."%'".$cond." order by id desc limit 500;");
                }
                if($fecha_1=="" and $fecha_2!=""){
                    $stmt = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and title like '%".$texto."%'".$cond." order by id desc limit 500;");
                }
            } else {
                if($fecha_1!="" and $fecha_2==""){
                    $stmt = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."'".$cond." and fecha_audio>='".$fecha_1."' order by id desc limit 500;");
                }
                if($fecha_1!="" and $fecha_2!=""){
                    $stmt = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."'".$cond." and fecha_audio between '".$fecha_1."' and '".$fecha_2."' order by id desc limit 500;");
                }
            }
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            if ($rows!=null) {
                $mp3_files = 0;
                $doc_files = 0;
                $other_files = 0;
                $stmt1 = "";
                if($texto!=""){
                    if($fecha_1!="" and $fecha_2==""){
                        $stmt1 = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and fecha_audio>='".$fecha_1."' and title like '%".$texto."%'".$cond." order by id desc limit 500;");
                    }
                    if($fecha_1!="" and $fecha_2!=""){
                        $stmt1 = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and title like '%".$texto."%'".$cond." and fecha_audio between '".$fecha_1."' and '".$fecha_2."' order by id desc limit 500;");
                    }
                    if($fecha_1=="" and $fecha_2==""){
                        $stmt1 = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and title like '%".$texto."%'".$cond." order by id desc limit 500;");
                    }
                    if($fecha_1=="" and $fecha_2!=""){
                        $stmt1 = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and title like '%".$texto."%'".$cond." order by id desc limit 500;");
                    }
                } else {
                    if($fecha_1!="" and $fecha_2==""){
                        $stmt1 = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."'".$cond." and fecha_audio>='".$fecha_1."' order by id desc limit 500;");
                    }
                    if($fecha_1!="" and $fecha_2!=""){
                        $stmt1 = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."'".$cond." and fecha_audio between '".$fecha_1."' and '".$fecha_2."' order by id desc limit 500;");
                    }
                }
                $stmt1->execute();
                $rows1 = $stmt1->fetchAll();
                foreach ($rows1 as $rs) {
                    $extension = strtolower(pathinfo($rs['filename'], PATHINFO_EXTENSION));
                    if ($extension=='mp3') {
                        $mp3_files++;
                    } else {
                        if ($extension=='pdf' || $extension=='xlsx' || $extension=='xls' || $extension=='csv' || $extension=='docx' || $extension=='doc') {
                            $doc_files++;
                        } else {
                            $other_files++;
                        }
                    }
                    
                    if ($rs['filename_play']!='') {
                        //$ruta = "./phocadownload/".$rs['filename_play'];
                        $ruta = $rs['filename_play'];
                        $btn_download = "<audio style='height:20px;width:100%;' src='".$ruta."' preload='none' controls>";
                    } else {
                        $btn_download = "<a href='./controlador/descarga_archivo.php?nombre=".$rs['filename']."' style='text-decoration:none;'><button type='button' class='btn btn-success btn-sm'><i class='glyphicon glyphicon-download-alt'></i></button></a>";
                    }
                    $arreglo["data"][] = array($rs['id'],$rs['title'],$btn_download);
                }
            } else {
                $arreglo["data"][] = array('','SIN REGISTROS','');
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    if($fecha_1=="" and $texto==""){$arreglo["data"][] = array('','SIN REGISTROS','');}
    echo json_encode($arreglo,JSON_UNESCAPED_UNICODE|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_ERROR_UTF8|JSON_ERROR_RECURSION);
?>