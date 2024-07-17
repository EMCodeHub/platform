<?php
/////////////////////////////////////////////////////////////////////
 function EmailAlumno($numAlumno,$conexion) {
	 $mail = "";
	   $FormatMaestros = "SELECT id, email, nombre, apellidos FROM vtalumnos  where  id = %d";
	//echo "<br>".$FormatMaestros."<br>";
   $queMaestros = sprintf($FormatMaestros, $numAlumno); 
    //echo "<br>".$queMaestros."<br>"; 
   //..........ejecutar query
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);
   if ($totMaestros == 0) {
	   return "";
   }
    while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
		$mail = $rowRegistros['email'];
		
	}
	mysqli_free_result($resMaestros);  
return $mail;
 }
 //////////////////////////////////////////////////////////////////////////
function dibujaRajolaVideotutorial($numCurso,$conexion) {

  $FormatMaestros = "SELECT id_curso, carpetadeficheros, imaicono_cur, web_titulo, titulo_cur, descripcion_cur, web_logosoftware, web_ficherophp 
                     FROM vtcursos  
                     WHERE  id_curso = %d";
	//echo "<br>".$FormatMaestros."<br>";
   $queMaestros = sprintf($FormatMaestros, $numCurso); 
    //echo "<br>".$queMaestros."<br>"; 
   //..........ejecutar query
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);
   if ($totMaestros == 0) {
	   exit;
   }
   while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) { 
   $background = "VIDEOTUTORIALES/".trim($rowRegistros['carpetadeficheros'])."/".trim($rowRegistros['imaicono_cur']);
   $destino ="paginas/".trim($rowRegistros['web_ficherophp']);/*."?NumeroCurso=".$numCurso;*/
   $imgSoftware = "imagenes/".trim($rowRegistros['web_logosoftware']);
   $tituloWeb = trim($rowRegistros['web_titulo']);
   $tituloCur = trim($rowRegistros['titulo_cur']);
   $descripcion = trim($rowRegistros['descripcion_cur']);   
   ?>

       
       <div class="ContenedorCursoLinea">
           <a href="<?php echo $destino ?>">
	        <div class="ContenedorCursoIzda" style="background-image: url('<?php echo $background ?>'); " >  
               <div class="NewContenedor100" >
                    <div class ="ImagenSoftware"><img src="<?php echo $imgSoftware ?>" height="50" alt="Logo Software" /></div>
                    
               </div>
            </div>   <!--ContenedorCursoIzda-->
           </a>
           
           
           <div class="ContenedorCursoDcha">
               
               
               <a href="<?php echo $destino ?>"><h2><?php echo $tituloWeb ?></h2></a>
               
               
               
               
               <div class="raya"></div>
               <h3><?php echo $tituloCur ?></h3>
               
               
               <p><?php  echo str_replace("\r\n","<br>",$descripcion); ?></p>
               
      
               

<!--REBRANDING, SE HA AÑADIDO UN SVG FLECHA-->
               
             
               <div class="derecha"><a href="<?php echo $destino ?>" >Ver más ... <svg class="combined-svg" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"> <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"></path> </svg></path>
</svg>
</a>  </div>  
           </div>
           
           
           
       </div> <!--ContenedorCursoLinea-->
       
     

		
  <?php } //DE WHILE 
	mysqli_free_result($resMaestros);  
}
?>
<?php
 function dibujaCatalogoRajoles($clausulaNOTIN,$conexion) {

						  
		$FormatCatalogo = "SELECT id_categoria, id_curso 
		                     FROM vtcursos , vtcategorias 
		                    WHERE vtcursos.id_categoria = vtcategorias.id 
							  and  vtcursos.esta_activo > 0
							  and  vtcursos.es_d_pago > 0 
							  and   ( vtcursos.fecha_fin IS NULL OR YEAR(vtcursos.fecha_fin) = 0  OR vtcursos.fecha_fin >= CURDATE()) ";
							   if (strlen($clausulaNOTIN) > 0){
							       $FormatCatalogo .= " and   id_curso NOT IN ".$clausulaNOTIN;
							   }
						  //$FormatCatalogo .= " ORDER BY id_categoria,id_curso";
						  $FormatCatalogo .= " ORDER BY vtcursos.orden";
        $queCatalogo = sprintf($FormatCatalogo);
		
		  //echo $queCatalogo;
		  
		  
        $resCatalogo = mysqli_query($conexion, $queCatalogo) or die(mysqli_error($conexion)); 
	  
        $totCatalogo = mysqli_num_rows($resCatalogo);     

if ($totCatalogo == 0){
	return;
}
	
	while ($rowCatalogo = mysqli_fetch_assoc($resCatalogo)) {
		$cursoPagado = $rowCatalogo['id_curso'];
		dibujaRajolaVideotutorial($rowCatalogo['id_curso'],$conexion) ;
	}
    mysqli_free_result($resCatalogo); 
 }
//////////////////////////////////////////////////////////////////////////
 function buscaTituloCatalogo($clausulaNOTIN,$conexion) {
	 $longitudPagados = count($_SESSION['permisos']);
	 if ($longitudPagados == 0) {
		 return "Cursos Cype Online:";
	 }
	 $longitudNOPagados = cuentaNOPagados($clausulaNOTIN,$conexion);
	 if ($longitudNOPagados > 0) {
		 return "Otros cursos Cype:";
	 } else {
		return ""; 
	 }
 }
 //////////////////////////////////////////////////////////////////////////
 function cuentaNOPagados($clausulaNOTIN,$conexion) {
		   $FormatMaestros = "SELECT id_curso 
		                        FROM vtcursos  
		                       WHERE vtcursos.esta_activo > 0
                               and es_d_pago > 0
							   and   ( vtcursos.fecha_fin IS NULL OR YEAR(vtcursos.fecha_fin) = 0  OR vtcursos.fecha_fin >= CURDATE())";
							   if (strlen($clausulaNOTIN) > 0){
							       $FormatMaestros .= "and   id_curso NOT IN ".$clausulaNOTIN;
							   }
	//echo "<br>".$FormatMaestros."<br>";
    $queMaestros = sprintf($FormatMaestros); 
    //echo "<br>".$queMaestros."<br>"; 
   //..........ejecutar query
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);
   mysqli_free_result($resMaestros);  
	return $totMaestros;
 }
?>






