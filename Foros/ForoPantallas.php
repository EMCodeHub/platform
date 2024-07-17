<?php

$alias ="";
$comment = "";
$pwd = "";
$FormatAlumnos = "SELECT alias_foro, alias_comment, pwd from vtalumnos where id = %d";
$queAlumnos = sprintf($FormatAlumnos,$_SESSION['NumeroUsuario']);
$resAlumnos = mysqli_query($conexion, $queAlumnos) or die(mysqli_error($conexion));  
$totAlumnos = mysqli_num_rows($resAlumnos);  


if ($totAlumnos > 0){
	while ($rowAlumnos = mysqli_fetch_assoc($resAlumnos)) {
		$alias = $rowAlumnos['alias_foro']; 
        $comment = $rowAlumnos['alias_comment']; 
        $pwd = $rowAlumnos['pwd']; 
	}
}

mysqli_free_result($resAlumnos);  
?>
    


    
<div id="Acceder" style="border-radius: 20px;">


<div class="pruebasforo">


     <div class="AccederAzul">


     <div class="tituloaccederyx">
        <div class="AccederTitulo">Comunidad de Foros: Software CYPE</div>


        <div class="AccederCruz" onclick="CierraAcceder(0)" style="margin-left: -5px;"> ❌ </div>

</div>

        <div class="clear"></div>
    </div>
   
    
    <div class="AccederDiv100">
        <div class="Gris"></div>
        <div class="clear"></div>
    </div> 
    

<div class="tomodatosforo">

   <div class="AccederDiv100">
        <div class="AccederI">Tu Email</div>
        <div class="AccederD"><input id="TuCorreo" class="inputRedondo" name="TuCorreo" size=25 type="text" placeholder="¿Cuál es tu email?"/></div>
        <div class="clear"></div>
    </div>  
    <div class="AccederDiv100">
        <div class="AccederI">Contraseña</div>
        <div class="AccederD"><input id="TuPwd" class="inputRedondo" name="TuPwd" type="password" size=25 type="text" placeholder="¿Cuál es tu contraseña?"/></div>
        <div class="clear"></div>
    </div>


</div>


    <div class="AccederDiv100">
        <div class="AccederI">&nbsp;</div>
            <div class="AccederD"><div id="mensajeAcceder"></div></div>
        <div class="clear"></div>
    </div>
    <div class="AccederDiv100">
        <div class="AccederI">&nbsp;</div>
        <div class="AccederD"><a href="javascript:ACCPwdOlvidado()">Has olvidado la contraseña ?</a></div>
        <div class="clear"></div>
    </div>

    <div class="AccederDiv100">
        <div class="AccederI">&nbsp;</div>
        <div class="AccederD"><a href="#" id="Conecta" class="ButtonGris ">Inicia sesión</a></div>
        
        <div class="clear"></div>
        
    </div>  
    <div class="AccederDiv100T">
        <spam class="AccederTitulo2">Registro gratis en nuestra comunidad</spam><br /><br />
        <spam class="AccederPequenyo">Los usuarios registrados pueden participar en el apartado de consultas generales, 
        obtener respuestas técnicas.<br />
        Para acceder a foros de cursos hay que estar inscrito al curso en cuestión.<br />
        No recibirás spam ni te enviaremos emails con información que seguramente no te interese.<br /> 
        </spam>
        <div class="clear"></div>
        <br/>
        <a href="javascript:CierraRegistrarse(1)" class="ButtonGris ">Regístrate</a>
        <br />
    </div> 



</div>



</div>




<div id="Registrarse">
     <div class="AccederAzul">
        <div class="AccederTitulo">Regístrate</div>


        <div class="AccederCruz"> <img  src="../imagenes/exitbotonbusqueda.png" alt="Aspa de Cierre" width="14px"  height="10px" onclick="CierraRegistrarse(0)"/> </div>
        <div class="clear"></div>
    </div>    

      <div class="AccederDiv100">
        <div class="AccederI">Alias</div>

        <div class="AccederD"><input style="width: 260px;
    padding: 8px;
    border: 1px solid rgb(204, 204, 204);
    border-radius: 30px;
    box-sizing: border-box;" id="TuAlias" class="inputRedondo" name="TuAlias" size=20 type="text" placeholder="Nombre para visualizar en los foros"/></div>
        <div class="clear"></div>
    </div>  
    
    <div class="AccederDiv100">
        <div class="AccederI">Descripción</div>
        <div class="AccederD"><input style="width: 260px;
    padding: 8px;
    border: 1px solid rgb(204, 204, 204);
    border-radius: 30px;
    box-sizing: border-box;" id="TuDescripcion" class="inputRedondo" name="TuDescripcion" size=20 type="text" placeholder="Descripción para visualizar en los foros"/></div>
        <div class="clear"></div>
    </div>  
    
    <div class="AccederDiv100">
        <div class="AccederI">E-mail</div>
        <div class="AccederD"><input style="width: 260px;
    padding: 8px;
    border: 1px solid rgb(204, 204, 204);
    border-radius: 30px;
    box-sizing: border-box;" id="TuEmailReg" class="inputRedondo" name="TuEmailReg" size=20 type="text" /></div>
        <div class="clear"></div>
    </div>  

    <div class="AccederDiv100">
        <div class="AccederI">Crea tu Contraseña</div>
        <div class="AccederD"><input style="width: 260px;
    padding: 8px;
    border: 1px solid rgb(204, 204, 204);
    border-radius: 30px;
    box-sizing: border-box;" id="TuPwdReg" class="inputRedondo" name="TuPwdReg" type="password" size=20 type="text" placeholder="¿Cuál es tu contraseña?"/></div>
        <div class="clear"></div>
    </div>
    <div class="AccederDiv100">
        <div class="AccederI"><br/></div>
            <div class="AccederD"><input type="checkbox" id="TuBoxReg" value="1"> <span class="AccederPequenyo">Acepto la Política de Privacidad</span>
            </div>
        
        <div class="clear"></div>
    </div>
      <div class="AccederDiv100">
        <div class="AccederI"><br/><br/></div>
            <div class="AccederD">
               <p class="AccederMasPequenyo">Los datos suministrados no se comparten con terceros ni recibirás correos spam</p>
            </div>
        
    </div>
    
    
       <div class="AccederDiv100">
        <div class="AccederI"><br/><br/></div>
        <div class="AccederD"><div id="mensajeRegistro"></div></div>
        <div class="clear"></div>
    </div>
    
    <div class="AccederDiv100">
        
        <div id="BotonAceptar">
            <div class="AccederI"><br /><br /><br /></div>
            <div class="AccederD"><a href="#" id="BtnRegistro" class="ButtonGris">Registro</a><br /><br /></div>
        </div>
        
        <div class="clear"></div>
    </div> 
    
    <div class="clear"></div>

