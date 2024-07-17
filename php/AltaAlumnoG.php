<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php

include_once('../conexion/conn_bbdd.php');
session_start();
$palabra = "";










///////////////confirmar que es un curso grtis   ///////////////////////////////////////funciones

















//////////////////////////////////////////////////////////
function InsertaVTPERMISOS($curso,$mailAlumno,$conexion) {
	//....numero de cobro
	$cobroID = 0;
	$FormatSelect = "SELECT   id
                       FROM   vtcobros
                       WHERE  id_solicitud = %d
				      ";
$queSelect = sprintf($FormatSelect, $_REQUEST['merchant_order_id']);


//echo "<br>@1@".$queSelect;

$resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
$totSelect = mysqli_num_rows($resSelect);  
    if ($totSelect < 1){   
	    $error .= " No encontrada la solicitud en vtcobros. Solicitud = ".$_REQUEST['merchant_order_id'];
	    gravaError($error,$conexion);
	    mysqli_free_result($resSelect);  
	    exit;
     }
	 while ($rowVTSelect = mysqli_fetch_assoc($resSelect)) {
		 $cobroID = $rowVTSelect['id'];
	 }	
mysqli_free_result($resSelect);
//....numero de alumno
	$alumnoID = 0;
	$FormatSelect = "SELECT   id
                       FROM   vtalumnos
                       WHERE  email = '%s'
				      ";
$queSelect = sprintf($FormatSelect, $mailAlumno);

//echo "<br>@2@".$queSelect;


$resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
$totSelect = mysqli_num_rows($resSelect);  
    if ($totSelect < 1){   
	    $error .= " No encontrado en vtalumnos. Alumno = ".$mailAlumno;
	    gravaError($error,$conexion);
	    mysqli_free_result($resSelect);  
	    exit;
     }
	 while ($rowVTSelect = mysqli_fetch_assoc($resSelect)) {
		 $alumnoID = $rowVTSelect['id'];
	 }	
mysqli_free_result($resSelect);
//.....alta de permisos
	$FormatMaestros = "INSERT into vtpermisos (id_cobro,
                              id_usuario, 
                              id_curso	,
                              fecha_ini	) 
	                          values (%d,%d,%d,'%s') ";
$queMaestros = sprintf($FormatMaestros, $cobroID, $alumnoID, $curso, date('Y-m-d'));


//echo "<br>@3@".$queMaestros;


$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
mysqli_free_result($resMaestros);
}
////////////////////////////////////////////////////////
function InsertaVTCOBRO($curso,$alumno,$real,$usd,$conexion) {
	
	
	
	//echo "<br>@3-2-3-4@(0) curso-->".$curso;
	//echo "<br>@3-2-3-4@(0) alumno-->".$alumno;
	//echo "<br>@3-2-3-4@(0) real-->".$real;
	//echo "<br>@3-2-3-4@(0) usd-->".$usd;
	
	//echo "<br>@3-2-3-4@(1) entramos en InsertaVTCOBRO";
	
	if ($real == 0) {
		$pruebas= "PRUEBA";
	} else {
		$pruebas= "Real";
	}
	$FormatMaestros = "INSERT into vtcobros (id_curso,	
pruebas_real,	
email_cliente,		 	 
fecha_emision,		 
numero_orden,	
numero_factura,	
importe,	 	 	 
id_solicitud	) 
	             values (%d,'%s','%s','%s','%s','%s',%d,%d) ";
							  
							  
//echo "<br>@3-2-3-4@(2)  InsertaVTCOBRO";							  
							  
							  
$queMaestros = sprintf($FormatMaestros, $curso, $pruebas, $alumno, date ('Y-m-d H:i:s'),  $_REQUEST['order_number'], $_REQUEST['invoice_id'], $usd, $_REQUEST['merchant_order_id']);


//echo "<br>@4@".$queMaestros;

$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
mysqli_free_result($resMaestros);

