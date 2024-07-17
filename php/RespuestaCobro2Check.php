<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
// session_start(); se hará en SesionesCookies;
include_once('../conexion/conn_bbdd.php');
include_once('ParametrosClass.php'); //Clase ParametrosClass
include_once('../paginas/NewWebEstilosNOIndex.php');

$DatosWeb =   new ParametrosClass($conexion);
	
include_once('ValidaLoginScript.php');
include_once('SesionesCookies.php'); //Inicio de sesión y asignación de sus variables despues de DatosWeb
	
$palabra = "";
$datosCorrectos = 0;
////////// inicio de proceso de página ////////////////////////////////////////////////////////////////////////////////
////////// inicio de proceso de página ////////////////////////////////////////////////////////////////////////////////
$pwdInicio ="medFK";
$mailOrganizador =  $DatosWeb->GetTrimValor('CorreoPrincipal');
$keyOK = 0; 
$errorTxt = "";
$hashSecretWord = ''; //2Checkout Secret Word
$hashSid = 0; //2Checkout account number
$tmp1 = substr($_REQUEST['li_0_name'],0,3);

$es_real = 0;	
	
//////////////////////////////////////////////////////////////////////////// grabar la respuesta en la tabla vtcheckout
      $resp = "";
      $numero2 = count($_REQUEST);
      $tags2 = array_keys($_REQUEST); // obtiene los nombres de las varibles
      $valores2 = array_values($_REQUEST);// obtiene los valores de las varibles

     for($i=0;$i<$numero2;$i++){ 
         $resp .= $tags2[$i]."=".$valores2[$i]."\r\n"; 
      }
	  
      
      //if ( $numero2 < 1 || !isset($_REQUEST['order_number']) || !isset($_REQUEST['merchant_order_id']) ) {
 	  //   header("Location: ../index.php");
      //   exit;  
	  //}





    if (ExisteOrderNumber($_REQUEST['order_number'],$conexion) == 0) {
	  $resp2 = str_replace("'"," ",$resp);
      $FormatMaestros = "INSERT into vtcheckout (order_number,respuesta) values ('%s','%s') ";
      $queMaestros = sprintf($FormatMaestros, $_REQUEST['order_number'],$resp2);
      //echo "<br>@8@".$queMaestros;
      $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
      mysqli_free_result($resMaestros);   
	
	} 	
    $errorTxt .= ProcesoRepetido($_REQUEST['merchant_order_id'],$_REQUEST['credit_card_processed'],$conexion);
    
////////////////////////////////////// ////////////////////////////////////// comprobar la key, real o test

if ($tmp1 == "-T-") {
  $es_real = 0;	
} else {
  $es_real = 1;
}


//..........leer la key
$FormatMaestros = "SELECT  twocheck_real_id, twocheck_real_word	
                    FROM vtparametros 
				    WHERE id = 1
				 ";
$queMaestros = sprintf($FormatMaestros);

//echo "<br>@9@".$queMaestros;


$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
		     $hashSecretWord = $rowVTMaestros['twocheck_real_word'];
		     $hashSid = $rowVTMaestros['twocheck_real_id'];
	 }	
} else {
	$errorTxt .= " No encontrados los parametros de cobro. Tabla vtparametros";
	
	mysqli_free_result($resMaestros);  
	
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
	$errorTxt .= " No encontrado el precio del videotutorial ";
	
	mysqli_free_result($resMaestros);  
	
}
 mysqli_free_result($resMaestros);
 //...........................................
 if ($es_real == 0 ) {
    $hashOrder = $_REQUEST['order_number']; //2Checkout Order Number y no 1 como reza el manual
 } else {
	$hashOrder = $_REQUEST['order_number']; //2Checkout Order Number 
 }




$StringToHash = strtoupper(md5($hashSecretWord . $hashSid . $hashOrder . $hashTotal));


