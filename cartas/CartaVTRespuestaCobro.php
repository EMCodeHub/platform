
<!doctype html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Carta respuesta al alumno: alta de permisos</title>
</head>

<body>

<?php
include_once('../conexion/conn_bbdd.php');
$imagenCurso = "https://medifestructuras.com/imagenes/Demo_Cype_3D.jpg";
$cadena = "(".$_REQUEST['lote'].")";
$password = $_REQUEST['PwdPalabra'];  //volvemos a recuperarla de la tabla, por si el alumno no es nuevo
session_start();

$password = "";
    $FormatPwd = "SELECT  pwd
                   FROM vtalumnos
                   WHERE  email = '%s'
				 ";
     $quePwd = sprintf($FormatPwd, $_POST['CBemail']);
     $resPwd = mysqli_query($conexion, $quePwd) or die(mysqli_error($conexion));                                                        
     $totPwd = mysqli_num_rows($resPwd);     

	 while ($rowVTPwd = mysqli_fetch_assoc($resPwd)) {
		 $password = $rowVTPwd['pwd'];
	 }	
     mysqli_free_result($resPwd);




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
    <td width="79%">
    <?php if ($_POST['TodoOK'] == 1) {?>  
    <p>Bienvenido a nuestro aula, le facilitamos los datos de conexión:  </p>
  
  <?php } else {?>  
        <p>El proceso de compra NO se ha completado, entendemos que no se le ha hecho ningun cargo en su tarjeta de crédito.</p>
        <p>Repita el proceso o póngase en contacto con nosotros si cree que es una incidencia.</p>
   <?php } ?>  
 
 
    <BR>
    </td>
    <td width="21%">
        <img src="<?php echo $imagenCurso ;?>" width="240" height="100">
    </td>
  </tr>
</table>  
  <?php
  $FormatCarta = "SELECT id_curso,  titulo_cur
                  FROM vtcursos 
                 WHERE  id_curso in ".$cadena ;
				 
 $queCarta = sprintf($FormatCarta);
 $resCarta = mysqli_query($conexion, $queCarta) or die(mysqli_error($conexion));
 $totCarta = mysqli_num_rows($resCarta);
 
 if ($totCarta> 0) { 
 
echo "<b>Curso(s) adquiridos:</b><br>";
 echo('<table width="97%" border="1"><tr><td width="15%"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Número</td> <td width="85%" bgcolor="#03F"  style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top"><b>Título</b></td></tr>');
 

 while ($rowRegistros = mysqli_fetch_assoc($resCarta)) {	
?>
<tr><td align="right">
<?php echo $rowRegistros['id_curso']; ?>
</td>
<td>
<?php echo $rowRegistros['titulo_cur']; ?>
</td></tr>
  
<?php } 
echo('</table>');
}?>  
<br>
Ud. ha hecho un abono de:  <?php echo $_POST['precio']. " $"; ?>


<br>
<br>

<?php if ($_POST['TodoOK'] == 1) {?>  
<table width="97%" border="1">
  
  <tr>
    <td  width="15%"   bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Usuario</td>
    <td  width="85%"  style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $_POST['CBemail']; ?></td>
  </tr>
  
  
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Password</td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $password; ?></td>
  </tr>
</table>

<p>Le hemos asignado permisos para acceder al curso(s).</p>
<?php } else { ?> 


<?php } ?> 
<p>Para cualquier otra información puede visitar nuestra web: <a href="https://medifestructuras.com">medifestructuras.com</a> o bien responder a este correo
</p>
<p>Gracias por su confianza.</p>
<p>En breve nos pondremos en contacto con Ud.</p>
<p>&nbsp;</p>
<p>Atentamente,</p>
<p> <?php echo $_POST['Nombre_correo']; ?></p>
<p><br>
 

</body>
</html>
