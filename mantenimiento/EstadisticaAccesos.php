<?php
session_start();
if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
if (!isset($_REQUEST['volver_a'])) {
	$_REQUEST['volver_a'] = "mantenimiento.php";
}
//......................................................
if (!isset($_REQUEST['Fecha_Ini'])) {
	$_REQUEST['Fecha_Ini'] = date("Y-m-d",strtotime(date("Y-m-d")." - 3 month")); 
}
if (!isset($_REQUEST['Fecha_Fin'])) {
	$_REQUEST['Fecha_Fin'] = date("Y-m-d");
}
//.......................................................

//.......................................................
function elfecha($nombre,$tipo) {
	$devolver ="";
	$pos = strpos($tipo,'date');
	if ($pos !== false) {
		$devolver = '<input type="button" id="'."BOT".$nombre.'" value="..." />'; 
	}
	return $devolver;
}
//...........................................................................
function RellenaPuntos($txt,$long) {
	$longTexto = strlen($txt);
	$relleno = "";
	if ($longTexto < $long) {
		$relleno = str_repeat(".",$long-$longTexto);
		return $txt.$relleno;
	}
	return $txt;
}
//...........................................................................
function NoZero($num) {
	return ($num == 0 ? "..." : $num);
}
//...........................................................................
function Totales($Dini,$Dfin,$conexion) {
	$tornar = Array();
   	$FormatMaestros = "SELECT count(pagina) AS CONTADOR, SUM(tiempo_segundos) AS SEGUNDOS
                         FROM vtleads, vtsesionlead
                        WHERE vtleads.id = vtsesionlead.id_lead
                              and vtsesionlead.Fecha >= '%s' and vtsesionlead.Fecha <= '%s'
                        ";
    $queMaestros = sprintf($FormatMaestros, $Dini, $Dfin);
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros); 
     if ($totMaestros > 0){
       while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		  $TotalPaginas   = $rowMaestros['CONTADOR'];
		  $TotalSegundos  = $rowMaestros['SEGUNDOS'];
		  $TotalMinutos    = ceil($TotalSegundos / 60);
		  array_push($tornar, $TotalPaginas);
		  array_push($tornar, $TotalSegundos);
		  array_push($tornar, $TotalMinutos);
       }
     }
     mysqli_free_result($resMaestros); 
	 return $tornar;		
}
//...........................................................................
function TotalesPais($Dini,$Dfin,$pais,$conexion) {
	$tornar = Array();
   	$FormatMaestros = "SELECT pais, count(pagina) AS CONTADOR, SUM(tiempo_segundos) AS SEGUNDOS
                         FROM vtleads, vtsesionlead
                        WHERE vtleads.id = vtsesionlead.id_lead
                              and vtsesionlead.Fecha >= '%s' and vtsesionlead.Fecha <= '%s'
							  and pais = '%s'
                        ";
    $queMaestros = sprintf($FormatMaestros, $Dini, $Dfin,$pais);
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros); 
     if ($totMaestros > 0){
       while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		  $TotalPaginas   = $rowMaestros['CONTADOR'];
		  $TotalSegundos  = $rowMaestros['SEGUNDOS'];
		  $TotalMinutos    = ceil($TotalSegundos / 60);
		  array_push($tornar, $TotalPaginas);
		  array_push($tornar, $TotalSegundos);
		  array_push($tornar, $TotalMinutos);
       }
     }
     mysqli_free_result($resMaestros); 
	 return $tornar;		
}
//...........................................................................
function LeadsPaises($Dini,$Dfin,$conexion) {
	
	$Totales = Totales($Dini,$Dfin,$conexion);

    $devolver = "";
   	$FormatMaestros = "SELECT vtleads.pais, count(pagina) AS CONTADOR, SUM(tiempo_segundos) AS SEGUNDOS
                         FROM vtleads, vtsesionlead
                        WHERE vtleads.id = vtsesionlead.id_lead
                              and vtsesionlead.Fecha >= '%s' and vtsesionlead.Fecha <= '%s'
                     GROUP BY pais
                     ORDER BY pais
                        ";
    $queMaestros = sprintf($FormatMaestros, $Dini, $Dfin);
	//echo "<br />@@@ ----- >".$queMaestros;
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros); 
		$cabeceras = '<div class="EstadPais1T">País</div>';
        $cabeceras .= '<div class="EstadNumero1T">Páginas visitadas</div>'; 
        $cabeceras .= '<div class="EstadNumero1T">Segundos</div>'; 
        $cabeceras .= '<div class="EstadNumero1T">Minutos</div>';
        $cabeceras .= '<div class="clear"></div>';  
     if ($totMaestros > 0){
	   $devolver .= $cabeceras;
       while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		   $devolver .= '<div class="EstadPais1">'.RellenaPuntos($rowMaestros['pais'],70).'</div>';
           $devolver .= '<div class="EstadNumero1">'.NoZero(number_format ( $rowMaestros['CONTADOR'], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
           $devolver .= '<div class="EstadNumero1">'.NoZero( number_format ( $rowMaestros['SEGUNDOS'], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
           $devolver .= '<div class="EstadNumero1">'.NoZero(number_format ( $rowMaestros['SEGUNDOS'] / 60, $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
           $devolver .= '<div class="clear"></div>';  
       }
	   $devolver .= '<b><div class="EstadPais1">'.RellenaPuntos('TOTAL',70).'</div>';
       $devolver .= '<div class="EstadNumero1">'.NoZero(number_format ( $Totales[0], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero1">'.NoZero(number_format ( $Totales[1], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero1">'.NoZero(number_format ( $Totales[2], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )) .'</div></b>';
       $devolver .= '<div class="clear"></div>';  
    
     }
	 
     mysqli_free_result($resMaestros);
     return 	$devolver;
 		
}
//...........................................................................
//...........................................................................
function LeadsPaisesPag($Dini,$Dfin,$conexion) {
	//$Totales = Totales($Dini,$Dfin,$conexion);
    $devolver = "";
   	$FormatMaestros = "SELECT vtleads.pais, pagina, count(pagina) AS CONTADOR, SUM(tiempo_segundos) AS SEGUNDOS
                         FROM vtleads, vtsesionlead
                        WHERE vtleads.id = vtsesionlead.id_lead
                              and vtsesionlead.Fecha >= '%s' and vtsesionlead.Fecha <= '%s'
                     GROUP BY pais, pagina
                     ORDER BY pais, pagina
                        ";
    $queMaestros = sprintf($FormatMaestros, $Dini, $Dfin);
	//echo "<br />@@@ ----- >".$queMaestros;
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros); 
		$cabeceras = '<div class="EstadPais2T">País</div>';
		$cabeceras .= '<div class="EstadPagina2T">Página</div>';
        $cabeceras .= '<div class="EstadNumero2T">Veces visitada</div>'; 
        $cabeceras .= '<div class="EstadNumero2T">Segundos</div>'; 
        $cabeceras .= '<div class="EstadNumero2T">Minutos</div>';
        $cabeceras .= '<div class="clear"></div>';  
     if ($totMaestros > 0){
	   $devolver .= $cabeceras;
	   $n = 0;
       while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		   $n++;
		   if ($pais != $rowMaestros['pais'] && $n != 1) {	   
			    $TotalesPais = TotalesPais($Dini,$Dfin,$pais,$conexion);
			   	$devolver .= '<div class="EstadPais2"></div>';
		        $devolver .= '<div class="EstadPagina2T">'.$pais.'</div>';
                $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[0], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
                $devolver .= '<div class="EstadNumero2T">'.NoZero( number_format ( $TotalesPais[1], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
                $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[2], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
                $devolver .= '<div class="clear"></div>';       	
		   }
		   $devolver .= '<div class="EstadPais2">'.RellenaPuntos($rowMaestros['pais'],30).'</div>';
		   $devolver .= '<div class="EstadPagina2">'.RellenaPuntos($rowMaestros['pagina'],50).'</div>';
           $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $rowMaestros['CONTADOR'], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
           $devolver .= '<div class="EstadNumero2">'.NoZero( number_format ( $rowMaestros['SEGUNDOS'], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
           $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $rowMaestros['SEGUNDOS'] / 60, $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
           $devolver .= '<div class="clear"></div>'; 
		   $pais = $rowMaestros['pais']; 
       }
	   
	   $TotalesPais = TotalesPais($Dini,$Dfin,$pais,$conexion);
	   $devolver .= '<div class="EstadPais2"></div>';
	   $devolver .= '<div class="EstadPagina2T">'.$pais.'</div>';
       $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[0], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2T">'.NoZero( number_format ( $TotalesPais[1], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[2], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
       $devolver .= '<div class="clear"></div>';       	
       $Totales = Totales($Dini,$Dfin,$conexion);
	   $devolver .= '<b><div class="EstadPais2"></div>';
	   $devolver .= '<div class="EstadPagina2">TOTAL GENERAL</div>';
       $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $Totales[0], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2">'.NoZero( number_format ( $Totales[1], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $Totales[2], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
       $devolver .= '<div class="clear"></div></b>';       	   
     }
	 
     mysqli_free_result($resMaestros);
     return 	$devolver;
 		
}
//...........................................................................
function LeadsPaisesCiudad($Dini,$Dfin,$conexion) {
	//$Totales = Totales($Dini,$Dfin,$conexion);
    $devolver = "";
   	$FormatMaestros = "SELECT vtleads.pais, ciudad, count(pagina) AS CONTADOR, SUM(tiempo_segundos) AS SEGUNDOS
                         FROM vtleads, vtsesionlead
                        WHERE vtleads.id = vtsesionlead.id_lead
                              and vtsesionlead.Fecha >= '%s' and vtsesionlead.Fecha <= '%s'
                     GROUP BY pais, ciudad
                     ORDER BY pais, ciudad
                        ";
    $queMaestros = sprintf($FormatMaestros, $Dini, $Dfin);
	//echo "<br />@@@ ----- >".$queMaestros;
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros); 
		$cabeceras = '<div class="EstadPais2T">País</div>';
		$cabeceras .= '<div class="EstadPagina2T">Ciudad</div>';
        $cabeceras .= '<div class="EstadNumero2T">Páginas visitadas</div>'; 
        $cabeceras .= '<div class="EstadNumero2T">Segundos</div>'; 
        $cabeceras .= '<div class="EstadNumero2T">Minutos</div>';
        $cabeceras .= '<div class="clear"></div>';  
     if ($totMaestros > 0){
	   $devolver .= $cabeceras;
	   $n = 0;
       while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		   $n++;
		   if ($pais != $rowMaestros['pais'] && $n != 1) {	   
			    $TotalesPais = TotalesPais($Dini,$Dfin,$pais,$conexion);
			   	$devolver .= '<div class="EstadPais2"></div>';
		        $devolver .= '<div class="EstadPagina2T">'.$pais.'</div>';
                $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[0], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
                $devolver .= '<div class="EstadNumero2T">'.NoZero( number_format ( $TotalesPais[1], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
                $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[2], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
                $devolver .= '<div class="clear"></div>';       	
		   }
		   $devolver .= '<div class="EstadPais2">'.RellenaPuntos($rowMaestros['pais'],30).'</div>';
		   $devolver .= '<div class="EstadPagina2">'.RellenaPuntos($rowMaestros['ciudad'],80).'</div>';
           $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $rowMaestros['CONTADOR'], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
           $devolver .= '<div class="EstadNumero2">'.NoZero( number_format ( $rowMaestros['SEGUNDOS'], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
           $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $rowMaestros['SEGUNDOS'] / 60, $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
           $devolver .= '<div class="clear"></div>'; 
		   $pais = $rowMaestros['pais']; 
       }
	   
	   $TotalesPais = TotalesPais($Dini,$Dfin,$pais,$conexion);
	   $devolver .= '<div class="EstadPais2"></div>';
	   $devolver .= '<div class="EstadPagina2T">'.$pais.'</div>';
       $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[0], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2T">'.NoZero( number_format ( $TotalesPais[1], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[2], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
       $devolver .= '<div class="clear"></div>';       	
       $Totales = Totales($Dini,$Dfin,$conexion);
	   $devolver .= '<b><div class="EstadPais2"></div>';
	   $devolver .= '<div class="EstadPagina2">TOTAL GENERAL</div>';
       $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $Totales[0], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2">'.NoZero( number_format ( $Totales[1], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $Totales[2], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
       $devolver .= '<div class="clear"></div></b>';       	   
     }
	 
     mysqli_free_result($resMaestros);
     return 	$devolver;
 		
}
//...........................................................................
//............... GRATIS ....................................................
//...........................................................................
function TotalesG($Dini,$Dfin,$conexion) {
	$tornar = Array();
   	$FormatMaestros = "SELECT count(pagina) AS CONTADOR, SUM(tiempo_segundos) AS SEGUNDOS
                         FROM vtalumnos, vtsesiongratis
                        WHERE vtalumnos.id = vtsesiongratis.id_alumno
                              and vtsesiongratis.fecha >= '%s' and vtsesiongratis.fecha <= '%s'
                        ";
    $queMaestros = sprintf($FormatMaestros, $Dini, $Dfin);
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros); 
     if ($totMaestros > 0){
       while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		  $TotalPaginas   = $rowMaestros['CONTADOR'];
		  $TotalSegundos  = $rowMaestros['SEGUNDOS'];
		  $TotalMinutos    = ceil($TotalSegundos / 60);
		  array_push($tornar, $TotalPaginas);
		  array_push($tornar, $TotalSegundos);
		  array_push($tornar, $TotalMinutos);
       }
     }
     mysqli_free_result($resMaestros); 
	 return $tornar;		
}
//...........................................................................
function TotalesGPais($Dini,$Dfin,$pais,$conexion) {
	$tornar = Array();
   	$FormatMaestros = "SELECT pais, count(pagina) AS CONTADOR, SUM(tiempo_segundos) AS SEGUNDOS
                         FROM vtalumnos, vtsesiongratis
                        WHERE vtalumnos.id = vtsesiongratis.id_alumno
                              and vtsesiongratis.fecha >= '%s' and vtsesiongratis.fecha <= '%s'
							  and pais = '%s'
                        ";
    $queMaestros = sprintf($FormatMaestros, $Dini, $Dfin,$pais);
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros); 
     if ($totMaestros > 0){
       while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		  $TotalPaginas   = $rowMaestros['CONTADOR'];
		  $TotalSegundos  = $rowMaestros['SEGUNDOS'];
		  $TotalMinutos    = ceil($TotalSegundos / 60);
		  array_push($tornar, $TotalPaginas);
		  array_push($tornar, $TotalSegundos);
		  array_push($tornar, $TotalMinutos);
       }
     }
     mysqli_free_result($resMaestros); 
	 return $tornar;		
}
//...........................................................................
function GratisPaises($Dini,$Dfin,$conexion) {
	
	$Totales = TotalesG($Dini,$Dfin,$conexion);

    $devolver = "";
   	$FormatMaestros = "SELECT vtalumnos.pais, count(pagina) AS CONTADOR, SUM(tiempo_segundos) AS SEGUNDOS
                         FROM vtalumnos, vtsesiongratis
                        WHERE vtalumnos.id = vtsesiongratis.id_alumno
                              and vtsesiongratis.fecha >= '%s' and vtsesiongratis.fecha <= '%s'
                     GROUP BY pais
                     ORDER BY pais
                        ";
    $queMaestros = sprintf($FormatMaestros, $Dini, $Dfin);
	//echo "<br />@@@ ----- >".$queMaestros;
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros); 
		$cabeceras = '<div class="EstadPais1T">País</div>';
        $cabeceras .= '<div class="EstadNumero1T">Páginas visitadas</div>'; 
        $cabeceras .= '<div class="EstadNumero1T">Segundos</div>'; 
        $cabeceras .= '<div class="EstadNumero1T">Minutos</div>';
        $cabeceras .= '<div class="clear"></div>';  
     if ($totMaestros > 0){
	   $devolver .= $cabeceras;
       while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		   $devolver .= '<div class="EstadPais1">'.RellenaPuntos($rowMaestros['pais'],70).'</div>';
           $devolver .= '<div class="EstadNumero1">'.NoZero(number_format ( $rowMaestros['CONTADOR'], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
           $devolver .= '<div class="EstadNumero1">'.NoZero( number_format ( $rowMaestros['SEGUNDOS'], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
           $devolver .= '<div class="EstadNumero1">'.NoZero(number_format ( $rowMaestros['SEGUNDOS'] / 60, $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
           $devolver .= '<div class="clear"></div>';  
       }
	   $devolver .= '<b><div class="EstadPais1">'.RellenaPuntos('TOTAL',70).'</div>';
       $devolver .= '<div class="EstadNumero1">'.NoZero(number_format ( $Totales[0], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero1">'.NoZero(number_format ( $Totales[1], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero1">'.NoZero(number_format ( $Totales[2], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )) .'</div></b>';
       $devolver .= '<div class="clear"></div>';  
    
     }
     mysqli_free_result($resMaestros);
     return 	$devolver;
}
//...........................................................................
function GratisPaisesPag($Dini,$Dfin,$conexion) {
	//$Totales = Totales($Dini,$Dfin,$conexion);
    $devolver = "";
   	$FormatMaestros = "SELECT vtalumnos.pais, pagina, count(pagina) AS CONTADOR, SUM(tiempo_segundos) AS SEGUNDOS
                         FROM vtalumnos, vtsesiongratis
                        WHERE vtalumnos.id = vtsesiongratis.id_alumno
                              and vtsesiongratis.fecha >= '%s' and vtsesiongratis.fecha <= '%s'
                     GROUP BY pais, pagina
                     ORDER BY pais, pagina
                        ";
    $queMaestros = sprintf($FormatMaestros, $Dini, $Dfin);
	//echo "<br />@@@ ----- >".$queMaestros;
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros); 
		$cabeceras = '<div class="EstadPais2T">País</div>';
		$cabeceras .= '<div class="EstadPagina2T">Página</div>';
        $cabeceras .= '<div class="EstadNumero2T">Veces visitada</div>'; 
        $cabeceras .= '<div class="EstadNumero2T">Segundos</div>'; 
        $cabeceras .= '<div class="EstadNumero2T">Minutos</div>';
        $cabeceras .= '<div class="clear"></div>';  
     if ($totMaestros > 0){
	   $devolver .= $cabeceras;
	   $n = 0;
       while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		   $n++;
		   if ($pais != $rowMaestros['pais'] && $n != 1) {	   
			    $TotalesPais = TotalesGPais($Dini,$Dfin,$pais,$conexion);
			   	$devolver .= '<div class="EstadPais2"></div>';
		        $devolver .= '<div class="EstadPagina2T">'.$pais.'</div>';
                $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[0], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
                $devolver .= '<div class="EstadNumero2T">'.NoZero( number_format ( $TotalesPais[1], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
                $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[2], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
                $devolver .= '<div class="clear"></div>';       	
		   }
		   $devolver .= '<div class="EstadPais2">'.RellenaPuntos($rowMaestros['pais'],30).'</div>';
		   $devolver .= '<div class="EstadPagina2">'.RellenaPuntos($rowMaestros['pagina'],50).'</div>';
           $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $rowMaestros['CONTADOR'], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
           $devolver .= '<div class="EstadNumero2">'.NoZero( number_format ( $rowMaestros['SEGUNDOS'], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
           $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $rowMaestros['SEGUNDOS'] / 60, $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
           $devolver .= '<div class="clear"></div>'; 
		   $pais = $rowMaestros['pais']; 
       }
	   
	   $TotalesPais = TotalesGPais($Dini,$Dfin,$pais,$conexion);
	   $devolver .= '<div class="EstadPais2"></div>';
	   $devolver .= '<div class="EstadPagina2T">'.$pais.'</div>';
       $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[0], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2T">'.NoZero( number_format ( $TotalesPais[1], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[2], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
       $devolver .= '<div class="clear"></div>';       	
       $Totales = TotalesG($Dini,$Dfin,$conexion);
	   $devolver .= '<b><div class="EstadPais2"></div>';
	   $devolver .= '<div class="EstadPagina2">TOTAL GENERAL</div>';
       $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $Totales[0], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2">'.NoZero( number_format ( $Totales[1], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $Totales[2], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
       $devolver .= '<div class="clear"></div></b>';       	   
     }
	 
     mysqli_free_result($resMaestros);
     return 	$devolver;
 		
}
//...........................................................................
function GratisPaisesCiudad($Dini,$Dfin,$conexion) {
	//$Totales = Totales($Dini,$Dfin,$conexion);
    $devolver = "";
   	$FormatMaestros = "SELECT vtalumnos.pais, ciudad, count(pagina) AS CONTADOR, SUM(tiempo_segundos) AS SEGUNDOS
                         FROM vtalumnos, vtsesiongratis
                        WHERE vtalumnos.id = vtsesiongratis.id_alumno
                              and vtsesiongratis.fecha >= '%s' and vtsesiongratis.fecha <= '%s'
                     GROUP BY pais, ciudad
                     ORDER BY pais, ciudad
                        ";
    $queMaestros = sprintf($FormatMaestros, $Dini, $Dfin);
	//echo "<br />@@@ ----- >".$queMaestros;
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros); 
		$cabeceras = '<div class="EstadPais2T">País</div>';
		$cabeceras .= '<div class="EstadPagina2T">Ciudad</div>';
        $cabeceras .= '<div class="EstadNumero2T">Páginas visitadas</div>'; 
        $cabeceras .= '<div class="EstadNumero2T">Segundos</div>'; 
        $cabeceras .= '<div class="EstadNumero2T">Minutos</div>';
        $cabeceras .= '<div class="clear"></div>';  
     if ($totMaestros > 0){
	   $devolver .= $cabeceras;
	   $n = 0;
       while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		   $n++;
		   if ($pais != $rowMaestros['pais'] && $n != 1) {	   
			    $TotalesPais = TotalesGPais($Dini,$Dfin,$pais,$conexion);
			   	$devolver .= '<div class="EstadPais2"></div>';
		        $devolver .= '<div class="EstadPagina2T">'.$pais.'</div>';
                $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[0], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
                $devolver .= '<div class="EstadNumero2T">'.NoZero( number_format ( $TotalesPais[1], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
                $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[2], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
                $devolver .= '<div class="clear"></div>';       	
		   }
		   $devolver .= '<div class="EstadPais2">'.RellenaPuntos($rowMaestros['pais'],30).'</div>';
		   $devolver .= '<div class="EstadPagina2">'.RellenaPuntos($rowMaestros['ciudad'],80).'</div>';
           $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $rowMaestros['CONTADOR'], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
           $devolver .= '<div class="EstadNumero2">'.NoZero( number_format ( $rowMaestros['SEGUNDOS'], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
           $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $rowMaestros['SEGUNDOS'] / 60, $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
           $devolver .= '<div class="clear"></div>'; 
		   $pais = $rowMaestros['pais']; 
       }
	   
	   $TotalesPais = TotalesGPais($Dini,$Dfin,$pais,$conexion);
	   $devolver .= '<div class="EstadPais2"></div>';
	   $devolver .= '<div class="EstadPagina2T">'.$pais.'</div>';
       $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[0], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2T">'.NoZero( number_format ( $TotalesPais[1], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2T">'.NoZero(number_format ( $TotalesPais[2], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
       $devolver .= '<div class="clear"></div>';       	
       $Totales = TotalesG($Dini,$Dfin,$conexion);
	   $devolver .= '<b><div class="EstadPais2"></div>';
	   $devolver .= '<div class="EstadPagina2">TOTAL GENERAL</div>';
       $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $Totales[0], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2">'.NoZero( number_format ( $Totales[1], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>'; 
       $devolver .= '<div class="EstadNumero2">'.NoZero(number_format ( $Totales[2], $decimals = 0 , $dec_point = "," , $thousands_sep = "." )).'</div>';
       $devolver .= '<div class="clear"></div></b>';       	   
     }
	 
     mysqli_free_result($resMaestros);
     return 	$devolver;
 		
}
//...........................................................................
//...........................................................................
//...........................................................................
//...........................................................................
//...........................................................................
//...........................................................................
//...........................................................................
//...........................................................................
//...........................................................................

?>
<!doctype html>
<html lang="es">


      <SCRIPT LANGUAGE="JavaScript"> 
	   function Procesar(campo) {
		   ini =  document.getElementById('Fecha_Ini').value;
		   fin =  document.getElementById('Fecha_Fin').value; 
		   if (fin < ini) {
			alert("Fecha FIN menor que INICIO ---->Vuelva a entrar las fechas");
			return;   
		   }
			 
		   document.datos.action="EstadisticaAccesos.php";
		   document.datos.submit();
	   }
	   function EnsenyaRecalculo() {
		  ini =  document.getElementById('Recalculo').style.display = "inline"; 
	   }
    </SCRIPT>
  

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Estadísticas de accesos: Leads y Sesiones gratis</title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />
<!-Hoja de estilos del calendario --> 
  <link rel="stylesheet" type="text/css" media="all" href="../php/calendar/calendar-green.css" title="win2k-cold-1" /> 

  <!-- librería principal del calendario --> 
 <script type="text/javascript" src="../php/calendar/calendar.js"></script> 

 <!-- librería para cargar el lenguaje deseado --> 
  <script type="text/javascript" src="../php/calendar/lang/calendar-es.js"></script> 

  <!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código --> 
  <script type="text/javascript" src="../php/calendar/calendar-setup.js"></script> 

</head>
<?php
 	include_once('../conexion/conn_bbdd.php');
?>
<body>

<br>

<div class="TituloEstadistica">ESTADÍSTICAS de acceso: Leads y Sesiones gratis</div>
<br />
<div id = "cabeceraEstadistica"> 

<form id = "datos" name= "datos"  method="post">  <!--action="SubgruposFicha.php"-->
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='mantenimiento.php'" /> &nbsp; &nbsp; &nbsp; &nbsp;
&nbsp; &nbsp;Fecha alta >= a:  <input id = "Fecha_Ini" name="Fecha_Ini" size="12"  maxlength="12"  onChange="EnsenyaRecalculo()" value="<?php $_REQUEST['Fecha_Ini'] ?>" />
<?php echo elfecha('Fecha_Ini', 'date');?>
&nbsp; &nbsp;Fecha alta <= a:  <input id = "Fecha_Fin" name="Fecha_Fin" size="12"  maxlength="12"  onChange="EnsenyaRecalculo()"  value="<?php $_REQUEST['Fecha_Fin'] ?>" />
<?php echo elfecha('Fecha_Fin', 'date');?>
&nbsp; &nbsp; &nbsp; &nbsp;
<div id="Recalculo"><input name="Precesar" type="button" value ="Recalcular Estadística" onClick = "Procesar()" /> </div>
</form>
</div>

<script>
document.getElementById('Fecha_Ini').value = <?php echo '"'.$_REQUEST['Fecha_Ini'].'"';?>;
document.getElementById('Fecha_Fin').value = <?php echo '"'.$_REQUEST['Fecha_Fin'].'"';?>;
</script>




<div class = "Separador"> &nbsp;</div><br/><br/>
<div class="envoltorioEstadistica">
<div class="GratisCabeceraG">Alumnos Gratis: Países</div>
  <?php echo GratisPaises($_REQUEST['Fecha_Ini'],$_REQUEST['Fecha_Fin'],$conexion) ?>
</div>
<div class="GratisCabeceraG">Alumnos Gratis: Países / Páginas</div> 
 <?php echo GratisPaisesPag($_REQUEST['Fecha_Ini'],$_REQUEST['Fecha_Fin'],$conexion) ?>
</div>
<div class="GratisCabeceraG">Alumnos Gratis: Países / Ciudades</div>
<?php echo GratisPaisesCiudad($_REQUEST['Fecha_Ini'],$_REQUEST['Fecha_Fin'],$conexion) ?>
</div>

<div class="LeadCabeceraG">Leads: Países</div>
  <?php echo LeadsPaises($_REQUEST['Fecha_Ini'],$_REQUEST['Fecha_Fin'],$conexion) ?>
</div>
<div class="LeadCabeceraG">Leads: Países / Páginas</div>
    <?php echo LeadsPaisesPag($_REQUEST['Fecha_Ini'],$_REQUEST['Fecha_Fin'],$conexion) ?>
</div>
<div class="LeadCabeceraG">Leads: Países / Ciudades</div>
<?php echo LeadsPaisesCiudad($_REQUEST['Fecha_Ini'],$_REQUEST['Fecha_Fin'],$conexion) ?>
</div>








<br>
<br>
<script type="text/javascript"> 

<?php
   
		echo 'Calendar.setup({ inputField: "'.'Fecha_Ini'.'", ifFormat : "%Y-%m-%d",  button : "'."BOT".'Fecha_Ini'.'" }); ';   
		echo 'Calendar.setup({ inputField: "'.'Fecha_Fin'.'", ifFormat : "%Y-%m-%d",  button : "'."BOT".'Fecha_Fin'.'" }); ';  

   	   
/*   Calendar.setup({ 
    inputField     :    "campo_fecha",     
     ifFormat     :     "%d/%m/%Y",    
     button     :    "lanzador"     
     }); */

?>

</script> 

</body>
</html>
<?php mysqli_close($conexion); ?>
