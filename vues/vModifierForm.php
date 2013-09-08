<script type="text/javascript">
//<![CDATA[

function valider(){
 frm=document.forms['formAjout'];
  // si le prix est positif
  if(frm.elements['prix'].value >0) {
    // les données sont ok, on peut envoyer le formulaire    
    return true;
  }
  else {
    // sinon on affiche un message
    alert("Le prix doit être positif !");
    // et on indique de ne pas envoyer le formulaire
    return false;
  }
}
//]]>
</script>

<?php 
if (isset($message))
  {
?>
    <div class="container"><?php echo $message ?> </div>
<?php
  }
?>
 
<!--Saisir les informations dans un formulaire!-->
<div class="container">
  <form action="" method=post>
    <fieldset>
      <legend>Entrez les données sur la fleur à modifier </legend>
      <label> Référence :</label>
      <label><?php echo $lafleur["pdt_ref"]; ?> </label>
      <input type="hidden" name="refFin" value="<?php echo $lafleur["pdt_ref"]; ?>" /><br />
      <label>Désignation :</label>
      <input type="text" name="designation" value="<?php echo $lafleur["pdt_designation"]; ?>" size="20" /><br />
      <label>Prix :</label>
      <input type="text" name="prix" value="<?php echo $lafleur["pdt_prix"]; ?>" size="10" /><br />
      <label>Image :</label>
      <input type="text" name="image" value="<?php echo $lafleur["pdt_image"]; ?>" size="20"/><br />
      <label>Catégorie :</label>
      <input type="text" name="categorie" value="<?php echo $lafleur["pdt_categorie"]; ?>" size="10"/><br />
    </fieldset>
    <button type="submit" class="btn btn-primary">Modifier</button>
    <button type="reset" class="btn">Annuler</button>
    <p />
  </form> 
</div>



