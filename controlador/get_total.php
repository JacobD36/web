<?php
    require_once("../configuracion/database.php");
    require_once("../modelo/app_model.php");
    $new_data = new app_model();
    $proyecto = $_POST['proy'];
    $id_menu = $_POST['id_menu'];
    $id_submenu = $_POST['id_submenu'];
    $docs = $_POST['docs'];
    $cond="";
    $mp3_files = 0;
    $doc_files = 0;
    $other_files = 0;

    if($docs==1){$cond=" and audio=0 ";}

    try {
        $stmt1 = database::conexion()->prepare("SELECT COUNT(*) AS cuenta FROM audios WHERE SUBSTRING_INDEX(filename,'.', -1) IN ('mp3') and id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."'".$cond.";");
        $stmt1->execute();
        $rows1 = $stmt1->fetchAll();
        unset($stmt1);
        $stmt2 = database::conexion()->prepare("SELECT COUNT(*) AS cuenta FROM audios WHERE SUBSTRING_INDEX(filename,'.', -1) IN ('pdf','docx','doc','xlsx','xls') and id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."'".$cond.";");
        $stmt2->execute();
        $rows2 = $stmt2->fetchAll();
        unset($stmt2);
        $stmt3 = database::conexion()->prepare("SELECT COUNT(*) AS cuenta FROM audios WHERE SUBSTRING_INDEX(filename,'.', -1) NOT IN ('mp3','pdf','docx','doc','xlsx','xls') and id_campana='".$proyecto."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."'".$cond.";");
        $stmt3->execute();
        $rows3 = $stmt3->fetchAll();
        unset($stmt3);
        if($rows1!=null){$mp3_files = $rows1[0]['cuenta'];}
        if($rows2!=null){$doc_files = $rows2[0]['cuenta'];}
        if($rows3!=null){$other_files = $rows3[0]['cuenta'];}
    } catch(PDOException $e){
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    echo $mp3_files.'|'.$doc_files.'|'.$other_files;
?>