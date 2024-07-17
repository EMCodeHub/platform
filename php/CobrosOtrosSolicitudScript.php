<?php
include_once ('FicherosFunciones.php');
include_once('ParametrosClass.php'); //Clase ParametrosClass
if (!isset($_REQUEST['operacion'])) {
	$_REQUEST['operacion'] = "NADA";
}
if (!isset($_REQUEST['id'])) {
	$_REQUEST['id'] = 0;
}
if (!isset($_REQUEST['filtro'])) {
	$_REQUEST['filtro'] = "FILTRO_ID"; 
}
if (!isset($_REQUEST['FechaFiltro'])) {
		$_REQUEST['FechaFiltro'] = date("Y-m-d",strtotime($fecha_actual."- 30 days"));
}



///////////////Otras ////////////////////////////////////
function comas($cadena) {
   return "'".$cadena."'";
}

///////////////Maestros ficha ////////////////////////////////////
function elfecha($nombre,$tipo) {
	$devolver ="";
	$pos = strpos($tipo,'date');
	if ($pos !== false) {
         if ($nombre == 'f_emision' || $nombre =='f_clickenlace' || $nombre =='f_mail') {
		     $devolver = "";
	     } else {
             $devolver = '<input type="button" id="'."BOT".$nombre.'" value="..." />'; 
         }		
	}
	return $devolver;
}
///////////////Maestros ficha ////////////////////////////////////
function esFecha($tipo){
$pos = strpos($tipo,'date');
	if ($pos !== false) {
		return TRUE;
	}	
	return false;
}

