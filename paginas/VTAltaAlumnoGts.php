<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
    
include_once('NewWebEstilosNOIndex.php');

$Referencia = $_REQUEST['Referencia'];
$numeroPrimo  = $DatosWeb->GetTrimValor('numeroprimo');;
$solicitud = 0;
$modulo = $Referencia % $numeroPrimo ;
if ($modulo == 0) {
	  $solicitud = $Referencia / $numeroPrimo ;  
} else {
	  echo "ERROR procesando inscripcon al curso, vuelva a inscribirse visitando la pagina:<br />";
	  echo "<a href='".$DatosWeb->GetTrimValor('web_url')."'>".$DatosWeb->GetTrimValor('web_dominio')."</a>";
	  
	  echo "</head>";
	  exit;
}

//.........................................................buscar datos de la solicitud
$cobroID = 1;
$alumnoID = 0;
$alumnoPWD = "medFK.".$solicitud;
$alumnoPais = "";
$cursoID = 0;
$loteCursos = "";
$mailAlumno = "";
$nombreAlumno = "";
$apellidosAlumno = "";
$telefonoAlumno = "";
$obser_medif = "";
$FormatMaestros = "SELECT id_curso, lotedecursos, email_cliente, nombre, apellidos, telefono, obser_medif, ciudad
                   FROM   vtsolicitudes
                   WHERE  id = %d
				          ";
$queMaestros = sprintf($FormatMaestros,$solicitud);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
		   $cursoID = $rowVTMaestros['id_curso'];                           
			 $mailAlumno = $rowVTMaestros['email_cliente'];
			 $loteCursos = $rowVTMaestros['lotedecursos'];
			 $nombreAlumno = $rowVTMaestros['nombre'];
			 $apellidosAlumno = $rowVTMaestros['apellidos'];
			 $telefonoAlumno = $rowVTMaestros['telefono'];
			 $obser_medif = $rowVTMaestros['obser_medif'];
			 $alumnoPais =  $rowVTMaestros['ciudad'];  
		    echo "<script>";
			  echo "lote = '".$loteCursos."';\n";
			  echo "</script>";
	 }	
} else {
	exit;
}
 mysqli_free_result($resMaestros);
 
//...................................................................dar de alta al alumno
//..............................................comprobar si existe......
$FormatSelect = "SELECT id
                   FROM vtalumnos
                  WHERE email = '%s'
				        ";
$queSelect = sprintf($FormatSelect, $mailAlumno);
$resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
$totSelect = mysqli_num_rows($resSelect);     
if ( $totSelect > 0 ) {
	while ($rowVTPwd = mysqli_fetch_assoc($resSelect)) {
		    $alumnoID = $rowVTPwd['id'];
	 }	
}	
mysqli_free_result($resSelect);

//..............................................alta de alumno......
if ( $alumnoID == 0) {
    $FormatMaestros = "INSERT into vtalumnos (
     email,
     pais,
     telefono,	 	 
     pwd,	 	 
     nombre,		 
     apellidos,	 
     fecha_alta,			 
     observaciones_medif,
     tipoalumno,
     es_colaborador)  
	   values ('%s','%s','%s','%s','%s','%s','%s','%s',%d,0) ";
  $queMaestros = sprintf($FormatMaestros, $mailAlumno, $alumnoPais, $telefonoAlumno, $alumnoPWD, $nombreAlumno, $apellidosAlumno, date('Y-m-d') , 'Contesta correo GRATIS',7);
  $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
  //echo "<br />Hemos dado de alta al alumno<br />";
  mysqli_free_result($resMaestros);
 
  //............................................recuperar el id a manini...........
 
  $FormatSelect = "select max(id) as NUMERO from vtalumnos";
  $queSelect = $FormatSelect;
  $resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
  $totSelect = mysqli_num_rows($resSelect);     
  if ( $totSelect > 0 ) {
  	while ($rowVTPwd = mysqli_fetch_assoc($resSelect)) {
  		    $alumnoID = $rowVTPwd['NUMERO']; 		    
  	 }	
  }	
  mysqli_free_result($resSelect);
}
  
//............................................recuperar pwd
$FormatSelect = "SELECT id, pwd 
                   FROM vtalumnos
                  WHERE id  = %d
				        ";
$queSelect = sprintf($FormatSelect, $alumnoID);
$resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
$totSelect = mysqli_num_rows($resSelect);     
if ( $totSelect > 0 ) {
	while ($rowVTPwd = mysqli_fetch_assoc($resSelect)) {
		    $alumnoPWD = $rowVTPwd['pwd'];
		    echo "<script>";
		    echo "pwd ='".$rowVTPwd['pwd']."';";
		    echo "mail ='".$mailAlumno."'";
		    echo "</script>";
	 }	
}	
mysqli_free_result($resSelect);

