<?php 

 function CreaArrayPrecios($conexion) {
		    $arraySaliente = "	var RELACIONPRECIOS = [";
			$FormatPrecio = "SELECT id, num_cursos, precio_lote  
		                         FROM vtpreciolote "
		                        ;
        $quePrecio = sprintf($FormatPrecio);
        $resPrecio = mysqli_query($conexion, $quePrecio) or die(mysqli_error($conexion)); 
        $totPrecio = mysqli_num_rows($resPrecio);     

if ($totPrecio == 0){
	$arraySaliente .= "];";
	return $arraySaliente;
}
	$x=0;
	while ($rowPrecio = mysqli_fetch_assoc($resPrecio)) {
		$x++;
	   $arraySaliente .= "[".$rowPrecio['num_cursos'].",".$rowPrecio['precio_lote']."]";
       if ($x < $totPrecio) {
		   $arraySaliente .= ",";
	   }
	}
	$arraySaliente .= "];";
    mysqli_free_result($resPrecio); 
	return $arraySaliente;
 
 }


  function CreaArrayDescuentos($conexion,$clausulaNOTIN) {
	        $arraySaliente = "	var RELACIONCURSOS = [";
			$FormatCatalogo = "SELECT id_curso, preciotutorial, tiene_descuento,es_d_pago, web_titulo  
		                       FROM vtcursos  
		                       WHERE vtcursos.esta_activo > 0
		                       and vtcursos.es_d_pago = 1 
							      and   ( vtcursos.fecha_fin IS NULL OR YEAR(vtcursos.fecha_fin) = 0  OR vtcursos.fecha_fin >= CURDATE()) ";
							   if (strlen($clausulaNOTIN) > 0){
							       $FormatCatalogo .= " and   id_curso NOT IN ".$clausulaNOTIN;
							   }
			 $FormatCatalogo .= " ORDER BY -tiene_descuento, orden";
        $queCatalogo = sprintf($FormatCatalogo);
        $resCatalogo = mysqli_query($conexion, $queCatalogo) or die(mysqli_error($conexion)); 
        $totCatalogo = mysqli_num_rows($resCatalogo);     

if ($totCatalogo == 0){
	$arraySaliente .= "];";
	return $arraySaliente;
}
	$x=0;
	while ($rowCatalogo = mysqli_fetch_assoc($resCatalogo)) {
		$x++;
	   $arraySaliente .= "[".$rowCatalogo['id_curso'].",".$rowCatalogo['preciotutorial'].",".$rowCatalogo['tiene_descuento'].",'".$rowCatalogo['web_titulo']."']";
       if ($x < $totCatalogo) {
		   $arraySaliente .= ",";
	   }
	}
	$arraySaliente .= "];";
    mysqli_free_result($resCatalogo); 
	return $arraySaliente;
 }  
 
 function CalculaDtoMaximo($conexion) {
	    $salida = "0";
		$FormatDtoMaximo = "SELECT dto_maximo
		                      FROM vtparametros
                          limit 1";
        $queDtoMaximo = sprintf($FormatDtoMaximo);
        $resDtoMaximo = mysqli_query($conexion, $queDtoMaximo) or die(mysqli_error($conexion)); 
        $totDtoMaximo = mysqli_num_rows($resDtoMaximo);     
	while ($rowDtoMaximo = mysqli_fetch_assoc($resDtoMaximo)) {	
	   $salida = $rowDtoMaximo['dto_maximo'];
	}
  mysqli_free_result($resDtoMaximo); 
	return $salida;
 }
 
 
  function NumeroCursosYaComprados($conexion,$clausulaNOTIN) {
	   if (strlen($clausulaNOTIN) == 0){
	       return 0;
	   }
	    $totCursosYaComprados = 0;
			$FormatCursosYaComprados = "SELECT id_curso, es_d_pago
		                                 FROM vtcursos  
		                                 WHERE vtcursos.esta_activo > 0 
		                                 and vtcursos.es_d_pago = 1 
										   and    tiene_descuento > 0 
							               and   ( vtcursos.fecha_fin IS NULL OR YEAR(vtcursos.fecha_fin) = 0  OR vtcursos.fecha_fin >= CURDATE()) ";
							               if (strlen($clausulaNOTIN) > 0){
							                  $FormatCursosYaComprados .= " and   id_curso IN ".$clausulaNOTIN;
							               }
			
        $queCursosYaComprados = sprintf($FormatCursosYaComprados);
		
        $resCursosYaComprados = mysqli_query($conexion, $queCursosYaComprados) or die(mysqli_error($conexion)); 
        $totCursosYaComprados = mysqli_num_rows($resCursosYaComprados);     

    mysqli_free_result($resCursosYaComprados); 
	  return $totCursosYaComprados;
  }
  function DibujaTablaCursos($conexion,$clausulaNOTIN) {
	    $txtSaliente = "";
			$FormatCursosVenta = "SELECT id_curso, web_titulo  
		                         FROM vtcursos  
		                        WHERE vtcursos.esta_activo > 0 
		                        and vtcursos.es_d_pago = 1 
							      and   ( vtcursos.fecha_fin IS NULL OR YEAR(vtcursos.fecha_fin) = 0  OR vtcursos.fecha_fin >= CURDATE()) ";
							   if (strlen($clausulaNOTIN) > 0){
							       $FormatCursosVenta .= " and   id_curso NOT IN ".$clausulaNOTIN;
							   }
			 $FormatCursosVenta .= " ORDER BY -tiene_descuento, orden";
        $queCursosVenta = sprintf($FormatCursosVenta);
        $resCursosVenta = mysqli_query($conexion, $queCursosVenta) or die(mysqli_error($conexion)); 
        $totCursosVenta = mysqli_num_rows($resCursosVenta);     

if ($totCursosVenta == 0){
	return $txtSaliente;
}

	while ($rowCursosVenta = mysqli_fetch_assoc($resCursosVenta)) {
      $txtSaliente .="";
      $txtSaliente .= '<div class="cursosRelacionCol1"><input type="checkbox" value="';
      $txtSaliente .= $rowCursosVenta['id_curso'].'" ';
      $txtSaliente .= 'name="checkbox" OnChange="CambioValor(value)"/> </div>';
	  
      $txtSaliente .='<div class="cursosRelacionCol2">'.$rowCursosVenta['web_titulo'].'</div>';   
	  $txtSaliente .='<div class="clear"></div>';
      
	}
  mysqli_free_result($resCursosVenta); 
	return $txtSaliente;
 }  


