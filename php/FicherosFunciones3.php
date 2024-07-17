<?php


//.........................................................................................
function ValorVacioOk($Valor, $TipoCampo) {
    $pos = strpos($TipoCampo,'date');
    if ($pos !== false) {
        return ($Valor == "" || $Valor == "0000-00-00") ? 'null' : "'".$Valor."'";
    }
    $pos = strpos($TipoCampo,'int');
    if ($pos !== false) {
        return ($Valor == "" || $Valor == 0) ? 'null' : "'".$Valor."'";
    }
    $pos = strpos($TipoCampo,'decimal');
    if ($pos !== false) {
        return ($Valor == "" ) ? '0.0' : "'".str_replace(",",".",$Valor)."'";
    }
  
    $pos = strpos($TipoCampo,'archar');
    if ($pos !== false) {
        return "'".$Valor."'";
    } 
    return $Valor;
}

?>
	