<?php
  ///////////////////////////////////  Funciones /////////////////////////////////////////////
function dibujaFichaVideotutorial($numCurso,$conexion,$conectado) {
	if ($conectado == 1) {
		$tituloBoton = "Acceder al curso";
	} else {
		$tituloBoton = "Ver Contenido";
	}
	$imagenIconoCurso = "../VIDEOTUTORIALES/";
	   $FormatMaestros = "SELECT id_curso, carpetadeficheros,  id_categoria,  esta_activo,  orden,  titulo_cur,  edicion,  descripcion_cur,  
imabackground_cur,  imaicono_cur,  videopresentacion,  programaPDF,  programasutilizados,  slogancomercial,  
metodologia,  preciotutorial,  duracion,  id_mailcomer,  autores,  entidadescolaboradoras,  dirigidoa,  objetivos,  
fecha_ini,  fecha_fin, tiene_descuento  FROM vtcursos  where  id_curso = %d";
	//echo "<br>".$FormatMaestros."<br>";
   $queMaestros = sprintf($FormatMaestros, $numCurso); 
    //echo "<br>".$queMaestros."<br>"; 
   //..........ejecutar query
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);
   if ($totMaestros == 0) {
	   exit;
   }
   echo '<div class="envoltorioMedif">'; 
   echo '<div class="ficha_fila">'; 
   while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
	   $txtURL = trim($rowRegistros['videopresentacion']);
	   $final = strlen($txtURL); 
	   $inicio = strpos($txtURL,'=');
	   $codigoYouTube = substr($txtURL,$inicio+1,$final-$inicio-1);
	   
	      echo '<div class="tituloDobleRaya">'.mb_strtoupper($rowRegistros['titulo_cur'],'UTF-8').'</div>';

	   
	   echo '<div class="celda_40_izda">'; 
	   
	        echo '<iframe class="youtube-player"  width="384" height="231" src="http://www.youtube.com/embed/'. $codigoYouTube. '"> </iframe>';
            echo '<br>Vídeo de presentación';
     /*   echo '<img src="../VIDEOTUTORIALES/'.$rowRegistros['carpetadeficheros'].'/'.$rowRegistros['imaicono_cur'].'" alt="'.$rowRegistros['imaicono_cur'].' ">';*/
		echo '</div>';
		echo '<div class="celda_60_decha">'; 
		
		      if (strlen(trim($rowRegistros['slogancomercial'])) > 0) {
              echo '<div class="tituloDobleRayaPeq">'.$rowRegistros['slogancomercial'].'</div>';
			  }
			  
	          echo str_replace("\r\n","<br>",$rowRegistros['descripcion_cur']).'<br>';
			  
			  echo '<br><div>  <!--para contener otras celdas 10 y 90-->';
              echo '<div class = "celda_5_izdaBis"> <img src="../imagenes/Punto.gif" width="30" height="30" /> </div>';
              echo '<div class = "celda_90_dechaTop"> <strong>Software utilizado:</strong><br>'.str_replace("\r\n","<br>",$rowRegistros['programasutilizados']); 
              echo '</div>';
              echo '</div> <!--para contener otras celdas 10 y 90-->';
              echo '<div class="clear"></div>';
           

			if ($conectado == 0) {  
			  
			  
	          echo '<br><div>  <!--para contener otras celdas 10 y 90-->';
              echo '<div class = "celda_5_izdaBis"> <img src="../imagenes/Punto.gif" width="30" height="30" /> </div>';
              echo '<div class = "celda_90_dechaTop"> <strong>Dirigido a:</strong><br>'.str_replace("\r\n","<br>",$rowRegistros['dirigidoa']); 
              echo '</div>';
              echo '</div> <!--para contener otras celdas 10 y 90-->';
              echo '<div class="clear"></div>';
              echo '<br>';
			  
			  
		      echo '<div>  <!--para contener otras celdas 10 y 90-->';
              echo '<div class = "celda_5_izdaBis"> <img src="../imagenes/Punto.gif" width="30" height="30" /> </div>';
              echo '<div class = "celda_90_dechaTop"> <strong>Objetivos:</strong><br>'.str_replace("\r\n","<br>",$rowRegistros['objetivos']); 
              echo '</div>';
              echo '</div> <!--para contener otras celdas 10 y 90-->';
              echo '<div class="clear"></div>';
              echo '<br>';
			  
		      
			  
			  
			}
			     echo '<div class="clear"></div>';
			 echo '<br><br><div align="center">  <input name="Boton22" type="button" class ="btnVerPagina" value ="&nbsp;&nbsp&nbsp;'.$tituloBoton.'&nbsp;&nbsp;&nbsp;" onClick="Javascript:VerCurso('.$rowRegistros['id_curso'].')"/>&nbsp;&nbsp;&nbsp;&nbsp;</div>';

			  
			  echo '</div> <!--de celda_derecha-->'; 
			
			  
	    
		
		
   } //DE WHILE 
	echo '</div></div>'; 
	mysqli_free_result($resMaestros);  
}
/////////////////////////////////////////////////////////////////////
 function EmailAlumno($numAlumno,$conexion) {
	 $mail = "";
	   $FormatMaestros = "SELECT id, email, nombre, apellidos FROM vtalumnos  where  id = %d";
	//echo "<br>".$FormatMaestros."<br>";
   $queMaestros = sprintf($FormatMaestros, $numAlumno); 
    //echo "<br>".$queMaestros."<br>"; 
   //..........ejecutar query
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);
   if ($totMaestros == 0) {
	   return "";
   }
    while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
		$mail = $rowRegistros['email'];
		
	}
	mysqli_free_result($resMaestros);  
