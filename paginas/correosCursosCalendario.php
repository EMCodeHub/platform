<?php
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
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

?>
<!DOCTYPE html>
<html lang="es">

<head>
<?php
$seleccione="Seleccione un curso";

function comas($cadena) {
	return "'".$cadena."'";
}
?>
<meta name="author" content="<?php echo $DatosWeb->GetTrimValor('NombrePrincipal'); ?>">
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1, user-scalable=yes" name="viewport"/>


<link rel="stylesheet" type="text/css" href="../css/EstiloBase.css">
<link rel="stylesheet" media="(min-width:419px) and (max-width:598px) and (orientation: landscape)" href="../css/Estilo_598_L.css">
<link rel="stylesheet" media="(min-width:419px) and (max-width:598px) and (orientation: portrait)" href="../css/Estilo_598_P.css">
<link rel="stylesheet" media="(max-width:419px) and (orientation: landscape)" href="../css/Estilo_419_L.css">
<link rel="stylesheet" media="(max-width:419px) and (orientation: portrait)" href="../css/Estilo_419_P.css">
												  


<title><?php echo $DatosWeb->GetTrimValor('web_dominio') ?> Solicitar información de cursos</title>
<!--   <link rel="shortcut icon" href="../../Iconos/rosca-1.ico" type="image/ico-icon">  -->



<SCRIPT LANGUAGE="JavaScript">
function borraCampos() {
	
	document.getElementById("nombre").value = "";
	document.getElementById("email").value = "";
	document.getElementById("apellidos").value = "";
	document.getElementById("telefono").value = "";
	document.getElementById("ciudad").value = "";
	document.getElementById("comentarios").value = "";
}

</script>
</head>
<body>
<?php 
$patronTelefono = "/^[[:digit:]]+$/";
$mensaje = '';  /* ojo */
$pintarFormulario = true;



if (!$_POST) {
     $pintarFormulario = true;	
} else {
	   if ( (strlen($_REQUEST['nombre']) >2)  and ( (strlen($_REQUEST['telefono']) >5 and preg_match($patronTelefono, $_REQUEST['telefono'])>0)  or (strlen($_REQUEST['email']) >5 and    strpos( $_REQUEST['email'],"@") == true) )  )  {
	    
	    
	    $pintarFormulario = false;	
    
    
    } else {
	   $pintarFormulario = true;
	   $mensaje = '<span class = "rojo">Indique datos de contacto</span>';	
	   if (strlen($_REQUEST['nombre']) <3) {
	    $mensaje = '<span class = "rojo">Indique su Nombre</span>';		
	   }
	   if (strlen($_REQUEST['telefono']) >0 and ((preg_match($patronTelefono, $_REQUEST['telefono']) < 1)  or (strlen($_REQUEST['telefono']) < 6)    ) ) {
	    $mensaje = '<span class = "rojo">Teléfono incorrecto</span>';		
	   }
	   if (strlen($_REQUEST['email']) > 0 and !strpos($_REQUEST['email'],"@") ) {
	    $mensaje = '<span class = "rojo">Mail incorrecto</span>';		
	   }
	   if ($_REQUEST['curso'] == $seleccione) {
	    $mensaje = '<span class = "rojo">Indique curso</span>';		
	   }
	   
	  /* $mensaje = "strlen--->".strlen($_REQUEST['telefono'])."   preg_match--->".preg_match($patronTelefono, $_REQUEST['telefono']);*/
	   
	}

}

?>

