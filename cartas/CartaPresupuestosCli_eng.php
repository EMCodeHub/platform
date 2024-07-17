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
    <td>CONSULTANCY AND DESIGN OF STRUCTURES</td>
  </tr>
  <tr>
    <td>Street 6 de Diciembre y Bosmediano</td>
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
    <br><br>We have received your request for a quote.     
    <br><br>We enclose the data of your request: 
    </td>
    
    <td width="10%"><img src="https://medifestructuras.com/imagenes/EnvesTarjetaEdu.png" width="130" height="100" >
    </td>
  </tr>
</table>

<table width="100%" border="1" cellpadding="4" cellspacing="5" bordercolor="#000000"  style="font-family:Arial, Helvetica, sans-serif; font-size:12px;border-collapse:collapse">
  <tr>
    <td width="15%" bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top;font-weight:bold">First Name</td>
    <td width="85%"><?php echo $_POST['nombre'] ;?></td>
  </tr>
  <tr>
    <td bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Surname(s)</td>
    <td><?php echo $_POST['apellidos'] ;?></td>
  </tr>
  <tr>
    <td bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">E-mail</td>
    <td><?php echo $_POST['email'] ;?></td>
  </tr>
  <tr>
    <td bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Phone:</td>
    <td><?php echo $_POST['telefono'] ;?></td>
  </tr>
  <tr>
    <td bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">City</td>
    <td><?php echo $_POST['ciudad'] ;?></td>
  </tr>
    <tr>
    <td bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Observations</td>
    <td><?php echo $_POST['comentarios'] ;?></td>
  </tr>

  <tr>
    <td bgcolor="#03F" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FFF ; font-size:0.9em; text-align:right;padding-right:0.2em; vertical-align:top">Project file</td>
    <td><?php echo $_POST['fichero'] ;?></td>
  </tr>
 
</table>
<br>
For any other information you can visit our website: <a href="https://medifestructuras.com">medifestructuras.com</a> or reply to this email
<p>Thank you for your trust.</p>
<p>Soon we will contact you.</p>
<p>&nbsp;</p>
<p>Sincerely,</p>
<p><?php echo $_POST['Nombre_correo'] ;?></p>
<p><br>
 

</body>
</html>
