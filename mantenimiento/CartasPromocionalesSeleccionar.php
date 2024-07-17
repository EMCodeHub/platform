<!doctype html>
<?php
// al entrar en pantalla se chequea si hay envíos pendientes (ReenviarCPendientes() ). Si hay pendientes se bloquea el formulario principal y se procede a realizar los reenvíos

session_start();
$_SESSION['pruebas'] = 0;
include_once('../conexion/conn_bbdd.php');
include_once('../php/CartasPromocionalesSeleccionarScript.php');


if ($_SESSION['es_admin'] != 1) {
    header("Location: ../index.php");
    exit;
}

//..................................................PENDIENTE ACTIVAR VARIABLE $exito en CartasPromocionalesEnviaMail.php
?>
<html>
<head>
<meta charset="UTF-8">
<title>Envío de cartas Promocionales</title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css">
<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script  src="../php/CartasPromocionalesSeleccionar.js"></script>
<script>   
cartaProbada = 0;
AlumnosEncontrados = 0;
AlumnosEnviados = 0;
AlumnosAfectados = 0;
HayErrores = 0;
IDPruebas = <?php echo ObtenerIDPruebas($conexion,ObtenerMailPruebas($conexion)) ?>;
TipoSelect  = [
    "Pruebas",
    "Tienen  ALGUNO de los seleccionados y NINGUNO más (A ó B y ninguno más)",
    "Tienen TODOS los seleccionados y NINGUNO más (A y B y ninguno más)",
    "Tienen  ALGUNO de los seleccionados y OTROS más (A ó B y alguno más)",
    "Tienen  TODOS los seleccionados y OTROS más (A y B y alguno más) ",
    "NO tienen los seleccionados" ] ;

    function Chequeo() {
      <?php echo  ReenviarCPendientes($conexion,0); ?>   
    }
    function VerEnviosAnteriores(){
        location.href='VTCartasPromocionalesLista.php';
    }
    
</script>
</head>

<body onLoad="Chequeo()"> 
    
    <div class="TituloEstadistica">Pantalla para enviar cartas a los alumnos</div>
    <div class="centro"> 
            <div class="pocoEspacio"></div>
            <?php echo  CartaUltimoEnvio($conexion); ?> &nbsp; &nbsp;
            <div id="enviosAnteriores"><input type="button" class="BotonGenerico" value ="Ver envíos anteriores" onclick="VerEnviosAnteriores()" > </div>
      
    </div>
    <div class=clear></div>
    <div class="centro">  
        <span class="azul">Las cartas tienen que estar en la carpeta /cartas/PromocionSemanal y las imágenes en /cartas/PromocionSemanal/ImagenesCartas</span></br>
        
        
       <p class='azul'> Sólo se pueden enviar las cartas de 100 en 100 cada 15 minutos y un máximo de  10.000 cartas al día</p>
    </div>

<div id="datosFormBloqueo" > 
        <p class="centro">SEGUIMOS PROCESANDO el lote. No han pasado 15 MINUTOS desde el último envío.</p>  
        <p class="centro">REFRESQUE LA PANTALLA y observe si disminuye el número de PENDIENTES</p>
		
	<br />
    <table width=98% border="1">
	<tr>
      <td  colspan="2" class="centro"><p>En caso de que el proveedor de hosting no envíe las cartas, o queden cartas pendientes, puede obtener un fichero CSV para realizar los envíos pendientes con una herramienta externa. Ej: MailRelay </p><p>(Cada proveeror hosting tiene sus políticas de envíos de cartas)</p></td> 
    </tr>
	 
    <tr>
      <td width=30%>CSV de cartas pendientes y anular el proceso automático de envíos</td>
      <td> &nbsp; &nbsp;<input name="CSV Pendientes1" type="button" class="BotonGenerico" value ="CSV cartas pendientes" id="botonPendientes1" onclick="CSVPendientes('MensajeCSV1')" >&nbsp; &nbsp;<div id="MensajeCSV1" class="azul"></div></td>
    </tr>
	 
    </table>
	<br />
</div>
    
  <div id="datosFormReenvio" > 
        <p class="centro">Procedemos a reenviar cartas pendientes . Puede ABRIR OTRA PESTAÑA para realizar otras gestiones</p>
    <br />
    <table width=98% border="1">
	<tr>
      <td  colspan="2" class="centro"><p>Si cree que el proceso está encallado, haga click en el botón para detener proceso y obtener fichero CSV de envíos pendientes. Reenvíe los pendientes con una herramienta externa. Ej: MailRelay </p><p>(Cada proveeror hosting tiene sus políticas de envíos de cartas)</p></td> 
    </tr>
	 
    <tr>
      <td width=30%>CSV de cartas pendientes y anular el proceso automático de envíos</td>
      <td> &nbsp; &nbsp;<input name="CSV Pendientes2" type="button" class="BotonGenerico" value ="CSV cartas pendientes" id="botonPendientes2" onclick="CSVPendientes('MensajeCSV2')" >&nbsp; &nbsp;<div id="MensajeCSV2" class="azul"></div></td>
    </tr>
	 
    </table>
	<br />    
		
