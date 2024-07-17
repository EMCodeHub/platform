<!doctype html>
<html lang="es">


<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<?php
echo "inicio pagina ......";
session_start();

if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}

include_once('../conexion/conn_bbdd.php');

$file = fopen("../CSVFicheros/AccesosRecursos.csv", "w");



echo "fichero abierto ......";

$FormatMaestros = "SELECT   email, ip_conex, vtusovideo.fecha AS FECHA, 'VIDEO' AS TIPO ,vtusovideo.id_recurso AS NUM_RECURSO, titulo_video AS TITULO, vtusovideo.id_curso AS NUM_CURSO, titulo_cur AS CURSO

  FROM   vtsesiones, vtusovideo, vtalumnos, vtcurmodbloqvideo, vtcursos
 WHERE   vtsesiones.id         = vtusovideo.id_sesion 
   and   vtsesiones.id_alumno  = vtalumnos.id
   and   vtusovideo.id_recurso = vtcurmodbloqvideo.id
   and   vtusovideo.id_curso   = vtcursos.id_curso

UNION

SELECT   email, ip_conex, vtusotema.fecha AS FECHA, 'TEMA' AS TIPO, vtusotema.id_recurso AS NUM_RECURSO, titulo_tema AS TITULO, vtusotema.id_curso AS NUM_CURSO, titulo_cur AS CURSO

  FROM   vtsesiones, vtusotema, vtalumnos, vtcurmodbloqtema, vtcursos
 WHERE   vtsesiones.id         = vtusotema.id_sesion 
   and   vtsesiones.id_alumno  = vtalumnos.id
   and   vtusotema.id_recurso = vtcurmodbloqtema.id
   and   vtusotema.id_curso   = vtcursos.id_curso

UNION

SELECT   email, ip_conex, vtusorecurso.fecha AS FECHA, 'RECURSO' AS TIPO, vtusorecurso.id_recurso AS NUM_RECURSO, titulo_recurso AS TITULO, vtusorecurso.id_curso AS NUM_CURSO, titulo_cur AS CURSO

  FROM   vtsesiones, vtusorecurso, vtalumnos, vtcurmodbloqrecurso, vtcursos
 WHERE   vtsesiones.id         = vtusorecurso.id_sesion 
   and   vtsesiones.id_alumno  = vtalumnos.id
   and   vtusorecurso.id_recurso = vtcurmodbloqrecurso.id
   and   vtusorecurso.id_curso   = vtcursos.id_curso
   ";
   $queMaestros = sprintf($FormatMaestros); 
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);
if ($totMaestros < 1) {
    exit;
}
 fwrite($file, "EMAIL;IP;FECHA;TIPO;NUM_RECURSO;TITULO;NUM_CURSO;CURSO" . PHP_EOL);
 while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
 
      $lineaSalida =  $rowRegistros['email'].";";
	  
      $lineaSalida .= $rowRegistros['ip_conex'].";";
      $lineaSalida .= $rowRegistros['FECHA'].";";
      $lineaSalida .= $rowRegistros['TIPO'].";";
      $lineaSalida .= $rowRegistros['NUM_RECURSO'].";";
      $lineaSalida .= $rowRegistros['TITULO'].";";
      $lineaSalida .= $rowRegistros['NUM_CURSO'].";";
      $lineaSalida .= $rowRegistros['CURSO'].";";
      fwrite($file, $lineaSalida . PHP_EOL);
 
 }
 fclose($file);
 mysqli_free_result($resMaestros);
 echo "<BR><br>EL FICHERO GENERADO ES: /CSVFicheros/AccesoRecursos.csv   
 <br> bájatelo con el fileZilla a tu máquina<br>
 <br>Hay que ordenarlo y filtrarlo con EXCEL<br>
 <br>";
?>
</html>