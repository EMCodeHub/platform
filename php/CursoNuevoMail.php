<?php
session_start();
include_once('../conexion/conn_bbdd.php');


$mailRepetido = 0;  // no repetido, de momento
$FormatMaestros = "select id_curso, nombre, apellidos, email_cliente, telefono, fecha_mail from alumnosinscritos
where id_curso =  %d
  and nombre   = '%s'    
  and apellidos =  '%s'
  and email_cliente = '%s' 
  and fecha_mail = '%s'
 ";
$queMaestros = sprintf($FormatMaestros, $_POST['NumIdCurso'], $_POST["nombre"], $_POST["apellidos"], $_POST["email"],date("Y-m-d"));
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	$mailRepetido = 1;   //.................ya ha enviado el mail antes
}
 
if ($mailRepetido == 0) {

	$FormatMaestros = "insert into alumnosinscritos (id_curso, fecha_mail, nombre, apellidos, email_cliente, telefono, obser_cliente, email_receptor, ciudad,  agente_inscriptor)
values (%d,'%s','%s','%s','%s','%s','%s','%s','%s','Web') ";
$queMaestros = sprintf($FormatMaestros, $_POST['NumIdCurso'],date("Y-m-d"), $_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['telefono'], $_POST['comentarios'], $_POST['emisorcorreo'], $_POST['ciudad']);
	
} else {
	$FormatMaestros = "
	update alumnosinscritos set
	obser_cliente = '%s',
	telefono      = '%s' 
	ciudad        =  '%s'
	where id_curso =  %d
      and nombre   = '%s'    
      and apellidos =  '%s'
      and email_cliente = '%s' 
      and fecha_mail = '%s'
	";
   $queMaestros = sprintf($FormatMaestros, $_POST["comentarios"],$_POST["telefono"],$_POST["ciudad"],$_POST["NumIdCurso"],$_POST["nombre"], $_POST["apellidos"],$_POST["email"],date("Y-m-d")); 	
}
 //..........ejecutar query                                                                                                        
 $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                         
 mysqli_free_result($resMaestros); 

echo "OK";
?>