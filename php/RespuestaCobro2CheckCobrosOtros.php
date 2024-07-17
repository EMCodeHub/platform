<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb = new ParametrosClass($conexion);
include_once('ValidaLoginScript.php');
include_once('SesionesCookies.php'); //Inicio de sesión y asignación de sus variables despues de DatosWeb
     
////////// inicio de proceso de página ////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////// grabar la respuesta en la tabla vtcheckout
$errorTxt = "";
$resp = "";
$numero2 = count($_REQUEST);
$tags2 = array_keys($_REQUEST); // obtiene los nombres de las varibles
$valores2 = array_values($_REQUEST);// obtiene los valores de las varibles

     for($i=0;$i<$numero2;$i++){ 
         $resp .= $tags2[$i]."=".$valores2[$i]."\r\n"; 
      }
	   if ( $numero2 < 1 || !isset($_REQUEST['order_number']) || !isset($_REQUEST['merchant_order_id']) ) {
 	      header("Location: ../index.php");
          exit;
	  }
    if (ExisteOrderNumber($_REQUEST['order_number'],$conexion) == 0) {
      $resp2 = str_replace("'"," ",$resp);
      $FormatMaestros = "INSERT into vtcheckout (order_number,respuesta) values ('%s','%s') ";
      $queMaestros = sprintf($FormatMaestros, $_REQUEST['order_number'],$resp2);
      $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
      mysqli_free_result($resMaestros);
	}
    $errorTxt .= ProcesoRepetido($_REQUEST['merchant_order_id'],$_REQUEST['credit_card_processed'],$conexion);

//////////////////////////////////////////////////////////////////////////// Datos de la solicitud
$mailOrganizador = $DatosWeb->GetTrimValor('CorreoPrincipal');
$f_emision   = "";
$f_cobro     = "";
$f_anulacion = "";
$email       = "";
$concepto    = "";
$descripcion = "";
$importe     = 0;
$moneda      = "";
$datosCorrectos = 0; 
if (!empty($_REQUEST['merchant_order_id'] )) {        
	     $FormatMaestros = "SELECT id, 
         	                      f_emision,
         	                      f_cobro, 	
         	                      f_anulacion, 
         	                      email_destino, 
         	                      importe, 
         	                      moneda, 
         	                      concepto, 
         	                      descripcion
                              FROM vtsolcobro     
                             WHERE id = %d";
         $queMaestros = sprintf($FormatMaestros,$_REQUEST['merchant_order_id']);
         $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));     
         $totMaestros = mysqli_num_rows($resMaestros);     
         if ($totMaestros > 0){
         	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
         		 $f_emision   = $rowVTMaestros['f_emision'];
                 $f_cobro     = $rowVTMaestros['f_cobro'];
                 $f_anulacion = $rowVTMaestros['f_anulacion'];
                 $email       = $rowVTMaestros['email_destino'];
                 $concepto    = $rowVTMaestros['concepto'];
                 $descripcion = $rowVTMaestros['descripcion'];
                 $importe     = $rowVTMaestros['importe'];
                 $moneda      = $rowVTMaestros['moneda'];      
         	 }	
         } else {
         		$errorTxt .= " No existe la solicitud número = ".$_REQUEST['merchant_order_id'];
         }
         mysqli_free_result($resMaestros);
} else {
	$errorTxt .= " Número merchant_order_id = 0";
} // de solicitud !=0 
     
////////////////////////////////////// ////////////////////////////////////// comprobar la key, real o test
$keyOK = 0; 

$hashSecretWord = ''; //2Checkout Secret Word
$hashSid = 0; //2Checkout account number

//............................................................................leer la key
$FormatMaestros = "SELECT  twocheck_real_id, twocheck_real_word	
                    FROM vtparametros 
				    WHERE id = 1";
$queMaestros = sprintf($FormatMaestros);
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
    
//.................................................................leer el total importe 
$hashTotal = $importe.".00"; //Sale total to validate against

$hashOrder = $_REQUEST['order_number']; //2Checkout Order Number y no 1 como reza el manual

$StringToHash = strtoupper(md5($hashSecretWord . $hashSid . $hashOrder . $hashTotal));

if ($StringToHash != $_REQUEST['key']) {
	  $errorTxt .= " StringToHash no cuadra. Salimos del proceso sin anotar en tablas ";
	  $ToHashOK = 0;

	} else { 
	  $ToHashOK = 1;
}

