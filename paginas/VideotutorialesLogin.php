<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<?php  
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);

$_SESSION['FotoCabecera'] = "../imagenes/FotoPrincipalLogin.jpg";
include_once('EstilosScripsNOIndex.php');
?>
<title><?php echo $DatosWeb->GetTrimValor('web_dominio') ?> Videotutoriales</title>
     <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
     <script type="text/javascript" src="../php/VideotutorialesLogin.js"></script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62544837-1', 'auto');
  ga('send', 'pageview');
</script>
<script>
function posicionate() {
	document.getElementById('usuario').focus();
}
</script>


</head>
<body onLoad="javascrip:posicionate()">

<?php  
//include_once('cabeceraNOIndex.php');
include_once('CabNoIndex.php');
?>
<section class="contenedor">



          <h1 class ="tituloApartado">Bienvenido al campus</h1>


         

<div class="ficha">  
  <div class="envoltorioMedif">
 

<div class="ficha_fila">

<div class="centro">
<form>
   <p class = "tituloApartadoAzulCenter" >Log in </p>
  
  <table width="70%" border="0">
  <tr style="vertical-align:center">
    <td width="30%" class = "pide_panPreDcha" >Correo Electrónico </td>
    <td width="70%"><input id = "usuario" type="text" name="usuario" size="40" maxlength="100"  value= "" ></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td class = "pide_panPreDcha">Contraseña</td>
    <td><input id = "pwd" type="password" name="pwd" size="20" maxlength="100"   value= "" > </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td colspan="2" align="center"><input id = "Login" name="Login" type="button" class ="btnVerPagina" value ="&nbsp;&nbsp;&nbsp;Entrar&nbsp;&nbsp;&nbsp;" /></td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td colspan="2" align="center"><a href="javascript:PwdOlvidado()">Has olvidado la cotraseña ?</a></td>
    </tr>
</table>
 </form>        
</div>
</div>    <!-- end .ficha_fila -->


<div class="ficha_fila">
<center><div id = "marcoConexion"></div></center>
</div>    <!-- end .ficha_fila -->









</div>  <!--envoltorio_medif-->
</div><!-- end .ficha -->

  
</section><!-- end .contenedor -->


<div class = "Aviso"></div>

</body>




</html>
