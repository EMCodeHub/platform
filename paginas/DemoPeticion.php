<!doctype html>
<html lang="es">
<?php
  session_start();
 include_once('../conexion/conn_bbdd.php');
 include_once('EstilosScripsNOIndex.php');
 

?>



<head>
<meta charset="utf-8">
<meta content="Eduardo Mediavilla Villodre" name="author"/>
<meta content="Demos CYPE en Ecuador:Calendario de encuentros Cursos prácticos, presentaciones, seminarios y jornadas técnicas" name="description" />
<meta content="CYPE, estructuras, calculo estructuras, encuentros, presentacionesCYPE" name="keywords"/>

<meta property="og:title" content="Aula CYPE en Ecuador:Calendario de encuentros Cursos prácticos, presentaciones, seminarios y jornadas técnicas" />
<meta property="og:type" content="article" />
<meta property="og:url" content=" http://www.medifestructuras.com/index.php" />
<!--<meta property="og:image" content=" http://www.jmptechnological.com/..imagenes/jmp_foto_600.png" />-->
<meta property="og:description" content="Usamos software de última generación para presupuestar en diferentes escenarios. Realizamos cursos presenciales y a distancia del software CYPE" />

<?php  
/* grupo d programas-------------------------------
PresupuestoPeticion.php
PresupuestoEnviaEmail.php
PresupuestoNuevoEmail.php
CartaPresupuestosCli.php
-----------------------------------------------------*/
include_once('EstilosScripsNOIndex.php');
?>

<title>Medif: Solicitud de demo CYPE</title>

     <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
     <script type="text/javascript" src="../php/DemoPeticion.js"></script>

</head>
<body>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TM8DJ4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TM8DJ4');</script>
<!-- End Google Tag Manager -->

<?php  
include_once('CabNoIndex.php');

$FormatMaestros = "SELECT A.id,  A. id_mailcomer,
B.id AS IDEMAIL, B.correoelectronico , B.nombre_interno , B.nombre_correo , B.es_smtp , 
B.es_pop3 , B.servidor , B.puerto , B.seguridad , B.requiere_auth , B.usuario , B.password , B.usa_logo , B.fichero_logo   
from cursos A, emailscomerciales B 
where A.id_mailcomer = B.id
and A.id = 2
";
$queMaestros = sprintf($FormatMaestros); 
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
$totMaestros = mysqli_num_rows($resMaestros);

if ($totMaestros == 1) {
       //....correo para el cliente...................................................................
          while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {	 
		    echo "<script>Nombre_correo = '".$rowRegistros['nombre_correo']."';\n";
			echo "emisorcorreo = '".$rowRegistros['correoelectronico']."';\n";	
			echo "</script>";
		  }
}
?>

