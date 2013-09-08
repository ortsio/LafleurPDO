<?php
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Supprimer"
 * @package default
 * @todo  RAS
 */
 
$repInclude = './include/';
$repVues = './vues/';

require($repInclude . "_init.inc.php");
  
$uneRef=lireDonneePost("ref", "");

if (count($_POST)==0)
{
  $etape = 1;
}
else
{
  $etape = 2;
  $lafleur = $pdo->supprimer($uneRef,$tabErreurs,$tabSucces);
}

// Construction de la page Supprimer
// pour l'affichage (appel des vues)
include($repVues."entete.php") ;
include($repVues."menu.php") ;
include($repVues ."erreur.php");
include($repVues."vSupprimerForm.php") ;
include($repVues."pied.php") ;
?>
  
