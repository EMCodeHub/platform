<?php

include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
include_once('../php/SesionesCookies.php'); //Inicio de sesión y asignación de sus variables despues de DatosWeb
?>

<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script  src="../php/VideotutorialesLoginNOIndex.js"></script> 
<?php include_once('PaginaCabecera.php'); ?>  
<?php
include_once('NewWebEstilosNOIndex.php');
include_once('../php/IndexScript.php');
include_once('PaginaCursoPHP01_2.php');  
?>
<?php
 $mapslocalizacion = ""; 
 $registro_mercantil = ""; 
 $tituloacademico = "";
 $colegioprofesional = ""; 
 $num_colegiado = "";
 $tribunal_legislacion = "";
 $tribunal_provincia = "";
 $nif = "";
 $finalidadweb = "";
 $FormatMaestros  = "SELECT mapslocalizacion, 
                            registro_mercantil, 
                            tituloacademico, 
                            colegioprofesional, 
                            num_colegiado, 
                            tribunal_legislacion,
                            tribunal_provincia, 
                            nif, 
                            finalidadweb               
                       FROM vtparamdatosweb
                      WHERE id = 1";
   $queMaestros = $FormatMaestros;
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);
   while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
	  $mapslocalizacion     = $rowRegistros['mapslocalizacion']; 
      $registro_mercantil   = $rowRegistros['registro_mercantil']; 
      $tituloacademico      = $rowRegistros['tituloacademico'];
      $colegioprofesional   = $rowRegistros['colegioprofesional']; 
      $num_colegiado        = $rowRegistros['num_colegiado'];
      $tribunal_legislacion = $rowRegistros['tribunal_legislacion'];
      $tribunal_provincia   = $rowRegistros['tribunal_provincia'];
      $nif                  = $rowRegistros['nif'];
      $finalidadweb         = $rowRegistros['finalidadweb'];   
   }     //while
mysqli_free_result($resMaestros); 

?>   
<title><?php echo $DatosWeb->GetTrimValor('web_dominio')?>: Aviso Legal</title>

<script>
     Nombre_correo = '<?php echo $DatosWeb->GetTrimValor('NombrePrincipal') ?>';
     emisorcorreo = '<?php echo $DatosWeb->GetTrimValor('CorreoPrincipal') ?>'; 
     function CierraAclaracion(modo) {
      		d = document.getElementById('AclaracionCookie');
            if (modo == 0) {
                d.style.display= "none";
            } else {
                 d.style.display= "block";
            }   
     }  
    function VerLocalizacion() {
		URL = "<?php echo $mapslocalizacion ?>";
		window.open(URL,"Localización <?php echo $DatosWeb->GetTrimValor('web_dominio') ?>","width=1000,height=800,scrollbars=YES,resizable=YES,LEFT=100,TOP=50") 	
}
</script>  
 
</head>
<body class="dark-mode">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php
include_once('MenuNOIndex.php');   
?>
 
<div class="PocoEspacio" ></div>
<div class="clear"></div>
  <div class = "Aviso"></div>


<div id="VideoIndex" class="NewDivVideo" >
     <img id="ImaIndex" src="../imagenes/contacto.png"  alt="<?php echo $DatosWeb->GetTrimValor('web_dominio')?> Aviso Legal" />
</div>

<?php
     include_once('PantallaPwd.php');
