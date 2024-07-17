<?php
class AsesoriaSesion {
   var $conexion = null;
   var $listaEventos = array();
   var $f_inicio = "";
   var $f_final  = "";      

//..............................................................................
public function __construct($Conexion) {
 $this->conexion = $Conexion; 
 $this->f_inicio = date("Y-m-d", strtotime($this->f_inicio. ' + 1 days'));  
 $this->f_final  = date('Y-m-d', strtotime($this->f_inicio. ' + 45 days'));
 $this->CargaListaEventos();

}    

//..............................................................................
//.........................................construye los eventos de FullCalendar
public function PintaEventos() {
    $atornar = "events: [";
    $n =0;
    foreach($this->listaEventos as $evento) {
     if ($n != 0) {
          $atornar .= ",";  
     }
     $atornar .=  "{";
        //$atornar .= "id: ".$evento[0].",";
        $atornar .= "title: '- ".$evento[3]." Reservado',";
        $atornar .= "start: '".$evento[1]."T".$evento[2].":00:00',";
        $atornar .= "end: '".$evento[1]."T".$evento[3].":00:00',";
        $atornar .= "color: '#3A87AD',";
        $atornar .= "textColor: '#ffffff',";        
        $atornar .=  "}\n\r";  
        $n++;
    }    
    $atornar .=  "],";
    return $atornar;
}
//..............................................................................
//....................................ecribe  los eventos en un array javascript
function EscribeArrayEventos(){
  $atornar = "\n\rArrayEventos = [ ";
  $n =0;
  foreach($this->listaEventos as $evento) {
   if ($n != 0) {
          $atornar .= ",";  
     }   
     $atornar .=  "[";  
     $atornar .=  "'".$evento[1]."',";  
     $atornar .=  $evento[2].",";  
     $atornar .=  $evento[3];  
     $atornar .=  "]";  
     $n++;   
  }
  $atornar .=  "]\n\r";  
  return $atornar;
}
//..............................................................................
function CargaListaEventos() {
$FormatSesion = "SELECT id, f_sesion, h_inicio, h_final
                   FROM asesoriasesiones   
                  WHERE activo > 0
                    and f_sesion >= '%s' and f_sesion <= '%s'
                  ORDER by f_sesion, h_inicio";
$queSesion = sprintf($FormatSesion,$this->f_inicio,$this->f_final);
    //echo "<br />@@@Eventos->".$queSesion;
$resSesion = mysqli_query($this->conexion, $queSesion) or die(mysqli_error($conexion));  
$totSesion = mysqli_num_rows($resSesion);     
if ($totSesion > 0){
	while ($rowSesion = mysqli_fetch_assoc($resSesion)) {
        //echo "<br />@@@Eventos->".$rowSesion['f_sesion']." ".$rowSesion['h_inicio']." - ".$rowSesion['h_final'];
		$id		 	    = $rowSesion['id'];
        $fecha		 	= $rowSesion['f_sesion'];
        $h_ini		 	= $this->PonZero($rowSesion['h_inicio']);
        $h_fin		 	= $this->PonZero($rowSesion['h_final']);
        $tmp            = array($id,$fecha,$h_ini,$h_fin);
        array_push($this->listaEventos,$tmp);
	}
}
mysqli_free_result($resSesion); 
}
//..............................................................................
function PonZero($valor){
    if ($valor < 10) {
        return "0".$valor;
        
    }
    return $valor;
}

//.............................................................................. 
//.............................................................................. 
//.............................................................................. 
//.............................................................................. 

} // fin de la clase

?>