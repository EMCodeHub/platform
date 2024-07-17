<!DOCTYPE html>
<?php
/* grupo d programas-------------------------------
PresupuestoPeticion.php
PresupuestoEnviaEmail.php
PresupuestoNuevoEmail.php
CartaPresupuestosCli.php
-----------------------------------------------------*/
 session_start();
 include '../conexion/conn_bbdd.php';
 include_once('NewWebEstilosNOIndex.php');
 include_once('../php/ValidaLoginScript.php');
 include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
 $DatosWeb =   new ParametrosClass($conexion);

?>

<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,500,800" rel="stylesheet">    

    <script src="../php/PresupuestoPeticion.js"></script>

 <?php include_once('PaginaCabecera.php'); ?>     
    
<title>Petición de presupuesto</title>

<script>
     Nombre_correo = '<?php echo $DatosWeb->GetTrimValor('NombrePrincipal') ?>';
     emisorcorreo = '<?php echo $DatosWeb->GetTrimValor('CorreoPrincipal') ?>';
</script>  
    
</head>


<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->



<?php
include_once('MenuNOIndexSinLogin.php');   
?>
<div class="PocoEspacio" ></div>
<div class="clear"></div>
<section class="contenedor">
<br>
        <h1 class ="tituloApartado">Cálculo de estructuras - Planos de ejecución</h1>
 <br>
 


  <div class="ficha">

  <div class= "ficha_fila_imagen">
  <img src="../imagenes/PresupuestosPeticion.jpg"  alt="Workflow envios">
  </div>
 
  
<div class="ficha_fila">
  <div class="centro">
 		  <p class="ApartadoAzul">Utilice este formulario para solicitarnos un presupuesto sin compromiso</p>
         
       <p class="Adjuntar">   Adjunte el fichero DWG de su proyecto, es preferible que lo comprima antes y nos envíe un fichero ZIP
         <br><br>
        O, si lo prefiere, puede escribir a  <span class ="textoAzul"><?php echo $DatosWeb->GetTrimValor('CorreoPrincipal') ?> </span>adjuntando su fichero de proyecto</p>
  
      </div>    
   </div>

     <div class="ficha_fila">
        <div id="correoPresupuesto">
        <p class="pide_panPreTit">Solicitud de presupuesto</p>
        <form enctype="multipart/form-data" class="formulario">
	    
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
         <br> <br> <br> 
         
<label class="pide_panPre">Adjuntar fichero</label>
      <input type="checkbox" name="adjuntarFichero" id="adjuntarFichero" value="1" checked>
          
<br>
<div id = "marcoEligeFichero">
               <br>
               <label class="pide_panPre">Fichero DWG / ZIP</label>   
               <input type="file" id="userfile" name="userfile"  >
 </div>
 
 <br><br>
         <div class="clear"></div>
         <img src="captcha.php" alt="captcha"  /> &nbsp;&nbsp;&nbsp;<input type="text" id = "code" name="code" maxlength="6" />
            
</div>
	
	 <div class="mitad">
 
         <label class="pide_panPre"> Observaciones:</label>
         <br>
         <textarea id = "comentarios" class="areaTexto" cols="40" rows="10" name="comentarios"  ><?php if (isset( $_REQUEST['comentarios'])) { echo $_REQUEST['comentarios']; }?></textarea>
         <div class="clear"></div>
         <div class="centro">
               <div id = "marcoMensaje"></div>
        </div>
        <div class="clear"></div>
        <div id = "botones" >
           <div class="centro">
           <input  type="Button"  class= "ButtonGrisP" id= "Button1" name="Button"  value="Enviar">
           <input  type="Button"  class= "ButtonGrisP" value="Borrar" onClick="borraCampos()"> 
           </div>
        </div>

        
	 </div> 
     <div class="clear"></div>
    
     <div class="centro"><div id = "marcoNombreFichero"></div></div>
     
 <div id = "recogeMensajes"></div>
</form> 
           
      </div>    
      
      

           </div>  

 </div><!-- end .ficha -->



</section><!-- end .contenedor -->

<div class="centro90"><?php include_once('PaginaPieNOIndex.php'); ?></div>
<div class = "Aviso"></div>

</body>





</html>
