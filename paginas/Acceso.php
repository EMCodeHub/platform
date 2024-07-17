<?php 
function acceso($conexion) {
       $_SESSION['autentificado'] = 0;
	     if (!isset($_SESSION['es_admin'])) { 
              $_SESSION['es_admin'] = 0;
		 }
	     $_SESSION['referencia_interna']  = 0;
 	
   //....inicio......................comprobar usu y pwd
	$FormatqueEmp = "SELECT id, nombre_usuario, pwd, es_admin, referencia_interna, fecha_alta,	fecha_baja FROM usuarios WHERE TRIM(nombre_usuario) = '%s' and TRIM(pwd) = '%s' and (SYSDATE() < fecha_baja or fecha_baja = '0000-0000-00')";
	

	
	$queEmp = sprintf($FormatqueEmp, $_REQUEST['usuario'],$_REQUEST['pwd']); 
   
   //..........ejecutar query
   $resEmp = mysqli_query($conexion, $queEmp) or die(mysqli_error($conexion));
   $totEmp = mysqli_num_rows($resEmp);	
   
    
   	  
   if ($totEmp> 0) {  
        
      
       $_SESSION['autentificado']  = 1;
       

	   while ($row = mysqli_fetch_assoc($resEmp)) {
		      $_SESSION['referencia_interna']  = $row['referencia_interna'];
		      $_SESSION['es_admin']             = $row['es_admin'];
     
      }
      
 
   }
   
   
  
   mysqli_free_result($resEmp);
	
	return $_SESSION['autentificado'];
}  //.............................................................acceso()

function cambioPwd($conexion,$xusuario,$xnueva) {
    //....inicio......................comprobar usu y pwd
	$FormatqueEmp = "UPDATE  usuarios SET pwd = '%s' WHERE TRIM(nombre_usuario) = '%s' ;";
	
	//echo "<br>".$FormatqueEmp."<br>";
	
	$queEmp = sprintf($FormatqueEmp, $xnueva, $xusuario); 
    //echo "<br>".$queEmp."<br>";
    //....fin......................comprobar usu y pwd
	  
   
   //..........ejecutar query
   $resEmp = mysqli_query($conexion, $queEmp) or die(mysqli_error($conexion));
    mysqli_free_result($resEmp);
}  //.............................................................cambioPwd()


?>
