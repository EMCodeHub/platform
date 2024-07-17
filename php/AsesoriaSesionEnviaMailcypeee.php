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




//............obtener el correo comercial
/*$correoE = "";
$NombreCorreoE = "";
$FormatCorreo = "SELECT correoelectronico, nombre_correo  
                   FROM emailscomerciales 
                  WHERE tipocorreo = 1 limit 1";
$queCorreo = $FormatCorreo;
$resCorreo = mysqli_query($conexion, $queCorreo) or die(mysqli_error($conexion));
$totCorreo = mysqli_num_rows($resCorreo);

if ($totCorreo == 1) {
    while ($rowRegistros = mysqli_fetch_assoc($resCorreo)) {			  
			$correoE       =  $rowRegistros['correoelectronico'];
			$NombreCorreoE =  $rowRegistros['nombre_correo'];
	  }
}
mysqli_free_result($resCorreo);	*/

//.......salvamos el body a un fichero
      /* $fichero = "Borrame_cuanto_antes.html";
       $modo = "wb+";
       $file = fopen($fichero, $modo);
       fwrite($file, $_POST['BodyCarta']);
       fflush($file);
       fclose($file);
*/

 //.........LA SELECT DE BBDD.............................el principal de correoscomerciales
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
$titulocorreo  = "Solicitud Reserva LLAMADA: ".$_REQUEST["Nombre"].' '.$_REQUEST["Apellidos"]."\n\n";
$cuerpoComercial = "=== SOLICITANTE  ===================================================\n";
$cuerpoComercial .= "NOMBRE:   ".$_REQUEST["Nombre"].' '.$_REQUEST["Apellidos"]."\n";
$cuerpoComercial .= "EMAIL:    ".$_REQUEST["Correo"]."\n";
$cuerpoComercial .= "TELÉFONO: ".$_REQUEST["Telefono"]."\n";
$cuerpoComercial .= "SKYPE:    ".$_REQUEST["UsuSkype"]."\n";              
$cuerpoComercial .= "CIUDAD:   ".$_REQUEST["Ciudad"]."\n";          
$cuerpoComercial .= "PAIS:     ".$_REQUEST["Pais"]."\n";
$cuerpoComercial .= "=== RESERVA  ===========================================================\n";
$cuerpoComercial .= "DÍA:      ".$_REQUEST["Dia"]." HORA: ".$_REQUEST["Hora"]."\n";
$cuerpoComercial .= "===================================================================\n\n";
$cuerpoComercial .= "LLamar o escribir al cliente aportando más información o manifestando interés. \n"; 

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
		      $nombre_destinatario = $_POST['Nombre']." ".$_POST['Apellidos'];
          $mail->AddAddress($_POST['Correo'], $nombre_destinatario );
          $mail->Subject = 'CONFIRMAR la Reserva de Llamada' ;
          $mail->AltBody = 'Para ver este correo utilice un programa con compatibilidad HTML'; // optional - MsgHTML will create an alternate automatically
          $mail->MsgHTML($_POST['BodyCarta']);
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
					          echo "OK";
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
