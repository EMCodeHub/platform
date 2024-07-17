 <?php

 
//echo "Cabecera curso Comprado ===================================NUMERO_CURSO = ".$_SESSION['NumeroCurso'];




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
          
</div>  <!--ancho80-->
  


<?php if (strlen(trim($rowRegistros['edicion'])) > 0) { ?>
       <div class="ficha_fila">
           <p style="font-size: 25px;color: #9faacd;line-height: 8px;text-align: center;font-family:'Montserrat';font-weight:300;font-style:normal" ><?php  echo str_replace("\r\n","<br>",$rowRegistros['edicion']); ?></p>
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
 
 