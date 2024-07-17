<?php
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
//....obtenemos el id del alumno de pruebas para añadirlo al final de cada lote y poder comprobar si se envía cada lote

function EnviaMail($Pasunto,$PidAlumno,$PafegirNom,$PidCarta,$PbodyCarta,$conexion){ 

//................datos del alumno..............................................
   $correoAlumno = "";
   $nombreAlumno = "";
   $apellidosAlumno = "";
   $idAlumno = 0;
   $asunto = $Pasunto;
      $FormatCorreo2 = "SELECT id, email, nombre, apellidos FROM vtalumnos WHERE id = %d";  
      $queCorreo2 = sprintf($FormatCorreo2,$PidAlumno);
      $resCorreo2 = mysqli_query($conexion, $queCorreo2) or die(mysqli_error($conexion)); 
      $totCorreo2 = mysqli_num_rows($resCorreo2);     
      while ($rowCorreo2 = mysqli_fetch_assoc($resCorreo2)) {
            $idAlumno        = $rowCorreo2['id'];
            $correoAlumno    = $rowCorreo2['email'];
            $nombreAlumno    = $rowCorreo2['nombre'];
            $apellidosAlumno = $rowCorreo2['apellidos'];
      }
      mysqli_free_result($resCorreo2); 
      if ($nombreAlumno == ""){
          $nombreAlumno = "Alumno";
      }
  if ($PafegirNom == 1){
      $asunto = $asunto." ".$nombreAlumno;
  }


 //.........tipocorreo=3 , EL QUE HACE LOS ENVÍOS MASIVOS
 $FormatMaestros = "SELECT id , correoelectronico , nombre_interno , nombre_correo , es_smtp , 
                           es_pop3 , servidor , puerto , seguridad , requiere_auth , usuario , password , usa_logo , fichero_logo   
                      FROM emailscomerciales 
                     WHERE tipocorreo = 3";
$queMaestros = $FormatMaestros; 
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
		  $nombre_destinatario = $nombreAlumno." ".$apellidosAlumno;
          $mail->AddAddress($correoAlumno, $nombre_destinatario );
          $mail->Subject = $asunto ;
          $mail->AltBody = 'Para ver este correo utilice un programa con compatibilidad HTML'; // optional - MsgHTML will create an alternate automatically
          $mail->MsgHTML($PbodyCarta); 
          //$exito = true;         //.....................OJO SI PRODUCCIÓN o PRUEBAS
          $exito = $mail->Send(); //.....................OJO SI PRODUCCIÓN o PRUEBAS

          $intentos=1; 
          while ((!$exito) && ($intentos < 5)) {
        	sleep(5);
            	//echo $mail->ErrorInfo;
                $exito = $mail->Send(); //.....................OJO SI PRODUCCIÓN o PRUEBAS
            	$intentos=$intentos+1;	
          }
          if(!$exito) {
       	       return "ERROR:".$mail->ErrorInfo;
          } else {
               ActualizaFechaEnvio($PidCarta,$PidAlumno, $conexion);
               return "OK";
          }
  } 	// de while registros  
   
} else {
  return "ERROR: Registros encontrados = ".$totMaestros;
}

}



/////////////////////////////////////////////////////////////////
function ActualizaFechaEnvio($idCarta,$idAlumno,$conexion) {
    $FormatActualiza = "UPDATE vtcartasregistros
                           SET f_envio = CURRENT_TIMESTAMP
                         WHERE id_carta = %d  AND id_Alumno = %d";
    $queActualiza = sprintf($FormatActualiza, $idCarta, $idAlumno);
    $resActualiza = mysqli_query($conexion, $queActualiza) or die(mysqli_error($conexion));  
    mysqli_free_result($resActualiza); 
    
    $FormatActualiza = "UPDATE vtcartascabecera
                           SET f_ultimoenvio = CURRENT_TIMESTAMP
                         WHERE id = %d";
    $queActualiza = sprintf($FormatActualiza, $idCarta);
    $resActualiza = mysqli_query($conexion, $queActualiza) or die(mysqli_error($conexion));  
    mysqli_free_result($resActualiza);     
}
?>
