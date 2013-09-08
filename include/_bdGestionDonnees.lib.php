<?php

// MODIFs A FAIRE
// Ajouter en têtes 
// Voir : jeu de caractères à la connection

/** 
 * Se connecte au serveur de données MySql.                      
 * Se connecte au serveur de données MySql à partir de valeurs
 * prédéfinies de connexion (hôte, compte utilisateur et mot de passe). 
 * Retourne l'identifiant de connexion si succès obtenu, le booléen false 
 * si problème de connexion.
 * @return resource identifiant de connexion
 */
function connecterServeurBD() {
    $hote = "localhost";
    $login = "root";
    $mdp = "";
    return mysql_connect($hote, $login, $mdp);
}

/**
 * Sélectionne (rend active) la base de données.
 * Sélectionne (rend active) la BD prédéfinie gsb_frais sur la connexion
 * identifiée par $idCnx. Retourne true si succès, false sinon.
 * @param resource $idCnx identifiant de connexion
 * @return boolean succès ou échec de sélection BD 
 */
function activerBD($idCnx) {
    $bd = "baseLafleur1";
    $query = "SET CHARACTER SET utf8";
    // Modification du jeu de caractères de la connexion
    // $res = mysql_query($query, $idCnx); 
    $ok = mysql_select_db($bd, $idCnx);
    return $ok;
}

/** 
 * Ferme la connexion au serveur de données.
 * Ferme la connexion au serveur de données identifiée par l'identifiant de 
 * connexion $idCnx.
 * @param resource $idCnx identifiant de connexion
 * @return void  
 */
function deconnecterServeurBD($idCnx) {
    mysql_close($idCnx);
}


function ajouter($ref, $des, $prix, $image, $cat,&$tabErr)
{
  // Ouvrir une connexion au serveur mysql en s'identifiant
  $idConnexion = connecterServeurBD();
  
  // Si la connexion au SGBD à réussi
  if ($idConnexion) 
  {
    // sélectionner la base de donnée
    activerBD($idConnexion);
    
    // Vérifier que la référence saisie n'existe pas déja
    $requete="select * from produit";
    $requete=$requete." where pdt_ref = '".$ref."';"; 
    $jeuResultat=mysql_query($requete,$idConnexion);
    $ligne=mysql_fetch_assoc($jeuResultat);
    if($ligne)
    {
      $message="Echec de l'ajout : la référence existe déjà !";
      ajouterErreur($tabErr, $message);
 
    }
    else
    {
      // Créer la requête d'ajout 
       $requete="insert into produit"
       ."(pdt_ref,pdt_designation,pdt_prix,pdt_image, pdt_categorie) values ('"
       .$ref."','"
       .$des."',"
       .$prix.",'"
       .$image."','"
       .$cat."');";
       
        // Lancer la requête d'ajout 
        $ok= mysql_query($requete,$idConnexion);
        
        // Si la requête a réussi
        if ($ok)
        {
          $message = "La fleur a été correctement ajoutée";
          ajouterErreur($tabErr, $message);
        }
        else
        {
          $message = "Attention, l'ajout de la fleur a échoué !!!";
          ajouterErreur($tabErr, $message);
        } 

    }
    // fermer la connexion
    deconnecterServeurBD($idConnexion);
  }
  else
  {
    $message = "problème à la connexion <br />";
    ajouterErreur($tabErr, $message);
  }
}

