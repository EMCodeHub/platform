<?php
session_start();
?>
<!doctype html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Documento sin título</title>
</head>

<body>







<table width="100%" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px">
  <tr>
    <td width="6%" rowspan="6"><img src="https://medifestructuras.com/imagenes/logos/LogoMedif.jpg" width="66" height="100"></td>
    <td width="1%" rowspan="6">&nbsp;</td>
    <td width="93%">&nbsp;</td>
  </tr>
  <tr>
    <td>CONSULTORIA Y DISEÑO DE ESTRUCTURAS</td>
  </tr>
  <tr>
    <td>Calle 6 de Diciembre y Bosmediano</td>
  </tr>
  <tr>
    <td>Torres del Norte. Junto CNE. Departamento 3B</td>
  </tr>
  <tr>
    <td>Quito </td>
  </tr>
  <tr>
    <td>Teléfono: +593997070242
      <hr style="color: #0056b2;" />
    </td>
  </tr>
</table>

<br>
  

<table width="97%" border="0">
  <tr>
    <td width="89%">
    Estimado <?php echo $_POST['nombre']." ".$_POST['apellidos'] ;?>
    <br><br>Hemos recibido su solicitud de presupuesto.     
    <br><br>Adjuntamos los datos de su petición: 
    </td>
    
    <td width="10%"><img src="https://medifestructuras.com/imagenes/EnvesTarjetaEdu.png" width="130" height="100" >
    </td>
  </tr>
</table>

<table width="100%" border="1" cellpadding="4" cellspacing="5" bordercolor="#000000"  style="font-family:Arial, Helvetica, sans-serif; font-size:12px;border-collapse:collapse">
  <tr>
    <td width="15%" bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top;font-weight:bold">Nombre</td>
    <td width="85%"><?php echo $_POST['nombre'] ;?></td>
  </tr>
  <tr>
    <td bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Apellidos</td>
    <td><?php echo $_POST['apellidos'] ;?></td>
  </tr>
  <tr>
    <td bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">email</td>
    <td><?php echo $_POST['email'] ;?></td>
  </tr>
  <tr>
    <td bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Teléfono:</td>
    <td><?php echo $_POST['telefono'] ;?></td>
  </tr>
  <tr>
    <td bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Ciudad</td>
    <td><?php echo $_POST['ciudad'] ;?></td>
  </tr>
    <tr>
    <td bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Observaciones</td>
    <td><?php echo $_POST['comentarios'] ;?></td>
  </tr>

  <tr>
    <td bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Fichero del proyecto</td>
    <td><?php echo $_POST['fichero'] ;?></td>
  </tr>
 
</table>
<br>
Para cualquier otra información puede visitar nuestra web: <a href="https://medifestructuras.com">medifestructuras.com</a> o bien responder a este correo
<p>Gracias por su confianza.</p>
<p>En breve nos pondremos en contacto con Ud.</p>
<p>&nbsp;</p>
<p>Atentamente,</p>
<p><?php echo $_POST['Nombre_correo'] ;?></p>
<p><br>
 

</body>
</html>
