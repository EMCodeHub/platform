<div id="DivDescBienve"> 
<?php if ($_SESSION['NumeroUsuario'] != 0) { ?>
<div id="DivBienvenida"> 
  Bienvenido/a: <b><?php  echo EmailAlumno($_SESSION['NumeroUsuario'],$conexion);?></b>
   <div class="DivBienvenida2">
      <input name="Cambio Contraseña" type="button" class ="ButtonVideo" value ="&nbsp&nbsp;Cambio Contraseña&nbsp;&nbsp;" 
       onclick="location.href='VideotutorialesCambioPwd.php?'"/> 
      <input name="Desconectarse" type="button" class ="ButtonVideo" value ="&nbsp;&nbsp;Desconectarse&nbsp;&nbsp;" onclick="location.href='VideotutorialesNOLogin.php?'"/>
   </div>
</div>
<?php } ?>


</div>
