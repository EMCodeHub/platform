
<?php

  include_once('../conexion/conn_bbdd.php');
  session_start();
 if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
} 

if ($_REQUEST['NumeroTrozo'] == 0) {
	$modo = "wb+";
} else {
	$modo = "ab+";
}
if ($_REQUEST['NumeroTrozo'] == 1) {
   chmod($_REQUEST['fichero'], 0755);
}

  //$file = fopen($_REQUEST['fichero'], "w+");
  $file = fopen($_REQUEST['fichero'], $modo);
  fwrite($file, $_REQUEST['bodycurso']);
  fflush($file);
  fclose($file);
 //if ($_REQUEST['NumeroTrozo'] == $_REQUEST['TotalTrozos']) {
 //   chmod($_REQUEST['fichero'], 0755);
// }
 
?>
