<?php
session_start();
include_once('../conexion/conn_bbdd.php');
require_once('../_lib/PHPMailer/PHPMailer.php');
require_once('../_lib/PHPMailer/POP3.php');
require_once('../_lib/PHPMailer/SMTP.php');
require_once('../_lib/PHPMailer/Exception.php');
require_once('../_lib/PHPMailer/OAuth.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\POP3;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
//.....obtener el correo secundario para no inundar de emails el correo principal 
$MailSecundario = "";
			$FormatCorreo2 = "SELECT  correoelectronico 
			                  FROM emailscomerciales  
			                 WHERE tipocorreo = 3";  
      $queCorreo2 = sprintf($FormatCorreo2);
      $resCorreo2 = mysqli_query($conexion, $queCorreo2) or die(mysqli_error($conexion)); 
      $totCorreo2 = mysqli_num_rows($resCorreo2);     

	    while ($rowCorreo2 = mysqli_fetch_assoc($resCorreo2)) {
         $MailSecundario = $rowCorreo2['correoelectronico'];  
      }
      mysqli_free_result($resCorreo2); 
 
 //.........LA SELECT DE BBDD.............................SIEMPRE ID_CURSO = 3 QUE SON consultas generales "WHERE cursos.ID=1"
 $FormatMaestros = "SELECT A.id_curso,  A. id_mailcomer, A.programaPDF, A.carpetadeficheros, A.web_titulo, A.preciotutorial,  
B.id AS IDEMAIL, B.correoelectronico , B.nombre_interno , B.nombre_correo , B.es_smtp , 
B.es_pop3 , B.servidor , B.puerto , B.seguridad , B.requiere_auth , B.usuario , B.password , B.usa_logo , B.fichero_logo   
from vtcursos A, emailscomerciales B 
where A.id_mailcomer = B.id
and A.id_curso = %d
";
$queMaestros = sprintf($FormatMaestros,$_REQUEST['NumIdCurso']); 
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
$totMaestros = mysqli_num_rows($resMaestros);
if ($totMaestros == 1) {
       //....correo para el cliente...................................................................
          while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
			  
			  
			  	    //........datos para el comercial
$mailOrganizador = $MailSecundario;
$titulocorreo  = "Información VIDEOTUTORIAL: ".$_REQUEST["nombre"].' '.$_REQUEST["apellidos"]."\n\n";
$cuerpoComercial = "=== SOLICITANTE  ===================================================\n";
$cuerpoComercial .= "NOMBRE:   ".$_REQUEST["nombre"].' '.$_REQUEST["apellidos"]."\n";
$cuerpoComercial .= "EMAIL:    ".$_REQUEST["email"]."\n";
$cuerpoComercial .= "TELÉFONO: ".$_REQUEST["telefono"]."\n";
$cuerpoComercial .= "PAIS:     ".$_REQUEST["ciudad"]."\n";
$cuerpoComercial .= "=== CURSO  ===========================================================\n";
$cuerpoComercial .= "CURSO: ".$rowRegistros['web_titulo']."\n";
$cuerpoComercial .= "===================================================================\n\n";
$cuerpoComercial .= "LLamar o escribir al cliente aportando más información o manidestando interés. \n"; 

//... fin comercial

          		 $programaCurso = "../VIDEOTUTORIALES/".$rowRegistros['carpetadeficheros']."/".$rowRegistros['programaPDF'];
          
  
          $mail = new PHPMailer();
          $mail->IsHTML(true);
          $mail->CharSet = 'UTF-8';
          if ($rowRegistros['es_smtp'] > 0) {
            $mail->IsSMTP();
            $mail->Host       = $rowRegistros['servidor'];        // SMTP server
       	  if ($rowRegistros['requiere_auth'] == 1) {
                $mail->SMTPAuth   =  true;                  // enable SMTP authentication
       	  }
            $mail->SMTPSecure = $rowRegistros['seguridad'];  //... ssl
            $mail->Port       = $rowRegistros['puerto'];
            $mail->Username   = $rowRegistros['usuario']; // SMTP account username 
            $mail->Password   = $rowRegistros['password'];        // SMTP account password
          }
                    	          
          if ($rowRegistros['es_pop3'] > 0) {
               $mail->Port       = $rowRegistros['puerto'];
               $mail->Username   = $rowRegistros['usuario']; // SMTP account username 
               $mail->Password   = $rowRegistros['password'];        // SMTP account password
          }


          $mail->From = $rowRegistros['correoelectronico'];
          $mail->AddReplyTo($rowRegistros['correoelectronico'], $rowRegistros['nombre_correo']);
          $mail->FromName = $rowRegistros['nombre_correo'];
		      $nombre_destinatario = $_POST['nombre']." ".$_POST['apellidos'];
          $mail->AddAddress($_POST['email'], $nombre_destinatario );
          $mail->Subject = 'CONFIRMAR la inscripción al curso' ;
          $mail->AltBody = 'Para ver este correo utilice un programa con compatibilidad HTML'; // optional - MsgHTML will create an alternate automatically
          $mail->MsgHTML($_POST['bodyCarta']);
          if (strlen(programaCurso) > 0){
            $mail->AddAttachment($programaCurso);
		  }
       
          $exito = $mail->Send();
          $intentos=1; 
          while ((!$exito) && ($intentos < 5)) {
        	sleep(5);
            	//echo $mail->ErrorInfo;
            	$exito = $mail->Send();
            	$intentos=$intentos+1;	
          }
         
             if(!$exito) {
       	       echo "ERROR:".$mail->ErrorInfo;
             } else {		  
			    //..........enviar el correo al comercial......................
				$headers = "MIME-Version: 1.0\r\n"; 
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
                if (mail($mailOrganizador,$titulocorreo,$cuerpoComercial,$headers)) {
			      echo "OK";  //........................................OJO diría que está corregido, aquí es ok un OK!!!!!       
				} else {
					echo "NO-OK";
					/*echo $mailOrganizador."#";
					echo $titulocorreo."#";
					echo $cuerpoComercial;*/
				}
			 } //....else de éxito en correo anterior
  } 	// de while registros  
  
     
} else {
 echo "ERROR: Registros encontrados = ".$totMaestros;
}
?>
