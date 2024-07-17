<?php
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
include_once('../php/SesionesCookies.php'); //Inicio de sesión y asignación de sus variables
?>
<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      
<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script  src="../php/VideotutorialesLoginNOIndex.js"></script> 
<?php
include_once('NewWebEstilosNOIndex.php');
include_once('../php/IndexScript.php');
include_once('PaginaCursoPHP01_2.php');  
?>

<title>Pago con Visa deshabilitado temporalmente</title>
<?php include_once('PaginaCabecera.php'); ?> 





<style>
















.contenedor {
  margin: 5px; /* Mínimo de 5px a cada lado */
  display: flex;
  justify-content: center;
  font-family: 'Montserrat', sans-serif;

  --tw-bg-opacity: 0.4;
  background-color: rgb(10 10 10 / var(--tw-bg-opacity));
  background-image: radial-gradient(ellipse 150% 80% at 50% -20%, #7877c64d, #fff0);
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.rectangulo {
  border: 3px solid black;
  padding: 30px;
  width: calc(100% - 10px); /* 5px a cada lado */
  max-width: 800px; /* Ancho máximo para mantener la legibilidad */
  margin: 5px; /* Mínimo de 5px a cada lado */
  box-sizing: border-box; /* Incluye el borde en el ancho y alto */
  font-family: 'Montserrat', sans-serif;
  color: white;
  

  
}

.rectangulo p {
  margin-bottom: 15px;
}




</style>















</head>

<body class="dark-mode">


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php
include_once('MenuNOIndex.php');   
?>
 
  
  
<div class="PocoEspacio" ></div>
<div class="clear"></div>
  <div class = "Aviso"></div>


 



 
<?php
     include_once('PantallaPwd.php');
?>


 
<div class="ficha_fila">

<!--

<div class = "celda_40_izda"><img src="../imagenes/img-eduardo.png"  alt="  -->    <?php  /*echo $DatosWeb->GetTrimValor('NombrePrincipal'); */ ?>  <!--  "> -->    </div> 
 




<div class="contenedor">

<br><br>

<h1 class ="NewtituloApartado">Inscripción Online</h1>

<br><br>


  <div class="rectangulo">
    <p>Estimado Ingeniero o Arquitecto.</p>
    <p>Es un gusto saludarle. </p>

    <p> Escriba un correo a <a style="color: #8689ff" href="mailto:eduardo.mediavilla@cype.com">eduardo.mediavilla@cype.com</a> o <a  style="color: #8689ff"  href="mailto:inscripciones@medifestructuras.com">inscripciones@medifestructuras.com</a> indicando los cursos que desea realizar, recibirá en la brevedad posible un link de pago. Una vez completado el pago le entregaremos el usuario y clave de acceso, mediante el cual podrá acceder a los contenidos y al servicio de asistencia técnica de dudas. Estamos realizando mantenimiento a nuestra pasarela de pagos stripe.</p>
    <p>Gracias anticipadas y disculpen las molestias.</p>


    <p>Atentamente.</p>

    <p>Ing. Eduardo </p>

    <br> <br>

    <br> <br> <br> <br>
    <div>

    <a href="https://medifestructuras.com/" target="_blank">
  <button class ="ButtonGris" >Volver a medifestructuras</button>

  </div>

</a>


<br>
<br><br>

<br>


  </div>


  <br>
<br><br>

<br>

<br>
<br><br>

<br>

<br>
<br><br>

<br>
<br>
<br><br>

<br>


</div>











<br><br>
<br>



 <div class="centro90"><?php include_once('PaginaPieNOIndex.php'); ?>
</div> </div> <!-- end .ficha_fila -->
 <br />
   






</body>
</html>