//////////////////////////////////////////////////////////////////////////// comprobar si procesada la tarjeta 
$tarjeta_procesada = 0;
$tmp1 = $_REQUEST['credit_card_processed'];
if ($tmp1 == "Y") {
	$tarjeta_procesada = 1;
} else {
    $errorTxt .= " No se ha procesado la tarjeta ";
}

  
if ($tarjeta_procesada == 1 && $ToHashOK == 1 && $errorTxt == "") {
   $numeroAlta = InsertaVTCobrosOtros($conexion,$email ,$_REQUEST['order_number'], $_REQUEST['invoice_id'], $importe, $_REQUEST['merchant_order_id']);
   
    UpdateVTsolcobro($conexion, $numeroAlta); 
    
   $datosCorrectos = 1;
} else {
   gravaError($errorTxt,$conexion,$mailOrganizador); 
}// de tarjeta procesada
//////////////////////////////////////////anotar en vtcheckout cómo ha ido el proceso
	$FormatSelect = "UPDATE vtcheckout set proceso_ok = '%s' where order_number = '%s'";
    $queSelect = sprintf($FormatSelect,$datosCorrectos,$_REQUEST['order_number']);
    $resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion)); 
    mysqli_free_result($resSelect); 
    
?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $DatosWeb->GetTrimValor('web_dominio') ?>  Respuesta 2checkout</title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,500,800" rel="stylesheet">    
<script  src="VideotutorialesLoginNOIndex.js"></script> 
<?php include_once('../paginas/PaginaCabecera.php'); ?>     
<?php
include_once('../paginas/NewWebEstilosNOIndex.php');
include_once('IndexScript.php');
include_once('../paginas/PaginaCursoPHP01_2.php');  

$clausulaNOTIN = "";  //...................................para seleccionar cursos y no cursos del alumno
if(	$_SESSION['NumeroUsuario'] != 0) {  
	$longitud = count($_SESSION['permisos']);
	if ($longitud > 0) {
       for($i=0; $i<$longitud; $i++) {
	        if ($i == 0 ) {
		      $clausulaNOTIN .= "(".$_SESSION['permisos'] [$i];
	        }  else {
		      $clausulaNOTIN .= ",".$_SESSION['permisos'] [$i];
	        }
        }
	$clausulaNOTIN .= ")";
    }
}
?>
<script>
     Nombre_correo = '<?php echo $DatosWeb->GetTrimValor('NombrePrincipal') ?>';
     emisorcorreo = '<?php echo $DatosWeb->GetTrimValor('CorreoPrincipal') ?>';
</script>  

<script>
bodyCartaCli = "";
function PResuelveBodyCarta(mail, numeroID, todoOK, DescriError)	{
	
        var parametros = { 
                "numID"       : numeroID , 
                "TodoOK"      : todoOK ,   
                "error"       : DescriError 
        };  
        
		$.ajax({
             data:  parametros,
             url:   '../cartas/CartaCobrosOtrosConfirmacionPago.php',
             type:  'post',
             beforeSend: function () {
                       $("#CAmarcoMensaje").html("Componiendo carta de confirmación..."); 
             },
             success:  function (response) {
				 bodyCartaCli = response;
				 EnviaCartaCliente(mail,bodyCartaCli); 
             },
			 error: function(){
                $("#CAmarcoMensaje").html("<span class='rojo'>Error componiendo carta</span>");
				return false;
            }
        });	
}
//........................................................
function EnviaCartaCliente( Pmail, PbodyCartaCli)	{
		     var parametros = {
			  "email"         : Pmail ,
			  "bodyCarta"     : PbodyCartaCli,
              "asunto"        : "Respuesta pago de servicios"     
			  
              };  
             
	$.ajax({
             data:  parametros,
             url:   '../php/VTEnviaCartaCorreoPrincipal.php',
             type:  'post',
             beforeSend: function () {
                      $("#CAmarcoMensaje").html("Enviando mail ...."); 
             },
             success:  function (response) {
					 if (response != "OK") {
						$("#CAmarcoMensaje").html("<span class='rojo'>"+response+"</span>"); 
						return false;
					 } else {
						 $("#CAmarcoMensaje").html("Le hemos enviado un Email"); 
						return true;
					 }
             },
			 error: function(){
                $("#CAmarcoMensaje").html("<span class='rojo'>Error enviando Email</span>");
				return false;
            }
        });	
}
</script>
</head>


<body onload='PResuelveBodyCarta(<?php echo '"'.$email.'",'.$_REQUEST['merchant_order_id'].','.$datosCorrectos.','.'"'.$errorTxt.'"' ?>);'> 

 

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

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
 
 <h1 class ="NewtituloApartado">Pago de servicios prestados</h1>

<?php
     include_once('../paginas/PantallaPwd.php');
?>  
  
<div class="ficha_fila">
<?php     
if ($datosCorrectos == 1){
     $resolucion = "Pago <strong>realizado correctamente</strong>. Gracias por su confianza";
 }  else {
     $resolucion = "NO hemos podido procesar su tarjeta, ERROR: <span class='rojo'>".$errorTxt."</span>";
 }  
?>     
<p class="centro"><?php echo $resolucion; ?></p>
</div> <!--ficha_fila-->


