<?php 
    session_start(); 
    require_once("../configuracion/database.php");
    require_once("../modelo/app_model.php");
    date_default_timezone_set("America/Lima");
    $fecha_actual = date("d/m/Y");
    $modulo = new app_model();
    $id = $_GET['id'];
    $id_sub = $_GET['id_sub'];
    $unique = $_GET['unique'];
    $proyecto = $_GET['proy'];
    $docs = $_GET['docs'];
    $titulo = $modulo->get_module_title($id,$unique);
    $camp_nombre = $modulo->get_nombre_campana($proyecto);
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $camp_nombre[0]['descripcion'];?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="./inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Documentos</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Info boxes -->
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-music"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Audios</span>
                    <span class="info-box-number"><div id="aud">0</div></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-file-word-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Documentos</span>
                    <span class="info-box-number"><div id="doc">0</div></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-file-text-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Otros</span>
                    <span class="info-box-number"><div id="oth">0</div></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>
    <!-- /.row -->

    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa <?php echo $titulo[0]['glyphicon'];?>"></i>&nbsp&nbsp<?php echo $titulo[0]['descripcion'];?></h3>
        </div>
        <div class="box-body">
            <input type="hidden" id="proyecto" name="proyecto" value="<?php echo $proyecto;?>">
            <input type="hidden" id="docs" name="docs" value="<?php echo $docs;?>">
            <input type="hidden" id="id_menu" name="id_menu" value="<?php echo $id;?>">
            <input type="hidden" id="id_submenu" name="id_submenu" value="<?php echo $id_sub;?>">
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="datapicker_1">Fecha Inicial</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker1" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?php echo $fecha_actual;?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="datepicker_2">Fecha Final</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker2" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?php echo $fecha_actual;?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="b_valor_2">Texto a buscar</label>
                        <input type="text" class="form-control" id="b_valor_2" placeholder="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="buscar_audio" style="float:right;">
                            <i class="glyphicon glyphicon-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-folder-open-o"></i>&nbsp&nbspArchivos</h3>
        </div>
        <div class="box-body">
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
        <div class="box-footer">
        <p>&nbsp;</p>
        </div>
    </div>
</section>
<!-- /.content -->
<script>
  $(function () {
    var proy = $("#proyecto").val();
    var docs = $("#docs").val();
    $('.select2').select2({
        language: {
            noResults: function () {
                return "No se encontraron resultados";
            }
        }
    });
    get_total();
    mostrar(proy);
  });
    
  $("#buscar_audio").click(function(){
      var proy = $("#proyecto").val();
      update_count(proy);
      mostrar(proy);
  });

  function get_total(){
    var proy = $("#proyecto").val();
    var id_menu = $("#id_menu").val();
    var id_submenu = $("#id_submenu").val();
    var docs = $("#docs").val();

    $.ajax({
        type: "post",
        url: "controlador/get_total.php",
        data: {
            proy: proy,
            id_menu: id_menu,
            id_submenu: id_submenu,
            docs: docs
        },
        success: function(datos) {
            var parts = datos.split('|');
            $("#aud").html(parts[0]);
            $("#doc").html(parts[1]);
            $("#oth").html(parts[2]);
        }
    });
  }

  function update_count(proy){
    var fecha_1="";
    var fecha_2="";
    var filtro2="";
    var texto="";
    var params="";
    var docs = $("#docs").val();
    var id_menu = $("#id_menu").val();
    var id_submenu = $("#id_submenu").val();

    fecha_1 = $("#datepicker1").val();
    fecha_2 = $("#datepicker2").val();
    texto = document.getElementById("b_valor_2").value;

    var url1 = "";
    params="?proy="+proy+"&id_menu="+id_menu+"&id_submenu="+id_submenu+"&fech1="+fecha_1+"&fech2="+fecha_2+"&texto="+texto+"&docs="+docs;
    url1 = "controlador/update_count.php"+params;
    
    $.ajax({
        type: "post",
        url: url1,
        data: {
            proy: proy
        },
        success: function(datos) {
            var parts = datos.split('|');
            $("#aud").html(parts[0]);
            $("#doc").html(parts[1]);
            $("#oth").html(parts[2]);
        }
    });
  }

  function mostrar(proy){
        var fecha_1="";
        var fecha_2="";
        var filtro2="";
        var texto="";
        var params="";
        var id_menu = $("#id_menu").val();
        var id_submenu = $("#id_submenu").val();
        var docs = $("#docs").val();
 
        fecha_1 = document.getElementById("datepicker1").value;
        fecha_2 = document.getElementById("datepicker2").value;
        texto = document.getElementById("b_valor_2").value;

        var columns = [
            { "title":"ID","width": "10%" },
            { "title":"ARCHIVO","width": "60%" },
            { "title":"OPCIONES","width": "30%" }
        ];

        params="?proy="+proy+"&id_menu="+id_menu+"&id_submenu="+id_submenu+"&fech1="+fecha_1+"&fech2="+fecha_2+"&texto="+texto+"&docs="+docs;

        var table = $('#my-table').DataTable( {
            "processing": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "order": [[ 0, "desc" ]],
            "info": true,
            "autoWidth": false,
            "destroy": true,
            "columns": columns,
            "ajax": "controlador/get_audios.php"+params,
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
            "responsive" : true,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    "targets": [0],
                    "render": function(data, type, full) {
                    return data;
                    }
                },
                {
                    "targets": [1],
                    "render": function(data, type, full) {
                        if(data=='SIN REGISTROS'){
                            return "<center><strong>"+data+"</strong></center>";
                        } else {
                            if(data==null){
                                data="<span style='color:red;'><strong>ERROR EN EL NOMBRE DEL ELEMENTO</strong></span>";
                            }
                            return data;
                        }
                    }
                },
                {
                    "targets": [2],
                    "render": function(data, type, full) {
                    return "<center>"+data+"</center>";
                    }
                },
            ],
        });
        $("th").css("background-color", "#4c88bb");
        $("th").css("color", "white");
        /*setInterval( function () {
            table.ajax.reload();
        }, 4000 );*/
    }

    $('#datepicker1').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/aaaa' });
    $('#datepicker2').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/aaaa' });

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

    $('#datepicker1').datepicker({
      autoclose: true,
      format: "dd/mm/yyyy",
      todayHighlight: true,
      todayBtn: true,
    });

    $('#datepicker2').datepicker({
      autoclose: true,
      format: "dd/mm/yyyy",
      todayHighlight: true,
      todayBtn: true,
    });
</script>