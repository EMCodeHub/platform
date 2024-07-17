<!DOCTYPE HTML><html lang='en' dir='ltr' class='safari safari8'><meta charset="utf-8" /><meta name="robots" content="noindex,nofollow" /><meta http-equiv="X-UA-Compatible" content="IE=Edge"><link rel="icon" href="favicon.ico" type="image/x-icon" /><link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /><link rel="stylesheet" type="text/css" href="print.css" /><title>Estructura tabla Emails recibidos (Presupuestos, cursos ...)</title>
</head><body><noscript></noscript><div id="page_content"><div>
<h1>alumnosinscritos</h1>
<table border = "1" style="width: 100%;"><thead><tr><th>Column</th><th>Type</th><th>Null</th><th>Default</th><th>Links to</th>
    <th>Comments</th>
</tr></thead><tbody>
<tr><td>    id
</td><td>int(10)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>&nbsp;</td>
    <td>No informar este campo&nbsp;</td>
</tr>
<tr><td>    id_curso
</td><td>int(6)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>cursos -&gt; id&nbsp;</td>
    <td>Identificador o id del curso al que se ha inscrito. Daremos de alta un curso genérico para que se puedan recibir en él peticiones de demos de programas, de presupuestos de estructuras, etc&nbsp;</td>
</tr>
<tr><td>    fecha_mail
</td><td>date<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Fecha en que recibimos el correo del cliente, fecha de la petición.&nbsp;</td>
</tr>
<tr><td>    fecha_inscripcion
</td><td>date<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Día en que se inscribe, igual o anterior a la fecha celebración del curso. Para cursos el alumno debe confirmar la inscripción, en ese momento apuntamos esta fecha.</td>
</tr>
<tr><td>    fecha_validacion
</td><td>date<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Debemos confirmar las inscripciones, ponernos en contacto con el alumno y confirmar que efectivamente desea realizar el curso. Un registro sin fecha de confirmación no vale, puede que el tío nos haya tomado el pelo desde la web&nbsp;</td>
</tr>
<tr><td>    nombre
</td><td>varchar(30)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>&nbsp;</td>
    <td>Nombre del alumno. Si es una empresa poner aquí el nombre&nbsp;</td>
</tr>
<tr><td>    apellidos
</td><td>varchar(100)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Apellidos del allumno&nbsp;</td>
</tr>
<tr><td>    email_cliente
</td><td>varchar(100)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>&nbsp;</td>
    <td>Email enviado por el cliente en el formulario de petición o solicitud&nbsp;</td>
</tr>
<tr><td>    telefono
</td><td>varchar(30)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Teléfono del alumno&nbsp;</td>
</tr>
<tr><td>    obser_cliente
</td><td>varchar(400)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Observaciones que el cliente nos envía en su correo &nbsp;</td>
</tr>
<tr><td>    agente_inscriptor
</td><td>varchar(50)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>&nbsp;</td>
    <td>Si el alumno se ha apuntado directamente de la web (automatica), si lo hemos anotado nosotros aquí pondremos el nombre del comercial que ha captado el curso&nbsp;</td>
</tr>
<tr><td>    obser_medif
</td><td>varchar(400)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>&nbsp;</td>
    <td>Observaciones que Medif hace sobre el cliente&nbsp;</td>
</tr>
<tr><td>    email_receptor
</td><td>varchar(100)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>&nbsp;</td>
    <td>Email que ha recibido la solicitud, es un dato duplicado de la tabla de cursos, es para saber si tienes que contestar tú o va dirigido a otra persona&nbsp;</td>
</tr>
<tr><td>    fecha_cobro
</td><td>date<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Apuntas esta fecha cuando hayas cobrado el curso. Si no está se entiende que te lo debe el alumno&nbsp;</td>
</tr>
<tr><td>    fecha_anulacion
</td><td>date<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Si el alumno se borra del curso, queda anulada la inscripción. Fíjate bien que este campo no esté informado cuando recuentes los alumnos de un curso&nbsp;</td>
</tr>
<tr><td>    dni_o_tarjeta
</td><td>varchar(30)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Es la identificación fiscal del alumno&nbsp;</td>
</tr>
<tr><td>    direccion
</td><td>varchar(200)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Domicilio del alumno&nbsp;</td>
</tr>
<tr><td>    ciudad
</td><td>varchar(30)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Ciudad informada en la solicitud de curso o presupuesto&nbsp;</td>
</tr>
<tr><td>    precio_tarifa
</td><td>varchar(50)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Es el precio que consta en el curso, el precio real facturado puede ser diferente&nbsp;</td>
</tr>
<tr><td>    precio_real
</td><td>decimal(8,2)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Importe por el que le hemos facturado el curso, puede ser diferente al que consta en la ficha del curso&nbsp;</td>
</tr>
<tr><td>    aplicado_descuento
</td><td>varchar(100)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Aquí haremos alguna anotación si le hemos facturado con descuento. El porcentaje de descuento o simplemente saber que hemos facturado por debajo de la tarifa oficial&nbsp;</td>
</tr>
<tr><td>    fichero_zipdwg
</td><td>varchar(200)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Fichero enviado por el cliente para calcular presupuesto&nbsp;</td>
</tr></tbody></table><h3>Indexes</h3><div class='no_indexes_defined hide'><div class="notice"><img src="themes/dot.gif" title="" alt="" class="icon ic_s_notice" /> No index defined!</div></div><table border = "1" id="table_index"><thead><tr><th>Keyname</th><th>Type</th><th>Unique</th><th>Packed</th><th>Column</th><th>Cardinality</th><th>Collation</th><th>Null</th><th>Comment</th></tr></thead><tbody><tr class="noclick odd"><td  rowspan="1" >PRIMARY</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >Yes</td><td  rowspan="1" >No</td><td>id</td><td>0</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr><tr class="noclick even"><td  rowspan="1" >id_curso</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >No</td><td  rowspan="1" >No</td><td>id_curso</td><td>0</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr></tbody></table></div>
<p class="print_ignore"><input type="button" class="button" id="print" value="Volver"  onClick='location.href="../mantenimiento/mantenimiento.php"'/></p></body></html>