///////////////////////////////////////////////////
function esTextArea($nombre) {

	if ($nombre == 'concepto'){
		return TRUE;
	}
    if ($nombre == 'descripcion'){
		return TRUE;
	}
	return false;
}
///////////////////////////////////////////////////
function elinput($nombre, $valor,$tipo,$activarSelect,$conexion) {
	$carpeta = "";
	$readonly = "";
	$inicio = strpos($tipo,'(');
	$final   =strpos($tipo,')');
	$long = 12;
    $valida = "";
    
    if ($valor == "") {
       $readonly = "";  
    } else {
       $readonly = "READONLY"; 
    }
    
   
    
    
    if ($nombre == 'f_emision') {
		$readonly = "READONLY";
        $valor = date("Y-m-d");
        return "<input ".$readonly." id = '".$nombre."' name='".$nombre."' value='".$valor."' maxlength='".$long."'".$valida.' size = "'.$long.'"'."/>";
	}
    
	if ($nombre == 'id') {
		$readonly = "READONLY";
	}
    if ($nombre == 'id_cobrosotros') {
		$readonly = "READONLY";
	}
    
    
    if ($nombre == 'f_clickenlace') {
		$readonly = "READONLY";
	}
     if ($nombre == 'f_mail') {
		$readonly = "READONLY";
	}
	if ($nombre == 'email_destino') {
		$valida = " onchange='CPVerificarDireccionCorreo(1)'";  //validación con etiqueta de existe alumno
	}
    if ($nombre == 'f_cobro') {
		$valida = " onchange='CPValidaCobroAnulacion($activarSelect)'";  
	}
    if ($nombre == 'f_anulacion') {
		$valida = " onchange='CPValidaCobroAnulacion($activarSelect)'";  
	}
    if ($nombre == 'importe') {
		$valida = " onchange='CPValidaImporte()'";  
	}
    if ($nombre == 'concepto') {
		$valida = " onchange='CPValidaConcepto()'"; 
	}
     if ($nombre == 'moneda'){  //en una select rara, para cobrar en USD ó EUR
	      $return = hazSelectIndiceMoneda($valor,$nombre,$activarSelect,$conexion); 
		  return $return; //..................................................................................input propio
     }
    
    
    
    //....................varchar
	$pos = strpos($tipo,'archar(');
	if ($pos !== false) {
		$long = substr($tipo,$inicio+1,$final-$inicio-1);
	    //...si es una imaIcono
		
		//echo "es string..."; //debug
		
		//if ($nombre == 'programa_pdf'){
		//    $carpeta = "../CURSOSPROGRAMAS/";	
		//}
		
	   
		
		if ($carpeta != "") {
			if (is_dir($carpeta)) {
			    if ($dh = opendir($carpeta)) { 
			     $return =  '<select name="'.$nombre.'">';
				 $return = $return.'<option></option>';
                 while (($file = readdir($dh)) !== false) { 
				     if ($file == $valor) {
						 $selected = "selected";
					 } else {
						  $selected = "";
					 }
				     if ($file!="." && $file!="..") { 
				      $return = $return. '<option '.$selected.'>'.$file.'</option>';
				     }
				 }
               $return = $return.'</select>';
		       return $return; //..................................................................................input propio
			   }
		   }
		} // es una carpeta valida	
        
        
        
        
        
        
	} //de strpost false
	//.......................................................si es entero
	

	$pos = strpos($tipo,'int(');
	if ($pos !== false) {
      $long = substr($tipo,$inicio+1,$final-$inicio-1);
	  $valida .= " onKeypress='return solonumeros()' ";
	 
	 
	  /*if ($_REQUEST['alta'] == 1) {
	 
	     if ($nombre == 'id_curso'){  //es un campo indice hay que hacer una select a su fichero
	         $return = hazSelectIndiceCursos("vtcursos","id_curso",$valor,$conexion,"id_curso",0,1); 
		  return $return; //..................................................................................input propio
	     }
	  } else {
		 if ($nombre == 'id_curso'){  //es un campo indice hay que hacer una select a su fichero
	         $return = hazSelectIndiceCursos("vtcursos","id_curso",$valor,$conexion,"id_curso",0,0); 
		  return $return; //..................................................................................input propio
	     }

		  
	  }*/
	  
	/*  	if ($nombre == 'tipoalumno'){  //es un campo indice hay que hacer una select a su fichero
	      $return = hazSelectIndiceTipoAlumno("vttipoalumno","id",$valor,$conexion,"tipoalumno",0,1); 
		  return $return; //..................................................................................input propio
	  }
*/
	
	  	
	}
   //.....................................
	//.... si no es varchar ni int el long sera de 12  sera textarea ?????
	if ($long <= 100) {
	    return "<input ".$readonly." id = '".$nombre."' name='".$nombre."' value='".$valor."' maxlength='".$long."'".$valida.' size = "'.$long.'"'."/>";
	} else {
		$colu = ($long /100 ) +1;
		return '<textarea '.$readonly.' '.$valida.' id="'.$nombre.'"'.' name="'.$nombre.'" cols="100" rows="'.$colu.'">'.$valor.'</textarea>';

	}
}
///////////////////MaestrosLista///////////////////////////////////////////////////
function pintaSolicitudesCobro($conexion) {
    $query = 'show columns FROM vtsolcobro';
    $datosLista = mysqli_query($conexion, $query);
	$nColumnas = mysqli_num_rows ($datosLista); 
    if ($nColumnas > 0) {
		$n = 0;
		 while ($row = mysqli_fetch_assoc($datosLista)) {
    		 $CampoMombre[$n] = $row['Field'];
			 $CampoTipo[$row['Field']] = $row['Type'];
			 $n++;
		 }
		
	}
    

//echo " ..................................................".$_REQUEST['operacion'];

if ($_REQUEST['operacion'] == "UPDATE"){
    $FormatMaestros = "UPDATE  vtsolcobro SET ";
    $n = 0;
	$ValorGrabar = "";
    for( $i = 0; $i < $nColumnas ; $i++ ) {
	     if($n == 0){
		    $coma = "";
	     } else {
		    $coma = ", ";
	     }
	
	     $ValorGrabar =  ValorVacioOk($_REQUEST[$CampoMombre[$i]],  $CampoTipo[$CampoMombre[$i]]);
	     $FormatMaestros = $FormatMaestros.$coma.$CampoMombre[$i]." = ".$ValorGrabar." ";
	     
	$n++;
    }

    $FormatMaestros = $FormatMaestros." WHERE  id = ".$_REQUEST['id'];

   //  echo $FormatMaestros;  

	$resMaestros = mysqli_query($conexion, $FormatMaestros) or die(mysqli_error($conexion));
	
} 
if ($_REQUEST['operacion'] == "INSERT"){ //........desestimado, nunca llamaremos con insert, se hace con Ajax
	$FormatMaestros = "INSERT INTO vtsolcobro (";
    $n = 0;
    for( $i = 0; $i < $nColumnas ; $i++ ) {
	     if($n == 0){
		    $coma = "";
	     } else {
		    $coma = ", ";
	    }
	$FormatMaestros = $FormatMaestros.$coma.$CampoMombre[$i];
	$n++;
    }
	$FormatMaestros = $FormatMaestros.") VALUES ( NULL ";
    $coma = ", ";
	
	$ValorGrabar = "";
	for( $i = 1 ; $i < $nColumnas ; $i++ ) {
	    $ValorGrabar =  ValorVacioOk($_REQUEST[$CampoMombre[$i]],  $CampoTipo[$CampoMombre[$i]]); 
        if ($CampoMombre[$i] == "f_emision") {
            $ValorGrabar = "'".date("Y-m-d")."'";
        } 
        if ($CampoMombre[$i] == "activo") {
		     $ValorGrabar = 1;
        } 
        
	   $FormatMaestros = $FormatMaestros.$coma.$ValorGrabar;
    }
	$FormatMaestros = $FormatMaestros.")";
	  //
	
    $resMaestros = mysqli_query($conexion, $FormatMaestros) or die(mysqli_error($conexion));
	
}  // ...... de insert



	
	if ($_REQUEST['filtro'] == "FILTRO_ID" &&  $_REQUEST['FechaFiltro'] <> "" && $_REQUEST['FechaFiltro'] <> "0000-00-00"){
		
		$FormatMaestros = "SELECT id, 
	                              f_emision, 
                                  f_mail,
                                  f_clickenlace,
	                              f_cobro, 	
	                              f_anulacion, 
	                              email_destino, 
	                              importe, 
	                              moneda, 
	                              concepto, 
	                              descripcion, 
	                              id_cobrosotros
                             FROM vtsolcobro   
                            WHERE f_emision >= '%s' 
						    ORDER by f_emision";
		                   
         $queMaestros = sprintf($FormatMaestros,$_REQUEST['FechaFiltro'] ); 
	
	    //echo "hoyhoy".$queMaestros;
	
	} else {
		
		$FormatMaestros = "SELECT id, 
	                              f_emision,
                                  f_mail,
                                  f_clickenlace,
	                              f_cobro, 	
	                              f_anulacion, 
	                              email_destino, 
	                              importe, 
	                              moneda, 
	                              concepto, 
	                              descripcion, 
	                              id_cobrosotros
                             FROM vtsolcobro   
						    ORDER by f_emision";
		                   
         $queMaestros = $FormatMaestros; 
	
	}
	
   //..........ejecutar query 
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);