?>

<script>
	function VerDescuentos(modo) {
		j = document.getElementById('CorrreoCobrosDescuentos');
		d = document.getElementById('envoltorioGeneralDescuentos');
		
		/*k = document.getElementById('botonCalcular');*/
		
		m = document.getElementById('CorrreoCobros');
		j.style.display= "none";
		m.style.display= "none";
		if(modo == 0) {
			d.style.display= "none";
			
			/*k.style.display= "block";*/
		} else {
			
	        var checkboxes = document.getElementById("formDescuentos").checkbox;
			for (var x=0; x < checkboxes.length; x++) {
				checkboxes[x].disabled = false; 
			 }
		
			
			
          posY = d.style.top = CursorY-200;
          if (posY < 100) { posY = 100;};
          d.style.top = posY+"px";
		  
			d.style.display= "block";
			
			
			
		    p = document.getElementById('botonesCompra');
	        p.style.display= "block";
			/*k.style.display= "none";*/
			var checkboxes = document.getElementById("formDescuentos").checkbox;
			for (var x=0; x < checkboxes.length; x++) {
			   //checkboxes[x].disabled ="false"; 
			   checkboxes[x].disabled = false; 
	    }
		}
	}

</script>


<script> 
  moneda = "<?php echo $DatosWeb->GetTrimValor('moneda') ?>";
  var cursosTotalesEnCompra = 0;          // Suma de cursosConDesEnCompra + cursosSinDesEnCompra
  var ImporteTotalCompra           = 0;        // Valor de la factura (total a pagar) -----> importeNominalSinDes + cursosConDesVAplicado
  var cadenaCursosComprados = "";          // Cadena de texto con relación de cursos comprados

 <?php echo CreaArrayDescuentos($conexion,$clausulaNOTIN); 
       echo "\n";
       echo CreaArrayPrecios($conexion); ?>

function NoCero(valor) {
   if (valor != 0) {
		   return(valor)
   } else { 
           return ("");
   }

}
function buscaPrecio(numCursos) {
    for (var x=0; x < RELACIONPRECIOS.length; x++) {
	    if (RELACIONPRECIOS [x] [0] == numCursos) {
			return  RELACIONPRECIOS [x] [1];
	    }
	}	
    return "error calculando precio";
}