//echo "<br>@4-4-4@   Final InsertaVTCOBRO";
}
//////////////////////////////////////////////////////////
function InsertaVTALUMNOS($Alumno,$real,$pwd_inicial,$conexion) {
	
	
	//echo "<br>@5-0@   Alumno-->".$Alumno;
	//echo "<br>@5-0@   real-->".$real;
	//echo "<br>@5-0@   pwd_inicial-->".$pwd_inicial;
	
	
	$FormatSelect = "SELECT id
                   FROM vtalumnos
                   WHERE  email = '%s'
				 ";
				 
				 
//echo "<br>@5-0-0@FormatSelect-->".$FormatSelect;

				 
$queSelect = sprintf($FormatSelect, $Alumno);


//echo "<br>@5@".$queSelect;


$resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
$totSelect = mysqli_num_rows($resSelect);
mysqli_free_result($resSelect);     
if ( $totSelect > 0 ) {
	// recuperamos su pwd para enviarla a la carta que se envía al alumno
	$palabra = "";
    $FormatPwd = "SELECT  pwd
                   FROM vtalumnos
                   WHERE  email = '%s'
				 ";
     $quePwd = sprintf($FormatPwd, $Alumno);
     $resPwd = mysqli_query($conexion, $quePwd) or die(mysqli_error($conexion));                                                        
     $totPwd = mysqli_num_rows($resPwd);     

	 while ($rowVTPwd = mysqli_fetch_assoc($resPwd)) {
		 $palabra = $rowVTPwd['pwd'];
	 }	
     mysqli_free_result($resPwd);
      return;	
}
//...alta del alumno
$palabra = $pwd_inicial.$_REQUEST['merchant_order_id'];
$observaciones = "ALTA Automática 2CHECKOUT";
if ($real == 0) {
$observaciones = "TEST-PRUEBAS Web";
	
}
$FormatMaestros = "INSERT into vtalumnos (
email,	 	 
pwd	,	 	 
nombre,		 
apellidos,	 
fecha_alta,			 
observaciones_medif
	) 
	                          values ('%s','%s','%s','%s','%s','%s') ";
$queMaestros = sprintf($FormatMaestros, $Alumno, $palabra, $_REQUEST['first_name'], $_REQUEST['last_name'], date('Y-m-d') , $observaciones);

//echo "<br>@6@".$queMaestros;

$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
mysqli_free_result($resMaestros);	
}
/////////////////////////////////////////////////////////
function buscaCorreoOrganizador($conexion) {
	$mailErrores = "";
$FormatSelect = "SELECT mail_organizador
                   FROM vtparametros
                   WHERE  id = 1
				 ";
$queSelect = sprintf($FormatSelect);

//echo "<br>@6-6@".$queSelect;



$resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
$totSelect = mysqli_num_rows($resSelect);     

	 while ($rowVTSelect = mysqli_fetch_assoc($resSelect)) {
		 $mailErrores = $rowVTSelect['mail_organizador'];
	 }	
mysqli_free_result($resSelect);
return $mailErrores;

}

////////////////////////////////////////////////////////
function gravaError($errores,$conexion) {
	$mailOrganizador = buscaCorreoOrganizador($conexion);
    $headers = "Content-type: text/html; charset=iso-8859-1\r\n"; 
	$FormatSelect = "UPDATE vtcheckout set error = '%s' where order_number = '%s'";
    $queSelect = sprintf($FormatSelect,$errores,$_REQUEST['order_number']);
	
	
	//echo "<br>@7@".$queSelect;
	
	
    $resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion)); 	
	
	$titulocorreo  = "Error en proceso de cobro con tarjeta: "."\n\n";
    $cuerpoComercial = "=== Order de respuesta 2checkout   ========================================================\n";
    $cuerpoComercial .= "NUMERO: ".$_REQUEST['order_number']."\n";
    $cuerpoComercial .= "EMAIL: ".$_REQUEST["email"]."\n";
    $cuerpoComercial .= "ERROR: ".$errores."\n";
    $cuerpoComercial .= "OBSERVACIONES: mirar la tabla VTCHECKOUT, NO se han dado permisos de acceso al curso\n";
    $cuerpoComercial .= "===================================================================\n\n";
    $cuerpoComercial .= "LLamar o escribir al cliente, a partir de order_number se llega a todos los datos. \n"; 

	mail($mailOrganizador,$titulocorreo,$cuerpoComercial,$headers);
	mysqli_free_result($resSelect);
	return;
}
////////// inicio de proceso de página ////////////////////////////////////////////////////////////////////////////////
////////// inicio de proceso de página ////////////////////////////////////////////////////////////////////////////////
////////// inicio de proceso de página ////////////////////////////////////////////////////////////////////////////////
$pwdInicio ="cypecadcype3d";
//////////////////////////////////////////////////////////////////////////// grabar la respuesta en la tabla vtcheckout
      $resp = "";
      $numero2 = count($_REQUEST);
      $tags2 = array_keys($_REQUEST); // obtiene los nombres de las varibles
      $valores2 = array_values($_REQUEST);// obtiene los valores de las varibles

     for($i=0;$i<$numero2;$i++){ 
         $resp .= $tags2[$i]."=".$valores2[$i]."\r\n"; 
      }
	  
	  $resp2 = str_replace("'"," ",$resp);
