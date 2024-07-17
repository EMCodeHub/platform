<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">

<?php  
session_start();
include_once('../conexion/conn_bbdd.php');  
include_once('../php/ValidaLoginScript.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
    
include_once('NewWebEstilosNOIndex.php');
?>
<title><?php echo $DatosWeb->GetTrimValor('web_dominio') ?> Cambio de contraseña</title>
     <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
     <script type="text/javascript" src="../php/VideotutorialesCambioPwd.js"></script>

<?php include_once('PaginaCabecera.php'); ?>   
    
<script>
function posicionate() {
	document.getElementById('usuario').focus();
}
</script>


</head>
<body onLoad="javascrip:posicionate()">
<?php  
include_once('MenuNOIndexSinLogin.php');   
?>
 

<div class="clear"></div>




<section class="contenedor">



<br><br><br><br>  

<br>
         

<div class="ficha">  
  <div class="envoltorioMedif">
 

<div class="ficha_fila">

<div class="centro">
<form>
   <p class = "tituloApartadoAzulCenter" >Introduzca su nueva contraseña</p>
  
  <table width="70%" border="0" align="center">
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
    <td><input id = "pwd" type="password" name="pwd" size="30" maxlength="30"   value= "" > </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
      <tr>
    <td class = "pide_panPreDcha">Nueva Contraseña</td>
    <td><input id = "pwdNew" type="password" name="pwdNew" size="30" maxlength="30"   value= "" > </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td class = "pide_panPreDcha">Repita Contraseña</td>
    <td><input id = "pwdRepe" type="password" name="pwdRepe" size="30" maxlength="30"   value= "" > </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

    <tr>
    <td colspan="2"><div class="centro"><input id = "Cambiar" name="Cambiar" type="button" class ="ButtonGrisP" value ="&nbsp;&nbsp;&nbsp;Cambiar&nbsp;&nbsp;&nbsp;" /></div></td>
    </tr>
    
    
</table>
 </form>        
</div>
</div>    <!-- end .ficha_fila -->


<div class="ficha_fila">
<div class="centro"><div id = "marcoConexion"></div></div>
</div>    <!-- end .ficha_fila -->



</div>  <!--envoltorio_medif-->
</div><!-- end .ficha -->
<br><br><br><br>  
<br><br><br><br> <br><br><br><br>  
<br><br><br><br> 
  
</section><!-- end .contenedor -->

 


<div class="centro90"><?php include_once('PaginaPieNOIndex.php'); ?></div>
<div class = "Aviso"></div>

</body>




</html>
