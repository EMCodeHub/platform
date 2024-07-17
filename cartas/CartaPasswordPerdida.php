
<!doctype html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
?>
<title>Carta al alumno: Pérdida de Password</title>
</head>

<body>

<?php
if ($_SESSION['pruebas'] == 1) { //...para ver la carta desde mantenimiento->VisorDeCartas.php
     $queCarta = "SELECT id, pwd , email
                   FROM vtalumnos
				   WHERE id=1 ";
} else {
 $FormatCarta = "SELECT id, pwd , email
                   FROM vtalumnos
				   WHERE UPPER(email) = UPPER('%s') ";
 $queCarta = sprintf($FormatCarta,$_REQUEST['usuario']);
    
}
    

 $resCarta = mysqli_query($conexion, $queCarta) or die(mysqli_error($conexion));
 $totCarta = mysqli_num_rows($resCarta);
 
 if ($totCarta> 0) { 

 while ($rowRegistros = mysqli_fetch_assoc($resCarta)) {

?>

<?php include_once('../paginas/CartaCabecera.php'); ?>  
    
<!--## .........INICIO sección modificable ................... ............. ......... ........ ###   -->   
  

<table width="97%" border="0">
  <tr>
    <td width="79%">
   
    <p>Ha solicitado que le enviemos su contraseña:  </p>
 
    <BR>
    </td>
    
  </tr>
</table>  
  

<table width="97%" border="1">
 <tr>
    <td width="15%"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Contraseña</td>
    <td width="85%" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['pwd'] ; ?></td>
  </tr>
</table>

<!--## .........FIN sección modificable ................... ............. ......... ........ ###   -->   
    
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Para cualquier otra información puedes visitar nuestra web: <a href="<?php echo $DatosWeb->GetTrimValor('web_url'); ?>" > <?php echo $DatosWeb->GetTrimValor('web_dominio'); ?></a> o bien responder a este correo
</p>
<p>Gracias por tu confianza.</p>
<p>&nbsp;</p>
<p>Atentamente,</p>
<p> <?php echo $DatosWeb->GetTrimValor('NombrePrincipal'); ?></p>
<p>
<br/>
<!--## ............................ ................ ...... ..... ....... ......... ........ ###   --> 
<?php include_once('../paginas/CartaPie.php'); ?>
</body>
</html>
<?php } }?>