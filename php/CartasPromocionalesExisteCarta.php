<?php
//verifica si la carta promocional que vamos a enviar ya existe
//si existe devolverá la fecha en que fue enviada
//si no existe devolverá un OK
include_once('../conexion/conn_bbdd.php');
$devolver ="OK";
    $FormatExiste = "SELECT f_creacion 
                       FROM vtcartascabecera
                      WHERE fichero = '%s'";
    $queExiste = sprintf($FormatExiste,$_REQUEST['carta']);
    $resExiste = mysqli_query($conexion, $queExiste) or die(mysqli_error($conexion));  
    $totExiste = mysqli_num_rows($resExiste);     
	   while ($rowExiste = mysqli_fetch_assoc($resExiste)) {
		  $devolver = "La carta ya se envió el día: ".$rowExiste['f_creacion']; 	 	         
	   }
    mysqli_free_result($resExiste);
    echo $devolver;
?>
