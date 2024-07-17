
<!DOCTYPE html>
<html lang="es">

<head>
<?php
$seleccione="**************************";
?>
<meta name="author" content="Eduardo Mediavilla Villodre">
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1, user-scalable=yes" name="viewport"/>

<link rel="stylesheet" type="text/css" href="../css/EstiloBase.css">
<link rel="stylesheet" media="(min-width:419px) and (max-width:598px) and (orientation: landscape)" href="../css/Estilo_598_L.css">
<link rel="stylesheet" media="(min-width:419px) and (max-width:598px) and (orientation: portrait)" href="../css/Estilo_598_P.css">
<link rel="stylesheet" media="(max-width:419px) and (orientation: landscape)" href="../css/Estilo_419_L.css">
<link rel="stylesheet" media="(max-width:419px) and (orientation: portrait)" href="../css/Estilo_419_P.css">
												  


<title>Medif - Solicitar presupuesto</title>
<!--   <link rel="shortcut icon" href="../../Iconos/rosca-1.ico" type="image/ico-icon">  -->



<SCRIPT LANGUAGE="JavaScript">
function borraCampos() {
	
	document.getElementById("nombre").value = "";
	document.getElementById("email").value = "";
	document.getElementById("telefono").value = "";
	document.getElementById("ciudad").value = "";
	document.getElementById("curso").value = "<?php  echo($seleccione)?>";
	document.getElementById("comentarios").value = "";
}

</script>
</head>
<body>
<?php 
$patronTelefono = "/^[[:digit:]]+$/";
$mensaje = 'Cursos presenciales. Videoconferencia.';
$pintarFormulario = true;

if (!$_POST) {
    $pintarFormulario = true;	
} else {
	   if ( (strlen($_REQUEST['nombre']) >2)  and ( (strlen($_REQUEST['telefono']) >5 and preg_match($patronTelefono, $_REQUEST['telefono'])>0)  or (strlen($_REQUEST['email']) >5 and    strpos( $_REQUEST['email'],"@") == true)   ) and ( $_REQUEST['curso'] != $seleccione)  )  {
	    $pintarFormulario = false;	
    } else {
	   $pintarFormulario = true;
	   $mensaje = '<span class = "rojo">Indique datos de contacto</span>';	
	   if (strlen($_REQUEST['nombre']) <3) {
	    $mensaje = '<span class = "rojo">Indique su Nombre</span>';		
	   }
	   if (strlen($_REQUEST['telefono']) >0 and ((preg_match($patronTelefono, $_REQUEST['telefono']) < 1)  or (strlen($_REQUEST['telefono']) < 6)    ) ) {
	    $mensaje = '<span class = "rojo">Teléfono incorrecto</span>';		
	   }
	   if (strlen($_REQUEST['email']) > 0 and !strpos($_REQUEST['email'],"@") ) {
	    $mensaje = '<span class = "rojo">Mail incorrecto</span>';		
	   }
	   if ($_REQUEST['curso'] == $seleccione) {
	    $mensaje = '<span class = "rojo">Indique curso</span>';		
	   }
	   
	  /* $mensaje = "strlen--->".strlen($_REQUEST['telefono'])."   preg_match--->".preg_match($patronTelefono, $_REQUEST['telefono']);*/
	   
	}

}

?>

<?php 
if ($pintarFormulario) {
	
?>
	<p class="piede_p">Solicitud de información: Cursos CYPE en Quito</p>

<form action="correosAulaCype.php" method="post" > 
	<div class="mitad">
	     <br>
 	     <label class="piede_pan">Nombre </label><input id = "nombre" type="text" name="nombre" size="20" maxlength="30" value= "<?php if (isset( $_REQUEST['nombre'])) { echo $_REQUEST['nombre']; }?>" required> 
	     <br> 
	     <label class="piede_pan">Email </label> <input id = "email" type="text" name="email" size="20" maxlength="30" value= "<?php if (isset( $_REQUEST['email'])) { echo $_REQUEST['email']; }?>" required > 
	     <br> 
	     <label class="piede_pan">Teléfono</label> <input id = "telefono" type="text" name="telefono" size="20" maxlength="30" value= "<?php if (isset( $_REQUEST['telefono'])) { echo $_REQUEST['telefono']; }?>" >
	     <br> 
	     <label class="piede_pan">Ciudad</label> <input id = "ciudad" type="text" name="ciudad" size="20" maxlength="30" value= "<?php if (isset( $_REQUEST['ciudad'])) { echo $_REQUEST['ciudad']; }?>" >
         <br> 
          <label class="piede_pan">Curso</label> 
          <select name="curso" id ="curso">
      
          <option <?php  if ($_REQUEST['curso'] == $seleccione) { echo selected; }   ?>><?php  echo($seleccione)?></option>
          <option <?php  if ($_REQUEST['curso'] == "CypeCAD") { echo selected; }   ?>>CypeCAD</option>
          <option <?php  if ($_REQUEST['curso'] == "Cype 3D") { echo selected; }   ?>>Cype 3D</option>
          <option <?php  if ($_REQUEST['curso'] == "Cype Connect") { echo selected; }   ?>>Cype Connect</option>
          <option <?php  if ($_REQUEST['curso'] == "Generador de Pórticos") { echo selected; }   ?>>Generador de Pórticos</option>
          <option <?php  if ($_REQUEST['curso'] == "Otros") { echo selected; }   ?>>Otros</option>
          </select>        
         
       
         
	     <br><br>
	     <span class="piede_pan_iz"> <?php  echo($mensaje); ?>  
	     <div class="clear"></div>
	</div>  
	
	<div class="mitad">
       <label class="piede_pan_iz"> Observaciones:</label>
       <br>
       <textarea id = "comentarios" class="areaTexto" cols="32" rows="5" name="comentarios"  ><?php if (isset( $_REQUEST['comentarios'])) { echo $_REQUEST['comentarios']; }?></textarea>
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

   	$cuerpo = "Curso Aula CYPE: solicitud de información\n"; 
    $cuerpo .= "================================================================\n"; 
   	$cuerpo .= "Nombre:     " . $_POST["nombre"] . "\n"; 
   	$cuerpo .= "Email:      " . $_POST["email"] . "\n"; 
   	$cuerpo .= "Teléfono:   " . $_POST["telefono"] . "\n"; 
   	$cuerpo .= "Ciudad:     " . $_POST["ciudad"] . "\n"; 
   	$cuerpo .= "Curso:      " . $_POST["curso"] . "\n"; 
	$cuerpo .= "Comentario: " . $_POST["comentarios"] . "\n"; 
	$cuerpo .= "================================================================\n"; 
   	mail("llumed@gmail.com","Aula CYPE: Solicitud de curso",$cuerpo); 
	
	
	
    echo ('<p class = "okCorreo">  Gracias por rellenar el formulario. <br>Se ha enviado correctamente.<br><br>En breve contactaremos con usted</p>'); 
	
}  
?>


</body>

</html>


