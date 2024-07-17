<!DOCTYPE HTML><html lang='en' dir='ltr' class='safari safari8'><meta charset="utf-8" /><meta name="robots" content="noindex,nofollow" /><meta http-equiv="X-UA-Compatible" content="IE=Edge"><link rel="icon" href="favicon.ico" type="image/x-icon" /><link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /><link rel="stylesheet" type="text/css" href="print.css" /><title>Estructura tabla Organizadores</title>
</head><body><noscript></noscript><div id="page_content"><div>
<h1>organizadores</h1>
<table border = "1" style="width: 100%;"><thead><tr><th>Column</th><th>Type</th><th>Null</th><th>Default</th>    <th>Comments</th>
</tr></thead><tbody>
<tr><td>    id
</td><td>int(6)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>El campo id no se informa en los formularios, es autoincrementable.&nbsp;</td>
</tr>
<tr><td>    descripcion_interna
</td><td>varchar(100)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>Es el nombre casero, En realidad el organizador es el local en el que se impartirá el curso. Si haces un curso en tu oficina o en la cámara de comercio, según el lugar del curso tendrás que dar de alta un organizador. Luego el curso tendrá su propio ponente, su propio e-mail comercial&nbsp;</td>
</tr>
<tr><td>    nombre_organizador
</td><td>varchar(100)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>CYPE Ingenieros S.A.     /   Medif   /  Otra empresa&nbsp;</td>
</tr>
<tr><td>    pais
</td><td>varchar(30)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>En el que se realiza el curso&nbsp;</td>
</tr>
<tr><td>    ciudad
</td><td>varchar(30)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>En la que se celebra el curso&nbsp;</td>
</tr>
<tr><td>    lugar
</td><td>varchar(100)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>Oficina CYPE Quito   / Salón de actos del Ayuntamiento de Quito&nbsp;</td>
</tr>
<tr><td>    direccion
</td><td>varchar(100)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>Dirección a la que tiene que acudir el alumno a realizar el curso&nbsp;</td>
</tr>
<tr><td>    pers_contacto
</td><td>varchar(50)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>Nombre de la persona de contacto, tiene asociado su teléfono, el mail de inscripción del curso está anotado en el mismo curso, no en el organizador. Convendría que la persona de contacto sea diferente de la que luego se informa de ponente en el curso.&nbsp;</td>
</tr>
<tr><td>    tfn_contacto
</td><td>varchar(30)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>El teléfono de la persona de contacto o donde se desee que llame el cliente para pedir información&nbsp;</td>
</tr></tbody></table border = 1><h3>Indexes</h3><div class='no_indexes_defined hide'><div class="notice"><img src="themes/dot.gif" title="" alt="" class="icon ic_s_notice" /> No index defined!</div></div><table border = 1" id="table_index"><thead><tr><th>Keyname</th><th>Type</th><th>Unique</th><th>Packed</th><th>Column</th><th>Cardinality</th><th>Collation</th><th>Null</th><th>Comment</th></tr></thead><tbody><tr class="noclick odd"><td  rowspan="1" >PRIMARY</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >Yes</td><td  rowspan="1" >No</td><td>id</td><td>2</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr></tbody></table></div>
<p class="print_ignore"><input type="button" class="button" id="print" value="Volver"  onClick='location.href="../mantenimiento/mantenimiento.php"'/></p></body></html>