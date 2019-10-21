<?php
class app_model{
    private $db;

    public function __construct(){
        $this->db=database::conexion();
    }

    public function get_module_title($id,$unico){
        $busqueda = array();
        try{
            $stmt = "";
            if ($unico==1) {
                $stmt = $this->db->prepare("select * from menu where id='".$id."';");
            } else {
                $stmt = $this->db->prepare("select * from submenu where id='".$id."';");
            }
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach($rows as $rs){
                $busqueda[] = $rs;
            }
            unset($stmt);
            return $busqueda;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_nombre_campana($id){
        try{
            $stmt = $this->db->prepare("select descripcion from campanas where id='".$id."';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

    }

    public function get_nombre_categoria($id){
        try{
            $stmt = $this->db->prepare("select descripcion from menu where id='".$id."';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_categorias($proyecto){
        try{
            $stmt = $this->db->prepare("select * from menu where campana='".$proyecto."' and lista=1 order by id asc;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_subcat($id){
        try{
            $stmt = $this->db->prepare("select * from submenu where id_menu='".$id."' and estado=1 order by id asc;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function document_confirm($tabla,$id){
        try{
            $stmt="";
            if ($tabla==1) {
                $stmt = $this->db->prepare("select docs from menu where id='".$id."';");
            } else {
                $stmt = $this->db->prepare("select docs from submenu where id='".$id."';");
            }
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_all_audios($filtro1,$filtro2,$filtro3,$proyecto){
        $stmt = "";
        try{
            if($filtro1=="" and $filtro2=="" and $filtro3==""){
                $stmt = $this->db->prepare("select * from audios where id_campana='".$proyecto."' order by id desc limit 500;");
            }
            if($filtro1!="" and $filtro2=="" and $filtro3==""){
                $stmt = $this->db->prepare("select * from audios where id_campana='".$proyecto."' and title like '%".$filtro1."%' order by id desc limit 500;");
            }
            if($filtro1=="" and $filtro2!="" and $filtro3==""){
                $stmt = $this->db->prepare("select * from audios where id_campana='".$proyecto."' and id_menu='".$filtro2."' order by id desc limit 500;");
            }
            if($filtro1=="" and $filtro2!="" and $filtro3!=""){
                $stmt = $this->db->prepare("select * from audios where id_campana='".$proyecto."' and id_menu='".$filtro2."' and id_submenu='".$filtro3."' order by id desc limit 500;");
            }
            if($filtro1!="" and $filtro2!="" and $filtro3==""){
                $stmt = $this->db->prepare("select * From audios where id_campana='".$proyecto."' and id_menu='".$filtro2."' and title like '%".$filtro1."%' order by id desc limit 500;");
            }
            if($filtro1!="" and $filtro2!="" and $filtro3!=""){
                $stmt = $this->db->prepare("select * from audios where id_campana='".$proyecto."' and id_menu='".$filtro2."' and id_submenu='".$filtro3."' and title like '%".$filtro1."%' order by id desc limit 500;");
            }
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function set_file($id_campana,$id_menu,$fecha,$title,$alias,$filename,$filename_play,$id_submenu,$audio,$id_usuario,$descripcion){
        try{
            $stmt = $this->db->prepare("insert into audios (id_campana,id_menu,fecha_audio,title,alias,filename,filename_play,id_submenu,audio,id_usuario,descripcion) values ('".$id_campana."','".$id_menu."','".$fecha."','".$title."','".$alias."','".$filename."','".$filename_play."','".$id_submenu."','".$audio."','".$id_usuario."','".$descripcion."');");
            $stmt->execute();
            unset($stmt);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_carga_items($id,$idperfil){
        try{
            $stmt = $this->db->prepare("select * from menu where campana='".$id."' and descripcion='Carga de Archivos';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $stmt1 = $this->db->prepare("SELECT * FROM permisos WHERE idperfil='".$idperfil."' AND id_menu='".$rows[0]['id']."' AND id_submenu=0 AND idcampana='".$id."';");
            $stmt1->execute();
            $rows1 = $stmt1->fetchAll();
            unset($stmt);
            if ($rows1!=null) {
                return $rows;
            } else {
                return "";
            }
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_nombre_mes($mes) {
        $sel_mes="";
        switch($mes){
            case "01": {
                $sel_mes="Enero";
                break;
            }
            case "02": {
                $sel_mes="Febrero";
                break;
            }
            case "03": {
                $sel_mes="Marzo";
                break;
            }
            case "04": {
                $sel_mes="Abril";
                break;
            }
            case "05": {
                $sel_mes="Mayo";
                break;
            }
            case "06": {
                $sel_mes="Junio";
                break;
            }
            case "07": {
                $sel_mes="Julio";
                break;
            }
            case "08": {
                $sel_mes="Agosto";
                break;
            }
            case "09": {
                $sel_mes="Setiembre";
                break;
            }
            case "10": {
                $sel_mes="Octubre";
                break;
            }
            case "11": {
                $sel_mes="Noviembre";
                break;
            }
            default: {
                $sel_mes="Diciembre";
                break;
            }
        }
        return $sel_mes;
    }

    public function migra_audios($proyecto){
        $res = "0";
        $db1 = null;
        try{
            $stmt = $this->db->prepare("select * from bayental_app.migraciones where proyecto='".$proyecto."' and estado=1;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            foreach($rows as $rs){
                switch($rs['conexion']){
                    case 'conexion_251':{
                        $db1 = database::conexion_251();
                        break;
                    }
                }
                $stmt1 = $db1->prepare("SELECT date(fFecha) as Fecha,replace(date(fFecha),'-','') as fecha1,right(concat('00',month(fFecha)),2) as mes,right(concat('00',day(fFecha)),2) as dia,year(fFecha) as ano FROM ".$rs['base'].".tb_audios_ventas where lEstado = 0 group by date(ffecha) order by fFecha;");
                $stmt1->execute();
                $rows1 = $stmt1->fetchAll();
                unset($stmt1);
                foreach($rows1 as $rs1){
                    $fechabayental = $rs1['Fecha'];
                    $stmt2 = $db1->prepare("SELECT tRegistro,LEFT(replace(tAudio,'BAY_',''),length(tAudio)-26) as titulo,replace(date(fFecha),'-','') as Fecha,tAudio,lEstado FROM ".$rs['base'].".tb_audios_ventas where date(ffecha) ='".$fechabayental."' and ifnull(lEstado,'') in (0,'');");
                    $stmt2->execute();
                    $rows2 = $stmt2->fetchAll();
                    unset($stmt2);
                    foreach($rows2 as $rs2){
                        $audio=$rs2['tAudio'];
                        $titulo=$rs2['titulo'];
                        $fecha=$rs2['Fecha'];
                        $pedido=$rs2['tRegistro'];
                        if($pedido != "" && $pedido != "0"){
                            //$nombre_fichero = "/home/audios_bayental/".$rs['ruta']."/".$fecha."/".$audio;
                            $nombre_fichero = "/phocadownload/bayental_audios/".$rs['ruta']."/".$fecha."/".$audio;
                            if(file_exists($nombre_fichero)) {
                                $stmt3 = $db1->prepare("update bdrimac_onco.tb_audios_ventas set lEstado=1 where tRegistro = ".$pedido);
                                $stmt3->execute();
                                unset($stmt3);
                                $stmt4 = $this->db->prepare("insert into bayental_app.audios (id_campana,id_menu,fecha_audio,title,alias,filename,filename_play,estado,id_submenu,audio,id_usuario) values (
                                '".$proyecto."',
                                '".$rs['id_menu']."',
                                '".$fechabayental."',
                                '".$titulo."',
                                '".$audio."',
                                '".$nombre_fichero."',
                                '".$nombre_fichero."',
                                1,
                                '".$rs['id_submenu']."',
                                1,
                                1
                                )");
                                $stmt4->execute();
                                unset($stmt4);
                                $res = 1;
                            }
                        }
                    }
                }
            }
            return $res;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $res;
    }

    public function existe_migra($proyecto){
        try{
            $stmt = $this->db->prepare("select * from bayental_app.migraciones where proyecto='".$proyecto."';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            if($rows!=null){
                return true;
            } else {
                return false;
            }
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function guarda_log($dato){
        $fp = fopen("../logs/querys.txt", "a");
        fputs($fp, $dato."\r\n");
        fclose($fp);
    }
}
?>