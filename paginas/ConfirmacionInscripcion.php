<!doctype html>
<html lang="es">
<?php
  session_start();
 include_once('../conexion/conn_bbdd.php');
 include_once('EstilosScripsNOIndex.php');
 include_once('../php/ValidaLoginScript.php');
 include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);

?>
<head>
<meta charset="utf-8">


<?php  
include_once('EstilosScripsNOIndex.php');
?>

<title>Aula Cype: Confirmación de inscripción</title>
<?php include_once('PaginaCabecera.php'); ?>  
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php  
include_once('CabNoIndex.php');
$datosEncontrados = 0;
$idRegistro   = 0;
$fechaInscripcionAnterior = "";
$mensajeDeRepeticion = "";
$mensajeWarning = "";
$tfnCliente = "";
$commentCliente = "";
$mailOrganizador = "";
$cursoActivo = 0;  //.... no está activo por defecto
$cursoVencido = 1; //..... está vencido por defecto
$FormatMaestros = "select id, id_curso, fecha_inscripcion, nombre, apellidos, email_cliente, telefono, fecha_mail 
 from alumnosinscritos
where id_curso =  %d
  and nombre   = '%s'    
  and apellidos =  '%s'
  and email_cliente = '%s' 
  and fecha_mail = '%s'
 ";
$queMaestros = sprintf($FormatMaestros, $_REQUEST["C_idCurso"], $_REQUEST["C_nombre"], $_REQUEST["C_apellidos"], $_REQUEST["C_email"],$_REQUEST["C_fechaMail"]);


$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros); 

if ($totMaestros > 0){
	$datosEncontrados = 1; 
	while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
	   $idRegistro = $rowRegistros['id'];
	   $fechaInscripcionAnterior = 	$rowRegistros['fecha_inscripcion'];
	   $tfnCliente =  $rowRegistros['telefono'];
	   if ($rowRegistros['fecha_inscripcion'] >'0000-00-00') {
		   if ($rowRegistros['fecha_inscripcion'] == date("Y-m-d") ) {
			   $mensajeDeRepeticion = "Nos constas inscrito/a en una petición anteior.";  
		   } else {
			  $mensajeDeRepeticion = "Nos constas inscrito/a desde el día: ".$rowRegistros['fecha_inscripcion'];  
		   }
	   }
	} 
}
//.............INI......ver si curso activo y no vencido
$FormatMaestros = "select id, esta_activo,fecha_ini, fecha_fin from cursos where id = %d";
$queMaestros = sprintf($FormatMaestros,$_REQUEST['C_idCurso']);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));	
while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {	
   $cursoActivo = $rowRegistros['esta_activo'];
   if (date("Y-m-d") > $rowRegistros['fecha_ini'])  {
    $mensajeWarning = "El curso ya está iniciado";
   }
   if ( date("Y-m-d") > $rowRegistros['fecha_fin']  && date("Y-m-d") > $rowRegistros['fecha_ini']) {
        $mensajeWarning = "El curso al que intentas inscribirte ya ha acabado";
   } else {
	  $cursoVencido = 0; 
   }
}
//.............FIN......ver si curso activo y no vencido