$FormatMaestros = "INSERT into vtcheckout (order_number,respuesta) values ('%s','%s') ";
$queMaestros = sprintf($FormatMaestros, $_REQUEST['order_number'],$resp2);

//echo "<br>@8@".$queMaestros;

$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
mysqli_free_result($resMaestros);                                                       
////////////////////////////////////// ////////////////////////////////////// comprobar la key, real o test
$keyOK = 0; 
$error = "";
$hashSecretWord = ''; //2Checkout Secret Word
$hashSid = 0; //2Checkout account number
$tmp1 = substr($_REQUEST['li_0_name'],0,3);


//echo "<br>@@ li_0_name->".$_REQUEST['li_0_name'];
//echo "<br>@@ tmp1->".$tmp1;




$es_real = 0;
if ($tmp1 == "-T-") {
  $es_real = 0;	
} else {
  $es_real = 1;
}

//echo "<br>@@ es_real->".$es_real;




//..........leer la key
$FormatMaestros = "SELECT  twocheck_test_id, twocheck_test_word,  twocheck_real_id, twocheck_real_word	
                    FROM vtparametros 
				    WHERE id = 1
				 ";
$queMaestros = sprintf($FormatMaestros);

//echo "<br>@9@".$queMaestros;


$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
		 if ($es_real == 0 ) {
		     $hashSecretWord = $rowVTMaestros['twocheck_test_word'];
		     $hashSid = $rowVTMaestros['twocheck_test_id'];
		 } else {
		     $hashSecretWord = $rowVTMaestros['twocheck_real_word'];
		     $hashSid = $rowVTMaestros['twocheck_real_id'];
		 }

	 }	
} else {
	$error .= " No encontrados los parametros de cobro. Tabla vtparametros";
	gravaError($error,$conexion);
	mysqli_free_result($resMaestros);  
	exit;
}
 mysqli_free_result($resMaestros);

//..........leer el total importe
$hashTotal = '0.00'; //Sale total to validate against
$precio = 0;
$FormatMaestros = "SELECT importe
                   FROM   vtsolicitudes
                   WHERE  id = %d
				 ";
$queMaestros = sprintf($FormatMaestros,$_REQUEST['merchant_order_id']);


//echo "<br>@10@".$queMaestros;


$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
		     $hashTotal = $rowVTMaestros['importe'].".00";
			 $precio = $rowVTMaestros['importe'];
	 }	
} else {
	$error .= " No encontrado el precio del videotutorial ";
	gravaError($error,$conexion);
	mysqli_free_result($resMaestros);  
	exit;
}
 mysqli_free_result($resMaestros);
 //...........................................
 if ($es_real == 0 ) {
    $hashOrder = $_REQUEST['order_number']; //2Checkout Order Number y no 1 como reza el manual
 } else {
	$hashOrder = $_REQUEST['order_number']; //2Checkout Order Number 
 }



//echo "<br>@@ llegamos a 111111 <br>";


$StringToHash = strtoupper(md5($hashSecretWord . $hashSid . $hashOrder . $hashTotal));




//echo "<br>@@ llegamos a 22222222 <br>";
//echo "<br>@@ StringToHash->".$StringToHash;
//echo "<br>@@ key ->".$_REQUEST['key'];
//echo "<br>@@ hashSecretWord ->".$hashSecretWord;
//echo "<br>@@ hashSid ->".$hashSid;
//echo "<br>@@ hashOrder ->".$hashOrder;
//echo "<br>@@ hashTotal ->".$hashTotal;





