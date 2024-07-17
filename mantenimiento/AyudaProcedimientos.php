<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Ayuda Jerarquía de Procedimientos</title>
<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>   
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />
<?php
//http://localhost/WEBPLANTILLAPREMIUM2021/mantenimiento/AyudaProcedimientos.php

//session_start();
include_once('../conexion/conn_bbdd.php');
if (!isset($_REQUEST['pal_abra'])) {  
	 $_REQUEST['pal_abra'] = "";        
}

?>

<style type="text/css">
#FrameEdicion {
	display: none;	
	position:absolute;
	background-color: #FFFFE1;
	padding: 2%;
	width:80%;
	border:1px;
	  border-style:solid;
	  border-color:rgba(067,128,131,0.8);
	  background-size:cover;
	  -webkit-box-shadow: 4px 5px 2px 0px rgba(233,230,134,1);
      -moz-box-shadow: 4px 5px 2px 0px rgba(233,230,134,1);
      box-shadow: 4px 5px 2px 0px rgba(233,230,134,1);


	
}
  .FichaReduc { 	 
     float:left;
	  display:block;
	  width: 90%;
	  margin-top:0.5%;
	  margin-bottom:1%;
	  margin-left:5%;
	  padding:2px;
	  text-align:left;
  	  border:1px;
	  border-style:solid;
	  border-color:rgba(067,128,131,0.8);
	  background-size:cover;
	  -webkit-box-shadow: 4px 5px 2px 0px rgba(162,162,162,1);
      -moz-box-shadow: 4px 5px 2px 0px rgba(162,162,162,1);
      box-shadow: 4px 5px 2px 0px rgba(162,162,162,1);

  }
.FichaReducC {
	text-align:left;
	padding-left:1%;
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	width:10%;
	float:left;
	display:inline;
	margin-top:5px;
	margin-bottom:5px;
	font-size:0.9em;

	
}
.FichaReducF {
	text-align:left;
	padding-left:1%;
	background-color:#F90;
	font-family:Arial, Helvetica, sans-serif;
	color:#FFF;
	width:22%;
	float:left;
	display:inline;
	margin-top:5px;
	margin-bottom:5px;
	font-size:0.9em;
	cursor: pointer;
}
.FichaReducD {
	text-align:left;
	padding-left:1%;
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	width:65%;
	float:left;
	display:inline;
	margin-top:5px;
	margin-bottom:5px;
	font-size:0.8em;
    cursor: pointer;
}
.etiquetaReduc {
	text-align:left;
	padding-left:1%;
	background-color:#FBD606;
	font-family:Arial, Helvetica, sans-serif;
	color:#FFF;
	width:20%;
	float:left;
	display:inline;
	margin-top:10px;
	margin-bottom:3px;
	font-size:0.9em;
	
}
#mensaDescri {
	font-family:Arial, Helvetica, sans-serif;
	text-align:center;
}
#Busqueda {
	float:right;
	margin:0px;
	margin-right:5%;
	
}
#Busqueda input {
   margin: 0px;
   padding:0px;	
   vertical-align:top;
}
#Busqueda img {
   margin: 0px;
   padding:0px;	
   vertical-align:top;
}
</style>

<script>
CursorX = 0;
CursorY = 0;
openedWindow = null;
function coordenadas(event) {
 CursorX = event.clientX;
 CursorY = event.pageY;
}


function EditaFichaProcedimiento(id) {
           if (openedWindow != null) {
             openedWindow.close();
           }
		   URL = "ActividadProcedimiento.php?NumeroProc="+id;
	       openedWindow =  window.open(URL,"Ficha del Procedimiento","width=1200,height=700,scrollbars=YES,resizable=YES,LEFT=250,TOP=150") 	
	  
}

function EditaDescripcion(id) {
      ofset = 100;
	  d = document.getElementById('FrameEdicion');
      //d.style.left = CursorX+ofset+"px";
       d.style.left = ofset+"px";

      d.style.top = CursorY-25+"px";
	  d.style.display= "block";
	  contenido = document.getElementById('D'+id).innerHTML;
	  document.getElementById('Registro').value = id;
      document.getElementById('FrameEdicionCarpeta').innerHTML =  document.getElementById('C'+id).innerHTML;
      document.getElementById('FrameEdicionFichero').innerHTML =  document.getElementById('F'+id).innerHTML;
      document.getElementById('TEXTO').value = contenido; 
      document.getElementById('mensaDescri').innerHTML = "";
      
   
      
}
function CierraDescripcion() {
  document.getElementById('FrameEdicion').style.display = "none";

}

