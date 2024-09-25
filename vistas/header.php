<?php 
if (strlen(session_id()) < 1) 
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>QACHUU ALOOM</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../public/img/favicon.ico">

    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">    
    <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">

    <!-- FullCalendar -->
    <link rel="stylesheet" href="../public/fullcalendar/fullcalendar.min.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml: true,
            version: 'v3.2'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<header class="main-header">
    <a href="escritorio.php" class="logo">
        <span class="logo-mini"><b>SQA</b></span>
        <span class="logo-lg"><b>QACHUU</b> ALOOM</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                            <p><?php echo $_SESSION['nombre'].' '.$_SESSION['cargo']; ?></p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Perfil</a>
                            </div>
                            <div class="pull-right">
                                <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Salir</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <br>
            <?php 
            if ($_SESSION['escritorio'] == 1) {
                echo '<li><a href="escritorio.php"><i class="fa fa-dashboard"></i> <span>Escritorio</span></a></li>';
            }
            ?>

            <?php 
            if ($_SESSION['grupos'] == 1) {
                echo '<li class="treeview">
                    <a href="#">
                        <i class="fa fa-sitemap"></i> <span>Comunidades</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="grupos.php"><i class="fa fa-circle-o"></i> Grupos</a></li>
                    </ul>
                </li>';
            }
            ?>

            <!-- Nueva opción de menú para Eventos -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-calendar"></i> <span>Eventos</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="eventos.php"><i class="fa fa-circle-o"></i> Ver Eventos</a></li>
                </ul>
            </li>

            <?php
            if(isset($_GET["idgrupo"])):?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-check"></i> <span>Asistencia</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="asistencia.php?idgrupo=<?php echo $_GET["idgrupo"]; ?>"><i class="fa fa-circle-o"></i> Agregar</a></li>
                </ul>
            </li>
            <!-- Otras opciones... -->
            <?php endif; ?>

            <?php 
            if ($_SESSION['acceso'] == 1) {
                echo '<li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i> <span>Acceso</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                        <li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
                    </ul>
                </li>';
            }
            ?>
            <li><a href="#"><i class="fa fa-question-circle"></i> <span>Ayuda</span><small class="label pull-right bg-yellow">PDF</small></a></li>
            <li><a href="https://www.qachuualoom.org" target="_blanck"><i class="fa fa-exclamation-circle"></i> <span>Acerca de</span><small class="label pull-right bg-yellow">ComCod</small></a></li>   
        </ul>
    </section>
</aside>
