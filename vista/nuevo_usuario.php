<?php 
    session_start();    
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $data = new usuario_model();
    $perfiles = $data->get_all_perfiles();
    $campanas = $data->get_campanas();
    $num_camp = $data->get_num_camp();
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Nuevo Usuario</h4>
</div>
<div class="modal-body">
    <input type="hidden" id="num_camp" name="num_camp" value="<?php echo $num_camp;?>">
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="form-group" id="sel_nombre1">
                <label for="nombre1">Primer Nombre</label>
                <input type="text" class="form-control" id="nombre1" placeholder="" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="form-group" id="sel_nombre2">
                <label for="nombre2">Segundo Nombre</label>
                <input type="text" class="form-control" id="nombre2" placeholder="" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="form-group" id="sel_apellido1">
                <label for="apellido1">Primer Apellido</label>
                <input type="text" class="form-control" id="apellido1" placeholder="" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="form-group" id="sel_apellido2">
                <label for="apellido2">Segundo Apellido</label>
                <input type="text" class="form-control" id="apellido2" placeholder="" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="form-group" id="sel_dni">
                <label for="dni">DNI</label>
                <input type="number" class="form-control" id="dni" placeholder="">
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="form-group" id="sel_perfil">
                <label for="perfil">Perfil</label>
                <select class="form-control select2" id="perfil" style="width: 100%;">
                    <option value="">SELECCIONE UNA CATEGORIA</option>
                    <?php foreach($perfiles as $lista){?>
                        <option value="<?php echo $lista['id']?>"><?php echo $lista['descripcion'];?></option>
                    <?php }?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="form-group" id="sel_password1">
                <label for="password1">Contraseña</label>
                <input type="password" class="form-control" id="password1" placeholder="">
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="form-group" id="sel_password2">
                <label for="password2">Repetir Contraseña</label>
                <input type="password" class="form-control" id="password2" placeholder="">
            </div>
        </div>
    </div>
    <legend>Mantenimiento</legend>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="checkbox">
                <label>
                    <input type="checkbox" class="minimal" id="super_adm" name="super_adm" value="1">
                    Super Administrador
                </label>
            </div>
        </div> 
    </div>
    <legend>Campañas</legend>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="form-group">
                <div class="checkbox">
                    <?php $i=1;foreach($campanas as $lista){?>
                        <label>
                            <!--<input type="checkbox" class="minimal" id="chk_cmp_<?php echo $lista['id'];?>" name="chk_cmp_<?php echo $lista['id'];?>" value="<?php echo $lista['id'];?>">-->
                            <input type="checkbox" class="minimal" id="chk_cmp_<?php echo $i;?>" name="chk_cmp_<?php echo $i;?>" value="<?php echo $lista['id'];?>">
                            <?php echo $lista['descripcion'];?>
                        </label>
                    <?php $i++;}?>
                </div>
            </div>
        </div>
    </div>
</div>  
<div class="modal-footer">
    <button type="button" class="btn btn-primary" id="guardar_info">Guardar</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>
<script>
    $(function () {
        $('#perfil').select2({
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

    $("#guardar_info").on('click',function(){
        var num_camp = $("#num_camp").val();
        var nombre1 = $("#nombre1").val();
        var nombre2 = $("#nombre2").val();
        var apellido1 = $("#apellido1").val();
        var apellido2 = $("#apellido2").val();
        var dni = $("#dni").val();
        var perfil = $("#perfil").val();
        var password1 = $("#password1").val();
        var password2 = $("#password2").val();
        var i,z=0;
        var super_adm = 0;

        if(document.getElementById("super_adm").checked==true){
            super_adm = $("#super_adm").val();
        }

        var nom_var="";
        var v_campana_list = new Array(num_camp);
        for(i=1;i<=num_camp;i++){
            v_campana_list[i-1]=0;
            nom_var='chk_cmp_'+i;
            if(document.getElementById(nom_var).checked==true) {
                v_campana_list[i - 1] = $('#' + nom_var + ':checked').val();
                z++;
            }
        }

        if(nombre1!="" && apellido1!="" && apellido2!="" && dni!="" && perfil!="" && password1!="" && password2!="" && z!=0){
            if(password1==password2){
                $.ajax({
                    type: "post",
                    url: "controlador/genera_nuevo.php",
                    data: {
                        num_camp: num_camp,
                        nombre1: nombre1,
                        nombre2: nombre2,
                        apellido1: apellido1,
                        apellido2: apellido2,
                        dni: dni,
                        perfil: perfil,
                        password1: password1,
                        password2: password2,
                        super_adm: super_adm,
                        campana_list: v_campana_list,
                        cont_camp: z
                    },
                    success: function(datos) {
                        if(datos!='existe'){
                            $('#my-table').DataTable().ajax.reload();
                            $('#myModal').modal('toggle');
                            swal("¡Operación exitosa! Se generó el usuario: "+datos, {icon: "success",});
                        } else {
                            swal("¡Error! El usuario ya existe con los nombres y apellidos de la persona.", { icon: "error", });
                        }
                    }
                });
            } else {
                swal("¡Error! Las contraseñas no coindicen.", { icon: "error", });
            }
        } else {
            if(nombre1==""){
                $("#sel_nombre1").addClass("has-error has-feedback");
                swal("¡Error! Por favor, ingrese el primer nombre de la persona.", { icon: "error", });
            } else {
                $("#sel_nombre1").removeClass("has-error has-feedback");
                if(apellido1==""){
                    $("#sel_apellido1").addClass("has-error has-feedback");
                    swal("¡Error! Por favor, ingrese el primer apellido de la persona.", { icon: "error", });
                } else {
                    $("#sel_apellido1").removeClass("has-error has-feedback");
                    if(apellido2==""){
                        $("#sel_apellido2").addClass("has-error has-feedback");
                        swal("¡Error! Por favor, ingrese el segundo apellido de la persona.", { icon: "error", });
                    } else {
                        $("#sel_apellido2").removeClass("has-error has-feedback");
                        if(dni==""){
                            $("#sel_dni").addClass("has-error has-feedback");
                            swal("¡Error! Por favor, ingrese el DNI de la persona.", { icon: "error", });
                        } else {
                            $("#sel_dni").removeClass("has-error has-feedback");
                            if(perfil==""){
                                swal("¡Error! Por favor, seleccione un perfil.", { icon: "error", });
                            } else {
                                if(password1==""){
                                    $("#sel_password1").addClass("has-error has-feedback");
                                    swal("¡Error! Por favor, ingrese la contraseña.", { icon: "error", });
                                } else {
                                    $("#sel_password1").removeClass("has-error has-feedback");
                                    if(password2==""){
                                        $("#sel_password2").addClass("has-error has-feedback");
                                        swal("¡Error! Por favor, repita la contraseña.", { icon: "error", });
                                    } else {
                                        $("#sel_password2").removeClass("has-error has-feedback");
                                        if(z==0){
                                            swal("¡Error! Por favor, seleccione una campaña como mínimo.", { icon: "error", });
                                        }    
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    });    
</script>