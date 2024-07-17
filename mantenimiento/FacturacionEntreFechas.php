<?php
session_start();

if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
if (!isset($_REQUEST['volver_a'])) {
	$_REQUEST['volver_a'] = "mantenimiento.php";
}
//......................................................
if (!isset($_REQUEST['Fecha_Ini'])) {
	$_REQUEST['Fecha_Ini'] = date("Y-m-d",strtotime(date("Y-m-d")." - 1 month")); 
}
if (!isset($_REQUEST['Fecha_Fin'])) {
	$_REQUEST['Fecha_Fin'] = date("Y-m-d");
}

include_once('../conexion/conn_bbdd.php');
include_once('../php/PaisesIvaClass.php'); //Clase Paises iva


//...........................................................................
$FormatCobros = "SELECT 'CURSO' AS tipo, email_cliente, DATE(fecha_emision) AS fecha, importe, 0 as gastos, numero_orden, numero_factura, codigo_pais,ciudad
	                     FROM vtcobros
	                    WHERE pruebas_real != 'PRUEBA'
						  AND fecha_emision >= '%s'
						  AND fecha_emision <= '%s'
					
	                    UNION
	                   SELECT 'LINK-PAGO' AS tipo, email_cliente, DATE(fecha_emision) AS fecha, importe,0 as gastos, numero_orden, numero_factura, codigo_pais,ciudad
	                     FROM vtcobrosotros
	                    WHERE fecha_emision >= '%s'
						  AND fecha_emision <= '%s'
				
						UNION
						 SELECT origen_entidad AS tipo, email_cliente, DATE(fecha_emision) AS fecha, importe_original as importe, importe_original-importe_cobrado as gastos, numero_orden, numero_factura, codigo_pais,ciudad
	                     FROM vtcobrosmanual
	                    WHERE fecha_emision >= '%s'
						  AND fecha_emision <= '%s'
				     ";
	
//...........................................................................
//...........................................................................
$FormatRecibidas = "SELECT id, 
                          proveedor, 
                          numero_factura, 
                          fecha_factura, 
                          importe, 
                          iva, 
                          codigo_pais, 
                          medio_pago 
                          FROM vtpagosgastos
						  WHERE fecha_factura >= '%s'
						  AND fecha_factura <= '%s'
";


//...............................................................................
?>
<!doctype html>
<html lang="es">
	<head>
	<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
      <SCRIPT LANGUAGE="JavaScript">
      
      //.........................
	   function VerActividad(NumAlumno) {
		   URL = "ActividadAlumno.php?NumeroAlumno="+NumAlumno;
	       window.open(URL,"Registro actividad alumno","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=200,TOP=100") 	

	   }

       function VerActividadNoAlumno(Email) {
		   URL = "ActividadNoAlumno.php?Email="+Email;
	       window.open(URL,"Registro actividad cliente","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=200,TOP=100") 	

	   }


      
	   function Procesar(campo) {
		   ini =  document.getElementById('Fecha_Ini').value;
		   fin =  document.getElementById('Fecha_Fin').value; 
		   if (fin < ini) {
			alert("Fecha FIN menor que INICIO ---->Vuelva a entrar las fechas");
			return;   
		   }
			 
		   document.datos.action="FacturacionEntreFechas.php";
		   document.datos.submit();
	   }
	   function EnsenyaRecalculo() {
		   document.getElementById('Recalculo').style.display = "inline"; 
           document.getElementById('resultado').style.display = "none"; 
		   document.getElementById('resultado2').style.display = "none"; 
		   document.getElementById('GenerarCSV').style.display = "none";
		   
           
	   }
		  
	function CreaFicheroCSV() {
		
	       ini =  document.getElementById('Fecha_Ini').value;
		   fin =  document.getElementById('Fecha_Fin').value;
		
		   document.getElementById("GenerarCSV").style.display = "none";
		    
		$("#mensaCSV").html("");  
         
		var parametros = {
			  "salida"     : "FacturasEntreFechas",
			  "inicio"     : ini,
			  "fin"        : fin
              };  
		$.ajax({
             data:  parametros,
             url:   '../php/GenerarFicheroCSVFacturasEntreFechas.php',
             type:  'post',
             beforeSend: function () {
                 $("#mensaCSV").html("<span class='azul'>Generando Fichero ....</span>"); 
             },
             success:  function (response) {
                if (response != "OK") {
                    $("#mensaCSV").html("<span class='rojo'>El Fichero NO se ha grabado correctamente</span>")
                } else {
                    $("#mensaCSV").html("<span class='azul'>Fichero generado en la carpeta /CSVFicheros (Bajar con Filezilla)</span>"); 
                }
				 $('#botonSalidaCSV').css("display","inline");
             },
			 error: function(jqXHR, textStatus, errorThrown){
                $("#mensaCSV").html("<span class='rojo'>Error Generando Fichero</span>"+ " " + errorThrown+" "+textStatus+" "+jqXHR);
				$('#botonSalidaCSV').css("display","inline");
				return false;
            }
        });	
	
              
        }
     

    </SCRIPT>
  


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Facturación entre fechas</title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />
<!-Hoja de estilos del calendario --> 
  <link rel="stylesheet" type="text/css" media="all" href="../php/calendar/calendar-green.css" title="win2k-cold-1" /> 

  <!-- librería principal del calendario --> 
 <script type="text/javascript" src="../php/calendar/calendar.js"></script> 

 <!-- librería para cargar el lenguaje deseado --> 
  <script type="text/javascript" src="../php/calendar/lang/calendar-es.js"></script> 

  <!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código --> 
  <script type="text/javascript" src="../php/calendar/calendar-setup.js"></script> 

