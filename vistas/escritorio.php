<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

require 'header.php';

if ($_SESSION['escritorio']==1) {
$user_id=$_SESSION["idusuario"];
  require_once "../modelos/Consultas.php";
  $consulta = new Consultas();
  $rsptav = $consulta->cantidadalumnos($user_id);
  $regv=$rsptav->fetch_object();
  $totalestudiantes=$regv->total_alumnos;
  $cap_almacen=3000;

 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="panel-body">
<?php 
  $rspta=$consulta->cantidadgrupos($user_id);

// Arreglo de códigos hexadecimales de colores sólidos
$colores = [
    "#FF5733", "#33FF57", "#3357FF", "#FF33A1", "#33FFF5", 
    "#F5FF33", "#A133FF", "#FF8F33", "#33FFA8", "#FF3333",
    "#33A1FF", "#A1FF33", "#8F33FF", "#33FF8F", "#FFA133",
    "#FF33F5", "#33F5FF", "#57FF33", "#FF338F", "#33FF33",
    "#F533FF", "#33FF57", "#FF5733", "#338FFF"
];

$colores_usados = []; // Guardar colores ya usados

while ($reg=$rspta->fetch_object()) {
    $idgrupo=$reg->idgrupo;
    $nombre_grupo=$reg->nombre;
    
    if (count($colores) > 0) {
        // Selecciona un color aleatorio sin repetir
        $indice_color = array_rand($colores);
        $color_seleccionado = $colores[$indice_color];

        // Elimina el color seleccionado del array para evitar que se repita
        unset($colores[$indice_color]);

        // Reindexar el array después de eliminar un color
        $colores = array_values($colores);

        // Almacena el color usado en un arreglo por si necesitas revisarlo más tarde
        $colores_usados[] = $color_seleccionado;
    } else {
        echo "No hay suficientes colores para todos los grupos.";
        break;
    }
?>

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
    <div class="box collapsed-box" style="background-color: <?php echo $color_seleccionado; ?>;">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $nombre_grupo; ?></h3>

            <div class="box-tools pull-right">
                <span data-toggle="tooltip" title="" class="badge" data-original-title="Cantidad de Estudiantes">
                  <?php 
                    $rsptag=$consulta->cantidadg($user_id,$idgrupo);
                    while ($regrupo=$rsptag->fetch_object()) {
                      echo $regrupo->total_alumnos;
                    }
                   ?>
                </span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="display: none;">
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages">
                <!-- Message. Default to the left -->
                <div class="direct-chat-msg">
                    <?php
                    $rsptas=$consulta->cantidadalumnos_porgrupo($user_id,$idgrupo);
                    while ($reg=$rsptas->fetch_object()) {
                        if (empty($reg->image)){
                            echo ' <img class="img-circle" src="../files/articulos/anonymous.png" height="50px" width="50px">';
                        } else {
                            echo '<img class="img-circle" src="../files/articulos/'. $reg->image.'" height="50px" width="50px">';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="box-footer" style="">
            <a href="vista_grupo.php?idgrupo=<?php echo $idgrupo; ?>" class="btn btn-default form-control">VER <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<?php 
} // End while 
?>

</div>
<!--fin centro-->
      </div>
      </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>

 <?php 
}

ob_end_flush();
?>