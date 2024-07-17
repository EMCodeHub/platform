
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

<title>Carta con datos bancarios para transferencias manuales</title>
</head>

<body>

<?php
$entidadBancaria = "";
$cuentaBancaria =  "";
$obserBancaria =  "";
$benefBancaria = "";
//-----------------------------------------datos de la cuenta
$FormatBanco = "SELECT transfer_cuenta, transfer_entidad, transfer_obser
                  FROM vtparametros";
 $queBanco = sprintf($FormatBanco);
 $resBanco = mysqli_query($conexion, $queBanco) or die(mysqli_error($conexion));
 $totBanco = mysqli_num_rows($resBanco);
 
 if ($totBanco > 0) { 
   while ($rowRegistros = mysqli_fetch_assoc($resBanco)) {	
	   $entidadBancaria = $rowRegistros['transfer_entidad'];
       $cuentaBancaria  = $rowRegistros['transfer_cuenta'];
       $obserBancaria   = $rowRegistros['transfer_obser'];
	   $benefBancaria   = $rowRegistros['transfer_beneficiario'];
   }
}
mysqli_free_result($resBanco);

//.........................................datos del curso
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
    
    <p>Según su solicitud le informamos nuestra cuenta bancaria y datos del curso que desea adquirir:   </p>
 
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


</table>
<br>
<br>
<table width="97%" border="1">
  
  <tr>
    <td  width="15%"   bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Entidad</td>
    <td  width="85%"  style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $entidadBancaria; ?></td>
  </tr>
  
  
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Cuenta</td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $cuentaBancaria; ?></td>
  </tr>
  
  <?php if (trim($benefBancaria) != "") {?>  
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">
    Beneficiario </td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $benefBancaria; ?></td>
  </tr>
 <?php }?>   
  
  
<?php if (trim($obserBancaria) != "") {?>  
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">
    Observaciones    </td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $obserBancaria; ?></td>
  </tr>
 <?php }?>   
  
 
</table>

<p>Una vez haya realizado la transferencia bancaria es IMPORTANTE que RESPONDA a este correo, o ENVIE un nuevo mail informando del hecho, así podremos otorgarle la licencia de uso lo antes posible.</p>

<?php  if ($rowRegistros['programaPDF'] != "" ) { ?> 
       <p>Adjuntamos el programa del curso en formato PDF</p>
 <?php } ?>

<!--## .........FIN sección modificable ................... ............. ......... ........ ###   -->   
    
<p>&nbsp;</p>
<p>&nbsp;</p>
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