<?php 

include("conexion/conn_bbdd.php");

if (isset($_POST['register'])) {
    if (strlen($_POST['name']) >= 1 && strlen($_POST['email']) >= 1  &&  strlen($_POST['mensaje']) &&  strlen($_POST['pais']) >= 1 ) {
	    $name =  trim($_POST['name']);                  
	    $email = trim($_POST['email']);
		$pais = trim($_POST['pais']);
		$mensaje = trim($_POST['mensaje']);


	    $fechareg = date("y/m/d");
	    $consulta = "INSERT INTO e_vtmensajesformulario (nombre, email_cliente, fecha_emision, pais, mensaje) VALUES ('$name','$email','$fechareg','$pais','$mensaje')";
	    $resultado = mysqli_query($conexion,$consulta);
	    if ($resultado) {
	    	?> 
	    	<h3 class="ok">¡Hemos recibido su apreciación correctamente, gracias por participar!</h3>
           <?php
	    } else {
	    	?> 
	    	<h3 class="bad">¡Ha ocurrido un error, rellena nuevamente los campos!</h3>
           <?php
	    }
    }   else {
	    	?> 
	    	<h3 class="bad">¡Por favor complete los campos!</h3>
           <?php
    }
}

?>