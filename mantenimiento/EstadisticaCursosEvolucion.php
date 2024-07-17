<?php
include_once("../php/EstadisticaCursosEvolucionScript.php");
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
include_once('../conexion/conn_bbdd.php');

session_start();

if ($_SESSION['es_admin'] != 1) {
     header("Location: ../index.php");
     exit;
}
if (!isset($_REQUEST['volver_a'])) {
	$_REQUEST['volver_a'] = "mantenimiento.php";
}
//......................................................
if (!isset($_REQUEST['Anyo_ini'])) {
	$_REQUEST['Anyo_ini'] = date("Y")-1; 
}
if (!isset($_REQUEST['Anyo_fin'])) {
	$_REQUEST['Anyo_fin'] = date("Y");
}
if (!isset($_REQUEST['ORDEN'])) {
	$_REQUEST['ORDEN'] = "A-C";
}
//.......................................................
$DatosWeb =   new ParametrosClass($conexion);
$cursoGratis = $DatosWeb->GetTrimValor('curso_en_promocion');
?>
<!doctype html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Estadística Evolución Cursos</title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />
<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
       <SCRIPT LANGUAGE="javaScript"> 
        SalidaCSV = '../CSVFicheros/EvolucionFinalizacionCursos.csv';
	   function Procesar() {
		   ini =  document.getElementById('Anyo_ini').value;
		   fin =  document.getElementById('Anyo_fin').value; 
		   if (fin < ini) {
			alert("Año FIN menor que INICIO ---->Vuelva a definir los años");
			return;   
		   }
		   document.datos.action="EstadisticaCursosEvolucion.php";
		   document.datos.submit();
	   }
          
	   function EnsenyaRecalculo() {
           document.getElementById('GenerarCSV').style.display = "none";
		   document.getElementById('Recalculo').style.display = "inline"; 
           document.getElementById('resultado2').style.display = "none"; 
           document.getElementById("SalidaCSV").style.display = "none";
	   }
          
       function CreaFicheroCSV() {
           document.getElementById("GenerarCSV").style.display = "none";
		   document.getElementById("SalidaCSV").style.display = "block";
           GeneraSalidaCSV(SalidaCSV);
	   }    
       //.............................................................................
        function GeneraSalidaCSV(FicheroSalida) {
           $("#mensaCSV").html("");  
          var parametros = {
			  "salida"     : FicheroSalida 
              };  
		$.ajax({
             data:  parametros,
             url:   '../php/GenerarFicheroCSVEvolucionCursos.php',
             type:  'post',
             beforeSend: function () {
                 $("#mensaCSV").html("<span class='azul'>Generando Fichero ....</span>"); 
             },
             success:  function (response) {
                if (response != "OK") {
                    $("#mensaCSV").html("<span class='rojo'>El Fichero NO se ha grabado correctamente</span>")
                } else {
                    $("#mensaCSV").html("<span class='azul'>Fichero generado OK</span>"); 
                }
				 $('#botonSalidaCSV').css("display","inline");
             },
			 error: function(jqXHR, textStatus, errorThrown){
                $("#mensaCSV").html("<span class='rojo'>Error Generando Fichero</span>"+ " " + errorThrown);
				$('#botonSalidaCSV').css("display","inline");
				return false;
            }
        });	
	
              
        }
     
    </SCRIPT>
   
    
    
    
    
</head>
<body>
<br>

<div class="TituloEstadistica">Evolución Finalización Cursos</div>
<br />
<div id = "cabeceraEstadistica"> 

<form id = "datos" name= "datos"  method="post">  <!--action="SubgruposFicha.php"-->
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='mantenimiento.php'" /> &nbsp; &nbsp; &nbsp; &nbsp;
&nbsp; &nbsp;Año Inicio  <input id = "Anyo_ini" name="Anyo_ini" size="4"  maxlength="4"  onchange='javascript:EnsenyaRecalculo()' value="<?php $_REQUEST['Anyo_ini'] ?>" />
&nbsp; &nbsp;
    Año Final  <input id = "Anyo_fin" name="Anyo_fin" size="4"  maxlength="4"  onchange='javascript:EnsenyaRecalculo()'  value="<?php $_REQUEST['Anyo_fin'] ?>" />
&nbsp; &nbsp; &nbsp; &nbsp;
Orden:  
<select  id = ORDEN name="ORDEN" onchange='javascript:EnsenyaRecalculo()'>
<option value = "A-C" >Año + Curso
<option value = "C-A" >Curso + Año
</select> 
    &nbsp; &nbsp;
<div id="GenerarCSV"><input name="CreaCSV" type="button" value ="Generar CSV" onclick = "CreaFicheroCSV()" /></div>
<div id="Recalculo"><input name="Precesar" type="button" value ="Recalcular" onclick = "Procesar()" /> </div>
</form>
</div>
<div class="clear"></div>
<script>
document.getElementById('Anyo_ini').value = <?php echo '"'.$_REQUEST['Anyo_ini'].'"';?>;
document.getElementById('Anyo_fin').value = <?php echo '"'.$_REQUEST['Anyo_fin'].'"';?>;
document.getElementById('ORDEN').value = <?php echo '"'.$_REQUEST['ORDEN'].'"';?>;
</script>


<div class="envoltorioEstadistica">
   <div class="GratisCabeceraG">Análisis Evolución Cursos</div>
    <div class="clear"></div>
    <div id="SalidaCSV">
         <p>Los datos SELECCIONADOS han sido guardados en la tabla vtestadiscursos</p>
         <p>Los grabamos en formato CSV en el fichero: ../CSVFicheros/EvolucionFinalizacionCursos.CSV</p>
          <div id="mensaCSV"></div>
         <div id="botonSalidaCSV"><input name="Salir" type="button" value ="Salir" onclick = 'document.getElementById("SalidaCSV").style.display = "none";' /> </div>
        
    </div>
    <div class="clear"></div>
      <div id="resultado2">
       <?php echo PintaSeleccionados($_REQUEST['Anyo_ini'],$_REQUEST['Anyo_fin'],$_REQUEST['ORDEN'],$cursoGratis,$conexion) ?>
      </div>  
</div>
<script>
    document.getElementById("GenerarCSV").style.display = "inline";
</script>


<br>
<br>


</body>
</html>
<?php mysqli_close($conexion); ?>
