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
//..............................................................


//..............................................................usamos tipocorreo = 1
$FormatMaestros = "SELECT correoelectronico, es_smtp, es_pop3, servidor,requiere_auth, seguridad, puerto, usuario, password, nombre_correo
			         FROM emailscomerciales  
			        WHERE tipocorreo = 1 limit 1";
       $queMaestros = $FormatMaestros; 
       $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
       $totMaestros = mysqli_num_rows($resMaestros);
if ($totMaestros == 1) {
       
     while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
  
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
		  $nombre_destinatario = "";
          $mail->AddAddress($_POST['email'], $nombre_destinatario );
          $mail->Subject = 'Abono de servicios' ;
          $mail->AltBody = 'Para ver este correo utilice un programa con compatibilidad HTML'; // optional - MsgHTML will create an alternate automatically
          $mail->MsgHTML($_POST['bodyCarta']);
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
             	   	$FormatUpdate = "UPDATE vtsolcobro SET f_mail = CURDATE() WHERE id = %d"; 
                    $queUpdate = sprintf($FormatUpdate,$_POST['id'] ); 
                    $resUpdate = mysqli_query($conexion, $queUpdate) or die(mysqli_error($conexion));
	  
			           echo "OK";
             } //....else de éxito en correo anterior
  } 	// de while registros  
  
     
} else {
 echo "ERROR: No encontrado correo comercial --> tipocorreo = 1";
}

?>