function modifier($ref, $des, $prix, $image, $cat,&$tabErr)
{
  // Ouvrir une connexion au serveur mysql en s'identifiant
  $idConnexion = connecterServeurBD();
  
  // Si la connexion au SGBD à réussi
  if ($idConnexion) 
  {
    // sélectionner la base de donnée
    activerBD($idConnexion);

    // Créer la requête de modification 

    $requete ="update produit set pdt_designation ='".$des.
      "',pdt_prix=".$prix.
      ",pdt_image='".$image.
      "',pdt_categorie='".$cat.
      "' where pdt_ref='".$ref."';";
       
        // Lancer la requête de modification
        $ok= mysql_query($requete,$idConnexion);
        
        // Si la requête a réussi
        if ($ok)
        {
          $message = "La modification a été effectuée.";
          ajouterErreur($tabErr, $message);
        }
        else
        {
          $message = "Attention, la modification de la fleur a échoué !!!";
          ajouterErreur($tabErr, $message);
        } 

  
    // fermer la connexion
    deconnecterServeurBD($idConnexion);
  }
  else
  {
    $message = "problème à la connexion <br />";
    ajouterErreur($tabErr, $message);
  }
}


function inscrire($nom, $mdp,&$tabErr)
{

   // Ouvrir une connexion au serveur mysql en s'identifiant
  $idConnexion = connecterServeurBD();
  
  // Si la connexion au SGBD à réussi
  if ($idConnexion) 
  {
    // sélectionner la base de donnée
    activerBD($idConnexion);
    
    
    // Vérifier que le nom saisi n'existe pas déja
    $requete="select * from utilisateur";
    $requete=$requete." where nom = '".$nom."';"; 
    $jeuResultat=mysql_query($requete,$idConnexion);
    $ligne=mysql_fetch_assoc($jeuResultat);
    if($ligne)
    {
      $message="Echec de l'inscription : le nom existe déjà !";
      ajouterErreur($tabErr, $message);
 
    }
    else
    {
      // Créer la requête d'ajout      
       $requete="insert into utilisateur"
       ."(nom,mdp,cat) values ('"
       .$nom."','"
       .$mdp."','client');";
       
        // Lancer la requête d'ajout 
        $ok= mysql_query($requete,$idConnexion);
        
        // Si la requête a réussi
        if ($ok)
        {
          $message = "Inscription effectuée";
          ajouterErreur($tabErr, $message);
        }
        else
        {
          $message = "Attention, l'inscription a échoué !!!";
          ajouterErreur($tabErr, $message);
        } 

    }
    // fermer la connexion
    deconnecterServeurBD($idConnexion);
  }
  else
  {
    $message = "problème à la connexion <br />";
    ajouterErreur($tabErr, $message);
  }
}



function identifier($nom, $mdp,&$tabErr)
{
  
  // Initialisation de l'identification a échec
  $ligne = false;

   // Ouvrir une connexion au serveur mysql en s'identifiant
  $idConnexion = connecterServeurBD();
  
  // Si la connexion au SGBD à réussi
  if ($idConnexion) 
  {
    // sélectionner la base de donnée
    activerBD($idConnexion);
    
    
    // Vérifier que nom et login existent
    $requete="select * from utilisateur where nom ='".$nom."' and mdp ='".$mdp."' ;";
 
    $jeuResultat=mysql_query($requete,$idConnexion);
    $ligne=mysql_fetch_assoc($jeuResultat);
    if($ligne)
    {
        // identification réussie
    }
    else
    {
      $message = "Echec de l'identification !!!";
      ajouterErreur($tabErr, $message);
    }
    // fermer la connexion
    deconnecterServeurBD($idConnexion);
  }
  else
  {
    $message = "problème à la connexion <br />";
    ajouterErreur($tabErr, $message);
  }
  // renvoyer les informations d'identification si réussi
  return $ligne;
}

function rechercherRef($uneRef,$tabErreurs)
{
  $fleur=array(1);
  
  $idConnexion = connecterServeurBD();
  
  // Si la connexion au SGBD à réussi
  if ($idConnexion) 
  {
    // sélectionner la base de donnée
    activerBD($idConnexion);
   
    // Création de la requête
    $requete="select * from produit";
    $requete=$requete." where pdt_ref = '".$uneRef."';"; 
    $jeuResultat=mysql_query($requete,$idConnexion);
    $ligne=mysql_fetch_assoc($jeuResultat);
    $i = 0;
    if($ligne)
    {
        $fleur['image']=$ligne["pdt_image"];
        $fleur['ref']=$ligne["pdt_ref"];
        $fleur['designation']=$ligne["pdt_designation"];
        $fleur['prix']=$ligne["pdt_prix"];
        $fleur['categorie']=$ligne["pdt_categorie"];
    }
    // fermer la connexion
    deconnecterServeurBD($idConnexion);
  }
  return $fleur;
}

