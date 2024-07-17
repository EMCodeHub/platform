<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>VERIFICAR Accesos SIN Permisos</title>
</head>

<body>
<?php
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
session_start();
//.......................................
function ArrayPermisos($usuario,$conexion) {  //todos los permisos, activos y caducados
	$permisos_usu = array();
	$FormatMaestros = "SELECT DISTINCT vtpermisos.id_curso
                     FROM vtpermisos, vtcursos
				        WHERE vtpermisos.id_curso = vtcursos.id_curso
						    and  vtcursos.esta_activo > 0 
					
					        and id_usuario   = %d 
					      ORDER BY vtpermisos.id_curso";
    $queMaestros = sprintf($FormatMaestros, $usuario);
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros);     
     if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
     	 	$cursoPagado = $rowMaestros['id_curso'];
     	 	array_push($permisos_usu, $cursoPagado);
     	 }
         
     }	
	 return $permisos_usu;		 				 
}
//......................................................................
function TienePermisos($PArrayPermisos,$numCurso,$conexion) {
	$longitud = count($PArrayPermisos);
	for($i=0; $i < $longitud; $i++) {
		if ($PArrayPermisos [$i] == $numCurso) {
			return true;
		}
	}
	return false;	
}
//.......................................
function Procesa($conexion){
	$ArrayPermisos = array();
$FormatArray = "SELECT  distinct vtsesiones.id_alumno, vtusovideo.id_curso, email
                   FROM  vtusovideo, vtsesiones, vtalumnos
				  WHERE  vtsesiones.id = vtusovideo.id_sesion
				    and  vtsesiones.id_alumno = vtalumnos.id       
			   ORDER BY vtsesiones.id_alumno, vtusovideo.id_curso";
    $queArray = sprintf($FormatArray, $numCurso, $numVideo);
    $resArray = mysqli_query($conexion, $queArray) or die(mysqli_error($conexion));                                                     
    $totArray = mysqli_num_rows($resArray);  
	if ($totArray > 0){
		$control = 0;
	    	$cc = 0;
     	 while ($rowArray = mysqli_fetch_assoc($resArray)) {
			 $curso = $rowArray['id_curso'];
			 $alumno = $rowArray['id_alumno'];
			 $email = $rowArray['email'];
			 
			 
			 if ($control != $alumno) {
				$cc = 0;
				$ArrayPermisos = ArrayPermisos($alumno,$conexion);
				
     	 	}
		
			 if (TienePermisos($ArrayPermisos,$curso,$conexion) == false) {
				 $cc++;
				 if ($cc == 1) {
				   echo "<br/> ".$alumno." ---------------------------------------------".$email;
				   /*echo "  Permisos ".count($ArrayPermisos)."--->";
	               for($i=0; $i < count($ArrayPermisos); $i++) {
		               echo $ArrayPermisos[$i]." , ";
	               }*/
				 }
				echo "<br />........ Sin permisos en curso -->". $curso;
			 }
			 
			 
			 
		 $control = $alumno;		 
		 }                                                       
     mysqli_free_result($resArray); 
     } 
}
?>
<br />	<br />
		<?php Procesa($conexion)  ?>
         <br /><br />
</body>
</html>