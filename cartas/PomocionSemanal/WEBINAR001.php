
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<?php
session_start();
if ($_SESSION['pruebas'] == 1) {
   $_REQUEST['NumeroAlumno'] = 1;
}
include_once('../../conexion/conn_bbdd.php');
include_once('../../php/ValidaLoginScript.php');
include_once('../../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
?>

<title>Carta Promocional</title>

 <?php
    $NOMBRE_ALUMNO = "";
    $formatSeleccion = "SELECT nombre FROM vtalumnos WHERE id = %d";
    $queSeleccion = sprintf($formatSeleccion,$_REQUEST['NumeroAlumno']);
		  //echo $queSeleccion;	  
    $resSeleccion = mysqli_query($conexion, $queSeleccion) or die(mysqli_error($conexion));  
    $totSeleccion = mysqli_num_rows($resSeleccion);     
	while ($rowSeleccion = mysqli_fetch_assoc($resSeleccion)) {
		 $NOMBRE_ALUMNO =  $rowSeleccion['nombre'];
	}
    mysqli_free_result($resSeleccion); 
    if ($NOMBRE_ALUMNO == "") {
        $NOMBRE_ALUMNO = "Ingeniero";
    }
    ?>   
    
</head>

<body>
	
<?php include_once('../../paginas/CartaCabecera.php'); ?>  
    
<!--## .........INICIO sección modificable ................... ............. ......... ........ ###   -->   

   <br /><br /> 
   Bienvenido <?php echo $NOMBRE_ALUMNO ?>.
    <br /><br />
    <p>Queremos invitarle a nuestro webinar gratuito donde aprenderá a enfocar internacionalmente sus proyectos. </p>

    <p>Es necesario que se inscriba haciendo clic en el siguiente enlace: <a href="http://webinar.<?php echo $DatosWeb->GetTrimValor('web_dominio') ?>/">CLIC AQUI PARA INSCRIBIRSE</a></p>
    <p>El webinar se celebrará el dia 25 de junio a las 11.00h de Colombia, una vez registrado, podrá acceder por medio de ese link: </p>
    <p> <a href="https://www.youtube.com/watch?v=Vd4M1Loe3u4"> CLIC AQUI PARA ACCEDER A LA CLASE *Previamente deberá de inscribirse</a><p>

    
    <br />
    <div style="text-align:center">
      <img src="<?php echo $DatosWeb->GetTrimValor('web_url') ?>/cartas/PomocionSemanal/ImagenesCartas/WEBINAR.jpg" width="393" height="258" />
    </div>
   
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Para cualquier otra información puedes visitar nuestra web: <a href="<?php echo $DatosWeb->GetTrimValor('web_url'); ?>" > <?php echo $DatosWeb->GetTrimValor('web_dominio'); ?></a> o bien responder a este correo
</p>
<p>Gracias por tu confianza.</p>
<p>&nbsp;</p>
<p>Atentamente,</p>
<p> <?php echo $DatosWeb->GetTrimValor('NombrePrincipal'); ?></p>
<p>
<br/>
<!--## ............................ ................ ...... ..... ....... ......... ........ ###   --> 
<?php include_once('../../paginas/CartaPie.php'); ?>

</body>
</html>


