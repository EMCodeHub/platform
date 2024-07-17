<?php
//....se imprime la tabla vtestadiscursos en formato CSV
session_start();
if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
include_once('../conexion/conn_bbdd.php');
include_once('../php/PaisesIvaClass.php'); //Clase Paises iva
$fichero = "../CSVFicheros/".$_REQUEST['salida'].$_REQUEST['inicio']."-".$_REQUEST['fin'].".CSV";

$file = fopen($fichero, "w");
fwrite($file,$fichero . PHP_EOL);
fwrite($file,"" . PHP_EOL);
fwrite($file,"Facturas Emitidas" . PHP_EOL);
//.................cabecera del fichero

//.................registros del fichero
    $FormatCobros = "SELECT id, 'CURSO' AS tipo, email_cliente, DATE(fecha_emision) AS fecha, importe, 0 as gastos, numero_orden, numero_factura, codigo_pais,ciudad
	                     FROM vtcobros
	                    WHERE pruebas_real != 'PRUEBA'
						  AND fecha_emision >= '%s'
						  AND fecha_emision <= '%s'
					
	                    UNION
	                   SELECT id, 'LINK-PAGO' AS tipo, email_cliente, DATE(fecha_emision) AS fecha, importe,0 as gastos, numero_orden, numero_factura, codigo_pais,ciudad
	                     FROM vtcobrosotros
	                    WHERE fecha_emision >= '%s'
						  AND fecha_emision <= '%s'
				
						UNION
						 SELECT id, origen_entidad AS tipo, email_cliente, DATE(fecha_emision) AS fecha, importe_original as importe, importe_original-importe_cobrado as gastos, numero_orden, numero_factura, codigo_pais,ciudad
	                     FROM vtcobrosmanual
	                    WHERE fecha_emision >= '%s'
						  AND fecha_emision <= '%s'
				     ";
   $queFichero = sprintf($FormatCobros, $_REQUEST['inicio'], $_REQUEST['fin'],$_REQUEST['inicio'],  $_REQUEST['fin'],$_REQUEST['inicio'],  $_REQUEST['fin']);

   $resFichero = mysqli_query($conexion, $queFichero) or die(mysqli_error($conexion));
   $totFichero = mysqli_num_rows($resFichero);
   $separador =";";
   $DatosIva =   new PaisesIva($conexion);
   
        $lineaC = '';
        $lineaC .= comillas('ID');
        $lineaC .= $separador.comillas('TIPO');
        $lineaC .= $separador.comillas('EMAILCLIENTE');
        $lineaC .= $separador.comillas('PAIS');             
        $lineaC .= $separador.comillas('FECHA');      
        $lineaC .= $separador.comillas('B. iMPONIBLE');                 
        $lineaC .= $separador.comillas('IVA');               
        $lineaC .= $separador.comillas('IMPORTE');             
        $lineaC .= $separador.comillas('GASTOS');             
        $lineaC .= $separador.comillas('ORDEN NUM');             
        $lineaC .= $separador.comillas('N. FACTURA');  
		
         fwrite($file,$lineaC . PHP_EOL);

   while ($rowFichero = mysqli_fetch_assoc($resFichero)) {
        $Piva = $DatosIva->GetIva($rowFichero['codigo_pais'],$rowFichero['ciudad']);
		   $baseI=$rowFichero['importe']-($rowFichero['importe']*$Piva/100);
		   $Iva=($rowFichero['importe']*$Piva/100);

        $linea = '';
        $linea .= comillas($rowFichero['id']);
        $linea .= $separador.comillas($rowFichero['tipo']);
        $linea .= $separador.comillas($rowFichero['email_cliente']);
        $linea .= $separador.comillas($rowFichero['codigo_pais']);             
        $linea .= $separador.comillas($rowFichero['fecha']);      
        $linea .= $separador.comillas(str_replace(".", ",",$baseI));                 
        $linea .= $separador.comillas(str_replace(".", ",",$Iva));               
        $linea .= $separador.comillas(str_replace(".", ",",$rowFichero['importe']));             
        $linea .= $separador.comillas(str_replace(".", ",",$rowFichero['gastos']));             
        $linea .= $separador.comillas($rowFichero['numero_orden']);             
        $linea .= $separador.comillas($rowFichero['numero_factura']);  
		
     fwrite($file,$linea . PHP_EOL);   
   }
    