</div>
    
    
    
    
<div id="datosFormPrincipal" >
 
    <form id="FormSeleccionCartas">
    <table width=98% border="1">
    <tr>
      <td width=30%>E-mail para probar la carta: (Debe de ser alumno)</td>
      <td><?php echo  ObtenerMailPruebas($conexion) ?></td>
    </tr>

    <tr>
      <td width=30%>Asunto:</td>
      <td><input type="text" name="asunto" id="asunto" size="100"> </td>
    </tr>
     <tr>
      <td width=30%>El asunto acaba con el nombre del alumno:</td>
      <td>
          <input type="radio" id="AcabaNombre1" name="LlevaNombre" value="1" checked > <label for="AcabaNombre1">Si</label>
          <input type="radio" id="AcabaNombre2" name="LlevaNombre" value="0" > <label for="AcabaNombre1">No</label>
          &nbsp; &nbsp; Ejemplo: Mira esto Eduardo. (Añado el nombre del alumno al asunto)
      </td>
    </tr>        
        
    <tr>
      <td width=30%>Selecciona la carta:</td>
      <td>
          <?php    
              $resultado = BuscaCartas($conexion);
              echo $resultado;
           ?>
          <span id="CartaYaEncontrada" class="rojo"></span>
       </td>
    </tr>
    <tr>
      <td width=30%>Que tengan o no los cursos seleccionados</td>
      <td>
          <input type="radio" id="QueTengan1" name="QueTengan" value="1" checked onchange="LimpiaCalculos()"> <label for="QueTengan1">
          <script>document.write(TipoSelect[1])</script>
          </label><br />
          
          <input type="radio" id="QueTengan2" name="QueTengan" value="2"  onchange="LimpiaCalculos()"> <label for="QueTengan2"><script>document.write(TipoSelect[2])</script></label><br />
          
          
          <input type="radio" id="QueTengan3" name="QueTengan" value="3" onchange="LimpiaCalculos()"> <label for="QueTengan3"><script>document.write(TipoSelect[3])</script></label> <br />
          
          <input type="radio" id="QueTengan4" name="QueTengan" value="4" onchange="LimpiaCalculos()"> <label for="QueTengan4"><script>document.write(TipoSelect[4])</script></label> <br />
         
          
          <input type="radio" id="QueTengan5" name="QueTengan" value="5" onchange="LimpiaCalculos()"> <label for="QueTengan5"><script>document.write(TipoSelect[5])</script></label>
      </td>
    </tr>        
    
    <tr>
      <td width=30%>Cursos:</td>
      <td><?php echo  DibujaChecksCursos($conexion) ?></td>
    </tr>
    <tr>
      <td width=30%>Calcular alumnos afectados:</td>
      <td id="BotonCalcularAlumnos">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
          <input type="button" class="BotonGenerico" value ="Calcular número de alumnos" onclick="CalcularAlumnos()" > 
      </td>
    </tr>  
    <tr>
      <td width=30%>Alumnos afectados:</td>
      <td id="numAlumnos"></td>
    </tr>
    <tr>
      <td width=30%>Enviar e-mail de prueba:</td>
      <td id="BotonProbar">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
          <input type="button" class="BotonGenerico" value ="Probar carta" onclick="ProbarCarta()" > 
      </td>
    </tr>
    
    <tr>
        <td width=30%>Para enviar los correos escriba: ENVIAR y pulse el botón</td>
         <td id="EnviosCartas">
			 <input type="text" name="enviar" id="enviar" size="6" > 
             &nbsp; &nbsp;<input name="Enviar Cartas" type="button" class="BotonGenerico" value ="Enviar Correos"   onclick="EnviarCorreos()" >
         </td>
    </tr>

</table>
<br />
	
  <br />     
</form>
</div>   <!--datosFormPrincipal-->
<div id="botonSalir" class="derecha2"> <input name="Salir" type="button" class="BotonGenerico" value ="Salir" onclick="location.href = 'mantenimiento.php';" > </div>     
<div id="MensajeCarta1"></div>  
<div id="MensajeCarta2"></div>  
<div id="MensajeCarta3"></div> 
<div id="MensajeCarta4"></div>    
<div id="MensajeCarta5"></div>      
<a name="Fin"></a>   
 
</body>

</html>