if ($StringToHash != $_REQUEST['key']) {
	  $error .= " StringToHash no cuadra. Salimos del proceso sin anotar en tablas ";
	  $ToHashOK = 0;
	  	gravaError($error,$conexion);
	    exit;
	  
	} else { 
	  $ToHashOK = 1;
}

//echo "<br>@@ ToHashOK (correcto = 1)->".$ToHashOK;

//////////////////////////////////////////////////////////////////////////// comprobar si procesada la tarjeta 
$tarjeta_procesada = 0;
$mensaje = "NO PAGADO";
$tmp1 = $_REQUEST['credit_card_processed'];
if ($tmp1 == "Y") {
	$tarjeta_procesada = 1;
	$mensaje = "PAGADO";
} 
////////////////////////////////////// ////////////////////////////////////// vtsolicitudes
  $FormatProceso = "UPDATE vtsolicitudes
                       set tipomensaje = '%s', 	
                           nombre	   = '%s', 
                           apellidos   = '%s',	   
                           ciudad	   = '%s', 
                           telefono    = '%s'
					 where  id = %d";
    
    $queProceso = sprintf($FormatProceso,$mensaje,$_REQUEST['first_name'],$_REQUEST['last_name'],$_REQUEST['city'],$_REQUEST['phone'],$_REQUEST['merchant_order_id']);
	
	
	
	//echo "<br>@11@".$queProceso;
	
    $resProceso = mysqli_query($conexion, $queProceso) or die(mysqli_error($conexion)); 	
	mysqli_free_result($resProceso);
////////////////////////////////////// ////////////////////////////////////// vtcobros


//....necesito saber id_curso y mail_alumno 
$cursoID = 0;
$loteCursos = "";
$mailAlumno = "";
$importe = 0;
$FormatMaestros = "SELECT id_curso, lotedecursos, email_cliente,importe
                   FROM   vtsolicitudes
                   WHERE  id = %d
				 ";
$queMaestros = sprintf($FormatMaestros,$_REQUEST['merchant_order_id']);


	//echo "<br>@12@".$queMaestros;


$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
		     $cursoID = $rowVTMaestros['id_curso'];                           
			 $mailAlumno = $rowVTMaestros['email_cliente'];
			 $loteCursos = $rowVTMaestros['lotedecursos'];
			 $importe = $rowVTMaestros['importe'];
		    echo "<script>";
			echo "precio = ".$importe.";\n";
			echo "lote = '".$loteCursos."';\n";
			echo "</script>";
	 }	
} else {
	$error .= " No encontrada la solicitud buscando email_cliente";
	gravaError($error,$conexion);
	mysqli_free_result($resMaestros);  
	exit;
}
 mysqli_free_result($resMaestros);
 
 //echo "<br>@12-12@  tarjeta procesada-->".$tarjeta_procesada;
 
 
if ($tarjeta_procesada == 1) {
	
	//echo "<br>@12-12@  Entramos a procesar el trío de funciones";
	
	
    InsertaVTCOBRO($cursoID, $mailAlumno,$es_real,$precio,$conexion);	/////////////////////////////// cobros
	InsertaVTALUMNOS($mailAlumno,$es_real,$pwdInicio,$conexion); /////////////////////////////// alumnos inscritos
    $numeroCursos = explode(",",$loteCursos);
	for ($i=0;$i<count($numeroCursos);$i++) {
		InsertaVTPERMISOS($numeroCursos[$i],$mailAlumno,$conexion); /////////////////////////////// permisos de acceso
	}
    //...hecho en javascript Ajax  ---> EnviaCartaPWD($mailAlumno, $pwdInicio.$_REQUEST['merchant_order_id']);
} // de tarjeta procesada

?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CYPE: Respuesta 2checkout</title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<?php  
$FormatMaestros = " SELECT correoelectronico , nombre_correo   
from emailscomerciales 
where tipocorreo = 1 limit 1";

$queMaestros = $FormatMaestros; 
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
$totMaestros = mysqli_num_rows($resMaestros);

