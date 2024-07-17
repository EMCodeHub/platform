<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);

$order_id = $_REQUEST['Referencia'];
$curso_id = 1; //......no se qué poner
$action = "";
$name="";
$id = 0;
$description = "";
$price = 0;

$paginaRespuesta = ""; //enviaremos la página de cobros otros que no sean cursos
//............................
$f_cobro = "";
$f_anulacion = "";
$moneda = "";
$error = "";
//............................    
 /////////////////////////////////////cursos//////////////////////////
 $FormatMaestros = "SELECT id, 
         	                      f_emision,
         	                      f_cobro, 	
         	                      f_anulacion, 
         	                      email_destino, 
         	                      importe, 
         	                      moneda, 
         	                      concepto, 
         	                      descripcion
                              FROM vtsolcobro     
                             WHERE id = %d";
$queMaestros = sprintf($FormatMaestros,$order_id);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                       
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
		 $name        = $rowVTMaestros['concepto'];
		 $description = $rowVTMaestros['descripcion'];
		 $price       = $rowVTMaestros['importe'];
         $moneda      = $rowVTMaestros['moneda'];
         $f_cobro     = $rowVTMaestros['f_cobro'];
         $f_anulacion = $rowVTMaestros['f_anulacion'];  
		  if (strlen ( $name ) > 120) {
			$name =  substr($name,120); 
		  }
		  if (strlen ( $description ) > 254) {
			$description =  substr($description,254); 
		  }
	 }	
} else {
	$error .= " No encontrada la Referencia ".$order_id;
}
 mysqli_free_result($resMaestros);
    
 if (!empty($f_cobro)) {
   $error .= " Pago ya está realizado: ".$f_cobro;  
 }
if (!empty($f_anulacion)) {
   $error .= " La operación está anulada: ".$f_anulacion;  
 }  
 if ($price < 1) {
   $error .= " El importe es 0 ";  
 }    
 if (empty($moneda)) {
   $error .= " No está informada la moneda ";  
 }   
 /////////////////////////////////////parametros////////////////////////////////////
 $FormatMaestros = "SELECT twocheck_real_inicio, twocheck_real_id, twocheck_respnocurso
                    FROM vtparametros 
				    WHERE id = 1
				 ";
$queMaestros = sprintf($FormatMaestros);

$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
         if (empty($rowVTMaestros['twocheck_respnocurso'])) {
             $error .= " No definida página de respuesta en parámetros "; 
         }
         $paginaRespuesta = $DatosWeb->GetTrimValor("web_url")."/".$rowVTMaestros['twocheck_respnocurso'];
         $action          = $rowVTMaestros['twocheck_real_inicio'];
         $id              = $rowVTMaestros['twocheck_real_id']; 
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
    
    <?php
     if (!empty($error)) {
       echo "return;" ; 
     }
    ?>
    
    
    
    
		var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
            if ((new Date().getTime() - start) > 15000){
                break;
            }
        }
	document.getElementById("datos").submit();
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php    
    include_once('../paginas/NewWebEstilosNOIndex.php'); 
    include_once('ValidaLoginScript.php');
?>
<title><?php echo $DatosWeb->GetTrimValor('web_dominio') ?>  Pago de servicios</title>
</head>



<body onload="LlamaPlataformaPago()"> 
<form id="datos" action='<?php echo $action ?>' method='post'>
<input type='hidden' name='sid' value='<?php echo $id ?>' >
<input type='hidden' name='mode' value='2CO' >
<input type='hidden' name='li_0_type' value='product' >
<input type='hidden' name='li_0_name' value='<?php echo  $name ?>' >
<input type='hidden' name='li_0_product_id' value='<?php echo $curso_id ?>' >
<input type='hidden' name='li_0_price' value='<?php echo $price.".00" ?>' >
<input type='hidden' name='currency_code' value='<?php echo $moneda ?>' >
<input type='hidden' name='li_0_quantity' value='1' >
<input type='hidden' name='li_0_tangible' value='N' >
<input type='hidden' name='lang' value='es_ib' >
<input type='hidden' name='merchant_order_id' value='<?php echo $order_id ?>' >
<input type='hidden' name='x_receipt_link_url' value='<?php echo $paginaRespuesta ?>' >
  
<!--<input name='submit' type='submit' value='Checkout' >-->
</form>


<!--Está siendo redirigido a un sitio seguro<br>
Descripcion error: -->
<?php if (empty($error)) { ?>  
     <center>
           <img src="../imagenes/Redirigiendo.jpg"  alt="2checkout" />
     </center>
<?php } ?>   
    
<br>
<br>
<center>
<?php 
    if (!empty($error)) { 
        $enlace = '<p class ="pide_panPreTit"><a href="'.$DatosWeb->GetTrimValor("web_url").'">'.$DatosWeb->GetTrimValor("web_dominio").'</a></p>';
    $error = "<p><b>". $enlace."</b></p>".'<p class="rojo">'.$error."</p><p>Póngase en contacto con nosotros</p><p>Gracias anticipadas</p>";
        
    }
    echo $error;
?>
</center>

<?php  if (!empty($error)) { ?>
    <div class="separadorGrande"></div>   
    <div class="centro90"><?php include_once('../paginas/PaginaPieNOIndex.php'); ?></div>  
<?php  } ?>   
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