<?php 
if ($pintarFormulario) {


?>
	<p class="piede_p">Solicitud de inscripción</p>

<form action="correosCursosCalendario.php" method="post" > 

<?php 

echo '<input id = "P_ciudad" name = "P_ciudad" type= "hidden" value = "'.$_REQUEST['P_ciudad'].'" />';    
echo '<input id = "P_diaFinCurso" name = "P_diaFinCurso" type= "hidden" value = "'.$_REQUEST['P_diaFinCurso'].'"/>';    
echo '<input id = "P_diaIniCurso" name = "P_diaIniCurso" type= "hidden" value = "'.$_REQUEST['P_diaIniCurso'].'"/>';    
echo '<input id = "P_direccionCurso" name = "P_direccionCurso" type= "hidden" value = "'.$_REQUEST['P_direccionCurso'].'"/>';    
echo '<input id = "P_emailDestino" name = "P_emailDestino" type= "hidden" value = "'.$_REQUEST['P_emailDestino'].'"/>';    
echo '<input id = "P_formaPagoCurso" name = "P_formaPagoCurso" type= "hidden" value = "'.$_REQUEST['P_formaPagoCurso'].'"/>';    
echo '<input id = "P_horarioCurso" name = "P_horarioCurso" type= "hidden" value = "'.$_REQUEST['P_horarioCurso'].'"/>';    
echo '<input id = "P_idCurso" name = "P_idCurso" type= "hidden" value = "'.$_REQUEST['P_idCurso'].'"/>';    
echo '<input id = "P_lugar" name = "P_lugar" type= "hidden" value = "'.$_REQUEST['P_lugar'].'"/>';    
echo '<input id = "P_modalidadCurso" name = "P_modalidadCurso" type= "hidden" value = "'.$_REQUEST['P_modalidadCurso'].'"/>';    
echo '<input id = "P_nombrePonente" name = "P_nombrePonente" type= "hidden" value = "'.$_REQUEST['P_nombrePonente'].'"/>';    
echo '<input id = "P_nombre_organizador" name = "P_nombre_organizador" type= "hidden" value = "'.$_REQUEST['P_nombre_organizador'].'"/>';    
echo '<input id = "P_observaciones" name = "P_observaciones" type= "hidden" value = "'.$_REQUEST['P_observaciones'].'"/>';    
echo '<input id = "P_pais" name = "P_pais" type= "hidden" value = "'.$_REQUEST['P_pais'].'"/>';    
echo '<input id = "P_periodicidadCurso" name = "P_periodicidadCurso" type= "hidden" value = "'.$_REQUEST['P_periodicidadCurso'].'"/>';    
echo '<input id = "P_pers_contacto" name = "P_pers_contacto" type= "hidden" value = "'.$_REQUEST['P_pers_contacto'].'"/>';    
echo '<input id = "P_plazas_aprox" name = "P_plazas_aprox" type= "hidden" value = "'.$_REQUEST['P_plazas_aprox'].'"/>';    
echo '<input id = "P_precioCurso" name = "P_precioCurso" type= "hidden" value = "'.$_REQUEST['P_precioCurso'].'"/>';    
echo '<input id = "P_programa_pdf" name = "P_programa_pdf" type= "hidden" value = "'.$_REQUEST['P_programa_pdf'].'"/>';    
echo '<input id = "P_referenciaCurso" name = "P_referenciaCurso" type= "hidden" value = "'.$_REQUEST['P_referenciaCurso'].'"/>';    
echo '<input id = "P_tfn_contacto" name = "P_tfn_contacto" type= "hidden" value = "'.$_REQUEST['P_tfn_contacto'].'"/>';    
echo '<input id = "P_tipoCurso" name = "P_tipoCurso" type= "hidden" value = "'.$_REQUEST['P_tipoCurso'].'"/>';    
echo '<input id = "P_titulo_corto" name = "P_titulo_corto" type= "hidden" value = "'.$_REQUEST['P_titulo_corto'].'"/>';    
echo '<input id = "P_titulo_largo" name = "P_titulo_largo" type= "hidden" value = "'.$_REQUEST['P_titulo_largo'].'"/>';    
                                                                       
?>

	<div class="mitad">
	     <br>
 	     <label class="piede_pan">Nombre </label><input id = "nombre" type="text" name="nombre" size="30" maxlength="40" value= "<?php if (isset( $_REQUEST['nombre'])) { echo $_REQUEST['nombre']; }?>" required> 
	     <br> 
 	     <label class="piede_pan">Apellidos</label><input id = "apellidos" type="text" name="apellidos" size="30" maxlength="40" value= "<?php if (isset( $_REQUEST['apellidos'])) { echo $_REQUEST['apellidos']; }?>" required> 
	     <br> 
         
	     <label class="piede_pan">Email </label> <input id = "email" type="text" name="email" size="30" maxlength="70" value= "<?php if (isset( $_REQUEST['email'])) { echo $_REQUEST['email']; }?>" required > 
	     <br> 
	     <label class="piede_pan">Teléfono</label> <input id = "telefono" type="text" name="telefono" size="20" maxlength="30" value= "<?php if (isset( $_REQUEST['telefono'])) { echo $_REQUEST['telefono']; }?>" >
	     <br> 
	     <label class="piede_pan">Ciudad</label> <input id = "ciudad" type="text" name="ciudad" size="20" maxlength="30" value= "<?php if (isset( $_REQUEST['ciudad'])) { echo $_REQUEST['ciudad']; }?>" >
         <br> 
 
	     <span class="piede_pan_iz"> <?php  echo($mensaje); ?>  
	     <div class="clear"></div>
	</div>  
	
	<div class="mitad">
       <label class="piede_pan_iz"> Observaciones:</label>
       <br>
       <textarea id = "comentarios" class="areaTexto" cols="32" rows="5" name="comentarios"  ><?php if (isset( $_REQUEST['comentarios'])) { echo $_REQUEST['comentarios']; }?></textarea>
       <br>
       <br>
       <input class="piede_pan" type="submit"  name="submit"  value="Submit" required>
       <input class="piede_pan" type="Button" value="Reset" onClick="borraCampos()"> 

       <div class="clear"></div>
	</div> 
 
  <br> 
  <br>
  <div class="clear"></div> 
</form> 
	
	
<?php 	
} else {  

 /* correo para el cliente */

$url_formulario = $DatosWeb->GetTrimValor('web_url')."/paginas/ConfirmacionInscripcion.php?C_idCurso=".rawurlencode($_REQUEST['P_idCurso']);
$url_formulario .= "&C_nombre=".rawurlencode($_REQUEST['nombre']);
$url_formulario .= "&C_apellidos=".rawurlencode($_REQUEST['apellidos']);
$url_formulario .= "&C_email=".rawurlencode($_REQUEST['email']);
$url_formulario .= "&C_fechaMail=".date("Y-m-d");


$bodyCliente = file_get_contents("../cartas/CartaCursosCypeAlumno.php", true); 
$bodyCliente = str_replace('@P_url@',$url_formulario,$bodyCliente);  
$bodyCliente = str_replace('@P_ciudad@',$_REQUEST["P_ciudad"],$bodyCliente);  
$bodyCliente = str_replace('@P_diaFinCurso@',$_REQUEST["P_diaFinCurso"],$bodyCliente);  
$bodyCliente = str_replace('@P_diaIniCurso@',$_REQUEST["P_diaIniCurso"],$bodyCliente);  
$bodyCliente = str_replace('@P_direccionCurso@',$_REQUEST["P_direccionCurso"],$bodyCliente);  
$bodyCliente = str_replace('@P_formaPagoCurso@',$_REQUEST["P_formaPagoCurso"],$bodyCliente);  
$bodyCliente = str_replace('@P_horarioCurso@',$_REQUEST["P_horarioCurso"],$bodyCliente);  
$bodyCliente = str_replace('@P_lugar@',$_REQUEST["P_lugar"],$bodyCliente);  
$bodyCliente = str_replace('@P_modalidadCurso@',$_REQUEST["P_modalidadCurso"],$bodyCliente);  
$bodyCliente = str_replace('@P_nombrePonente@',$_REQUEST["P_nombrePonente"],$bodyCliente);  
$bodyCliente = str_replace('@P_nombre_organizador@',$_REQUEST["P_nombre_organizador"],$bodyCliente);  
$bodyCliente = str_replace('@P_num_horas_curso@',$_REQUEST["P_num_horas_curso"],$bodyCliente);  
$bodyCliente = str_replace('@P_observaciones@',$_REQUEST["P_observaciones"],$bodyCliente);  
$bodyCliente = str_replace('@P_pais@',$_REQUEST["P_pais"],$bodyCliente);  
$bodyCliente = str_replace('@P_periodicidadCurso@',$_REQUEST["P_periodicidadCurso"],$bodyCliente);  
$bodyCliente = str_replace('@P_pers_contacto@',$_REQUEST["P_pers_contacto"],$bodyCliente);  
$bodyCliente = str_replace('@P_pers_contacto@',$_REQUEST["P_pers_contacto"],$bodyCliente);  
$bodyCliente = str_replace('@P_plazas_aprox@',$_REQUEST["P_plazas_aprox"],$bodyCliente);  
$bodyCliente = str_replace('@P_precioCurso@',$_REQUEST["P_precioCurso"],$bodyCliente);  
$bodyCliente = str_replace('@P_referenciaCurso@',$_REQUEST["P_referenciaCurso"],$bodyCliente);  
$bodyCliente = str_replace('@P_tfn_contacto@',$_REQUEST["P_tfn_contacto"],$bodyCliente);  
$bodyCliente = str_replace('@P_tipoCurso@',$_REQUEST["P_tipoCurso"],$bodyCliente);  
$bodyCliente = str_replace('@P_titulo_corto@',$_REQUEST["P_titulo_corto"],$bodyCliente);  
$bodyCliente = str_replace('@P_titulo_largo@',$_REQUEST["P_titulo_largo"],$bodyCliente);  
$bodyCliente = str_replace('@nombre@',$_REQUEST["nombre"],$bodyCliente);  
$bodyCliente = str_replace('@apellidos@',$_REQUEST["apellidos"],$bodyCliente);  


//$bodyCliente = convertir_especiales_html($bodyCliente);
 $mail = new PHPMailer();
 $mail->IsHTML(true);
 $mail->From = $_REQUEST["P_emailDestino"];

 $mail->AddAddress($_POST["email"]);
 $mail->Subject = "Aula CYPE: Solicitud de inscripción";
 //$mail->Body = $bodyCliente;
 $mail->MsgHTML($bodyCliente);
if (strlen($_REQUEST['P_programa_pdf']) > 0){
	$fichero ="../CursosProgramas/".$_REQUEST['P_programa_pdf'];
  $mail->AddAttachment($fichero);
}

 $exito = $mail->Send();
 $intentos=1; 
  while ((!$exito) && ($intentos < 5)) {
	sleep(5);
     	//echo $mail->ErrorInfo;
     	$exito = $mail->Send();
     	$intentos=$intentos+1;	
   }
 
		
   if(!$exito)
   {
	   echo ('<p class = "okCorreo"> Problemas enviando correo electrónico a '.$valor. '</p> <br/>'.$mail->ErrorInfo); 
   }
   else
   {
	    echo ('<p class = "okCorreo">  Gracias por rellenar el formulario. <br>Se ha enviado correctamente.<br><br>Le hemos enviado un correo con los datos de su solicitud.<br><br>Por favor, confírmenos su e-mail pulsando en el link que le hemos enviado</p>'); 
   } 	

//............calcular que no se repita la clave ..del mail a enviar al cliente, registros duplicados etc...................................
$mailRepetido = 0;  // no repetido, de momento
$FormatMaestros = "select id_curso, nombre, apellidos, email_cliente, telefono, fecha_mail from alumnosinscritos
where id_curso =  %d
  and nombre   = '%s'    
  and apellidos =  '%s'
  and email_cliente = '%s' 
  and fecha_mail = '%s'
 ";
$queMaestros = sprintf($FormatMaestros, $_POST["P_idCurso"], $_POST["nombre"], $_POST["apellidos"], $_POST["email"],date("Y-m-d"));
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	$mailRepetido = 1;   //.................ya ha enviado el mail antes
}
 
