
<!doctype html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
session_start();
if ($_SESSION['pruebas'] == 1) {
   $_REQUEST['NumIdCurso'] = 1;
}
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
?>

<title>Carta confirmación inscripción a curso gratis</title>
</head>

<body>

<?php
//......obtener número de solicitud..............
$id_solicitud = 0;
$numeroPrimo  = $DatosWeb->GetTrimValor('numeroprimo');
$FormatMaestros = "SELECT id 
                     FROM vtsolicitudes
                    WHERE id_curso =  %d
                      and nombre   = '%s'    
                      and apellidos =  '%s'
                      and email_cliente = '%s' 
                      and fecha_mail = '%s'
                      and tipomensaje = '%s' ";
$queMaestros = sprintf($FormatMaestros, $_POST['NumIdCurso'], $_POST["nombre"], $_POST["apellidos"], $_POST["email"],date("Y-m-d"),$_POST["tipo"]);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
    while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {			  
			$id_solicitud =  $rowRegistros['id'];
	  }

}
$Referencia = $id_solicitud * $numeroPrimo;
$url_formulario = $DatosWeb->GetTrimValor('web_url')."/paginas/VTAltaAlumnoGts.php?Referencia=".rawurlencode($Referencia);
 //.........obtener correo comercial
$correoE = "";
$NombreCorreoE = "";
$FormatCorreo = "SELECT A.id_curso,  A. id_mailcomer,  
                           B.id AS IDEMAIL, B.correoelectronico , B.nombre_correo  
                    FROM   vtcursos A, emailscomerciales B 
                    WHERE  A.id_mailcomer = B.id
                           and A.id_curso = %d";
$queCorreo = sprintf($FormatCorreo,$_REQUEST['NumIdCurso']); 
$resCorreo = mysqli_query($conexion, $queCorreo) or die(mysqli_error($conexion));
$totCorreo = mysqli_num_rows($resCorreo);

if ($totCorreo == 1) {
    while ($rowRegistros = mysqli_fetch_assoc($resCorreo)) {			  
			$correoE =  $rowRegistros['correoelectronico'];
			$NombreCorreoE =  $rowRegistros['nombre_correo'];
	  }
}
mysqli_free_result($resCorreo);	


//.........................................datos del curso
$FormatCarta = "SELECT id_curso,  web_titulo,   carpetadeficheros, edicion,  descripcion_cur,  imaicono_cur,  programaPDF, autores,
                       programasutilizados, preciotutorial,  duracion,  id_mailcomer,  entidadescolaboradoras,  objetivos, soporte, licencias_temporales, certificado_diploma,
                       emailscomerciales.correoelectronico, emailscomerciales.nombre_correo
                  FROM vtcursos , emailscomerciales  
                 WHERE vtcursos.id_mailcomer = emailscomerciales.id
                   and id_curso = %d";
 $queCarta = sprintf($FormatCarta,$_REQUEST['NumIdCurso']);
 $resCarta = mysqli_query($conexion, $queCarta) or die(mysqli_error($conexion));
 $totCarta = mysqli_num_rows($resCarta);
 
 if ($totCarta> 0) { 

 while ($rowRegistros = mysqli_fetch_assoc($resCarta)) {
	 $imagenCurso = $DatosWeb->GetTrimValor('web_url')."/VIDEOTUTORIALES/".$rowRegistros['carpetadeficheros']."/".$rowRegistros['imaicono_cur'];

?>

<?php include_once('../paginas/CartaCabecera.php'); ?>  
    
<!--## .........INICIO sección modificable ................... ............. ......... ........ ###   -->   
  

<table width="97%" border="0">
  <tr>
    <td width="79%">
    
    <p>Bienvenido/a a nuestra aula </p><?php echo $_REQUEST['nombre']?>
 
    <BR>
    </td>
    <td width="21%">
        <img src="<?php echo $imagenCurso ;?>" width="240" height="160">
    </td>
  </tr>
</table>  

<table width="97%" border="1">
 <tr>
    <td width="15%"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Videotutorial</td>
    <td width="85%" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['web_titulo'] ; ?></td>
  </tr>
  
  
  <tr>
    <td width="15%"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Edición</td>
    <td width="85%" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['edicion']; ?></td>
  </tr>
  
  
  
  
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Presentación</td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo str_replace("\r\n","<br>",$rowRegistros['descripcion_cur']); ?></td>
  </tr>



  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Objetivos</td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo str_replace("\r\n","<br>",$rowRegistros['objetivos']); ?></td>
  </tr>
  
  
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Programas utilizados</td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['programasutilizados']; ?></td>
  </tr>
  
  
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Duración</td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['duracion']; ?></td>
  </tr>
  
<?php if (trim($rowRegistros['autores']) != "") {?>  
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">
    Editor    </td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['autores']; ?></td>
  </tr>
 <?php }?>   
  


</table>
<br>

<p align="center" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold;  font-size:1.5em"><a href="<?php echo $url_formulario ?>">CONFIRMA tu inscripción pulsando este enlace</a></p>


<!--## .........FIN sección modificable ................... ............. ......... ........ ###   -->   
    
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Para cualquier otra información puedes visitar nuestra web: <a href="<?php echo $DatosWeb->GetTrimValor('web_url'); ?>" > <?php echo $DatosWeb->GetTrimValor('web_dominio'); ?></a> o bien responder a este correo
</p>
<p>Gracias por tu confianza.</p>
<p>&nbsp;</p>
<p>Atentamente,</p>
<p> <?php echo $NombreCorreoE; ?></p>
<p>
<br/>
<!--## ............................ ................ ...... ..... ....... ......... ........ ###   --> 
<?php include_once('../paginas/CartaPie.php'); ?>

</body>
</html>
<?php } }?>