if ($StringToHash != $_REQUEST['key']) {
	  $errorTxt .= " StringToHash no cuadra ";
	  $ToHashOK = 0;
	} else { 
	  $ToHashOK = 1;
}


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
	$errorTxt .= " No encontrada la solicitud buscando email_cliente";
	
	mysqli_free_result($resMaestros);  
	
}
 mysqli_free_result($resMaestros);
 
 //echo "<br>@12-12@  tarjeta procesada-->".$tarjeta_procesada;
 
 
if ($tarjeta_procesada == 1 /*&& $ToHashOK == 1 && $errorTxt == ""*/) {
	
    InsertaVTCOBRO($cursoID, $mailAlumno,$es_real,$precio,$conexion);	/////////////////////////////// cobros
    
	InsertaVTALUMNOS($mailAlumno,$es_real,$pwdInicio,$conexion); /////////////////////////////// alumnos inscritos
   
    $numeroCursos = explode(",",$loteCursos);

	for ($i=0;$i<count($numeroCursos);$i++) {
		InsertaVTPERMISOS($numeroCursos[$i],$mailAlumno,$conexion); /////////////////////////////// permisos de acceso
	}
    $datosCorrectos = 1;
} else {
    gravaError($errorTxt,$conexion,$mailOrganizador); 
}
//////////////////////////////////////////anotar en vtcheckout cómo ha ido el proceso
	$FormatSelect = "UPDATE vtcheckout set proceso_ok = '%s' where order_number = '%s'";
    $queSelect = sprintf($FormatSelect,$datosCorrectos,$_REQUEST['order_number']);
    $resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion)); 
    mysqli_free_result($resSelect); 

?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $DatosWeb->GetTrimValor('web_dominio') ?>  Respuesta 2checkout</title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script>
     DENombre_correo = '<?php echo $DatosWeb->GetTrimValor('NombrePrincipal') ?>';
     DEemisorcorreo = '<?php echo $DatosWeb->GetTrimValor('CorreoPrincipal') ?>';
</script>    
<script  src="VideotutorialesLoginNOIndex.js"></script>   
<?php 
    include_once('../paginas/PaginaCabecera.php'); 
    include_once('../paginas/PaginaCursoPHP01_2.php');  
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


<body onload="PResuelveBodyCarta(<?php echo "'".$mailAlumno."'".','."'".$palabra."'".','.$datosCorrectos ?>)"> 

<?php
include_once('../paginas/MenuNOIndex.php');   
?>
<div class="PocoEspacio" ></div>
<div class="clear"></div>
<div class = "Aviso"></div>

<div class="ContenedorSlider">    
    <input type="radio" id="1" name="image-slide" hidden/>
    <input type="radio" id="2" name="image-slide" hidden/>
    <input type="radio" id="3" name="image-slide" hidden/>
    <div class="slider">
        <ul class="sliderUL">
          <li><img src="../imagenes/SliderIndex01.jpg" alt=""/> <div class="parrafos" ><h2>Cursos CYPE</h2><p>Escuela OnLine</p></div></li>
          <li><img src="../imagenes/SliderIndex02.jpg" alt=""/> <div class="parrafos" ><h2>Especialidades</h2>
              <p>Hormigón, Estructuras Metálicas</p>
              <p>Análisis PushOver, Instalaciones BIM</p>
              </div></li>
          <li><img src="../imagenes/SliderIndex03.jpg" alt=""/> <div class="parrafos" ><h2>Accede al Curso Gratis</h2><p>Inscríbete</p></div></li>
        </ul>
        <div class="pagination">
            <label class="pagination-item" for="1"></label>
            <label class="pagination-item" for="2"></label>
            <label class="pagination-item" for="3"></label>  
        </div>
    </div>
</div> 
 
 <h1 class ="NewtituloApartado">Compra de Cursos</h1>

<?php
     include_once('../paginas/PantallaPwd.php');
?>  