mysqli_free_result($resFichero); 

////////////////////// facturas recibidas ////////////////////////
fwrite($file,"" . PHP_EOL);
fwrite($file,"" . PHP_EOL);
fwrite($file,"" . PHP_EOL);
fwrite($file,"Facturas Recibidas" . PHP_EOL);
//.................cabecera del fichero

//.................registros del fichero
    $FormatRecibidas = "SELECT id, 
                          proveedor, 
                          numero_factura, 
                          fecha_factura, 
                          importe, 
                          iva, 
                          codigo_pais, 
                          medio_pago 
                          FROM vtpagosgastos
						  WHERE fecha_factura >= '%s'
						  AND fecha_factura <= '%s'
";
   $queFichero = sprintf($FormatRecibidas, $_REQUEST['inicio'], $_REQUEST['fin']);

   $resFichero = mysqli_query($conexion, $queFichero) or die(mysqli_error($conexion));
   $totFichero = mysqli_num_rows($resFichero);
   $separador =";";
   $DatosIva =   new PaisesIva($conexion);
   
        $lineaC = '';
        $lineaC .= comillas('ID');
        $lineaC .= $separador.comillas('TIPO');
        $lineaC .= $separador.comillas('PROVEEDOR');
        $lineaC .= $separador.comillas('PAIS');             
        $lineaC .= $separador.comillas('FECHA');      
        $lineaC .= $separador.comillas('B. IMPONIBLE');                 
        $lineaC .= $separador.comillas('IVA');               
        $lineaC .= $separador.comillas('IMPORTE'); 
        $lineaC .= $separador.comillas(" ");
        $lineaC .= $separador.comillas('N. FACTURA');  
		
         fwrite($file,$lineaC . PHP_EOL);

   while ($rowFichero = mysqli_fetch_assoc($resFichero)) {
        $Piva = $DatosIva->GetIva($rowFichero['codigo_pais'],$rowFichero['ciudad']);
		   $baseI=$rowFichero['importe']-($rowFichero['importe']*$Piva/100);
		   $Iva=($rowFichero['importe']*$Piva/100);

        $linea = '';
        $linea .= comillas($rowFichero['id']);
        $linea .= $separador.comillas($rowFichero['medio_pago']);
        $linea .= $separador.comillas($rowFichero['proveedor']);
        $linea .= $separador.comillas($rowFichero['codigo_pais']);             
        $linea .= $separador.comillas($rowFichero['fecha_factura']);      
        $linea .= $separador.comillas(str_replace(".", ",",$baseI));                 
        $linea .= $separador.comillas(str_replace(".", ",",$Iva));               
        $linea .= $separador.comillas(str_replace(".", ",",$rowFichero['importe']));   
	    $linea .= $separador.comillas(" ");
        $linea .= $separador.comillas($rowFichero['numero_factura']);  
		
     fwrite($file,$linea . PHP_EOL);   
   }
fwrite($file,"" . PHP_EOL); 
fwrite($file,"" . PHP_EOL); 
fwrite($file,"Ahora hay que Obtener el CSV de la liquidacion con 2checkout para identificar gastos de las facturas emitidas" . PHP_EOL);
fwrite($file,"Consiste en identificar a que facturas corresponden los paquetes de pago checkout " . PHP_EOL);
fwrite($file,"La diferencia de importe, se debe de corregir en esta hoja, cargando gastos a una factura " . PHP_EOL);
fwrite($file,"Cada pago checkout son 2 Euros de cargo adicional " . PHP_EOL);






fclose($file);
echo "OK";
exit;

//......................................
function comillas($cadena) {
   return $cadena;
}

?>