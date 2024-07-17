<?php
$ICorreo       = "";    
$ITelefono     = "";
$IUsuSkype     = "";
$INombre       = "";
$IApellidos    = "";
$ICiudad       = "";
$IPais         = "";
if ($_SESSION['NumeroUsuario'] > 0) {
  $FormatAlumnos = "SELECT  email, telefono, skype_usuario, nombre, apellidos, ciudad, pais  
                      FROM  vtalumnos 
                      WHERE id = %d";
  $queAlumnos = sprintf($FormatAlumnos,$_SESSION['NumeroUsuario']);
  $resAlumnos = mysqli_query($conexion, $queAlumnos) or die(mysqli_error($conexion));  
  $totAlumnos = mysqli_num_rows($resAlumnos);  
  if ($totAlumnos > 0){
  	while ($rowAlumnos = mysqli_fetch_assoc($resAlumnos)) {
      $ICorreo       = $rowAlumnos['email'];    
      $ITelefono     = $rowAlumnos['telefono'];
      $IUsuSkype     = $rowAlumnos['skype_usuario'];
      $INombre       = $rowAlumnos['nombre'];
      $IApellidos    = $rowAlumnos['apellidos'];
      $ICiudad       = $rowAlumnos['ciudad'];
      $IPais         = $rowAlumnos['pais'];
  	}
  }
  mysqli_free_result($resAlumnos); 
} 
?> 
<div  id="AsesoriaForm1">
     <div class="centro">
         <b>Reserva de Videoconferencia</b>
    </div>
</div>
<div  id="AsesoriaForm2">
    <div id="diaSesion"></div> 
    <input readonly id="SesDia" class="inputRedondo" name="SesDia" size=10 type="text" />  
    Hora inicio:
           <select id="SesHora" >
               <option value="0">--</option>
           </select>
          <span class="textoAzul">Duración aproximada de 3 horas</span>  
</div>
<div  id="AsesoriaForm3">
     <div class="derecha">Informe la hora de inicio &nbsp; &nbsp;
           <input  type="Button"  class="myButton" id= "SesBotonCambioDia" name="SesBotonCambioDia"  value="Cambiar Día">
    </div>
</div>
<div  id="AsesoriaForm4">
    <div class="Sesion100">
        <div class="SesionI"></div>
        <div class="SesionD"><span class="azulGenerico">Los datos que nos facilites son para uso interno, no se ceden a terceros</span></div>
        <div class="clear"></div>
     </div>
    <div class="Sesion100">
        <div class="SesionI">E-mail</div>
        <div class="SesionD"><input id="SesCorreo" class="inputRedondo" name="SesCorreo" type="text" size=40 type="text" placeholder="¿Cuál es tu Correo Electrónico?" value = "<?php echo $ICorreo ?>"/></div>
        <div class="clear"></div>
     </div>
     <div class="Sesion100">
        <div class="SesionI">Teléfono</div>
        <div class="SesionD"><input id="SesTelefono" class="inputRedondo" name="SesTelefono" type="text" size=20 type="text" placeholder="Para coordinar mejor la sesión" value = "<?php echo $ITelefono ?>"/></div>
        <div class="clear"></div>
     </div>
    <div class="Sesion100">
        <div class="SesionI">Usuario Skype</div>
        <div class="SesionD"><input id="SesUsuSkype" class="inputRedondo" name="SesUsuSkype" type="text" size=40 type="text" placeholder="¿Cuál es tu usuario Skype?" value = "<?php echo $IUsuSkype ?>"/></div>
        <div class="clear"></div>
     </div>

      <div class="Sesion100">
        <div class="SesionI">Nombre</div>
        <div class="SesionD"><input id="SesNombre" class="inputRedondo" name="SesNombre" type="text" size=40 type="text" placeholder="¿Cuál es tu Nombre?" value = "<?php echo $INombre ?>"/></div>
        <div class="clear"></div>
     </div>
    <div class="Sesion100">
        <div class="SesionI">Apellidos</div>
        <div class="SesionD"><input id="SesApellidos" class="inputRedondo" name="SesApellidos" type="text" size=50 type="text" placeholder="¿Cuáles son tus Apellidos?" value = "<?php echo $IApellidos ?>"/></div>
        <div class="clear"></div>
     </div>
    <div class="Sesion100">
        <div class="SesionI">Ciudad</div>
        <div class="SesionD"><input id="SesCiudad" class="inputRedondo" name="SesCiudad" type="text" size=30 type="text" placeholder="¿Cuál es tu Ciudad?" value = "<?php echo $ICiudad ?>"/> </div>
        <div class="clear"></div>
     </div>
    <div class="Sesion100">
        <div class="SesionI">País</div>
        <div class="SesionD"><input id="SesPais" class="inputRedondo" name="SesPais" type="text" size=30 type="text" placeholder="¿Cuál es tu País?" value = "<?php echo $IPais ?>"/> </div>
        <div class="clear"></div>
     </div>
     <div class="Sesion100">
        <div class="SesionI">Tema a tratar</div>
        <div class="SesionD">
            <textarea name="SesObservaciones" id = "SesObservaciones" cols="50" rows="8"></textarea>
        </div>
        <div class="clear"></div>
     </div>

     <div class="Sesion100">
        <div class="SesionI"></div>
        <div class="SesionD" id="SesMensaje">&nbsp;</div>
        <div class="clear"></div>
     </div>
    
        
     <div class="Sesion100" id="SesBotones">
         <div class="derecha">
           <input  type="Button"  class="myButton" id= "SesBotonAceptar" name="SesBotonAceptar"  value="Enviar">
             &nbsp;&nbsp;&nbsp;
           <input  type="Button"  class="myButton" id= "SesBotonSalir" name="SesBotonSalir"  value="Salir">
         </div>
        <div class="clear"></div>
     </div>
</div>