<div class="NuevoAlumno">
<?php  if ($datosCorrectos == 1) { ?>
    <p><b>Compra realizada correctamente</b></p>
    <br />
    <div id = "CBmarcoMensaje" >&nbsp;</div>

    <p>Si no recibe el email con los datos de conexión póngase en contacto con nosotros</p>
    Entre en nuestra  Aula  y conéctese para ver el(los) curso(s) que acaba de adquirir.
  
<?php } else { ?>
     
    <br />
    El proceso de pago <strong>NO ha sido completado</strong>
    <br />
    <?php  echo "<span class='rojo'>".$errorTxt."</span>"  ?>         
    <br />
    Póngase en contacto con nosotros si considera que es una incidencia.
    
<?php } ?>
</div>
<div class="separadorGrande"></div>   
<div class="centro90"><?php include_once('../paginas/PaginaPieNOIndex.php'); ?></div>
<?php include_once('../paginas/PaginaCursoPHP01_4.php'); ?>





</body>
</html>
<?php
//////////////////////////////////////////////////////////
function ExisteEnVTPERMISOS($IDAlumno,$IDCurso,$conexion) {
	$FormatExiste = "SELECT id
                       FROM   vtpermisos
                       WHERE id_usuario = %d
                         AND  id_curso = %d
                         AND fecha_ini <= curdate()
                         AND ( fecha_fin = null OR fecha_fin is null OR fecha_fin >= curdate())
                         ";
   $queExiste = sprintf($FormatExiste, $IDAlumno, $IDCurso);
   $resExiste = mysqli_query($conexion, $queExiste) or die(mysqli_error($conexion));                                                        
   $totExiste = mysqli_num_rows($resExiste);  
   mysqli_free_result($resExiste);
   return $totExiste;
}


//////////////////////////////////////////////////////////
function InsertaVTPERMISOS($curso,$mailAlumno,$conexion) {
	//....numero de cobro
	$tmpError = "";
	$cobroID = 0;
	$FormatSelect = "SELECT   id
                       FROM   vtcobros
                       WHERE  id_solicitud = %d
				      ";
$queSelect = sprintf($FormatSelect, $_REQUEST['merchant_order_id']);

$resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
$totSelect = mysqli_num_rows($resSelect);  
    if ($totSelect < 1){   
	    $tmpError .= " No encontrada la solicitud en vtcobros. Solicitud = ".$_REQUEST['merchant_order_id'];
	    
	    mysqli_free_result($resSelect);  
	   
     }
	 while ($rowVTSelect = mysqli_fetch_assoc($resSelect)) {
		 $cobroID = $rowVTSelect['id'];
	 }	
mysqli_free_result($resSelect);
//.................................................numero de alumno
	$alumnoID = 0;
	$FormatSelect = "SELECT   id
                       FROM   vtalumnos
                       WHERE  email = '%s'
				      ";
$queSelect = sprintf($FormatSelect, $mailAlumno);

$resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
$totSelect = mysqli_num_rows($resSelect);  
    if ($totSelect < 1){   
	    $tmpError .= " No encontrado en vtalumnos. Alumno = ".$mailAlumno;
	    
	    mysqli_free_result($resSelect);  
	    
     }
	 while ($rowVTSelect = mysqli_fetch_assoc($resSelect)) {
		 $alumnoID = $rowVTSelect['id'];
	 }	
mysqli_free_result($resSelect);
//................................................................................alta de permisos
if (ExisteEnVTPERMISOS($alumnoID,$curso,$conexion) == 0){
	$FormatMaestros = "INSERT into vtpermisos (id_cobro,
                              id_usuario, 
                              id_curso	,
                              fecha_ini	) 
	                          values (%d,%d,%d,'%s') ";
    $queMaestros = sprintf($FormatMaestros, $cobroID, $alumnoID, $curso, date('Y-m-d'));
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    mysqli_free_result($resMaestros);
}

	
if ($tmpError != "")	{
	gravaError($tmpError ,$conexion,$mailOrganizador);
}
		
}
////////////////////////////////////////////////////////
function InsertaVTCOBRO($curso,$alumno,$real,$usd,$conexion) {

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
id_solicitud,
codigo_pais,
ciudad) 
	             values (%d,'%s','%s','%s','%s','%s',%d,%d,'%s','%s') ";
							  
							  
