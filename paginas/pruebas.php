
<?php
$conexion = mysqli_connect("qth840.medifestructuras.com", "qth840", "ZypMidZf22", "qth840");


//mysqli_options($mysqlconn, MYSQLI_INIT_COMMAND, 'SET @@SESSION.sql_mode = NO_ENGINE_SUBSTITUTION');

mysqli_query($conexion,"SET SESSION sql_mode = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");


//$conexion = mysqli_connect("localhost", "root", "root", "medif");

mysqli_set_charset ( $conexion , 'utf8' );
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

