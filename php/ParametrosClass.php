<?php
//Recoge valores de los ficheros de configuracion: vtparamdatosweb y ...
class ParametrosClass {
    var $conexion = null;
    var $valores  = array();
    
   
  
//..............................................................................
public function __construct($Conexion) {
       $this->conexion = $Conexion;
       $this->IniZio1();
       $this->IniZio2();
}
 
//..............................................................................
function IniZio1() {
	 //$this->valores = array("IniZio" => "i");
   $FormatParametros = "SELECT id,
                      web_dominio,
                      web_url,
                      web_logocolor,
                      web_logoblanco, 
                      web_logoforo,
                      descuento_activo,
                      web_usuarioskype,
                      web_tfnWhatsapp,
                      web_facebook,
                      web_instagram,
                      web_youtube,
                      web_twitter,
                      carta_logo,
                      carta_funcionempresa,
                      carta_direcc1,
                      carta_direcc2,
                      carta_codpostal,
                      carta_poblacion,
                      carta_pais,
                      numeroprimo, 
                      curso_en_promocion,
                      moneda,
                      idioma,
                      codigo_tagmanager,
                      codigo_analytics,
                      landing_reducida, 
                      favicon_32,
                      favicon_120,
                      favicon_152,
                      mapslocalizacion,
                      registro_mercantil,
                      tituloacademico,
                      colegioprofesional,
                      num_colegiado,
                      tribunal_legislacion,
                      tribunal_provincia,
                      nif,
                      finalidadweb               
                      FROM vtparamdatosweb
                      WHERE id = 1";
   $queParametros = $FormatParametros;
   //$queParametros = sprintf($FormatParametros,$clase);
   $resParametros = mysqli_query($this->conexion, $queParametros) or die(mysqli_error($conexion));  
   $totParametros = mysqli_num_rows($resParametros); 
   if ($totParametros > 0){
	   while ($rowParametros = mysqli_fetch_assoc($resParametros)) { 
            $query = 'show columns FROM vtparamdatosweb';
            $datosLista = mysqli_query($this->conexion, $query);
            while ($row = mysqli_fetch_assoc($datosLista)) {
			            $this->valores = array_merge($this->valores, array($row['Field'] => $rowParametros[$row['Field']] ));
		        }
	   }
   }
   mysqli_free_result($datosLista); 
   mysqli_free_result($resParametros); 
   //print_r($this->valores);
}
//..............................................................................
function IniZio2() {
	 //$this->valores =correo tipo 1.................................
   $FormatParametros = "SELECT correoelectronico, nombre_correo               
                          FROM emailscomerciales
                         WHERE tipocorreo = 1";
   $queParametros = $FormatParametros;
   $resParametros = mysqli_query($this->conexion, $queParametros) or die(mysqli_error($conexion));  
   $totParametros = mysqli_num_rows($resParametros); 
   if ($totParametros > 0){
	   while ($rowParametros = mysqli_fetch_assoc($resParametros)) { 
            $this->valores = array_merge($this->valores, array('CorreoPrincipal'  => $rowParametros['correoelectronico'] ));
            $this->valores = array_merge($this->valores, array('NombrePrincipal'  => $rowParametros['nombre_correo'] ));
	   }
   }
   
  mysqli_free_result($resParametros);
//$this->valores =correo tipo 3.................................
 $FormatParametros = "SELECT correoelectronico, nombre_correo               
                          FROM emailscomerciales
                         WHERE tipocorreo = 3";
   $queParametros = $FormatParametros;
   $resParametros = mysqli_query($this->conexion, $queParametros) or die(mysqli_error($conexion));  
   $totParametros = mysqli_num_rows($resParametros); 
   if ($totParametros > 0){
	   while ($rowParametros = mysqli_fetch_assoc($resParametros)) { 
            $this->valores = array_merge($this->valores, array('CorreoSecundario'  => $rowParametros['correoelectronico'] ));
            $this->valores = array_merge($this->valores, array('NombreSecundario'  => $rowParametros['nombre_correo'] ));
	   }
   }
   mysqli_free_result($resParametros); 
   
   
  // print_r($this->valores);
}
//..............................................................................  
public function GetValor($NombreCampo) {
    return $this->valores[$NombreCampo];
}
//..............................................................................  
public function GetTrimValor($NombreCampo) {
    return trim($this->valores[$NombreCampo]);
}
//..............................................................................  
public function EscribeMenu($CarpetaDeLlamada) {
$salida = "";    
$FormatParametros = "SELECT id, activo, llamada_directa_pagina, etiqueta, carpeta, pagina, orden 
                       FROM vtparamdatosmenu
                      WHERE activo > 0
                   ORDER BY -orden";
   $queParametros = $FormatParametros;
   $resParametros = mysqli_query($this->conexion, $queParametros) or die(mysqli_error($conexion));  
   $totParametros = mysqli_num_rows($resParametros); 
   if ($totParametros > 0){
	   while ($rowParametros = mysqli_fetch_assoc($resParametros)) { 
           $CarpetaUbicacion = $rowParametros['carpeta'];
            if ($rowParametros['llamada_directa_pagina'] == 0) {
                  if ($CarpetaUbicacion == $CarpetaDeLlamada) {
                              $salida .= '<a href="'.$rowParametros['pagina'].'" >'.$rowParametros['etiqueta'].'</a>'; 
                  } else {
                      if ($CarpetaDeLlamada == "") {
                              $salida .= '<a href="'.$rowParametros['carpeta'].'/'.$rowParametros['pagina'].'" >'.$rowParametros['etiqueta'].'</a>'; 
                      } else {
                      
                          $tmp1 = '<a href="'.'../'.$rowParametros['carpeta'].'/'.$rowParametros['pagina'].'" >'.$rowParametros['etiqueta'].'</a>'; 
                          $tmp2 = str_replace('//','/',$tmp1); 
                          $salida .= $tmp2;
                      }
                  }
           
           } else {
           	 $salida .= '<a href="'.$rowParametros['pagina'].'" >'.$rowParametros['etiqueta'].'</a>'; 
           }
         
 	   }
   }
   mysqli_free_result($resParametros); 
   return $salida;    
}
 //..............................................................................  
public function EscribeMenuForos($CarpetaDeLlamada) {
$salida = "";    
$FormatParametros = "SELECT id, activo, llamada_directa_pagina, etiqueta, carpeta, pagina, orden 
                       FROM vtparamdatosmenu
                      WHERE activo > 0
                        AND carpeta <> 'paginas'
                        AND llamada_directa_pagina < 1
                   ORDER BY -orden";
   $queParametros = $FormatParametros;
   $resParametros = mysqli_query($this->conexion, $queParametros) or die(mysqli_error($conexion));  
   $totParametros = mysqli_num_rows($resParametros); 
   if ($totParametros > 0){
	   while ($rowParametros = mysqli_fetch_assoc($resParametros)) { 
           $CarpetaUbicacion = $rowParametros['carpeta'];
            if ($rowParametros['llamada_directa_pagina'] == 0) {
                  if ($CarpetaUbicacion == $CarpetaDeLlamada) {
                              $salida .= '<a href="'.$rowParametros['pagina'].'" >'.$rowParametros['etiqueta'].'</a>'; 
                  } else {
                      if ($CarpetaDeLlamada == "") {
                              $salida .= '<a href="'.$rowParametros['carpeta'].'/'.$rowParametros['pagina'].'" >'.$rowParametros['etiqueta'].'</a>'; 
                      } else {
                      
                          $tmp1 = '<a href="'.'../'.$rowParametros['carpeta'].'/'.$rowParametros['pagina'].'" >'.$rowParametros['etiqueta'].'</a>'; 
                          $tmp2 = str_replace('//','/',$tmp1); 
                          $salida .= $tmp2;
                      }
                  }
           
           } else {
           	 $salida .= '<a href="'.$rowParametros['pagina'].'" >'.$rowParametros['etiqueta'].'</a>'; 
           }
         
           
 	   }
   }
   mysqli_free_result($resParametros); 
   return $salida;    
}
   
} // fin de la clase

?>