?>
<div id="content-wrap">
<article class="aviso_legal">



 
    <h2 id=finalidad>Finalidad</h2>
    <p class="PALegal"><span class=azulGenerico><?php echo $finalidadweb ?></span>.</p>
    
    
    <h2 id=condiciones-de-uso>Condiciones de Uso</h2>
    <p class="PALegal">La utilización del sitio Web le otorga la condición de Usuario, e implica la aceptación completa de todas las cláusulas y condiciones de uso incluidas en las páginas:</p>
    <ul class="lista">
      <li>Aviso Legal
      <li class="lipointer" onClick="CierraAclaracion(1)">Política de Privacidad
      <li class="lipointer" onClick="CierraAclaracion(1)">Política de Cookies
    </ul>
     <div id="AclaracionCookie">
          <p class="centro"><b>Política de Privacidad</b></p>
       
         <p class="centro">Las cookies que utiliza este sitio web  NO CONTIENEN información personal</p>
         
         <p class="centro">Utilizamos la cookie ga de Google Analytics para obtener información estadística del tráfico en nuestra web</p>
        
         <p class="centro">En este aula virtual compartimos conocimientos, experiencias, soluciones, sin revelar datos ni detalles personales</p>
         
         <p class="centro">No compartimos datos con terceros.</p>
         
         <br /><br /> 
             <div class="AceptarCookie" onclick="CierraAclaracion(0)"> SALIR </div>  
         </div>
  


    <p class="PALegal">Si no estuviera conforme con todas y cada una de estas cláusulas y condiciones absténgase de utilizar este sitio Web.<p class="PALegal">El acceso a este sitio Web no supone, en modo alguno, el inicio de una relación comercial con el Titular.</p>
    <p class="PALegal">A través de este sitio Web, el Titular le facilita el acceso y la utilización de diversos contenidos que el Titular o sus colaboradores han publicadon por medio de Internet.</p>
    <p class="PALegal">A tal efecto, usted está obligado y comprometido a NO utilizar cualquiera de los contenidos del sitio Web
    con fines o efectos ilícitos, prohibidos en este Aviso Legal o por la legislación vigente, lesivos de los derechos e intereses de terceros, o que de cualquier forma puedan dañar, inutilizar, sobrecargar, deteriorar o impedir la normal utilización de los contenidos, los equipos informáticos o los documentos, archivos y toda clase de contenidos almacenados en cualquier equipo informático propios o contratados por el Titular, de otros usuarios o de cualquier usuario de Internet.</p>
    
    
    <h2 id=comentarios-smallopcionalsmall>Comentarios </h2>
    <p class="PALegal">El Titular se reserva el derecho de retirar todos aquellos comentarios que vulneren la legislación vigente, lesivos de los derechos o intereses de terceros, o que, a su juicio, no resulten adecuados para su publicación.</p>
    <p class="PALegal">El Titular no será responsable de las opiniones vertidas por los usuarios a través del sistema de comentarios, redes sociales u otras herramientas de participación, conforme a lo previsto en la normativa de aplicación.</p>
    
    
    <h2 id=mayora-de-edad-smallopcionalsmall>Mayoría de edad </h2>
    <p class="PALegal">Usted debe tener al menos 18 años de edad para usar los servicios ofrecidos por el Titular o la mayoría de edad que se requiera su país para registrarse en el sitio Web o utilizarlo. Si reside en un país que no pertenezca a la Región europea, debe tener al menos 13 años de edad para usar el sitio Web o la mayoría de edad que se requiera su país para registrarse en el sitio Web o utilizarlo.<p class="PALegal">Además de tener la edad mínima requerida para usar el sitio Web en virtud de la ley aplicable, si no tiene la edad suficiente para poder aceptar nuestras condiciones en su país, su padre, madre, o tutor deben aceptar nuestras condiciones en su nombre.</p>
    
    
    <h2 id=medidas-de-seguridad>Medidas de seguridad</h2>
    <p class="PALegal">Los datos personales que facilite al Titular pueden ser almacenados en bases de datos automatizadas o no, cuya titularidad corresponde en exclusiva a el Titular, que asume todas las medidas de índole técnica, organizativa y de seguridad que garantizan la confidencialidad, integridad y calidad de la información contenida en las mismas de acuerdo con lo establecido en la normativa vigente en protección de datos.</p>
    <p class="PALegal">No obstante, debe ser consciente de que las medidas de seguridad de los sistemas informáticos en Internet no son enteramente fiables y que, por tanto el Titular no puede garantizar la inexistencia de virus u otros elementos que puedan producir alteraciones en los sistemas informáticos (software y hardware) del Usuario o en sus documentos electrónicos y ficheros contenidos en los mismos aunque el Titular pone todos los medios necesarios y toma las medidas de seguridad oportunas para evitar la presencia de estos elementos dañinos</p>
    
    
    <h2 id=datos-personales>Datos personales</h2>
    <p class="PALegal">Usted puede consultar toda la información relativa al tratamiento de datos personales que recoge el Titular en la página de la Política de Privacidad.</p>
    
    <h2 id=contenidos>Contenidos</h2>
    <p class="PALegal">El Titular ha obtenido la información, el contenido multimedia y los materiales incluidos en el sitio Web de fuentes que considera fiables, pero, si bien ha tomado todas las medidas razonables para asegurar que la información contenida es correcta, el Titular no garantiza que sea exacta, completa o actualizada. El Titular declina expresamente cualquier responsabilidad por error u omisión en la información contenida en  las páginas de este sitio Web.</p>
    <p class="PALegal">Queda prohibido transmitir o enviar a través del sitio Web cualquier contenido ilegal o ilícito, virus informáticos, o mensajes que, en general, afecten o violen derechos de el Titular o de terceros.</p>
    <p class="PALegal">Los contenidos del Sitio Web tienen únicamente una finalidad informativa y bajo ninguna circunstancia deben usarse ni considerarse como oferta de venta, solicitud de una oferta de compra ni recomendación para realizar cualquier otra operación, salvo que así se indique expresamente.</p>
    <p class="PALegal">El Titular se reserva el derecho a modificar, suspender, cancelar o restringir el contenido del Sitio Web, los vínculos o la información obtenida a través del sitio Web, sin necesidad de previo aviso.</p>
    <p class="PALegal">El Titular no es responsable de los daños y perjuicios que pudieran derivarse de la utilización de la información del sitio Web o de la contenida en las redes sociales del Titular.</p>
    
    
    <h2>Identificación y Titularidad</h2>
 <p class="PALegal">En cumplimiento del artículo 10 de la Ley 34 / 2002, de 11 de julio, de Servicios de la Sociedad de la Información y Comercio Electrónico, el Titular expone sus datos identificativos.</p>
  <ul class="lista">
  <li><strong>Titular: </strong>
      <span class=azulGenerico><?php echo $DatosWeb->GetTrimValor('NombrePrincipal') ?></span>
   
      
   <?php  if(trim($registro_mercantil) != "") {?>   
         <li><strong>Registro mercantil: </strong>  
             <span class=azulGenerico> <?php echo $registro_mercantil; ?> </span>
   <?php } ?> 
      
   <?php  if(trim($tituloacademico) != "") {?>   
         <li><strong>Título Académico: </strong>  
             <span class=azulGenerico> <?php echo $tituloacademico; ?> </span>
   <?php } ?> 
  
    <?php  if(trim($colegioprofesional) != "") {?>   
         <li><strong>Colegio Profesional: </strong>  
             <span class=azulGenerico> <?php echo $colegioprofesional; ?> </span>
             
        <?php  if(trim($num_colegiado) != "") {?>   
         <li><strong>Número Colegiado: </strong>  
             <span class=azulGenerico> <?php echo $num_colegiado; ?> </span>
        <?php } ?>               
   <?php } ?>          
              

  <li><strong>NIF:</strong> 
      <span class=azulGenerico><?php echo $nif; ?></span>
  <li><strong>Domicilio:</strong> 
      <span class=azulGenerico> 
      <?php 
    
    $CodigoPostal = ($DatosWeb->GetTrimValor('carta_codpostal') <> "" ? "(".$DatosWeb->GetTrimValor('carta_codpostal').")" : "");
         $Direccion =  $DatosWeb->GetTrimValor('carta_direcc1')
                          ." ".$DatosWeb->GetTrimValor('carta_direcc2')
                          ." ".$CodigoPostal
                          ." ".$DatosWeb->GetTrimValor('carta_poblacion')
                          ." ".$DatosWeb->GetTrimValor('carta_pais');
          
        echo  $Direccion; 
      ?>
      </span>
      <span class="lipointerArial" onClick="VerLocalizacion()"> Ver en Maps</span>
  <li><strong>Correo electrónico:</strong> 
      <span class=azulGenerico>inscripciones@medifestructuras.com</span>
 
  <li><strong>Sitio Web: </strong> 
      <span class=azulGenerico><?php echo $DatosWeb->GetTrimValor('web_dominio') ?></span>
    </ul>
    







    <h2 id=poltica-de-cookies>Política de cookies</h2>
    <p class="PALegal">En la página Política de Cookies puede consultar toda la información relativa a la política de recogida y tratamiento de las cookies.</p>
    <p class="PALegal">El Titular sólo obtiene y conserva la siguiente información acerca de los visitantes del Sitio Web:</p>
    <ul class="lista" >
    <li>El nombre de dominio del proveedor 
    (PSI) y/o dirección IP que les da acceso a la red.
    <li>La fecha y hora de acceso al sitio Web.
    <li>La dirección de Internet origen del enlace que dirige al sitio Web.<li>El número de visitantes diarios de cada sección.
    <li>La información obtenida es totalmente anónima, y en ningún caso puede ser asociada a un Usuario concreto e identificado.
    </ul>
    
    
    <h2 id=enlaces-de-inters-a-otros-sitios-web>Enlaces de interés a otros sitios Web</h2>
    <p class="PALegal">El Titular puede proporcionarle acceso a sitios Web de terceros mediante enlaces con la finalidad de informar sobre la existencia de otras fuentes de información en Internet en las que podrá ampliar los datos ofrecidos en el sitio Web.<p class="PALegal">Estos enlaces a otros sitios Web no suponen en ningún caso una sugerencia o recomendación para que usted visite las páginas web de destino, que están fuera del control del Titular, por lo que Titular no es responsable del contenido de los sitios web vinculados ni del resultado que obtenga al seguir los enlaces.</p>
    <p class="PALegal">Asimismo, el Titular no responde de los links o enlaces ubicados en los sitios web vinculados a los que le proporciona acceso.
    <p class="PALegal">El establecimiento del enlace no implica en ningún caso la existencia de relaciones entre Titular y el propietario del sitio en el que se establezca el enlace, ni la aceptación o aprobación por parte del Titular de sus contenidos o servicios.</p>
    <p class="PALegal">Si accede a un sitio Web externo desde un enlace que encuentre en el Sitio Web usted deberá leer la propia política de privacidad del otro sitio web que puede ser diferente de la de este sitio Web.</p>
    
    
    <h2 id=enlaces-de-afiliados-y-anuncios-patrocinados-smallopcionalsmall>Enlaces de Afiliados y anuncios patrocinados </h2>
    <p class="PALegal">El sitio Web ofrece contenidos patrocinados, anuncios y/o enlaces de afiliados.</p>
    <p class="PALegal">La información que aparece en estos enlaces de afiliados o los anuncios insertados, son facilitados por los propios anunciantes, por lo que el Titular no se hace responsable de posibles inexactitudes o errores que pudieran contener los anuncios, ni garantiza en modo alguno la experiencia, integridad o responsabilidad de los anunciantes o la calidad de sus productos y/o servicios.</p>
    
      
    <h2 id=propiedad-intelectual-e-industrial>Propiedad intelectual e industrial</h2>
    <p class="PALegal">Todos los derechos están reservados.<p class="PALegal">Todo acceso a este sitio Web está sujeto a las siguientes condiciones: la reproducción, almacenaje  permanente y la difusión de los contenidos o cualquier otro uso que tenga finalidad pública o comercial queda expresamente prohibida sin el consentimiento previo expreso y por escrito de Titular.</p>
    
    
    <h2 id=limitacin-de-responsabilidad>Limitación de responsabilidad</h2>
    <p class="PALegal">La información y servicios incluidos o disponibles a través de este sitio Web pueden incluir incorrecciones o errores tipográficos. 
    De forma periódica el Titular incorpora mejoras y/o cambios a la información contenida y/o los Servicios que puede introducir en cualquier momento.</p>
    <p class="PALegal">El Titular no declara ni garantiza que los servicios o contenidos sean interrumpidos o que estén libres de errores, que los defectos sean corregidos, o que el servicio o el servidor que lo pone a disposición estén libres de virus u otros componentes nocivos sin perjuicio de que el  Titular realiza todos los esfuerzos en evitar este tipo de incidentes.</p>
    <p class="PALegal">Titular declina cualquier responsabilidad en caso de que existan interrupciones o un mal funcionamiento de los Servicios o contenidos ofrecidos en Internet, cualquiera que sea su causa. Asimismo, el Titular no se hace responsable por caídas de la red, pérdidas de negocio a consecuencia de dichas caídas, suspensiones temporales de fluido eléctrico o cualquier otro tipo de daño indirecto que te pueda ser causado por causas ajenas a el Titular.</p>
    <p class="PALegal">Antes de tomar decisiones y/o acciones con base a la información incluida en el sitio Web, el Titular le recomienda comprobar y contrastar la información recibida con otras fuentes.</p>
    
    
    <h2 id=derecho-de-exclusin-smallopcionalsmall>Derecho de exclusión </h2>
    <p class="PALegal">Titular se reserva el derecho a denegar o retirar el acceso al sitio Web y los servicios ofrecidos sin necesidad de preaviso, a instancia propia o de un tercero, a aquellos usuarios que incumplan cualquiera de las condiciones de este Aviso Legal.</p>
    
    
    <h2 id=jurisdiccin>Jurisdicción</h2>
    <p class="PALegal">Este Aviso Legal se rige íntegramente por la legislación <span class=azulGenerico><?php echo $tribunal_legislacion ?></span>.</p>
    <p class="PALegal">Siempre que no haya una norma que obligue a otra cosa, para cuantas cuestiones se susciten sobre la interpretación, aplicación y cumplimiento de este Aviso Legal, así como de las reclamaciones que puedan derivarse de su uso, las partes acuerdan someterse a los Jueces y Tribunales de la provincia de <span class=azulGenerico><?php echo $tribunal_provincia ?></span>, con renuncia expresa de cualquier otra jurisdicción que pudiera corresponderles.</p>
    
    
    <h2 id=contacto>Contacto</h2>
    <p class="PALegal">En caso de que usted tenga cualquier duda acerca de estas Condiciones legales o quiera realizar cualquier comentario sobre este sitio Web, puede enviar un mensaje de correo electrónico a la dirección <span class=azulGenerico>inscripciones@medifestructuras.com</span></p>
    
    
    <h2 id=condiciones-de-venta-smallopcionalsmall>Condiciones de Venta </h2>
    <p class="PALegal"><span class=azulGenerico>Cuando adquieres nuestros cursos te enviamos por e-mail un usuario y una contraseña que te permitirán acceder al contenido de los mismos</span>
    
      <p class="PALegal"><span class=azulGenerico>La compra la puedes realizar mediante pago con tarjeta, transferencia bancaria o envío mediante WesternUnion</span>
    
    
     <p class="PALegal"><span class=azulGenerico>El pago con tarjeta está automatizado desde la web, si vas a usar cualquier otra modalidad ponte antes en contacto con nosotros: e-mail, whatsapp </span>
    
         <p class="PALegal"><span class=azulGenerico>El pago con tarjeta se realiza a través de la pasarela segura de pagos 2checkout, aquí podrás optar por tarjeta o PayPal</span>
    
   
    <h2 id=cambio-de-pedido-smallopcionalsmall>Cambio y anulaciones de pedido</h2>
    <p class="PALegal"><span class=azulGenerico>Llámanos si tienes problemas de acceso a los cursos</span>
    
      <p class="PALegal"><span class=azulGenerico>Llámanos si te has equivocado en la compra</span>
    
    
     <p class="PALegal"><span class=azulGenerico>Si deseas el reembolso, rellena el formulario de la página</span>
          <span class="lipointerArial" onClick="location.href='Contacto.php#reembolso'"> Contacto</span>
    
         
    

    
    
    
    
    
    
    </article>
    </div>  <!-- content-wrap -->
    
    
<div class="centro90"><?php include_once('PaginaPieNOIndex.php'); ?></div>
 
    
<?php include_once('PaginaCursoPHP01_4.php'); ?>





</body>
</html>