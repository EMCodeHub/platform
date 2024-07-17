
<!DOCTYPE html>
<html lang="es">

<head>
<?php
$seleccione="**************************";
include_once('../conexion/conn_bbdd.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);

session_start( );
?>
<meta name="author" content="<?php echo $DatosWeb->GetTrimValor('NombrePrincipal'); ?>">
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1, user-scalable=yes" name="viewport"/>


<link rel="stylesheet" type="text/css" href="../css/EstiloBase.css">
<link rel="stylesheet" media="(min-width:419px) and (max-width:598px) and (orientation: landscape)" href="../css/Estilo_598_L.css">
<link rel="stylesheet" media="(min-width:419px) and (max-width:598px) and (orientation: portrait)" href="../css/Estilo_598_P.css">
<link rel="stylesheet" media="(max-width:419px) and (orientation: landscape)" href="../css/Estilo_419_L.css">
<link rel="stylesheet" media="(max-width:419px) and (orientation: portrait)" href="../css/Estilo_419_P.css">
												  


<title><?php echo $DatosWeb->GetTrimValor('web_dominio') ?> Solicitar presupuesto</title>
<!--   <link rel="shortcut icon" href="../../Iconos/rosca-1.ico" type="image/ico-icon">  -->



<SCRIPT LANGUAGE="JavaScript">
      
function borraCampos() {
	
	document.getElementById("nombre").value = "";
	document.getElementById("email").value = "";
	document.getElementById("telefono").value = "";
	document.getElementById("ciudad").value = "";
	document.getElementById("curso").value = "";
	document.getElementById("comentarios").value = "";
}

</script>
</head>
<body>
<?php 
$patronTelefono = "/^[[:digit:]]+$/";
$mensaje = '*************';
$pintarFormulario = true;

if (!$_POST) {
    $pintarFormulario = true;	
} else {
	$extensionFichero = "";
	if (strlen($_REQUEST['userfile']) >5){
		$extensionFichero = substr($_REQUEST['userfile'], strlen($_REQUEST['userfile'])-3,3);
	}
	
	$extensionFichero = strtolower($extensionFichero);
	
	
	   if ( (strlen($_REQUEST['nombre']) >2)  and ( (strlen($_REQUEST['telefono']) >5 and preg_match($patronTelefono, $_REQUEST['telefono'])>0)  or (strlen($_REQUEST['email']) >5 and    strpos( $_REQUEST['email'],"@") == true)   ) and (strlen($_REQUEST['userfile']) > 0 and (  $extensionFichero  == "zip"   or  $extensionFichero  == "dwg"  )))  {
		 if( md5( $_POST[ 'code' ] ) != $_SESSION[ 'key' ] ) {
          // echo "You ented the wrong code, please try again!";
           $pintarFormulario = true;
		   $mensaje = '<span class = "rojo">Introduzca código y nombre de fichero</span>';		
         } else {
			$pintarFormulario = false; 
			
		 }    
    } else {
		 $pintarFormulario = true;
		 $mensaje = "........";
		 
	   if (strlen($_REQUEST['nombre']) <3) {
	              $mensaje = '<span class = "rojo">Indique su Nombre</span>';		
	     } elseif (strlen($_REQUEST['telefono']) >0 and ((preg_match($patronTelefono, $_REQUEST['telefono']) < 1)  or (strlen($_REQUEST['telefono']) < 6)    ) ) {
	              $mensaje = '<span class = "rojo">Teléfono incorrecto</span>';		
	     }  elseif (strlen($_REQUEST['email']) > 0 and !strpos($_REQUEST['email'],"@") ) {
			      $mensaje = '<span class = "rojo">Mail incorrecto</span>';	
		 } elseif (strlen($_REQUEST['email']) == 0  and ( strlen($_REQUEST['telefono']) < 6   )) {
			      $mensaje = '<span class = "rojo">Indique email</span>';	
		 } elseif (strlen($_REQUEST['userfile']) == 0) {
			      $mensaje = '<span class = "rojo">Seleccione un fichero</span>';	
		 } elseif ($extensionFichero  <> "zip"   and  $extensionFichero  <> "dwg" ) {
		          $mensaje = '<span class = "rojo">Debe ser un fichero ZIP o DWG</span>';	
		 } else {
			      $mensaje = '<span class = "rojo">Indique datos de contacto</span>';	
		 }
	

	  /* $mensaje = "strlen--->".strlen($_REQUEST['telefono'])."   preg_match--->".preg_match($patronTelefono, $_REQUEST['telefono']);*/
	   
	}

}

?>

<?php 
if ($pintarFormulario) {
	
?>
	<p class="piede_p">Solicitud de presupuesto</p>

<form action="correosPresupuestos.php" method="post" > 
	<div class="mitad">
	     <br>
 	     <label class="piede_panPre">Nombre </label><input id = "nombre" type="text" name="nombre" size="20" maxlength="30" value= "<?php if (isset( $_REQUEST['nombre'])) { echo $_REQUEST['nombre']; }?>" required> 
	     <br> 
	     <label class="piede_panPre">Email </label> <input id = "email" type="text" name="email" size="20" maxlength="30" value= "<?php if (isset( $_REQUEST['email'])) { echo $_REQUEST['email']; }?>" required > 
	     <br> 
	     <label class="piede_panPre">Teléfono</label> <input id = "telefono" type="text" name="telefono" size="20" maxlength="30" value= "<?php if (isset( $_REQUEST['telefono'])) { echo $_REQUEST['telefono']; }?>" >
	     <br> 
	     <label class="piede_panPre">Ciudad</label> <input id = "ciudad" type="text" name="ciudad" size="20" maxlength="30" value= "<?php if (isset( $_REQUEST['ciudad'])) { echo $_REQUEST['ciudad']; }?>" >
         <br> 
          <label class="piede_panPre">Fichero DWG</label> 
          
          <input name="userfile" type="file" />
          <div class="clear"></div>
          <p><img src="captcha.php" border="0" /><input type="text" name="code" maxlength="6" />
            
            <br><br>
            <span class="piede_pan_iz"> <?php  echo($mensaje); ?>  
          </p>
         <div class="clear"></div>
	</div>  
	
	<div class="mitad">
       <label class="piede_pan_iz"> Observaciones:</label>
       <br>
       <textarea id = "comentarios" class="areaTexto" cols="40" rows="8" name="comentarios"  ><?php if (isset( $_REQUEST['comentarios'])) { echo $_REQUEST['comentarios']; }?></textarea>
       <br>
       <br>
       <input class="piede_pan" type="submit"  name="submit"  value="Submit" required>
       <input class="piede_pan" type="Button" value="Reset" onClick="borraCampos()"> 

       <div class="clear"></div>
	</div> 
 
  <br> 
  <br>
  <div class="clear"></div> 
</form> 
	
	
<?php 	
} else {  

   	$cuerpo = "Solicitud de presupuesto\n"; 
    $cuerpo .= "================================================================\n"; 
   	$cuerpo .= "Nombre:     " . $_POST["nombre"] . "\n"; 
   	$cuerpo .= "Email:      " . $_POST["email"] . "\n"; 
   	$cuerpo .= "Teléfono:   " . $_POST["telefono"] . "\n"; 
   	$cuerpo .= "Ciudad:     " . $_POST["ciudad"] . "\n"; 
   	$cuerpo .= "Curso:      " . $_POST["curso"] . "\n"; 
	$cuerpo .= "Comentario: " . $_POST["comentarios"] . "\n"; 
	$cuerpo .= "================================================================\n"; 
   	
	
	
    echo ('<p class = "okCorreo">  Gracias por rellenar el formulario. <br>Se ha enviado correctamente.<br><br>En breve contactaremos con usted</p>'); 
	
}  
?>


</body>

</html>


