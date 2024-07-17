
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
$url_formulario = $DatosWeb->GetTrimValor('web_url')."/paginas/ConfirmacionInscripcion.php?C_idCurso=".rawurlencode($_REQUEST['NumIdCurso']);
$url_formulario .= "&C_nombre=".rawurlencode($_REQUEST['nombre']);
$url_formulario .= "&C_apellidos=".rawurlencode($_REQUEST['apellidos']);
$url_formulario .= "&C_email=".rawurlencode($_REQUEST['email']);
$url_formulario .= "&C_fechaMail=".date("Y-m-d");

?>

<title>Carta al alumno de Videotutoriales</title>
</head>

<body>

<?php

$FormatCarta = "SELECT id_curso,  titulo_cur,   carpetadeficheros, edicion,  descripcion_cur,  imaicono_cur,  programaPDF, autores,
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
    Estimado/a <?php echo $_POST['nombre']." ".$_POST['apellidos'] ;?>
    <p>Hemos recibido su solicitud de información:  </p>
 
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
    <td width="85%" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['titulo_cur'] ; ?></td>
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
   
<?php if (trim($rowRegistros['licencias_temporales']) != "") {?>  
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">
    Licencias</td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['licencias_temporales']; ?></td>
  </tr>
 <?php }?>   
 
  
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
  
<?php if (trim($rowRegistros['entidadescolaboradoras']) != "") {?> 
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Entidades colaboradoras</td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['entidadescolaboradoras']; ?></td>
  </tr>
 <?php }?>
<?php if (trim($rowRegistros['certificado_diploma']) != "") {?>  
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">
    Certificado</td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['certificado_diploma']; ?></td>
  </tr>
 <?php }?>   
<?php if (trim($rowRegistros['soporte']) != "") {?>  
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">
    Soporte</td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['soporte']; ?></td>
  </tr>
 <?php }?>   



  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Precio    </td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['preciotutorial']." ".$DatosWeb->GetTrimValor('moneda'); ?></td>
  </tr>

<tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">
    Su solicitud    </td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $_REQUEST['comentarios']; ?></td>
  </tr>
</table>


 <?php  if ($rowRegistros['programaPDF'] != "" ) { ?> 
       <p>Adjuntamos el programa del curso en formato PDF</p>
 <?php } ?>
 <br />
<p>En breve nos pondremos en contacto.</p>

<p>Para cualquier otra información puedes visitar nuestra web: <a href="<?php echo $DatosWeb->GetTrimValor('web_url'); ?>" > <?php echo $DatosWeb->GetTrimValor('web_dominio'); ?></a> o bien responder a este correo
</p>
<p>Gracias por tu confianza.</p>
<p>&nbsp;</p>
<p>Atentamente,</p>
<p> <?php echo $_POST['Nombre_correo']; ?></p>
<p>
<br/>
<!--## ............................ ................ ...... ..... ....... ......... ........ ###   --> 
<?php include_once('../paginas/CartaPie.php'); ?>
 

</body>
</html>
<?php } }?>