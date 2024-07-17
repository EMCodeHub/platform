<?php
//Nos pasan un fichero php, con su padre de llamada y grabamos en ficheros ctr_fic... los enlaces a otros procedimientos y funcionesque contienen
class ProcesosWriteClass {
    var $conexion = null;
    var $carpeta = "";
    var $fichero = "";
    var $pathCompleto = "";
    var $contenidoPagina = ""; // el texto del fichero oprocedimiento
    var $valoresTablas  = array();
    var $valoresAscendientes  = array(); //Los ficheros desde los que es llamado
    var $valoresDescendientes  = array(); //Los ficheros A los que llama, js, php
    var $valoresFunciones  = array(); 
    var $IDProcedimiento= 0;
    //..TABLAS.............................................
    var $patternTABLAInsert = '/ INTO[ ](.*?)[ ]/s';
    var $patternTABLAInsert2 = '/[ ]into[ ](.*?)[ ]/s';
    var $patternPreTABLAUpdate = '/\"UPDATE\"(.*?)}/s';
    var $patternTABLAUpdate = '/UPDATE (.*?) [SET-set]/s';
    var $patternPreTABLASelect = '/SELECT[ ](.*?);/s'; // de subgrupo, para localizar el from
    var $patternTABLASelect = '/FROM[ ](.*?)[\n|WHERE|ORDER|\']/s';
    //..FUNCIONES......................................................................
    var $patternFUNCTION = '/function[ ](.*?){/s';
    //..PHP Y JS......................................................................
    var $patternINCLUDE = '/include_once\((.*?)\);/s';
    var $patternREQUIRE = '/require_once\((.*?)\);/s';
    var $patternJS = '/<script  src=\"(.*?)\">/s';
    var $patternFORMULARIO = '/\$url_formulario(.*?)\?/s';
    var $patternACTION = '/\.action="(.*?)\"/s';
    var $patternPreMANTENIMIENTO = '/ContenedorDchaMantenimiento(.*?)<\/div>/s';
    var $patternMANTENIMIENTO = '/<li><a href=\"(.*?)\">/s';
    var $patternPreURL = '/\$\.ajax\((.*?)\}\);/s';
    var $patternURL = '/url\:(.*?)\,/s';
    var $patternURL2 = '/URL[ ]=[ ]\"(.*?)\?/s';
    var $patternDESTINO = '/ destino[ ]=[ ]\'(.*?)\?/s';
    var $patternSCRIPT = '/\<script[ ]src=(.*?)\>/s';
    var $patternSRC = '/<script type="text/javascript" src=(.*?)\>/s';
    var $patternRARO = '/[\'\"](.*?)\.php/s';



//..............................................................................
public function __construct($Pfichero, $Conexion) {

  echo "<br> Entramos en constructor";


       $this->conexion = $Conexion;
       $this->fichero = $Pfichero;
       $this->carpeta = $this->BuscaCarpeta($Pfichero);
       $this->pathCompleto = "../".$this->carpeta."/".$Pfichero;  //..llamado desde carpeta UTILIDADES
       $this->contenidoPagina = file_get_contents( $this->pathCompleto);
       $this->$IDProcedimiento = $this->GetIDProcedimiento($Pfichero);

       $this->LeeTablas($this->patternTABLAInsert, ""); // con un sólo pattern
       $this->LeeTablas($this->patternTABLAInsert2, ""); // con un sólo pattern

       $this->LeeTablas($this->patternTABLAUpdate , "" );
       $this->LeeTablas($this->patternTABLASelect , "" ); // con un sólo pattern
       $this->LeeFunciones($this->patternFUNCTION, "" ); // con un sólo pattern
  
 
  
       $this->LeeDescendientes($this->patternINCLUDE , "" );
       $this->LeeDescendientes($this->patternREQUIRE , "" );
       $this->LeeDescendientes($this->patternJS , "" );
       $this->LeeDescendientes($this->patternFORMULARIO, "" );
       $this->LeeDescendientes($this->patternACTION , "" );
       $this->LeeDescendientes($this->patternURL2 , "" );
 
      $this->LeeDescendientes($this->patternMANTENIMIENTO ,$this->patternPreMANTENIMIENTO); // 2 patterns
     $this->LeeDescendientes($this->patternDESTINO , "" );
      
      $this->LeeDescendientes($this->patternURL ,"");
     
      
       $this->LeeDescendientes($this->patternSCRIPT , "" );
       $this->LeeDescendientes($this->patternSRC , "" );
       $this->LeeDescendientesRARO($this->patternRARO , "" );

      echo "<br>".$this->VerDatos();
       $this->GravaDescendientes($this->$IDProcedimiento);
       $this->GravaFunciones($this->$IDProcedimiento);
       $this->GravaTablas($this->$IDProcedimiento);
       }
//..............................................................................
public function VerDatos() {
   $Mensaje = "<br>============== ================= ====================== =================";
   $Mensaje .= "<br>Carpeta: ".$this->carpeta;
   $Mensaje .= "<br>Fichero: ".$this->fichero;
   $Mensaje .= "<br>Path: ".$this->pathCompleto ;
   $Mensaje .= "<br>Contenid-Longitud: ".strlen($this->contenidoPagina) ;
   if (count($this->valoresAscendientes) > 0) {
     $Mensaje .= "<br>Padre: ".$this->valoresAscendientes [0];
   } else {
          $Mensaje .= "<br>Padre-sin: " ;
   }
   $Mensaje .= "<br>TABLAS.........";  
   for ($a = 0; $a < count($this->valoresTablas); $a++){
      $Mensaje .= "<br>........................".$this->valoresTablas[$a];  

   }
   $Mensaje .= "<br>FUNCIONES.........";  
   for ($a = 0; $a < count($this->valoresFunciones); $a++){
      $Mensaje .= "<br>........................".$this->valoresFunciones[$a];  

   }
   $Mensaje .= "<br>DESCENDIENTES.........";  
   for ($a = 0; $a < count($this->valoresDescendientes); $a++){
      $Mensaje .= "<br>Des........................".$this->valoresDescendientes[$a];  

   }

   
  return $Mensaje;
}

//..........................................................................
function GetDescendientes(){
  return $this->valoresDescendientes;
}
//..........................................................................
function GetProcedimiento(){
  return $this->fichero;
}


//...........................................................................
function GravaTablas($PID){
$FormatTmp = "SELECT id
                FROM ctr_fictablas
               WHERE id_tabla = %d
                 AND id_procedimiento = %d"; 
  for ($x = 0; $x < count($this->valoresTablas) ; $x++) {
     $queTmp = sprintf($FormatTmp, $this->GetIDTabla($this->valoresTablas[$x]), $PID);
     $resTmp = mysqli_query($this->conexion, $queTmp) or die(mysqli_error($this->conexion));  
     $totTmp = mysqli_num_rows($resTmp);     
     if ($totTmp == 0) {
	    $FormatInsert = "INSERT INTO ctr_fictablas (`id`, `id_procedimiento`,`id_tabla`) VALUES (NULL, %d, %d)"; 
	    $queInsert = sprintf($FormatInsert, $PID, $this->GetIDTabla($this->valoresTablas[$x]));
        $resInsert = mysqli_query($this->conexion, $queInsert) or die(mysqli_error($this->conexion));  
        mysqli_free_result($resInsert);
      }
      mysqli_free_result($resTmp); 
  }  
}
//.........................................................................
function GetIDTabla($tabla) {
   $devolver = 0;
   $FormatBus = "SELECT id
                   FROM ctr_tablas
                  WHERE tabla_nombre = '%s'"; 
  
   $queBus = sprintf($FormatBus,$tabla);
   $resBus = mysqli_query($this->conexion, $queBus) or die(mysqli_error($this->conexion));  
   $totBus = mysqli_num_rows($resBus);     
   if ($totBus > 0){
	 while ($rowBus = mysqli_fetch_assoc($resBus)) { 
         $devolver = $rowBus['id'];
   	 }
   }
   mysqli_free_result($resBus); 
   return $devolver;
}

//...........................................................................
function GravaFunciones($PID){
$FormatTmp = "SELECT id
                FROM ctr_ficfunciones
               WHERE nombre_funcion = '%s'
                 AND id_procedimiento = %d"; 
  for ($x = 0; $x < count($this->valoresFunciones) ; $x++) {
     $queTmp = sprintf($FormatTmp,$this->valoresFunciones [$x], $PID);
     $resTmp = mysqli_query($this->conexion, $queTmp) or die(mysqli_error($this->conexion));  
     $totTmp = mysqli_num_rows($resTmp);     
     if ($totTmp == 0) {
	    $FormatInsert = "INSERT INTO ctr_ficfunciones (`id`, `id_procedimiento`,`nombre_funcion`) VALUES (NULL, %d,'%s')"; 
	    $queInsert = sprintf($FormatInsert, $PID, $this->valoresFunciones [$x]);
        $resInsert = mysqli_query($this->conexion, $queInsert) or die(mysqli_error($this->conexion));  
        mysqli_free_result($resInsert);
      }
      mysqli_free_result($resTmp); 
  }  
}


//......................................................................
function GravaDescendientes($PID){
//...primero miramos si existe de registro D, = descendiente
$FormatTmp2 = "SELECT id
                FROM ctr_ficpadreshijos
               WHERE ascen_descen = 'D'
                 AND  id_procedimiento = %d
                 AND  id_fichero = %d"; 
                 
 for ($x = 0; $x < count($this->valoresDescendientes) ; $x++) {
   if ( $this->GetIDProcedimiento($this->valoresDescendientes[$x]) != $PID && $this->GetIDProcedimiento($this->valoresDescendientes[$x]) > 0){
     $queTmp = sprintf($FormatTmp2, $PID, $this->GetIDProcedimiento($this->valoresDescendientes[$x]));
     
     echo "<br>Descendientes: ". $queTmp;
     
     $resTmp = mysqli_query($this->conexion, $queTmp) or die(mysqli_error($this->conexion));  
     $totTmp = mysqli_num_rows($resTmp);     
     if ($totTmp < 1) {
        echo "<br>Valor descendiente grabado->".$this->valoresDescendientes[$x];

        $FormatInsert = "INSERT INTO ctr_ficpadreshijos (`id`, `ascen_descen`, `id_procedimiento`, `id_fichero`) VALUES (NULL, 'D', %d, %d)"; 
	    $queInsert = sprintf($FormatInsert, $PID, $this->GetIDProcedimiento($this->valoresDescendientes[$x]));


     echo "<br>Descendientes Insert: ". $queInsert ;


        $resInsert = mysqli_query($this->conexion, $queInsert) or die(mysqli_error($this->conexion));  
        mysqli_free_result($resInsert);
      }   
   }    
   mysqli_free_result($resTmp); 
  //...ahora miramos si existe  registro A, = ascendiente
  $FormatTmp = "SELECT id
                  FROM ctr_ficpadreshijos
                 WHERE ascen_descen = 'A'
                   AND id_procedimiento = %d
                   AND id_fichero = %d"; 
  
   $queTmp = sprintf($FormatTmp,$this->GetIDProcedimiento($this->valoresDescendientes[$x]),$PID);
   $resTmp = mysqli_query($this->conexion, $queTmp) or die(mysqli_error($this->conexion));  
   $totTmp = mysqli_num_rows($resTmp);     
   if ($totTmp == 0){
	 $FormatInsert = "INSERT INTO ctr_ficpadreshijos (`id`, `ascen_descen`, `id_procedimiento`, `id_fichero`) VALUES (NULL, 'A', %d, %d)"; 
	 $queInsert = sprintf($FormatInsert,  $this->GetIDProcedimiento($this->valoresDescendientes[$x]),$PID);
     $resInsert = mysqli_query($this->conexion, $queInsert) or die(mysqli_error($this->conexion));  
     mysqli_free_result($resInsert);
   }
   mysqli_free_result($resTmp); 

  //...fin mirar registro C
 }  
 
}


//.........................................................................
function GetIDProcedimiento($proc) {
   $devolver = 0;
   $FormatBus = "SELECT id
                   FROM ctr_ficheros
                  WHERE fichero = '%s'"; 
  
   $queBus = sprintf($FormatBus,$proc);
   $resBus = mysqli_query($this->conexion, $queBus) or die(mysqli_error($this->conexion));  
   $totBus = mysqli_num_rows($resBus);     
   if ($totBus > 0){
	 while ($rowBus = mysqli_fetch_assoc($resBus)) { 
         $devolver = $rowBus['id'];
   	 }
   }
   mysqli_free_result($resBus); 
   return $devolver;
}
//......................................................................
function LeeDescendientes($pattenPropio, $patternSubGrupo){
 if (strlen($patternSubGrupo) > 0) {
    
    // echo "<br>Viene informado Pattern Subgrupo";
    // echo "<br> Elementos Subgrupo = ".preg_match_all($patternSubGrupo, $this->contenidoPagina, $matches);
     
     if (preg_match_all($patternSubGrupo, $this->contenidoPagina, $matches)) {
      
      //var_dump($matches);      
      
     for ($i = 0; $i < count($matches[0]); $i++) {
             $data = $matches[1][$i];
             
            // echo "<br>@@@@@@@@@@@@@@@@Encontrado Subgrupo-->".$data." número elemento ->".$i;
             // echo "<br> Elementos Propio: ".preg_match_all($pattenPropio, $data, $matches2);
              
             if (preg_match_all($pattenPropio, $data, $matches2)) {
                
               // var_dump($matches2);
                 
               //  echo "<br> Count count matches2[0] ".count($matches2[0]);
                 
                 for ($i2 = 0; $i2 < count($matches2[0]); $i2++) {
                      $tmp = trim($matches2[1][$i2]);
                      $palabras = explode("/",$tmp);
                      $fichero = $palabras [count($palabras)-1];
                      
                      //echo "<br>NombreFicheroLimpio-->".$this->LimpiaNombreFichero($fichero);
                      
                      $this->AltaArrayDescendientes($this->LimpiaNombreFichero($fichero)); 
                 }
             }
  
         }
      }
   } else {
   
      echo "<br>Con  path=1 grupos encontrados-->".preg_match_all($pattenPropio, $this->contenidoPagina, $matches);
   
      if (preg_match_all($pattenPropio, $this->contenidoPagina, $matches)) {
      
      //var_dump($matches);
      
      echo "<br> Count count matches[0]".count($matches[0]);
         for ($i = 0; $i < count($matches[0]); $i++) {
             $data = $matches[1][$i];
            // echo "<br>Elemento:".$data;
              $palabras = explode("/",$data);
              $fichero = $palabras [count($palabras)-1];
            
              $this->AltaArrayDescendientes($this->LimpiaNombreFichero($fichero)); 
         }
      }
}

}

//......................................................................
function LeeDescendientesRARO($pattenPropio, $patternSubGrupo){
    // echo "<br>Viene informado Pattern Subgrupo";
    // echo "<br> Elementos Subgrupo = ".preg_match_all($patternSubGrupo, $this->contenidoPagina, $matches);
      
      echo "<br>Con  path=1 grupos encontrados RARO-->".preg_match_all($pattenPropio, $this->contenidoPagina, $matches);
   
      if (preg_match_all($pattenPropio, $this->contenidoPagina, $matches)) {
      
      //var_dump($matches);
      
      echo "<br> Count count matches[0]".count($matches[0]);
         for ($i = 0; $i < count($matches[0]); $i++) {
             $data = $matches[1][$i];
            // echo "<br>Elemento:".$data;
              $palabras = explode("/",$data);
             
               $fichero = $palabras [count($palabras)-1].".php";  //esto le hace RARO, hemos quitado el .PHP y ahora lo añadimos
           
               //echo "<br>Raro----->".$fichero;
              if (strlen($fichero) < 40){
                  $this->AltaArrayDescendientes($this->LimpiaNombreFichero($fichero));
              } 
         }
      
}

}
//..............................................................................
function AltaArrayDescendientes($PElemento) {
   if (strlen($PElemento) == 0){
    return;
   }
   if (!in_array($PElemento, $this->valoresDescendientes)) {
      array_push($this->valoresDescendientes, $PElemento);
      //echo "<br>.................................. Alta en Array:".$nombreFichero." Elementos guardados->".count($this->valoresTablas);
   } 
}

//......................................................................
function LeeFunciones($pattenPropio, $patternSubGrupo){
      if (preg_match_all($pattenPropio, $this->contenidoPagina, $matches)) {
      //var_dump($matches);
      //echo "<br> Count count matches[0]".count($matches[0]);
         for ($i = 0; $i < count($matches[0]); $i++) {
             $data = $matches[1][$i];
            // echo "<br>Función:".$data;
            if ($data != "()" && $data != "(response)" ) {
             $this->AltaArrayFunciones($data); 
            }
         }
      }
}
//..............................................................................
function AltaArrayFunciones($PElemento) {
   if (!in_array($PElemento, $this->valoresFunciones)) {
      array_push($this->valoresFunciones, $PElemento);
      //echo "<br>.................................. Alta en Array:".$nombreFichero." Elementos guardados->".count($this->valoresTablas);
   } 
}

//..............................................................................
function LeeTablas($pattenPropio, $patternSubGrupo){
//..Si nos passan dos patterns es que usan pattern previos, buscaremos en continente o en cada general
  
     // echo "<br>Entro el Leetablas():";
      
      //echo "<br>Pattern Subgrupo: ".$patternSubGrupo;
      //echo "<br>Pattern Propio: ".$pattenPropio;

       //echo "<br>Contenid-Longitud: ".strlen($this->contenidoPagina);
      //echo "<br> Pregmatch Subgrupo: ".preg_match_all($patternSubGrupo, $this->contenidoPagina, $matches);

       //echo "<br>";

 if (strlen($patternSubGrupo) > 0) {
  
     if (preg_match_all($patternSubGrupo, $this->contenidoPagina, $matches)) {
      echo "<br> Pattern subgrupo".$patternSubGrupo;
      //var_dump($matches);
      
      
         for ($i = 0; $i < count($matches[0]); $i++) {
             $data = $matches[1][$i];
             
             echo "<br>@@@@@@@@@@@@@@@@Encontrado Subgrupo-->".$data." número elemento ->".$i;
              echo "<br> Pregmatch Propio: ".preg_match_all($pattenPropio, $data, $matches2);
             if (preg_match_all($pattenPropio, $data, $matches2)) {
             
                 var_dump($matches2);
                 
                 echo "<br> Count count matches2[0] ".count($matches2[0]);
                 
                 for ($i2 = 0; $i2 < count($matches2[0]); $i2++) {
                      $tabla = trim($matches2[1][$i2]);
             
                       echo "<br>Encontrada Tabla:".$tabla;
                 }
             }
  
         }
      }


   } else {
   
      if (preg_match_all($pattenPropio, $this->contenidoPagina, $matches)) {
      //var_dump($matches);
      //echo "<br> Count count matches[0]".count($matches[0]);
         for ($i = 0; $i < count($matches[0]); $i++) {
             $data = $matches[1][$i];
             
            // echo "<br>Encontrado:".$data;
             $ficheros = explode(",",$data);
             for ($i3 = 0; $i3 < count($ficheros); $i3++) {
               $nombreFichero = $ficheros [$i3];
               //echo "<br>............Encontrado Desglose:".$nombreFichero ;
                $this->AltaArrayTablas($this->LimpiaNombreFichero($nombreFichero));

             }

             
         }
      }
   }

}
//..............................................................................
function LimpiaNombreFichero($txt){
  $devolver = trim($txt);
   $devolver = str_replace("'", "",  $devolver);
  $devolver = str_replace('"', "",  $devolver);
  $devolver = str_replace("`", "",  $devolver);
  $devolver = str_replace("´", "",  $devolver);
  //echo "<br> Devuelvo---->". $devolver;
  return $devolver;
 }
//..............................................................................
function AltaArrayTablas($PElemento) {
   if (!in_array($PElemento, $this->valoresTablas)) {
      array_push($this->valoresTablas, $PElemento);
      //echo "<br>.................................. Alta en Array:".$nombreFichero." Elementos guardados->".count($this->valoresTablas);

   } else {
       //echo "<br>.................................. NO Alta Elementos guardados->".count($this->valoresTablas);
   }
}

//..............................................................................
function BuscaCarpeta($PFichero) {
   $devolver = "";
  
   $FormatTmp = "SELECT carpeta
                   FROM ctr_ficheros
                  WHERE fichero = '%s'";
 
   $queTmp = sprintf($FormatTmp,$PFichero);
   $resTmp = mysqli_query($this->conexion, $queTmp) or die(mysqli_error($this->conexion));  
   $totTmp = mysqli_num_rows($resTmp);     
  if ($totTmp > 0){
	 while ($rowTmp = mysqli_fetch_assoc($resTmp)) { 
         $devolver = $rowTmp['carpeta'];
   	 }
   }
mysqli_free_result($resTmp); 
return $devolver;  
}



//..............................................................................

//..............................................................................

//..............................................................................

//..............................................................................

//..............................................................................

//..............................................................................

//..............................................................................

//..............................................................................

//..............................................................................









} // fin de la clase

?>