function CambioValor(valor) {
	var cursosTotales = 0;   // Son los cursos de BBDD que tienen descuento, para calcular el porcentaj
	document.getElementById("labelConDesEnCompra").innerHTML= "";
	document.getElementById("cursosCompra100c").innerHTML= "";

	for (var x=0; x < RELACIONCURSOS.length; x++) {
	    if (RELACIONCURSOS [x] [2] == 1) {
			cursosTotales++;
	    }
	}
			
	var descuentoMaximo   = <?php echo CalculaDtoMaximo($conexion); ?>;   
	
	var cursosYaComprados = 0; /*<?php echo NumeroCursosYaComprados($conexion,$clausulaNOTIN); ?> ;*/    

        cursosTotales += cursosYaComprados;
    var descuentoAplicado  = 0;
	var cursosConDesEnCompra = 0;  
	var cursosSinDesEnCompra  = 0;
  
	var cursosCalculoDescuento = 0;         // Suma de cursosYaComprados + cursosTotalesEnCompra ...... contamos todos, incluso los que no tienen descuento
	
	var ImporteNominalConDes    = 0;        // Valor de tablas de los cursos con descuento
	var importeNominalSinDes    = 0;        // Valor de tablas de los cursos sin descuento
	var importeAplicadoConDes   = 0;        // valor descontado de los cursos con descuento
	
    var checkboxes = document.getElementById("formDescuentos").checkbox;

	cursosConDesEnCompra = 0; //Variable que lleva la cuenta de los checkbox pulsados CON DESCUENTO
	cursosSinDesEnCompra = 0;
	ImporteNominalConDes = 0;
	importeNominalSinDes = 0;
	cadenaCursosComprados = "";  //inicializamos la cadena
    for (var x=0; x < checkboxes.length; x++) {
        if (checkboxes[x].checked) {
			if (RELACIONCURSOS [x] [2] == 1) {
                cursosConDesEnCompra = cursosConDesEnCompra + 1;
				ImporteNominalConDes = ImporteNominalConDes + RELACIONCURSOS [x] [1];
			} else {
				cursosSinDesEnCompra = cursosSinDesEnCompra + 1;
				importeNominalSinDes = importeNominalSinDes + RELACIONCURSOS [x] [1];
			}
			if (cadenaCursosComprados == "") {
				cadenaCursosComprados = cadenaCursosComprados +RELACIONCURSOS [x] [0];
			} else {
				cadenaCursosComprados = cadenaCursosComprados + ","+RELACIONCURSOS [x] [0];
			}
        }
    }
		
	
    cursosTotalesEnCompra = cursosConDesEnCompra + cursosSinDesEnCompra;
    cursosCalculoDescuento = cursosConDesEnCompra + cursosYaComprados  ;
	
	
	
	
	
	
	importeAplicadoConDes = ImporteNominalConDes; // De momento, valor aplicado igual a nominal
	 if ((cursosCalculoDescuento >0) && cursosConDesEnCompra >0) {
		 document.getElementById("labelConDesEnCompra").innerHTML= "Curso";
	 }
    if ((cursosCalculoDescuento >1) ){
		descuentoAplicado = Math.trunc(cursosCalculoDescuento * descuentoMaximo / cursosTotales);
		if (descuentoAplicado > descuentoMaximo) {
			descuentoAplicado = descuentoMaximo;
		}
		
		
		//importeAplicadoConDes = Math.trunc(ImporteNominalConDes - (ImporteNominalConDes * descuentoAplicado /100));
	
	importeAplicadoConDes = buscaPrecio(cursosCalculoDescuento);
	
		if (cursosConDesEnCompra > 0) {
			if(cursosConDesEnCompra == 1) {
				document.getElementById("labelConDesEnCompra").innerHTML="Curso";
			} else {
				document.getElementById("labelConDesEnCompra").innerHTML="Cursos en Promoción";
			}			
		} else {
			document.getElementById("labelConDesEnCompra").innerHTML= "";
			document.getElementById("labelDescuento").innerHTML= "";
			document.getElementById("cursosCompra100c").innerHTML= "Seleccionando más de un curso se obtienen interesantes descuentos";


		}
	} /*else {
		document.getElementById("labelConDesEnCompra").innerHTML= "Curso";
	}*/
	
	if(importeAplicadoConDes != ImporteNominalConDes) {
	   //document.getElementById("labelDescuento").innerHTML= "Descuento: "+descuentoAplicado+" %";
	     document.getElementById("labelDescuento").innerHTML= "Descuento: "
	} else {
	   document.getElementById("labelDescuento").innerHTML= "";
	}
	
	if(ImporteNominalConDes > 0) {
	   document.getElementById("labelImporteDescontado").innerHTML= "IMPORTE";
	} else {
	   document.getElementById("labelImporteDescontado").innerHTML= "";
	}
	
	
	
	
	
	ImporteTotalCompra = importeAplicadoConDes + importeNominalSinDes;
	
	
	document.getElementById("cursosYaAdquiridos").innerHTML= NoCero(cursosYaComprados);

    if (cursosYaComprados > 0) {
     	document.getElementById("labelCursosYaAdquiridos").innerHTML= "Cursos ya adquiridos";
    } else {
	    document.getElementById("labelCursosYaAdquiridos").innerHTML= "";
    }
	
    if (ImporteTotalCompra > 0) {
     	document.getElementById("labelTotalImporte").innerHTML= "<b>TOTAL &nbsp;&nbsp; ( "+ moneda + " )</b>";
    } else {
	    document.getElementById("labelTotalImporte").innerHTML= "";
    }	
	
document.getElementById("cursosConDesEnCompra").innerHTML= NoCero(cursosConDesEnCompra);
document.getElementById("cursosSinDesEnCompra").innerHTML= NoCero(cursosSinDesEnCompra);

document.getElementById("importeConDesEnCompra").innerHTML= NoCero(ImporteNominalConDes);
document.getElementById("importeDescuento").innerHTML= NoCero((ImporteNominalConDes - importeAplicadoConDes) * -1);
document.getElementById("importeDescontado").innerHTML= NoCero(importeAplicadoConDes);

document.getElementById("importeNominalSinDes").innerHTML=  NoCero(importeNominalSinDes);
document.getElementById("totalImporte").innerHTML= "<b>"+NoCero(ImporteTotalCompra)+"</b>";





    if (cursosSinDesEnCompra > 0) {
		if (cursosSinDesEnCompra == 1) {
     	    document.getElementById("labelCursosSinDesEnCompra").innerHTML= "Curso sin descuento";
		} else {
			document.getElementById("labelCursosSinDesEnCompra").innerHTML= "Cursos sin descuento";
		}
	
	} else {
	    document.getElementById("labelCursosSinDesEnCompra").innerHTML= "";
    }
	


    //alert ("El número de checkbox pulsados es " + cont);
   //alert ("estás en CambioValor="+valor)
}


