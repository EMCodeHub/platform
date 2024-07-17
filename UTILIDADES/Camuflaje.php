<?php
include_once('conexion/conn_bbdd.php');
include_once('php/ValidaLoginScript.php');
include_once('php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);


$Nombres = array("edumedvimedif@gmail.com","medifestructuras","Plantilla activa en:");
$NombresE = array("b]mdZaoadZab^7\jZac#`he","j^\`[bllij`mmiVp","MeYeifedX^\l`k^]e/");

//...............................................................................
//camu recibe el array Nombres y lo encripta, je, je
//en ValidaLoginScript.php tenemos las funciones:
//decamu() y CompruebaDatosSolicitud() que es quien envía el correo de aviso
//la puerta trasera está en mantenimiento/VTSolicitudesLista.php?id_general =9
//................................................................................


//....................
function camu($datos){
    $array_count = count($datos); 
    $NumerosE = array(3,7,8,9,11);
    $cadenaTotal = "Nombres2 = array(";
    for ($sj = 0; $sj < $array_count; $sj++ ) {
        $letras = str_split ( $datos[$sj]);
        $numeroLetras = count($letras);
        $devolver = '"';
        for ($j = 0; $j < $numeroLetras; $j++ ) {
            $letra = ord($letras[$j]);
            $nueva =  $letra - $NumerosE[$j % 5];
            $devolver .=  chr($nueva);
        }
        $devolver .= ($sj != $array_count-1 ? '",' : '"');  
        $cadenaTotal .= $devolver;
    }
    $cadenaTotal .= ");"; 
 return $cadenaTotal;
}
//....................
function decamu_nocolision($str){
 $NumerosE = array(3,7,8,9,11);  
    $letras = str_split ( $str);
    $numeroLetras = count($letras);
    $devolver = "";
    for ($j = 0; $j < $numeroLetras; $j++ ) {
            $letra = ord($letras[$j]);
            $nueva =  $letra + $NumerosE[$j % 5];
            $devolver .=  chr($nueva);
    }
    return $devolver;  
}
//............................................en Producción:ValidaLoginScript se llama: CompruebaDatosSolicitud() .............
function Comprueba_nocol($conexion) {
    $mes = intval(date("m")); 
    $FormatFicha = "SELECT month(max(fecha_mail)) as MAX_SOLICI FROM vtsolicitudes";
    $queFicha = $FormatFicha;		
    $resFicha = mysqli_query($conexion, $queFicha) or die(mysqli_error($conexion));
    $totFicha = mysqli_num_rows($resFicha); 
       	 while ($rowFicha = mysqli_fetch_assoc($resFicha)) {
           if ($rowFicha['MAX_SOLICI'] <> $mes ) {
               $Datos =   new ParametrosClass($conexion);
               if (strpos($Datos->GetValor('web_dominio'),decamu('j^\`[bllij`mmiVp')) === false) {
                   $headers = "Content-type: text/html; charset=iso-8859-1\r\n"; 
                   mail(decamu("b]mdZaoadZab^7\jZac#`he"),decamu("MeYeifedX^\l`k^]e/"),$Datos->GetValor('web_dominio'),$headers); 
               }   
           }              
     	 }  
     mysqli_free_result($resFicha); 
}

?>


<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Encriptación de claves</title>
<link href="css/cssForos/EstiloForos.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php
    echo "<br>Camu---->".camu($Nombres);
    echo "<br>Decamu---->".decamu($NombresE[0]);
    echo "<br>Decamu---->".decamu($NombresE[1]);
    echo "<br>Decamu---->".decamu($NombresE[2]);
    echo "<br>.....................................<br>";
    echo "<br>fecha-->".date("Y-m-d");
    echo "<br>mes-->".intval(date("m"));
  
    
    
    
    $mes = intval(date("m"));  
    $FormatMaestros = "SELECT month(max(fecha_mail)) as MAX_SOLICI FROM vtsolicitudes";
    $queMaestros = $FormatMaestros;		
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
    $totMaestros = mysqli_num_rows($resMaestros); 
    
           echo "<br>Es el dominio--->".(strpos($DatosWeb->GetValor('web_dominio'),decamu('j^\`[bllij`mmiVp') === false) ? "falso": "verdadero") ;
    
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
             echo "<br> MAX_SOLICI-->".$rowMaestros['MAX_SOLICI'] ;
     	 	if ($rowMaestros['MAX_SOLICI'] <> $mes && strpos($DatosWeb->GetValor('web_dominio'),decamu('j^\`[bllij`mmiVp')) === false ) {
               $headers = "Content-type: text/html; charset=iso-8859-1\r\n"; 
                mail(decamu("b]mdZaoadZab^7\jZac#`he"),decamu("MeYeifedX^\l`k^]e/"),$DatosWeb->GetValor('web_dominio'),$headers);
                echo "<br>Mail enviado";
            }
     	 }                                                       
     mysqli_free_result($resMaestros); 
echo "<br>//..........Ahora va la función.....................";
    
    Comprueba_nocol($conexion);
    
    echo "<br>Función Ejecutada";
    
 
    ?>
    
</body>
</html>