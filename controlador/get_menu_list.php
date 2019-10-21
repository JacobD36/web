<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $info = new usuario_model();
    $campana = $_POST['campana'];
    $perfil = $_POST['perfil'];
    $menu = $info->get_menu_items($campana);
    $i=1;
    foreach($menu as $lista){
        if($lista['unico']==1){
        ?>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="minimal" id="opt_elem_<?php echo $i;?>" name="opt_elem_<?php echo $i;?>" value="<?php echo "1|".$lista['id']."|0";?>" <?php if($info->existe_en_permisos($perfil,$lista['id'],0,$campana)==true){echo "checked";}?>>
                        <?php echo $lista['descripcion'];?>
                    </label>
                </div>
            </div>
        <?php
            $i++;
        } else {
        ?>  
            <div class="form-group">
                <label>
                    <?php echo $lista['descripcion'];?>
                </label>
            </div>
        <?php
            $submenu = $info->get_submenu_items($lista['id']);
            foreach($submenu as $lista1){
            ?>
                <div class="form-group" style="padding-left:30px;">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="minimal" id="opt_elem_<?php echo $i;?>" name="opt_elem_<?php echo $i;?>" value="<?php echo "2|".$lista['id']."|".$lista1['id'];?>" <?php if($info->existe_en_permisos($perfil,$lista['id'],$lista1['id'],$campana)==true){echo "checked";}?>>
                            <?php echo $lista1['descripcion'];?>
                        </label>
                    </div>
                </div>
            <?php
                $i++;
            }
        }
    }
?>
<input type="hidden" id="num_items" name="num_items" value="<?php echo ($i-1);?>">
<p>&nbsp;</p>
<div class="form-group">
    <div class="col-md-12">
        <button type="button" class="btn btn-primary" id="save_dist" style="float:right;">
            <i class="glyphicon glyphicon-floppy-disk"></i> Guardar
        </button>
    </div>
</div>
<script>
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });

    $("#save_dist").on('click',function(){
        var campana_1 = $("#sel_campana").val();
        var perfil_1 = $("#sel_perfil").val();
        var num_items = $("#num_items").val();
        var z=0;
        var v_items_list = new Array(num_items);

        for(i=1;i<=num_items;i++){
            v_items_list[i-1]=0;
            nom_var='opt_elem_'+i;
            if(document.getElementById(nom_var).checked==true) {
                v_items_list[i - 1] = $('#' + nom_var + ':checked').val();
                z++;
            }
        }

        if(campana_1!="" && perfil_1!="" && z!=0){
            $.ajax({
                type: "post",
                url: "controlador/graba_permisos.php",
                data: {
                    campana: campana_1,
                    perfil: perfil_1,
                    num_items: num_items,
                    item_list: v_items_list
                },
                success: function(datos) {
                    $("#body_content").html("<div class='alert alert-success alert-dismissable fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close' style='text-decoration:none;'>x</a>Información guardada correctamente...</div>");
                    $('#sel_campana').val('').trigger('change.select2');
                    $('#sel_perfil').val('').trigger('change.select2');
                }
            });
        } else {
            swal("¡Error! Por favor, elija los filtros indicados.", { icon: "error", });
        }
    });
</script>