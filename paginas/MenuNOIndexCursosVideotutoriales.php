<?php
if ($_SESSION['es_admin'] == 1 || $_SESSION['es_colaborador'] == 1 ){
	include_once('paginas/menuGestion.php');
}
?>

<header>
<div class="menu_bar" onClick="VerNav()">
<svg width="4%" height="100%" viewBox="0 0 74 74" >
 <line x1="20" y1="22" x2="53" y2="22" style="stroke-width:9px; stroke:rgba(247,243,247,1.00); stroke-linecap:round"/>
 <line x1="20" y1="52" x2="53" y2="52" style="stroke-width:9px; stroke:rgba(247,243,247,1.00); stroke-linecap:round"/>
 <line x1="20" y1="37" x2="53" y2="37" style="stroke-width:9px; stroke:rgba(247,243,247,1.00); stroke-linecap:round"/>
 </svg>
</div>
<div class="PocoEspacio10"></div> <div class="clear"></div>
<nav id="navegador">

    <?php echo $DatosWeb->EscribeMenu("paginas") //La carpeta en la que estamos es paginas  ?>

</nav>
<div class="PocoEspacio"></div> <div class="clear"></div>  
</header>
<script>
  function VerNav(){
    a=document.getElementById("navegador").style.display;
      if (a=="none") {
          document.getElementById("navegador").style.display="block";
      } else {
           document.getElementById("navegador").style.display="none";
      }
      
  }
</script>



