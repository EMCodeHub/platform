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


$FormatMaestros = "SELECT id AS IDEMAIL, correoelectronico , nombre_interno , nombre_correo , es_smtp , 
                           es_pop3 , servidor , puerto , seguridad , requiere_auth , usuario , password , usa_logo , fichero_logo   
                      FROM emailscomerciales  
                     WHERE tipocorreo = 1 limit 1";
$queMaestros = $FormatMaestros; 
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
$totMaestros = mysqli_num_rows($resMaestros);

if ($totMaestros == 1) {
	
       //....correo para el cliente...................................................................
          while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
 			  //........datos para el comercial
              $mailOrganizador = $rowRegistros['correoelectronico'];
              $titulocorreo  = "Solicitud REEMBOLSO: ".$_REQUEST["nombre"].' '.$_REQUEST["apellidos"]."\n\n";
              $cuerpoComercial = "=== SOLICITANTE  ===================================================\n";
              $cuerpoComercial .= "NOMBRE:   ".$_REQUEST["nombre"].' '.$_REQUEST["apellidos"]."\n";
              $cuerpoComercial .= "EMAIL:    ".$_REQUEST["email"]."\n";
              $cuerpoComercial .= "TELÉFONO: ".$_REQUEST["telefono"]."\n";             
              $cuerpoComercial .= "CIUDAD:   ".$_REQUEST["ciudad"]."\n";          
              $cuerpoComercial .= "LLamar o escribir al cliente contestando a su petición. \n"; 

              //... fin comercial

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
          $mail->Subject = 'Hemos recibido su solicitud de reembolso';
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
			      }        //....else de éxito en correo anterior
  } 	// de while registros  
  
     
} else {
 echo "ERROR: Registros encontrados = ".$totMaestros;
}

?>