if ($mailRepetido == 0) {

	$FormatMaestros = "insert into alumnosinscritos (id_curso, nombre, apellidos, email_cliente, email_receptor, telefono, fecha_mail,agente_inscriptor, precio_tarifa, obser_cliente)  values(%d,%s,%s,%s,%s,%s, %s,%s, %s, %s)";                                                                                         
   $queMaestros = sprintf($FormatMaestros, $_POST["P_idCurso"],comas($_POST["nombre"]),comas($_POST["apellidos"]),comas($_POST["email"]),comas($_POST["P_emailDestino"]),comas($_POST["telefono"]),comas(date("Y-m-d")),comas('Web'),comas($_POST["P_precioCurso"]),comas($_POST["comentarios"])); 	
	
} else {
	$FormatMaestros = "
	update alumnosinscritos set
	obser_cliente = '%s',
	telefono      = '%s' 
	where id_curso =  %d
      and nombre   = '%s'    
      and apellidos =  '%s'
      and email_cliente = '%s' 
      and fecha_mail = '%s'
	";
   $queMaestros = sprintf($FormatMaestros, $_POST["comentarios"],$_POST["telefono"],$_POST["P_idCurso"],$_POST["nombre"], $_POST["apellidos"],$_POST["email"],date("Y-m-d")); 	
}
 //..........ejecutar query                                                                                                        
 $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                         
 mysqli_free_result($resMaestros); 
}  
?>
</body>

</html>


