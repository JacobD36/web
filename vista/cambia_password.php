<?php
    session_start();
?>
<section class="content-header">
    <h1>CONFIGURACIÓN</h1>
    <ol class="breadcrumb">
        <li><a href="./inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Configuración</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Cambiar Contraseña</h3>
        </div>
        <div class="box-body">
            <input type="hidden" id="codusuario" name="codusuario" value="<?php echo $_SESSION['usuario'];?>">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="form-group" id="sel_password1">
                        <label for="password1">Contraseña</label>
                        <input type="password" class="form-control" id="password1" placeholder="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="form-group" id="sel_password2">
                        <label for="password2">Repetir Contraseña</label>
                        <input type="password" class="form-control" id="password2" placeholder="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="graba_pass" style="float:left;">
                            <i class="glyphicon glyphicon-floppy-save"></i> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $("#graba_pass").on('click',function(){
        var pass1 = $("#password1").val();
        var pass2 = $("#password2").val();
        var codusuario = $("#codusuario").val();

        if(pass1!="" && pass2!=""){
            if(pass1==pass2){
                $.ajax({
                    type: "post",
                    url: "controlador/cambia_pass.php",
                    data: {
                        pass1: pass1,
                        pass2: pass2,
                        codusuario: codusuario
                    },
                    success: function(datos) {
                        $("#password1").val("");
                        $("#password2").val("");
                        swal("¡Operación exitosa! Se actualizó la contraseña.", {icon: "success",});
                    }
                });
            } else {
                swal("¡Error! Las contraseñas no coindicen.", { icon: "error", });
            }
        } else {
            swal("¡Error! Por favor ingrese la información solicitada.", { icon: "error", });
        }
    });
</script>