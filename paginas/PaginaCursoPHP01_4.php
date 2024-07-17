<?php if($_SESSION['cookieGrabada'] == 0) { ?>
         <div id="AclaracionCookie">
          <p class="centro"><b>Política de Privacidad</b></p>
       
         <p class="centro">Las cookies que utiliza este sitio web  NO CONTIENEN información personal</p>
         
         <p class="centro">Utilizamos la cookie ga de Google Analytics para obtener información estadística del tráfico en nuestra web</p>
        
         <p class="centro">En este aula virtual compartimos conocimientos, experiencias, soluciones, sin revelar datos ni detalles personales</p>
         
         <p class="centro">No compartimos datos con terceros.</p>
         
         
         <br />
         
             <br /> 
             <div class="AceptarCookie" onclick="PreGrabaCookie()"> ACEPTAR </div>   
             <div class="AceptarCookie" onClick="location.href='index.php'"> RECHAZAR </div>  
             
         </div>
         <div id="cookies"> 
            <div id="cookies_Iz">        
               Utilizamos cookies propias y de Google Analytics para generar estadísticas de audiencia y mejorar tu navegación.<br />Si sigues navegando estarás aceptando su uso. 
               <a href="javascript:VerMasInformacion()">Más información</a>
            </div>     
            <div id="botonAceptarCookie" onclick="GrabaCookie()"> ACEPTAR </div>   
         </div>
 <?php }?>
