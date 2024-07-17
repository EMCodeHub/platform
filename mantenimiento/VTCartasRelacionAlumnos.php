<!doctype html>
<?php
include_once('../conexion/conn_bbdd.php');
?>
<html>
<head>
<meta charset="UTF-8">
<title>Relación de Alumnos por Carta Promocional</title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />
<script>
	   function VerActividadAlumno(registro) {
		   URL = "ActividadAlumno.php?NumeroAlumno="+registro;
	       window.open(URL,"Registro actividad alumno","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=250,TOP=150") 	
	   }    
</script>
</head>

<body>
    <?php $DatosCarta = DatosCabeceraCarta($conexion,$_REQUEST['NumeroCarta']) ?>
    <div class="fondoAzul"> 
        Carta: <?php echo $DatosCarta[1]; ?> Fecha: <?php echo $DatosCarta[0]; ?>
        <p> Asunto: <?php echo $DatosCarta[2]; ?> </p>
    </div>
    <div class="centro">Pulse sobre el alumno para ver su actividad</div>
    <div class="centro">
       <div class="CPFechaT">F. Carta</div>
       <div class="CPUconexionT">Últ. conex.</div>
       <div class="CPDiasT">Días</div>
       <div class="CPemailT">E-mail</div>
       <div class="CPermisosT">Permisos</div>
       <div class="CPNombreT">Nombre</div>
       <div class="CPApellidosT">Apellidos</div>
<?php  
         $FormatAlumnos = "SELECT id_alumno, f_envio, email, nombre, apellidos, 
                                  IF (ultima_conexion IS NULL, '0000-00-00', ultima_conexion) AS FECHA_CON
                             FROM vtcartasregistros, vtalumnos
                            WHERE id_carta = %d
                              and vtcartasregistros.id_alumno = vtalumnos.id
                         ORDER BY -FECHA_CON, f_envio";  
          $queAlumnos = sprintf($FormatAlumnos, $_REQUEST['NumeroCarta']);
          $resAlumnos = mysqli_query($conexion, $queAlumnos) or die(mysqli_error($conexion)); 
          $totAlumnos = mysqli_num_rows($resAlumnos);     
          while ($rowAlumnos = mysqli_fetch_assoc($resAlumnos)) {
              $f_envio         =  $rowAlumnos['f_envio']; 
              $ultima_conexion =  $rowAlumnos['FECHA_CON'];
              $email           =  $rowAlumnos['email'];
              $nombre          =  $rowAlumnos['nombre'];
              $apellidos       =  $rowAlumnos['apellidos'];
              $dias            =  dias_transcurridos($f_envio, $ultima_conexion);
              $permisos        =  CursosAlumno($rowAlumnos['id_alumno'],$conexion);
              
              echo "<div class = 'rowCartaAlumno' onclick='VerActividadAlumno(".$rowAlumnos['id_alumno'].")'>";
              echo '<div class="CPFechaD">'.Fecha0($f_envio).'</div>';
              echo '<div class="CPUconexionD">'.Fecha0($ultima_conexion).'</div>';
              echo '<div class="CPDiasD">'.$dias.'</div>';
              echo '<div class="CPemailD">'.$email.'</div>';
              echo '<div class="CPermisosD">'.$permisos.'</div>';
              echo '<div class="CPNombreD">'.Nombre0($nombre).'</div>';
              echo '<div class="CPApellidosD">'.Nombre0($apellidos).'</div>';
              echo '</div>';
              
              
              echo '<div class="clear"></div>';
          }
          mysqli_free_result($resAlumnos);            
?>       
       <div class="CPFechaT">F. Carta</div>
       <div class="CPUconexionT">Últ. conex.</div>
       <div class="CPDiasT">Días</div>
       <div class="CPemailT">E-mail</div>
       <div class="CPermisosT">Permisos</div>
       <div class="CPNombreT">Nombre</div>
       <div class="CPApellidosT">Apellidos</div>       
        
    </div>  <!--Centro-->
    <br /><br /><br />
    
</body>
</html>
<?php
//..............................................................................................  
function DatosCabeceraCarta($conexion,$numeroCarta){
    $Fecha = "";
    $Fichero = "";
    $Asunto = "";
    $Devolver = array();
           $FormatFecha = "SELECT asunto, fichero, f_creacion 
                             FROM vtcartascabecera
                            WHERE id = %d";  
          $queFecha = sprintf($FormatFecha, $numeroCarta);
          $resFecha = mysqli_query($conexion, $queFecha) or die(mysqli_error($conexion)); 
          $totFecha = mysqli_num_rows($resFecha);     
          while ($rowFecha = mysqli_fetch_assoc($resFecha)) {
              $Fecha   =  $rowFecha['f_creacion']; 
              $Fichero =  $rowFecha['fichero']; 
              $Asunto =  $rowFecha['asunto'];
               
          }
          mysqli_free_result($resFecha); 
     array_push($Devolver, $Fecha);    
     array_push($Devolver, $Fichero);   
     array_push($Devolver, $Asunto);   
    return $Devolver;  
}
//..............................................................................................   
function dias_transcurridos($fecha_i, $fecha_f) {
    if ($fecha_i == null || $fecha_i == '0000-00-00') {
        return "..";
    }
    if ($fecha_f == null || $fecha_f == '0000-00-00') {
        return "..";
    }
    
	$dias	= (strtotime($fecha_f)-strtotime($fecha_i))/86400;
	//$dias 	= abs($dias); 
    $dias = floor($dias);		
	return $dias;
}
//..............................................................................................   

function CursosAlumno($usuario,$conexion) {
	$devolver = "";
	$FormatMaestros = "  SELECT DISTINCT id_usuario, id_curso
                           FROM vtpermisos
                          WHERE id_usuario = %d
                       ORDER BY id_curso";
    $queMaestros = sprintf($FormatMaestros, $usuario);
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros);     
     if ($totMaestros > 0){
         $nn = 0;
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
            $nn++;
     	 	$curso = $rowMaestros['id_curso'];
     	 	$devolver .= ($nn == 1 ? $curso : ", ".$curso);	
     	 }
     }
mysqli_free_result($resMaestros);
return 	$devolver;
}
//..............................................
function Fecha0($fecha){
    return ($fecha == null ? "0000-00-00" :$fecha);  
}
//..............................................
function Nombre0($txt){
    return ($txt == null  || $txt == ""? ".........." :$txt);  
}
?>