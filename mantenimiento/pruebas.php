<?php

$conexion = mysqli_connect("qth840.medifestructuras.com", "qth840", "ZypMidZf22", "qth840");

mysqli_set_charset ( $conexion , 'utf8' );
?>



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
	

<div>

<?php

pintaAlumnos($conexion);

?>

</div>





</body>
</html>




