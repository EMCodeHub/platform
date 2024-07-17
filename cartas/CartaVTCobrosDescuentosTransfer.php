

<!doctype html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Carta con datos bancarios para transferencias manuales</title>
</head>
<?php
include_once('../conexion/conn_bbdd.php');
session_start();
$imagenCurso = "https://medifestructuras.com/imagenes/Demo_Cype_3D.jpg";
$cadena = "(".$_REQUEST['loteCursos'].")";
?>

<body>
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
    
    <p>Según su solicitud le informamos nuestra cuenta bancaria y relación del curso(s) que desea adquirir:</p>
 
    <BR>
    </td>
    <td width="21%">
        <img src="<?php echo $imagenCurso ;?>" width="240" height="100">
    </td>
  </tr>
</table>  
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
$FormatCarta = "SELECT id_curso,  titulo_cur
                  FROM vtcursos 
                 WHERE  id_curso in ".$cadena ;
				 
 $queCarta = sprintf($FormatCarta);
 $resCarta = mysqli_query($conexion, $queCarta) or die(mysqli_error($conexion));
 $totCarta = mysqli_num_rows($resCarta);
 
 if ($totCarta> 0) { 
 echo('<table width="97%" border="1"><tr><td width="15%"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Número</td> <td width="85%" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><b>Título</b></td></tr>');
 

 while ($rowRegistros = mysqli_fetch_assoc($resCarta)) {	
?>
<tr><td>
<?php echo $rowRegistros['id_curso']; ?>
</td>
<td>
<?php echo $rowRegistros['titulo_cur']; ?>
</td></tr>
  
<?php } 
echo('</table>');
}?>  
<br>
El importe de los cursos asciende a:   <?php echo $_REQUEST['DEimporte']. " $"; ?>

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

<p>Para cualquier otra información puede visitar nuestra web: <a href="https://medifestructuras.com">medifestructuras.com</a> o bien responder a este correo
</p>
<p>Gracias por su confianza.</p>
<p>En breve nos pondremos en contacto con Ud.</p>
<p>&nbsp;</p>
<p>Atentamente,</p>
<p> <?php echo $_REQUEST['DENombre_correo']; ?></p>
<p><br>
 
</body>
</html>
