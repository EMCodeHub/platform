
<!doctype html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
session_start();
if ($_SESSION['pruebas'] == 1) {
   $_POST['numID']  = 1;
   $_POST['todoOK'] = 1;
   $_POST['error']  = "";
}
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
?>

<title>Carta Solicitud Pago</title>
</head>

<body>

<?php
//......obtener datos de la carta  ..............
$id_solicitud = $_POST['numID'];
$todoCorrecto = $_POST['TodoOK'];
$error_pasado = $_POST['error'];


$email_destino = "";
$importe = 0;
$moneda = ""; 
$concepto = ""; 
$descripcion = ""; 

$FormatMaestros = "SELECT email_destino, 
	                      importe, 
	                      moneda, 
	                      concepto, 
	                      descripcion
                     FROM vtsolcobro
                    WHERE id =  %d ";
                    
$queMaestros = sprintf($FormatMaestros, $id_solicitud);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     



if ($totMaestros > 0){
    while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {			  
        $email_destino = $rowRegistros['email_destino'];
        $importe = $rowRegistros['importe']; 
        $moneda  = $rowRegistros['moneda'];
        $concepto  = $rowRegistros['concepto'];
        $descripcion  = $rowRegistros['descripcion']; 
	  }
}

$Referencia = $id_solicitud * $numeroPrimo;
$url_formulario = $DatosWeb->GetTrimValor('web_url')."/paginas/CobrosOtrosRespondeEnlace.php?Referencia=".rawurlencode($Referencia);
 
$imagenCarta = $DatosWeb->GetTrimValor('web_url')."/imagenes/SliderIndex01.jpg";

//................correo

$NombreCorreoE = $DatosWeb->GetTrimValor('NombrePrincipal');

include_once('../paginas/CartaCabecera.php'); 
?>  
    
<!--## .........INICIO sección modificable ................... ............. ......... ........ ###   -->   
  

<table width="97%" border="0">
  <tr>
    <td width="79%">
    
    <p>Estimado ingeniero,</p>
        
    <?php if ($todoCorrecto == 1) { ?>
                  <p>Hemos recibido el pago que ha realizado por nuestros servicios:</p> 
    <?php } else  { ?>  
                   <p>No hemos podido procesar su tarjeta, póngase en contacto con nosotros</p> 
    <?php } ?>    
 
    <BR>
    </td>
    <td width="21%">
        <img src="<?php echo $imagenCarta ;?>" width="240" height="160">
    </td>
  </tr>
</table>  

<table width="97%" border="1">
    
 <tr>
    <td width="15%"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Concepto</td>
    <td width="85%" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top;padding-left: 5px"><?php echo $concepto ; ?></td>
  </tr>
  
  
  <tr>
    <td width="15%"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Descripción</td>
    <td width="85%" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top;padding-left: 5px"><?php echo $descripcion ; ?></td>
  </tr>
  
  
  
  
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Importe</td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top;padding-left: 5px"><?php echo $importe.' '.$moneda ; ?></td>
  </tr>


</table>
<br>


<!--## .........FIN sección modificable ................... ............. ......... ........ ###   -->   

<p>Para cualquier otra información puede visitar nuestra web: <a href="<?php echo $DatosWeb->GetTrimValor('web_url'); ?>" > <?php echo $DatosWeb->GetTrimValor('web_dominio'); ?></a> o bien responder a este correo
</p>
<p>Gracias por su confianza.</p>
<p>&nbsp;</p>
<p>Atentamente,</p>
<p> <?php echo $NombreCorreoE; ?></p>
<p>
<br/>
<!--## ............................ ................ ...... ..... ....... ......... ........ ###   --> 
<?php include_once('../paginas/CartaPie.php'); ?>

</body>
</html>
