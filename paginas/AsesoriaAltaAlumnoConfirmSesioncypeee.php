<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('NewWebEstilosNOIndex.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);

$Referencia = $_REQUEST['Referencia'];
$numeroPrimo  = $DatosWeb->GetTrimValor('numeroprimo');
$solicitud = 0;
$altaNueva = 0;
$modulo = $Referencia % $numeroPrimo ;
if ($modulo == 0) {
	  $solicitud = $Referencia / $numeroPrimo ;  
    
} else {
	  echo "ERROR procesando la RESERVA de videoconferencia, inténtelo de nuevo en: ";
	  echo "<a href='".$DatosWeb->GetTrimValor('web_url')."/paginas/capacitacion.php'>".$DatosWeb->GetTrimValor('web_dominio')."</a>";
	  
	  echo "</head>";
	  exit;
}

//.........................................................buscar datos de la solicitud
$cobroID = 14;
$alumnoID = 0;
$ipConexion =  getRealIP();
              $Dia           = "";          
			  $Hora          = 0;        
			  $Correo        = "";        
			  $Telefono      = "";      
			  $UsuSkype      = "";      
			  $Nombre        = "";        
			  $Apellidos     = "";     
			  $Ciudad        = "";        
			  $Pais          = "";          
			  $Observaciones = ""; 
              $obser_medif   = "Alta de Asesoria";
$FormatMaestros = "SELECT id, activo, f_alta, f_confirmacion, f_sesion, h_inicio, h_final, ciudad, 
                             skype_usuario, telefono, email, pais, observa_cliente, observa_medif, id_alumno, nombre, apellidos  
                        FROM landingcursos   
                       WHERE id = %d";
$queMaestros = sprintf($FormatMaestros,$solicitud);
   /* echo "<br />@@@ Referencia-->".$Referencia;
    echo "<br />@@@ Solicitud-->".$solicitud;
    echo "<br />@@@ Query-->".$queMaestros;*/
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
 if ($totMaestros > 0){
	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
              $Dia           =  $rowVTMaestros['f_sesion'];         
			  $Hora          =  $rowVTMaestros['h_inicio'];        
			  $Correo        =  $rowVTMaestros['email'];      
			  $Telefono      =  $rowVTMaestros['telefono'];    
			  $UsuSkype      =  $rowVTMaestros['skype_usuario'];    
			  $Nombre        =  $rowVTMaestros['nombre'];      
			  $Apellidos     =  $rowVTMaestros['apellidos'];   
			  $Ciudad        =  $rowVTMaestros['ciudad'];      
			  $Pais          =  $rowVTMaestros['pais'];        
			  $Observaciones =  $rowVTMaestros['observa_cliente'];
	 }	
  } else {
    echo "Error procesando la solicitud";
	exit;
  }
 mysqli_free_result($resMaestros);
 
//...................................................................dar de alta al alumno
//..............................................comprobar si existe......
$FormatSelect = "SELECT id
                   FROM vtalumnos
                  WHERE email = '%s' ";
$queSelect = sprintf($FormatSelect, $Correo);
$resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
$totSelect = mysqli_num_rows($resSelect);     
if ( $totSelect > 0 ) {
	while ($rowVTPwd = mysqli_fetch_assoc($resSelect)) {
		    $alumnoID = $rowVTPwd['id'];
	 }	
}	
mysqli_free_result($resSelect);

//.................................................................................
if ( $alumnoID == 0) {
    //.................................................alta alumno si id = 0
    $altaNueva = 1;
    $Pwd = "Asesoria123";
    $FormatMaestros = "INSERT into vtalumnos (
     email,
     pwd,
     tipoalumno,
     nombre,
     apellidos,
     pais,
     ciudad,
     skype_usuario,
     telefono,
     agente,
     fecha_alta,
     observaciones_medif,
     ultima_ip,
     ultima_conexion )  
	   values ('%s', '%s', %d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s') ";
  $queMaestros = sprintf($FormatMaestros, $Correo , $Pwd, 0, $Nombre, $Apellidos, $Pais, $Ciudad, $UsuSkype, $Telefono, "Asesoria", date('Y-m-d'), 'Alta Asesoria', $ipConexion, date('Y-m-d'));
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
} else {
//.................................................updatear usuario Skype, ciudad en alumnos
   $FormatTemas = "UPDATE vtalumnos set 
                    nombre  = '%s',
                    apellidos = '%s',
                    pais = '%s',
                    ciudad = '%s',
                    skype_usuario = '%s',
                    telefono = '%s'
                 WHERE id= %d";
   $queTemas = sprintf($FormatTemas,$Nombre,$Apellidos,$Pais,$Ciudad,$UsuSkype,$Telefono,$alumnoID); 
   $resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion)); 
   mysqli_free_result($resTemas);       
}
//............................................actualizar asesoriassesiones: f_confirmacion, id_alumno
   $FormatTemas = "UPDATE landingcursos set 
                          f_confirmacion  = '%s',
                          id_alumno = %d
                    WHERE id= %d";
   $queTemas = sprintf($FormatTemas,date('Y-m-d'),$alumnoID,$solicitud);  
   $resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion)); 
   mysqli_free_result($resTemas);      
//............................................recuperar pwd
$FormatSelect = "SELECT id, pwd 
                   FROM vtalumnos
                  WHERE id  = %d ";
$queSelect = sprintf($FormatSelect, $alumnoID);
$resSelect = mysqli_query($conexion, $queSelect) or die(mysqli_error($conexion));                                                        
$totSelect = mysqli_num_rows($resSelect);     
if ( $totSelect > 0 ) {
	while ($rowVTPwd = mysqli_fetch_assoc($resSelect)) {
		    $alumnoPWD = $rowVTPwd['pwd'];
	 }	
}	
mysqli_free_result($resSelect);


?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Alta Sesión Asesoría</title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>


<body> 

 


<div class="NuevoAlumno2">

  <div class="centro"> 
        <br/>
        <br />
       <br />
         <?php if($Dia >= date('Y-m-d')) {  ?>
              <b>Queda confirmada la llamada para el día <?php echo $Dia ?> a las <?php echo $Hora ?> horas</b>
         <?php  } else {  ?>
              <span class="rojo">Esta VídeoConferencia es anterior a hoy, estaba programada para el día: <?php echo $Dia ?></span>
      
         <?php  }  ?>
        <br />
        <br />
        <?php if($altaNueva == 1){ ?>
             <p>Te hemos dado de alta como: <b><?php echo $Correo ?></b> con la password: <b><?php echo $alumnoPWD ?> </b></p>
             <p> <a href="<?php echo $DatosWeb->GetTrimValor('web_url') ?>/paginas/capacitacion.php">Puedes utilizar este usuario para futuras reservas</a></p>
        <?php } ?>
        
    </div>
  <img src="../imagenes/reservallamada.png"  alt="Foro" />
    
    <br />
    <br />
    <div id = "CBmarcoMensaje" >&nbsp;</div>
  
    
    
    <br /> <br />


</div>




</body>
</html>
