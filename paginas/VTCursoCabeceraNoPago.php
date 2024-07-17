 <?php

 
//echo "Cabecera curso NO Comprado ===================================NUMERO_CURSO = ".$_SESSION['NumeroCurso'];




 $FormatVTCursos = "SELECT id_curso, carpetadeficheros,  id_categoria,  esta_activo,  orden,  titulo_cur,  edicion,  descripcion_cur, web_titulo, imabackground_cur,  imaicono_cur,  videopresentacion,  programaPDF,  programasutilizados,  slogancomercial, soporte, proc_evaluacion,   metodologia,  preciotutorial,  duracion,  id_mailcomer,  autores,  entidadescolaboradoras,  dirigidoa,  objetivos,  certificado_diploma, licencias_temporales, web_logosoftware, 
 fecha_ini,  fecha_fin  
                   FROM vtcursos  where  id_curso = %d";
	//echo "<br>".$FormatVTCursos."<br>";
   $queVTCursos = sprintf($FormatVTCursos, $_SESSION['NumeroCurso']); 
    //echo "<br>".$queVTCursos."<br>"; 
   //..........ejecutar query
   $resVTCursos = mysqli_query($conexion, $queVTCursos) or die(mysqli_error($conexion));
   $totVTCursos = mysqli_num_rows($resVTCursos);
//echo "<br>totVTCursos--->".$totVTCursos;


