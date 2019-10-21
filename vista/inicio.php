<?php 
    session_start();
    if ($_SESSION['usuario'] == '') {
      header('Location: ./index.php');
    }
    require_once("configuracion/database.php");
    require_once("./modelo/usuario_model.php");
    $usr = new usuario_model();
    $campanas = $usr->get_campanas();
    $campanas_list = $usr->get_campanas();
    $usr_info = $usr->get_personal_info($_SESSION['id']);
    $usr_nombre = $usr_info[0]['nombre1'].' '.$usr_info[0]['apellido1'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Báyental | Compartido</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="./vista/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="./vista/fileinput/css/fileinput.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./vista/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="./vista/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Pace style -->
  <link rel="stylesheet" href="./vista/plugins/pace/pace.min.css">
  <!-- jQuery 3 -->
    <script src="./vista/bower_components/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="./vista/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="./vista/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="./vista/plugins/iCheck/all.css">
    <link rel="stylesheet" href="./vista/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="./vista/plugins/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="./vista/bower_components/select2/dist/css/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./vista/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="./vista/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="./vista/dist/css/skins/skin-purple-light.css">
    <link rel="stylesheet" href="./vista/dist/css/skins/skin-red.css">
    <link rel="stylesheet" href="./vista/datatables/datatables.min.css">

  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style type="text/css">
        .skin-purple .main-header .navbar .dropdown-menu li a {
            color: #333 !important;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('body').layout('fix');
        });
    </script>
