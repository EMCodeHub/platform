<?php
//....se imprime la tabla vtestadiscursos en formato CSV
session_start();
if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
include_once('../conexion/conn_bbdd.php');

//.................registros del fichero
 $patternEmail = '/email=(.*?)\s/s';
 $patternTarjetaProcesasa = '/credit_card_processed=(.*?)zip=/s';
 $patternImporte = '/li_0_price=(.*?)\s/s';
   $FormatSelect = "SELECT id, dia, order_number,respuesta, error FROM vtcheckout order by dia";
   $queFichero = $FormatSelect;

   $resFichero = mysqli_query($conexion, $queFichero) or die(mysqli_error($conexion));
   $totFichero = mysqli_num_rows($resFichero);
   $vevolver = "<br>Buscar--".$_POST['email'];	
   $vevolver = "<br>Registros totles en tabla--".$totFichero;
   $vevolver .= "<br>Buscar-->".$_POST['email'];
   $encontrados = 0;
   while ($rowFichero = mysqli_fetch_assoc($resFichero)) {
	   $Dia = $rowFichero['dia'];
	   $Order = $rowFichero['order_number'];
	   $Respuesta = $rowFichero['respuesta'];
	   $Error = $rowFichero['error'];
	   $Id = $rowFichero['id'];
	   //$vevolver .= "<br>..................................nuevo registro";
	   if (preg_match_all($patternEmail,$rowFichero['respuesta'],$matchesTmp)) {		   
				$num_matchesTmp = count($matchesTmp[1]);
                if ($num_matchesTmp > 0) {
					//echo "<br>Valor encontrado--->".trim($matchesTmp[1][0]);
					if (trim($matchesTmp[1][0]) == trim($_POST['email'])) {
						//echo "<br>Email igual--->".$matchesTmp[1][0];
						
					    $encontrados = $encontrados + 1;
						$country =  $matchesTmp[1][0];
						$vevolver .= "<BR>----------------------------------------------------------------";
					    $vevolver .= "<BR>ID-->".$Id;
						$vevolver .= "<BR>DIA-->".$Dia;
					    $vevolver .= "<BR>ORDER NUMBER-->".$Order;
					    $vevolver .= "<BR>ERROR-->".$Error;
					    $vevolver .= "<BR>RESPUESTA-->".$Respuesta;
					    
						if (preg_match_all($patternTarjetaProcesasa,$rowFichero['respuesta'],$matchesTm2)) {
				           $num_matchesTm2 = count($matchesTm2[1]);
                           if ($num_matchesTm2 > 0) {
					          $vevolver .= "<BR>TARJETA PROCESADA -->".$matchesTm2[1][0];
					       }	
                        } 
						if (preg_match_all($patternImporte,$rowFichero['respuesta'],$matchesTm2)) {
				           $num_matchesTm2 = count($matchesTm2[1]);
                           if ($num_matchesTm2 > 0) {
					          $vevolver .= "<BR>IMPORTE -->".$matchesTm2[1][0];
							  $vevolver .= "<BR>";
					       }	
                        } 
		               
   	               }
                  
               }
		   
			   
		   }
		   
	   }
echo  $vevolver;
mysqli_free_result($resFichero); 

exit;
////////////////////////////////////////

?>