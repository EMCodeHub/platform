<?php
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
$_SESSION['pruebas'] = 0;
if ($_SESSION['es_admin'] != 1 && $_SESSION['es_colaborador'] != 1) {
     header("Location: ../index.php");
     exit;
}
?>
<!doctype html>
<html lang="es">


<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Mantenimiento <?php echo $DatosWeb->GetTrimValor('web_dominio') ?></title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />
   
<SCRIPT LANGUAGE="JavaScript">
  function ventanaSecundaria (URL){ 
   window.open(URL,"ventana0","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=200,TOP=100") 
  
 } 
</SCRIPT>
</head>

<body>
<div class="ContenedorImagen">
    <img id="ImaIndex" src="../imagenes/Mant_Portada.jpg">
</div>
    <h1 align="center">Mantenimiento de la Web <?php echo $DatosWeb->GetTrimValor('web_dominio') ?></h1>
    <div class="ContenedorTotalMantenimiento">
        <input name="Salir" 
 	                 type="button" class ="ButtonGrisM" value ="Salir" onclick="location.href = '../index.php'"/> 
    </div>
<div class="ContenedorTotalMantenimiento"> 
    
  <!-------------------  ------------------------- -->     
     <div class="ContenedorIzdaMantenimiento" style="background-image: url('../imagenes/Mant_Alumnos.jpg'); ">
  </div>   <!--ContenedorIzdaMantenimiento-->
    
    
  <div class="ContenedorDchaMantenimiento">
    <h2>Alumnos</h2>
      <ul>
          <li><a href="VTBusquedaAlumnoListaz.php">Buscar por E-mail</a></li>
          <li><a href="VTAlumnosListaz.php">Relación de Alumnos</a></li>
          <li><a href="VTPermisosLista.php">Permisos de acceso</a></li>  
          <li><a href="VTTipoAlumnoLista.php">Tipos de Alumnos y visitantes</a></li> 
      </ul>
      
  </div>   <!--ContenedorDchaMantenimiento-->
  <div class="clear"></div>  
  <!-------------------  ------------------------- -->  



  <!--
  <div class="ContenedorIzdaMantenimiento" style="background-image: url('../imagenes/logocypeventas.png'); ">
  </div>-->   <!--ContenedorIzdaMantenimiento-->
    
    

  
  <div class="ContenedorDchaMantenimiento">
    
  
  <!--
  
  <h2>Reserva de llamada CYPE</h2>
      <ul>
          
          <li><a href="AsesoriasListacypee.php">Base de datos llamada CYPE para Estudiantes</a></li>
          <li><a href="AsesoriasListacype.php">Base de datos llamada CYPE Profesionales (No-Estudiantes)</a></li>
          <li><a href="https://medifestructuras.com/paginas/cype-software.php">Landing Page Oculta de web para Estudiantes </a></li>
          <li><a href="https://medifestructuras.com/paginas/cypesoftware.php">Landing Page Oculta de web para Profesionales (No-Estudiantes)</a></li>
        
      </ul>
      

-->

  </div>   <!--ContenedorDchaMantenimiento-->
  <div class="clear"></div>  












