<?php
  session_start();
  if (!isset($_REQUEST['NumeroCurso'])) {
	    $_REQUEST['NumeroCurso'] = 0;
  }
  include_once('../conexion/conn_bbdd.php');
  include_once('../php/CursosScrip.php');
  include_once('../php/ValidaLoginScript.php');
  include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
  $DatosWeb =   new ParametrosClass($conexion);
  include_once('EstilosScripsNOIndex.php');
?>
<head>
<link rel="stylesheet" type="text/css" href="../css/EstiloBase.css">
<link rel="stylesheet" media="(min-width:1184px) and (max-width:1300px) and (orientation: landscape)" href="../css/Estilo_1300_L.css">
<link rel="stylesheet" media="(min-width:1184px) and (max-width:1300px) and (orientation: portrait)" href="../css/Estilo_1300_P.css">
<link rel="stylesheet" media="(min-width:859px) and (max-width:1184px) and (orientation: landscape)" href="../css/Estilo_1184_L.css">
<link rel="stylesheet" media="(min-width:859px) and (max-width:1184px) and (orientation: portrait)" href="../css/Estilo_1184_P.css">
<link rel="stylesheet" media="(min-width:781px) and (max-width:859px) and (orientation: landscape)" href="../css/Estilo_859_L.css">
<link rel="stylesheet" media="(min-width:781px) and (max-width:859px) and (orientation: portrait)" href="../css/Estilo_859_P.css">
<link rel="stylesheet" media="(min-width:668px) and (max-width:781px) and (orientation: landscape)" href="../css/Estilo_781_L.css">
<link rel="stylesheet" media="(min-width:668px) and (max-width:781px) and (orientation: portrait)" href="../css/Estilo_781_P.css">
<link rel="stylesheet" media="(min-width:598px) and (max-width:668px) and (orientation: landscape)" href="../css/Estilo_668_L.css">
<link rel="stylesheet" media="(min-width:598px) and (max-width:668px) and (orientation: portrait)" href="../css/Estilo_668_P.css">
<link rel="stylesheet" media="(min-width:419px) and (max-width:598px) and (orientation: landscape)" href="../css/Estilo_598_L.css">
<link rel="stylesheet" media="(min-width:419px) and (max-width:598px) and (orientation: portrait)" href="../css/Estilo_598_P.css">
<link rel="stylesheet" media="(max-width:419px) and (orientation: landscape)" href="../css/Estilo_419_L.css">
<link rel="stylesheet" media="(max-width:419px) and (orientation: portrait)" href="../css/Estilo_419_P.css">



<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>encuentros <?php echo $DatosWeb->GetTrimValor('web_dominio') ?> </title>
<?php include_once('PaginaCabecera.php'); ?>    
<?php
  header('Pragma: no-cache'); // HTTP 1.0.
  header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
  header('Expires: 0'); // Proxies.
?>
     <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
     <script type="text/javascript" src="../php/CursoPeticion.js"></script>

<SCRIPT LANGUAGE="JavaScript">
function VerDocumentoAdjunto(URL) {
		
		window.open(URL,"Programa / Documentacion curso","width=900,height=700,scrollbars=YES,resizable=YES,LEFT=250,TOP=100") 	

}

function VerSeccionCorreo() {
		
		document.getElementById('FichaSeccionCorreoDelCurso').style.display  = "block";
}
 </SCRIPT>

</head>
<body>
 <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


<div id="FichaCursoEnvoltorio">


<?php

