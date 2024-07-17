<?php
session_start();
include_once('../conexion/conn_bbdd.php');

// FUNCIONES: ....................
//.......................................................
function Graba1($conexion) {
  $FormatMaestros = "UPDATE vtalumnos 
                        SET alias_foro = '%s',
                            alias_comment = '%s'
                      WHERE id = %d";
    
$queMaestros = sprintf($FormatMaestros, $_POST['alias'], $_POST['descripcion'], $_SESSION['NumeroUsuario']);

$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
mysqli_free_result($resMaestros); 
return true;  	
}
function Graba2($conexion) {
  $FormatMaestros = "UPDATE vtalumnos 
                        SET alias_foro = '%s',
                            alias_comment = '%s',
                            pwd = '%s'
                      WHERE id = %d";
    
$queMaestros = sprintf($FormatMaestros, $_POST['alias'], $_POST['descripcion'], $_POST['palabra'], $_SESSION['NumeroUsuario']);

$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
mysqli_free_result($resMaestros); 
return true;  	
}		  
//......................................
$resul = false;
if (strlen($_POST['palabra']) > 0) {
    $resul = Graba2($conexion);
} else {
    $resul = Graba1($conexion);
}


if ($resul) {
    echo "OK";
} else {
       echo "ERROR Grabando Perfil";
}
?>