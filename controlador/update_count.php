<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/app_model.php");
    $new_data = new app_model();
    $id_menu = $_GET['id_menu'];
    $id_submenu = $_GET['id_submenu'];
    $proyecto = $_GET['proy'];
    $docs = $_GET['docs'];
    $fecha_1 = "";
    $fecha_2 = "";
    $f1 = $_GET['fech1'];
    $f2 = $_GET['fech2'];
    $texto = $_GET['texto'];
    $cond="";
    $mp3_files = 0;
    $doc_files = 0;
    $other_files = 0;
    if($f1!=""){
        $f1_val = explode("/", $f1);
        $fecha_1 = $f1_val[2].'-'.$f1_val[1].'-'.$f1_val[0];
    }
    if ($f2!="") {
        $f2_val = explode("/", $f2);
        $fecha_2 = $f2_val[2].'-'.$f2_val[1].'-'.$f2_val[0];
    }

    if($docs==1){$cond=" and audio=0 ";}

    if ($fecha_1!='' or $texto!="") {
        try {
            $stmt = "";
            if($texto!=""){
                if($fecha_1!="" and $fecha_2==""){
                    $stmt = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and fecha_audio>='".$fecha_1."' and title like '%".$texto."%'".$cond." order by id asc;");
                }
                if($fecha_1!="" and $fecha_2!=""){
                    $stmt = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and title like '%".$texto."%'".$cond." and fecha_audio between '".$fecha_1."' and '".$fecha_2."' order by id asc;");
                }
                if($fecha_1=="" and $fecha_2==""){
                    $stmt = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and title like '%".$texto."%'".$cond." order by id asc;");
                }
                if($fecha_1=="" and $fecha_2!=""){
                    $stmt = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and title like '%".$texto."%'".$cond." order by id asc;");
                }
            } else {
                if($fecha_1!="" and $fecha_2==""){
                    $stmt = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."'".$cond." and fecha_audio>='".$fecha_1."' order by id asc;");
                }
                if($fecha_1!="" and $fecha_2!=""){
                    $stmt = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."'".$cond." and fecha_audio between '".$fecha_1."' and '".$fecha_2."' order by id asc;");
                }
            }
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            if ($rows!=null) {
                $stmt1 = "";
                if($texto!=""){
                    if($fecha_1!="" and $fecha_2==""){
                        $stmt1 = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and fecha_audio>='".$fecha_1."' and title like '%".$texto."%'".$cond." order by id asc;");
                    }
                    if($fecha_1!="" and $fecha_2!=""){
                        $stmt1 = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and title like '%".$texto."%'".$cond." and fecha_audio between '".$fecha_1."' and '".$fecha_2."' order by id asc;");
                    }
                    if($fecha_1=="" and $fecha_2==""){
                        $stmt1 = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and title like '%".$texto."%'".$cond." order by id asc;");
                    }
                    if($fecha_1=="" and $fecha_2!=""){
                        $stmt1 = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and title like '%".$texto."%'".$cond." order by id asc;");
                    }
                } else {
                    if($fecha_1!="" and $fecha_2==""){
                        $stmt1 = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."'".$cond." and fecha_audio>='".$fecha_1."' order by id asc;");
                    }
                    if($fecha_1!="" and $fecha_2!=""){
                        $stmt1 = database::conexion()->prepare("select id,title,filename_play,filename from audios where id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."'".$cond." and fecha_audio between '".$fecha_1."' and '".$fecha_2."' order by id asc;");
                    }
                }
                $stmt1->execute();
                $rows1 = $stmt1->fetchAll();
                foreach($rows1 as $rs){
                    $extension = strtolower(pathinfo($rs['filename'], PATHINFO_EXTENSION));
                    if($extension=='mp3'){
                        $mp3_files++;
                    } else {
                        if($extension=='pdf' || $extension=='xlsx' || $extension=='xls' || $extension=='csv' || $extension=='docx' || $extension=='doc'){
                            $doc_files++;
                        }else{
                            $other_files++;
                        }
                    }
                }
            }
        } catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    echo $mp3_files.'|'.$doc_files.'|'.$other_files;
?>