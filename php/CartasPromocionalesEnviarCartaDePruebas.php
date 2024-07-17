<?php
include_once('../conexion/conn_bbdd.php');
require_once('CartasPromocionalesSeleccionarScript.php');
require_once('CartasPromocionalesEnviaPruebasScript.php');
//....obtenemos el id del alumno de pruebas para añadirlo al final de cada lote y poder comprobar si se envía cada lote
$idAlumnoPruebas = ObtenerIDPruebas($conexion,ObtenerMailPruebas($conexion));
$idsEncontradas = array();
$IdCarta   = 0;
$Fichero   = "";
$Asunto    = "";
$AfegirNom = 0;
//.....................................................comprobamos que no haya otro proceso en marcha

ActualizaProcesoActivo(1,$conexion);  //.... ponemos proceso_activo = 1

               $Fichero   =  $_REQUEST['Carta']; 
               $Asunto    =  $_REQUEST['Asunto']; 
               $AfegirNom =  $_REQUEST['AfegirNom']; 
               $idCarta = 0; //ojo


//......................................................................................... proceso de reenvío 
$bodyCarta = "";
$segundosDeEspera = 60*15; //quince minutos
//sleep($segundosDeEspera); 

        $url = "https://".$_SERVER['HTTP_HOST']."/cartas/PomocionSemanal/".$Fichero."?NumeroAlumno=".$idAlumnoPruebas;
        $bodyCarta = curl2($url);  // Ejecuta la función curl escrapeando el sitio web 
		
        echo EnviaMailPruebas($Asunto,$idAlumnoPruebas,$AfegirNom,$bodyCarta,$conexion)." al alumno número:".$idAlumnoPruebas;
	
ActualizaProcesoActivo(0,$conexion);  //.... ponemos proceso_activo = 0

exit;



//........................................................
    function curl2($url) {
        $ch = curl_init($url); // Inicia sesión cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
        $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
        curl_close($ch); // Cierra sesión cURL
        return $info; // Devuelve la información de la función
    }

?>
