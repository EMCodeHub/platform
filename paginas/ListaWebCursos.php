<?php
  session_start();
  include_once('../conexion/conn_bbdd.php');
 include_once('NewWebEstilosNOIndex.php');

?>
<script> 
  function AbreLaVentana(numero){
	    URL = "../paginas/FichaDelCurso.php?NumeroCurso="+numero;
		window.open(URL,"Ficha Curso","width=1000,height=800,scrollbars=YES,resizable=YES,LEFT=200,TOP=50") 	
  }

function entraReg(reg){
  
  reg.style.backgroundColor ='#FFFFEF';
}
function salReg(reg){
  
  reg.style.backgroundColor='#41355b47';
}
</script>
 
<div class="FichaLista">
<div class="FichaListaFila" >
 <div class="FichaLista6CAB">Pais</div>
  <div class="FichaLista8TCAB">Ciudad</div>
  <div class="FichaLista8TCAB">Fecha</div>
  <div class="FichaLista10CAB">Tipo</div>
  <div class="FichaLista10CAB">Modalidad</div>
  <div class="FichaLista20CAB">Titulo Curso</div>
  <div class="FichaLista8CAB">Horas</div>
  <div class="FichaLista6CAB">Precio</div>
</div>

<?php

if ($_REQUEST["K_idCurso"] == 0) {
	
$FormatMaestros = "select A.id, A.referencia, A.esta_activo, A.fecha_ini,  A.id_organizador,  A.titulo_corto, A.id_tipocurso, A.id_modalidad,  A.id_periodicidad, 
 A.num_horas_curso,  A.precio, A.horario,B.id AS IDORGANIZADOR, B.pais, B.ciudad, C.id AS MODALIDAD_ID, C.descripcion AS MODALIDAD_DESCRI, D.id AS TIPO_ID, D.descripcion AS TIPO_DESCRI from cursos A, organizadores B, modalidadcurso C, tipocurso D where  A.esta_activo = 1 and    A.id_organizador = B.id and  A.id_modalidad = C.id and    A.id_tipocurso = D.id and (fecha_ini >= sysdate() or fecha_fin >= sysdate()) order by pais,ciudad,fecha_ini";
$queMaestros = sprintf($FormatMaestros);
} else {
$FormatMaestros = "select A.id, A.referencia, A.esta_activo, A.fecha_ini,  A.id_organizador,  A.titulo_corto, A.id_tipocurso, A.id_modalidad,  A.id_periodicidad, 
 A.num_horas_curso,  A.precio, A.horario,B.id AS IDORGANIZADOR, B.pais, B.ciudad, C.id AS MODALIDAD_ID, C.descripcion AS MODALIDAD_DESCRI, D.id AS TIPO_ID, D.descripcion AS TIPO_DESCRI from cursos A, organizadores B, modalidadcurso C, tipocurso D where  A.id = %d and A.esta_activo = 1 and    A.id_organizador = B.id and  A.id_modalidad = C.id and    A.id_tipocurso = D.id and (fecha_ini >= sysdate() or fecha_fin >= sysdate()) order by pais,ciudad,fecha_ini";
$queMaestros = sprintf($FormatMaestros,$_REQUEST["K_idCurso"]);
}
 $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
 $totMaestros = mysqli_num_rows($resMaestros);
 $contador = 0;
 while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
	 $complemento = "";
	 $contador++;
	 if ($contador % 2 == 0) {
		$complemento = "2"; 
	 }
	 
?>

<div class="FichaListaFila" onmouseover = "entraReg(this)" onmouseout="salReg(this)" onclick="AbreLaVentana(<?php echo ($rowRegistros['id']); ?>)">
  <div class="FichaLista6TXT<?php echo ($complemento); ?>"><?php echo ($rowRegistros['pais']); ?></div>
  <div class="FichaLista8TTXT<?php echo ($complemento); ?>"><?php echo ($rowRegistros['ciudad']); ?></div>
  <div class="FichaLista8TTXT<?php echo ($complemento); ?>"><?php echo ($rowRegistros['fecha_ini']); ?></div>
  <div class="FichaLista10TXT<?php echo ($complemento); ?>"><?php echo ($rowRegistros['TIPO_DESCRI']); ?></div>
  <div class="FichaLista10TXT<?php echo ($complemento); ?>"><?php echo ($rowRegistros['MODALIDAD_DESCRI']); ?></div>
  <div class="FichaLista20TXT<?php echo ($complemento); ?>"><?php echo ($rowRegistros['titulo_corto']); ?></div>
  <div class="FichaLista8TXT<?php echo ($complemento); ?>"><?php echo ($rowRegistros['horario']); ?></div>
  <div class="FichaLista6TXT<?php echo ($complemento); ?>"><?php echo ($rowRegistros['precio']); ?></div>
</div>

<?php
 }
?>

</div>  
<?php if ($_REQUEST["K_idCurso"] == 0) { ?>
   <div class="FichaListaFilaRaya">
   <p class="FichaListaFilaNota">Notas informativas</p>

   <ul>
   <li>Le sugerimos que se registre lo antes posible, dada la limitación de plazas.</li>
   <li>Si lo que desea es un curso personalizado para usted o su empresa puede ponerse en contacto con CYPE o con el distribuidor de su zona o país.</li>
   <li>También puede realizar su consulta o confirmación de asistencia contactando con nuestro Departamento Comercial en el teléfono: <span class = "textoAzul"><?php echo $DatosWeb->GetTrimValor('web_tfnWhatsapp') ?></span>    o enviando un correo electrónico a <span class = "textoAzul"><?php echo $DatosWeb->GetValor('CorreoPrincipal');
                   if ( DatoLleno($DatosWeb->GetValor('CorreoSecundario')) && $DatosWeb->GetValor('CorreoPrincipal') <> $DatosWeb->GetValor('CorreoSecundario')) {
                     echo  " / ".$DatosWeb->GetValor('CorreoSecundario'); 
                   }
             ?> </span></li>
  </ul>
  </div>
<?php  } ?>