if ($totVTCursos> 0) {  //.....Registro de conexión
   while ($rowRegistros = mysqli_fetch_assoc($resVTCursos)) {
	   $txtURL = trim($rowRegistros['videopresentacion']);
	   $final = strlen($txtURL); 
	   $inicio = strpos($txtURL,'=');
	   $codigoYouTube = substr($txtURL,$inicio+1,$final-$inicio-1);
       $imgSoftware = "../imagenes/".trim($rowRegistros['web_logosoftware']); 
?>

<div class="PocoEspacio"></div>
<div class="ficha_fila_presentacion"  style="background-image: url(<?php  echo "../VIDEOTUTORIALES/".$rowRegistros['carpetadeficheros'].'/'.$rowRegistros['imabackground_cur'] ?>)"> 
    <div class="NewContenedor100b" >
        <div class ="ImagenSoftware"><img src="<?php echo $imgSoftware ?>" height="50" alt="Logo Software" /></div>
    </div>
    <div class = "TituloVideotutorialP">CURSO</div>
    <h1 class = "TituloVideotutorialPVT"><?php  echo $rowRegistros['web_titulo']; ?></h1> 
    
</div>
<div class="ficha_fila" >
   <div class="centro"><h2 class = "TituloVideotutorialPVTPeq"><?php  echo $rowRegistros['titulo_cur']; ?></h2></div>
</div>

 
 
  <div class="Ancho80">
      
      <div class="Ancho80T"><?php  echo $rowRegistros['slogancomercial']; ?></div>
   <?php if ( strlen($rowRegistros['metodologia']) > 0) {   ?>
       <div class = "CeldaVideotutorialE">Metodología:</div>
       <div class = "CeldaVideotutorialD"><?php  echo $rowRegistros['metodologia']; ?></div>
       <div class = "clear"></div>
   <?php  }  ?>    
       <div class = "CeldaVideotutorialE">Duración:</div>
       <div class = "CeldaVideotutorialD"><?php  echo $rowRegistros['duracion']; ?></div>
       <div class = "clear"></div>
       
       <div class = "CeldaVideotutorialE">Herramientas:</div>
       <div class = "CeldaVideotutorialD"><?php  echo $rowRegistros['programasutilizados']; ?></div>
       <div class = "clear"></div>

   <?php if ( strlen($rowRegistros['licencias_temporales']) > 0) {   ?>
       <div class = "CeldaVideotutorialE">Licencias:</div>
       <div class = "CeldaVideotutorialD"><?php  echo $rowRegistros['licencias_temporales']; ?></div>
       <div class = "clear"></div>
   <?php  }  ?>   

   <?php if ( strlen($rowRegistros['entidadescolaboradoras']) > 0) {  ?>
       <div class = "CeldaVideotutorialE">Colaboradores:</div>
       <div class = "CeldaVideotutorialD"><?php  echo $rowRegistros['entidadescolaboradoras']; ?></div>
       <div class = "clear"></div>
   <?php } ?>
      
   <?php if ( strlen($rowRegistros['certificado_diploma']) > 0) {  ?>
       <div class = "CeldaVideotutorialE">Certificado:</div>
       <div class = "CeldaVideotutorialD"><?php  echo $rowRegistros['certificado_diploma']; ?></div>
       <div class = "clear"></div>
   <?php  }  ?>
 
   <?php if ( strlen($rowRegistros['soporte']) > 0) {   ?>
       <div class = "CeldaVideotutorialE">Soporte:</div>
       <div class = "CeldaVideotutorialD"><?php  echo $rowRegistros['soporte']; ?></div>
       <div class = "clear"></div>
   <?php  }  ?>    

       <div class = "CeldaVideotutorialE">Precio:</div>
       <div class = "CeldaVideotutorialD"><?php  echo $rowRegistros['preciotutorial']." ".$DatosWeb->GetTrimValor('moneda'); ?></div>
       <div class = "clear"></div>
          
</div>  <!--ancho80-->
<!--   INICIO CORREO -->  



   <div id = "CorreoGeneral">  
    
   





   <div id="correoContacto" >
           <p class="pide_panPreTit">Solicitar información del curso</p>
        <form  class="formulario">
	    



<div style="display:flex; flex-direction: column; align-items: center; justify-content:center;">


        <div class="mitad">
	     <br>
 	     <label class="pide_panPre">Nombre </label><input id = "nombre" type="text" name="nombre" size="35" maxlength="30" onKeypress='return txNombres()' value= "<?php if (isset( $_REQUEST['nombre'])) { echo $_REQUEST['nombre']; }?>" required> 
	     <br> <br> 
      	 <label class="pide_panPre">Apellidos </label><input id = "apellidos" type="text" name="apellidos" size="35" maxlength="100" onKeypress='return txNombres()'  value= "<?php if (isset( $_REQUEST['apellidos'])) { echo $_REQUEST['apellidos']; }?>" required> 
	     <br> <br> 

	     <label class="pide_panPre">Email </label> <input id = "email" type="text" name="email" size="35" maxlength="99" value= "<?php if (isset( $_REQUEST['email'])) { echo $_REQUEST['email']; }?>" required > 
	     <br> <br> 
	     <label class="pide_panPre">Teléfono</label> <input id = "telefono" type="text" name="telefono" size="35" maxlength="30" onKeypress='return solonumeros()' value= "<?php if (isset( $_REQUEST['telefono'])) { echo $_REQUEST['telefono']; }?>" >
	     <br> <br> 
	     <label class="pide_panPre">Ciudad</label> <input id = "ciudad" type="text" name="ciudad" size="35" maxlength="30"  onKeypress='return txNombres()' value= "<?php if (isset( $_REQUEST['ciudad'])) { echo $_REQUEST['ciudad']; }?>" >
         <br> <br>  

         <div class="clear"></div>
         <img src="captcha.php" alt="captcha"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id = "code" name="code" maxlength="6" />
            
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




        <div id = "botones"  style="display:flex; flex-direction: column; align-items: center; justify-content:center;">
          
        
        
           
           <input id= "Button1" name="Button" type="Button" class ="ButtonGrisP" value ="&nbsp;&nbsp;&nbsp;&nbsp;Enviar&nbsp;&nbsp;&nbsp;&nbsp;" />


           &nbsp;&nbsp;&nbsp;&nbsp;




       

           
           <input id= "Button2" name="Button" type="Button" class ="ButtonGrisP" value ="&nbsp;&nbsp;&nbsp;&nbsp;Salir&nbsp;&nbsp;&nbsp;&nbsp;" />
         

            
       

        </div>

        





	 </div> 



     </div>





     <div class="clear"></div>
    
     <div class="centro"><div id = "marcoNombreFichero"></div></div>
     
 <div id = "recogeMensajes"></div>
</form> 
</div>
   </div> 
  <!-- FIN CORREO-->

<div class="ficha_fila" >
   <div class="centro">
     <img  style="cursor:pointer" src="../imagenes/SolicitarInformacion_naranja.gif" width="40" height="40" alt="Solicitar información" onMouseOut="javascript:GetImagenSolicitud(1,this)" onMouseOver="javascript:GetImagenSolicitud(2,this)" onclick="javascript:RecibirInformacion()"/>
         
         &nbsp;&nbsp;&nbsp;
          <img style="cursor:pointer" src="../imagenes/AddToCart_naranja.gif" width="40" height="40" alt="carrito compra" onMouseOut="javascript:GetImagenCart(1,this)" onMouseOver="javascript:GetImagenCart(2,this)" onclick="javascrip:ComprarCurso()"/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   </div>
</div>  <!--ficha_fila-->

   
  
   
   


<?php if (strlen(trim($rowRegistros['edicion'])) > 0) { ?>
       <div class="ficha_fila">
           <p style="font-size: 25px;color: #998484;line-height: 8px;text-align: center;font-family:'Montserrat';font-weight:300;font-style:normal" ><?php  echo str_replace("\r\n","<br>",$rowRegistros['edicion']); ?></p>
       </div>
	<?php } ?>
   
   
    <div class="ficha_fila"> <!--  Empezamos con presentación y víseo comercial -->
      <div class = "celda_40_izda"> 
             <div class="izquierda">   
                  <strong style="font-size: 18px">Presentación:</strong><br><br>
                  <?php  echo str_replace("\r\n","<br>",$rowRegistros['descripcion_cur']); ?>
             </div>
             <br>
             <br>
             <div>  <!--para contener otras celdas 10 y 90-->
                      <div class = "celda_5_izdaBis"> <img src="../imagenes/Objetivos.gif" alt="Objetivos" width="20" height="20" /> </div>
                      <div class = "celda_90_dechaTop"> <strong>Objetivos:</strong><br><br><?php  echo str_replace("\r\n","<br>",$rowRegistros['objetivos']); ?></div>
    
             </div> <!--para contener otras celdas 10 y 90-->
             <div class="clear"></div>
             <br>
         
         <div>  <!--para contener otras celdas 10 y 90-->
           <div class = "celda_5_izdaBis"> <img src="../imagenes/DirigidoA.gif" alt="Target" width="20" height="20" /> </div>
           <div class = "celda_90_dechaTop"> <strong>Dirigido a:</strong><br><br><?php  echo str_replace("\r\n","<br>",$rowRegistros['dirigidoa']); ?><br><br></div>
        </div> <!--para contener otras celdas 10 y 90-->
        
        <div class="clear"></div>
      
       <?php
          if ( trim($rowRegistros['programaPDF']) != "") {
        ?>
         <input name="Ver Programa" type="button" class ="ButtonGris" value ="Ver Programa" onClick="VerDocumentoAdjunto('<?php  echo "../VIDEOTUTORIALES/".$rowRegistros['carpetadeficheros'].'/'.$rowRegistros['programaPDF'] ?>')" />
   
        <?php
          }
        ?>
        
        
     <br />
   </div> <!--celda_40_izda-->
      
      
   <div class = "celda_60_decha">
        <br />
        <br />
          
   <div class="centro">     
   

<object data="https://www.youtube.com/embed/<?php echo  $codigoYouTube ?>">
</object>


</div>

    </div> <!--de celda_60_decha-->
 </div> <!--de ficha_fila-->
   
 
 <?php
   }     //while
}  else {  //$totVTCursos   
    echo "<br>Videotutorial no encontrado--->".$_SESSION['NumeroCurso']."<br>";
} //$totVTCursos
 mysqli_free_result($resVTCursos);
//$rowRegistros[$CampoMombre[$i]]
 ?>
 
 