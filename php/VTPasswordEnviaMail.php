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
 //.........LA SELECT DE BBDD.............................SIEMPRE ID_CURSO = 3 QUE SON consultas generales "WHERE cursos.ID=1"
 $FormatMaestros = "SELECT  email
                    FROM vtalumnos
				    WHERE UPPER(email) = UPPER('%s') ";
$queMaestros = sprintf($FormatMaestros,$_REQUEST['usuario']); 
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
$totMaestros = mysqli_num_rows($resMaestros);

if ($totMaestros == 1) {
       //....correo para el cliente...................................................................
	   
	   //echo " hemos encontrado el e-mail";
	   
      while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
          $mail = new PHPMailer();
		  
		  
		  //echo "****hacecmos new()*****";
		  
		  
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

          $mail->From = $rowRegistros['email'];
          $mail->AddAddress($_POST['email'], "" );
          $mail->Subject = 'Password' ;
          $mail->AltBody = 'Para ver este correo utilice un programa con compatibilidad HTML'; // optional - MsgHTML will create an alternate automatically
          $mail->MsgHTML($_POST['bodyCarta']);
//echo "****llegamos a 22222*****";	  
          $exito = $mail->Send();
//echo "****llegamos a 3333333*****";		  
          $intentos=1; 
          while ((!$exito) && ($intentos < 5)) {
        	sleep(5);
            	//echo $mail->ErrorInfo;
            	$exito = $mail->Send();
            	$intentos=$intentos+1;	
          }
 //echo "****llegamos a 44444444*****";	        
             if(!$exito) {
       	       echo "ERROR:".$mail->ErrorInfo;
             } else {	
			   echo "OK";
			   exit;
			 } //....else de éxito en correo anterior
        } 	// de while registros  
} else {
 echo "ERROR: No se ha encontrado el alumno";
}
?>
