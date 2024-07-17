<!DOCTYPE html>
<html>
<head>

<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>  

<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,500,800" rel="stylesheet">    


<?php
include_once('paginas/FormularioEduardoNewWebEstilos.php');
?>




	<title>Registrar usuario</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css">
</head>
<body>
   
<div class="contienelogo">


<img src="../imagenes/logoformulario.png"  alt="Logo Medif">




</div>




<form method="post">
    	<h1>¿Qué tipo de curso o temática le interesaría cursar?</h1> <br>
		<p>Estimado Ingeniero o Arquitecto, le saluda el <b>Ing.Eduardo de CYPE Ingenieros,</b> estamos consultando sobre los <b>temas de mayor interés</b> para desarrollar un nuevo curso online.</p>
		<br> 
		<p>Aprovechamos para desearle mucha suerte con sus proyectos </p> <br>

	
    	<input type="text" name="name" placeholder="Nombre">
    	<input type="email" name="email" placeholder="Email">
		<input type="text" name="pais" placeholder="Pais">
		<textarea id="mensaje" name="mensaje" placeholder="Escriba aquí su comentario, lo valoraremos mucho" rows="10" cols="50"></textarea>
    	<input type="submit" name="register">
    </form>
        <?php 
        include("php/registrar.php");
        ?>
</body>
</html>


