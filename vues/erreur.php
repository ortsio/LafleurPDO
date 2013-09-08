<?php
      
if ( nbMessages($tabErreurs) > 0 ) 
{
 ?>
 <div class="container">
    <div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>Erreur !</strong> <?php echo toStringMessage($tabErreurs);?>
    </div>
 </div>            
 <?php               
}
if ( nbMessages($tabSucces) > 0 ) 
{
 ?>
 <div class="container">
    <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>Succes !</strong> <?php echo toStringMessage($tabSucces);?>
    </div>
 </div>            
 <?php               
}


?>
