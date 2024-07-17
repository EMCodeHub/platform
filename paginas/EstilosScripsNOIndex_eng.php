
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">

<link rel="stylesheet" type="text/css" href="../css/EstiloBase.css">

<link rel="stylesheet" media="(min-width:1184px) and (max-width:1300px) and (orientation: landscape)" href="../css/Estilo_1300_L.css">
<link rel="stylesheet" media="(min-width:1184px) and (max-width:1300px) and (orientation: portrait)" href="../css/Estilo_1300_P.css">
<link rel="stylesheet" media="(min-width:859px) and (max-width:1184px) and (orientation: landscape)" href="../css/Estilo_1184_L.css">
<link rel="stylesheet" media="(min-width:859px) and (max-width:1184px) and (orientation: portrait)" href="../css/Estilo_1184_P.css">
<link rel="stylesheet" media="(min-width:781px) and (max-width:859px) and (orientation: landscape)" href="../css/Estilo_859_L.css">
<link rel="stylesheet" media="(min-width:781px) and (max-width:859px) and (orientation: portrait)" href="../css/Estilo_859_P.css">
<link rel="stylesheet" media="(min-width:668px) and (max-width:781px) and (orientation: landscape)" href="../css/Estilo_781_L.css">
<link rel="stylesheet" media="(min-width:668px) and (max-width:781px) and (orientation: portrait)" href="../css/Estilo_781_P.css">
<link rel="stylesheet" media="(min-width:598px) and (max-width:668px) and (orientation: landscape)" href="../css/Estilo_668_L.css">
<link rel="stylesheet" media="(min-width:598px) and (max-width:668px) and (orientation: portrait)" href="../css/Estilo_668_P.css">
<link rel="stylesheet" media="(min-width:419px) and (max-width:598px) and (orientation: landscape)" href="../css/Estilo_598_L.css">
<link rel="stylesheet" media="(min-width:419px) and (max-width:598px) and (orientation: portrait)" href="../css/Estilo_598_P.css">
<link rel="stylesheet" media="(max-width:419px) and (orientation: landscape)" href="../css/Estilo_419_L.css">
<link rel="stylesheet" media="(max-width:419px) and (orientation: portrait)" href="../css/Estilo_419_P.css">




<SCRIPT LANGUAGE="JavaScript"> 
 function CambiaFoto(numero,sufijo) {
	 TitulosItems = new Array("***","Company","CYPE classroom","Projects","","","","Contact");
	 var foto = "";
	 var nombreElementoImagen = "image_"+numero;
	 var nombreElementoSpan = "menu_"+numero;
	 
	 if (sufijo == "G"){
		 foto = "../imagenes/MenuGris_"+numero+".png";
		 document.getElementById(nombreElementoSpan).style.color = "#666";
		 
	 } else {
		 foto = "../imagenes/MenuVerde_"+numero+".png";
		 document.getElementById(nombreElementoSpan).style.color = "#090";
	 }
	 document.getElementById(nombreElementoSpan).innerHTML = TitulosItems[numero];
	 document.getElementById(nombreElementoImagen).src = foto;
	 
	 
	 
 }
</script>
