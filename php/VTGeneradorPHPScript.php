<?php
  ///////////////////////////////////  Funciones /////////////////////////////////////////////
 function ContenidoCurso($conexion) {
	
  $FormatVTModulos = "SELECT id_modulo, id_vtcurso, esta_activo, orden_mod, titulo_mod 
                     FROM vtcursomodulo  
                     WHERE  esta_activo > 0
                       and id_vtcurso = %d 
			      ORDER BY orden_mod";
	//echo "<br>".$FormatVTModulos."<br>";
   $queVTModulos = sprintf($FormatVTModulos, $_SESSION['NumeroCurso']); 
   $resVTModulos = mysqli_query($conexion, $queVTModulos) or die(mysqli_error($conexion));
   $totVTModulos = mysqli_num_rows($resVTModulos);
 if ($totVTModulos> 0) {  //.....Registro de conexión
   while ($rowVTModulos = mysqli_fetch_assoc($resVTModulos)) {
   	   if ($totVTModulos != 1) {
   		echo "\n\r".'<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">'.mb_strtoupper($rowVTModulos['titulo_mod'],'UTF-8')."</h2></div>";
   	   }
	   ContenidoBloque($rowVTModulos['id_modulo'],$conexion);
   }     //while

}  else {  //$totVTModulos   
   echo "<br>Módulo no encontrado<br>";
} //$totVTModulos
mysqli_free_result($resVTModulos);
return;
}
//////////////////////
 function endswith($string, $test) {
    $strlen = strlen($string);
    $testlen = strlen($test);
    if ($testlen > $strlen) return false;
    return substr_compare($string, $test, $strlen - $testlen, $testlen) === 0;
 }