function GrabaDescripcion() {
 id = document.getElementById('Registro').value;
 document.getElementById('D'+id).innerHTML = document.getElementById('TEXTO').value;
			  var parametros = {
			  "id"     : id ,
			  "texto"  : $('#TEXTO').val()               };  
	$.ajax({
             data:  parametros,
             url:   '../php/AyudaProcedimientosUpdateDesc.php',
             type:  'post',
             beforeSend: function () {
                      $("#mensaDescri").html("Conectando con bbdd ...."); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#mensaDescri").html("<span class='rojo'>"+response+"</span>"); 
						return false;
					 } else {
						 $("#mensaDescri").html("Descripción grabada OK"); 
						   document.getElementById('FrameEdicion').style.display = "none";
						return true;
					 }
             },
			 error: function(){
                $("#mensaDescri").html("<span class='rojo'>Error grabando Descripción</span>");
				return false;
            }
        });	

}

function EjecutaBusqueda() {
    $url_formulario = "AyudaProcedimientos.php?pal_abra="+document.getElementById('pal_abra').value;
    location.href = $url_formulario;
}

</script>
</head>

<body onMouseMove="javascript:coordenadas(event);">

<?php
/*
      $resp = "<br>";
      $numero2 = count($_REQUEST);
      $tags2 = array_keys($_REQUEST); // obtiene los nombres de las varibles
      $valores2 = array_values($_REQUEST);// obtiene los valores de las varibles

     for($i=0;$i<$numero2;$i++){ 
         $resp .= $tags2[$i]."=".$valores2[$i]."\r\n"; 
      }
     echo $resp;
*/
?>
  
<div class="gris"> Ayuda Jerarquía de Procedimientos
<div id="Busqueda">
  <form id ="datos" name ="datos" method="POST">
    <input id ="pal_abra" type="text" size="50" maxlength="100"   value= "<?php  echo $_REQUEST['pal_abra']; ?>" placeholder="Palabras a buscar" />
    <img src="../imagenes/BotonLupa.gif" width="35" height="20" alt="Boton Lupa" onclick="EjecutaBusqueda()" />
     <img src="../imagenes/BotonExit.gif" width="35" height="20" alt="Boton Exit" onclick=" location.href = 'mantenimiento.php'" />

  </form>
</div>    
</div>



<?php 
if (strlen($_REQUEST['pal_abra']) == 0) {
	 PintaProcedimientos($conexion);
} else {
     DibujaBusqueda($_REQUEST['pal_abra'],$conexion);

}

 ?>






<br /><br /><br /><br />



<div id="FrameEdicion">
    <div class="AccesoApartado">Edición de la Descripción de un Procedimiento</div>
    <input type="hidden" id="Registro" value="" />
    <div class="etiquetaReduc">Carpeta</div>
    <div id ="FrameEdicionCarpeta" class="etiquetaDatos"></div>
    <div class="clear"></div>
     <div class="etiquetaReduc">Procedimiento</div>
    <div id ="FrameEdicionFichero" class="etiquetaDatos"></div>
    <div class="clear"></div>
     <div class="etiquetaReduc">Descripción</div>
    <div id ="FrameEdicionDescripcion" class="etiquetaDatos">
    <textarea name="TEXTO" id = "TEXTO" cols="90" rows="10"></textarea>
     <div class="clear"></div>
     <div class="pocoEspacio10"></div>
    <div class="centro">
        <input type="button" id="Button1" name="Salir" value="Salir" class ="ButtonGrisP" onclick="CierraDescripcion()" />
         &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" id="Button2" name="Grabar" value="Grabar"  class ="ButtonGrisP" onclick="GrabaDescripcion()" />
        <br /> <br />
     </div>  
    </div>
    <div class="clear"></div>
   <div id="mensaDescri"></div>



</div>
</body>
</html>