<!-------------------  ------------------------- -->     
     <div class="ContenedorIzdaMantenimiento" style="background-image: url('../imagenes/Mant_Facturas.jpg'); ">
  </div>   <!--ContenedorIzdaMantenimiento-->
    
    
  <div class="ContenedorDchaMantenimiento">
    <h2>Facturas Manuales, Gastos e Iva</h2>
      <ul>
		  <li><a href="BuscaMailEnCkeckout.php">Buscar E-Mail en Respuestas 2checkout</a></li>
          <li><a href="VTPaisesIsoLista.php">Paises códigos ISO</a></li>
          <li><a href="VTPaisesIvaLista.php">Paises Iva a aplicar</a></li>  
		  <li><a href="VTFacturasManualesLista.php">Facturas cobros manuales</a></li> 
		   <li><a href="VTFacturasPagosGastosLista.php">Facturas pagadas, gastos</a></li>
      </ul>
      
  </div>   <!--ContenedorDchaMantenimiento-->
  <div class="clear"></div>  
  <!-------------------  ------------------------- -->  
	
	
	
	
	
  <div class="ContenedorIzdaMantenimiento" style="background-image: url('../imagenes/Mant_Estadistica.jpg'); ">
  </div>   <!--ContenedorIzdaMantenimiento-->
    
    
  <div class="ContenedorDchaMantenimiento">
    <h2> Listados / Estadísticas</h2>
      <ul>
          <li><a href="EstadisticaAltaPermisos.php">Alta de Permisos entre fechas</a></li>
		  <li><a href="FacturacionEntreFechas.php">Facturación entre fechas</a></li>
          <li><a href="EstadisticaCursosEvolucion.php">Alta de Cursos por años (Proceso de + de 1 minuto / Exportación de CSV)</a></li>
          <li><a href="EstadisticaAccesos.php">Accesos de Leads y sesiones gratis por países</a></li>
          <li><a href="../php/AccesoRecursos.php">Generar fichero de accesos a vídeos y recursos (Exportación de CSV)</a></li>  
      </ul> 
  </div>   <!--ContenedorDchaMantenimiento-->
  <div class="clear"></div>  
  <!-------------------  ------------------------- -->   
  <div class="ContenedorIzdaMantenimiento" style="background-image: url('../imagenes/Mant_Emails.jpg'); "></div>   <!--ContenedorIzdaMantenimiento-->
  <div class="ContenedorDchaMantenimiento">
    <h2> Emails / Cartas</h2>
      <ul>
         <li><a href="VTSolicitudesLista.php">Recepción Solicitudes Videotutoriales</a></li> 
         <li><a href="AlumnosInscritosLista.php">Recepción Solicitudes Cursos Presenciales, Presupuestos</a></li>
         <li><a href="CartasPromocionalesSeleccionar.php">Envío de Cartas Promocionales (Notificaciones al alumnado)</a></li>  
         <li><a href="CobrosOtrosSolicitudLista.php">Envío de Email Solicitando un Cobro (Asesorías, Ofertas, Cobros varios)</a></li> 
         <li><a href="formulariolista.php">Recepción de solicitudes de alumnos FEEDBACK Formulario</a></li> 
      </ul> 
  </div>   <!--ContenedorDchaMantenimiento-->
  <div class="clear"></div>  
  <!-------------------  ------------------------- -->    


  <!---<div class="ContenedorIzdaMantenimiento" style="background-image: url('../imagenes/Mant_Alumnos.jpg'); ">  
  </div>  
  
   -->  
  
  
  <!--ContenedorIzdaMantenimiento-->
    
    
  <div class="ContenedorDchaMantenimiento">
    
  
  <!--
  <h2>Ingenieros Digitales</h2>
      <ul>
          <li><a href="AsesoriasListacypeee.php">Base de datos</a></li>
          <li><a href="https://medifestructuras.com/paginas/ingenieros&arquitectos-digitales.php">Landing</a></li>
         
      </ul>
      -->

  </div>   <!--ContenedorDchaMantenimiento-->
  <div class="clear"></div>  





















   <div class="ContenedorIzdaMantenimiento" style="background-image: url('../imagenes/Mant_AgendaAsesoria.jpg'); ">
  </div>   <!--ContenedorIzdaMantenimiento-->
    
    
  <div class="ContenedorDchaMantenimiento">
    <h2>Asesorías</h2>
      <ul>
          <li><a href="AsesoriasLista.php">Agenda de Sesiones</a></li> 
      </ul>
      
  </div>   <!--ContenedorDchaMantenimiento-->
  <div class="clear"></div>  
  <!Foro---------------  ------------------------- -->      
  <div class="ContenedorIzdaMantenimiento" style="background-image: url('../imagenes/Mant_Foros.jpg'); ">
  </div>   <!--ContenedorIzdaMantenimiento-->
    
    
  <div class="ContenedorDchaMantenimiento">
    <h2>Foros</h2>
      <ul>
          <li><a href="ForosClasesLista.php">Clases</a></li>
          <li><a href="ForosTemasLista.php">Temas</a></li>  
          <li><a href="ForosCuestionesLista.php">Cuestiones</a></li> 
          <ul>
              <li><a href="ForosMensajesLista.php">Mensajes</a></li>
               <ul>
                   <li><a href="ForosRecursosLista.php">Recursos</a></li>
              </ul>
          </ul>
          
      </ul>
      
  </div>   <!--ContenedorDchaMantenimiento-->
  <div class="clear"></div>  
  <!-------------------  ------------------------- -->  
  <div class="ContenedorIzdaMantenimiento" style="background-image: url('../imagenes/Mant_Videotutorial.jpg'); ">
  </div>   <!--ContenedorIzdaMantenimiento-->  
  <div class="ContenedorDchaMantenimiento">
    <h2>Videotutoriales</h2>
      <ul>
          <li><a href="VTCategoriasLista.php">Categorías</a></li>
          <li><a href="VTCursosLista.php">Cursos</a></li> 
          <ul>
              <li><a href="VTModulosLista.php">Módulos</a></li>
              <li><a href="VTBloquesLista.php">Bloques</a></li>
              <ul>
                  <li><a href="VTTemasLista.php">Temas</a></li>
                  <li><a href="VTRecursosLista.php">Recursos</a></li>
                  <li><a href="VTVideosLista.php">Vídeos</a></li>
          </ul>  
          </ul>  
      </ul>  
  </div>   <!--ContenedorDchaMantenimiento-->
  <div class="clear"></div>  
    
 <!-------------------  ------------------------- -->  
  <div class="ContenedorIzdaMantenimiento" style="background-image: url('../imagenes/Mant_Webinar.jpg'); ">
  </div>   <!--ContenedorIzdaMantenimiento-->  
  <div class="ContenedorDchaMantenimiento">
    <h2>Cursos Presenciales / Webinars</h2>
      <ul>
          <li><a href="CursosLista.php">Cursos</a></li> 
          <ul>
              <li><a href="OrganizadorLista.php">Organizadores (Ubicaciones Aulas)</a></li>
              <li><a href="ModalidadLista.php">Modalidades (Presencial, Videoconferencia)</a></li>
              <li><a href="TipoCursoLista.php">Tipos (Seminario, Jornada)</a></li>
              <li><a href="PeriodicidadCursoLista.php">Periodicidades (Única, Diaria, Semanal)</a></li> 
          </ul>  
      </ul>  
  </div>   <!--ContenedorDchaMantenimiento-->
  <div class="clear"></div>  