if ($datosEncontrados == 1 && $cursoActivo > 0 && $cursoVencido == 0) {	
$FormatMaestros = "select A.id, A.referencia, A.fecha_ini, A.fecha_fin, A.titulo_corto, A.horario, A.titulo_corto, A.id_mailcomer, A.precio, 
 B.pais, B.ciudad, B.lugar, B.direccion, B.pers_contacto, C.correoelectronico
 from cursos A, organizadores B, emailscomerciales C
 where  A.id = %d and  A.id_organizador = B.id and A.id_mailcomer = C.id
 ";
 $queMaestros = sprintf($FormatMaestros,$_REQUEST['C_idCurso']);
 $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));	

  while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {	
 
$mailOrganizador = $rowRegistros['correoelectronico'];
$titulocorreo  = "(CURSO: ".$_REQUEST["referencia"]."): ".$_REQUEST["C_nombre"].' '.$_REQUEST["C_apellidos"]."\n\n";
$cuerpoComercial = "=== SOLICITANTE  ===================================================\n";
$cuerpoComercial .= "NOMBRE: ".$_REQUEST["C_nombre"].' '.$_REQUEST["C_apellidos"]."\n";
$cuerpoComercial .= "EMAIL: ".$_REQUEST["C_email"]."\n";
$cuerpoComercial .= "TELÉFONO: ".$tfnCliente."\n";
$cuerpoComercial .= "OBSERVACIONES: ".$commentCliente."\n";
$cuerpoComercial .= "=== CURSO  ===========================================================\n";
$cuerpoComercial .= "REFERENCIA CURSO: ".$rowRegistros['referencia']." ID CURSO: ".$rowRegistros['id']."\n";
$cuerpoComercial .= "TÍTULO: ".$rowRegistros['titulo_corto']."\n";
$cuerpoComercial .= "CIUDAD: ".$rowRegistros['ciudad'].' - '.$rowRegistros['pais']."\n";
$cuerpoComercial .= "FECHA: ".$rowRegistros['fecha_ini'].' a '.$rowRegistros['fecha_fin']."\n";
$cuerpoComercial .= "PRECIO: ".$rowRegistros['precio']."\n";
$cuerpoComercial .= "===================================================================\n\n";
$cuerpoComercial .= "El cliente tiene mail de solicitud, pero NO mail automático de inscripción. No se forma de pago, ... condiciones de inscripción\n";
$cuerpoComercial .= "LLamar o escribir al cliente para confirmar su inscripción. \n"; 
?>

<!--Sección de datos encontrados----------------------------------------------------------------------->

<section class="contenedor">
        <h1 class ="tituloApartado">Confirmación de inscripción curso Cype</h1>
 
 
  <div class="ficha">
     <div class="ficha_fila">
          Bienvenido/a <?php echo $_REQUEST["C_nombre"].' '.$_REQUEST["C_apellidos"]; ?> 
		  <?php
              if ($mensajeDeRepeticion <> "") {
			     echo '<p>'.$mensajeDeRepeticion.'</p>';
		      }
			  if ($mensajeWarning <> "") {
			     echo '<p>'.$mensajeWarning.'</p>';
		      }
		   ?>
		  
     </div>

     <div class="ficha_fila">
          <center><span class = "tituloApartadoAzul">
          <?php
          if ( $cursoVencido == 1) {
             echo ("El curso ya está finalizado");
          } else {
			 echo ("Gracias por inscribirte"); 
		  }
          ?>
          </span></center>
     </div>
     <div class="FichaConfirmación">

 
  
    <div class="ficha_fila">
             
             <div class="celdaConfirmaIzda">
                Curso
             </div>   <!-- end .celda_10_izda -->  
             <div class="celdaConfirmaDecha">
                <?php echo $rowRegistros['titulo_corto'];  ?>
             </div>     <!-- end .celda_90_decha -->
    </div>    <!-- end .ficha_fila -->



    <div class="ficha_fila">
             
             <div class="celdaConfirmaIzda">
                Ciudad
             </div>   <!-- end .celda_10_izda -->  
             <div class="celdaConfirmaDecha">
                <?php echo $rowRegistros['ciudad'].' ('.$rowRegistros['pais'].')';  ?>
             </div>     <!-- end .celda_90_decha -->
    </div>    <!-- end .ficha_fila -->

    <div class="ficha_fila">
             
             <div class="celdaConfirmaIzda">
                Lugar
             </div>   <!-- end .celda_10_izda -->  
             <div class="celdaConfirmaDecha">
                <?php echo $rowRegistros['lugar'];  ?>
             </div>     <!-- end .celda_90_decha -->
    </div>    <!-- end .ficha_fila -->
  
  
    <div class="ficha_fila">
             
             <div class="celdaConfirmaIzda">
                Dirección
             </div>   <!-- end .celda_10_izda -->  
             <div class="celdaConfirmaDecha">
                <?php echo $rowRegistros['direccion'];  ?>
             </div>     <!-- end .celda_90_decha -->
    </div>    <!-- end .ficha_fila -->
  
  
  
    <div class="ficha_fila">
             
             <div class="celdaConfirmaIzda">
                <?php 
				if ($rowRegistros['fecha_ini'] <> $rowRegistros['fecha_fin'] && $rowRegistros['fecha_fin'] > '0000-00-00') {
				  echo 'Dias';
				} else {
					echo 'Dia';
				}
			   ?>
             </div>   <!-- end .celda_10_izda -->  
             <div class="celdaConfirmaDecha">
                 <?php 
				if ($rowRegistros['fecha_ini'] <> $rowRegistros['fecha_fin'] && $rowRegistros['fecha_fin'] <> '0000-00-00') {
				  echo 'De '.$rowRegistros['fecha_ini'].' a '.$rowRegistros['fecha_fin'];
				} else {
					echo $rowRegistros['fecha_ini'];
				}
			   ?>
             </div>     <!-- end .celda_90_decha -->
    </div>    <!-- end .ficha_fila -->
        <div class="ficha_fila">
             
             <div class="celdaConfirmaIzda">
                Hora
             </div>   <!-- end .celda_10_izda -->  
             <div class="celdaConfirmaDecha">
                <?php echo $rowRegistros['horario'];  ?>
             </div>     <!-- end .celda_90_decha -->
    </div>    <!-- end .ficha_fila -->
  
  
    
    
    
    
  </div><!-- end .FichaConfirmación -->    
    
     <div class="ficha_fila">
     <?php
	  if ( date("Y-m-d") > $rowRegistros['fecha_fin']  && date("Y-m-d") > $rowRegistros['fecha_ini']) {
		  echo "Consulte los cursos disponibles en nuestra aula Cype"; 
	  } else {
		  if ($mensajeDeRepeticion == "") {
		      echo "En breve nos pondremos en contacto "; 
		  }
	  }
	 
	 ?>
          
     </div>
     <div class="ficha_fila">
         <span class="textoAzul"><?php echo $rowRegistros['pers_contacto'];  ?></span>
     </div>
  </div><!-- end .ficha -->
</section><!-- end .contenedor -->
<?php 
} // de while
/////////// aqui actualizamos fecha de inscripción y enviamos correo al comercial del curso





