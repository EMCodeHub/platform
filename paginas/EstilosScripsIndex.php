<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">


<link rel="stylesheet" type="text/css" href="css/EstiloBase.css">
<link rel="stylesheet" media="(min-width:1184px) and (max-width:1300px) and (orientation: landscape)" href="css/Estilo_1300_L.css">
<link rel="stylesheet" media="(min-width:1184px) and (max-width:1300px) and (orientation: portrait)" href="css/Estilo_1300_P.css">
<link rel="stylesheet" media="(min-width:859px) and (max-width:1184px) and (orientation: landscape)" href="css/Estilo_1184_L.css">
<link rel="stylesheet" media="(min-width:859px) and (max-width:1184px) and (orientation: portrait)" href="css/Estilo_1184_P.css">
<link rel="stylesheet" media="(min-width:781px) and (max-width:859px) and (orientation: landscape)" href="css/Estilo_859_L.css">
<link rel="stylesheet" media="(min-width:781px) and (max-width:859px) and (orientation: portrait)" href="css/Estilo_859_P.css">
<link rel="stylesheet" media="(min-width:668px) and (max-width:781px) and (orientation: landscape)" href="css/Estilo_781_L.css">
<link rel="stylesheet" media="(min-width:668px) and (max-width:781px) and (orientation: portrait)" href="css/Estilo_781_P.css">
<link rel="stylesheet" media="(min-width:598px) and (max-width:668px) and (orientation: landscape)" href="css/Estilo_668_L.css">
<link rel="stylesheet" media="(min-width:598px) and (max-width:668px) and (orientation: portrait)" href="css/Estilo_668_P.css">
<link rel="stylesheet" media="(min-width:419px) and (max-width:598px) and (orientation: landscape)" href="css/Estilo_598_L.css">
<link rel="stylesheet" media="(min-width:419px) and (max-width:598px) and (orientation: portrait)" href="css/Estilo_598_P.css">
<link rel="stylesheet" media="(max-width:419px) and (orientation: landscape)" href="css/Estilo_419_L.css">
<link rel="stylesheet" media="(max-width:419px) and (orientation: portrait)" href="css/Estilo_419_P.css">




<script> 
	function trim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}


 function VerLayerConexion(modo) {
  
  if (modo == 1) {
			  
			   document.getElementById('envoltorioPWD').style.display = "block";
			   document.getElementById('Conectarse').style.display = "block";
			   
			   document.getElementById('CambioPwd').style.display = "none";
			   
		   } else {
			 /*  document.getElementById('envoltorioPWD').style.visibility = "hidden";*/
			   document.getElementById('envoltorioPWD').style.display = "none";
			   document.getElementById("OPERACION").value = "";
		   }

 }
 function Autentificar() {
		   document.getElementById("OPERACION").value = "AUTENTIFICAR";
		   document.DATOS1.submit();
 }

function VerCambioPwd() {
  
  document.getElementById('Conectarse').style.display = "none";
  document.getElementById('CambioPwd').style.display = "block";
}

	   
	   
	   
function CambioPwd() {
  
  if (document.getElementById("pwdNew").value == document.getElementById("pwd").value) {
  alert("No ha cambiado la contraseña");
   
   document.getElementById('CambioPwd').style.display = "none";
  return; 
  }  
 
  password = trim(document.getElementById("pwdNew").value);
  
  if (trim(document.getElementById("pwdNew").value).length < 6) {
  alert("NO PROCESADO: Debe tener más caracteres");
  
  document.getElementById('envoltorioPWD').style.display = "none";
  return; 
  }
  
  if (document.getElementById("pwdNew").value != document.getElementById("pwdConfirm").value) {
  alert("Las contraseñas  NO son iguales");
  return; 
  }
  
  document.getElementById("pwd").value = document.getElementById("pwdNew").value;
  document.getElementById("OPERACION").value = "CAMBIOPWD";
  document.DATOS1.submit();
}
	   
</script>
 