<!-------------------  ------------------------- -->     
  <div class="ContenedorIzdaMantenimiento" style="background-image: url('../imagenes/Mant_ConfiguracionWeb.jpg'); ">
  </div>   <!--ContenedorIzdaMantenimiento-->
    
    
  <div class="ContenedorDchaMantenimiento">
    <h2> Configuración Web</h2>
      <ul>
          <li><a href="VTOpcionesMenuLista.php">Opciones del menú</a></li>
          <li><a href="VTParametrosGenerales.php">Parámetros Generales</a></li>  
          <li><a href="VTParametrosFicha.php">Parámetros de Cobro (Precio Asesoría, conexión 2Checkout)</a></li>  
          <ul>
              <li><a href="VTPrecioLoteLista.php">Precios compra más de 1 curso</a></li>
          </ul>
          <li><a href="EmailsLista.php">Emails de envío y recepción</a></li>   
         <li><a href="VisorDeCartas.php">Modelos de Cartas Comerciales (Enviadas por los procesos de la aplicación)</a></li> 
      </ul>
      
  </div>   <!--ContenedorDchaMantenimiento-->
  <div class="clear"></div> 
    
<!-------------------  ------------------------- -->     
  <div class="ContenedorIzdaMantenimiento" style="background-image: url('../imagenes/Mant_ManualProcesos.jpg'); ">
  </div>   <!--ContenedorIzdaMantenimiento-->
    
    
  <div class="ContenedorDchaMantenimiento">
    <h2> Ayuda</h2>
      <ul>
          <li><a href="AyudaProcedimientos.php">Jerarquía de procesos</a></li>
      </ul>
      
  </div>   <!--ContenedorDchaMantenimiento-->
  <div class="clear"></div> 
   
    
</div>   <!--ContenedorTotalMantenimiento-->
    
 <div class="ContenedorTotalMantenimiento">
        <input name="Salir" 
 	                 type="button" class ="ButtonGrisM" value ="Salir" onclick="location.href = '../index.php'"/> 
 </div>
    </br> </br> </br> </br> </br>
</body>
</html>