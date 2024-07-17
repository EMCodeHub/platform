<?php
session_start();
include_once('../conexion/conn_bbdd.php');
$FormatMaestros = "insert into vtsolicitudes (id_curso, lotedecursos, fecha_mail, email_cliente, tipomensaje, nombre, apellidos, telefono, obser_cliente, agente_inscriptor, email_receptor)
values (3,'%s','%s', '%s', '%s' ,'%s', '%s', '%s', '%s','Web','%s' ) ";
$queMaestros = sprintf($FormatMaestros,'DEVOLUCION COMPRA',date("Y-m-d"),$_POST['email'],'SOLICITUD DEVOLUCION',$_POST['nombre'],$_POST['apellidos'], $_POST['telefono'],$_POST['comentarios'],$_POST['emisor_correo']);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));

// GRABAMOS CONSULTA GENERAL, ASIGNADO A CURSO CON ID = 3
echo "OK";
?>