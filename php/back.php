<?php



$Nombre = htmlentities(addslashes(trim($_POST['nombre'])));

$Email = htmlentities(addslashes(trim($_POST['correo'])));

$Asunto = htmlentities(addslashes(trim($_POST['asunto'])));

$Mensaje = htmlentities(addslashes(trim($_POST['mensaje'])));

$fechareg = date("y/m/d");



$conexion = mysqli_connect("qth840.medifestructuras.com", "qth840", "ZypMidZf22", "qth840");

mysqli_query($conexion,"SET SESSION sql_mode = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");

mysqli_set_charset ( $conexion , 'utf8' );



				$consulta = "INSERT INTO `registroasmr` (`nombre`, `email`, `asunto`, `mensaje`, `fecha_reg`) VALUES ('$Nombre','$Email','$Asunto','$Mensaje','$fechareg')";


				$resultado = mysqli_query($conexion,$consulta)  or die(mysqli_error($conexion));

				if ($resultado) {

					?> 


                       <span class='ok'>Información enviada con éxito</span>


				   
                   <?php

				} else {
					?> 

                    <span class='bad'>¡Ups ha ocurrido un error!</span>
					
				   <?php
				} 
		
	

?>