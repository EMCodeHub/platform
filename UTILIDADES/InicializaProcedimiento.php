<?php
//http://localhost/WEBPLANTILLAPREMIUM2021/UTILIDADES/InicializaProcedimiento.php
include_once('../conexion/conn_bbdd.php');
require_once('ClassProcesosWrite.php'); //Clase 
?>
tablas
=================================
  array_push($Tablas , array("ActividadProcedimiento.php", "ctr_tablas"));
  array_push($Tablas , array("EstadisticaAltaPermisos.php", "vtalumnos"));
  array_push($Tablas , array("EstadisticaAltaPermisos.php", "vtcursos"));
  array_push($Tablas , array("EstadisticaAltaPermisos.php", "vtpermisos"));
  array_push($Tablas , array("VTSesionesUsoRecursosScript.php", "vtusovideo"));
  array_push($Tablas , array("VTSesionesUsoRecursosScript.php", "vtusotema"));
  array_push($Tablas , array("VTSesionesUsoRecursosScript.php", "vtusorecurso"));
  array_push($Tablas , array("", ""));
  array_push($Tablas , array("", ""));
  array_push($Tablas , array("", ""));
  array_push($Tablas , array("", ""));
  array_push($Tablas , array("", ""));
  array_push($Tablas , array("", ""));
  array_push($Tablas , array("", ""));
  array_push($Tablas , array("", ""));


<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Prueba una clase</title>
</head>

<body>
<?php
  insertaAscendientes($conexion);

  $procedimiento = "AsesoriasYObras.php";

   $DatosClase =   new ProcesosWriteClass($procedimiento,$conexion);
   
   echo "<br> Clase finalizada";
?>
</body>

</html>