if ($mensajeDeRepeticion == "") {

   $FormatMaestros = 'update alumnosinscritos set fecha_inscripcion = sysdate() where id= %d';
   $queMaestros = sprintf($FormatMaestros, $idRegistro);
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
//.......carta al organizador.....................................................................
    
	mail($mailOrganizador,$titulocorreo,$cuerpoComercial);                     


}
} else {         // .........................................de datos encontrados, sin errores de vencido ni noactivo seguidamente viene la seccion NO encontrado
?> 
<section class="contenedor">
        <h1 class ="tituloApartado"><span class = "rojo">Error en inscripción curso Cype</span></h1>
  <div class="ficha">
     <div class="ficha_fila">
          <p>Bienvenido/a <?php echo $_REQUEST["C_nombre"].' '.$_REQUEST["C_apellidos"]; ?> 
          </p>
          
     </div>
     <div class="ficha_fila">
     <?php
        $mensajeAlCliente = "No hemos encontrado tu referencia en nuestra base de datos";
        if ($cursoActivo < 1){
			$mensajeAlCliente = "El curso ha sido retirado del catálogo, le pedimos disculpas.";
		}
        if ($cursoVencido == 1){
			$mensajeAlCliente = "El curso ya ha finalizado";
		}
		echo "<strong>".$mensajeAlCliente."</strong><p></p>";      
       ?>   
     </div>
     
   <?php if($cursoActivo > 0 && $cursoVencido == 0) { ?>     
       <div class="ficha_fila">
       Relacionamos el curso al que intentas inscribirte: Si sigues interesado <span class = "rojo">Pulsa sobre él</span> para cursar de nuevo tu solicitud de inscripción
          <p></p>
     </div>
     <center><span class ="textoAzul">Curso</span></center>
      <?php
	     $pagina = "ListaWebCursos.php?K_idCurso=".$_REQUEST["C_idCurso"];
	 ?>
     <iframe src="<?php echo $pagina?>" style="width:100%;height:100px"></iframe>
     
       <div class="ficha_fila">
       
      Puedes ver aquí nuestro <a href="CYPE.php">calendario de cursos</a>
      Si el problema persiste puede entrar en nuestra <a href="contacto.php">sección Contacto</a> y enviar un correo electrónico a nuestro departamento técnico.
     </div>
     
<?php } else { ?>        
     
     <div class="ficha_fila">
            <article><h1 class = "tituloApartadoAzul">Calendario de cursos</h1>
            <center><span class ="textoAzul">Relacionamos los cursos disponibles, pulse sobre uno de ellos para obtener más información.</span></center>
          <p></p>
     </div>
     <?php
         include_once('ListaWebCursos.php');
     ?>
     
<?php } ?>       
     
     

</div>
</section>

<?php 
}       // de datos encontrados
?> 
<div class="clear"></div>
<div class="centro90"><?php include_once('PaginaPieNOIndex.php'); ?></div>

<div class = "Aviso"></div>

</body>




</html>