if ($totMaestros == 1) {
       //....correo para el cliente...................................................................
          while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {	 
		    echo "<script>DENombre_correo = '".$rowRegistros['nombre_correo']."';\n";
			echo "DEemisorcorreo = '".$rowRegistros['correoelectronico']."';\n";
			echo "</script>";
		  }
}

?>

<script>
//...........................................................................
bodyCartaCli="";
function PResuelveBodyCarta(mail, pwd, todoOK)	{
	
		     var parametros = {   
			  "CBemail"       : mail ,
			  "Nombre_correo" : DENombre_correo ,
			  "Emisor_correo" : DEemisorcorreo,
			  "lote"          : lote ,
			  "PwdPalabra"    : pwd ,
			  "precio"        : precio,
			  "TodoOK"        : todoOK 
			  
              };  
		$.ajax({
             data:  parametros,
             url:   '../cartas/CartaVTRespuestaCobro.php',
             type:  'post',
             beforeSend: function () {
                      $("#CBmarcoMensaje").html("Componiendo carta ...Cursos:"+lote); 
             },
             success:  function (response) {
				 bodyCartaCli = response;
				 EnviaCartaAlumno(mail,bodyCartaCli);
				 procesoActivo = 0; 
             },
			 error: function(){
                $("#CBmarcoMensaje").html("<span class='rojo'>Error componiendo carta</span>");
				$('#botones').css("display","inline");
				procesoActivo = 0;
				return false;
            }
        });	
	
	
}


//........................................................
function EnviaCartaAlumno( Pmail, PbodyCartaCli)	{
		     var parametros = {
			  "email"         : Pmail ,
			  "Nombre_correo" : DENombre_correo ,
			  "bodyCarta"     : PbodyCartaCli
			  
              };  
	$.ajax({
             data:  parametros,
             url:   '../php/VTRespuestaCobroEnviaMail.php',
             type:  'post',
             beforeSend: function () {
                      $("#CBmarcoMensaje").html("Enviando mail con datos de conexión ...."); 
             },
             success:  function (response) {
					 if (response != "OK") {
						$("#CBmarcoMensaje").html("<span class='rojo'>"+response+"</span>"); 
						$('#botones').css("display","inline");
						return false;
					 } else {
						 $("#CBmarcoMensaje").html("Le hemos enviado un Email con los datos de conexión"); 
						return true;
					 }
             },
			 error: function(){
                $("#CBmarcoMensaje").html("<span class='rojo'>Error enviando Emails</span>");
				$('#botones').css("display","inline");
				return false;
            }
        });	
	
}
//.............................................
</script>
</head>


<body onload="PResuelveBodyCarta(<?php echo "'".$mailAlumno."'".','."'".$palabra."'".','.$tarjeta_procesada ?>)"> 

<?php 
 
/*echo "<br>Inicio parámetros ========================================================================<br>";	  
	  $numero2 = count($_REQUEST);
      $tags2 = array_keys($_REQUEST); // obtiene los nombres de las varibles
      $valores2 = array_values($_REQUEST);// obtiene los valores de las varibles

     for($i=0;$i<$numero2;$i++){ 
         echo $tags2[$i]."=".$valores2[$i]."<br>"; 
      }
echo "<br>Final parámetros ========================================================================";	  
*/
?>

<center>
<?php  if ($tarjeta_procesada == 1) { ?>
  <img src="../imagenes/RespuestaCobroLogin.jpg" width="1129" height="353" alt="MedifLoginPermisos" />
    <br />
    <br />
    <br />
    <br />
    <div id = "CBmarcoMensaje" >&nbsp;</div>
    <br />
    <br />
    <p>Si no recibe el email con los datos de conexión póngase en contacto con nosotros</p>
    Entre en nuestra página de Aula Cype y conéctese para ver el curso que acaba de adquirir.
<?php } else { ?>
    <img src="../imagenes/VisaError.jpg" width="400" height="398" alt="VisaError" /><br />
    <br />
    <br />
    <br />
    El proceso de pago NO ha sido completado
    <br />
    <br />
    Póngase en contacto con nosotros si considera que es una incidencia.
	
<?php } ?>
</center>




</body>
</html>
