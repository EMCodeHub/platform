<table width="100%" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px">
  <tr>
    <td width="6%" rowspan="6"><img src="<?php echo $DatosWeb->GetTrimValor('web_url') ?>/imagenes/logos/<?php echo $DatosWeb->GetTrimValor('carta_logo') ?>"  height="100"></td>
    <td width="1%" rowspan="6">&nbsp;</td>
    <td width="93%">&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $DatosWeb->GetTrimValor('carta_funcionempresa') ?></td>
  </tr>
  <tr>
    <td><?php echo $DatosWeb->GetTrimValor('carta_direcc1') ?></td>
  </tr>
  <?php if (strlen($DatosWeb->GetTrimValor('carta_direcc2'))> 0 ) { ?>  
     <tr>
       <td><?php echo $DatosWeb->GetTrimValor('carta_direcc2') ?></td>
     </tr>
  <?php } ?>   
  <tr>
    <td>
    <?php if (strlen($DatosWeb->GetTrimValor('carta_codpostal'))> 0 ) { echo $DatosWeb->GetTrimValor('carta_codpostal')." - ";} ?>
    <?php echo $DatosWeb->GetTrimValor('carta_poblacion'); ?>
    <?php if (strlen($DatosWeb->GetTrimValor('carta_pais'))> 0 ) { echo " (".$DatosWeb->GetTrimValor('carta_pais').")";} ?>
    </td>
  </tr>
 
  <tr>
    <td>Teléfono: <?php echo $DatosWeb->GetTrimValor('web_tfnWhatsapp'); ?>
      <hr style="color: #0056b2;" />
    </td>
  </tr>
</table>

<br>
  
