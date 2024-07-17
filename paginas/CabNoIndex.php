<div id="logoPrincipal"><img src="../imagenes/logos/LogoMedif.jpg"  alt="Logo Medif"></div>
<?php

if ($_SESSION['es_admin'] == 1 ){
	include_once('menuGestionNoIndex.php');
}
?> 
<header id="header">
 
 <nav id="mobile">
 
 <input type="radio" id="hide-menu" name="gestion_nav">
 <input type="radio" id="show-menu" name="gestion_nav">
 <label for="show-menu" class="label" id="saca_menu">
 <svg width="100%" height="100%" viewBox="0 0 74 74" >
 <line x1="20" y1="22" x2="53" y2="22" style="stroke-width:9px; stroke:rgb(255,255,255); stroke-linecap:round"/>
 <line x1="20" y1="52" x2="53" y2="52" style="stroke-width:9px; stroke:rgb(255,255,255); stroke-linecap:round"/>
 <line x1="20" y1="37" x2="53" y2="37" style="stroke-width:9px; stroke:rgb(255,255,255); stroke-linecap:round"/>
 </svg>
 </label>
 
 <label for="hide-menu" class="label" id="oculta_menu">
 <svg width="100%" height="100%" viewBox="0 0 74 74" >
 <rect x="5" y="5" width="64" height="64" rx="10" ry="10" style="stroke-width:9px; fill:none; stroke:rgb(255,255,255)"/>
 <line x1="24" y1="22" x2="49" y2="22" style="stroke-width:9px; stroke:rgb(255,255,255); stroke-linecap:round"/>
 <line x1="24" y1="52" x2="49" y2="52" style="stroke-width:9px; stroke:rgb(255,255,255); stroke-linecap:round"/>
 <line x1="20" y1="37" x2="53" y2="37" style="stroke-width:9px; stroke:rgb(255,255,255); stroke-linecap:round"/>
 </svg>
 </label>
       <div id = "menu">
       <ul class = "listaMenuMobile" >
       <li>
       <a href="../index.php" class="presentacion" id = "presentacion"><span class="etiquetaMenuMobile">Empresa</span></a>
       </li>
       <li>
       <a href="CYPEVideotutoriales.php" class="cype" id = "cype"><span class="etiquetaMenuMobile">Aula Cype</span></a>
       </li>
       
       <li>
       <a href="PlanosEjecucion.php" class="edificiohierro"><span class="etiquetaMenuMobile">Proyectos</span></a>
       </li>
       
       <li>
       <a href="contacto.php" class="contacto"><span class="etiquetaMenuMobile">Contacto</span></a>
       </li>

        </ul>
        </div>

<div class="clear"></div>

 </nav>
 CYPE Ecuador - Medif
 </header>
<div id= cabeceras class="cabeceras">
<img src="<?php echo $_SESSION['FotoCabecera']; ?>" > </div> <!--Cabecera .................................................................................-->
<div class="separador"></div>

<nav  id = navegador class = "navegador" >  <!--Navegador .................................................................................-->
<ul class = "listaMenu" >
       <li>
       <a href="../index.php" class="item_menu" ><img src="..//imagenes/MenuGris_1.png" alt="Icono presentación" onMouseOut="CambiaFoto(1,'G')" onMouseOver="CambiaFoto(1,'V')"            id="image_1"><span id="menu_1">Empresa</span></a>
       </li>
       <li>
       <a href="CYPEVideotutoriales.php" class="item_menu" ><img src="../imagenes/MenuGris_2.png" alt="Icono Cype" onMouseOut="CambiaFoto(2,'G')" onMouseOver="CambiaFoto(2,'V')"            id="image_2"><span id="menu_2">Aula Cype</span></a>
       </li>
       
       <li>
       <a href="PlanosEjecucion.php" class="item_menu"><img src="../imagenes/MenuGris_3.png" alt="Icono Planos ejecución" onMouseOut="CambiaFoto(3,'G')" onMouseOver="CambiaFoto(3,'V')"            id="image_3"><span id="menu_3">Proyectos</span></a>
       </li>
       
       <li>
       <a href="contacto.php" class="item_menu"><img src="../imagenes/MenuGris_7.png" alt="Icono Naves" onMouseOut="CambiaFoto(7,'G')" onMouseOver="CambiaFoto(7,'V')"            id="image_7"><span id="menu_7">Contacto</span></a>
       </li>

</ul>
</nav>
<div class = "clear_boot" > </div>
