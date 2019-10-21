<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/app_model.php");
    $elem = new app_model();
    $id = $_POST['id'];
    $subcat = $elem->get_subcat($id);
    $data = "<div class='form-group'><label for='sel_subcategoria_carga'>Sub Categoría</label><select class='form-control select2' id='sel_subcategoria_carga' style='width: 100%;'><option value=''>SELECCIONE UNA CATEGORÍA</option>";
    if ($subcat!=null) {
        foreach ($subcat as $lista) {
            $data.="<option value='".$lista['id']."'>".$lista['descripcion']."</option>";
        }
    }
    $data.="</select></div>";
    echo $data;
?>