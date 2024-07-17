<?php
// si no está conectado no enseñamos el correo, sencillamente le decimos que se conecte
/*include_once('conexion/conn_bbdd.php');*/
$nombre    = "";
$apellidos = "";
$email     = ""; 
$telefono  = "";
if ($_SESSION['NumeroUsuario'] != 0) {
	
   $FormatMaestros = "SELECT id, email, nombre, apellidos FROM vtalumnos  where  id = %d";
   $queMaestros = sprintf($FormatMaestros, $_SESSION['NumeroUsuario']); 
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);
   if ($totMaestros > 0) {
    while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {		
		$nombre = $rowRegistros['nombre'];
		$apellidos = $rowRegistros['apellidos'];
		$email = $rowRegistros['email'];
		$nombre = $rowRegistros['nombre'];
	}
   }
	mysqli_free_result($resMaestros);  
?>	


   <div id = "CorreoDevoluciones" >    
   
   <div id="correoContactoDevol" >
        <p id = 'TituloCorreo' class="pide_panPreTit">Solicitud devolución de importe</p>
        <form  class="formulario">
        <div class="mitad">
	     <br>
 	     <label class="pide_panPre">Nombre </label><input id = "nombre" type="text" name="nombre" size="35" maxlength="30" onKeypress='return CDtxNombres()' value= "<?php echo $nombre ?>" required /> 
	     <br> 
      	 <label class="pide_panPre">Apellidos </label><input id = "apellidos" type="text" name="apellidos" size="35" maxlength="100" onKeypress='return CDtxNombres()'  value= "<?php echo $apellidos ?>" required /> 
	     <br> 

	     <label class="pide_panPre">Email </label> <input id = "email" type="text" name="email" size="35" maxlength="99" value= "<?php echo $email ?>" required /> 
	     <br> 
	     <label class="pide_panPre">Teléfono</label> <input id = "telefono" type="text" name="telefono" size="35" maxlength="30" onKeypress='return CDsolonumeros()' value= "<?php echo $telefono ?>" />
	     <br> 


         <div class="clear"></div>
         <img src="captcha.php" border="0" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="text" id = "code" name="code" maxlength="6" />
            
	 </div>
	
	 <div class="mitad">
 
         <label class="pide_panPre"> Justifica el motivo:</label>
         <br>
         <textarea id = "comentarios" class="areaTexto" cols="40" rows="10" name="comentarios" style="text-align:left"></textarea>
         <div class="clear"></div>
         <div align="center">
               <div id = "marcoMensaje"></div>
        </div>
        <div class="clear"></div>
        <div id = "CDbotones">
           <center>
            <input id= "Button1" name="Button1" type="button" class ="ButtonGrisP" value ="&nbsp;&nbsp;&nbsp;&nbsp;Enviar&nbsp;&nbsp;&nbsp;&nbsp;" />
           &nbsp;&nbsp;&nbsp;&nbsp;
           
           &nbsp;&nbsp;&nbsp;&nbsp;
           <input id= "Button2" name="Button2" type="button" class ="ButtonGrisP" value ="&nbsp;&nbsp;&nbsp;&nbsp;Salir&nbsp;&nbsp;&nbsp;&nbsp;" />
           </center>
        </div>
	 </div> 
     <div class="clear"></div>
    
     <div align="center"><div id = "CDmarcoMensaje"></div></div>
 <div id = "CDrecogeMensajes"></div>
 <br />
</form> 
</div>
</div>
<?php
} else {
?>	

<div id = "CorreoDevoluciones" >  
<div id="correoDevolSinConexion" >
<form>
<input id = "nombre" type="hidden"   value= ""> 
<input id = "apellidos" type="hidden"   value= ""> 
<input id = "email" type="hidden"   value= ""> 
<input id = "telefono" type="hidden"   value= ""> 
<input id = "code" type="hidden"   value= ""> 
<textarea id = "comentarios" style="display:none"> </textarea>

</form>

    <p >Haz LOGIN para cursar tu solicitud de reclamación y te atendemos en breve</p>
    <input id= "Button2" name="Button2" type="button" class ="ButtonGrisP" value ="Salir" />
</div>
</div>



<?php
} 
?>	