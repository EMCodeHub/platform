<?php
session_start();
include_once('../conexion/conn_bbdd.php');
$ExisteAlumno = 0;  // no existe, de momento

////.........comprobar si  existe el email de $_POST["email"]
$FormatMaestros = "SELECT id
                     FROM vtalumnos   
                    WHERE    email = '%s' ";

$queMaestros = sprintf($FormatMaestros, $_POST['email']);

$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	$ExisteAlumno = 1;   //.................ya ha enviado el mail antes
}
mysqli_free_result($resMaestros);

if ($ExisteAlumno == 0) {
    	echo "<span class='rojo'>email_destino NO existe en vtalumnos (enviaremos igualmente)</span>";
} else {
	    echo "<span class='azul'>email_destino SÍ es alumno</span>";
}
?>