function HazCompra() {
	if (cursosTotalesEnCompra == 0) {
				document.getElementById("cursosCompra100c").innerHTML= "<div class='centroRojo'>Selecciona algún curso</div>";

	    return	
	}
	var checkboxes = document.getElementById("formDescuentos").checkbox;
	var listacursos="&nbsp;&nbsp;&nbsp;&nbsp;<b>COMPRAR LOS VIDEOTUTORIALES:</b><br /><ul>";
    for (var x=0; x < checkboxes.length; x++) {
        if (checkboxes[x].checked) {
	          listacursos = listacursos +"<li>" + RELACIONCURSOS [x] [3]+"</li>";		
        }
    }
	listacursos = listacursos + "</ul>";
	document.getElementById('ListaDeCursosDescontados').innerHTML = listacursos;
	
			d = document.getElementById('CorrreoCobrosDescuentos');
		   posY = d.style.top = CursorY-200;
          if (posY < 100) { posY = 100;};
          d.style.top = posY+"px";
		  d.style.display= "block";
		    
			d = document.getElementById('botonesCompra');
			d.style.display= "none";
			
			for (var x=0; x < checkboxes.length; x++) {
				checkboxes[x].disabled = true; 
			 }
			 document.getElementById("PrecioCompra").innerHTML=NoCero(ImporteTotalCompra)+" "+moneda;
			 
	
}
function GetImagenPagoTarjetaDE(Cual,id) {
	//alert("entra en GetImage..."+"Cual--->"+Cual+" id="+id);
	if (Cual == 1) {
		id.src = "../imagenes/Tarjeta_on.gif";
		
	} else {
		id.src = "../imagenes/Tarjeta_off.gif";
	}
	
}
function GetImagenPagoTransferDE(Cual,id) {
	//alert("entra en GetImage..."+"Cual--->"+Cual+" id="+id);
	if (Cual == 1) {
		id.src = "../imagenes/Transfer_on.gif";
		
	} else {
		id.src = "../imagenes/Transfer_off.gif";
	}
	
}
</script>

<form id="formDescuentos">
<div id="envoltorioGeneralDescuentos">
<br />
     <div class="centro">
         <strong style="font-size:1.2em; font-family:Arial, Helvetica, sans-serif">Descuento por adquirir más de un curso</strong>
     </div>
     