<?php
//..........................................................................................................
function NoZero($num) {
	return ($num == 0 ? "..." : $num);
}
function NoNull($num) {
	if (is_null($num)) {
	  return "....";
	}
	if (strlen($num) == 0) {
	  return "....";
	}

	return $num;
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
//..................................................................
function PintaProcedimientos($conexion){
  $FormatProcedimiento = "SELECT id 
                     FROM ctr_ficheros
                     ORDER BY orden, fichero";
  $queProcedimiento = $FormatProcedimiento;
  $resProcedimiento = mysqli_query($conexion, $queProcedimiento) or die(mysqli_error($conexion));  
  $totProcedimiento = mysqli_num_rows($resProcedimiento);    
  if ($totProcedimiento > 0){
	  while ($rowProcedimiento = mysqli_fetch_assoc($resProcedimiento)) {
		  $id = $rowProcedimiento['id'];
		  echo DibujaFichaReducida($id,$conexion);		  
      } 
  }
  mysqli_free_result($resProcedimiento);
}
//..................................................................
function DibujaFichaReducida($Pid,$conexion){
  $devolver = "";
  $FormatFReducida = "SELECT id, carpeta, fichero, descripcion
                        FROM ctr_ficheros
                       WHERE id = %d";
  $queFReducida =  sprintf($FormatFReducida, $Pid);
  $resFReducida = mysqli_query($conexion, $queFReducida) or die(mysqli_error($conexion));  
  $totFReducida = mysqli_num_rows($resFReducida);    
  if ($totFReducida > 0){
	  while ($rowFReducida = mysqli_fetch_assoc($resFReducida)) {
		  $id = $rowFReducida['id'];
		  $carpeta = $rowFReducida['carpeta'];
		  $fichero = $rowFReducida['fichero'];
		  $descripcion = $rowFReducida['descripcion'];  
          
          $devolver .= '<div class ="FichaReduc" >';
		  $devolver .= '<div id=C'.$id.' class = "FichaReducC">'.$carpeta."/</div>";
          $devolver .= '<div id=F'.$id.' class = "FichaReducF"  onclick="EditaFichaProcedimiento('.$id.')" >'.$fichero."</div>";
		  $devolver .= '<div id=D'.$id.' class = "FichaReducD"  onclick="EditaDescripcion('.$id.')" >'.NoNull($descripcion)."</div>";
          $devolver .= "</div>";
      } 
 }
 mysqli_free_result($resFReducida);
 return $devolver;
}
///////////////////////////////////////////////////////////////////////////////////////////////
function DibujaBusqueda($PALABRAS,$conexion) {

   $PALA_BRAS = strtolower($PALABRAS);
   $trozos=explode(" ",$PALABRAS); 
   $numero=count($trozos); 
   if ($numero == 1) { //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE   
      $FormatBusqueda = "SELECT DISTINCT id AS CLAU
                        FROM  ctr_ficheros
                         WHERE ( LOWER(fichero) like '%$PALA_BRAS%'
                            OR LOWER(descripcion) like '%$PALA_BRAS%')";
          
    } elseif ($numero > 1) { //busqueda de frases con mas de una palabra y un algoritmo especializado 
      $FormatBusqueda = "SELECT id  AS CLAU, MATCH (descripcion) AGAINST ( '$PALA_BRAS' ) AS Score 
                           FROM ctr_ficheros
                           WHERE (MATCH ( descripcion) AGAINST ( '$PALA_BRAS' )
                              OR MATCH ( fichero ) AGAINST ( '$PALA_BRAS' ))
                        ORDER BY Score DESC";
     } 
 
 
 
   $resGrupoSelect = mysqli_query($conexion, $FormatBusqueda) or die(mysqli_error($conexion));

   $totGrupoSelect = mysqli_num_rows($resGrupoSelect);

   if ($totGrupoSelect < 1) { mysqli_free_result($resGrupoSelect); 
    echo '<div class="FichaReduc">';
    echo  "No encontrado";                      
    echo '</div>'; 
   
   }
    while ($rowPalabra = mysqli_fetch_assoc($resGrupoSelect)) {	
	   $clave = $rowPalabra['CLAU'];
	   echo DibujaFichaReducida($clave, $conexion);	
	}
   mysqli_free_result($resGrupoSelect);
} // function DibujaBusqueda


?>