</div>








  





<div id="Busqueda" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 80px; ">
   
<input id="pal_abra" type="text" size="50" maxlength="100" value="" placeholder="Palabras a buscar" style="margin-bottom: 10px; padding: 8px;">
    <div style="display: flex; flex-direction: row;">
    <img src="../imagenes/lupaforobusqueda.png" width="35" height="35" alt="Boton Lupa" onclick="EjecutaBusqueda()">

        <img src="../imagenes/exitbotonbusqueda.png" width="35" height="35" alt="Boton Exit" onclick="PantallaBusqueda(0)" style="margin-right: 10px;">




    </div>
</div>


















    
<div id="Perfil">
     <div class="AccederAzul">
        <div class="AccederTitulo">Edición de tu Perfil</div>
        <div class="AccederCruz"> <img style="margin-right:5px;"  src="../imagenes/exitbotonbusqueda.png" alt="Aspa de Cierre" width="30px"  height="30px" onclick="CierraPerfil(0)"/> </div>
        <div class="clear"></div>
    </div>    

 
      <div class="AccederDiv100">
        <div class="AccederI">Alias / Sobrenombre</div>
        <div class="AccederD"><input style="width: 260px;
    padding: 8px;
    border: 1px solid rgb(204, 204, 204);
    border-radius: 30px;
    box-sizing: border-box;" id="PerfilAlias" name="PerfilAlias" size=25 type="text" placeholder="Nombre para visualizar en los foros, en blanco se borra" value = "<?php echo $alias ?>"/></div>
        <div class="clear"></div>
    </div>   
      <div class="AccederDiv100">
        <div class="AccederI">Descríbete en una frase</div>
        <div class="AccederD"><input style="width: 260px;
    padding: 8px;
    border: 1px solid rgb(204, 204, 204);
    border-radius: 30px;
    box-sizing: border-box;" id="PerfilDescripcion" name="PerfilDescripcion" size=25 type="text" placeholder="Descripción para visualizar en los foros, en blanco se borra" value = "<?php echo $comment ?>"/></div>
        <div class="clear"></div>
    </div>  
      <div class="AccederDiv100">
        <div class="AccederI">Nueva Contraseña</div>
        <div class="AccederD"><input style="width: 260px;
    padding: 8px;
    border: 1px solid rgb(204, 204, 204);
    border-radius: 30px;
    box-sizing: border-box;" id="PerfilPwd" name="PerfilPwd" type="password" size=25 type="text" placeholder="Infórmala si deseas cambiarla. No es obligatorio"/></div>
        <div class="clear"></div>
    </div> 
         <div class="AccederDiv100">
        <div class="AccederI">Repite Contraseña</div>
        <div class="AccederD"><input style="width: 260px;
    padding: 8px;
    border: 1px solid rgb(204, 204, 204);
    border-radius: 30px;
    box-sizing: border-box;" id="PerfilPwd2"  name="PerfilPwd2" type="password" size=25 type="text" placeholder="Si deseas cambiarla: Repite la contraseña"/></div>
        <div class="clear"></div>
    </div> 
       <div class="AccederDiv100">
        <div class="AccederI"><br/><br/></div>
        <div class="AccederD"><div id="mensajePerfil"></div></div>
        <div class="clear"></div>
    </div>
    
    <div class="AccederDiv100">
        <div id="BotonAceptar">
            <div class="AccederI"><br /><br /><br /></div>
            <div class="AccederD"><a href="#" id="BtnPerfil" class="ButtonGris">Grabar</a><br /><br /></div>
        </div>
        <div class="clear"></div>
    </div>    
    
    

	
</div>
    