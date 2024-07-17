<?php
session_start();
include_once('../conexion/conn_bbdd.php');
$FormatMaestros = "UPDATE ctr_ficheros
                        SET descripcion = '%s'
                      WHERE id = %d";
$queMaestros = sprintf($FormatMaestros, $_POST['texto'], $_POST['id']);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
mysqli_free_result($resMaestros); 
echo "OK";
?>