return $mail;
 }
 //////////////////////////////////////////////////////////////////////////
 function buscaTituloCatalogo($clausulaNOTIN,$conexion) {
	 $longitudPagados = count($_SESSION['permisos']);
	 if ($longitudPagados == 0) {
		 return "Cursos Cype Online:";
	 }
	 $longitudNOPagados = cuentaNOPagados($clausulaNOTIN,$conexion);
	 if ($longitudNOPagados > 0) {
		 return "Otros cursos Cype:";
	 } else {
		return ""; 
	 }
 }
 //////////////////////////////////////////////////////////////////////////
 function cuentaNOPagados($clausulaNOTIN,$conexion) {
		   $FormatMaestros = "SELECT id_curso 
		                        FROM vtcursos  
		                       WHERE vtcursos.esta_activo > 0
							   and   ( vtcursos.fecha_fin IS NULL OR YEAR(vtcursos.fecha_fin) = 0  OR vtcursos.fecha_fin >= CURDATE())";
							   if (strlen($clausulaNOTIN) > 0){
							       $FormatMaestros .= "and   id_curso NOT IN ".$clausulaNOTIN;
							   }
	//echo "<br>".$FormatMaestros."<br>";
    $queMaestros = sprintf($FormatMaestros); 
    //echo "<br>".$queMaestros."<br>"; 
   //..........ejecutar query
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);
   mysqli_free_result($resMaestros);  
	return $totMaestros;
 }
///////////////////////////////////////////////////////////////////////////////////
 function dibujaCatalogo($clausulaNOTIN,$conexion) {

						  
		$FormatCatalogo = "SELECT id_categoria, id_curso 
		                     FROM vtcursos , vtcategorias 
		                    WHERE vtcursos.id_categoria = vtcategorias.id 
							  and  vtcursos.esta_activo > 0
							  and   ( vtcursos.fecha_fin IS NULL OR YEAR(vtcursos.fecha_fin) = 0  OR vtcursos.fecha_fin >= CURDATE()) ";
							   if (strlen($clausulaNOTIN) > 0){
							       $FormatCatalogo .= " and   id_curso NOT IN ".$clausulaNOTIN;
							   }
						  $FormatCatalogo .= " ORDER BY id_categoria,id_curso";
        $queCatalogo = sprintf($FormatCatalogo);
		
		  //echo $queCatalogo;
		  
		  
        $resCatalogo = mysqli_query($conexion, $queCatalogo) or die(mysqli_error($conexion)); 
	  
        $totCatalogo = mysqli_num_rows($resCatalogo);     

if ($totCatalogo == 0){
	return;
}
	
	while ($rowCatalogo = mysqli_fetch_assoc($resCatalogo)) {
		$cursoPagado = $rowCatalogo['id_curso'];
		dibujaFichaVideotutorial($rowCatalogo['id_curso'],$conexion,0) ;
	}
    mysqli_free_result($resCatalogo); 
 }
?>
