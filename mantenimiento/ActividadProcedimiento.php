<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Ficha del Procedimiento</title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.C90 {
	width:95%;
	padding:1%;
	margin:0px;
	
}

.nombreFicTit {
	text-align:left;
	padding-left:1%;
	background-color:#EAD20C;
	font-family:Arial, Helvetica, sans-serif;
	color:#FFF;
	width:20%;
	float:left;
	display:inline;
	margin-top:2px;
	margin-bottom:3px;
	font-size:0.9em;
}
.nombreFic {
      float:left;
	  display:inline;
	  width:20%;	
	  cursor:pointer;
}
.descriFicTit {
    margin-left:10px;
	text-align:left;
	padding-left:1%;
	background-color:#EAD20C;
	font-family:Arial, Helvetica, sans-serif;
	color:#FFF;
	width:75%;
	float:left;
	display:inline;
	margin-top:2px;
	margin-bottom:3px;
	font-size:0.9em;

}
.descriFic {
	  float:left;
	  display:inline;
	  margin-left:20px;
	  width:75%;
	  font-size:0.8em;
}
.rayaFicTit {
    height:1px;
	text-align:left;
	padding-left:1%;
	background-color:#EAD20C;
	font-family:Arial, Helvetica, sans-serif;
	color:#FFF;
	width:97%;
	float:left;
	display:block;
	margin-top:2px;
	margin-bottom:3px;
	font-size:0.9em;

}
.rayaProc {
    height:1px;
	text-align:left;
	padding-left:1%;
	background-color:#CBE983;
	font-family:Arial, Helvetica, sans-serif;
	color:#FFF;
	width:97%;
	float:left;
	display:block;
	margin-top:2px;
	margin-bottom:3px;
	font-size:0.9em;

}

.nombreProcTit {
	text-align:left;
	padding-left:1%;
	background-color:#CBE983;
	font-family:Arial, Helvetica, sans-serif;
	color:#FFF;
	width:35%;
	float:left;
	display:inline;
	margin-top:2px;
	margin-bottom:3px;
	font-size:0.9em;
}
.nombreProc {
      float:left;
	  display:inline;
	  width:35%;	
	  cursor:pointer;
	  font-size:0.9em;
	  margin-top: 3px;

}
.descriProcTit {
    margin-left:10px;
	text-align:left;
	padding-left:1%;
	background-color:#CBE983;
	font-family:Arial, Helvetica, sans-serif;
	color:#FFF;
	width:60%;
	float:left;
	display:inline;
	margin-top:2px;
	margin-bottom:3px;
	font-size:0.9em;

}
.descriProc {
      float:left;
	  display:inline;
	  margin-left:20px;
	  margin-top: 3px;
	  width:60%;
	  font-size:0.8em;

}
.nombreFun {
	
	margin-top:2px;
}

</style>
<script>
openedWindowP = null;
openedWindowT = null;
function VerProcedimiento(id){
           if (openedWindowP != null) {
             openedWindowP.close();
           }
		   URL = "ActividadProcedimiento.php?NumeroProc="+id;
	       openedWindowP =  window.open(URL,"Ficha del Procedimiento","width=1200,height=700,scrollbars=YES,resizable=YES,LEFT=250,TOP=150") 	
}
function VerTabla(nombre){
           if (openedWindowT != null) {
             openedWindowT.close();
           }
		   URL = "ActividadTabla.php?NombreTabla="+nombre;
	       openedWindowT =  window.open(URL,"Ficha de la Tabla","width=900,height=500,scrollbars=YES,resizable=YES,LEFT=300,TOP=100") 	
}

function CerrarVentana(){
   window.close();
}

</script>
</head>

<body>
<?php
include_once('../conexion/conn_bbdd.php');
//include_once('../php/ValidaLoginScript.php');
session_start();
//...........................................................................
function NoZero($num) {
	return ($num == 0 ? "..." : $num);
}
function NoNull($num) {
	if (is_null($num)) {
	  return "....";
	} else {
	  return $num;
	}
}

//...........................................................................
function RellenaPuntos($txt) {
	$longTexto = strlen($txt);
	$relleno = "";
	if ($longTexto < 60) {
		$relleno = str_repeat(".",60-$longTexto);
		return $txt.$relleno;
	}
	return $txt;
} 