function supprimer($ref,&$tabErr)
{
  $idConnexion = connecterServeurBD();
  
  // Si la connexion au SGBD à réussi
  if ($idConnexion) 
  {
    // sélectionner la base de donnée
    activerBD($idConnexion);
   
    // Vérifier que la référence existe
     $requete="select * from produit";
    $requete=$requete." where pdt_ref = '".$ref."';"; 
    $jeuResultat=mysql_query($requete,$idConnexion);
    $nb_lignes=mysql_num_rows($jeuResultat);
    
    // Si la référence n'existe pa, la supression n'est pas possible
    if($nb_lignes==0)
    {
      $message= "Echec de la suppression : la référence n'existe pas !";
      ajouterErreur($tabErr, $message);
    }    
    else
    {
       // Créer la requête de suppression 
       $requete ="delete from produit where pdt_ref='".$_POST["ref"]."';";  
   
      // Lancer la requête de suppression 
      $ok= mysql_query($requete,$idConnexion);
      
      // Si la requête a réussi
      if ($ok)
      {
        $message= "La fleur a bien été supprimée";
         ajouterErreur($tabErr, $message);
       }
      else
      {
        $message= "Attention, la suppression de la fleur a échoué !";
        ajouterErreur($tabErr, $message);
      }

    }
    // fermer la connexion
    deconnecterServeurBD($idConnexion);
  }
  else
  {
    $message = "problème à la connexion <br />";
    ajouterErreur($tabErr, $message);
  }
}


function rechercherDes($description)
{

  $fleur=array();
  $idConnexion = connecterServeurBD(); 

  // Si la connexion au SGBD à réussi
  if ($idConnexion) 
  {
    // sélectionner la base de donnée
    activerBD($idConnexion);
         
    $requete="select * from produit";
    $requete=$requete." where pdt_designation like '%".$description."%';"; 
    $jeuResultat=mysql_query($requete,$idConnexion);
    $ligne=mysql_fetch_assoc($jeuResultat);
    $i = 0;
    while($ligne)
    {
        $fleur[$i]['image']=
                  $ligne["pdt_image"];
        $fleur[$i]['ref']=$ligne["pdt_ref"];
        $fleur[$i]['designation']=$ligne["pdt_designation"];
        $fleur[$i]['prix']=$ligne["pdt_prix"];
        $ligne=mysql_fetch_assoc($jeuResultat);
        $i = $i + 1;
    }
  }
  deconnecterServeurBD($idConnexion);
  return $fleur;
}

function lister($categ)
{
  $idConnexion = connecterServeurBD();
  
  // Si la connexion au SGBD à réussi
  if ($idConnexion) 
  {
      // sélectionner la base de donnée
      activerBD($idConnexion);
           
      $requete="select * from produit";
      if ($categ!="")
      {
          $requete=$requete." where pdt_categorie='".$categ."';";
      }
      $jeuResultat=mysql_query($requete,$idConnexion);
      $ligne=mysql_fetch_assoc($jeuResultat);
      $i = 0;
      while($ligne)
      {
          $fleur[$i]['image']=$ligne["pdt_image"];
          $fleur[$i]['ref']=$ligne["pdt_ref"];
          $fleur[$i]['designation']=$ligne["pdt_designation"];
          $fleur[$i]['prix']=$ligne["pdt_prix"];
          $ligne=mysql_fetch_assoc($jeuResultat);
          $i = $i + 1;
      }
  }
  deconnecterServeurBD($idConnexion);
  return $fleur;
}


?>
