<?php
session_start();
include_once('../conexion/conn_bbdd.php');
$FormatMaestros = "insert into alumnosinscritos (id_curso, fecha_mail, nombre, apellidos, email_cliente, telefono, obser_cliente, email_receptor, ciudad, fichero_zipdwg, agente_inscriptor)
values (1,'%s','%s','%s','%s','%s','%s','%s','%s','%s','Web') ";
$queMaestros = sprintf($FormatMaestros, date("Y-m-d"), $_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['telefono'], $_POST['comentarios'], $_POST['emisorcorreo'], $_POST['ciudad'], $_POST['fichero']);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
echo "OK";
?>