// .............................................................................
function NombreProcedimiento ($id, $conexion) {
	$devolver = "";
	$FormatTmp = "SELECT carpeta, fichero
                    FROM ctr_ficheros
                   WHERE id = %d";
    $queTmp = sprintf($FormatTmp, $id);	
    $resTmp = mysqli_query($conexion, $queTmp) or die(mysqli_error($conexion)); 
    $totTmp = mysqli_num_rows($resTmp);     
     if ($totTmp > 0){
     	 while ($rowTmp = mysqli_fetch_assoc($resTmp)) {
     	 	$devolver = $rowTmp['carpeta']."/".$rowTmp['fichero'];
     	 }   
     } 
     mysqli_free_result($resTmp);	
	 return $devolver;
}    
// .............................................................................
function DescripcionProcedimiento ($id, $conexion) {
	$devolver = "";
	$FormatTmp = "SELECT descripcion
                    FROM ctr_ficheros
                   WHERE id = %d";
    $queTmp = sprintf($FormatTmp, $id);	
    $resTmp = mysqli_query($conexion, $queTmp) or die(mysqli_error($conexion)); 
    $totTmp = mysqli_num_rows($resTmp);     
     if ($totTmp > 0){
     	 while ($rowTmp = mysqli_fetch_assoc($resTmp)) {
     	 	$devolver = $rowTmp['descripcion'];     	 
     	 }   
     } 
     mysqli_free_result($resTmp);	
	 return $devolver;
}    
//...............................................................................................
function VerTablas ($id, $conexion) {
$devolver = '<div class="nombreFicTit">Nombre</div><div class="descriFicTit">Descripción</div><div class="clear"></div>';
	$FormatTmp = "SELECT tabla_nombre AS NOMBRE, ctr_tablas.descripcion AS DESCRIPCION
	                FROM ctr_fictablas, ctr_tablas
                   WHERE ctr_fictablas.id_tabla = ctr_tablas.id
                     AND id_procedimiento = %d";
    $queTmp = sprintf($FormatTmp, $id);	
    $resTmp = mysqli_query($conexion, $queTmp) or die(mysqli_error($conexion)); 
    $totTmp = mysqli_num_rows($resTmp);     
     if ($totTmp > 0){
     	 while ($rowTmp = mysqli_fetch_assoc($resTmp)) {
     	 	$devolver .= '<div class="nombreFic"  onclick = "VerTabla('."'".$rowTmp['NOMBRE']."'".')">'.$rowTmp['NOMBRE'].'</div>';
     	 	$devolver .= '<div class="descriFic">'.$rowTmp['DESCRIPCION'].'</div>';
            $devolver .= '<div class="rayaFicTit"></div>';
     	 }   
     } 
     mysqli_free_result($resTmp);	
return $devolver;
}


//...............................................................................................
function VerFunciones ($id, $conexion) {
$devolver = '<div class="rayaFicTit"></div><div class="clear"></div>';
	$FormatTmp = "SELECT nombre_funcion
                    FROM ctr_ficfunciones
                    WHERE id_procedimiento = %d";
    $queTmp = sprintf($FormatTmp, $id);	
    $resTmp = mysqli_query($conexion, $queTmp) or die(mysqli_error($conexion)); 
    $totTmp = mysqli_num_rows($resTmp);     
     if ($totTmp > 0){
     	 while ($rowTmp = mysqli_fetch_assoc($resTmp)) {
     	 	$devolver .= '<div class="nombreFun">'.$rowTmp['nombre_funcion'].'</div>';
            $devolver .= '<div class="clear"></div>';
     	 }   
     } 
     mysqli_free_result($resTmp);	
return $devolver;
}
//...............................................................................................
function VerAscendientes($id,$ascen_descen,$conexion) {
$devolver = '<div class="nombreProcTit">Nombre</div><div class="descriProcTit">Descripción</div><div class="clear"></div>';
	$FormatTmp = "SELECT fichero, descripcion, ctr_ficheros.id AS NUMERO
                    FROM ctr_ficpadreshijos, ctr_ficheros
                   WHERE ctr_ficpadreshijos.id_fichero  = ctr_ficheros.id
                     AND  ascen_descen  = '%s'
                     AND id_procedimiento = %d";
    $queTmp = sprintf($FormatTmp, $ascen_descen, $id);	
    $resTmp = mysqli_query($conexion, $queTmp) or die(mysqli_error($conexion)); 
    $totTmp = mysqli_num_rows($resTmp);     
     if ($totTmp > 0){
     	 while ($rowTmp = mysqli_fetch_assoc($resTmp)) {
     	 	$devolver .= '<div class="nombreProc" onclick="VerProcedimiento('.$rowTmp['NUMERO'].')"' .'>'.$rowTmp['fichero'].'</div>';
     	 	$devolver .= '<div class="descriProc">'.$rowTmp['descripcion'].'</div>';
            $devolver .= '<div class="rayaProc"></div>';
     	 }   
     } 
     mysqli_free_result($resTmp);	
return $devolver;
}


?>
    
    
    
    
    
<div class="gris"> Ficha del Procedimiento: <?php echo $_REQUEST['NumeroProc'] ?></div>
<div class="C90">
    <div class="etiqueta">Nombre:</div>
    <div class="etiquetaDatos"> <?php echo  NombreProcedimiento($_REQUEST['NumeroProc'], $conexion) ?></div>
    <div class="clear"></div>
</div>
<div class="C90">
    <div class="etiqueta">Descripción:</div>
    <div class="etiquetaDatos"> <?php echo  DescripcionProcedimiento($_REQUEST['NumeroProc'], $conexion) ?></div>
    <div class="clear"></div>
</div>
<div class="C90">
    <div class="etiqueta">Ascendientes:</div>
    <div class="etiquetaDatos"> <?php echo  VerAscendientes($_REQUEST['NumeroProc'],"A", $conexion) ?></div>
    <div class="clear"></div>
</div>
<div class="C90">
    <div class="etiqueta">Descendientes:</div>
    <div class="etiquetaDatos"> <?php echo  VerAscendientes($_REQUEST['NumeroProc'],"D", $conexion) ?></div>
    <div class="clear"></div>
</div>

<div class="C90">
    <div class="etiqueta">Tablas:</div>
    <div class="etiquetaDatos"> <?php echo  VerTablas($_REQUEST['NumeroProc'], $conexion) ?></div>
    <div class="clear"></div>
</div>
<div class="C90">
    <div class="etiqueta">Funciones:</div>
    <div class="etiquetaDatos"> <?php echo  VerFunciones($_REQUEST['NumeroProc'], $conexion) ?></div>
    <div class="clear"></div>
</div>
<br />
<div class="C90"><div class="derecha">
<input type="button" name="&nbsp;salir&nbsp;" value="Salir" class ="ButtonSalir" onclick="CerrarVentana()" />
</div></div>
<br /><br />
</body>
</html>