$FormatMaestros = "select A.id, A.referencia, A.esta_activo, A.fecha_ini,  A.fecha_fin,  A.ponente,  A.id_mailcomer,  A.id_organizador, A.titulo_abreviado, A.titulo_corto, A.titulo_largo, A.id_tipocurso, A.id_modalidad, A.id_periodicidad, A.horario, 
A.num_horas_curso, A.programas_utili, A.precio, A.forma_pago, A.plazas_aprox, A.programa_pdf, A.documentos_pdf, A.observaciones, B.id AS IDORGANIZADOR, B.descripcion_interna, B.nombre_organizador, B.pais, B.ciudad, B.lugar, B.direccion, B.pers_contacto, 
B.tfn_contacto, C.id AS MODALIDAD_ID, C.descripcion AS MODALIDAD_DESCRI, D.id AS TIPO_ID, D.descripcion AS TIPO_DESCRI, E.id AS PERIODO_ID, E.descripcion AS PERIODO_DESCRI, F.correoelectronico, F.nombre_correo  
from cursos A, organizadores B, modalidadcurso C, tipocurso D, periodocursos E , emailscomerciales F
where  A.id = %d and  A.id_organizador = B.id and  A.id_modalidad = C.id and  A.id_tipocurso = D.id and A.id_periodicidad = E.id and A.id_mailcomer = F.id";

 $queMaestros = sprintf($FormatMaestros,$_REQUEST['NumeroCurso']);
 $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
 $totMaestros = mysqli_num_rows($resMaestros);
 
 if ($totMaestros> 0) { 

 while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
		    echo "<script>Nombre_correo = '".$rowRegistros['nombre_correo']."';\n";
			echo "emisorcorreo = '".$rowRegistros['correoelectronico']."';\n";	
			echo "numCurso = '".$rowRegistros['id']."';\n";	
			echo "</script>";

?>

     
     <div class = "FichaTituloCurso">
   
          <?php echo $rowRegistros['titulo_corto'];  ?>
     </div>

     
     <div class = "FichaCurso">
     	
     	
          <div class = "FichaCursoFila">
               <div class = "FichaCursoIzda">
                             Ciudad
               </div>
               <div class = "FichaCursoDecha">
                          <div class="ColorTituloCursoParaCiudad">
                             <?php echo $rowRegistros['ciudad']    ;  
                             if ( strlen($rowRegistros['pais'] ) > 0) { 
							   echo ' ('. $rowRegistros['pais'].')' ;
							 } 
							 ?>
                          </div>   
                             
               </div>
          </div>
          <div class = "FichaCursoFila">


          <div class = "FichaCursoFila">
               <div class = "FichaCursoIzda">
                             Lugar
               </div>
               <div class = "FichaCursoDecha">
                             <?php echo $rowRegistros['lugar'];  ?>
               </div>
          </div>

          <div class = "FichaCursoFila">
               <div class = "FichaCursoIzda">
                             Dirección
               </div>
               <div class = "FichaCursoDecha">
                             <?php echo $rowRegistros['direccion'];  ?>
               </div>
          </div>
         <div class = "FichaCursoFila">
               <div class = "FichaCursoIzda">
                             Teléfono
               </div>
               <div class = "FichaCursoDecha">
                             <?php echo $rowRegistros['pers_contacto'].'  Tfn: '.$rowRegistros['tfn_contacto'];?>
               </div>
          </div>
          
         <div class = "FichaCursoFila">
               <div class = "FichaCursoIzda">
                             Tipo
               </div>
               <div class = "FichaCursoDecha">
                             <?php echo $rowRegistros['TIPO_DESCRI'];  ?>
               </div>
          </div>
          <div class = "FichaCursoFila">
               <div class = "FichaCursoIzda">
                             Modalidad
               </div>
               <div class = "FichaCursoDecha">
                              <?php echo $rowRegistros['MODALIDAD_DESCRI'];  ?>
               </div>
          </div>
          <div class = "FichaCursoFila">
               <div class = "FichaCursoIzda">
                             Periodicidad
               </div>
               <div class = "FichaCursoDecha">
                              <?php echo $rowRegistros['PERIODO_DESCRI'];  ?>
               </div>
          </div>
      
        <?php   if (strlen($rowRegistros['programas_utili']) > 0) {  ?>
          
          <div class = "FichaCursoFila">
               <div class = "FichaCursoIzda">
                             Software utilizado
               </div>
               <div class = "FichaCursoDecha">
            
                             <?php echo $rowRegistros['programas_utili'];  ?>
                             
               </div>
          </div>
       <?php   }  ?>



         <div class = "FichaCursoFila">
               <div class = "FichaCursoIzda">
                             Total horas
               </div>
               <div class = "FichaCursoDecha">
                             <?php echo $rowRegistros['num_horas_curso'].' ';
							 if ($rowRegistros['num_horas_curso'] == 1) {
							    echo 'hora';
							 } else {
								echo 'horas';
							 }
							 ?>
               </div>
          </div>
          
  <?php   if ($rowRegistros['plazas_aprox'] > 0) {  ?>
             <div class = "FichaCursoFila">
               <div class = "FichaCursoIzda">
                             Plazas aprox.
               </div>
               <div class = "FichaCursoDecha">
                             <?php echo $rowRegistros['plazas_aprox'];  ?>
               </div>
          </div>
 <?php } ?>        
          
          
          
          
          
          
        <div class = "FichaCursoFila">
               <div class = "FichaCursoIzda">
                             Precio
               </div>
               <div class = "FichaCursoDecha">
                             <?php echo $rowRegistros['precio'];  ?>
               </div>
        </div>
        
        
<?php   if (strlen($rowRegistros['forma_pago']) > 0) {  ?>
             <div class = "FichaCursoFila">
               <div class = "FichaCursoIzda">
                             Forma de pago
               </div>
               <div class = "FichaCursoDecha">
                             <?php echo $rowRegistros['forma_pago'];  ?>
               </div>
          </div>
 <?php } ?>






<?php
$url_complem = "correosCursosCalendario.php";
$url_complem .= "?P_idCurso=".rawurlencode($rowRegistros['id']);
$url_complem .= "&P_emailDestino=".rawurlencode($rowRegistros['correoelectronico']);
$url_complem .= "&P_nombrePonente=".rawurlencode($rowRegistros['ponente']);
$url_complem .= "&P_referenciaCurso=".rawurlencode($rowRegistros['referencia']);
$url_complem .= "&P_titulo_corto=".rawurlencode($rowRegistros['titulo_corto']);
$url_complem .= "&P_titulo_largo=".rawurlencode($rowRegistros['titulo_largo']);
$url_complem .= "&P_ciudad=".rawurlencode($rowRegistros['ciudad']);
$url_complem .= "&P_pais=".rawurlencode($rowRegistros['pais']);
$url_complem .= "&P_lugar=".rawurlencode($rowRegistros['lugar']);
$url_complem .= "&P_nombre_organizador=".rawurlencode($rowRegistros['nombre_organizador']);
$url_complem .= "&P_pers_contacto=".rawurlencode($rowRegistros['pers_contacto']);
$url_complem .= "&P_direccionCurso=".rawurlencode($rowRegistros['direccion']);
$url_complem .= "&P_tfn_contacto=".rawurlencode($rowRegistros['tfn_contacto']);
$url_complem .= "&P_diaIniCurso=".rawurlencode($rowRegistros['fecha_ini']);
$url_complem .= "&P_diaFinCurso=".rawurlencode($rowRegistros['fecha_fin']);
$url_complem .= "&P_horarioCurso=".rawurlencode($rowRegistros['horario']);
$url_complem .= "&P_tipoCurso=".rawurlencode($rowRegistros['TIPO_DESCRI']);
$url_complem .= "&P_modalidadCurso=".rawurlencode($rowRegistros['MODALIDAD_DESCRI']);
$url_complem .= "&P_precioCurso=".rawurlencode($rowRegistros['precio']);
$url_complem .= "&P_periodicidadCurso=".rawurlencode($rowRegistros['PERIODO_DESCRI']);
$url_complem .= "&P_formaPagoCurso=".rawurlencode($rowRegistros['forma_pago']);
$url_complem .= "&P_plazas_aprox=".rawurlencode($rowRegistros['plazas_aprox']);
$url_complem .= "&P_programa_pdf=".rawurlencode($rowRegistros['programa_pdf']);
$url_complem .= "&P_observaciones=".rawurlencode($rowRegistros['observaciones']);
$url_complem .= "&P_num_horas_curso=".rawurlencode($rowRegistros['num_horas_curso']);
$url_complem .= "&P_num_horas_curso=".rawurlencode($rowRegistros['num_horas_curso']);

?>

<div id="FichaSeccionCorreoDelCurso">
   <div id="correoCurso" >
   <br>
           <p class="pide_panPreTit">Solicitud de inscripción curso</p>
        <form  class="formulario">
	    
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
         <br>  

         <div class="clear"></div>
         <img src="captcha.php" border="0" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id = "code" name="code" maxlength="6" />
            
	 </div>
	
	 <div class="mitad">
 
         <label class="pide_panPre"> Observaciones:</label>
         <br>
         <textarea id = "comentarios" class="areaTexto" cols="40" rows="10" name="comentarios"  ><?php if (isset( $_REQUEST['comentarios'])) { echo $_REQUEST['comentarios']; }?></textarea>
         <div class="clear"></div>
         <div align="center">
               <div id = "marcoMensaje"></div>
        </div>
        <div class="clear"></div>
        <div id = "botones" >
           <center>
           <input  type="Button"  id= "Button1" name="Button"  value="Enviar">
           <input  type="Button" value="Borrar" onClick="borraCampos()"> 
           </center>
        </div>

        
	 </div> 
     <div class="clear"></div>
    
<!--     <div align="center"><div id = "marcoNombreFichero"></div></div>-->
     
 <div id = "recogeMensajes"></div>
</form> 
</div>
</div>

       <div class = "FichaCursoFila">
               <div class = "FichaCursoIzdaAgenda">
                             Agenda
               </div>
               <div class = "FichaCursoDecha">
                  <div class = "FichaCursoAgendaDiaTxt">
                  	     <div class = "FichaCursoAgendaDia">
                  	                 Día
                         </div>	
                  	     <?php echo $rowRegistros['fecha_ini'];if ($rowRegistros['fecha_fin']<> '0000-00-00') {echo " / ".$rowRegistros['fecha_fin'];}  ?>
                  </div>	           
                  <div class = "FichaCursoAgendaHorarioTxt">
                  	<div class = "FichaCursoAgendaHorario">
                  	                 Horario
                    </div>	
                  	                 <?php echo $rowRegistros['horario'];  ?>
                  </div>	             
                   <div class = "FichaCursoAgendaTituloTxt">
                   	<div class = "FichaCursoAgendaTitulo">
                   	                 Título
                  	
                    </div>	
                   	                 <?php echo $rowRegistros['titulo_largo'];  ?>
                  </div>
                                        
            
             </div>
       </div>







        <div class = "FichaCursoFila">
               <div class = "FichaCursoIzdaConBordeSuperior">
                             Ponente
               </div>
               <div class = "FichaCursoDecha">
                             <?php echo $rowRegistros['ponente'];  ?>
               </div>
        </div>

        <div class = "FichaCursoFila">
               <div class = "FichaCursoIzda">
                             Entidad organizadora
               </div>
               <div class = "FichaCursoDecha">
                             <?php echo $rowRegistros['nombre_organizador'];  ?>
               </div>
        </div>
        
 <?php   if (strlen($rowRegistros['observaciones']) > 0) {  ?>
          <div class = "FichaCursoFila">
               <div class = "FichaCursoIzdaObservaciones">
                             Observaciones
               </div>
               <div class = "FichaCursoDecha">
                             <?php echo $rowRegistros['observaciones'];  ?>
               </div>
          </div>
 <?php } ?>

<?php   if (strlen($rowRegistros['programa_pdf']) > 0) {  ?>
         <div class = "FichaCursoFila">
               <div class = "FichaCursoIzdaConBordeSuperior">
                             Programa del curso
               </div>
               <div class = "FichaCursoDecha">
                             <div class = "contenedorBoton"><input name="Ver Programa" type="button" class ="btnVerPrograma" value ="Ver Programa" onClick="VerDocumentoAdjunto('<?php   echo '../CURSOSPROGRAMAS/'.$rowRegistros['programa_pdf']; ?>')" /></div>
               </div>
          </div>
 <?php } ?>          
 
<?php   if (strlen($rowRegistros['documentos_pdf']) > 0) {  ?> 
         <div class = "FichaCursoFila">
               <div class = "FichaCursoIzda">
                             Documentación
               </div>
               <div class = "FichaCursoDecha">
                             <div class = "contenedorBoton"><input name="Ver Documentos" type="button" class ="btnVerPrograma" value ="Ver Documentos" onClick="VerDocumentoAdjunto('<?php   echo '../CURSOSDOCUMENTOS/'.$rowRegistros['documentos_pdf']; ?>')" /></div>
               </div>
          </div>
 <?php } ?> 



        <div class = "FichaCursoFila">
               <div class = "FichaCursoIzda">
                             Inscripción
               </div>
               <div class = "FichaCursoDecha">
                             <div class = "contenedorBoton"><input name="Inscribirse" type="button" class ="btnVerPrograma" value ="Inscribirse" onClick="VerSeccionCorreo()" /></div>
               </div>
          </div>





     </div>
 

<?php
}
}
 mysqli_free_result($resMaestros);
?>


</div>
<center> <input name="Cerrar Ventana" type="button" class ="btnVerPrograma" value ="Cerrar Ventana" onClick="window.close()" /> </center>


<div class = "Aviso"></div>
</body>