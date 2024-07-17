<?php
session_start();
include_once('../conexion/conn_bbdd.php');
$solicitudRepetida = 0;  // no repetido, de momento
 //.........obtener correo comercial
/*$correoE = "";
$NombreCorreoE = "";
$FormatCorreo = "SELECT correoelectronico , nombre_correo  
                   FROM emailscomerciales 
                   WHERE tipocorreo = 1 limit 1";
$queCorreo = $FormatCorreo;
$resCorreo = mysqli_query($conexion, $queCorreo) or die(mysqli_error($conexion));
$totCorreo = mysqli_num_rows($resCorreo);

if ($totCorreo == 1) {
    while ($rowRegistros = mysqli_fetch_assoc($resCorreo)) {			  
			$correoE       =  $rowRegistros['correoelectronico'];
			$NombreCorreoE =  $rowRegistros['nombre_correo'];
	  }
}
mysqli_free_result($resCorreo);	*/

////.........comprobar si ya existe
$FormatMaestros = "
                   SELECT id
                     FROM asesoriasesiones   
                    WHERE    f_sesion = '%s'
                      and    activo = 1 
                      and    f_alta = '%s' 
                      and    email = '%s'
                      and    h_inicio = '%s' 
                      and    h_final = '%s' 
                      and    ciudad = '%s' 
                      and    skype_usuario = '%s'
                      and    telefono = '%s'   
                      and    pais = '%s'
                      and    observa_cliente = '%s'
                      and    nombre = '%s' 
                      and    apellidos  = '%s' ";

$queMaestros = sprintf($FormatMaestros, $_POST['Dia'],date("Y-m-d"),$_POST["Correo"] , $_POST["Hora"], $_POST["Hora"] +3,$_POST["Ciudad"], $_POST["UsuSkype"],$_POST["Telefono"],$_POST["Pais"],str_replace("<","[",$_POST["Observaciones"]),$_POST["Nombre"],$_POST["Apellidos"]);

$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	$solicitudRepetida = 1;   //.................ya ha enviado el mail antes
}
mysqli_free_result($resMaestros);

if ($solicitudRepetida == 0) {
	$FormatMaestros = "INSERT INTO asesoriasesiones (activo, f_alta, f_confirmacion, f_sesion, h_inicio, h_final, ciudad, 
                             skype_usuario, telefono, email, pais, observa_cliente, nombre, apellidos  )
                      values (%d,'%s', null , '%s', %d, %d, '%s', '%s', '%s', '%s', '%s', '%s',  '%s', '%s') ";
    $queMaestros = sprintf($FormatMaestros, 1,date("Y-m-d"), $_POST['Dia'],$_POST['Hora'] ,$_POST['Hora'] + 3, $_POST['Ciudad'], $_POST['UsuSkype'], $_POST['Telefono'], $_POST['Correo'],  $_POST['Pais'],  str_replace("<","[",$_POST["Observaciones"]),  $_POST['Nombre'], $_POST['Apellidos']);
 

 
 
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                         
    mysqli_free_result($resMaestros); 
    
 
    
    
}  

echo "OK";
?>