<section class="contenedor">
        <h1 class ="tituloApartado">Demos software CYPE</h1>
 
 
  <div class="ficha">
   <div class="ficha_fila">
      <div  class = "envoltorioDemo" >  
	   <ul class = "listaDemo" >
       <li class = "itemDemo">
       <img src= "../imagenes/Demo_Cype_CAD.jpg" alt="CypeCAD" ><span>CypeCAD</span>
       </li>
       <li class = "itemDemo">
       <img src= "../imagenes/Demo_Cype_3D.jpg" alt="Cype 3D" ><span>Cype 3D</span>
       </li>
       <li class = "itemDemo">
       <img src= "../imagenes/Demo_Cype_connect.jpg" alt="Cype Connect" ><span>Cype Connect</span>
       </li>
       <li class = "itemDemo">
       <img src= "../imagenes/Demo_Cype_Generador_Porticos.jpg" ><span>Generador de pórticos</span>
       </li>
      </ul>
     </div>
     <div class="clear_boot"></div>
     <center>
 	    <p class="ApartadoAzul">Utilice este formulario para solicitarnos una DEMO de software CYPE</p>
     </center>  

   </div>

     <div class="ficha_fila">
        <div id="correoPresupuesto">
        <p class="pide_panPreTit">Solicitud DEMO software CYPE</p>
        <form  class="formulario">
	    
        <div class="mitad">
	     <br>
 	     <label class="pide_panPre">Nombre </label><input id = "nombre" type="text" name="nombre" size="35" maxlength="30" onKeypress='return txNombres()' value= "<?php if (isset( $_REQUEST['nombre'])) { echo $_REQUEST['nombre']; }?>" required> 
	     <br> 
      	 <label class="pide_panPre">Apellidos </label><input id = "apellidos" type="text" name="apellidos" size="35" maxlength="100" onKeypress='return txNombres()'  value= "<?php if (isset( $_REQUEST['apellidos'])) { echo $_REQUEST['apellidos']; }?>" required> 
	     <br> 

	     <label class="pide_panPre">Email </label> <input id = "email" type="text" name="email" size="35" maxlength="99" value= "<?php if (isset( $_REQUEST['email'])) { echo $_REQUEST['email']; }?>" required > 
	     <br> 
	     <label class="pide_panPre">Teléfono</label> <input id = "telefono" type="text" name="telefono" size="35" maxlength="30" onKeypress='return solonumeros()' value= "<?php if (isset( $_REQUEST['telefono'])) { echo $_REQUEST['telefono']; }?>" >
	     <br> 
	     <label class="pide_panPre">Ciudad</label> <input id = "ciudad" type="text" name="ciudad" size="35" maxlength="30"  onKeypress='return txNombres()' value= "<?php if (isset( $_REQUEST['ciudad'])) { echo $_REQUEST['ciudad']; }?>" >
         <br>  
         	     <label class="pide_panPre">Programa CYPE</label> 
    <?php
	  $txtSelect ="";
      $FormatImagen = "select id, esta_activo, descripcion from programasdemos  where esta_activo > 0 order by descripcion ";
      $queImagen = sprintf($FormatImagen, $campo, $fichero); 
      $resImagen = mysqli_query($conexion, $queImagen) or die(mysqli_error($conexion));
      $totImagen = mysqli_num_rows($resImagen);	
      if ($totImagen> 0) {  //.....Registro de conexión
         $txtSelect = $txtSelect.'<select  id = "programa" name = "programa" >';                  
         while ($rowImagen = mysqli_fetch_assoc($resImagen)) {
	      if ($rowImagen['descripcion'] == $_REQUEST['programa']) {
			     $selected = " selected";
		    } else {
			     $selected = "";
	      }			    
		    $txtSelect = $txtSelect. '<option value = "'.$rowImagen['descripcion'].'" '.$selected.'>'.$rowImagen['descripcion'];
         }
	   $txtSelect = $txtSelect.'</select> ';
     }
     mysqli_free_result($resImagen);
     echo $txtSelect;
	?>             
                 
                 
                 
                 
         <br>  

         <div class="clear"></div>
         <img src="captcha.php" border="0" /><input type="text" id = "code" name="code" maxlength="6" />
            
	 </div>
	
	 <div class="mitad">
 
         <label class="pide_panPre"> Observaciones:</label>
         <br>
         <textarea id = "comentarios" class="areaTexto" cols="40" rows="10" name="comentarios"  ><?php if (isset( $_REQUEST['comentarios'])) { echo $_REQUEST['comentarios']; }?></textarea>
         <div class="clear"></div>
         <div align="center">
               <div id = "marcoMensaje"></div>
        </div>
        <div class="clear"></div>
        <div id = "botones" >
           <center>
           <input  type="Button"  id= "Button1" name="Button"  value="Enviar">
           <input  type="Button" value="Borrar" onClick="borraCampos()"> 
           </center>
        </div>

        
	 </div> 
     <div class="clear"></div>
    
     <div align="center"><div id = "marcoNombreFichero"></div></div>
     
 <div id = "recogeMensajes"></div>
</form> 
           
      </div>         

           </div>  

 </div><!-- end .ficha -->
</section><!-- end .contenedor -->


<div class = "Aviso"></div>

</body>





</html>
