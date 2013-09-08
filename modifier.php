<?php
/** 
 * Script de contr�le et d'affichage du cas d'utilisation "Modifier"
 * @package default
 * @todo  RAS
 */
 
$repInclude = './include/';
$repVues = './vues/';

require($repInclude . "_init.inc.php");
  
$uneRef=lireDonneePost("ref", "");

$uneRefFin=lireDonneePost("refFin", "");
$uneDesignation=lireDonneePost("designation", "");
$unPrix=lireDonneePost("prix", "");
$uneImage=lireDonneePost("image", "");
$uneCategorie=lireDonneePost("categorie", "");

if (count($_POST)==0)
{
  $etape = 1;
}

if ($uneRef!="")
{
  // Rechercher la fleur correspondant � la r�f�rence saisie
  $lafleur=$pdo->getFleurReference($uneRef);
  
  // Si la fleur � modifier a �t� trouv�e
  if (count($lafleur)>1)
  {
    $etape = 2;
  }
  else
  {
    $message="Echec de la modification : la r�f�rence n'a pas �t� trouv�e !";
    ajouterMessage($tabErreurs, $message); 
    $etape = 1;
  }
}

if ($uneRefFin!="")
{
    $etape = 3;
    $lafleur=$pdo->modifier($uneRefFin, $uneDesignation, $unPrix, 
                 $uneImage, $uneCategorie,$tabErreurs,$tabSucces);
    print_r($tabSucces);
}

echo "etape :".$etape;

// Construction de la page Modifier
// pour l'affichage (appel des vues)

include($repVues."entete.php") ;
include($repVues."menu.php") ;
include($repVues ."erreur.php");

switch ($etape)
{
  case 1 :
   include($repVues."vModifierRefForm.php");
   break;
  case 2 :
   include($repVues."vModifierForm.php");
   break;
}
include($repVues."pied.php") ;
?>
  
