<!DOCTYPE HTML><html lang='en' dir='ltr' class='safari safari8'><meta charset="utf-8" /><meta name="robots" content="noindex,nofollow" /><meta http-equiv="X-UA-Compatible" content="IE=Edge"><link rel="icon" href="favicon.ico" type="image/x-icon" /><link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /><link rel="stylesheet" type="text/css" href="print.css" /><title>Estructura tabla Cursos</title>
</head><body><noscript></noscript><div id="page_content"><div><h1>cursos</h1>
<table border = "1" style="width: 100%;"><thead><tr><th>Column</th><th>Type</th><th>Null</th><th>Default</th><th>Links to</th>
    <th>Comments</th>
</tr></thead><tbody>
<tr><td>    id
</td><td>int(10)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>&nbsp;</td>
    <td>La ID nunca debe llenarse en un fichero, es read-only, es un campo autoincrementado, automático&nbsp;</td>
</tr>
<tr><td>    referencia
</td><td>varchar(20)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>&nbsp;</td>
    <td>Es el código de curso, un número para saber exactamente de qué curso hablamos, como si fuera la referencia de un color&nbsp;</td>
</tr>
<tr><td>    esta_activo
</td><td>int(1)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>&nbsp;</td>
    <td>0= Curso no activo(anulado)  1=Curso activo. Los cursos NO activos no se visualizaran en la web&nbsp;</td>
</tr>
<tr><td>    fecha_ini
</td><td>date<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Fecha inicio curso&nbsp;</td>
</tr>
<tr><td>    fecha_fin
</td><td>date<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Fecha fin curso&nbsp;</td>
</tr>
<tr><td>    ponente
</td><td>varchar(200)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>&nbsp;</td>
    <td>Nombre de la persona que da el curso&nbsp;</td>
</tr>
<tr><td>    id_mailcomer
</td><td>int(6)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>emailscomerciales -&gt; id&nbsp;</td>
    <td>El mail que recibirá los e-mails cuando un potencial cliente solicite un curso&nbsp;</td>
</tr>
<tr><td>    id_organizador
</td><td>int(6)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>organizadores -&gt; id&nbsp;</td>
    <td>Crear un organizador nuevo para cada local en el que se hacen cursos. Utilizar nombre.ubicación. que es donde se realizara el curso&nbsp;</td>
</tr>
<tr><td>    titulo_abreviado
</td><td>varchar(40)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>&nbsp;</td>
    <td>Es el que se usara  para crear las selects de los emails. Es un título super corto, condensado, en 30 palabras.&nbsp;</td>
</tr>
<tr><td>    titulo_corto
</td><td>varchar(200)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>&nbsp;</td>
    <td>Aparecera en la ficha del curso como titulo principal en granate&nbsp;</td>
</tr>
<tr><td>    titulo_largo
</td><td>varchar(500)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>&nbsp;</td>
    <td>descripción exhaustiva del curso&nbsp;</td>
</tr>
<tr><td>    id_tipocurso
</td><td>int(6)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>tipocurso -&gt; id&nbsp;</td>
    <td>Seminario, presentación&nbsp;</td>
</tr>
<tr><td>    id_modalidad
</td><td>int(6)<bdo dir="ltr"></bdo></td><td>No&nbsp;</td><td>&nbsp;</td>    <td>modalidadcurso -&gt; id&nbsp;</td>
    <td>Presencial, On line, videoconferencia&nbsp;</td>
</tr>
<tr><td>    id_periodicidad
</td><td>int(6)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>periodocursos -&gt; id&nbsp;</td>
    <td>Si es única, diaria, mensual ..&nbsp;</td>
