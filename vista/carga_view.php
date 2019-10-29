<?php 
    session_start();
    require_once("../configuracion/database.php");
    require_once("../modelo/app_model.php");
    date_default_timezone_set("America/Lima");
    $modulo = new app_model();
    $id = $_GET['id'];
    $id_sub = $_GET['id_sub'];
    $unique = $_GET['unique'];
    $proyecto = $_GET['proy'];
    $docs = $_GET['docs'];
    $fecha_actual = date("d/m/Y");
    $titulo = $modulo->get_module_title($id,$unique);
    $camp_nombre = $modulo->get_nombre_campana($proyecto);
    $categorias = $modulo->get_categorias($proyecto);
    $existe_m = $modulo->existe_migra($proyecto);
?>
<style>
    .glyphicon-folder-open{
        display: unset !important;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>CARGA DE ARCHIVOS</h1>
    <ol class="breadcrumb">
        <li><a href="./inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Cargas</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Búsqueda de Archivos</h3>
        </div>
        <div class="box-body">
            <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
            <input type="hidden" id="id_sub" name="id_sub" value="<?php echo $id_sub;?>">
            <input type="hidden" id="proyecto" name="proyecto" value="<?php echo $proyecto;?>">
            <input type="hidden" id="docs" name="docs" value="<?php echo $docs;?>">
            <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id'];?>">
            <div class="row">
                <div class="col-md-4 col-xs-12" id="filtro1">
                    <div class="form-group">
                        <label for="sel_nombre">Texto a Buscar</label>
                        <input type="text" class="form-control" id="sel_nombre" placeholder="">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12" id="filtro2">
                    <div class="form-group">
                        <label for="sel_categoria">Categoría</label>
                        <select class="form-control select2" id="sel_categoria" style="width: 100%;">
                            <option value="">SELECCIONE UNA CATEGORÍA</option>
                            <?php foreach($categorias as $lista){?>
                                <option value="<?php echo $lista['id'];?>"><?php echo $lista['descripcion'];?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12" id="filtro3">
                    <div class="form-group">
                        <label for="sel_subcategoria">Sub Categoría</label>
                        <select class="form-control select2" id="sel_subcategoria" style="width: 100%;">
                            <option value="">SELECCIONE UNA CATEGORÍA</option>
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
            <h3 class="box-title">Archivos Cargados</h3>
        </div>
        <div class="box-body">
            <?php if($existe_m==true){?>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-3" style="padding-right:0px;">
                        <div class="form-group" style="padding-right:0px;">
                            <button type="button" class="btn btn-success" id="carga_fuente" style="float:left;">
                                <i class="glyphicon glyphicon-download-alt"></i> Actualizar Audios
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2" id="carga" style="display:none;">
                        <div class="form-group" style="float:left;">
                            <img src="./vista/img/loading.gif" width="30px"/>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:15px;margin-left:15px;margin-right:15px;">
                    <div class="cold-md-12">
                        <div class="form-group">
                            <div id="migra_progress_area" style="display:none;">
                                <div class="progress" id="migra_progress_proc"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<p>&nbsp;</p>-->
            <?php }?>
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
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Cargar Archivo</h3>
        </div>
        <div class="box-body">
            <form enctype="multipart/form-data" class="formulario">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label for="titulo">Título del Archivo</label>
                            <input type="text" class="form-control" id="titulo" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label for="descripcion">Fecha de Carga</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?php echo $fecha_actual;?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12" id="filtro3">
                        <div class="form-group">
                            <label for="sel_categoria_carga">Categoría</label>
                            <select class="form-control select2" id="sel_categoria_carga" name="sel_categoria_carga" style="width: 100%;">
                                <option value="">SELECCIONE UNA CATEGORÍA</option>
                                <?php foreach($categorias as $lista){?>
                                    <option value="<?php echo $lista['id'];?>"><?php echo $lista['descripcion'];?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12" id="filtro4">
                        <div class="form-group">
                            <label for="sel_subcategoria_carga">Sub Categoría</label>
                            <select class="form-control select2" id="sel_subcategoria_carga" style="width: 100%;">
                                <option value="">SELECCIONE UNA CATEGORÍA</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label for="archivo">Archivo</label>
                            <input id="archivo" name="archivo" type="file" class="file">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="cargar" style="float:right;">
                                <i class="glyphicon glyphicon-open"></i> Cargar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:15px;margin-left:15px;margin-right:15px;">
                    <div class="cold-md-12">
                        <div class="form-group">
                            <div id="progress_area" style="display:none;">
                                <div class="progress" id="progress_proc"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="box-footer">
            <p>&nbsp;</p>
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

    $('#datepicker').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/aaaa' });

    $.fn.datepicker.dates['en'] = {
        days: ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"],
        daysShort: ["Dom","Lun","Mar","Mié","Jue","Vie","Sáb"],
        daysMin: ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
        months: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
        monthsShort: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
        today: "Hoy",
        monthsTitle:"Meses",
        clear: "Borrar",
        format: "mm/dd/yyyy",
        titleFormat: "MM yyyy",
        weekStart: 0
    };

    $('#datepicker').datepicker({
      autoclose: true,
      format: "dd/mm/yyyy",
      todayHighlight: true,
      todayBtn: true,
    });
    
    $("#archivo").fileinput({
        showCaption: true,
        showUpload: false,
        previewFileType: "any",
        showPreview: false,
		browseClass: "btn btn-primary",
		fileType: "any"
	});
    mostrar_elem('','',''); 
  });

  $("#sel_categoria").change(function(){
    $.ajax({
        type: "post",
        url: "controlador/get_subcat.php",
        data: {
            id: this.value
        },
        success: function(datos) {
            $("#filtro3").html(datos);
            $('.select2').select2({
                language: {
                    noResults: function () {
                        return "No se encontraron resultados";
                    }
                }
            });
        }
    });
  });

  $("#sel_categoria_carga").change(function(){
    $.ajax({
        type: "post",
        url: "controlador/get_subcat_carga.php",
        data: {
            id: this.value
        },
        success: function(datos) {
            $("#filtro4").html(datos);
            $('.select2').select2({
                language: {
                    noResults: function () {
                        return "No se encontraron resultados";
                    }
                }
            });
        }
    });
  });

  $("#carga_fuente").click(function(){
    var proy = $("#proyecto").val();
    $("#carga").css("display","block");

    $.ajax({
        type: "post",
        url: "controlador/migra_audios.php",
        data: {
            proy: proy
        },
        success: function(datos) {
            $("#carga").css("display","none");
            if(datos=='1'){
                $('#my-table').DataTable().ajax.reload();
                swal("¡Operación exitosa! Se actualizó la base de audios.", { icon: "success", });
            } else {
                swal("¡Error! No ha sido posible actualizar la base y/o ésta ya se encuentra actualizada.", { icon: "error", });
            }
        }
    });
  });
  
  $("#cargar").click(function(){
    var formData = new FormData($(".formulario")[0]);
    formData.append("id",$("#id").val());
    formData.append("id_sub",$("#id_sub").val());
    formData.append("titulo",$("#titulo").val()); 
    formData.append("fecha",$("#datepicker").val());
    formData.append("descripcion",$("#descripcion").val());
    formData.append("proyecto",$("#proyecto").val());
    formData.append("cat_carga",$("#sel_categoria_carga").val());
    formData.append("subcat_carga",$("#sel_subcategoria_carga").val());
    formData.append("docs",$("#docs").val());
    formData.append("id_usuario",$("#id_usuario").val());

    if($("#datepicker").val()!="" && $("#titulo").val()!="" && $("#sel_categoria_carga").val()!=""){
        $.ajax({
            url: 'controlador/cargar_archivo.php',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            xhr: function(){
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt){
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        var percent_v = percentComplete*100;
                        var percent_show = Math.trunc(percent_v);
                        $("#progress_area").css("display","block");
                        var muestra = "<div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='";
                        muestra+=percent_show;
                        muestra+="' aria-valuemin='0' aria-valuemax='100' style='width:";
                        muestra+=percent_show;
                        muestra+="%'>";
                        muestra+=percent_show+'% completado';
                        muestra+="</div>";
                        $("#progress_proc").html(muestra);
                    }
                }, false);
                return xhr;
            },
            success: function(data) {
                if (data == 'Exito') {
                    $("#titulo").val("");
                    $("#descripcion").val("");
                    $('#sel_categoria_carga').val('').trigger('change.select2');
                    $("#filtro4").html("<div class='form-group'><label for='sel_subcategoria_carga'>Sub Categoría</label><select class='form-control select2' id='sel_subcategoria_carga' style='width: 100%;'><option value=''>SELECCIONE UNA CATEGORÍA</option></select></div>");
                    $('#sel_subcategoria_carga').select2({
                    language: {
                        noResults: function () {
                            return "No se encontraron resultados";
                        }
                    }
                    });
                    $('#my-table').DataTable().ajax.reload();
                    swal("¡Operación exitosa! Archivo subido con éxito.", { icon: "success", });
                } else {
                    if(data=='Error_Cat'){
                        swal("¡Error! No se ha seleccionado una Sub Categoría.", { icon: "error", });
                    } else {
                        if(data=='Error_Extension'){
                            swal("¡Error! Extensión de archivo no aceptada.", { icon: "error", });
                        } else {
                            if(data=="Existe"){
                                swal("¡Error! El archivo ya existe.", { icon: "error", });
                            } else {
                                swal("¡Error! No ha seleccionado un archivo.", { icon: "error", });
                            }
                        }
                    }
                }
            },
            error: function() {
                swal("¡Error! No se pudo subir el archivo.", { icon: "error", });
            }
        });
    } else {
        swal("¡Error! Por favor ingrese la información solicitada.", { icon: "error", });
    }
  });

  $("#buscar_dato").click(function(){
      var filtro1 = $("#sel_nombre").val();
      var filtro2 = $("#sel_categoria").val();
      var filtro3 = $("#sel_subcategoria").val();
      mostrar_elem(filtro1,filtro2,filtro3);
  })

  function mostrar_elem(filtro1,filtro2,filtro3){
        var proy = $("#proyecto").val();

        var columns = [
            { "title":"TÍTULO","width": "30%" },
            { "title":"CAMPAÑA","width": "15%" },
            { "title":"TIPO","width": "10%" },
            { "title":"CATEGORÍA","width": "15%" },
            { "title":"FECHA CARGA","width": "10%" },
            { "title":"AUTORIZADO","width": "10%" },
            { "title":"SUBIDO POR","width": "10%" }
        ];

        var table = $('#my-table').DataTable( {
            "processing": true,
            "lengthChange": true,
            "responsive" : true,
            "searching": true,
            "ordering": true,
            "order": [[ 5, "desc" ]],
            "info": true,
            "autoWidth": false,
            "destroy": true,
            "columns": columns,
            "ajax": "controlador/get_elem_activos.php?filtro1="+filtro1+'&filtro2='+filtro2+'&filtro3='+filtro3+'&proy='+proy,
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
                { responsivePriority: 2, targets: 2 },
                { responsivePriority: 3, targets: 6 },
                {
                    "targets": [0],
                    "render": function(data, type, full) {
                        if(data=="SIN REGISTROS"){
                            return "<center><strong>"+data+"</strong></center>";
                        } else {
                            return data;
                        }
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
                        if (data!=null) {
                            return '<center>'+data+'</center>';
                        } else {
                            return "";
                        }
                    }
                },
                {
                    "targets": [3],
                    "render": function(data, type, full) {
                        if (data!=null) {
                            return data;
                        } else {
                            return "";
                        }
                    }
                },
                {
                    "targets": [4],
                    "render": function(data, type, full) {
                        if(data!=null){
                            return data;
                        } else {
                            return "";
                        }
                    }
                },
                {
                    "targets": [5],
                    "render": function(data, type, full) {
                        if (data==1) {
                            return "<center><img src='./vista/img/check_icon.png' style='width:20px;'></center>";
                        } else {
                            return "<center><img src='./vista/img/uncheck.png' style='width:20px;'></center>";
                        }
                    }
                },
                {
                    "targets": [6],
                    "render": function(data, type, full) {
                        if(data!=null){
                            return "<center>"+data+"</center>";
                        } else {
                            return "";
                        }
                    }
                },
            ],
        });
        $("th").css("background-color", "#4c88bb");
        $("th").css("color", "white");
    }
</script>