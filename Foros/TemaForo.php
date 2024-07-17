<?php
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);

$tituloPagina = "";
$FormatTemas = "SELECT tema
                  FROM forostemas
                 WHERE id = %d";
$queTemas = sprintf($FormatTemas,$_REQUEST['id']);
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion));  
$totTemas = mysqli_num_rows($resTemas);     
if ($totTemas > 0){
	while ($rowTemas = mysqli_fetch_assoc($resTemas)) {
		$tituloPagina = $rowTemas['tema']; 
	}
}
mysqli_free_result($resTemas); 
?>
<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head> 
<title>Foro CYPE - <?php echo $tituloPagina?></title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<?php include_once('../paginas/PaginaCabecera.php'); ?>   
<script>
 CursorX = 0;
 CursorY = 0;  
function CierraAcceder(modo) {
   
	var j=document.getElementById("Acceder");
	if (modo == 0){
		j.style.display="none";
	} else {
         CierraRegistrarse(0);
		j.style.display="block";
	}
	
}
function CierraRegistrarse(modo) {
	
	var j=document.getElementById("Registrarse");
	if (modo == 0){
		j.style.display="none";
	} else {
        CierraAcceder(0);
		j.style.display="block";
	}
}

</script>
 
<script  src="../php/Acceder.js"></script>
<script  src="../php/VideotutorialesLogin.js"></script>
<script src="../php/widgEditor.js"></script> 
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes"/>
<?php


include_once('../php/SesionesCookies.php'); //Inicio de sesión y asignación de sus variables
include_once('../paginas/NewWebEstilosForos.php')    
//$CursoEnPromocion  = 9;   //....... cambiar si cambia el curso de la landing, el curso gratis

?>
</head>
<body onMouseMove="javascript:coordenadas(event);">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
include_once('../php/IndexScript.php');
include_once('../php/ForosScript.php');
include_once('../paginas/MenuForos.php'); 
include_once('../paginas/PaginaCursoPHP01_2.php');
?>

 <br> <br> <br> <br>


    <div id="CuestionPantalla">
		<div class="centro"><b>NUEVA CUESTIÓN</b></div>

		<form id="formcuestion" name = "formcuestion" action="../php/ForoCuestionAlta.php" >
            <input id = "num_tema"  name="num_tema"  type="hidden" /> 
            <fieldset>
                <label for="descri_cuestion">
					Ponga un título a su consulta o tema a tratar:
				</label>
                <textarea id = "descri_cuestion" name = "descri_cuestion" class="widgEditor nothing" maxlength=500 placeholder="Defina aquí el ENCABEZAMIENTO de su Cuestión"></textarea>
            </fieldset>
			<fieldset>
				<label for="noise">
					Desarolla la consulta o tema a tratar:
				</label>
				<textarea id="noise" name="noise" class="widgEditor nothing" placeholder="Escriba aquí su Mensaje ...."></textarea>
			</fieldset>
			
			<fieldset class="submit">
				<input type="submit" value="Enviar al Foro" />
                <input type="button" value="Salir" onclick="SalirCuestion()"/>
			</fieldset>
		</form>	
		
	</div>
    
<section class="EnvoltorioForoClase">    
   <?php 
      ActualizaVisitas($_REQUEST['id'],$conexion);
      echo PintaTemaById($_REQUEST['id'],$conexion); 
    ?> 
</section>  
<?php 
    include_once('TemaPie.php'); 
    include_once('ForoPantallas.php'); 
?> 
    <div class = "Aviso"></div>
 <?php 
function ActualizaVisitas($id,$conexion){
mysqli_free_result($resTemas);  
$FormatTemas = "UPDATE forostemas 
                   set veces_visitado = veces_visitado +1 
                 WHERE id= %d";
$queTemas = sprintf($FormatTemas,$id);
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion)); 
mysqli_free_result($resTemas);  
} 
?>    
<?php include_once('../paginas/PaginaCursoPHP01_4.php'); ?>
</body>
</html>
