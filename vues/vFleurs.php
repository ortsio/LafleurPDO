

<!-- Affichage des informations sur les fleurs-->

<div class="container">

    <table class="table table-bordered table-striped table-condensed">
      <caption>
<?php
    if (isset($cat))
    {
?>
        <h3><?php echo $cat;?></h3>
<?php    
    }
?>
      </caption>
      <thead>
        <tr>
          <th>Image</th>
          <th>R�f�rence</th>
          <th>Libell�</th>
          <th>Prix</th>
        </tr>
      </thead>
      <tbody>  
<?php
    $i = 0;
    while($i < count($lafleur))
    { 
 ?>     
        <tr>
            <td align="center"><img class="img-polaroid" src="../images/<?php echo $lafleur[$i]["pdt_image"]?>" /></td>
            <td><?php echo $lafleur[$i]["pdt_ref"]?></td>
            <td><?php echo $lafleur[$i]["pdt_designation"]?></td>
            <td align="right"><?php echo $lafleur[$i]["pdt_prix"]?></td>
        </tr>
<?php
        $i = $i + 1;
     }
?>       
       </tbody>       
     </table>    
  </div>

 