$queMaestros = sprintf($FormatMaestros, $curso, $pruebas, $alumno, date ('Y-m-d H:i:s'),  $_REQUEST['order_number'], $_REQUEST['invoice_id'], $usd, $_REQUEST['merchant_order_id'],$_REQUEST['country'],strtoupper($_REQUEST['city']));


//echo "<br>@4@".$queMaestros;

$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
mysqli_free_result($resMaestros);

//echo "<br>@4-4-4@   Final InsertaVTCOBRO";
}
//////////////////////////////////////////////////////////
function InsertaVTALUMNOS($Alumno,$real,$pwd_inicial,$conexion) {
		
	$FormatSelect = "SELECT id
                   FROM vtalumnos
                   WHERE  email = '%s'
				          ";
				 				 
  $queSelect = sprintf($FormatSelect, $Alumno);
  
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
  //.....................................................................................alta del alumno
  $palabra = $pwd_inicial.$_REQUEST['merchant_order_id'];
  $observaciones = "ALTA Automática 2CHECKOUT";
  if ($real == 0) {
      $observaciones = "TEST-PRUEBAS Web";	
  }
  
  $FormatMaestros = "INSERT into vtalumnos (
  email,
  recibir_mails,	 	 
  pwd	,	 	 
  nombre,		 
  apellidos,	 
  fecha_alta,			 
  observaciones_medif,
  es_colaborador,
  telefono,
  tipoalumno
  	) 
  	                          values ('%s',1,'%s','%s','%s','%s','%s',0,'%s',%d) ";
  $queMaestros = sprintf($FormatMaestros, $Alumno,$palabra, $_REQUEST['first_name'], $_REQUEST['last_name'], date('Y-m-d') , $observaciones,$_REQUEST['phone'],13);
  
  //echo "<br>@6@".$queMaestros;
  
  $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
  mysqli_free_result($resMaestros);	
}

////////////////////////////////////////////////////////
function gravaError($errores,$conexion,$mailOrganizador) {
    
  $headers = "Content-type: text/html; charset=iso-8859-1\r\n"; 
  $FormatSelect = "UPDATE vtcheckout set error = '%s' where order_number = '%s'";
  $queSelect = sprintf($FormatSelect,$errores,$_REQUEST['order_number']);
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
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function ProcesoRepetido($NumSolicitud,$TarjetaProcesada,$conexion) {
$repetido =0;
$TipoMensaje = "";
$tmpError ="";
	if ($TarjetaProcesada != "Y"){
	  return $tmpError;	
	}
$FormatMaestros = "SELECT tipomensaje
                   FROM   vtsolicitudes
                   WHERE  id = %d
				 ";
$queMaestros = sprintf($FormatMaestros,$NumSolicitud);
	
	
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     

if ($totMaestros > 0){
	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
		    $TipoMensaje= $rowVTMaestros['tipomensaje'];
	 }	
 
} else {
	 $tmpError = " No encontrada la solicitud ";
	
}	
if (trim($TipoMensaje) == "PAGADO"){
	$tmpError = "Proceso Repetido";
}	
 mysqli_free_result($resMaestros);
return $tmpError;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function ExisteOrderNumber($PorderNumber,$conexion) {
  $TotalEncontrados = 0;

  if ($PorderNumber == "") {
    return 1;
  }
  $FormatExiste = "SELECT id 
                       FROM vtcheckout
                      WHERE order_number = '%s'
                  ";
  $queExiste = sprintf($FormatExiste,$PorderNumber);
  $resExiste = mysqli_query($conexion, $queExiste) or die(mysqli_error($conexion));                                                        
  $TotalEncontrados = mysqli_num_rows($resExiste);     
  mysqli_free_result($resExiste);
  return $TotalEncontrados;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>



