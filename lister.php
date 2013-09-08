<?php
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Rechercher"
 * @package default
 * @todo  RAS
 */
 
  $repInclude = './include/';
  $repVues = './vues/';
  
  require($repInclude . "_init.inc.php");
 
  $cat="";
  if (isset($_GET['categ']))
  {
  $cat = $_GET['categ'];
  }  
  $lafleur = $pdo->getFleurs($cat);
  
  // Construction de la page Rechercher
  // pour l'affichage (appel des vues)
  include($repVues."entete.php") ;
  include($repVues."menu.php") ;
  include($repVues."vFleurs.php");
  include($repVues."pied.php") ;
  ?>
    