</head>
<body class="hold-transition skin-purple sidebar-mini fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="./inicio.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">Báy</span>
      <!-- logo for regular state and mobile devices -->
      <!--<span class="logo-lg"><b>Báyental</b></span>-->
      <span class="logo-lg"><img src="./vista/img/bayental_logo_2.png" id="id_img_header" class="center-block img-responsive" style="height:50px;"/></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <?php if($usr->accesa_superadm($_SESSION['id'])==1){?>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-wrench"></i>&nbsp;&nbsp;Mantenimiento
              <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#" onclick="load_wrapper('./vista/usuarios.php',0,0,0,0,0);"><i class="fa fa-users"></i> Usuarios</a></li>
                <li><a href="#" onclick="load_wrapper('./vista/permisos.php',0,0,0,0,0);"><i class="fa fa-unlock"></i> Permisos</a></li>
                <!--<li><a href="#"><i class="fa fa-calendar-minus-o"></i> Campañas</a></li>-->
              </ul>
            </li>
          <?php }?>
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tienes 0 mensajes</li>
              <li class="footer"><a href="#">Ver todos los mensajes</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tienes 0 notificaciones</li>
              <li class="footer"><a href="#">Ver todas las notificaciones</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tienes 0 tareas</li>
              <li class="footer"><a href="#">Ver todas las tareas</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="./vista/img/avatar.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $usr_nombre;?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="./vista/img/avatar.png" class="img-circle" alt="User Image">
                <p>
                  <?php echo $usr_nombre;?>
                  <small>Báyental 2019</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" onclick="load_wrapper('./vista/cambia_password.php',0,0,0,0,0);" class="btn btn-default btn-flat">Cambiar Contraseña</a>
                </div>
                <div class="pull-right">
                  <a href="./controlador/logout.php" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->
  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="./vista/img/avatar.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $usr_nombre;?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Activo</a>
        </div>
      </div>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <div id="menu_principal">
      <?php foreach($campanas as $filas){
            $menu = $usr->get_menu_items($filas['id']);
      ?>
            <input type="hidden" id="section_title<?php echo $filas['id']?>" name="section_title<?php echo $filas['id']?>" value="<?php echo $filas['descripcion']?>">
            <div class="menu_n" id="menu<?php echo $filas['id'];?>" style="display:none;">
              <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MENÚ PRINCIPAL</li>
                <?php 
                  if($menu!=''){
                      foreach($menu as $lista){
                          if($lista['unico']==1){
                              if ($usr->valida_permiso_menu_unico($_SESSION['perfil'],$lista['id'],$filas['id'])==true) {
                              ?>
                                  <li><a href="#" onclick="load_wrapper('<?php echo $lista['ruta'];?>','<?php echo $lista['id'];?>',0,'<?php echo $lista['unico'];?>','<?php echo $filas['id'];?>','<?php echo $lista['docs']?>');">
                                      <i class="fa <?php echo $lista['glyphicon']?>"></i> <span><?php echo $lista['descripcion']; ?></span>
                                      </a>
                                  </li>   
                              <?php
                              }
                          } else {
                          ?>
                              <li class="treeview">
                                  <?php if ($usr->contiene_elementos_activos($lista['id'],$lista['campana'],$_SESSION['perfil'])==1) {?>
                                  <a href="#">
                                      <i class="fa <?php echo $lista['glyphicon']?>"></i> <span><?php echo $lista['descripcion']; ?></span>
                                      <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                      </span>
                                  </a>
                                  <?php }?>
                                  <ul class="treeview-menu">
                                  <?php
                                      $submenu = $usr->get_submenu_items($lista['id']);
                                      foreach ($submenu as $lista1) {
                                          if ($usr->valida_permiso_submenu($_SESSION['perfil'], $lista['id'], $lista1['id'], $filas['id'])==true) {
                                          ?>
                                            <li><a href="#" onclick="load_wrapper('<?php echo $lista1['ruta']; ?>','<?php echo $lista['id']?>','<?php echo $lista1['id']; ?>',0,'<?php echo $filas['id']; ?>','<?php echo $lista1['docs']?>');"><i class="fa <?php echo $lista1['glyphicon']; ?>"></i> <?php echo $lista1['descripcion']; ?></a></li>
                                          <?php
                                          }
                                      } ?>
                                  </ul>
                              </li>
                          <?php
                          }
                      }
                  }
              ?>
              </ul>
            </div>
      <?php } ?>
      </div>
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- =============================================== -->
  <!-- Content Wrapper. Contains page content --> 
  <div class="content-wrapper" id="main_content">
    <section class="content-header">
      <h1>
          Documentos
      </h1>
      <ol class="breadcrumb">
        <li><a href="./inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Documentos</li>
      </ol>
    </section>
    <section class="content">
      <div id="launcher">
        <div class="row">
          <?php foreach($campanas_list as $lista){?>
            <?php if($usr->accesa_campana($_SESSION['id'],$lista['id'])==true){?>
            <div class="col-md-4 col-xs-12">
                <div class="info-box"  style="height:54px;">
                    <a href="#" onclick="activa_menu(<?php echo $lista['id']?>);"><span class="info-box-icon <?php echo $lista['bg_color'];?>"><i class="glyphicon <?php echo $lista['glyphicon'];?>"></i></span></a>
                    <div class="info-box-content">
                        <span class="info-box-text">
                          <a href="#" onclick="activa_menu(<?php echo $lista['id']?>);"><h3><?php echo $lista['descripcion'];?></h3></a>
                        </span>
                    </div>
                </div>
            </div>
            <?php }?>
          <?php }?>
        </div>
      </div>
    </section>
  </div>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.0.0
    </div>
    <strong>Copyright &copy; 2019 <a href="http://www.bayental.com/" target='_blank'>Báyental BPO</a>.</strong> Todos los derechos reservados.
  </footer>
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.7 -->
<script src="./vista/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./vista/fileinput/js/fileinput.js"></script>
<script src="./vista/fileinput/js/locales/es.js"></script>
<!-- PACE -->
<script src="./vista/bower_components/PACE/pace.min.js"></script>
<!-- SlimScroll -->
<script src="./vista/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="./vista/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="./vista/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="./vista/plugins/input-mask/jquery.inputmask.js"></script>
<script src="./vista/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="./vista/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="./vista/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="./vista/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="./vista/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="./vista/plugins/iCheck/icheck.min.js"></script>
<script src="./vista/datatables/datatables.min.js"></script>
<script type="text/javascript" src="./vista/sweetalert/dist/sweetalert.min.js"></script>
<!-- FastClick -->
<script src="./vista/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="./vista/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./vista/dist/js/demo.js"></script>
<!-- page script -->
<script type="text/javascript">
  // To make Pace works on Ajax calls
  $(document).ajaxStart(function () {
    Pace.restart()
  });
  $('.ajax').click(function () {
    $.ajax({
      url: '#', success: function (result) {
        $('.ajax-content').html('<hr>Ajax Request Completed !')
      }
    })
  });

  function load_wrapper(url,id,id_sub,unique,proy,docs){
    if(url!=''){
        $('#main_content').load(url+'?id='+id+'&id_sub='+id_sub+'&unique='+unique+'&proy='+proy+'&docs='+docs);
    }
  }

  function activa_menu(id){
    var elem = "#menu"+id;
    var elem1 = "#section_title"+id;
    var proyect_name = $(elem1).val();
    $("#main_content").html("<section class='content-header'><h1>"+proyect_name+"</h1><ol class='breadcrumb'><li><a href='./inicio.php'><i class='fa fa-dashboard'></i> Inicio</a></li><li class='active'>Documentos</li></ol></section>");
    $(".menu_n").css("display","none");
    $(elem).css("display","block");
    $.ajax({
        type: "post",
        url: "controlador/get_carga_items.php",
        data: {
            id: id
        },
        success: function(datos) {
            if(datos!=""){
              var items = datos.split("|");
              $('#main_content').load(items[2]+'?id='+items[0]+'&id_sub=0'+'&unique='+items[3]+'&proy='+id+'&docs='+items[4]);
            }
        }
    });
  }
</script>
</body>
</html>
