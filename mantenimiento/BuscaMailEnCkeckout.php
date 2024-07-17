<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VIDEOTUTORIALES: Buscar E-Mailen tabla vt2checkout</title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />
<!-Hoja de estilos del calendario --> 

<meta charset="utf-8">
<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
<?php
	session_start();
	include('../conexion/conn_bbdd.php');
	if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
    }
	
?>
	 <SCRIPT> 		  
	function buscaMail() {
	       e_mail =  document.getElementById('Email').value;
		   document.getElementById("Buscar").style.display = "none";
		
		
		//alert("Enviamos email-->"+e_mail);
		    
		$("#Resultado2").html("");  
         
		var parametros = {
			  "email"     : e_mail
              };  
		$.ajax({
             data:  parametros,
             url:   '../php/GenerarFicheroBusquedaCkeckout.php',
             type:  'post',
             beforeSend: function () {
                 $("#Resultado2").html("<span class='azul'>Generando Fichero ....</span>"); 
             },
             success:  function (response) {
                 $("#Resultado2").html(response); 
				 $('#Buscar').css("display","inline");
             },
			 error: function(jqXHR, textStatus, errorThrown){
                $("#Resultado2").html("<span class='rojo'>Error: </span>"+ " " + errorThrown+" "+textStatus+" "+jqXHR);
				$('#Buscar').css("display","inline");
				return false;
            }
        });	      
     } 
	 </SCRIPT>	 
		 
</head>

<body>
	
<form id = "datos" name= "datos"  method="post">

<div class="TituloLista">VIDEOTUTORIALES: Buscar un e-mail en tabla vtckeckout </div>
	<br>
<div class = "TituloTablaFacturaM"> &nbsp; &nbsp;
	<input name="Anterior" type="button" value ="Volver" onClick = "location.href='mantenimiento.php'" /> &nbsp; &nbsp; &nbsp; &nbsp;
&nbsp; &nbsp; &nbsp; &nbsp; E-mail &nbsp; &nbsp;
	<input id = "Email" name="Email" size="60"  maxlength="60"    value="<?php $_REQUEST['FechaFiltro'] ?>" />
	<input id="Buscar" name="Buscar" type="Button" value ="Buscar" onClick = "buscaMail()" /> &nbsp; &nbsp; &nbsp; &nbsp;

	</div></div>
</form>
<br><br>
<div id="Resultado2"></div>	
<br>
<div class="clear"></div>
	<div class = "TituloTablaFacturaM">&nbsp; &nbsp;</did>
</body>
</html>
	