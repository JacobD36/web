<?php 
    session_start();
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $data = new usuario_model();
    $campanas = $data->get_campanas();
    $perfiles = $data->get_all_perfiles();
?>
<!-- Content Header (Page header) -->
<style type="text/css">
    .modal-header {
        background-color: #5c94cc;
        color: white;
    }
</style>
<section class="content-header">
    <h1>PERMISOS</h1>
    <ol class="breadcrumb">
        <li><a href="./inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Permisos</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Búsqueda</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="sel_campana">Campaña</label>
                        <select class="form-control select2" id="sel_campana" style="width: 100%;">
                            <option value="">SELECCIONE UNA CATEGORÍA</option>
                            <?php foreach($campanas as $filas){?>
                                <option value="<?php echo $filas['id'];?>"><?php echo $filas['descripcion'];?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="sel_perfil">Perfil</label>
                        <select class="form-control select2" id="sel_perfil" style="width: 100%;">
                            <option value="">SELECCIONE UNA CATEGORÍA</option>
                            <?php foreach($perfiles as $filas){?>
                                <option value="<?php echo $filas['id'];?>"><?php echo $filas['descripcion'];?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="buscar_dato" style="float:right;">
                            <i class="glyphicon glyphicon-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
            <p>&nbsp;</p>
            <div class="row" id="menu_opt" style="display:none;">
                <div class="col-md-12">
                <div class="box box-solid box-default">
                    <div class="box-header">
                        <h3 class="box-title">Menú - Acceso</h3>
                    </div>
                    <div class="box-body" id="body_content">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function () {
        $('.select2').select2({
            language: {
                noResults: function () {
                    return "No se encontraron resultados";
                }
            }
        });
    });

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });

    $("#buscar_dato").on('click',function(){
        var campana = $("#sel_campana").val();
        var perfil = $("#sel_perfil").val();
        
        if(campana!="" && perfil!=""){
            $.ajax({
                type: "post",
                url: "controlador/get_menu_list.php",
                data: {
                    campana: campana,
                    perfil: perfil
                },
                success: function(datos) {
                    $("#menu_opt").css('display','block');
                    $("#body_content").html(datos);
                }
            });

        } else {
            swal("¡Error! Por favor, elija los filtros indicados.", { icon: "error", });
        }
    });
</script>