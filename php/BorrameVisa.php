<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
session_start();
include_once('../conexion/conn_bbdd.php');

$order_id = 407; //será el número de solicitud
$curso_id = 5;
$action = "https://www.2checkout.com/checkout/purchase";
$name="Curso (5) pruebas a 1$";
$id = 102909160;
$description = "Prueba curso 5 a 1$";
$price = 1;
$error = "";
$real_test = ""; 
$paginaRespuesta = "http://www.medifestructuras.com/php/RespuestaCobro2Check.php"; 



?>
<script>
function LlamaPlataformaPago() {
	var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > 6000){
      break;
    }
  }
	document.getElementById("datos").submit();
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CYPE: Prueba Compra de Videotutorial</title>
</head>



<body onload="LlamaPlataformaPago()"> 
<form id="datos" action='<?php echo $action ?>' method='post'>
<input type='hidden' name='sid' value='<?php echo $id ?>' >
<input type='hidden' name='mode' value='2CO' >
<input type='hidden' name='li_0_type' value='product' >
<input type='hidden' name='li_0_name' value='<?php echo  $real_test.$name ?>' >
<input type='hidden' name='li_0_product_id' value='<?php echo $curso_id ?>' >
<input type='hidden' name='li_0_price' value='<?php echo $price.".00" ?>' >
<input type='hidden' name='currency_code' value='USD' >
<input type='hidden' name='li_0_quantity' value='1' >
<input type='hidden' name='li_0_tangible' value='N' >
<input type='hidden' name='lang' value='es_ib' >
<input type='hidden' name='merchant_order_id' value='<?php echo $order_id ?>' >
<input type='hidden' name='x_receipt_link_url' value='<?php echo $paginaRespuesta ?>' >

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