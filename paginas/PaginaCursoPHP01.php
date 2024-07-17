<?php

  session_start();
   
//  if (!isset($_REQUEST['NumeroCurso'])) {
//	   $_REQUEST['NumeroCurso'] = 0;
//  }
  
  
    $_REQUEST['NumeroCurso'] = $NumeroCurso;
	$_SESSION['ver_curso'] = 0;
	$_REQUEST['modo_ver'] = 0;
  
	$_SESSION['NumeroCurso'] = $_REQUEST['NumeroCurso'];

      $longitud = count($_SESSION['permisos']);
      for($i=0; $i<$longitud; $i++) {
		       if ($_SESSION['permisos'] [$i] == $_SESSION['NumeroCurso']) {
	          $_SESSION['ver_curso'] = 1;
			      $_REQUEST['modo_ver'] = 1;
           }
       }

 

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