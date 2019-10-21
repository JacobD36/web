<?php
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    session_start();
    $usuario = new usuario_model();
    $username = strtolower($_POST['username']);
    $userpass = $_POST['userpass'];
    if($username!='' and $userpass!='') {
        $idperfil = $usuario->valida_acceso($username, $userpass);
        if ($idperfil!=null) {
            $_SESSION['usuario'] = $username;
            $_SESSION['perfil'] = $idperfil[0]['idperfil'];    
            $_SESSION['id'] = $idperfil[0]['id'];
            $_SESSION['superadm'] = $idperfil[0]['superadm'];
            $_SESSION['start'] = time();
            ?>
            <script type="text/javascript">
                location.assign("../web/inicio.php");
            </script>
            <?php
        } else {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                Usuario y/o contraseña incorrectos
            </div>
            <script type="text/javascript">
                $(":text").each(function () {
                    $($(this)).val('');
                });
                $(":password").each(function () {
                    $($(this)).val('');
                });
            </script>
            <?php
            $_SESSION = array();
        }
    } else {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
            Por favor, ingrese la información solicitada
        </div>
        <?php
    }
?>