//echo "<br>totMaestros--->".$totMaestros;




if ($totMaestros> 0) {  //.....Registro de conexión
   echo "<div class = rowCabeceraAsesoria >";
   for( $i = 0; $i < $nColumnas ; $i++ ) {
		echo "<div class = ".tipoClase($CampoTipo[$CampoMombre[$i]],0).">".$CampoMombre[$i]."</div>";	
	 }
   echo "</div><br>";  // de rowGrupo		
   while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
   	
   	
   	
   	
   	
   	
	          echo '<A NAME="'.$rowRegistros['id'].'">';
			  
	          echo "<div class = 'rowAsesoria' onclick='edita(".$rowRegistros[$CampoMombre[0]].")'>";  //siempre pasamos el primer campo, es la id QuimGrupos
			  for( $i = 0; $i < $nColumnas ; $i++ ) {

		     // echo $CampoMombre[$i].".........".tipoClase($CampoTipo[$CampoMombre[$i]]);
		      echo "<div class = ".tipoClase($CampoTipo[$CampoMombre[$i]],1).">".contenidoFigura($rowRegistros[$CampoMombre[$i]],$CampoMombre[$i],$conexion )."</div>";
	          }
			  echo "</div><br>";  // de rowSeccion	
			  
			  
			  
			  
          }
   
   
   echo '<div class = "rowCabeceraAsesoria" >';
   for( $i = 0; $i < $nColumnas ; $i++ ) {
		echo "<div class = ".tipoClase($CampoTipo[$CampoMombre[$i]],0).">".$CampoMombre[$i]."</div>";	
	 }
   echo "</div><br>";  		
}
   
  
/*mysqli_close($conexion);*/
return 0;
}
///////////////////MaestrosLista///////////////////////////////////////////////////
function tipoClase($tipo,$esCuerpo) {
	$inicio = strpos($tipo,'(');
	$final   =strpos($tipo,')');
	$complemento = "";
	$CAB = "";
    if ($esCuerpo == 0) { 
	 $CAB = "CAB";
	}
	//....................varchar
	$pos = strpos($tipo,'archar(');
	if ($pos !== false) {
		$long = substr($tipo,$inicio+1,$final-$inicio-1);
	    if ($long <= 60){
			$complemento = "Menor"; 
		} else {
			$complemento = "Mayor"; 
		}
		return "Class".$CAB."Varchar".$complemento;
	}
	//....................numero
	$pos = strpos($tipo,'int');
	if ($pos !== false) {
		return "Class".$CAB."Number"."Mayor";
	}



//

    //$pos = strpos($tipo,'int(');


	//if ($pos !== false) {
		//$long = substr($tipo,$inicio+1,$final-$inicio-1);
	    //if ($long <= 5){
			//$complemento = "Menor"; 
		//} else {
			//$complemento = "Mayor"; 
		//}
		//return "Class".$CAB."Number".$complemento;
	//}

	$pos = strpos($tipo,'decimal(');
	if ($pos !== false) {
		$long = substr($tipo,$inicio+1,$final-$inicio-1);
	    if ($long <= 5){
			$complemento = "Menor"; 
		} else {
			$complemento = "Mayor"; 
		}
		return "Class".$CAB."Number".$complemento;
	}
	//....................date
	$pos = strpos($tipo,'date');
	if ($pos !== false) {
		return "Class".$CAB."Date";
	}
}
///////////////////MaestrosLista///////////////////////////////////////////////////
function contenidoFigura($contenidoCampo, $mombreCampo,$conexion){

$pos = strpos($mombreCampo,'foto');	
	if ($pos !== false) {
		return '<div class="IzquierdaGrupo"><img src="../imagenes/ingredientes/'.$contenidoCampo.'" width="40" height="40" /></div>'."<div class='DerechaGrupo'>".    $contenidoCampo."</div>";
	} 


if ($contenidoCampo == NULL) {
	return "&nbsp;";	
}

if ($contenidoCampo == '0000-00-00') {
	$contenidoCampo = "&nbsp;";
}


return mysqli_real_escape_string($conexion,substr($contenidoCampo,0,50));
}

