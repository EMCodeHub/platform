<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);

$order_id = 0; //será el número de solicitud
$lote_id = 0;
$action = "";
$name="";
$id = 0;
$description = "";
$price = 0;
$error = "";
$real_test = "-T-"; // si real, rerá blanco, si test llevará este prefijo en nombre del producto
$paginaRespuesta = ""; //enviaremos el parámetro pagina de respuesta, aunque esté apuntadoa en 2checkout, mandará esta
$FormatMaestros = "SELECT id as ID_PROD, lotedecursos
                   FROM vtsolicitudes as T1                 
                      where id = ( 
                         select max(id)  from vtsolicitudes as T2   
                         WHERE  RTRIM(LOWER(T2.email_cliente)) =   RTRIM(LOWER('%s'))
                               and T2.tipomensaje   =  '%s')
				 ";
$queMaestros = sprintf($FormatMaestros,$_REQUEST['mail'], 'Solicitud VISA');

//echo $queMaestros."<br>";



$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
		 $order_id = $rowVTMaestros['ID_PROD'];
		 $lote_id = $rowVTMaestros['lotedecursos'];
	 }	
} else {
	$error .= "No encontrada la solicitud";
}
 mysqli_free_result($resMaestros);
 
 
 $tmpnumeroCursos = explode(",",$_REQUEST['DEcadena']);
 $numeroCursos = sizeof($tmpnumeroCursos);
 
 $name = "Compra de ".$numeroCursos." cursos, números: ".$_REQUEST['DEcadena'];
 $description = "Compra de ".$numeroCursos." cursos, números: ".$_REQUEST['DEcadena'];
 $price = $_REQUEST['DEimporte'];
 
 
 
 
 /////////////////////////////////////parametros////////////////////////////////////
 $FormatMaestros = "SELECT twocheck_real_inicio, twocheck_real_id, twocheck_respuesta
                      FROM vtparametros 
				     WHERE id = 1";
$queMaestros = sprintf($FormatMaestros);

$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
		     $paginaRespuesta = $DatosWeb->GetTrimValor("web_url")."/".$rowVTMaestros['twocheck_respuesta'];
         $action          = $rowVTMaestros['twocheck_real_inicio'];
         $id = $rowVTMaestros['twocheck_real_id'];
         $real_test = "";
		 if ($_SESSION['es_admin'] == 1) {
			 $real_test = "-T-"; 
		 } 
	 }	
} else {
	$error .= " No encontrados los parametros ";
}
 mysqli_free_result($resMaestros);
 
?>
<script>


function LlamaPlataformaPago() {
     <?php
     if (EstaActivaVisa($conexion) == 0) {
       $destino = '../paginas/VisaNoHabilitada.php'; 
       echo "location.href = '".$destino."';" ;
       echo "return;" ; 
     }
    ?>

	document.getElementById("datos").submit();
}





</script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $DatosWeb->GetTrimValor('web_dominio') ?>  Compra Videotutoriales</title>
</head>





<body onload="LlamaPlataformaPago()">    


<form id="datos" action='<?php echo $action ?>' method='post'>
<input type='hidden' name='sid' value='<?php echo $id ?>' >
<input type='hidden' name='mode' value='2CO' >
<input type='hidden' name='li_0_type' value='product' >
<input type='hidden' name='li_0_name' value='<?php echo  $real_test.$name ?>' >
<input type='hidden' name='li_0_product_id' value='<?php echo $lote_id ?>' >
<input type='hidden' name='li_0_price' value='<?php echo $price.".00" ?>' >
<input type='hidden' name='currency_code' value='<?php echo $DatosWeb->GetTrimValor("moneda") ?>' >
<input type='hidden' name='li_0_quantity' value='1' >  
<input type='hidden' name='li_0_tangible' value='N' >
<input type='hidden' name='lang' value='es_ib' >
<input type='hidden' name='merchant_order_id' value='<?php echo $order_id ?>' >
<input type='hidden' name='x_receipt_link_url' value='<?php echo $paginaRespuesta ?>' >
<?php if ($_SESSION['es_admin'] == 1) {?>  
  <input type='hidden' name='demo' value='Y' >
<?php } ?>      

<!--<input name='submit' type='submit' value='Checkout' >-->
</form>


<!--Está siendo redirigido a un sitio seguro<br>
Descripcion error: -->
<center>
  <img src="../imagenes/Redirigiendo.jpg" width="600" height="461" alt="2checkout" />
</center>
<br>
<br>
<center>
<?php echo $error ?>
</center>
</body>
</html>
<?php
//..................................................................
function EstaActivaVisa($conexion){
$devolver = 0;
$FormatActivaVisa = "SELECT twocheck_activo
                       FROM vtparametros 
				              WHERE id = 1";
$queActivaVisa = $FormatActivaVisa;

$resActivaVisa = mysqli_query($conexion, $queActivaVisa) or die(mysqli_error($conexion));                                                        
$totActivaVisa = mysqli_num_rows($resActivaVisa);     
if ($totActivaVisa > 0){
	 while ($rowVTActivaVisa = mysqli_fetch_assoc($resActivaVisa)) {
	 	   if ($rowVTActivaVisa['twocheck_activo'] == NULL || $rowVTActivaVisa['twocheck_activo'] ==  0) {
	 		   $devolver = 0;
	   	} else {
	 		   $devolver = 1;
	 	  }
	 }	
} else {
	$error .= " No se puede determinar si está activo el pago con tarjetas ";
}
 mysqli_free_result($resActivaVisa);
 return $devolver;   
}      
?>