////////////////////////////////////////////////////////////////////////////
 function ContenidoBloque($numModulo,$conexion) {
 	
  $FormatVTBloques = "SELECT carpetadeficheros, id_bloque, id_vtcurmodulo, vtcurmodbloque.esta_activo, orden_bloc, titulo_bloc, descripcion_bloc, imaicono_bloc 
                        FROM  vtcursos, vtcursomodulo, vtcurmodbloque
					   WHERE  vtcursomodulo.id_vtcurso = vtcursos.id_curso
					     and  vtcurmodbloque.id_vtcurmodulo = vtcursomodulo.id_modulo
					     and  vtcurmodbloque.esta_activo > 0 
						 and  id_vtcurmodulo = %d
			        ORDER BY orden_bloc";

   $queVTBloques = sprintf($FormatVTBloques, $numModulo); 
   	//echo "<br>".$queVTBloques."<br>";
   $resVTBloques = mysqli_query($conexion, $queVTBloques) or die(mysqli_error($conexion));
   $totVTBloques = mysqli_num_rows($resVTBloques);
 if ($totVTBloques> 0) {  //.....Registro de conexión
   while ($rowVTBloques = mysqli_fetch_assoc($resVTBloques)) {
	
   	//if ($totVTBloques != 1) {
		echo "\n\r".'<div class="celda_5_izdaVT">';   
        echo '<img src="../VIDEOTUTORIALES/'.$rowVTBloques['carpetadeficheros'].'/'.$rowVTBloques['imaicono_bloc'].'" alt="'.$rowVTBloques['imaicono_bloc'].' ">';
		echo '</div>';
		echo "\n\r".'<div class="celda_95_dechaVT">'; 
		echo '<h3 class="bloque_tituloVT">'.str_replace("\r\n","<br>",$rowVTBloques['titulo_bloc'])."</h3>";
		echo '<p class ="bloque_descriVT" >'.str_replace("\r\n","<br>",$rowVTBloques['descripcion_bloc']).'</p>';
		echo "\n\r".'<div class="clear"></div>';
		  ContenidoTema($rowVTBloques['id_bloque'], $rowVTBloques['carpetadeficheros'] ,$conexion);
		  ContenidoRecurso($rowVTBloques['id_bloque'], $rowVTBloques['carpetadeficheros'] ,$conexion);
		  ContenidoVideo($rowVTBloques['id_bloque'], $rowVTBloques['carpetadeficheros'] ,$conexion);

		echo '</div>'; 
		echo '<div class="clear"></div>';
   	//}
	    //
	
   }     //while
   echo '</article>'; 
   
}  else {  //$totVTBloques   
   echo "<br>Bloque no encontrado<br>";
} //$totVTBloques
mysqli_free_result($resVTBloques);
return;
 }
   ///////////////////////////////////  Funciones /////////////////////////////////////////////
 function ContenidoTema($numBloque,$carpeta,$conexion) {
  $FormatVTTemas = "SELECT id, esta_activo, id_vtcurmodbloque, orden_tema, es_de_pago, titulo_tema, ficheroPDF 
                   FROM   vtcurmodbloqtema  
                    WHERE  esta_activo > 0
                      and  id_vtcurmodbloque = %d
                    ORDER BY orden_tema";

   $queVTTemas = sprintf($FormatVTTemas, $numBloque); 
   
   
   //	echo "<br>".$queVTTemas."<br>";
   
   
   
   $resVTTemas = mysqli_query($conexion, $queVTTemas) or die(mysqli_error($conexion));
   $totVTTemas = mysqli_num_rows($resVTTemas);
 if ($totVTTemas> 0) {  //.....Registro de conexión
   echo "<b>Temas</b><br /><br />";
   
   while ($rowVTTemas = mysqli_fetch_assoc($resVTTemas)) {
	  $verLinks = 0;
	  $mostrarCandado = 0;
	  if ($_SESSION['ver_curso'] == 1) {
		  $verLinks = 0;  //se pone a 0 en generación del PHP, después según ejecución cambiará de valor, ver los echo de más abajo
	  } else {
		  if ($rowVTTemas['es_de_pago'] == 0) {
			 $verLinks = 1; 
			 $mostrarCandado = 1;
		  } 
	  }
	  
	
echo '<?php ';
echo '	  $control = '.$rowVTTemas["es_de_pago"].";";     
echo '	  $verLinks = 0;                              ';          
echo '	  $mostrarCandado = 0;                        ';          
echo '	  if ($_SESSION["ver_curso"] == 1) {          ';          
echo '		  $verLinks = 1;                          ';          
echo '	  } else {                                    ';          
echo '		  if ($control == 0) {   ';          
echo '			 $verLinks = 1;                       ';          
echo '			 $mostrarCandado = 1;                 ';          
echo '		  }                                       ';          
echo '	  }                                           ';          
echo ' ?>';
	
	  ///...... si se ven los links
	   $txtLinkNO = "javascript:AvisoDebeComprar(25)";
	   $txtLinkSI = "javascript:Descarga('T',".$rowVTTemas['id'].")"; 
	   $txtLink = $txtLinkNO;
	   if( $verLinks == 1) { $txtLink= $txtLinkSI;} 
	  
	   echo '<?php';
	   echo "\n\r";
	   echo '$txtLinkNO = "javascript:AvisoDebeComprar(25)";';
	   echo '$txtLinkSI = "javascript:Descarga(';
	   echo "'T',".$rowVTTemas['id'].")\";"; 
	   echo '$txtLink = $txtLinkNO;';
	   echo 'if( $verLinks == 1) { $txtLink= $txtLinkSI;} ';
	   echo '?>';
	 
	 
    echo "\n\r".'<div  class="bloqueCelda6Inicial">';
    echo ($mostrarCandado == 1 ? '<img src="../imagenes/CandadoAbierto.gif" alt="Candado abierto" width="25" height="25" />':'
	       <img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" />');            
    echo '<img src="../imagenes/'.IconoFichero($rowVTTemas['ficheroPDF']).'" alt= "Formato fichero" width="25" height="25" />';
    echo "</div>";
    echo '<div  class="bloqueCelda88Cursor"  onclick="';
	               echo '<?php echo  $txtLink  ?>';
	               echo '" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >';           
	    echo ' '.$rowVTTemas['titulo_tema'];
  	echo "</div>";


       
       
	echo "<div class='clear'></div>";
   }     //while
   echo "<br />";
}  
mysqli_free_result($resVTTemas);
return;
 }
 /////////////////////////////////////////////
 function IconoFichero($fichero) {
 $inicio = strrpos($fichero, ".");
 $final = strlen($fichero);
 $sufijo = 	substr($fichero,$inicio+1,$final-$inicio-1); 
 $sufijo = strtoupper($sufijo);	 
 $nombreIcono = "Clip.gif";
	switch ($sufijo) {
    case "PDF":
	    $nombreIcono = "PDF.gif";
	    break;
    case "CYP":
	    $nombreIcono = "CYPE.gif";
	    break;
    case "MP4":
	    $nombreIcono = "MP4.gif";
	    break;
    case "DWG":
	    $nombreIcono = "DWG.gif";
	    break;
    case "RAR":
	    $nombreIcono = "RAR.gif";
	    break;
    case "ZIP":
	    $nombreIcono = "ZIP.gif";
	    break;
    case "DOC":
	    $nombreIcono = "WORD.gif";
	    break;
    case "DOCX":
	    $nombreIcono = "WORD.gif";
	    break;
    case "XLS":
	    $nombreIcono = "XLS.gif";
	    break;
    case "XLSX":
	    $nombreIcono = "XLS.gif";
	    break;
    case "PPT":
	    $nombreIcono = "PPT.gif";
	    break;

    case "JPG":
	    $nombreIcono = "JPG.gif";
	    break;
	}
	return $nombreIcono;
 }
 
 ///////////////////////////////////////////
 function ContenidoRecurso($numBloque,$carpeta,$conexion) {
  $FormatVTRecursos = "SELECT  id, esta_activo, id_vtcurmodbloque, orden_recurso, es_de_pago, titulo_recurso, nomfic_recurso 
		                   FROM vtcurmodbloqrecurso  
						           WHERE esta_activo > 0
						             and   id_vtcurmodbloque = %d 
						           ORDER BY orden_recurso";

   $queVTRecursos = sprintf($FormatVTRecursos, $numBloque); 
   
   
   //	echo "<br>".$queVTRecursos."<br>";
   
   
   
   $resVTRecursos = mysqli_query($conexion, $queVTRecursos) or die(mysqli_error($conexion));
   $totVTRecursos = mysqli_num_rows($resVTRecursos);
 if ($totVTRecursos> 0) {  //.....Registro de conexión
   echo "<b>Recursos</b><br /><br />";
   while ($rowVTRecursos = mysqli_fetch_assoc($resVTRecursos)) {
	  $verLinks = 0;
	  $txtLink ="";
	  $mostrarCandado = 0;
	  if ($_SESSION['ver_curso'] == 1) {
		  $verLinks = 0; //se pone a 0 en generación del PHP, después según ejecución cambiará de valor, ver los echo de más abajo
	  } else {
		  if ($rowVTRecursos['es_de_pago'] == 0) {
			 $verLinks = 1; 
			 $mostrarCandado = 1;
		  } 
	  }
echo '<?php ';
echo '	  $control = '.$rowVTRecursos["es_de_pago"].";";     
echo '	  $verLinks = 0;                              ';          
echo '	  $mostrarCandado = 0;                        ';          
echo '	  if ($_SESSION["ver_curso"] == 1) {          ';          
echo '		  $verLinks = 1;                          ';          
echo '	  } else {                                    ';          
echo '		  if ($control == 0) {   ';          
echo '			 $verLinks = 1;                       ';          
echo '			 $mostrarCandado = 1;                 ';          
echo '		  }                                       ';          
echo '	  }                                           ';          
echo ' ?>';
	  	  ///...... si se ven los links
	   $txtLinkNO = "javascript:AvisoDebeComprar(25)";
	   $txtLinkSI = "javascript:Descarga('R',".$rowVTRecursos['id'].")";  
	  
	   echo '<?php';
	   echo "\n\r";
	   echo '$txtLinkNO = "javascript:AvisoDebeComprar(25)";';
	   echo '$txtLinkSI = "javascript:Descarga(';
	   echo "'R',".$rowVTRecursos['id'].")\";"; 
	   echo '$txtLink = $txtLinkNO;';
	   echo 'if( $verLinks == 1) { $txtLink= $txtLinkSI;} ';
	   echo '?>';


 echo "\n\r".'<div  class="bloqueCelda6Inicial">';
 echo ($mostrarCandado == 1 ? '<img src="../imagenes/CandadoAbierto.gif" alt="Candado abierto" width="25" height="25" />':'<img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" />');
 echo '<img src="../imagenes/'.IconoFichero($rowVTRecursos['nomfic_recurso']).'" alt="Formato fichero" width="25" height="25" />';	

 
echo "</div>";
 
echo '<div  class="bloqueCelda88Cursor"  onclick="';
	               echo '<?php echo  $txtLink  ?>';
	               echo '" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >';        
                 echo $rowVTRecursos['titulo_recurso'];
 echo "</div>";
 
 

	
	
echo "<div class='clear'></div>";
	 
	 
	 
   }     //while

    echo "<br>";
}  
mysqli_free_result($resVTRecursos);
return;
 }
 ///////////////////////////////////////////
 function ContenidoVideo($numBloque,$carpeta,$conexion) {
  $FormatVTVideos = "SELECT  id, esta_activo, id_vtcurmodbloque, es_de_pago, orden_video, titulo_video, url_YouTube, video_pago 
		                   FROM vtcurmodbloqvideo  
						   where id_vtcurmodbloque = %d and esta_activo > 0
						   ORDER BY orden_video";

   $queVTVideos = sprintf($FormatVTVideos, $numBloque); 
   
   
   //	echo "<br>".$queVTVideos."<br>";
   
   
   
   $resVTVideos = mysqli_query($conexion, $queVTVideos) or die(mysqli_error($conexion));
   $totVTVideos = mysqli_num_rows($resVTVideos);
 if ($totVTVideos> 0) {  //.....Registro de conexión
   echo "<b>Videos</b><br /><br />";
   while ($rowVTVideos = mysqli_fetch_assoc($resVTVideos)) {
	  $verLinks = 0;
	  $txtLink ="";
	  $mostrarCandado = 0;
	  
	  
	  
	  if ($_SESSION['ver_curso'] == 1) {
		  $verLinks = 0; //se pone a 0 en generación del PHP, después según ejecución cambiará de valor, ver los echo de más abajo
	  } else {
		  if ($rowVTVideos['es_de_pago'] == 0) {
			 $verLinks = 1; 
			 $mostrarCandado = 1;
		  } 
	  }

echo '<?php ';
echo '	  $control = '.$rowVTVideos["es_de_pago"].";";       
echo '	  $verLinks = 0;                              ';          
echo '	  $mostrarCandado = 0;                        ';          
echo '	  if ($_SESSION["ver_curso"] == 1) {          ';          
echo '		  $verLinks = 1;                          '; 
echo '	  } else {                                    ';          
echo '		  if ($control == 0) {   ';          
echo '			 $verLinks = 1;                       ';          
echo '			 $mostrarCandado = 1;                 ';          
echo '		  }                                       ';          
echo '	  }                                           ';          
echo ' ?>';
	
	  ///...... si se ven los links
	   $txtLinkNO = "javascript:AvisoDebeComprar(25)";
	   $txtLinkSI = "javascript:VerVideo(".$rowVTVideos['id'].")";
  
       echo '<?php';
	   echo "\n\r";
	   echo '$txtLinkNO = "javascript:AvisoDebeComprar(25)";';
	   echo '$txtLinkSI = "javascript:VerVideo(';
	   echo  $rowVTVideos['id'].")\";"; 
	   echo '$txtLink = $txtLinkNO;';
	   echo 'if( $verLinks == 1) { $txtLink= $txtLinkSI;} ';
	   echo '?>';
 
  
  
  
echo "\n\r".'<div  class="bloqueCelda6Inicial">';
echo ($mostrarCandado == 1 ? '<img src="../imagenes/CandadoAbierto.gif" alt="Candado abierto" width="25" height="25" />':'<img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" />');
echo ( $rowVTVideos['es_de_pago'] == 0 ? '<img src="../imagenes/YouTube.jpg" alt="Logo Youtube" width="25" height="25" />':'<img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" />');
 
 
echo "</div>";
 
echo '<div  class="bloqueCelda88Cursor"  onclick="';
	               echo '<?php echo  $txtLink  ?>';
	               echo '" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >';        
                 echo $rowVTVideos['titulo_video'];
                                 
 echo "</div>";
 
	
	
	
	
	
	 echo "<div class='clear'></div>";
   }     //while

    echo "<br>";
}  
mysqli_free_result($resVTVideos);
return;
 }
 /////////////////////////////////////////// funciones para enviar correos al organizador, anotar vtsolicitudes
 function EstadoCertificado($conexion) {
  //devolverá 0 si no está solicitado
  // 1 si está solicitado
  // 2 si está entregado
  
$estado = 0;  // de momento no solicitado
$FormatVTCertificado = "SELECT  fecha_solici_certifi, fecha_entreg_certifi
		             FROM  vtpermisos  
				     WHERE id_usuario = %d 
					   and id_curso   = %d ";
   $queVTCertificado = sprintf($FormatVTCertificado, $_SESSION['NumeroUsuario'], $_SESSION['NumeroCurso']); 
   
   $resVTCertificado = mysqli_query($conexion, $queVTCertificado) or die(mysqli_error($conexion));
   $totVTCertificado = mysqli_num_rows($resVTCertificado);
   if ($totVTCertificado > 0) {  
     while ($rowVTCertificado = mysqli_fetch_assoc($resVTCertificado)) {
	   if ($rowVTCertificado['fecha_solici_certifi'] >'0000-00-00') {
		 $estado = 1;  //solicitado ya que tiene la fecha informada  
	   }
	   if ($rowVTCertificado['fecha_entreg_certifi'] >'0000-00-00') {
		 $estado = 2;  //certificado entregado
	   }
	 } 
}
mysqli_free_result($resVTCertificado);
return $estado;
}
  /////////////////////////////////////////// funciones para enviar correos al organizador, anotar vtsolicitudes
 function FechaSolicitudCertificado($conexion) {
 $devolver = '';  // de momento no solicitado
 $FormatVTCertificado = "SELECT  fecha_solici_certifi
		                   FROM  vtpermisos  
				          WHERE  id_usuario = %d 
					        and  id_curso   = %d ";
   $queVTCertificado = sprintf($FormatVTCertificado, $_SESSION['NumeroUsuario'], $_SESSION['NumeroCurso']); 
   $resVTCertificado = mysqli_query($conexion, $queVTCertificado) or die(mysqli_error($conexion));
   $totVTCertificado = mysqli_num_rows($resVTCertificado);
   if ($totVTCertificado > 0) {  
     while ($rowVTCertificado = mysqli_fetch_assoc($resVTCertificado)) {
	   if ($rowVTCertificado['fecha_solici_certifi'] >'0000-00-00') {
		  $devolver = $rowVTCertificado['fecha_solici_certifi'] ;
	   }
	 } 
    }
mysqli_free_result($resVTCertificado);
return $devolver;

 }
  /////////////////////////////////////////// funciones para enviar correos al organizador, anotar vtsolicitudes
 function FechaEntregaCertificado($conexion) {
 $devolver = '';  // de momento no solicitado
 $FormatVTCertificado = "SELECT  fecha_entreg_certifi
		                   FROM  vtpermisos  
				          WHERE  id_usuario = %d 
					        and  id_curso   = %d ";
   $queVTCertificado = sprintf($FormatVTCertificado, $_SESSION['NumeroUsuario'], $_SESSION['NumeroCurso']); 
   $resVTCertificado = mysqli_query($conexion, $queVTCertificado) or die(mysqli_error($conexion));
   $totVTCertificado = mysqli_num_rows($resVTCertificado);
   if ($totVTCertificado > 0) {  
     while ($rowVTCertificado = mysqli_fetch_assoc($resVTCertificado)) {
	   if ($rowVTCertificado['fecha_entreg_certifi'] >'0000-00-00') {
		  $devolver = $rowVTCertificado['fecha_entreg_certifi'] ;
	   }
	 } 
    }
   mysqli_free_result($resVTCertificado);
   return $devolver;
}
  /////////////////////////////////////////// funciones para enviar correos al organizador, anotar vtsolicitudes
 function FechaInicioPermiso($conexion) {
   $devolver = '';  // de momento no solicitado
   $FormatVTCertificado = "SELECT  fecha_ini
		                   FROM  vtpermisos  
				          WHERE  id_usuario = %d 
					        and  id_curso   = %d ";
   $queVTCertificado = sprintf($FormatVTCertificado, $_SESSION['NumeroUsuario'], $_SESSION['NumeroCurso']); 
   $resVTCertificado = mysqli_query($conexion, $queVTCertificado) or die(mysqli_error($conexion));
   $totVTCertificado = mysqli_num_rows($resVTCertificado);
   if ($totVTCertificado > 0) {  
     while ($rowVTCertificado = mysqli_fetch_assoc($resVTCertificado)) {
	   if ($rowVTCertificado['fecha_ini'] >'0000-00-00') {
		  $devolver = $rowVTCertificado['fecha_ini'] ;
	   }
	 } 
    }
   mysqli_free_result($resVTCertificado);
   return $devolver;
 }
 
?>
