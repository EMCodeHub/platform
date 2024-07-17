
<?php
session_start();

$url_formulario = "https://medifestructuras.com/paginas/ConfirmacionInscripcion.php?C_idCurso=".rawurlencode($_REQUEST['NumIdCurso']);
$url_formulario .= "&C_nombre=".rawurlencode($_REQUEST['nombre']);
$url_formulario .= "&C_apellidos=".rawurlencode($_REQUEST['apellidos']);
$url_formulario .= "&C_email=".rawurlencode($_REQUEST['email']);
$url_formulario .= "&C_fechaMail=".date("Y-m-d");
?>
<!doctype html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Documento sin título</title>
</head>

<body>

<?php
include_once('../conexion/conn_bbdd.php');
$FormatCarta = "select A.id, A.referencia, A.esta_activo, A.fecha_ini,  A.fecha_fin,  A.ponente,  A.id_mailcomer,  A.id_organizador, A.titulo_abreviado, A.titulo_corto, A.titulo_largo, A.id_tipocurso, A.id_modalidad, A.id_periodicidad, A.horario, 
A.num_horas_curso, A.programas_utili, A.precio, A.forma_pago, A.plazas_aprox, A.programa_pdf, A.documentos_pdf, A.observaciones, B.id AS IDORGANIZADOR, B.descripcion_interna, B.nombre_organizador, B.pais, B.ciudad, B.lugar, B.direccion, B.pers_contacto, 
B.tfn_contacto, C.id AS MODALIDAD_ID, C.descripcion AS MODALIDAD_DESCRI, D.id AS TIPO_ID, D.descripcion AS TIPO_DESCRI, E.id AS PERIODO_ID, E.descripcion AS PERIODO_DESCRI, F.correoelectronico, F.nombre_correo  
from cursos A, organizadores B, modalidadcurso C, tipocurso D, periodocursos E , emailscomerciales F
where  A.id = %d and  A.id_organizador = B.id and  A.id_modalidad = C.id and  A.id_tipocurso = D.id and A.id_periodicidad = E.id and A.id_mailcomer = F.id";

 $queCarta = sprintf($FormatCarta,$_REQUEST['NumIdCurso']);
 $resCarta = mysqli_query($conexion, $queCarta) or die(mysqli_error($conexion));
 $totCarta = mysqli_num_rows($resCarta);
 
 if ($totCarta> 0) { 

 while ($rowRegistros = mysqli_fetch_assoc($resCarta)) {

?>




<table width="100%" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px">
  <tr>
    <td width="6%" rowspan="6"><img src="https://medifestructuras.com/imagenes/logos/LogoMedif.jpg" width="66" height="100"></td>
    <td width="1%" rowspan="6">&nbsp;</td>
    <td width="93%">&nbsp;</td>
  </tr>
  <tr>
    <td>CONSULTORIA Y DISEÑO DE ESTRUCTURAS</td>
  </tr>
  <tr>
    <td>Calle 6 de Diciembre y Bosmediano</td>
  </tr>
  <tr>
    <td>Torres del Norte. Junto CNE. Departamento 3B</td>
  </tr>
  <tr>
    <td>Quito </td>
  </tr>
  <tr>
    <td>
      <hr style="color: #0056b2;" />
    </td>
  </tr>
</table>

<br>
  

<table width="97%" border="0">
  <tr>
    <td width="79%">
    Estimado <?php echo $_POST['nombre']." ".$_POST['apellidos'] ;?>
    <p>Hemos recibido su solicitud de inscripción al curso:  </p>
 
    <p style="font-family:Arial, Helvetica, sans-serif;font-weight:bold;font-size:1em;color:#03F" ><?php echo $rowRegistros['titulo_corto'] ;?></p>
    <BR>
    </td>
    <td width="21%">
        <img src="https://medifestructuras.com/imagenes/CursoCypeCarta.jpg" width="240" height="100">
    </td>
  </tr>
</table>  
  
  
  

<table width="97%" border="1">
  <tr>
    <td width="15%">&nbsp;</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><a href="<?php echo $url_formulario ;?>"><strong>Para confirmar su inscripción pulse este enlace</strong></a></td>
  </tr>

  <tr>
    <td width="15%"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Referencia</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['referencia']; ?></td>
  </tr>
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Ciudad</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['ciudad'].' ('.$rowRegistros['pais'].')'; ?></td>
  </tr>

  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Lugar</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['lugar']; ?></td>
  </tr>
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Dirección</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['direccion']; ?></td>
  </tr>
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Teléfono</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['pers_contacto'].' Tfn: '.$rowRegistros['tfn_contacto']; ?></td>
  </tr>
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Tipo</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['TIPO_DESCRI']; ?></td>
  </tr>
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Modalidad</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['MODALIDAD_DESCRI']; ?></td>
  </tr>
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Periodicidad</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['PERIODO_DESCRI']; ?></td>
  </tr>
<?php  if ($rowRegistros['num_horas_curso'] > 0) { ?>
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Total horas</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['num_horas_curso']; ?></td>
  </tr>
<?php  } ?>

<?php  if ($rowRegistros['plazas_aprox'] > 0) { ?>
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Plazas aprox.</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['plazas_aprox']; ?></td>
  </tr>
<?php  } ?>

<?php  if ($rowRegistros['precio'] != "" ) { ?>
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Precio</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['precio']; ?></td>
  </tr>
  <?php  } ?>
 <?php  if ($rowRegistros['forma_pago'] != "" ) { ?> 
    <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Forma de pago</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['forma_pago']; ?>@</td>
  </tr>
   <?php  } ?> 
  
  <tr>
    <td rowspan="2"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Agenda</td>
    <td width="22%"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:center;padding-right:0.2em; vertical-align:top">Día</td>
    <td width="15%"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:center;padding-right:0.2em; vertical-align:top">Horario</td>
    <td width="48%"  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:center;padding-right:0.2em; vertical-align:top">Título</td>
  </tr>
    <tr>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top">
	<?php echo $rowRegistros['fecha_ini']; 
	if ($rowRegistros['fecha_fin'] > "0001-01-01" && $rowRegistros['fecha_fin'] != $rowRegistros['fecha_ini'] ){
		 echo ' - '.$rowRegistros['fecha_fin'];
	}
	?>
    </td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['horario']; ?></td>
    <td style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['titulo_largo']; ?></td>
  </tr>

  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Ponente</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['ponente']; ?></td>
  </tr>
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Entidad organizadora</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['nombre_organizador']; ?></td>
  </tr>
  
  <?php  if ($rowRegistros['observaciones'] != "" ) { ?> 
  <tr>
    <td  bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top"> Observaciones</td>
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;vertical-align:top"><?php echo $rowRegistros['observaciones']; ?></td>
  </tr>
 <?php } ?>
</table>




 <?php  if ($rowRegistros['forma_pago'] != "" ) { ?> 
       <p>Adjuntamos el programa del curso en formato PDF<br>
 <?php } ?>
</p>
<p>Para cualquier otra información puede visitar nuestra web: <a href="https://medifestructuras.com">medifestructuras.com</a> o bien responder a este correo
</p>
<p>Gracias por su confianza.</p>
<p>En breve nos pondremos en contacto con Ud.</p>
<p>&nbsp;</p>
<p>Atentamente,</p>
<p> <?php echo $_POST['Nombre_correo']; ?></p>
<p><br>
 

</body>
</html>
<?php } }?>