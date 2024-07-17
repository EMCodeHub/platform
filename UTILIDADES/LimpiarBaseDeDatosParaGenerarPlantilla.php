<!doctype html>

<html>
<head>
<meta charset="UTF-8">
<title>Vaciar base de datos</title>

<style>
    ul {
        margin-left: 50px;
    }
    .otros {
        margin-left: 50px;
    }
  .ButtonGrisP {
    font-family: 'Montserrat', sans-serif;
	background-color:transparent;
	border-radius:28px;
	border:1px solid #737874;
	display:inline-block;
	cursor:pointer;
	color:#6e6e6e;
	font-size:12px;
	padding:9px 15px;
	text-decoration:none;
	
}
.ButtonGrisP:hover {
	background:linear-gradient(to bottom, #b7c4eb 5%, #cfcfcf 100%);
	background-color:#b7c4eb;
}
.ButtonGrisP:active {
	position:relative;
	top:1px;
}    
.centro {
	text-align:center;
}  
    
</style>
</head>

<body>
<h1>Vaciado de la base de datos para generar la plantilla (en LOCALHOST)</h1>
</br>
<?php
$conexion = null;
if (strlen(trim($_REQUEST['BDDName'])) > 0 ) {
    echo "Entramos a procesar</br>";
    $conexion = conectate($_REQUEST['BDDName'], $_REQUEST['BDDUsu'], $_REQUEST['BDDPwd']);
    if ( $conexion == null) {
        echo "NO HAY CONEXIÓN CON BASE DE DATOS</br>";
        
    } else {
        echo "CONEXIÓN con base de datos ESTABLECIDA</br></br>";
        if (limpia($conexion) <> 1) {
            echo "ERROR limpiando base de datos</br>";
        } else {
            echo "</br>Limpieza de base de datos CORRECTA</br>";
            echo "</br>PENDIENTE: Borrar de la carpeta VIDEOTUTORIALES las subcarpetas que no sean del curso número 1</br>";
            echo "</br>El usuario administrador será el mismo que emprendecon, con su misma password</br>";
            
            echo "</br>Puede que sea necesario borrar el historial de navegación para que arranque la nueva web</br></br></br>";
            
        }
    }
    exit;
    
}


?>  
 
<p>Este procedimiento limpia la base de dados de emprendecon para generar una plantilla (Sólo funcionará en localhost)</p>
<p>Pasos a seguir:</p>
    <ul>
      <li>CREAR una carpeta en localhost y COPIAR la web de emprendecon. Toda la estructura de carpetas</li>
      <li>BORRAR de la carpeta VIDEOTURORIALES las subcarpetas que no sean del curso número 1</li>
      <li>Exportar la base de datos de emprendecon</li>
      <li>Editar el archivo exportado y eliminar la línea CREATE DATABASE qaed777</li>    
      
      <li>Crear una base de datos en localhost con el archivo recientemente exportado</li>
      <li>Tomar nota del nuevo nombre de base de datos, de la que hemos generado en localhost</li>
      <li>Informar en esta página el nombre base de datos, usuario y contraseña</li>
      <li>Pulsar el botón Limpiar base de datos</li>
      <li>Al acabar tendremos la base de datos limpia: con un sólo alumno que es el administrador, con un curso de ejemplo y  sólo un registro de órdenes de pago</li>
    <li>Una vez limpia la base de datos la tenemos que volver a exportar y el fichero generado es el que se usará para la plantilla</li>
    </ul>
    
    <form action="LimpiarBaseDeDatosParaGenerarPlantilla.php" method="get">
    <div class="otros">
     Nombre de la base de datos creada: <input id="BDDName" name="BDDName" size="40" type="text" placeholder="Nombre de la base de datos ?"></br>
     Usuario: <input id="BDDUsu" name="BDDUsu" size="40" type="text" placeholder="Nombre del usuario ?"></br>
     Contraseña: <input id="BDDPwd" name="BDDPwd" size="40" type="text" placeholder="Cuál es la contraseña ?"></br>
   </div>
<div class="centro">
    <input type="submit" id="Limpiar" name="Limpiar" value="Limpiar base de datos" class="ButtonGrisP">
</div>
    </form>
    
    
</body>
</html>

<?php
function conectate($bdd, $usu, $pwd){
    $connect = mysqli_connect("localhost", $usu, $pwd, $bdd);
    mysqli_set_charset ( $connect , 'utf8' );
    return $connect;
    
}
//.......................................................................
function autoincremento($conexion, $tabla,$campo_id){
 $maxID = 1;    
 $Format = "SELECT MAX(%s) AS contador from %s";
 $queFormat = sprintf($Format, $campo_id, $tabla); 
 $resFormat = mysqli_query($conexion, $queFormat) or die(mysqli_error($conexion));
 while ($rowFormat = mysqli_fetch_assoc($resFormat)) {
   	 	$maxID = $rowFormat[contador]+1;
 }
 mysqli_free_result($resFormat); 
// **********
 $Auto = "ALTER TABLE %s  AUTO_INCREMENT = %d;";
 $queAuto = sprintf($Auto,  $tabla, $maxID);  
 $resAuto = mysqli_query($conexion, $queAuto) or die(mysqli_error($conexion));
 mysqli_free_result($resAuto); 
 return $maxID;
}
//.......................................................................
function limpia($conexion){
    $devolver = 0;
    //...................................................................
    echo "Borrando vtpermisos, autoincremento = ";
    $orden = "DELETE from vtpermisos";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtpermisos","id_usuario")."<br>";
    //...................................................................
    echo "Borrando vtusorecurso, autoincremento = ";
    $orden = "DELETE from vtusorecurso";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtusorecurso","id")."<br>";
    //...................................................................
    echo "Borrando vtusotema, autoincremento = ";
    $orden = "DELETE from vtusotema";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtusotema","id")."<br>";
    //...................................................................
    echo "Borrando vtusovideo, autoincremento = ";
    $orden = "DELETE from vtusovideo";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtusovideo","id")."<br>";
    
   
    //...................................................................
    echo "Borrando vtsesiones, autoincremento = ";
    $orden = "DELETE from vtsesiones";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtsesiones","id")."<br>";
    //...................................................................
    echo "Borrando vtsesionlead, autoincremento = ";
    $orden = "DELETE from vtsesionlead";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtsesionlead","id")."<br>";
    //...................................................................
    echo "Borrando vtsesiongratis, autoincremento = ";
    $orden = "DELETE from vtsesiongratis";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtsesiongratis","id")."<br>";
    //...................................................................
     echo "Borrando vtcobros, autoincremento = ";
    $orden = "DELETE from vtcobros WHERE id <>1";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtcobros","id")."<br>";
    //...................................................................
     echo "Borrando vtcobrosotros, autoincremento = ";
    $orden = "DELETE from vtcobrosotros WHERE id <>1";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtcobrosotros","id")."<br>";
    //...................................................................
     echo "Borrando vtsolicitudes, autoincremento = ";
    $orden = "DELETE from vtsolicitudes where id <> 1";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtsolicitudes","id")."<br>";
    $orden = "UPDATE vtsolicitudes SET id_curso = 1 where id = 1";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    
    
    
    //...................................................................
    
    echo "Borrando vtcurmodbloqvideo, autoincremento = ";
    $orden = "DELETE vtcurmodbloqvideo 
                FROM vtcursos, vtcursomodulo, vtcurmodbloque,vtcurmodbloqvideo
               WHERE vtcursomodulo.id_vtcurso = vtcursos.id_curso
                 and vtcurmodbloque.id_vtcurmodulo = vtcursomodulo.id_modulo
                 and vtcurmodbloqvideo.id_vtcurmodbloque = vtcurmodbloque.id_bloque 
                 and vtcursos.id_curso <> 1";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtcurmodbloqvideo","id")."<br>";
    //...................................................................
    echo "Borrando vtcurmodbloqtema, autoincremento = ";
    $orden = "DELETE vtcurmodbloqtema 
                FROM vtcursos, vtcursomodulo, vtcurmodbloque,vtcurmodbloqtema
               WHERE vtcursomodulo.id_vtcurso = vtcursos.id_curso
                 and vtcurmodbloque.id_vtcurmodulo = vtcursomodulo.id_modulo
                 and vtcurmodbloqtema.id_vtcurmodbloque = vtcurmodbloque.id_bloque 
                 and vtcursos.id_curso <> 1";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtcurmodbloqtema","id")."<br>";
     //...................................................................
    echo "Borrando vtcurmodbloqrecurso, autoincremento = ";
    $orden = "DELETE vtcurmodbloqrecurso 
                FROM vtcursos, vtcursomodulo, vtcurmodbloque,vtcurmodbloqrecurso
               WHERE vtcursomodulo.id_vtcurso = vtcursos.id_curso
                 and vtcurmodbloque.id_vtcurmodulo = vtcursomodulo.id_modulo
                 and vtcurmodbloqrecurso.id_vtcurmodbloque = vtcurmodbloque.id_bloque 
                 and vtcursos.id_curso <> 1";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtcurmodbloqrecurso","id")."<br>";
    //...................................................................
    echo "Borrando vtcurmodbloque, autoincremento = ";
    $orden = "DELETE vtcurmodbloque 
                FROM vtcursos, vtcursomodulo, vtcurmodbloque
               WHERE vtcursomodulo.id_vtcurso = vtcursos.id_curso
                 and vtcurmodbloque.id_vtcurmodulo = vtcursomodulo.id_modulo
                 and vtcursos.id_curso <> 1";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtcurmodbloque","id_bloque")."<br>";
   //...................................................................
    echo "Borrando vtcursomodulo, autoincremento = ";
    $orden = "DELETE vtcursomodulo 
                FROM vtcursos, vtcursomodulo
               WHERE vtcursomodulo.id_vtcurso = vtcursos.id_curso
                 and vtcursos.id_curso <> 1";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtcursomodulo","id_modulo")."<br>";
   //...................................................................
    echo "Borrando vtcursos, autoincremento = ";
    $orden = "DELETE from vtcursos
               WHERE vtcursos.id_curso <> 1";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtcursos","id_curso")."<br>";
    //...................................................................
    echo "Borrando vtavisoalumno, autoincremento = ";
    $orden = "DELETE from vtavisoalumno";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtavisoalumno","id")."<br>";
  //...................................................................
    echo "Borrando vtcambiopwd, autoincremento = ";
    $orden = "DELETE from vtcambiopwd";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtcambiopwd","id")."<br>"; 
  //...................................................................
    echo "Borrando vtcartasregistros, autoincremento = ";
    $orden = "DELETE from vtcartasregistros";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtcartasregistros","id")."<br>"; 
   //...................................................................
    echo "Borrando vtcartascabecera, autoincremento = ";
    $orden = "DELETE from vtcartascabecera";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtcartascabecera","id")."<br>";    
    //...................................................................
    echo "Borrando vtcheckout, autoincremento = ";
    $orden = "DELETE from vtcheckout";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtcheckout","id")."<br>";    
    //...................................................................
    echo "Borrando vtleads, autoincremento = ";
    $orden = "DELETE from vtleads";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtleads","id")."<br>";    
    //...................................................................
    echo "Borrando vtestadiscursos, autoincremento = ";
    $orden = "DELETE from vtestadiscursos";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtestadiscursos","id")."<br>";    
    //...................................................................
    echo "Borrando vtpreciolote, autoincremento = ";
    $orden = "DELETE from vtpreciolote";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtpreciolote","id")."<br>";    
    //...................................................................
    echo "Borrando asesoriasesiones, autoincremento = ";
    $orden = "DELETE from asesoriasesiones";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "asesoriasesiones","id")."<br>";    
    //...................................................................
    echo "Borrando vtsolcobro, autoincremento = ";
    $orden = "DELETE from vtsolcobro";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtsolcobro","id")."<br>";    
    //...................................................................
    echo "Borrando vtalumnos, autoincremento = ";
    $orden = "DELETE from vtalumnos where es_adm <1";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    $orden = "UPDATE vtalumnos SET id = 1";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "vtalumnos","id")."<br>";  
    //...................................................................
    echo "Borrando usuarios, autoincremento = ";
    $orden = "DELETE from usuarios";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "usuarios","id")."<br>"; 
   //...................................................................
    echo "Borrando programasdemos, autoincremento = ";
    $orden = "DELETE from programasdemos";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "programasdemos","id")."<br>";  
    //...................................................................
    echo "Borrando emailscomerciales, autoincremento = ";
    $orden = "DELETE from emailscomerciales WHERE tipocorreo > 3";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    $orden = "UPDATE emailscomerciales 
              SET correoelectronico = 'tucorreo@dominio.com',
              nombre_correo = 'tu nombre tus apellidos',
              usuario = 'usuario de conexión l correo',
              password ='Contraseña de acceso'";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "emailscomerciales","id")."<br>"; 
    //...................................................................
    echo "Borrando organizadores, autoincremento = ";
    $orden = "DELETE from organizadores WHERE id <> 1";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    $orden = "UPDATE organizadores 
              SET pers_contacto = 'Nombre Apellidos',
              tfn_Contacto = '+34 12345678'";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "organizadores","id")."<br>"; 
 
    //...................................................................
    echo "Borrando cursos, autoincremento = ";
    $orden = "DELETE from cursos WHERE id <> 1";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    $orden = "UPDATE cursos 
              SET ponente = 'Nombre Pnente'";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "cursos","id")."<br>"; 
    //...................................................................
    echo "Borrando alumnosinscritos, autoincremento = ";
    $orden = "DELETE from alumnosinscritos";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "alumnosinscritos","id")."<br>";  
   //...................................................................
    echo "Borrando forosolicitudes, autoincremento = ";
    $orden = "DELETE from forosolicitudes";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "forosolicitudes","id")."<br>";  
    //...................................................................
    echo "Borrando forosrecursos, autoincremento = ";
    $orden = "DELETE from forosrecursos";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "forosrecursos","id")."<br>";  
     //...................................................................
    echo "Borrando forosmensajes, autoincremento = ";
    $orden = "DELETE from forosmensajes";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "forosmensajes","id")."<br>";  
      //...................................................................
    echo "Borrando forostemas, autoincremento = ";
    $orden = "DELETE from forostemas";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "forostemas","id")."<br>";  
    //...................................................................
    echo "Borrando foroscuestiones, autoincremento = ";
    $orden = "DELETE from foroscuestiones";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "foroscuestiones","id")."<br>";  
    //...................................................................
    echo "Borrando forosclases, autoincremento = ";
    $orden = "DELETE from forosclases";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo autoincremento($conexion, "forosclases","id")."<br>";  
   //...................................................................  
    $orden = "UPDATE vtparamdatosweb 
              SET web_dominio = 'TuDominio.com',
              web_url = 'https://TuDominio.com',
              mapslocalizacion = 'Copia direccion de Google Maps',
              registro_mercantil = '9876543210',
              tituloacademico = 'Ingeniero naval',
              colegioprofesional = 'Nombre del colegio',
              num_colegiado = '9912345',
              tribunal_legislacion = 'Barcelona',
              tribunal_provincia = 'Barcelona',
              nif = '4444444444',
              finalidadweb = 'Tu Web es un proyecto que cuenta con más de <b>5 años en el mercado de la capacitación online y presencial</b>. <br><br>Nace con la intención de brindar una herramienta de aprendizaje efectiva y práctica para todos aquellos que se encuentren en el área de la construcción y que aspiren convertirse en especialistas en <b>Estructuras e Instalaciones utilizando software  Cype</b>. <br><br>
             A lo largo de estos últimos años hemos capacitado a <b>un gran número de ingenieros ...',
             descuento_activo = 0,
             web_usuarioskype = 'Tu Usuario Skype',
             web_tfnWhatsapp = '123 8888888',
             web_facebook = 'https://www.facebook.com/Acceso a tu pagina Facebook',
             web_instagram = 'https://www.instagram.com/Acceso a tu pagina Instagram',
             web_twitter = '',carta_funcionempresa = 'CONSULTORíA Y DISEÑO DE .....',carta_direcc1 = 'Calle, número, piso',
             carta_direcc2 = '',carta_codpostal = '11111',
             carta_poblacion = 'Población oficina',
             carta_pais = '',
             curso_en_promocion = 0,
             moneda = 'EUR',
             codigo_tagmanager = 'GTM-********',
             codigo_analytics = 'UA-********-1'";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo "Modificado vtparamdatosweb. Cambiados los valores</br>"; 
   //...................................................................  
    $orden = "UPDATE vtparametros 
              SET twocheck_activo = 1,
              twocheck_real_id = 'Codigo cliente',
              twocheck_real_word = 'Palabra secret 2checkout',
              transfer_entidad = 'Banco para recibir transferencias',
              transfer_cuenta = 'Número cuenta bancaria',
              transfer_beneficiario = 'Nombre beneficiario, el tuyo'
              ";
    $resOrden = mysqli_query($conexion, $orden) or die(mysqli_error($conexion));
    mysqli_free_result($resOrden);
    echo "Modificado vtparametros. Cambiados los valores</br>"; 
 
    
    
    
    //...................................................................
    $devolver = 1;
    return $devolver;
}


?>


