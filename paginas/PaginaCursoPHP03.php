<?php 
if (strlen($txtCertificado) > 0) {
echo '<div class="ficha"><div class="ficha_fila">';	
echo '<div class="celda_10_izda">&nbsp;</div>';
echo '<div class="celda_90_decha">';
    if ($_SESSION['ver_curso'] == 1) {
		   echo '<div class = "TituloModulo">'.'CERTIFICADO / EVALUACIÓN'."</div>";
	        $estadoCertif = EstadoCertificado($conexion);
       switch ($estadoCertif) {
       case 0:
           echo str_replace("\r\n","<br>",$txtProcEvaluacion)."<br><br><br>";  
        break;
       case 1:
           echo "Estamos estudiando tu modelo.";
        break;
       case 2:
          echo "Esperamos que los conocimientos adquiridos  sean de utilidad.<br>Si tienes alguna incidencia con el certificado notifícanos la incidencia.<br>Gracias por tu confianza. ";
        break;
        }
    } // de ver curso == 1
	
	echo "</div></div></div>";
} // de certificado informado
?>
