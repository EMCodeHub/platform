<!DOCTYPE HTML><html lang='en' dir='ltr' class='safari safari8'><meta charset="utf-8" /><meta name="robots" content="noindex,nofollow" /><meta http-equiv="X-UA-Compatible" content="IE=Edge"><link rel="icon" href="favicon.ico" type="image/x-icon" /><link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /><link rel="stylesheet" type="text/css" href="print.css" /><title>Estructura tabla Usuarios</title>
</head><body><noscript></noscript><div id="page_content"><div>
<h1>usuarios</h1>
<table border "1" style="width: 100%;"><thead><tr><th>Column</th><th>Type</th><th>Null</th><th>Default</th>    <th>Comments</th>
</tr></thead><tbody>
<tr><td>    id
</td><td>int(6)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>&nbsp;</td>
</tr>
<tr><td>    nombre_usuario
</td><td>varchar(20)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>Nombre con el que te conectas. Si eres administrador, tienes acceso al menú de mantenimiento: puedes modificar datos de la web&nbsp;</td>
</tr>
<tr><td>    pwd
</td><td>varchar(20)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>password del usuario&nbsp;</td>
</tr>
<tr><td>    es_admin
</td><td>int(1)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>0&nbsp;</td>    <td>1 = Administrador, tiene acceso a modificar información de la web. Si das de alta un nuevo usuario vigila que este campo tenga un 0, no un 1.&nbsp;</td>
</tr>
<tr><td>    referencia_interna
</td><td>varchar(50)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>Es un numerito que informas cuando das de alta el usuario, ya está controlado por la id del registro, pero esta es la referencia bajo la cual tú conoces a ese usuario&nbsp;</td>
</tr>
<tr><td>    fecha_alta
</td><td>date<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
</tr>
<tr><td>    fecha_baja
</td><td>date<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>Si está informada y la fecha sistema es superior, el usuario está dado de baja.No activo&nbsp;</td>
</tr></tbody></table ><h3>Indexes</h3><div class='no_indexes_defined hide'></div><table border = "1" id="table_index"><thead><tr><th>Keyname</th><th>Type</th><th>Unique</th><th>Packed</th><th>Column</th><th>Cardinality</th><th>Collation</th><th>Null</th><th>Comment</th></tr></thead><tbody><tr class="noclick odd"><td  rowspan="1" >PRIMARY</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >Yes</td><td  rowspan="1" >No</td><td>id</td><td>3</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr></tbody></table></div>
<p class="print_ignore"><input type="button" class="button" id="print" value="Volver"  onClick='location.href="../mantenimiento/mantenimiento.php"'/></p></body></html>