//////////////////////////////////////////////////////////////////////
function hazSelectIndiceMoneda($valorID,$nombreSelect,$Activar,$conexion) {
if ($Activar == 1){
    $Activado = '';
} else {
    //$Activado = 'disabled';
    $Activado = '';
}
    
    
    
$txtSelect ="";
$DatosWeb =   new ParametrosClass($conexion);
$txtSelect = $txtSelect.'<select '.$Activado.' id = '.$nombreSelect.' name="'.$nombreSelect.'"';                  
$txtSelect = $txtSelect.'>';

//.....primera opcion...moneda del programa
$valor = $DatosWeb->GetValor('moneda');
$descripcion = $DatosWeb->GetValor('moneda');
if ($valorID == $valor) {
	$selected = " selected";
} else {
	$selected = "";
}
$txtSelect = $txtSelect. '<option value = "'.$valor.'" '.$selected.'>'.$descripcion;

//.....segunda opcion...moneda alternativa
if ($valor == "USD"){
   $valor = "EUR";
   $descripcion = "EUR"; 
} else {
   $valor = "USD";
   $descripcion = "USD";  
}
if ($valorID == $valor) {
	$selected = " selected";
} else {
	$selected = "";
}
$txtSelect = $txtSelect. '<option value = "'.$valor.'" '.$selected.'>'.$descripcion;

    
//...Pie select   
$txtSelect = $txtSelect.'</select> ';
 return $txtSelect;



}  


?>
