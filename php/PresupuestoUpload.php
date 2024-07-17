<?php

 //comprobamos que sea una petición ajax
 if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  
     $file = $_FILES['userfile']['name'];
     if(!is_dir("../PRESUPUESTOS/")) {
         mkdir("../PRESUPUESTOS/", 0777);
     } 
     $file_comprobar = "../PRESUPUESTOS/".$_FILES['userfile']['name'];
     if (file_exists($file_comprobar)) {
       	  echo "Fichero ya existe en el servidor<br>Por seguridad cambie el nombre a su fichero";
     } else {
       if ($file && move_uploaded_file($_FILES['userfile']['tmp_name'],"../PRESUPUESTOS/".$file))  {
          sleep(15);//retrasamos la petición 15 segundos
          //echo $file;//devolvemos el nombre del archivo para pintar la imagen
          echo "OK";
       } else {
       	echo "Error en la transmison";
       }   
    }   
 
 }else{
 	echo "Se ha producido una excepcon, repita el envio";
     throw new Exception("Error Processing Request");   
 }  

?>