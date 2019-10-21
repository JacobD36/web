<?php
class usuario_model{
    private $db;

    public function __construct(){
        $this->db=database::conexion();
    }

    public function valida_acceso($user,$pass){
        $busqueda = array();
        $valor_hash=$this->get_hash($user);
        if($valor_hash!=null) {
            $hash_x = hash('sha256',$pass.$valor_hash[0]['salt']);
            if ($valor_hash[0]['hashcode'] == $hash_x) {
                try{
                    $stmt = $this->db->prepare("select * from usuarios where codusuario='".$user."' and estado=1 limit 1;");
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
            } else {
                return "";
            }
        } else {
            return "";
        }
    }

    public function update_user($id_usuario,$id_persona,$nombre1,$nombre2,$apellido1,$apellido2,$dni,$perfil,$super_adm){
        try{
            $stmt = $this->db->prepare("update personas set nombre1='".$nombre1."',nombre2='".$nombre2."',apellido1='".$apellido1."',apellido2='".$apellido2."',dni='".$dni."' where id='".$id_persona."';");
            $stmt->execute();
            $stmt1 = $this->db->prepare("update usuarios set idperfil='".$perfil."',superadm='".$super_adm."' where id='".$id_usuario."';");
            $stmt1->execute();
            unset($stmt);
            unset($stmt1);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_hash($codusuario) {
        $busqueda = array();
        try{
            $stmt = $this->db->prepare("select hashcode,salt from login_code where codusuario='".$codusuario."' limit 1;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach($rows as $rs){
                $busqueda[] = $rs;
            }
            unset($stmt);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $busqueda;
    }

    public function get_campanas(){
        try{
            $stmt = $this->db->prepare("select * from campanas where estado=1;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        } catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_all_user_campaign($id){
        $resultado = "";
        try{
            $stmt = $this->db->prepare("select * from acceso where idusuario='".$id."' and estado=1;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $stmt1 = $this->db->prepare("select id from campanas order by id desc limit 1;");
            $stmt1->execute();
            $rows1 = $stmt1->fetchAll();
            foreach($rows as $rs){
                $stmt2 = $this->db->prepare("select * from campanas where id='".$rs['idcampana']."';");
                $stmt2->execute();
                $rows2 = $stmt2->fetchAll();
                if ($rows2[0]['id']!=$rows1[0]['id']) {
                    $resultado.=$rows2[0]['descripcion']." | ";
                } else {
                    $resultado.=$rows2[0]['descripcion'];
                }
            }
            unset($stmt);
            unset($stmt1);
            unset($stmt2);
            return $resultado;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_num_camp(){
        try{
            $stmt = $this->db->prepare("select count(*) as cuenta from campanas where estado=1");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows[0]['cuenta'];
        } catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_menu_items($campana){
        try{
            $stmt = $this->db->prepare("select * from menu where campana='".$campana."' and estado=1 order by id asc;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_submenu_items($id_menu){
        try{
            $stmt = $this->db->prepare("select * from submenu where id_menu='".$id_menu."' and estado=1 order by id asc;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows; 
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    
    public function get_personal_info($id){
        $busqueda = array();
        try{
            $stmt = $this->db->prepare("select * from personas where idusuario='".$id."';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach($rows as $rs){
                $busqueda[] = $rs;
            }
            unset($stmt);
            return $busqueda;
        } catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_username($id){
        try{
            $stmt = $this->db->prepare("select codusuario from usuarios where id='".$id."' order by id desc limit 1;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_user_perfil($id){
        try{
            $stmt = $this->db->prepare("select descripcion from perfiles where id='".$id."';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_all_perfiles(){
        try{
            $stmt = $this->db->prepare("select * from perfiles where estado=1;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_all_users($nombre,$perfil){
        try{
            $stmt = "";
            if($nombre!="" && $perfil==""){
                $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE codusuario like '%".$nombre."%' or id IN (SELECT idusuario FROM personas WHERE CONCAT(nombre1,nombre2,apellido2,apellido2) LIKE '%".$nombre."%');"); 
            }
            if($nombre=="" && $perfil!=""){
                $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE idperfil='".$perfil."';");
            }
            if($nombre=="" && $perfil==""){
                $stmt = $this->db->prepare("SELECT * FROM usuarios;");
            }
            if($nombre!="" && $perfil!=""){
                $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE codusuario like '%".$nombre."%' or id IN (SELECT idusuario FROM personas WHERE CONCAT(nombre1,nombre2,apellido1,apellido2) LIKE '%".$nombre."%') AND idperfil='".$perfil."';");
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

    public function get_perfil($id){
        try{
            $stmt = $this->db->prepare("select idperfil from usuarios where id='".$id."';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows[0]['idperfil'];
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function cambia_estado($id,$opt){
        try{
            $stmt = $this->db->prepare("update usuarios set estado='".$opt."' where id='".$id."';");
            $stmt->execute();
            $stmt1 = $this->db->prepare("update personas set estado='".$opt."' where idusuario='".$id."';");
            $stmt1->execute();
            unset($stmt);
            unset($stmt1);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function accesa_campana($idusuario,$idcampana){
        try{
            $stmt = $this->db->prepare("select * from acceso where idusuario='".$idusuario."' and idcampana='".$idcampana."';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if($rows!=null){
                if($rows[0]['estado']==1){
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
            unset($stmt);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function campana_activa($id){
        try{
            $stmt = $this->db->prepare("select * from campanas where id='".$id."';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if($rows[0]['estado']==1){
                return true;
            } else {
                return false;
            }
            unset($stmt);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function accesa_superadm($id){
        try{
            $stmt = $this->db->prepare("select superadm from usuarios where id='".$id."';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows[0]['superadm'];
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function valida_permiso_menu_unico($idperfil,$id_menu,$idcampana){
        $busqueda = array();
        $validacion = false;
        try{
            $stmt = $this->db->prepare("select * from permisos where idperfil='".$idperfil."' and id_menu='".$id_menu."' and idcampana='".$idcampana."' and estado=1 order by id limit 1;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach($rows as $rs){
                $busqueda[] = $rs;
            }
            unset($stmt);
            if($busqueda!=null){$validacion=true;}
            return $validacion;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function valida_permiso_submenu($idperfil,$id_menu,$id_submenu,$idcampana){
        $busqueda = array();
        $validacion = false;
        try{
            $stmt = $this->db->prepare("select * from permisos where idperfil='".$idperfil."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and idcampana='".$idcampana."' and estado=1 order by id limit 1;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach($rows as $rs){
                $busqueda[] = $rs;
            }
            unset($stmt);
            if($busqueda!=null){$validacion=true;}
            return $validacion;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /*public function set_acceso($idusuario,$idcampana,$estado){
        if($estado!=0){$estado=1;}
        try{
            $stmt = $this->db->prepare("select * from acceso where idusuario='".$idusuario."' and idcampana='".$idcampana."';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if($rows!=null){
                $stmt1 = $this->db->prepare("update acceso set estado='".$estado."' where idusuario='".$idusuario."' and idcampana='".$idcampana."';");
                $stmt1->execute();
            } else {
                $stmt2 = $this->db->prepare("insert into acceso (idusuario,idcampana,estado) values ('".$idusuario."','".$idcampana."','".$estado."');");
                $stmt2->execute();
            }
            unset($stmt);
            unset($stmt1);
            unset($stmt2);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }*/

    public function set_acceso($idusuario,$idcampana){
        try{
            if ($idcampana!=0) {
                $stmt = $this->db->prepare("select * from acceso where idusuario='".$idusuario."' and idcampana='".$idcampana."';");
                $stmt->execute();
                $row = $stmt->fetchAll();
                if($row!=null){
                    $stmt1 = $this->db->prepare("update acceso set estado=1 where id='".$row[0]['id']."';");
                    $stmt1->execute();
                } else {
                    $stmt1 = $this->db->prepare("insert into acceso (idusuario,idcampana,estado) values ('".$idusuario."','".$idcampana."',1);");
                    $stmt1->execute();
                }
                unset($stmt);
                unset($stmt1);
            }
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function clear_acceso($idusuario){
        try{
            $stmt = $this->db->prepare("update acceso set estado=0 where idusuario='".$idusuario."';");
            $stmt->execute();
            unset($stmt);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function existe_user($codusuario){
        try {
            $stmt = $this->db->prepare("select * from usuarios where codusuario='".$codusuario."';");
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

    public function set_new_user($nombre1,$nombre2,$apellido1,$apellido2,$dni,$idperfil,$superadm,$password1,$camp_list,$num_camp){
        $codusuario = substr($nombre1,0,1);
        $ape1 = $apellido1;
        $apellido1 = str_replace("Ñ","N",$apellido1);
        $first_c = substr($apellido2,0,1);
        $codusuario.=$apellido1;
        if($this->existe_user($codusuario)==true){$codusuario.=$first_c;}
        if ($this->existe_user($codusuario)==false) {
            try {
                $codusuario = strtolower($codusuario);
                $stmt = $this->db->prepare("select id from personas order by id desc limit 1;");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $id_persona = $rows[0]['id']+1;
                $stmt1 = $this->db->prepare("insert into usuarios (idpersona,codusuario,idperfil,superadm) values ('".$id_persona."','".$codusuario."','".$idperfil."','".$superadm."');");
                $stmt1->execute();
                $stmt2 = $this->db->prepare("select * from usuarios where codusuario='".$codusuario."' order by id desc limit 1;");
                $stmt2->execute();
                $rows1 = $stmt2->fetchAll();
                $stmt3 = $this->db->prepare("insert into personas (idusuario,dni,nombre1,nombre2,apellido1,apellido2) values ('".$rows1[0]['id']."','".$dni."','".$nombre1."','".$nombre2."','".$ape1."','".$apellido2."');");
                $stmt3->execute();
                $pass_salt = $this->generateHashWithSalt($password1);
                $pass_salt_val = explode("|",$pass_salt);
                $hash = $pass_salt_val[0];
                $salt = $pass_salt_val[1];
                $stmt4 = $this->db->prepare("insert into login_code (codusuario,hashcode,salt) values ('".$codusuario."','".$hash."','".$salt."');");
                $stmt4->execute();
                for($i=0;$i<=($num_camp-1);$i++){
                    //$this->set_acceso($rows1[0]['id'],($i+1),$camp_list[$i]);
                    $this->set_acceso($rows1[0]['id'],$camp_list[$i]);
                }
                unset($stmt);
                unset($stmt1);
                unset($stmt2);
                unset($stmt3);
                unset($stmt4);
                return $codusuario;
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        } else {
            return "existe";
        }
    }

    public function actualiza_password($codusuario,$password){
        try{
            $pass_salt = $this->generateHashWithSalt($password);
            $pass_salt_val = explode("|",$pass_salt);
            $hash = $pass_salt_val[0];
            $salt = $pass_salt_val[1];
            $stmt = $this->db->prepare("update login_code set hashcode='".$hash."',salt='".$salt."' where codusuario='".$codusuario."';");
            $stmt->execute();
            unset($stmt);
        } catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function elimina_permisos($idperfil,$idcampana){
        try{
            $stmt = $this->db->prepare("delete from permisos where idperfil='".$idperfil."' and idcampana='".$idcampana."'");
            $stmt->execute();
            unset($stmt);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function asigna_permisos($idperfil,$idcampana,$id_menu,$id_submenu){
        try{
            $stmt = $this->db->prepare("insert into permisos (idperfil,id_menu,id_submenu,idcampana) values ('".$idperfil."','".$id_menu."','".$id_submenu."','".$idcampana."');");
            $stmt->execute();
            unset($stmt);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function existe_en_permisos($idperfil,$id_menu,$id_submenu,$idcampana){
        try{
            $stmt = $this->db->prepare("select * from permisos where idperfil='".$idperfil."' and id_menu='".$id_menu."' and id_submenu='".$id_submenu."' and idcampana='".$idcampana."';");
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

    public function contiene_elementos_activos($id_menu,$idcampana,$idperfil){
        $resultado = 0;
        try{
            $stmt = $this->db->prepare("select * from submenu where id_menu='".$id_menu."' and estado=1 order by id asc;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach($rows as $rs){
                $stmt1 = $this->db->prepare("select * from permisos where idperfil='".$idperfil."' and id_menu='".$id_menu."' and id_submenu='".$rs['id']."' and idcampana='".$idcampana."';");
                $stmt1->execute();
                $rows1=$stmt1->fetchAll();
                if($rows1!=null){
                    $resultado = 1;
                }
            }
            unset($stmt);
            unset($stmt1);
            return $resultado;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    function generateHashWithSalt($password) {
        define("MAX_LENGTH", 6);
        $intermediateSalt = md5(uniqid(rand(), true));
        $salt = substr($intermediateSalt, 0, MAX_LENGTH);
        return hash("sha256", $password . $salt)."|".$salt;
    }

    public function guarda_log($dato){
        $fp = fopen("../logs/querys.txt", "a");
        fputs($fp, $dato."\r\n");
        fclose($fp);
    }
}
?>