</head>

<body>

<br>

<div class="TituloEstadistica">Facturación entre fechas</div>
<br />

<div id = "cabeceraEstadistica"> 

<form id = "datos" name= "datos"  method="post">  <!--action="SubgruposFicha.php"-->
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='mantenimiento.php'" />
	
&nbsp; &nbsp; &nbsp; &nbsp;
&nbsp; &nbsp;Fecha inicio >= a:  <input id = "Fecha_Ini" name="Fecha_Ini" size="12"  maxlength="12"  onChange="EnsenyaRecalculo()" value="<?php $_REQUEST['Fecha_Ini'] ?>" />
<?php echo elfecha('Fecha_Ini', 'date');?>
&nbsp; &nbsp;Fecha fin <= a:  <input id = "Fecha_Fin" name="Fecha_Fin" size="12"  maxlength="12"  onChange="EnsenyaRecalculo()"  value="<?php $_REQUEST['Fecha_Fin'] ?>" />
<?php echo elfecha('Fecha_Fin', 'date');?>
&nbsp; &nbsp; &nbsp; &nbsp;
 
<div id="Recalculo"><input name="Procesar1" type="button" value ="Recalcular" onClick = "Procesar()" /> </div>
<div id="GenerarCSV"><input name="CreaCSV" type="button" value ="Generar CSV" onclick = "CreaFicheroCSV()" /></div>
</form>
</div>
<div class="clear"></div>
<script>
document.getElementById('Fecha_Ini').value = <?php echo '"'.$_REQUEST['Fecha_Ini'].'"';?>;
document.getElementById('Fecha_Fin').value = <?php echo '"'.$_REQUEST['Fecha_Fin'].'"';?>;

</script>


<div class="envoltorioEstadistica">

     <div class="centro"><div id="mensaCSV"></div></div>
     <div class="centro">Verifique el porcentaje de IVA</div>

     <div class="GratisCabeceraG">Facturas emitidas, cobros</div>
          <?php echo PintaFacturas($FormatCobros,$_REQUEST['Fecha_Ini'],$_REQUEST['Fecha_Fin'],$conexion) ?>
     </div>
	
     <div class="clear"></div>
     <br>
	
     <div class="GratisCabeceraG">Facturas recibidas, gastos</div>
          <?php echo PintaRecibidas($FormatRecibidas,$_REQUEST['Fecha_Ini'],$_REQUEST['Fecha_Fin'],$conexion) ?>
     </div>	


</div>
	
<script>
    document.getElementById("GenerarCSV").style.display = "inline";
</script>


<br>
<br>
<script type="text/javascript"> 

<?php
   
		echo 'Calendar.setup({ inputField: "'.'Fecha_Ini'.'", ifFormat : "%Y-%m-%d",  button : "'."BOT".'Fecha_Ini'.'" }); ';   
		echo 'Calendar.setup({ inputField: "'.'Fecha_Fin'.'", ifFormat : "%Y-%m-%d",  button : "'."BOT".'Fecha_Fin'.'" }); ';  

   	   
/*   Calendar.setup({ 
    inputField     :    "campo_fecha",     
     ifFormat     :     "%d/%m/%Y",    
     button     :    "lanzador"     
     }); */

?>

</script> 

</body>
</html>
<?php mysqli_close($conexion); ?>

<?php

