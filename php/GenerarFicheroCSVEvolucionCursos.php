<?php
//....se imprime la tabla vtestadiscursos en formato CSV
session_start();
if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
include_once('../conexion/conn_bbdd.php');
$fichero = $_REQUEST['salida'];
$file = fopen($fichero, "w");
//.................cabecera del fichero
    $query = 'show columns FROM vtestadiscursos';
    $datosLista = mysqli_query($conexion, $query);
	$nColumnas = mysqli_num_rows ($datosLista); 
    if ($nColumnas > 0) {
		$n = 0;
        $salida ="";
		 while ($row = mysqli_fetch_assoc($datosLista)) {
		     $separador = ($n == 0 ? "": ";");
			 $salida .= $separador.comillas(strtoupper($row['Field']));
			 $n++;
		 }
	}
fwrite($file,$salida . PHP_EOL);
//.................registros del fichero
    $FormatFichero = "SELECT id,
                      email_alumno,
                      f_alta,
                      id_curso,
                      algun_curso_mas,
                      Pv_0,
                      Pv1_20,
                      Pv_21_40,
                      Pv_41_60,
                      Pv_61_80,
                      Pv_81_100,
                      Pt_0,
                      Pt1_20,
                      Pt_21_40,
                      Pt_41_60,
                      Pt_61_80,
                      Pt_81_100,
                      Pr_0,
                      Pr1_20,
                      Pr_21_40,
                      Pr_41_60,
                      Pr_61_80,
                      Pr_81_100,
                      dias_ultimaconexion,
                      f_ultimaconexion    
                FROM  vtestadiscursos
                ORDER BY id_curso,f_alta";
   $queFichero = $FormatFichero; 
   $resFichero = mysqli_query($conexion, $queFichero) or die(mysqli_error($conexion));
   $totFichero = mysqli_num_rows($resFichero);
   $separador =";";
   while ($rowFichero = mysqli_fetch_assoc($resFichero)) {
        $linea = "";
        $linea .= comillas($rowFichero['id']);
        $linea .= $separador.comillas($rowFichero['email_alumno']);
        $linea .= $separador.comillas($rowFichero['f_alta']);
        $linea .= $separador.comillas($rowFichero['id_curso']);             
        $linea .= $separador.comillas($rowFichero['algun_curso_mas']);      
        $linea .= $separador.comillas($rowFichero['Pv_0']);                 
        $linea .= $separador.comillas($rowFichero['Pv1_20']);               
        $linea .= $separador.comillas($rowFichero['Pv_21_40']);             
        $linea .= $separador.comillas($rowFichero['Pv_41_60']);             
        $linea .= $separador.comillas($rowFichero['Pv_61_80']);             
        $linea .= $separador.comillas($rowFichero['Pv_81_100']);            
        $linea .= $separador.comillas($rowFichero['Pt_0']);                 
        $linea .= $separador.comillas($rowFichero['Pt1_20']);               
        $linea .= $separador.comillas($rowFichero['Pt_21_40']);             
        $linea .= $separador.comillas($rowFichero['Pt_41_60']);             
        $linea .= $separador.comillas($rowFichero['Pt_61_80']);             
        $linea .= $separador.comillas($rowFichero['Pt_81_100']);            
        $linea .= $separador.comillas($rowFichero['Pr_0']);                 
        $linea .= $separador.comillas($rowFichero['Pr1_20']);               
        $linea .= $separador.comillas($rowFichero['Pr_21_40']);             
        $linea .= $separador.comillas($rowFichero['Pr_41_60']);             
        $linea .= $separador.comillas($rowFichero['Pr_61_80']);             
        $linea .= $separador.comillas($rowFichero['Pr_81_100']);            
        $linea .= $separador.comillas($rowFichero['dias_ultimaconexion']);  
        $linea .= $separador.comillas($rowFichero['f_ultimaconexion']);     
     fwrite($file,$linea . PHP_EOL);   
   }
mysqli_free_result($resFichero);  
fclose($file);
echo "OK";
exit;

//......................................
function comillas($cadena) {
   return '"'.$cadena.'"';
}

?>