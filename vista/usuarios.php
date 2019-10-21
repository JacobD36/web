<?php 
    session_start();
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $usr = new usuario_model();
    $perfiles = $usr->get_all_perfiles();
?>
<!-- Content Header (Page header) -->
<style type="text/css">
    .modal-header {
        background-color: #5c94cc;
        color: white;
    }
</style>
<section class="content-header">
    <h1>USUARIOS</h1>
    <ol class="breadcrumb">
        <li><a href="./inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Usuarios</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Búsqueda</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="sel_nombre">Usuario a Buscar</label>
                        <input type="text" class="form-control" id="sel_nombre" placeholder="">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="sel_perfil">Perfil</label>
                        <select class="form-control select2" id="sel_perfil" style="width: 100%;">
                            <option value="">SELECCIONE UNA CATEGORÍA</option>
                            <?php foreach($perfiles as $lista) {?>
                                <option value="<?php echo $lista['id'];?>"><?php echo $lista['descripcion'];?></option>
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
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Usuarios Registrados</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="nuevo_usuario();" id="nuevo_usuario" style="float:left;">
                            <i class="glyphicon glyphicon-user"></i> Nuevo Usuario
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <p>&nbsp;</p>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <table class="table table-bordered table-striped table-hover display responsive nowrap" width="100%" cellspacing="0" id="my-table" >
                            <thead>
                                <tr role="row" class="col_heading"></tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    <div class="modal fade" id="myModal" data-backdrop="static" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="contenido_modal"></div>
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
        mostrar_usuarios('','');
    });

    function edita_contacto(id){
        $.ajax({
            type: "post",
            url: "vista/edita_usuario.php",
            data: {
                id: id
            },
            success: function(datos) {
               $("#contenido_modal").html(datos);
            }
        });
    }

    $("#buscar_dato").on('click',function(){
        var nombre = $("#sel_nombre").val();
        var perfil = $("#sel_perfil").val();
        mostrar_usuarios(nombre,perfil);
    });

    function nuevo_usuario(){
        var id="";
        
        $.ajax({
            type: "post",
            url: "vista/nuevo_usuario.php",
            data: {
                id: id
            },
            success: function(datos) {
               $("#contenido_modal").html(datos);
            }
        });
    }

    function desactiva_usuario(id){
        swal({
            title: "¿Confirma la desactivación del elemento?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: {
                cancel: "Cancelar",
                catch: {
                    text: "Aceptar",
                    value: "aceptar",
                },
            }
        })
        .then((value) => {
            if (value=="aceptar") {
                $.ajax({
                    type: "post",
                    url: "controlador/cambia_estado.php?opt=0",
                    data: {
                        id: id
                    },
                    success: function(datos) {
                        $('#my-table').DataTable().ajax.reload();
                        swal("¡Operación exitosa! Se ha desactivado el registro...", {icon: "success",});
                    }
                });
            } 
        });
    }

    function activa_usuario(id){
        swal({
            title: "¿Confirma la activación del elemento?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: {
                cancel: "Cancelar",
                catch: {
                    text: "Aceptar",
                    value: "aceptar",
                },
            }
        })
        .then((value) => {
            if (value=="aceptar") {
                $.ajax({
                    type: "post",
                    url: "controlador/cambia_estado.php?opt=1",
                    data: {
                        id: id
                    },
                    success: function(datos) {
                        $('#my-table').DataTable().ajax.reload();
                        swal("¡Operación exitosa! Se ha activado el registro...", {icon: "success",});
                    }
                });
            } 
        });
    }

    function mostrar_usuarios(nombre,perfil){
        var columns = [
            { "title":"NOMBRES Y APELLIDOS","width": "30%" },
            { "title":"PERFIL","width": "15%" },
            { "title":"USUARIO","width": "15%" },
            { "title":"ESTADO","width": "10%" },
            { "title":"ASIGNADO A","width": "15%" },
            { "title":"OPCIONES","width": "15%" }
        ];

        var table = $('#my-table').DataTable( {
            "processing": true,
            "lengthChange": true,
            "responsive" : true,
            "searching": true,
            "ordering": true,
            "order": [[ 1, "asc" ]],
            "info": true,
            "autoWidth": false,
            "destroy": true,
            "columns": columns,
            "ajax": "controlador/get_all_users.php?nombre="+nombre+"&perfil="+perfil,
            "deferRender": true,
            "paging": true,
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "Sin registros",
                "sEmptyTable": "Tabla vacía",
                "sInfo": "_START_ a _END_ de _TOTAL_ reg",
                "sInfoEmpty": "0 a 0 de 0 REG",
                "sInfoFiltered": "(_MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            "bInfo": true,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                { responsivePriority: 3, targets: 5 },
                {
                    "targets": [0],
                    "render": function(data, type, full) {
                        return data;
                    }
                },
                {
                    "targets": [1],
                    "render": function(data, type, full) {
                        return data;
                    }
                },
                {
                    "targets": [2],
                    "render": function(data, type, full) {
                        return data;
                    }
                },
                {
                    "targets": [3],
                    "render": function(data, type, full) {
                       if(data==1){
                           return "<span class='label label-success'>ACTIVO</span>";
                       } else {
                           if (data==0) {
                               return "<span class='label label-danger'>INACTIVO</span>";
                           } else {
                               if(data==3){
                                   return '';
                               }
                           }
                       }
                    }
                },
                {
                    "targets": [4],
                    "render": function(data, type, full) {
                       return data;
                    }
                },
                {
                    "targets": [5],
                    "render": function(data, type, full) {
                        return '<center>'+data+'</data>';
                    }
                },
            ],
        });
        $("th").css("background-color", "#4c88bb");
        $("th").css("color", "white");
    }
</Script>