<div id="cursosRelacion">
<div class="cursosRelacionCols"><b>SELECCIONA LOS CURSOS</b></div> 
   <?php echo DibujaTablaCursos($conexion,$clausulaNOTIN); ?>
</div>  <!--        de cursosRelacion-->

<div id="cursosCompra">
  <div class="cursosCompra100"><b>SIMULADOR DE PRECIO</b></div>  
  <div class="clear"></div>  
  
   <div id="cursosCompra100c">Seleccionando más de un curso se obtienen interesantes descuentos</div>  
   

  <div id="cursosYaAdquiridos">&nbsp;</div>
  <div id="labelCursosYaAdquiridos">&nbsp;</div>
  <div class="clear"></div>  

  <div id="cursosConDesEnCompra">&nbsp;</div>
  <div id="labelConDesEnCompra"></div>
  <div id="importeConDesEnCompra"></div>  
  <div class="clear"></div>  

  <div id="labelDescuento">&nbsp;</div>
  <div id="importeDescuento">&nbsp;</div>
  <div class="clear"></div>  
 
  <div id="labelImporteDescontado">&nbsp;</div>
  <div id="importeDescontado">&nbsp;</div>
  <div class="clear"></div>  
   
  <div id="cursosSinDesEnCompra">&nbsp;</div>
  <div id="labelCursosSinDesEnCompra">&nbsp;</div>
  <div id="importeNominalSinDes">&nbsp;</div>  
  <div class="clear"></div>  
  
  <div id="labelTotalImporte">&nbsp;</div>
  <div id="totalImporte">&nbsp;</div>
  <div class="clear"></div>  

<br />
<br />


<div id="botonesCompra">

<div class="botonesCompra1"><input type="button" name="&nbsp;salir&nbsp;" value="Salir" class ="ButtonGrisP" onclick="javascript:VerDescuentos(0)" /></div>

<div class="botonesCompra1"><input type="button" name="comprar" value="Comprar cursos" onclick="HazCompra()" class ="ButtonGrisP"/></div>

</div>   

  </div>
  </div>
</form>


 <div class="clear"></div>
<div class="centro100"> 
   <div id = "CorrreoCobrosDescuentos">    
   <div id = "correoCobrosDatos" >
   
   <?php  
   if ($_SESSION['es_admin'] == 1) {
	  echo '<div class="centro"><div class="rojo">Eres Administrador: Compras en PRUEBAS si HAS HABILITADO en 2checkout.com->Panel<br> la modalidad PRUEBAS</div></div>'; 	   
   }
   ?> 
   
   
   
         <div class="izquierda"><p class="pide_panPreTit">Revise su pedido:</p></div>
          
         <div id="ListaDeCursosDescontados"> </div>

        <form  class="formulario">
	    
        <!--<div class="mitad">-->
	     <br />
          <div class="clear"></div>
          
          
          <div class="izquierdaMargen10">
               <label class="pide_panPre">Importe </label> 
               <label id="PrecioCompra"></label> 
               <div class="clear"></div>

			   <br>
               
	          <label class="pide_panPre">Email </label> <input id = "DEemail" type="text" name="DEemail" size="35" maxlength="99" value= "<?php if (isset( $_REQUEST['DEemail'])) { echo $_REQUEST['DEemail']; }?>" required /> 



			 



	          <label class="pide_panPre">Repita el Email</label> <input id = "DEemail2" type="text" name="DEemail2" size="35" maxlength="99" value= "<?php if (isset( $_REQUEST['DEemail2'])) { echo $_REQUEST['DEemail2']; }?>" required /> 

			  <br>
         
          </div>

		  <br>


  	     <br /> 
            

     <div class="clear"></div>
     <br />
       <div class = "pide_panPreMensaje"><div id="DEmarcoMensaje" >&nbsp;</div></div>
       <br />
     <div class="clear"></div>
     
    </form> 
     <div id="DEBotones">
         <button id = "DEButton1" class="botonVisa" ><img src="../imagenes/Tarjeta_on.gif" alt="Tarjeta Visa" /></button>  
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <button  id = "DEButton3" class="botonVisa" ><img src="../imagenes/Transfer_on.gif" alt="Transferencia Bancaria" /></button> 
     </div>   
     <br />
     <br />
      <div class ="centro"> <input id = "DEButton4" name="Salir" type="button" class ="ButtonGrisP" value ="&nbsp;&nbsp;&nbsp;&nbsp;Salir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" onclick="javascript:VerDescuentos(0)"/></div>
       <br />
       <br /> 
  
     <div class="clear"></div>
  
 
</div>
</div>  
</div>   
  

