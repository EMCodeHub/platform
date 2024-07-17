<?php
session_start();
$_SESSION['pruebas'] = 0;
if (!isset($_SESSION['NumeroSesion'])) {  
	$_SESSION['NumeroSesion'] = 0;        
}
if (!isset($_SESSION['NumeroUsuario'])) {                                        
	$_SESSION['NumeroUsuario'] = 0;        
}  
if (!isset($_SESSION['es_admin'])) {                                      
	$_SESSION['es_admin'] = 0;        
} 
if (!isset($_SESSION['es_colaborador'])) {                                       
	$_SESSION['es_colaborador'] = 0;        
} 
if (!isset($_SESSION['permisos'])) {                                       
	$_SESSION['permisos'] = array();              
} 
if (!isset($_SESSION['TipoAlumno'])) {                                       
	$_SESSION['TipoAlumno'] = 1;        
}  
if (!isset($_SESSION['LeadNumero'])) {                                      
	$_SESSION['LeadNumero'] = 0;        
}   
if (!isset($_SESSION['FicheroDeSesiones'])) {                                     
	$_SESSION['FicheroDeSesiones'] = "";        
}  
if (!isset($_SESSION['Id_FicheroDeSesiones'])) {                                      
	$_SESSION['Id_FicheroDeSesiones'] = 0;        
} 
if (!isset($_SESSION['cookieGrabada'])) {                                      
	$_SESSION['cookieGrabada'] = 0;        
} 
if (!isset($_SESSION['LeadRecalculado'])) {  
	$_SESSION['LeadRecalculado'] = 0;        
}
if (!isset($_SESSION['RegrabarCookies'])) {  
	$_SESSION['RegrabarCookies'] = 0;        
}
if (!isset($_SESSION['VideoCargado'])) {  
	$_SESSION['VideoCargado'] = 0;        
}
if (!isset($_SESSION['ver_curso'])) {  
	$_SESSION['ver_curso'] = 0;        
}
if (!isset($_SESSION['NumeroCurso'])) {  
	$_SESSION['NumeroCurso'] = 0;        
}
$TipoEnCookie = "";  //L=Lead, A=Alumno
$ReferenciaEnCookie = 0;
$numeroAlumno = 0;
$numeroLead   = 0;
$numeroPrimo  = $DatosWeb->GetTrimValor('numeroprimo');
$exitoConexionAlumno = false;
$exitoConexionLead   = false;
//.....................................................................Reasignar cookies si ya están definidas
if (isset($_COOKIE['Tipo'])){
       $TipoEnCookie = $_COOKIE["Tipo"];
}
if (isset($_COOKIE['Referencia'])){ //............será el numeroDeUsuario * 1229
       $ReferenciaEnCookie = $_COOKIE["Referencia"];
}
if ($_SESSION['NumeroUsuario'] == 0 && $_SESSION['LeadNumero'] == 0 ) {  //Miramos las COOKIES
   if ($TipoEnCookie == "A" && $ReferenciaEnCookie > 0){ //ReferenciaEnCookie deberá ser múltiplo de $numeroPrimo   
       $modulo = $ReferenciaEnCookie % $numeroPrimo ;
	   if ($modulo == 0) {
	       $numeroAlumno = $ReferenciaEnCookie / $numeroPrimo ;
		   if ($numeroAlumno > 0) {
	          $exitoConexionAlumno = BuscaPwdYConectate($numeroAlumno,$conexion);	// Si va bien $_SESSION['NumeroUsuario'] estará informado
           }   
       }
   }
   if ($TipoEnCookie == "L" && $ReferenciaEnCookie > 0){ //ReferenciaEnCookie deberá ser múltiplo de $numeroPrimo
       $modulo = $ReferenciaEnCookie % $numeroPrimo ;
	   if ($modulo == 0) {
	       $numeroLead = $ReferenciaEnCookie / $numeroPrimo ;  
		   $exitoConexionLead = BuscaLead($numeroLead,$conexion);  //  asignará $_SESSION['LeadNumero'] 
       }
    }
} 
// alumno   lead
//   0        0  => Ata de lead
//   1        0  => No hacer nada
//   0        1  => Recalcular tipo de lead
//   1        1  => Este caso no se puede dar
if($_SESSION['NumeroUsuario'] == 0  && $_SESSION['LeadNumero'] == 0) { //.... si me sigue devolviendo 0 y 0, darle de alta como lead
	AltaNuevoLead($conexion);	
} else if($_SESSION['NumeroUsuario'] == 0  && $_SESSION['LeadNumero'] > 0){
	if ($_SESSION['LeadRecalculado'] == 0) {
	   $tipoAlumnoAnterior = $_SESSION['TipoAlumno'];
	   RecalculaTipoLead($_SESSION['LeadNumero'],$conexion);     
	   if ($tipoAlumnoAnterior != $_SESSION['TipoAlumno']) {
		   ActualizaLead($_SESSION['LeadNumero'],$_SESSION['TipoAlumno'],$conexion); 
	   }
	}
} else {
	$a=1;
}
if ($_SESSION['NumeroUsuario'] > 0) {
	$COcaducidad = 60 * 60 * 24 * 90 + time(); // en tres  meses
	$COTipo ="A";
	$COnumeroReferencia = $_SESSION['NumeroUsuario']*$numeroPrimo;
} else {
	$COcaducidad = 60 * 60 * 24 * 30 + time(); // en 1  meses
	$COTipo ="L";
	$COnumeroReferencia = $_SESSION['LeadNumero']*$numeroPrimo;
}
 //echo "<br />@@@ Leido en cookies --->Tipo = ".$TipoEnCookie."   Referencia=". $ReferenciaEnCookie;
 //echo "<br />@@@ Calculado en coo --->Tipo = ".$COTipo."   Referencia=". $COnumeroReferencia;
if ($TipoEnCookie != "" ) {
	//echo "<br />@@@ GRABADO en coo --->Tipo = ".$COTipo."   Referencia=". $COnumeroReferencia;
    setcookie("Tipo", $COTipo, $COcaducidad); 
    setcookie("Referencia",$COnumeroReferencia, $COcaducidad); 
    $_SESSION['cookieGrabada'] = 1;	
	$_SESSION['RegrabarCookies'] = 1;
}
if ($_SESSION['FicheroDeSesiones'] != "") {   //anotar log de paginas
          $numero = ($_SESSION['NumeroUsuario'] >0 ? $_SESSION['NumeroUsuario'] : $_SESSION['LeadNumero']);
		  $ipConexion = getRealIP();
	      AnotaLogDePaginas($_SESSION['FicheroDeSesiones'], $numero,$ipConexion,$_SERVER['PHP_SELF'],$conexion);
}
?>