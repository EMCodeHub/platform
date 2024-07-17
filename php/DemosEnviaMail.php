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


 //.........LA SELECT DE BBDD.............................SIEMPRE ID_CURSO = 1 QUE SON PRESUPUESTOS "WHERE cursos.ID=1"
 $FormatMaestros = "SELECT A.id,  A. id_mailcomer,
B.id AS IDEMAIL, B.correoelectronico , B.nombre_interno , B.nombre_correo , B.es_smtp , 
B.es_pop3 , B.servidor , B.puerto , B.seguridad , B.requiere_auth , B.usuario , B.password , B.usa_logo , B.fichero_logo   
from cursos A, emailscomerciales B 
where A.id_mailcomer = B.id
and A.id = 2
";
$queMaestros = sprintf($FormatMaestros); 
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
$totMaestros = mysqli_num_rows($resMaestros);

if ($totMaestros == 1) {
	
       //....correo para el cliente...................................................................
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
		      $nombre_destinatario = $_POST['nombre']." ".$_POST['apellidos'];
          $mail->AddAddress($_POST['email'], $nombre_destinatario );
          $mail->Subject = 'Medif: Solicitud DEMO software CYPE';
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
			       //......................................correo para Medif...........................................................................
             $mail->Subject = '(DEMO) Carta al cliente:'.$_POST['nombre']." ".$_POST['apellidos'];
			       $mail->ClearAllRecipients();		
		         $mail->AddAddress($rowRegistros['correoelectronico'], $rowRegistros['nombre_correo'] );
			       $mail->From = "medif@medifestructuras.com";
			       $mail->FromName = "medifestructuras.com";
			       $mail->IsSMTP();
			       $mail->ReplyTo    = "medif@medifestructuras.com";         //...añadido 2015-03-30
             $mail->Host       = "smtp.medifestructuras.com";        // SMTP server
             $mail->SMTPAuth   =  true;                  // enable SMTP authentication
             $mail->SMTPSecure = "ssl";  //... ssl
             $mail->Port       = 465;
             $mail->Username   = "medif@medifestructuras.com"; // SMTP account username 
             $mail->Password   = "EduM2015";        // SMTP account password
 			 
			 
			 
  } // de while registros
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
       	       echo "OK";  //........................................OJO diría que está corregido, aquí es ok un OK!!!!!
		  }
  } //....else de éxito en correo anterior	     
} else {
 echo "ERROR: Registros encontrados = ".$totMaestros;
}





?>
