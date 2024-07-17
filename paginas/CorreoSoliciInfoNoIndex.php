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
} ?>	


   <div id = "CorreoSoliciInfo" >    
   
   <div id="CorreoContactoSoliciInfo" >
        <!--<p id = 'TituloCorreo' class="pide_panPreTit">Haz tu consulta</p>-->
        <form  class="formulario">
        <div class="mitad">
	     <br>
 	     <label style="color: white;" class="pide_panPre">Nombre </label><input id = "SOnombre" type="text" name="nombre" size="35" maxlength="30" onKeypress='return SOtxNombres()' value= "<?php echo $nombre ?>" required /> 
	     <br>  <br> 
      	 <label style="color: white;" class="pide_panPre">Apellidos </label><input id = "SOapellidos" type="text" name="apellidos" size="35" maxlength="100" onKeypress='return SOtxNombres()'  value= "<?php echo $apellidos ?>" required /> 
	     <br>  <br> 

	     <label style="color: white;" class="pide_panPre">Email </label> <input id = "SOemail" type="text" name="email" size="35" maxlength="99" value= "<?php echo $email ?>" required /> 
	     <br>  <br> 
	     <label style="color: white;" class="pide_panPre">Teléfono</label> <input id = "SOtelefono" type="text" name="telefono" size="35" maxlength="30" onKeypress='return SOsolonumeros()' value= "<?php echo $telefono ?>" />
	     <br>  <br> 


         <div class="clear"></div>
         <div class="PocoEspacio10"></div>
         <img src="captcha.php" border="0" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="text" id = "SOcode" name="code" maxlength="6" />
            
	 </div>
	
	 <div class="mitad">
 
         <label style="color: white;" class="pide_panPre">Haz tu consulta:</label>
         <br>
         <textarea style="border-radius:20px;" id = "SOcomentarios" class="areaTexto" cols="40" rows="10" name="comentarios" style="text-align:left"></textarea>
         <div class="clear"></div>
         <div align="center">
               <div id = "SOmarcoMensaje"></div>
        </div>
        <div class="clear"></div>
        <div id = "SObotones">
           <center>

<br>
<br>
<br>

            <input id= "SOButton1" name="SOButton1" type="button" class ="ButtonGrisP" value ="Enviar" />
               
           <!--&nbsp;&nbsp;&nbsp;&nbsp;
           
           &nbsp;&nbsp;&nbsp;&nbsp;
           <input id= "SOButton2" name="SOButton2" type="button" class ="btnVerPagina" value ="&nbsp;&nbsp;&nbsp;&nbsp;Salir&nbsp;&nbsp;&nbsp;&nbsp;" />-->
               
           </center>
        </div>
	 </div> 
     <div class="clear"></div>
    
     <div align="center"><div id = "SOmarcoMensaje"></div></div>
 <div id = "SOrecogeMensajes"></div>
 <br />
</form> 
</div>
</div>
