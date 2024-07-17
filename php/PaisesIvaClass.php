<?php
//Recoge los ivas por países.
class PaisesIva {
    var $conexion = null;
    var $valoresIva  = array();
    var $valoresIvaNombre  = array();
   
  
//..............................................................................
public function __construct($Conexion) {
       $this->conexion = $Conexion;
       $this->IniZio1();
}
 
//..............................................................................
function IniZio1() {
	 //$this->valores = array("IniZio" => "i");
   $FormatParametros = "SELECT id, 
							   codigo_pais, 
							   ciudad
							   nombre_iva,
							   iva
                         FROM  vtpaisesiva";
   $queParametros = $FormatParametros;
   //$queParametros = sprintf($FormatParametros,$clase);
   $resParametros = mysqli_query($this->conexion, $queParametros) or die(mysqli_error($conexion));  
   $totParametros = mysqli_num_rows($resParametros); 
   if ($totParametros > 0){
	    while ($rowParametros = mysqli_fetch_assoc($resParametros)) {
		    $codigo = $rowParametros['codigo_pais'].$rowParametros['zip'];
            $this->valoresIva = array_merge($this->valoresIva, array($codigo => $rowParametros['iva'] ));
            $this->valoresIvaNombre = array_merge($this->valoresIvaNombre, array($codigo => $rowParametros['iva'] ));
	
            // $this->valores = array_merge($this->valores, array($row['Field'] => $rowParametros[$row['Field']] ));
	   }
	  }

   mysqli_free_result($resParametros); 
   //print_r($this->valoresIva);
	//echo count ($this->valoresIva);
}

//..............................................................................  
public function GetIva($pais,$ciudad) {
	$clave = $pais.$ciudad;
	
	if (!is_null($this->valoresIva[$clave])){
		return $this->valoresIva[$clave];
	} else {
		$clave = $pais;
		if (!is_null($this->valoresIva[$clave])){
		    return $this->valoresIva[$clave];
	    } else {
			return 0;
		} 
			
	}
}
//..............................................................................
	
public function GetNombreIva($paisMasZip) {
   $clave = $pais.$ciudad;
	
	if (!is_null($this->valoresIvaNombre[$clave])){
		return $this->valoresIvaNombre[$clave];
	} else {
		$clave = $pais;
		if (!is_null($this->valoresIvaNombre[$clave])){
		    return $this->valoresIvaNombre[$clave];
	    } else {
			return 0;
		} 
	} 
}
	

   
} // fin de la clase

?>
