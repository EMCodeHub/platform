
<?php


$conexion = mysqli_connect("", "", "", "");


//mysqli_options($mysqlconn, MYSQLI_INIT_COMMAND, 'SET @@SESSION.sql_mode = NO_ENGINE_SUBSTITUTION');

mysqli_query($conexion,"SET SESSION sql_mode = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");


//$conexion = mysqli_connect("localhost", "root", "root", "medif");

mysqli_set_charset ( $conexion , 'utf8' );
?>



<?php


//.........................................................................................
function ValorVacioOk($Valor, $TipoCampo) {
    $pos = strpos($TipoCampo,'date');
    if ($pos !== false) {
        return ($Valor == "" || $Valor == "0000-00-00") ? 'null' : "'".$Valor."'";
    }
    $pos = strpos($TipoCampo,'int(');
    if ($pos !== false) {
        return ($Valor == "" ) ? 0 : $Valor;
    }
    $pos = strpos($TipoCampo,'decimal(');
    if ($pos !== false) {
        return ($Valor == "" ) ? '0.0' : "'".str_replace(",",".",$Valor)."'";
    }
  
    $pos = strpos($TipoCampo,'archar(');
    if ($pos !== false) {
        return "'".$Valor."'";
    } 
    return $Valor;
}


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
	$pos = strpos($tipo,'int(');
	if ($pos !== false) {
		$long = substr($tipo,$inicio+1,$final-$inicio-1);
	    if ($long <= 5){
			$complemento = "Menor"; 
		} else {
			$complemento = "Mayor"; 
		}
		return "Class".$CAB."Number".$complemento;
	}
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
	
	
	return mysqli_real_escape_string($conexion, substr($contenidoCampo,0,50));
	}
	
















?>
	













<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>

<h1>hola</h1>


<div class = "Separador"> &nbsp;</div><br>

<div class="envoltorioCursos">


<?php



function pintaAlumnos($conexion) {
    $query = 'show columns FROM vtalumnos';
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
    $FormatMaestros = "UPDATE  vtalumnos SET ";
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
if ($_REQUEST['operacion'] == "INSERT"){
	    $FormatMaestros = "INSERT INTO vtalumnos (";
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
	    $FormatMaestros = $FormatMaestros.$coma.$ValorGrabar;
	}
	$FormatMaestros = $FormatMaestros.")";
	  //
		  
    $resMaestros = mysqli_query($conexion, $FormatMaestros) or die(mysqli_error($conexion));
	
}  // ...... de insert





	
	if ($_REQUEST['filtro'] == "FILTRO_ID" && $_REQUEST['CursoID'] !=0 && $_REQUEST['FechaFiltro'] <> "" && $_REQUEST['FechaFiltro'] <> "0000-00-00"){
		
		//echo "estamos en 1";
		
		
		$FormatMaestros = "SELECT DISTINCT vtalumnos.id, es_adm, es_colaborador, telefono, pais, ciudad, skype_usuario, agente, email, pwd, nombre, apellidos,fecha_alta, fecha_baja, observaciones_medif,tipoalumno, ultima_ip, ultima_conexion, recibir_mails, alias_foro, alias_comment,bloquear_foro, mensajes_foro 
		                   FROM vtalumnos, vtpermisos
						   WHERE vtpermisos.id_usuario = vtalumnos.id 
						     and vtpermisos.id_curso = %d 
						     and fecha_alta >= '%s' 
						   ORDER by id";
		                   
    $queMaestros = sprintf($FormatMaestros,$_REQUEST['CursoID'],$_REQUEST['FechaFiltro'] ); 
	
	 //echo "@@hoyhoy".$queMaestros;
	
	} elseif ($_REQUEST['filtro'] == "FILTRO_ID" && $_REQUEST['CursoID'] != 0 ){
        	//echo "estamos en 2";
		$FormatMaestros = "SELECT DISTINCT vtalumnos.id, es_adm,es_colaborador,telefono, pais, ciudad, skype_usuario, agente, email, pwd, nombre, apellidos,fecha_alta, fecha_baja, observaciones_medif,tipoalumno, ultima_ip, ultima_conexion, recibir_mails, alias_foro, alias_comment,bloquear_foro, mensajes_foro 
		                   FROM vtalumnos, vtpermisos
						   WHERE vtpermisos.id_usuario = vtalumnos.id 
						     and vtpermisos.id_curso = %d 
						   ORDER by id";
	
    $queMaestros = sprintf($FormatMaestros,$_REQUEST['CursoID']); 
	
	} elseif ($_REQUEST['filtro'] == "FILTRO_ID" && $_REQUEST['FechaFiltro'] <> "" && $_REQUEST['FechaFiltro'] <> "0000-00-00"){
			//echo "estamos en 3";
		$FormatMaestros = "SELECT DISTINCT  vtalumnos.id, es_adm, es_colaborador, telefono, pais, ciudad, skype_usuario, agente, email, pwd, nombre, apellidos,fecha_alta, fecha_baja, observaciones_medif, tipoalumno, ultima_ip , ultima_conexion, recibir_mails, alias_foro, alias_comment,bloquear_foro, mensajes_foro 
		                   FROM vtalumnos LEFT JOIN vtpermisos on vtpermisos.id_usuario = vtalumnos.id 
						   WHERE fecha_alta >= '%s' 
						   ORDER by id";
    $queMaestros = sprintf($FormatMaestros,$_REQUEST['FechaFiltro']); 

	} else {
			//echo "estamos en 4";
		$FormatMaestros = "SELECT DISTINCT  vtalumnos.id, es_adm, es_colaborador, telefono, pais, ciudad, skype_usuario, agente, email, pwd, nombre, apellidos,fecha_alta, fecha_baja, observaciones_medif,tipoalumno, ultima_ip, ultima_conexion, recibir_mails, alias_foro, alias_comment,bloquear_foro, mensajes_foro 
						   FROM vtalumnos LEFT JOIN vtpermisos on vtpermisos.id_usuario = vtalumnos.id 
						   ORDER by id";
    $queMaestros = sprintf($FormatMaestros); 
	}
	
   //..........ejecutar query 
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);

