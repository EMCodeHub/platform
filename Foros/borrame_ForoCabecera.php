    
<!-- PARA CUALQUIER NAVEGADOR -->
<?php if(DatoLleno($DatosWeb->GetValor('favicon_32'))) { 
      $pag = $DatosWeb->GetValor('web_url')."/imagenes/logos/".$DatosWeb->GetValor('favicon_32');
      echo '<link rel="icon" href="'.$pag.'" sizes="32x32" type="image/gif">';
}  ?>    
    
<!-- PARA LOS MODELOS MAS RECIENTES DE IPAD Y IPHONE -->
<?php if(DatoLleno($DatosWeb->GetValor('favicon_152'))) { 
      $pag = $DatosWeb->GetValor('web_url')."/imagenes/logos/".$DatosWeb->GetValor('favicon_152');
      echo '<link rel="apple-touch-icon-precomposed" href="'.$pag.'" sizes="152x152" type="image/gif">';
}  ?>    
<?php if(DatoLleno($DatosWeb->GetValor('favicon_120'))) { 
      $pag = $DatosWeb->GetValor('web_url')."/imagenes/logos/".$DatosWeb->GetValor('favicon_120');
      echo '<link rel="apple-touch-icon-precomposed" href="'.$pag.'" sizes="120x120" type="image/gif">';
}  ?>    
    
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>');</script>
<!-- End Google Tag Manager -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo $DatosWeb->GetTrimValor('codigo_analytics') ?>', 'auto');
  ga('send', 'pageview');
</script>
