<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $menu_layout = new usuario_model();
    $campana = $_POST['campana'];
    $perfil = $_POST['perfil'];
    $num_items = $_POST['num_items'];
    $item_list = $_POST['item_list'];

    $menu_layout->elimina_permisos($perfil,$campana);

    if ($campana!="" && $perfil!="" && $num_items!="" && $item_list!="") {
        for ($i=0;$i<=($num_items-1);$i++) {
            if ($item_list[$i]!=0) {
                $elem = explode("|", $item_list[$i]);
                $menu_layout->asigna_permisos($perfil, $campana, $elem[1], $elem[2]);
            }
        }
    }
?>