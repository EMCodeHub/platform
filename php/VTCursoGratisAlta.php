<?php
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('ValidaLoginScript.php');
include_once('ParametrosClass.php');
$mailRepetido = 0;  // no repetido, de momento
 //.........obtener correo comercial
$correoE = "";
$NombreCorreoE = "";
$FormatCorreo = "SELECT A.id_curso,  A. id_mailcomer,  
                           B.id AS IDEMAIL, B.correoelectronico , B.nombre_correo  
                    FROM   vtcursos A, emailscomerciales B 
                    WHERE  A.id_mailcomer = B.id
                           and A.id_curso = %d";
$queCorreo = sprintf($FormatCorreo,$_POST['NumIdCurso']); 
$resCorreo = mysqli_query($conexion, $queCorreo) or die(mysqli_error($conexion));
$totCorreo = mysqli_num_rows($resCorreo);

if ($totCorreo == 1) {
    while ($rowRegistros = mysqli_fetch_assoc($resCorreo)) {			  
			$correoE =  $rowRegistros['correoelectronico'];
			$NombreCorreoE =  $rowRegistros['nombre_correo'];
	  }
}
mysqli_free_result($resCorreo);	


$FormatMaestros = "select id_curso, nombre, apellidos, email_cliente, telefono, fecha_mail 
                   from vtsolicitudes
  where id_curso =  %d
  and nombre   = '%s'    
  and apellidos =  '%s'
  and email_cliente = '%s' 
  and fecha_mail = '%s'
  and tipomensaje = '%s'
 ";
$queMaestros = sprintf($FormatMaestros, $_POST['NumIdCurso'], $_POST["nombre"], $_POST["apellidos"], $_POST["email"],date("Y-m-d"),$_POST["tipo"]);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	$mailRepetido = 1;   //.................ya ha enviado el mail antes
}
 
if ($mailRepetido == 0) {
	CompruebaDatosSolicitud($conexion);
	$FormatMaestros = "insert into vtsolicitudes (id_curso, lotedecursos, fecha_mail, tipomensaje, nombre, apellidos, email_cliente, telefono, obser_cliente, email_receptor, ciudad,  agente_inscriptor)
values (%d,'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','Web') ";
$queMaestros = sprintf($FormatMaestros, $_POST['NumIdCurso'],$_POST['NumIdCurso'],date("Y-m-d"),$_POST['tipo'] ,$_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['telefono'], $_POST['comentarios'], $correoE, $_POST['ciudad']);
}
 //..........ejecutar query                                                                                                        
 $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                         
 mysqli_free_result($resMaestros); 

echo "OK";
?>