<div class="ficha_CobrosOtros"> <!-- Pantalla ficha operación-->
    <div class="NewCelda_40_Cobro">Fecha:</div>
    <div class="NewCelda_60_Cobro"><?php echo $f_emision ?> </div>
    <div class="clear"></div> 
        
    <div class="NewCelda_40_Cobro">Concepto:</div>
    <div class="NewCelda_60_Cobro"><?php echo $concepto ?></div>
    <div class="clear"></div> 
        
    <?php if (!empty($descripcion)) { ?>  
       <div class="NewCelda_40_Cobro">Descripción:</div>
       <div class="NewCelda_60_Cobro"><?php echo $descripcion ?></div>
       <div class="clear"></div>    
    <?php } ?>

    <div class="NewCelda_40_Cobro">Importe:</div>
    <div class="NewCelda_60_Cobro"><?php echo $importe.' '.$moneda ?></div>
    <div class="clear"></div> 
    
</div>    <!--(Fin) Pantalla ficha operación-->
<div class="PocoEspacio10"></div>    
<div id="CAmarcoMensaje" class="centro"></div>
<div class="PocoEspacio"></div>
<div class="centro"><input name="Salir" type="button" class ="ButtonGrisP" value ="Salir" onClick="location.href='../index.php'" /> </div>
    
<div class="separadorGrande"></div>   
 
<div class="centro90"><?php include_once('../paginas/PaginaPieNOIndex.php'); ?></div>
<?php include_once('../paginas/PaginaCursoPHP01_4.php'); ?>
 
</body>
</html>
<?php 
//////////////////////////////////////////////////////////
function UpdateVTsolcobro($conexion,$idCobrosOtros) {
         $FormatUpdate = "UPDATE vtsolcobro SET f_cobro = CURDATE(), id_cobrosotros = %d WHERE id = %d"; 
         $queUpdate = sprintf($FormatUpdate,$idCobrosOtros,$_REQUEST['merchant_order_id'] ); 
         $resUpdate = mysqli_query($conexion, $queUpdate) or die(mysqli_error($conexion));
         mysqli_free_result($resUpdate);  
}
////////////////////////////////////////////////////////
function InsertaVTCobrosOtros($conexion,$email,$orden,$factura,$importe,$id_vtsolcobro) {
$FormatMaestros = "INSERT into vtcobrosotros (email_cliente,
                                              fecha_emision,
                                              numero_orden,
                                              numero_factura,
                                              importe,
                                              id_solcobro,
											  codigo_pais,
											  ciudad) 
	             values ('%s',CURDATE(),'%s','%s',%d,%d,'%s','%s') ";				  
$queMaestros = sprintf($FormatMaestros,$email,$orden,$factura,$importe,$id_vtsolcobro,$_REQUEST['country'],strtoupper($_REQUEST['city']));   
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
mysqli_free_result($resMaestros);
    
//......................
  $ultimoNumero = 0;
  $FormatSelect = "select max(id) as NUMERO from vtcobrosotros";
  $queSelect = $FormatSelect;
  $resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
  $totSelect = mysqli_num_rows($resSelect);     
  if ( $totSelect > 0 ) {
  	while ($rowVTPwd = mysqli_fetch_assoc($resSelect)) {
  		    $ultimoNumero = $rowVTPwd['NUMERO']; 		    
  	 }	
  }	
   mysqli_free_result($resSelect);   
  return $ultimoNumero;
}
//////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
function gravaError($errores,$conexion) {
	
    $headers = "Content-type: text/html; charset=iso-8859-1\r\n"; 
	$FormatSelect = "UPDATE vtcheckout set error = '%s' where order_number = '%s'";
    $queSelect = sprintf($FormatSelect,$errores,$_REQUEST['order_number']);

    $resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion)); 	
	
	$titulocorreo  = "Error en proceso de cobro con tarjeta Cobros Otros: "."\n\n";
    $cuerpoComercial = "=== Order de respuesta 2checkout   ========================================================\n";
    $cuerpoComercial .= "NUMERO: ".$_REQUEST['order_number']."\n";
    $cuerpoComercial .= "EMAIL: ".$email."\n";
    $cuerpoComercial .= "ERROR: ".$errores."\n";
    $cuerpoComercial .= "OBSERVACIONES: mirar la tabla VTCHECKOUT, NO se ha anotado f_cobro\n";
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
$FormatMaestros = "SELECT id
                   FROM   vtcobrosotros
                   WHERE  id_solcobro = %d
				 ";
$queMaestros = sprintf($FormatMaestros,$NumSolicitud);
	
	
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     

if ($totMaestros > 0){
	 $tmpError = "Proceso Repetido";	
} else {
	 	 $tmpError = "";	
	
}	
 mysqli_free_result($resMaestros);
return $tmpError;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function ExisteOrderNumber($PorderNumber,$conexion) {
  $TotalEncontrados = 0;
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