//echo "<br>totMaestros--->".$totMaestros;




if ($totMaestros> 0) {  //.....Registro de conexión
   echo "<div class = 'rowCabeceraAlumnos' >";
   for( $i = 0; $i < $nColumnas ; $i++ ) {
		echo "<div class = ".tipoClase($CampoTipo[$CampoMombre[$i]],0).">".$CampoMombre[$i]."</div>";	
	 }
   echo "</div><br>";  // de rowGrupo		
   while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
   	

   	
	          echo '<A NAME="'.$rowRegistros['id'].'">';
			  if ($rowRegistros["es_adm"] == 1 && $_SESSION['es_admin'] < 1){
	             echo "<div class = 'rowAlumno' >";  //siempre pasamos el primer campo
              } else { 
                 echo "<div class = 'rowAlumno' onclick='edita(".$rowRegistros[$CampoMombre[0]].")'>";  //siempre pasamos el primer campo
              }
       
			  for( $i = 0; $i < $nColumnas ; $i++ ) {

		     // echo $CampoMombre[$i].".........".tipoClase($CampoTipo[$CampoMombre[$i]]);
                 if ($rowRegistros["es_adm"] == 1 && $CampoMombre[$i] == "pwd" && $_SESSION['es_admin'] < 1){
                    echo "<div class = ".tipoClase($CampoTipo[$CampoMombre[$i]],1)."> &nbsp;</div>";
                 }  else {   
                     echo "<div class = ".tipoClase($CampoTipo[$CampoMombre[$i]],1)."> ".contenidoFigura($rowRegistros[$CampoMombre[$i]],$CampoMombre[$i],$conexion )."</div>";
                 }
              }
			  echo "</div><br>";  // de rowSeccion	
			  
			  
			  
			  
          }
   
   
   
   
   
   
   
   
   echo "<div class = 'rowCabeceraAlumnos' >";
   for( $i = 0; $i < $nColumnas ; $i++ ) {
		echo "<div class = ".tipoClase($CampoTipo[$CampoMombre[$i]],0).">".$CampoMombre[$i]."</div>";	
	 }
   echo "</div><br>";  		
}
   
   
  
   
/*mysqli_close($conexion);*/
return 0;
}


?>


<?php

pintaAlumnos($conexion);


/*echo "<br>usuario ................".$_SESSION['usuario']         ;
echo "<br>pwd.....................".$_SESSION['pwd']             ;
echo "<br>regId...................".$_SESSION['regId']           ;
echo "<br>EsCliente...............".$_SESSION['esCliente']       ;
echo "<br>autentificado...........".$_SESSION['autentificado']   ;
echo "<br>esAdmin.................".$_SESSION['esAdmin']         ;
echo "<br>registradoAcceso........".$_SESSION['registradoAcceso'];*/
?>

</div>

	
</body>
</html>

