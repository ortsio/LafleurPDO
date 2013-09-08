<?php
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Ajouter"
 * @package default
 * @todo  RAS
 */
 
$repInclude = './include/';
$repVues = './vues/';

require($repInclude . "_init.inc.php");
  
$uneRef=lireDonneePost("ref", "");
$uneDes=lireDonneePost("des", "");
$unPrix=lireDonneePost("prix", "");
$uneImage=lireDonneePost("image", "");
$uneCat=lireDonneePost("cat", "");

if (count($_POST)==0)
{
  $etape = 1;
}
else
{
  $etape = 2;
  $lafleur = $pdo->ajouter($uneRef, $uneDes, $unPrix, $uneImage, $uneCat,$tabErreurs,$tabSucces);
}

// Construction de la page Rechercher
// pour l'affichage (appel des vues)
include($repVues."entete.php") ;
include($repVues."menu.php") ;
include($repVues ."erreur.php");
include($repVues."vAjouterForm.php") ;
include($repVues."pied.php") ;
?>
  
