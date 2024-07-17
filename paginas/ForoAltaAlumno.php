<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
    
include_once('NewWebEstilosNOIndex.php');

$Referencia = $_REQUEST['Referencia'];
$numeroPrimo  = $DatosWeb->GetTrimValor('numeroprimo');
$solicitud = 0;
$modulo = $Referencia % $numeroPrimo ;
if ($modulo == 0) {
	  $solicitud = $Referencia / $numeroPrimo ;  
} else {
	  echo "ERROR procesando inscripcon al foro, vuelva a inscribirse visitando la pagina: ";
	  echo "<a href='".$DatosWeb->GetTrimValor('web_url')."/Foros/Foro.php'>".$DatosWeb->GetTrimValor('web_dominio')."</a>";
	  
	  echo "</head>";
	  exit;
}

//.........................................................buscar datos de la solicitud
$cobroID = 14;
$alumnoID = 0;
$mailAlumno        = "";
$aliasAlumno       = "";
$descripcionAlumno = "";
$alumnoPWD         = "";
$fecha_alta        = "";
$ip                = "";
$alumnoPais        = "";
$alumnoCiudad      = "";
$obser_medif       = "Alta en Foros";
$FormatMaestros = "SELECT id, email, alias, descripción, pwd, fecha_alta, ip, pais, ciudad
 	                 FROM forosolicitudes
 	                WHERE id = %d
				          ";
$queMaestros = sprintf($FormatMaestros,$solicitud);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
         $mailAlumno        = $rowVTMaestros['email'];
         $aliasAlumno       = $rowVTMaestros['alias'];
         $descripcionAlumno = $rowVTMaestros['descripción'];
         $alumnoPWD         = $rowVTMaestros['pwd'];
         $fecha_alta        = $rowVTMaestros['fecha_alta'];
         $ip                = $rowVTMaestros['ip'];
         $alumnoPais        = $rowVTMaestros['pais'];
         $alumnoCiudad      = $rowVTMaestros['ciudad'];
	 }	
} else {
	exit;
}
 mysqli_free_result($resMaestros);
 
//...................................................................dar de alta al alumno
//..............................................comprobar si existe......
$FormatSelect = "SELECT id
                   FROM vtalumnos
                  WHERE email = '%s'
				        ";
$queSelect = sprintf($FormatSelect, $mailAlumno);
$resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
$totSelect = mysqli_num_rows($resSelect);     
if ( $totSelect > 0 ) {
	while ($rowVTPwd = mysqli_fetch_assoc($resSelect)) {
		    $alumnoID = $rowVTPwd['id'];
	 }	
}	
mysqli_free_result($resSelect);

//..............................................alta de alumno......
if ( $alumnoID == 0) {
    $FormatMaestros = "INSERT into vtalumnos (
     email,
     pwd,
     tipoalumno,
     pais,
     ciudad,
     alias_foro,
     alias_comment,
     fecha_alta,
     observaciones_medif,
     ultima_ip,
     ultima_conexion,
     es_colaborador,
     telefono)  
	   values ('%s','%s',%d,'%s','%s','%s','%s','%s','%s','%s','%s',0,'') ";
  $queMaestros = sprintf($FormatMaestros, $mailAlumno, $alumnoPWD, 
                         0, $alumnoPais, $alumnoCiudad, $aliasAlumno, $descripcionAlumno, date('Y-m-d') , 'Alta FOROS',$ip,date('Y-m-d'));
  $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
  //echo "<br />Hemos dado de alta al alumno<br />";
  mysqli_free_result($resMaestros);
 
  //............................................recuperar el id a manini...........
 
  $FormatSelect = "select max(id) as NUMERO from vtalumnos";
  $queSelect = $FormatSelect;
  $resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
  $totSelect = mysqli_num_rows($resSelect);     
  if ( $totSelect > 0 ) {
  	while ($rowVTPwd = mysqli_fetch_assoc($resSelect)) {
  		    $alumnoID = $rowVTPwd['NUMERO']; 		    
  	 }	
  }	
  mysqli_free_result($resSelect);
}
  
//............................................recuperar pwd
$FormatSelect = "SELECT id, pwd 
                   FROM vtalumnos
                  WHERE id  = %d
				        ";
$queSelect = sprintf($FormatSelect, $alumnoID);
$resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
$totSelect = mysqli_num_rows($resSelect);     
if ( $totSelect > 0 ) {
	while ($rowVTPwd = mysqli_fetch_assoc($resSelect)) {
		    $alumnoPWD = $rowVTPwd['pwd'];
	 }	
}	
mysqli_free_result($resSelect);


?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Respuesta Alta a Foros</title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>


<body> 
<?php  
include_once('MenuNOIndex.php');   
?>
<?php 
 
/*echo "<br>Inicio parámetros ========================================================================<br>";	  
	  $numero2 = count($_REQUEST);
      $tags2 = array_keys($_REQUEST); // obtiene los nombres de las varibles
      $valores2 = array_values($_REQUEST);// obtiene los valores de las varibles

     for($i=0;$i<$numero2;$i++){ 
         echo $tags2[$i]."=".$valores2[$i]."<br>"; 
      }
echo "<br>Final parámetros ========================================================================";	  
*/
?>

<div class="NuevoAlumno">

  <img src="../imagenes/ForoPrincipal.jpg"  alt="Foro" />
    <br />
    <br />
    <div id = "CBmarcoMensaje" >&nbsp;</div>
    <div class="centro"> 
        <br/>
        <p>Te hemos dado de alta como: <b><?php echo $mailAlumno ?></b> con la password: <b><?php echo $alumnoPWD ?> </b></p>
        <p> <a href="<?php echo $DatosWeb->GetTrimValor('web_url') ?>/Foros/Foro.php">Entra en FOROS y conéctate con los datos facilitados</a></p>
    </div>
    
    
    <br /> 


</div>
    <br /><br />
<div class="centro90"><?php include_once('PaginaPieNOIndex.php'); ?></div>




</body>
</html>
