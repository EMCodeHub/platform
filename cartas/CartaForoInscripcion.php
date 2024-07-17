
<?php
session_start();
?>
<!doctype html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Carta confirmación inscripción a Foros</title>
</head>

<body>

<?php
include_once('../conexion/conn_bbdd.php');
// FUNCIONES ........................................
    function NumeroSolicitud($mail,$conexion) {
    $numero = 0;
	$FormatMaestros = "SELECT id 
	                   FROM forosolicitudes
	                   WHERE email = '%s'";	                   
    $queMaestros = sprintf($FormatMaestros, trim($mail));
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros); 
    if ($totMaestros > 0){
	   while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		$numero = $rowMaestros['id'];
	   }
    }  
    return $numero;
}
    
    

  $nombre       = $_REQUEST['nombre'];
  $descripcion  = $_REQUEST['descripcion'];
  $email        = trim(strtolower($_REQUEST['email']));
  $palabra      = $_REQUEST['palabra'];


//......obtener número de solicitud..............
$id_solicitud = NumeroSolicitud($email ,$conexion);
$numeroPrimo  = 1229;
$Referencia = $id_solicitud * $numeroPrimo;
//$url_formulario = "https://medifestructuras.com/paginas/VTAltaAlumnoGts.php?Referencia=".rawurlencode($Referencia);
$url_formulario = "https://medifestructuras.com/paginas/ForoAltaAlumno.php?Referencia=".rawurlencode($Referencia);
 //.........obtener correo comercial
$NombreCorreoE = "Eduardo Mediavilla";

//........................................
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
    <td>
      <hr style="color: #0056b2;" />
    </td>
  </tr>
</table>

<br>
  

<table width="97%" border="0">
  <tr>
    <td width="70%">
    
    <p>Bienvenido/a a nuestra Comunidad de Foros </p><?php echo $_REQUEST['nombre']?>
 
    <BR>
    </td>
    <td width="30%">
        <img src="https://medifestructuras.com/imagenes/Demo_Cype_CAD.jpg" width="372" height="120">
    </td>
  </tr>
</table>  

<table width="97%" border="1">
 <tr>
    <td width="15%"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Usuario</td>
    <td width="85%" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $email  ; ?></td>
  </tr>
  
  
  <tr>
    <td width="15%"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Contraseña</td>
    <td width="85%" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $palabra; ?></td>
  </tr>

</table>
<br>
<br>


<p align="center"><a href="<?php echo $url_formulario ?>">CONFIRMA tu inscripción pulsando este enlace</a></p>


<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Para cualquier otra información puede visitar nuestra web: <a href="https://medifestructuras.com">medifestructuras.com</a> o bien responder a este correo
</p>
<p>Gracias por su confianza.</p>
<p>&nbsp;</p>
<p>Atentamente,</p>
<p> <?php echo $NombreCorreoE; ?></p>
<p><br>
 

</body>
</html>