//................................................comprobar si ya tiene permisos
$YaTienePermisos = 0;
$FormatSelect  = "SELECT id
                      FROM vtpermisos
				             WHERE id_usuario = %d
				               and vtpermisos.id_curso = %d
					        ";	
$queSelect = sprintf($FormatSelect, $alumnoID, $cursoID);
$resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
$totSelect = mysqli_num_rows($resSelect); 
   if ( $totSelect > 0 ) {
    	$YaTienePermisos = 1;
   }	
mysqli_free_result($resSelect);

//.....................................................alta de permisos
if ($YaTienePermisos == 0) {
   $FormatMaestros = "INSERT into vtpermisos (id_cobro,
                              id_usuario, 
                              id_curso	,
                              fecha_ini	) 
	                          values (%d,%d,%d,'%s') ";
   $queMaestros = sprintf($FormatMaestros, $cobroID, $alumnoID, $cursoID, date('Y-m-d'));
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
   mysqli_free_result($resMaestros);
}


////////////////////////////////////// ////////////////////////////////////// vtsolicitudes actualizar comentario
  $FormatProceso = "UPDATE vtsolicitudes
                       SET obser_medif = '%s' 	                           
					           WHERE id = %d";
  $obser_medif = 'Contesta carta curso GRATIS';   
  $queProceso = sprintf($FormatProceso,$obser_medif,$solicitud);	
  $resProceso = mysqli_query($conexion, $queProceso) or die(mysqli_error($conexion)); 	
	mysqli_free_result($resProceso);
//........................................correo comercial
$correoE = "";
$NombreCorreoE = "";
$FormatCorreo = "SELECT A.id_curso,  A. id_mailcomer,  
                           B.id AS IDEMAIL, B.correoelectronico , B.nombre_correo  
                    FROM   vtcursos A, emailscomerciales B 
                    WHERE  A.id_mailcomer = B.id
                           and A.id_curso = %d";
$queCorreo = sprintf($FormatCorreo,$cursoID); 
$resCorreo = mysqli_query( $conexion, $queCorreo) or die(mysqli_error($conexion));
$totCorreo = mysqli_num_rows($resCorreo);
if ($totCorreo == 1) {
    while ($rowRegistros = mysqli_fetch_assoc($resCorreo)) {			  
			$correoE =  $rowRegistros['correoelectronico'];
			$NombreCorreoE =  $rowRegistros['nombre_correo'];
					 echo "<script>DENombre_correo = '".$NombreCorreoE."';\n";
			     echo "DEemisorcorreo = '".$correoE."';\n";
			     echo "</script>";			
	  }
}
mysqli_free_result($resCorreo);	

?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Respuesta Curso Gratis</title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script>
//...........................................................................
bodyCartaCli="";
function PResuelveBodyCarta()	{
		     var parametros = {   
			    "CBemail"       : mail ,
			    "Nombre_correo" : DENombre_correo ,
			    "Emisor_correo" : DEemisorcorreo,
			    "lote"          : lote ,
			    "PwdPalabra"    : pwd 
              };  
		$.ajax({
           data:  parametros,
           url:   '../cartas/CartaVTRespuestaGratis.php',
           type:  'post',
           beforeSend: function () {
             $("#CBmarcoMensaje").html("Componiendo carta ...Curso:"+lote); 
           },
           success:  function (response) {
				     bodyCartaCli = response;
				     EnviaCartaAlumno(mail,bodyCartaCli);
				     procesoActivo = 0; 
				     return true;
           },
			     error: function(){
             $("#CBmarcoMensaje").html("<span class='rojo'>Error componiendo carta</span>");
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


<body onload="PResuelveBodyCarta()"> 

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

<div class="NuevoAlumno">

  <img src="../imagenes/PantallaNuevaConexion2.jpg"  alt="<?php echo $DatosWeb->GetTrimValor('web_dominio') ?> Login" />
    <br />
    <br />
    <div id = "CBmarcoMensaje" >&nbsp;</div>
    <div class="centro"> 
        <p>Si no recibe el email con los datos de conexión póngase en contacto con nosotros</p>
        <br/>
        <p>Le hemos dado de alta como: <b><?php echo $mailAlumno ?></b> con la password: <b><?php echo $alumnoPWD ?> </b></p>
        <p> <a href="<?php echo $DatosWeb->GetTrimValor('web_url') ?>">Para ver el curso pulsa este enlace y haz un LOGIN con los datos facilitados</a></p>
    </div>
    
    
    <br />


</div>
 <br /> <br />
<div class="centro90"><?php include_once('PaginaPieNOIndex.php'); ?></div>



</body>
</html>
