
<?php
session_start();
?>
<!doctype html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Carta confirmación reserva sesión asesoría</title>
</head>

<body>

<?php
include_once('../conexion/conn_bbdd.php');
//......obtener número de solicitud..............
$id_solicitud = 0;
$numeroPrimo  = 1229;
    
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

$queMaestros = sprintf($FormatMaestros, $_POST['Dia'],date("Y-m-d"),$_POST["Correo"] , $_POST["Hora"], $_POST["Hora"] +3,$_POST["Ciudad"], $_POST["UsuSkype"],$_POST["Telefono"],$_POST["Pais"],$_POST["Observaciones"],$_POST["Nombre"],$_POST["Apellidos"]);

$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
    while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {			  
			$id_solicitud =  $rowRegistros['id'];
	  }

}
    
 
$Referencia = $id_solicitud * $numeroPrimo;
$url_formulario = "https://medifestructuras.com/paginas/AsesoriaAltaAlumnoConfirmSesion.php?Referencia=".rawurlencode($Referencia);
 //.........obtener correo comercial
$correoE = "";
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
mysqli_free_result($resCorreo);	


//.........................................datos del curso
$FormatCarta = "SELECT id, activo, f_alta, f_confirmacion, f_sesion, h_inicio, h_final, ciudad, 
                             skype_usuario, telefono, email, pais, observa_cliente, observa_medif, id_alumno, nombre, apellidos  
                        FROM asesoriasesiones   
                       WHERE id = %d";
 $queCarta = sprintf($FormatCarta,$id_solicitud);
 $resCarta = mysqli_query($conexion, $queCarta) or die(mysqli_error($conexion));
 $totCarta = mysqli_num_rows($resCarta);
 
 if ($totCarta > 0) { 

 while ($rowRegistros = mysqli_fetch_assoc($resCarta)) {
	 $imagenCurso = "https://medifestructuras.com/imagenes/AsesoriaSesion.jpg";
?>

<table width="100%" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px">
  <tr>
    <td width="6%" rowspan="6"><img src="https://medifestructuras.com/imagenes/logos/LogoMedif.jpg" width="66" height="100"></td>
    <td width="1%" rowspan="6">&nbsp;</td>
    <td width="93%">&nbsp;</td>
  </tr>
  <tr>
    <td>CONSULTORIA Y DISEÑO DE ESTRUCTURAS</td>
  </tr>
  <tr>
    <td>Calle 6 de Diciembre y Bosmediano</td>
  </tr>
  <tr>
    <td>Torres del Norte. Junto CNE. Departamento 3B</td>
  </tr>
  <tr>
    <td>Quito </td>
  </tr>
  <tr>
    <td>Teléfono: +593997070242 
      <hr style="color: #0056b2;" />
    </td>
  </tr>
</table>

<br>
  

<table width="97%" border="0">
  <tr>
    <td width="79%">
    
    <p>Bienvenido/a a nuestro servicio de Asesoría on-line, </p><?php echo $_REQUEST['Nombre']?>
    <p>En la videoconferencia podrás observar cómo realizamos los cálculos que propones, obtener los planos y la documentación de obra</p>
    <p>Es necesario CONFIRMAR la reserva:</p>
    <BR>
    </td>
    <td width="21%">
        <img src="<?php echo $imagenCurso ;?>" width="240" height="130">
    </td>
  </tr>
</table>  

<table width="97%" border="1">
 <tr>
    <td width="15%"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Día</td>
    <td width="85%" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['f_sesion'] ; ?></td>
  </tr>
  
  <tr>
    <td width="15%"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Hora</td>
    <td width="85%" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['h_inicio']; ?></td>
  </tr>

  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Usuario Skype</td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['skype_usuario']; ?></td>
  </tr>

  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Tema</td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['observa_cliente']; ?></td>
  </tr>
  
  
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Nuestro usuario Skype</td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo "edumedvi@hotmail.com"; ?></td>
  </tr>

</table>
<br>



<p align="center"style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:1.5em"><a href="<?php echo $url_formulario ?>">CONFIRMA tu RESERVA de ASESORÍA pulsando este enlace</a></p>


<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Para cualquier otra información puedes visitar nuestra web: <a href="https://medifestructuras.com">medifestructuras.com</a> o bien responder a este correo
</p>
<p>Gracias por tu confianza.</p>
<p>&nbsp;</p>
<p>Atentamente,</p>
<p> <?php echo $NombreCorreoE; ?></p>
<p><br>
 

</body>
</html>
<?php } }?>