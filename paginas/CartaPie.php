 <!--## ......INCLUSIÓN del PIE de las cartas ###   -->    
    <br/>
    <hr style="color: #0056b2;" />
        <div style="font-family:Arial, Helvetica, sans-serif; color:#0934CF ; font-size:0.9em; text-align:left; margin-left:5px; margin-right:3px;  padding-right:0.2em; vertical-align:top;float: right;">
         
         <?php if(DatoLleno($DatosWeb->GetValor('web_youtube'))) { ?>
           &nbsp;<img src="<?php echo $DatosWeb->GetValor('web_url') ?>/imagenes/YouTube.gif"  alt="Logo YouTube" height="25"  style="cursor:pointer"  
           onclick="location.href='<?php echo $DatosWeb->GetValor('web_youtube') ?>'"/> 
         <?php } ?>
         
         <?php if(DatoLleno($DatosWeb->GetValor('web_facebook'))) { ?>
           &nbsp;<img src="<?php echo $DatosWeb->GetValor('web_url') ?>/imagenes/LogoFacebook.gif"  alt="Logo FaceBook" height="25"  style="cursor:pointer"  
           onclick="location.href='<?php echo $DatosWeb->GetValor('web_facebook') ?>'"/> 
         <?php } ?>
          
         <?php if(DatoLleno($DatosWeb->GetValor('web_instagram'))) { ?>
           &nbsp;<img src="<?php echo $DatosWeb->GetValor('web_url') ?>/imagenes/InstagramLogo.gif"  alt="Logo Instagram" height="25"  style="cursor:pointer"  
           onclick="location.href='<?php echo $DatosWeb->GetValor('web_instagram') ?>'"/> 
         <?php } ?>
         
         <?php if(DatoLleno($DatosWeb->GetValor('web_twitter'))) { ?>
           &nbsp;<img src="<?php echo $DatosWeb->GetValor('web_url') ?>/imagenes/twitter.gif"  alt="Logo Twitter" height="25"  style="cursor:pointer"  
           onclick="location.href='<?php echo $DatosWeb->GetValor('web_twitter') ?>'"/> 
         <?php } ?>
         
    </div>
    
    
    <div style="font-family:Arial, Helvetica, sans-serif; color:#0934CF ; font-size:0.9em; text-align:left; margin-left:5px; margin-right:3px; padding-right:0.2em; vertical-align:top;float: right;">
         <div style="font-family:Arial, Helvetica, sans-serif; color:#0934CF ; font-size:0.9em; text-align:left; margin-left:5px; margin-right:3px; padding-right:0.2em; vertical-align:center;float: right;padding-top:0.4em">
             <?php echo $DatosWeb->GetValor('web_tfnWhatsapp'); ?> 
        </div>
         <div style="font-family:Arial, Helvetica, sans-serif; color:#0934CF ; font-size:0.9em; text-align:left; margin-left:5px; margin-right:3px; padding-right:0.2em; vertical-align:top;float: right;">
             <img src="<?php echo $DatosWeb->GetValor('web_url') ?>/imagenes/whatsapp.gif" alt="Logo whatsapp" height="25"/> 
         </div>  
    </div>
    

    <div>
         <div style="font-family:Arial, Helvetica, sans-serif; color:#0934CF ; font-size:0.9em; text-align:left; margin-left:5px; margin-right:3px; padding-right:0.2em; vertical-align:top;float: right;">
             <?php echo $DatosWeb->GetValor('CorreoPrincipal');
                   if ( DatoLleno($DatosWeb->GetValor('CorreoSecundario')) && $DatosWeb->GetValor('CorreoPrincipal') <> $DatosWeb->GetValor('CorreoSecundario')) {
                     echo  "<br />".$DatosWeb->GetValor('CorreoSecundario'); 
                   }
             ?> 
        </div>
         <div style="font-family:Arial, Helvetica, sans-serif; color:#0934CF ; font-size:0.9em; text-align:left; margin-left:5px; margin-right:3px; padding-right:0.2em; vertical-align:top;float: right;">
             <img src="<?php echo $DatosWeb->GetValor('web_url') ?>/imagenes/ContactoMail.gif"  alt="Logo Correo" height="25" />  
         </div>  
    </div>
    <br/>
    <br/>
    <br/>