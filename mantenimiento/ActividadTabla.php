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
.arial1 {
    font-family:Arial, Helvetica, sans-serif;
	font-size:0.8em;
	padding-left: 5px;
	padding-right:5px;

}
.arialn {
    font-family:Arial, Helvetica, sans-serif;
	font-size:0.8em;
	font-weight:bold;
	padding-left: 5px;
	padding-right: 5px;
	
}
.CabeceraTabla{
	font-family:Arial, Helvetica, sans-serif;
	font-size:0.8em;
	font-weight:bold;
	padding-left: 5px;
	padding-right: 5px;
	background-color:orange;

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
	  margin-left:10px;
	  width:75%;
	  font-size:0.8em;
}
.rayaFicTit {
    height:2px;
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
.ButtonSalir {
	box-shadow: 1px 2px 0px 0px #899599;
	background:linear-gradient(to bottom, #ededed 5%, #bab1ba 100%);
	background-color:#ededed;
	border-radius:5px;
	border:1px solid #d6bcd6;
	display:inline-block;
	cursor:pointer;
	color:#3a8a9e;
	font-family:Arial;
	font-size:12px;
	padding:0px 9px;
	text-decoration:none;
	text-shadow:0px 1px 0px #e1e2ed;
}

</style>
<script>
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
function DescripcionTabla($nombre, $conexion) {
	$devolver = "";
	$FormatTmp = "SELECT descripcion
                    FROM ctr_tablas
                   WHERE tabla_nombre = '%s'";
    $queTmp = sprintf($FormatTmp, $nombre);	
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
//...........................................................................................
function PintaTabla($nombre, $conexion) {

//Field, Type, Key, Extra, Comment  
    $devolver = '<TABLE border =1" align ="center" width = "95%">';
         	    $devolver .= '<TR>';
            $devolver .= '<TD  class="CabeceraTabla">'.'Field'.'</TD>';
            $devolver .= '<TD class="CabeceraTabla">'.'Type'.'</TD>';
            $devolver .= '<TD class="CabeceraTabla">'.'Key'.'</TD>';
            $devolver .= '<TD class="CabeceraTabla">'.'Extra'.'</TD>';
            $devolver .= '<TD  class="CabeceraTabla" widt = "80%">'.'Comment'.'</TD>';
            
     	    $devolver .= '</TR>';

	$FormatTmp = "SHOW FULL COLUMNS FROM %s";
    $queTmp = sprintf($FormatTmp, $nombre);	
    $resTmp = mysqli_query($conexion, $queTmp) or die(mysqli_error($conexion)); 
    $totTmp = mysqli_num_rows($resTmp);     
     if ($totTmp > 0){
     	 while ($rowTmp = mysqli_fetch_assoc($resTmp)) {
     	    $devolver .= '<TR>';
            $devolver .= '<TD class = "arialn">'.$rowTmp['Field'].'</TD>';
            $devolver .= '<TD  class="arial1">'.$rowTmp['Type'].'</TD>';
            $devolver .= '<TD  class="arial1">'.$rowTmp['Key'].'</TD>';
            $devolver .= '<TD  class="arial1">'.$rowTmp['Extra'].'</TD>';
            $devolver .= '<TD  class="arial1">'.$rowTmp['Comment'].'</TD>';
            
     	    $devolver .= '</TR>';
     	 }   
     } 
     $devolver .= '</TABLE>';
     mysqli_free_result($resTmp);	
	 return $devolver;
}
?>
    
    
    
<div class="gris"> Ficha de la tabla: <?php echo $_REQUEST['NombreTabla'] ?></div>
<div class="C90">
    <div class="etiqueta">Descripción:</div>
    <div class="etiquetaDatos"> <?php echo  DescripcionTabla($_REQUEST['NombreTabla'], $conexion) ?></div>
    <div class="clear"></div>
</div>
<br />
<?php echo PintaTabla($_REQUEST['NombreTabla'], $conexion); ?>
<br />
<div class="C90"><div class="derecha">
<input type="button" name="&nbsp;salir&nbsp;" value="Salir" class ="ButtonSalir" onclick="CerrarVentana()" />
</div></div>
<br /><br />
</body>
</html>