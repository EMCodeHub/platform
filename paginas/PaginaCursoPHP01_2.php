<script>
inicio_pagina = new Date();
inicio_pagina = inicio_pagina.getTime();

$(window).on('beforeunload', function() {
	
     fin = new Date();
     fin = fin.getTime();
     tiempoTotal = parseInt((fin-inicio_pagina)/1000);

		     var parametros = {
              "segundos"      : tiempoTotal
              };  
		$.ajax({
             data:  parametros,
             url:   '../php/ConexionAnotaTiempoDePagina.php',
             type:  'post',
			 async: false,
             beforeSend: function () {
                    a=1; 
             },
             success:  function (response) {
				    a=2;
             },
			 error: function(){
                    a=3;
            }
        });	
});

  <?php 
  if($_SESSION['cookieGrabada'] == 0) {  
          echo " pararGrabacionCook = 0;\n\r";
		  echo " setTimeout(function(){ ActivaPCookie(); }, 5000);\n\r";
        } else {
		  echo " pararGrabacionCook = 1;\n\r";
  }
 
  if($_SESSION['RegrabarCookies'] == 1) {  
          echo " PreGrabaCookie();\n\r";
		  $_SESSION['RegrabarCookies'] = 0;
  }     
 ?>
 
 
 
function  PreGrabaCookie() {
	pararGrabacionCook = 0;
	GrabaCookie();
 }
function GrabaCookie() {
   if (pararGrabacionCook == 1) {
		return;
   } 
   pararGrabacionCook = 1;
   
   
   
   
   document.cookie = "Tipo=" + <?php echo "'".$COTipo."'" ?>; expires=<?php echo $COcaducidad ?>;
   document.cookie = "Referencia=" + <?php echo $COnumeroReferencia; ?>; expires=<?php echo $COcaducidad ?>;
 
 
   <?php if($_SESSION['cookieGrabada'] == 0) { ?>
      document.getElementById("cookies").style.display="none";
      document.getElementById("AclaracionCookie").style.display="none";
   	<?php } ?> 
}


function leerCookie(nombre) {
	     var micookie = "";
         var lista = document.cookie.split(";");
         for (i in lista) {
             var busca = lista[i].search(nombre);
             if (busca > -1) {micookie=lista[i]}
             }
         var igual = micookie.indexOf("=");
         var valor = micookie.substring(igual+1);
         return valor;
}
		 
function ActivaPCookie() {	
    var Tipo = leerCookie("Tipo");
	if (Tipo.length > 0) {
		return;
	}
	
	
	 <?php if($_SESSION['cookieGrabada'] == 0) { ?>
	    document.getElementById("cookies").style.display="block";
	 <?php } ?> 
	 
	 
	pararGrabacionCook = 0;
	setTimeout(function(){ GrabaCookie(); }, 25000);
}

function VerMasInformacion() {
   pararGrabacionCook = 1;
   document.getElementById("cookies").style.display="none";	
   document.getElementById("AclaracionCookie").style.display="block";	
}

</script>