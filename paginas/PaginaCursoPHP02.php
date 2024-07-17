<?php
if (strlen($txtCertificado) > 0) {
    if ($_SESSION['ver_curso'] == 1) {
	   $estadoCertif = EstadoCertificado($conexion);
	   
       switch ($estadoCertif) {
       case 0:
	   	   
        echo "<br/><b>Fecha inicio del curso</b>: ".FechaInicioPermiso($conexion)."<br><br>Solicita tu certificado una vez hayas realizado el modelo propuesto: Puedes ver el procedimiento al final de esta página.";
		
        break;
       case 1:
	   
        echo "<br>Recibimos tu solicitud de certificado del curso el día: ".FechaSolicitudCertificado($conexion).". En breve te respondemos.";

        break;
       case 2:
        echo "<br>Nos consta haberte enviado el certificado del curso el día: ".FechaEntregaCertificado($conexion);
        break;
        }
    } // de ver curso == 1
} // de certificado informado
?>