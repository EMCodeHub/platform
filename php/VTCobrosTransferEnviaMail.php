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
//..............................................averiguar antes si ya hemos enviado la carta de transferencias









 //.........LA SELECT DE BBDD.............................
 $FormatMaestros = "SELECT A.id_curso,  A. id_mailcomer, A.programaPDF, A.carpetadeficheros, A.titulo_cur, A.preciotutorial,  
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
			  
			  
/*			  	    //........datos para el comercial
		$mailOrganizador = $rowRegistros['correoelectronico'];
$titulocorreo  = "Información VIDEOTUTORIAL: ".$_REQUEST["nombre"].' '.$_REQUEST["apellidos"]."\n\n";
$cuerpoComercial = "=== SOLICITANTE  ===================================================\n";
$cuerpoComercial .= "NOMBRE: ".$_REQUEST["nombre"].' '.$_REQUEST["apellidos"]."\n";
$cuerpoComercial .= "EMAIL: ".$_REQUEST["email"]."\n";
$cuerpoComercial .= "TELÉFONO: ".$_REQUEST["telefono"]."\n";
$cuerpoComercial .= "CIUDAD: ".$_REQUEST["ciudad"]."\n";
$cuerpoComercial .= "OBSERVACIONES: ".$_REQUEST["comentarios"]."\n";
$cuerpoComercial .= "=== CURSO  ===========================================================\n";
$cuerpoComercial .= "CURSO: ".$rowRegistros['titulo_cur']."\n";
$cuerpoComercial .= "PRECIO: ".$rowRegistros['preciotutorial']."\n";
$cuerpoComercial .= "===================================================================\n\n";
$cuerpoComercial .= "LLamar o escribir al cliente aportando más información o manidestando interés. \n"; 

*/ 
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
		      $nombre_destinatario = " ";  //..... no lo sabemos, sólo ha dado su mail
          $mail->AddAddress($_POST['email'], $nombre_destinatario );
          $mail->Subject = 'Solicitud información VideoTutorial' ;
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
             echo "OK"; 
			 } //....else de éxito en correo anterior
  } 	// de while registros  
     
} else {
 echo "ERROR: Registros encontrados = ".$totMaestros;
}
?>
