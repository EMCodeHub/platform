<?php
session_start();
include_once('../conexion/conn_bbdd.php');
$FormatMaestros = "insert into alumnosinscritos (id_curso, fecha_mail, nombre, apellidos, email_cliente, telefono, obser_cliente, email_receptor, ciudad,  agente_inscriptor)
values (3,'%s','%s','%s','%s','%s','%s','%s','%s','Web') ";
$queMaestros = sprintf($FormatMaestros, date("Y-m-d"), $_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['telefono'], $_POST['comentarios'], $_POST['emisorcorreo'], $_POST['ciudad']);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));

// GRABAMOS CONSULTA GENERAL, ASIGNADO A CURSO CON ID = 3
echo "OK";
?>