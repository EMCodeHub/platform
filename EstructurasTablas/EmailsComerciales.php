<!DOCTYPE HTML><html lang='en' dir='ltr' class='safari safari8'><meta charset="utf-8" /><meta name="robots" content="noindex,nofollow" /><meta http-equiv="X-UA-Compatible" content="IE=Edge"><link rel="icon" href="favicon.ico" type="image/x-icon" /><link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /><link rel="stylesheet" type="text/css" href="print.css" /><title>Print view - phpMyAdmin 4.2.10</title>
</head><body><noscript></noscript><div id="page_content"><div>
<h1>emailscomerciales</h1>
<p>Son los datos del correo electrónico para enviar e-mails a los clientes, indicaremos servidor, ususrio, contraseña</p>
<p>Cada curso lleva asociado un mailcomercial, el que recibirá los correos de los clientes</p>
<table border = "1" style="width: 100%;">
  <thead><tr><th>Column</th><th>Type</th><th>Null</th><th>Default</th>    <th>Comments</th>
</tr></thead><tbody>
<tr><td>    id
</td><td>int(6)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>La id nunca se informa, es un campo autoincrementado.</td>
</tr>
<tr><td>    correoelectronico
</td><td>varchar(60)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>el email que recibirá las peticiones&nbsp;</td>
</tr>
<tr><td>    nombre_interno
</td><td>varchar(60)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>Una etiqueta interna diferente del nombre verdadero&nbsp;</td>
</tr>
<tr><td>    nombre_correo
</td><td>varchar(60)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>Nombre que aparecerá como emisor del correo&nbsp;</td>
</tr>
<tr><td>    es_smtp
</td><td>int(1)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>Si es SMTP poner un 1, si SMPT tiene un 1, POP3 debería tener un cero&nbsp;. EStos datos son iguales a los que se introducen para configurar una cuenta de correo en outlook o en un teléfono.</td>
</tr>
<tr><td>    es_pop3
</td><td>int(1)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>1 si es POP3</td>
</tr>
<tr><td>    servidor
</td><td>varchar(50)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>Nombre del servidor</td>
</tr>
<tr><td>    puerto
</td><td>int(5)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>A veces no hace falta </td>
</tr>
<tr><td>    seguridad
</td><td>varchar(20)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>ssl o nada&nbsp;</td>
</tr>
<tr><td>    requiere_auth
</td><td>int(1)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>1 si requiere autentificación</td>
</tr>
<tr><td>    usuario
</td><td>varchar(50)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>nombre del usuario, ojo, que a veces es diferente del e-mail</td>
</tr>
<tr><td>    password
</td><td>varchar(20)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>password para abrir el correo</td>
</tr>
<tr><td>    usa_logo
</td><td>int(1)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>Si es que si = 1, se pondrá el logo en las cartas que escriba, en la cabecera&nbsp;</td>
</tr>
<tr><td>    fichero_logo
</td><td>varchar(150)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>El fichero de logo que estará en la carpeta imágenes/Logos&nbsp;</td>
</tr></tbody></table><h3>Indexes</h3><div class='no_indexes_defined hide'><div class="notice"><img src="themes/dot.gif" title="" alt="" class="icon ic_s_notice" /> No index defined!</div></div><table border = "1" id="table_index"><thead><tr><th>Keyname</th><th>Type</th><th>Unique</th><th>Packed</th><th>Column</th><th>Cardinality</th><th>Collation</th><th>Null</th><th>Comment</th></tr></thead><tbody><tr class="noclick odd"><td  rowspan="1" >PRIMARY</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >Yes</td><td  rowspan="1" >No</td><td>id</td><td>1</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr></tbody></table></div>
<p class="print_ignore"><input type="button" class="button" id="print" value="Volver"  onClick='location.href="../mantenimiento/mantenimiento.php"'/></p></body></html>
</html>
