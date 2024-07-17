<?php
include_once('../conexion/conn_bbdd.php');
require_once('CartasPromocionalesSeleccionarScript.php');
require_once('CartasPromocionalesEnviaMailScript.php');
//....obtenemos el id del alumno de pruebas para añadirlo al final de cada lote y poder comprobar si se envía cada lote
$idAlumnoPruebas = ObtenerIDPruebas($conexion,ObtenerMailPruebas($conexion));
$idsEncontradas = array();
$IdCarta   = 0;
$Fichero   = "";
$Asunto    = "";
$AfegirNom = 0;
//.....................................................comprobamos que no haya otro proceso en marcha
if (ProcesoActivo($conexion) == 1) {
    echo "Hay activo un proceso reenviando cartas<br />En la tabla  vtcartascontrol el campo proceso_activo es igual a 1";
    echo "<br> Si considera que las cartas pendientes es un ERROR, ejecute la siguiente query:";
    echo "<br><b>UPDATE vtcartasregistros SET f_envio = curdate() WHERE f_envio is null</b>";
    //exit;
}
ActualizaProcesoActivo(1,$conexion);  //.... ponemos proceso_activo = 1

//.....................................................OBTENER datos DE LA CABECERA DE LA CARTA
         $FormatCarta = "SELECT id, fichero, asunto, afegirnombre 
                           FROM vtcartascabecera
                          WHERE id = (SELECT max(id) FROM vtcartascabecera T2)";  
          $queCarta = sprintf($FormatCarta);
          $resCarta = mysqli_query($conexion, $queCarta) or die(mysqli_error($conexion)); 
          $totCarta = mysqli_num_rows($resCarta);     
          while ($rowCarta = mysqli_fetch_assoc($resCarta)) {
               $idCarta   =  $rowCarta['id'];
               $Fichero   =  $rowCarta['fichero']; 
               $Asunto    =  $rowCarta['asunto']; 
               $AfegirNom =  $rowCarta['afegirnombre']; 
          }
          mysqli_free_result($resCarta); 
//......................................................................................... proceso de reenvío 
$bodyCarta = "";
$segundosDeEspera = 60*15; //quince minutos
//sleep($segundosDeEspera); 
$pendientes = Pendientes100($conexion,$idCarta);
while (count($pendientes) > 0) {
    for ($ireg=0;$ireg<count($pendientes);$ireg++) {
        $url = "https://".$_SERVER['HTTP_HOST']."/cartas/PomocionSemanal/".$Fichero."?NumeroAlumno=".$pendientes[$ireg];
        $bodyCarta = curl($url);  // Ejecuta la función curl escrapeando el sitio web 
		EnviaMail($Asunto,$pendientes[$ireg],$AfegirNom,$idCarta,$bodyCarta,$conexion);  
	}
    sleep($segundosDeEspera); 
    $pendientes = Pendientes100($conexion,$idCarta);    
}
ActualizaProcesoActivo(0,$conexion);  //.... ponemos proceso_activo = 0
echo "Todas las cartas están enviadas";
exit;



//.....................................................OBTENER próximos 100 registros pendientes
function Pendientes100($conexion,$idCarta){
    $registrosPendientes = array();
    $formatSeleccion = "SELECT id_alumno 
                          FROM vtcartasregistros 
                         WHERE id_carta = %d and f_envio is null
                         LIMIT 0, 100";
    $queSeleccion = sprintf($formatSeleccion, $idCarta);
		  //echo $queSeleccion;	  
    $resSeleccion = mysqli_query($conexion, $queSeleccion) or die(mysqli_error($conexion));  
    $totSeleccion = mysqli_num_rows($resSeleccion); 
	while ($rowSeleccion = mysqli_fetch_assoc($resSeleccion)) {
		 array_push($registrosPendientes, $rowSeleccion['id_alumno']);   //..en el array [4+n] grabamos los 100 primeros alumnos 
	}
    mysqli_free_result($resSeleccion); 
    return $registrosPendientes;
}
//........................................................
    function curl($url) {
        $ch = curl_init($url); // Inicia sesión cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
        $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
        curl_close($ch); // Cierra sesión cURL
        return $info; // Devuelve la información de la función
    }

?>