//.......................................................
function elfecha($nombre,$tipo) {
	$devolver ="";
	$pos = strpos($tipo,'date');
	if ($pos !== false) {
		$devolver = '<input type="button" id="'."BOT".$nombre.'" value="..." />'; 
	}
	return $devolver;
}
//...........................................................................
function RellenaPuntos($txt,$long) {
	$longTexto = strlen($txt);
	$relleno = "";
	if ($longTexto < $long) {
		$relleno = str_repeat(".",$long-$longTexto);
		return $txt.$relleno;
	}
	return $txt;
}
//...........................................................................
function NoZero($num) {
	return ($num == 0 ? "..." : $num);
}
//...........................................................................

function PintaFacturas($FormatCobros, $Dini,$Dfin, $conexion) {
	$DatosIva =   new PaisesIva($conexion);
    $devolver = "";
	
	$queMailAl = sprintf($FormatCobros, $Dini, $Dfin,$Dini, $Dfin,$Dini, $Dfin); 
	//echo "<br />@@@ ----orden- >".$orden."     --->".$ordenAplicar;
    
	//echo "<BR>".$queMailAl;
    
    //$devolver .=  "<br />@@@ ----- >".$queMailAl;
    $devolver = "";
    $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion)); 
    $totMailAl = mysqli_num_rows($resMailAl); 
	
	
	
	
		$devolver .= "<TABLE class ='arialpeq' id ='resultado' align='center' border=1><TR class= 'negreta'><TD>TIPO</TD> <TD>CLIENTE</TD><TD>PAIS</TD><TD>F.  EMISIÓN</TD><TD>B. IMPONIBLE</TD><TD>IVA</TD><TD>T. FACTURA</TD><TD>GASTOS</TD><TD>ORDEN 2CHECK</TD><TD>N. FACTURA</TD></TR>";
     if ($totMailAl > 0){
		 $totalBase = 0;
		 $totalIva = 0;
		 $totalImporte = 0;
         while ($rowMailAl = mysqli_fetch_assoc($resMailAl)) {
		   $Piva = $DatosIva->GetIva($rowMailAl['codigo_pais'],$rowMailAl['ciudad']);
		   //$Piva = 0;
		   $baseI=$rowMailAl['importe']-($rowMailAl['importe']*$Piva/100);
		   $Iva=($rowMailAl['importe']*$Piva/100);
		   
           $totalBase = $totalBase+$baseI;
		   $totalIva = $totalIva+ $Iva;
		   $totalImporte = $totalImporte+$rowMailAl['importe'];
		   $totalGastos = $totalGastos + $rowMailAl['gastos'];
		   
		   if (BuscaIDPorEmail($rowMailAl['email_cliente'],$conexion) > 0) {
		       $FOnClick = ' onClick = "VerActividad('.BuscaIDPorEmail($rowMailAl['email_cliente'],$conexion).')"';	
		   } else {
		       $FOnClick = ' onClick = "VerActividadNoAlumno('."'".$rowMailAl['email_cliente']."'".')"';	
		   }
		  	   
	       $devolver .= "<TR class = 'rowActividadA' ".$FOnClick.">";
           
           //$devolver .= "<TR class = 'rowActividadA'>";
	
		   $devolver .= "<TD>".$rowMailAl['tipo']."</TD>";
		   $devolver .= "<TD>".$rowMailAl['email_cliente']."</TD>"; 
		   $devolver .= "<TD>".$rowMailAl['codigo_pais']."</TD>"; 
		   $devolver .= "<TD>".$rowMailAl['fecha']."</TD>"; 
		   $devolver .= "<TD class = 'derecha3'>".$baseI."</TD>"; 
		   $devolver .= "<TD class = 'derecha3'>".$Iva."</TD>"; 
		   
		   $devolver .= "<TD class = 'derecha3'>".$rowMailAl['importe']."</TD>"; 
		   $devolver .= "<TD class = 'derecha3'>".$rowMailAl['gastos']."</TD>"; 
           $devolver .= "<TD>".$rowMailAl['numero_orden']."</TD>";   
           $devolver .= "<TD>".$rowMailAl['numero_factura']."</TD>";   
           $devolver .= "</TR>";  
       }   
		   $devolver .= "<TR class= 'negreta'>";
		   $devolver .= "<TD></TD>";
		   $devolver .= "<TD></TD>";
		   $devolver .= "<TD></TD>";
		   $devolver .= "<TD>TOTALES</TD>"; 
		   $devolver .= "<TD class = 'derecha3'>".$totalBase."</TD>"; 
		   $devolver .= "<TD class = 'derecha3'>". $totalIva."</TD>"; 
		   
		   $devolver .= "<TD class = 'derecha3'>".$totalImporte."</TD>";  
		    $devolver .= "<TD class = 'derecha3'>".$totalGastos."</TD>";
           $devolver .= "<TD></TD>";   
           $devolver .= "<TD></TD>";   
           $devolver .= "</TR>";   
		 
     }
 	$devolver .= "</TABLE>";
	

    return $devolver;
}
//...............................................................................
function PintaRecibidas($FormatRecibidas, $Dini,$Dfin, $conexion) {
	$DatosIva =   new PaisesIva($conexion);
    $devolver = "";
	
	$FormatMailAl = $FormatRecibidas; 
    $queMailAl = sprintf($FormatRecibidas, $Dini, $Dfin);
	
    
	//echo "<BR>".$queMailAl;
    
    //$devolver .=  "<br />@@@ ----- >".$queMailAl;
    $devolver = "";
    $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion)); 
    $totMailAl = mysqli_num_rows($resMailAl); 
		$devolver .= "<TABLE class ='arialpeq' id ='resultado2' align='center' border=1>
		<TR class= 'negreta'><TD>M. PAGO</TD> <TD>PROVEEDOR</TD><TD>PAIS</TD><TD>F.  FACTURA</TD><TD>B. IMPONIBLE</TD><TD>IVA</TD><TD>T. FACTURA</TD><TD>N. FACTURA</TD></TR>";
    
	
	
	if ($totMailAl > 0){
		 $totalBase = 0;
		 $totalIva = 0;
		 $totalImporte = 0;
       while ($rowMailAl = mysqli_fetch_assoc($resMailAl)) {
		   $Piva = $DatosIva->GetIva($rowMailAl['codigo_pais'],"");
		   //$Piva = 0;
		   if ($Piva >0) {
			 $Iva=  $rowMailAl['iva'];  
		   } else {
		      $Iva = 0;
		    }
		   $baseI=$rowMailAl['importe'] - $Iva;
           
		   $totalBase = $totalBase+$baseI;
		   $totalIva = $totalIva+ $Iva;
		   $totalImporte = $totalImporte+$rowMailAl['importe'];
		   
		   
		   
           $devolver .= "<TR class = 'rowActividadA'>";
		   $devolver .= "<TD>".$rowMailAl['medio_pago']."</TD>";
		   $devolver .= "<TD>".$rowMailAl['proveedor']."</TD>"; 
		   $devolver .= "<TD>".$rowMailAl['codigo_pais']."</TD>"; 
		   $devolver .= "<TD>".$rowMailAl['fecha_factura']."</TD>"; 
		   $devolver .= "<TD class = 'derecha3'>".$baseI."</TD>"; 
		   $devolver .= "<TD class = 'derecha3'>".$Iva."</TD>"; 
		   
		   $devolver .= "<TD class = 'derecha3'>".$rowMailAl['importe']."</TD>";   
		  
           $devolver .= "<TD>".$rowMailAl['numero_factura']."</TD>";   
           $devolver .= "</TR>";  
       }   
		   $devolver .= "<TR class= 'negreta'>";
		   $devolver .= "<TD></TD>";
		   $devolver .= "<TD></TD>";
		   $devolver .= "<TD></TD>";
		   $devolver .= "<TD>TOTALES</TD>"; 
		   $devolver .= "<TD class = 'derecha3'>".$totalBase."</TD>"; 
		   $devolver .= "<TD class = 'derecha3'>". $totalIva."</TD>"; 
		   
		   $devolver .= "<TD class = 'derecha3'>".$totalImporte."</TD>";  
		  
           //$devolver .= "<TD></TD>";   
           $devolver .= "<TD></TD>";   
           $devolver .= "</TR>";   
		 
     }
	 
 	$devolver .= "</TABLE>";
    return $devolver;
}

//...................................................................
function BuscaIDPorEmail($Pmail,$conexion) {
$id = 0;
$FormatMailAl = "select id from vtalumnos where email = '%s'";
$queMailAl = sprintf($FormatMailAl,$Pmail); 
    $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion)); 
    $totMailAl = mysqli_num_rows($resMailAl); 
	 if ($totMailAl > 0){
		 while ($rowMailAl = mysqli_fetch_assoc($resMailAl)) {		   
		   $id = $rowMailAl['id'];
		 }
	}
mysqli_free_result($resMailAl);
return $id;

}

?>