<?php
//.............................................................................
function insertaAscendientes($conexion){
  $PadresHijos = array();
  array_push($PadresHijos , array("Visa.php", "RespuestaCobro2Check.php"));
  array_push($PadresHijos , array("VisaDescuentos.php", "RespuestaCobro2Check.php"));
  array_push($PadresHijos , array("VisaCobrosOtros.php", "RespuestaCobro2CheckCobrosOtros.php"));


  array_push($PadresHijos , array("Foro.php", "BusquedaForo.php"));
 // array_push($PadresHijos , array("", "AccesosSinPermisos.php"));
  array_push($PadresHijos , array("ForosClasesLista.php", "ForosClasesFicha.php"));
  array_push($PadresHijos , array("CartasPromocionalesSeleccionar.php", "VTCartasPromocionalesLista.php"));
 // array_push($PadresHijos , array("", "Acceso.php"));
  array_push($PadresHijos , array("index.php", "AvisoLegal.php"));
  array_push($PadresHijos , array("VTCursoContenido.js", "BajarFichero.php"));
  array_push($PadresHijos , array("index.php", "Contacto.php"));
  array_push($PadresHijos , array("FichaDelCurso.php", "correosCursosCalendario.php"));
 // array_push($PadresHijos , array("", "correosPresupuestos.php"));
  array_push($PadresHijos , array("index.php", "CYPECursosPresenciales.php"));
  //array_push($PadresHijos , array("", "EstilosScripsIndex.php"));
  //array_push($PadresHijos , array("", "PaginaPresupuestos.php"));
  //array_push($PadresHijos , array("", "PaginaCursoPHP01_3.php"));
  array_push($PadresHijos , array("PaginaPresupuestos.php", "PresupuestoPeticion.php"));
  //array_push($PadresHijos , array("", "VideotutorialesLogin.php"));
  array_push($PadresHijos , array("AsesoriasYObras.php", "AsesoriaSesion.js"));
  array_push($PadresHijos , array("index.php", "AsesoriasYObras.php"));
 // array_push($PadresHijos , array("", "ContactoPeticion.js"));
  array_push($PadresHijos , array("FichaDelCurso.php", "CursoPeticion.js"));
 // array_push($PadresHijos , array("", "CYPEVideotutorialesScrip.php"));
 // array_push($PadresHijos , array("", "DemoPeticion.js"));
 // array_push($PadresHijos , array("", "VideoDelIndex.php"));
  array_push($PadresHijos , array("VideotutorialesCambioPwd.php", "VideotutorialesCambioPwd.js"));
 // array_push($PadresHijos , array("", "VTCursoContenidoCobrosIndex.js"));
  array_push($PadresHijos , array("AyudaProcedimientos.php", "ActividadProcedimiento.php"));
  array_push($PadresHijos , array("mantenimiento.php", "AyudaProcedimientos.php"));
  array_push($PadresHijos , array("AyudaProcedimientos.php", "AyudaProcedimientosUpdateDesc.php"));
  array_push($PadresHijos , array("index.php", "VTCalculoDescuentosCobrosIndex.js"));
  array_push($PadresHijos , array("index.php", "CURSOEjemplo.php"));
  array_push($PadresHijos , array("CURSOEjemplo.php", "VTCalculoDescuentosCobros.js"));
  array_push($PadresHijos , array("index.php", "PaginaPresupuestos.php"));
  array_push($PadresHijos , array("index.php", "Foro.php"));
 

   for ($x=0; $x < count($PadresHijos); $x++) {
       $array = $PadresHijos[$x];

       $Padre =  GetIDProcedimiento($array[0],$conexion);
       $Hijo =  GetIDProcedimiento($array[1],$conexion);
       echo "<br>Padre:".$Padre;
       echo "<br>Hijo:".$Hijo;
       
       altaHijos($Padre, $Hijo, "D", $conexion);
       altaHijos($Padre, $Hijo, "A", $conexion);
   }
}
//.............................................................................
function altaHijos($Padre, $PHijo, $ascen_descen, $conexion) {

//echo "<br> A funcion llega Padre:".$Padre;
//echo "<br> A funcion llega Hijo:".$PHijo;


   $FormatTmp = "SELECT id
                    FROM ctr_ficpadreshijos
                   WHERE ascen_descen = '%s'
                     AND  id_procedimiento = %d
                     AND id_fichero = %d";
 
  if ($ascen_descen == 'D') {            
    $queTmp = sprintf($FormatTmp, $ascen_descen, $Padre, $PHijo);
  } else {
     $queTmp = sprintf($FormatTmp, $ascen_descen, $PHijo, $Padre);
  }   
   
   //echo "<br>". $queTmp;
   

     $resTmp = mysqli_query($conexion, $queTmp) or die(mysqli_error($conexion));  
     $totTmp = mysqli_num_rows($resTmp); 
      echo "<br>Encontrados: ".$totTmp ;
     if ($totTmp == 0) {
        $FormatInsert = "INSERT INTO ctr_ficpadreshijos (`id`, `ascen_descen`, `id_procedimiento`,`id_fichero`) VALUES (NULL, '%s', %d, %d)"; 
        if ($ascen_descen == 'D') {
	      $queInsert = sprintf($FormatInsert ,$ascen_descen,   $Padre, $PHijo);
        } else {
          $queInsert = sprintf($FormatInsert ,$ascen_descen,  $PHijo,  $Padre);
        }
        
        echo "<br>".$queInsert;        
        $resInsert = mysqli_query($conexion, $queInsert) or die(mysqli_error($conexion));  
        mysqli_free_result($resInsert);
        
      } else {
        echo "<br>Ya existe ".$Padre."   ".$PHijo."    ".$ascen_descen; 
      }
   
  }

 //.........................................................................
function GetIDProcedimiento($proc,$conexion) {
   $devolver = 0;
   $FormatBus = "SELECT id
                   FROM ctr_ficheros
                  WHERE fichero = '%s'"; 
  
   $queBus = sprintf($FormatBus,$proc);
   $resBus = mysqli_query($conexion, $queBus) or die(mysqli_error($conexion));  
   $totBus = mysqli_num_rows($resBus);     
   if ($totBus > 0){
	 while ($rowBus = mysqli_fetch_assoc($resBus)) { 
         $devolver = $rowBus['id'];
   	 }
   }
   mysqli_free_result($resBus); 
   return $devolver;
}

?>