</tr>
<tr><td>    horario
</td><td>varchar(30)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Ej:  16:00 - 19:00&nbsp;</td>
</tr>
<tr><td>    num_horas_curso
</td><td>int(6)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Número total de horas del curso&nbsp;</td>
</tr>
<tr><td>    programas_utili
</td><td>varchar(200)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Programas utilizados en el curso&nbsp;</td>
</tr>
<tr><td>    precio
</td><td>varchar(30)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>300 $, gratis, a convenir&nbsp;</td>
</tr>
<tr><td>    forma_pago
</td><td>varchar(300)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Descuentos especiales para grupos, o lo que quieras pones. Es el cómo cobrarás ese curso. Puedes decir que sólo se pagará a partir de la segunda o tercera sesión etc. .....&nbsp;</td>
</tr>
<tr><td>    plazas_aprox
</td><td>int(6)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>plazas aproximadas del curso&nbsp;</td>
</tr>
<tr><td>    programa_pdf
</td><td>varchar(150)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Es un fichero PDF que contiene el programa del curso. Para diseñar un nuevo curso empezar diseñando un PDF con su programa. ANES DE NADA SUBIR ESE PDF (con fiilezilla) A LA WEB. Se dejará el fichero PDF en la carpeta &quot;CURSOSPROGRAMAS&quot;&nbsp;</td>
</tr>
<tr><td>    documentos_pdf
</td><td>varchar(150)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Esta es la documentación del curso, algo más extenso que el programa, pueden ser ejemplos, fotos. Ya veremos si a este documento se tiene acceso si eres un usuario conectado, te he dado de alta un usuario no administrador y tú tienes acceso a ver este PDF. Ese documento se dejará en la carpeta &quot;CURSOSDOCUMENTOS&quot;&nbsp;</td>
</tr>
<tr><td>    carta_inscripcion
</td><td>varchar(150)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Carta que enviaremos al alumno después de inscribirse, recordar forma de pago o lo que sea, bienvenida a secas, etc&nbsp;</td>
</tr>
<tr><td>    observaciones
</td><td>varchar(300)<bdo dir="ltr"></bdo></td><td>Yes&nbsp;</td><td><i>NULL</i>&nbsp;</td>    <td>&nbsp;</td>
    <td>Cualquier otra información que quieras publicar en la ficha del curso.&nbsp;</td>
</tr></tbody></table><h3>Indexes</h3><div class='no_indexes_defined hide'><div class="notice"><img src="themes/dot.gif" title="" alt="" class="icon ic_s_notice" /> No index defined!</div></div><table border = "1" id="table_index"><thead><tr><th>Keyname</th><th>Type</th><th>Unique</th><th>Packed</th><th>Column</th><th>Cardinality</th><th>Collation</th><th>Null</th><th>Comment</th></tr></thead><tbody><tr class="noclick odd"><td  rowspan="1" >PRIMARY</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >Yes</td><td  rowspan="1" >No</td><td>id</td><td>3</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr><tr class="noclick even"><td  rowspan="1" >referencia</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >Yes</td><td  rowspan="1" >No</td><td>referencia</td><td>3</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr><tr class="noclick odd"><td  rowspan="2" >id_organizador</td><td  rowspan="2" >BTREE</td><td  rowspan="2" >No</td><td  rowspan="2" >No</td><td>id_organizador</td><td>3</td><td>A</td><td>No</td><td  rowspan="2" ></td></tr><tr class="noclick odd"><td>id_modalidad</td><td>3</td><td>A</td><td>No</td></tr><tr class="noclick even"><td  rowspan="1" >id_tipocurso</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >No</td><td  rowspan="1" >No</td><td>id_tipocurso</td><td>3</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr><tr class="noclick odd"><td  rowspan="1" >id_modalidad</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >No</td><td  rowspan="1" >No</td><td>id_modalidad</td><td>3</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr><tr class="noclick even"><td  rowspan="1" >id_tipocurso_2</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >No</td><td  rowspan="1" >No</td><td>id_tipocurso</td><td>3</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr><tr class="noclick odd"><td  rowspan="1" >id_periodicidad</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >No</td><td  rowspan="1" >No</td><td>id_periodicidad</td><td>3</td><td>A</td><td>Yes</td><td  rowspan="1" ></td></tr><tr class="noclick even"><td  rowspan="1" >id_tipocurso_3</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >No</td><td  rowspan="1" >No</td><td>id_tipocurso</td><td>3</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr><tr class="noclick odd"><td  rowspan="1" >id_modalidad_2</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >No</td><td  rowspan="1" >No</td><td>id_modalidad</td><td>3</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr><tr class="noclick even"><td  rowspan="1" >mail_solicitudes</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >No</td><td  rowspan="1" >No</td><td>id_mailcomer</td><td>3</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr></tbody></table></div>
<p class="print_ignore"><input type="button" class="button" id="print" value="Volver"  onClick='location.href="../mantenimiento/mantenimiento.php"'/></p></body></html>