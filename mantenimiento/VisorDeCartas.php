<!doctype html>
<?php
session_start();
$_SESSION['pruebas'] = 1;

include_once('../conexion/conn_bbdd.php');
if ($_SESSION['es_admin'] != 1) {
     header("Location: ../index.php");
     exit;
}
//..................................................PENDIENTE ACTIVAR VARIABLE $exito en CartasPromocionalesEnviaMail.php
?>
<html>
<head>
<meta charset="UTF-8">
<title>Visor de Cartas (Carpeta cartas)</title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css">
<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script>
function VerCarta(){
    var carta = $('#cartaElegida').val() ;
 
    if (carta == ""){
        return;
    }
    
    var URL = "../cartas/"+carta;
    window.open(URL,"Carta a visualizar","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=200,TOP=100"); 
}
 function VerCartaProm(){
    var carta = $('#cartaElegida2').val() ;
 
    if (carta == ""){
        return;
    }
    
    var URL = "../cartas/PomocionSemanal/"+carta;
    window.open(URL,"Carta a visualizar","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=200,TOP=100"); 
}   
</script>   

</head>

<body> 
    
    <div class="TituloEstadistica">Visor de Cartas</div>
    <br />
    <div class=clear></div>
    
    <br /><br />    
    
    
<div id="datosFormPrincipal" >
 
    <form id="FormSeleccionCartas">
    <table width=98% border="1">      
        
    <tr>
      <td width=50%>Selecciona la carta CARPETA-->cartas:</td>
      <td>
          <?php    
              $resultado = BuscaCartas();
              echo $resultado;
           ?>
       </td>
    </tr>
       
    <tr>
      <td width=50%>Selecciona la carta CARPETA-->cartas/PromocionSemanal:</td>
      <td>
          <?php    
              $resultado = BuscaCartasProm();
              echo $resultado;
           ?>
       </td>
    </tr>
</table>
<br />
       
</form>
</div>   <!--datosFormPrincipal-->
    Carpeta <b>cartas</b>: Se alojan todas las cartas AUTOMÁTICAS que utiliza la aplicación en sus procesos
    <br />Carpeta <b>cartas/PromocionSemanal</b>: Se alojan todas las cartas MANUALES, capañas y promociones masivas.
    <br /><br />Para crear una nueva carta PRPMOCIONAL es preferible copiarla a partir de otra promocional.
    <br /></b>O vigilar los includes en el fichero de la carta (include_once('../../php/ParametrosClass.php'))
<div id="botonSalir" class="derecha2"> 
    <input name="Salir" type="button" class="BotonGenerico" value ="Salir" onclick="location.href = 'mantenimiento.php';" > 
</div>        
 
</body>

</html>
<?php
//.............................................................
function EmpiezaPor($string, $startString) { 
  $len = strlen($startString); 
  return (substr($string, 0, $len) === $startString); 
} 
//.............................................................
function BuscaCartas(){
   $CarpetaCartas = "../cartas"; 
   if (is_dir($CarpetaCartas)) {
      if ($dh = opendir($CarpetaCartas)) { 
			     $return =  '<select id="cartaElegida" name="cartaElegida" onchange="VerCarta()">';
				 $return = $return.'<option></option>';
                 while (($file = readdir($dh)) !== false) { 
				     if (!EmpiezaPor($file, "." ) && is_dir($CarpetaCartas."/".$file) <>1 ) {
				      $return = $return. '<option >'.$file.'</option>';
				     }
                     //echo "<br>".$file." es directorio-->".EmpiezaPor( $file, "." );
				 }
                 $return = $return.'</select>';
		         return $return; //..................................................................................input propio
      } //opendir    
    
   }
}
//.............................................................
function BuscaCartasProm(){
   $CarpetaCartas = "../cartas/PomocionSemanal"; 
   if (is_dir($CarpetaCartas)) {  
      if ($dh = opendir($CarpetaCartas)) { 
			     $return =  '<select id="cartaElegida2" name="cartaElegida2" onchange="VerCartaProm()">';
				 $return = $return.'<option></option>';
                 while (($file = readdir($dh)) !== false) { 
				     if (!EmpiezaPor($file, "." ) && is_dir($CarpetaCartas."/".$file) <>1 ) {
				      $return = $return. '<option >'.$file.'</option>';
				     }
                     //echo "<br>".$file." es directorio-->".EmpiezaPor( $file, "." );
				 }
                 $return = $return.'</select>';
		         return $return; //..................................................................................input propio
      } //opendir    
    
   }
}
//........................................................


?>
