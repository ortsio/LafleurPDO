<?php

// MODIFs A FAIRE
// Ajouter en t�tes 
// Voir : jeu de caract�res � la connection

/** 
 * Se connecte au serveur de donn�es MySql.                      
 * Se connecte au serveur de donn�es MySql � partir de valeurs
 * pr�d�finies de connexion (h�te, compte utilisateur et mot de passe). 
 * Retourne l'identifiant de connexion si succ�s obtenu, le bool�en false 
 * si probl�me de connexion.
 * @return resource identifiant de connexion
 */
function connecterServeurBD() {
    $hote = "localhost";
    $login = "root";
    $mdp = "";
    return mysql_connect($hote, $login, $mdp);
}

/**
 * S�lectionne (rend active) la base de donn�es.
 * S�lectionne (rend active) la BD pr�d�finie gsb_frais sur la connexion
 * identifi�e par $idCnx. Retourne true si succ�s, false sinon.
 * @param resource $idCnx identifiant de connexion
 * @return boolean succ�s ou �chec de s�lection BD 
 */
function activerBD($idCnx) {
    $bd = "baseLafleur1";
    $query = "SET CHARACTER SET utf8";
    // Modification du jeu de caract�res de la connexion
    // $res = mysql_query($query, $idCnx); 
    $ok = mysql_select_db($bd, $idCnx);
    return $ok;
}

/** 
 * Ferme la connexion au serveur de donn�es.
 * Ferme la connexion au serveur de donn�es identifi�e par l'identifiant de 
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
  
  // Si la connexion au SGBD � r�ussi
  if ($idConnexion) 
  {
    // s�lectionner la base de donn�e
    activerBD($idConnexion);
    
    // V�rifier que la r�f�rence saisie n'existe pas d�ja
    $requete="select * from produit";
    $requete=$requete." where pdt_ref = '".$ref."';"; 
    $jeuResultat=mysql_query($requete,$idConnexion);
    $ligne=mysql_fetch_assoc($jeuResultat);
    if($ligne)
    {
      $message="Echec de l'ajout : la r�f�rence existe d�j� !";
      ajouterErreur($tabErr, $message);
 
    }
    else
    {
      // Cr�er la requ�te d'ajout 
       $requete="insert into produit"
       ."(pdt_ref,pdt_designation,pdt_prix,pdt_image, pdt_categorie) values ('"
       .$ref."','"
       .$des."',"
       .$prix.",'"
       .$image."','"
       .$cat."');";
       
        // Lancer la requ�te d'ajout 
        $ok= mysql_query($requete,$idConnexion);
        
        // Si la requ�te a r�ussi
        if ($ok)
        {
          $message = "La fleur a �t� correctement ajout�e";
          ajouterErreur($tabErr, $message);
        }
        else
        {
          $message = "Attention, l'ajout de la fleur a �chou� !!!";
          ajouterErreur($tabErr, $message);
        } 

    }
    // fermer la connexion
    deconnecterServeurBD($idConnexion);
  }
  else
  {
    $message = "probl�me � la connexion <br />";
    ajouterErreur($tabErr, $message);
  }
}

function modifier($ref, $des, $prix, $image, $cat,&$tabErr)
{
  // Ouvrir une connexion au serveur mysql en s'identifiant
  $idConnexion = connecterServeurBD();
  
  // Si la connexion au SGBD � r�ussi
  if ($idConnexion) 
  {
    // s�lectionner la base de donn�e
    activerBD($idConnexion);

    // Cr�er la requ�te de modification 

    $requete ="update produit set pdt_designation ='".$des.
      "',pdt_prix=".$prix.
      ",pdt_image='".$image.
      "',pdt_categorie='".$cat.
      "' where pdt_ref='".$ref."';";
       
        // Lancer la requ�te de modification
        $ok= mysql_query($requete,$idConnexion);
        
        // Si la requ�te a r�ussi
        if ($ok)
        {
          $message = "La modification a �t� effectu�e.";
          ajouterErreur($tabErr, $message);
        }
        else
        {
          $message = "Attention, la modification de la fleur a �chou� !!!";
          ajouterErreur($tabErr, $message);
        } 

  
    // fermer la connexion
    deconnecterServeurBD($idConnexion);
  }
  else
  {
    $message = "probl�me � la connexion <br />";
    ajouterErreur($tabErr, $message);
  }
}


function inscrire($nom, $mdp,&$tabErr)
{

   // Ouvrir une connexion au serveur mysql en s'identifiant
  $idConnexion = connecterServeurBD();
  
  // Si la connexion au SGBD � r�ussi
  if ($idConnexion) 
  {
    // s�lectionner la base de donn�e
    activerBD($idConnexion);
    
    
    // V�rifier que le nom saisi n'existe pas d�ja
    $requete="select * from utilisateur";
    $requete=$requete." where nom = '".$nom."';"; 
    $jeuResultat=mysql_query($requete,$idConnexion);
    $ligne=mysql_fetch_assoc($jeuResultat);
    if($ligne)
    {
      $message="Echec de l'inscription : le nom existe d�j� !";
      ajouterErreur($tabErr, $message);
 
    }
    else
    {
      // Cr�er la requ�te d'ajout      
       $requete="insert into utilisateur"
       ."(nom,mdp,cat) values ('"
       .$nom."','"
       .$mdp."','client');";
       
        // Lancer la requ�te d'ajout 
        $ok= mysql_query($requete,$idConnexion);
        
        // Si la requ�te a r�ussi
        if ($ok)
        {
          $message = "Inscription effectu�e";
          ajouterErreur($tabErr, $message);
        }
        else
        {
          $message = "Attention, l'inscription a �chou� !!!";
          ajouterErreur($tabErr, $message);
        } 

    }
    // fermer la connexion
    deconnecterServeurBD($idConnexion);
  }
  else
  {
    $message = "probl�me � la connexion <br />";
    ajouterErreur($tabErr, $message);
  }
}



function identifier($nom, $mdp,&$tabErr)
{
  
  // Initialisation de l'identification a �chec
  $ligne = false;

   // Ouvrir une connexion au serveur mysql en s'identifiant
  $idConnexion = connecterServeurBD();
  
  // Si la connexion au SGBD � r�ussi
  if ($idConnexion) 
  {
    // s�lectionner la base de donn�e
    activerBD($idConnexion);
    
    
    // V�rifier que nom et login existent
    $requete="select * from utilisateur where nom ='".$nom."' and mdp ='".$mdp."' ;";
 
    $jeuResultat=mysql_query($requete,$idConnexion);
    $ligne=mysql_fetch_assoc($jeuResultat);
    if($ligne)
    {
        // identification r�ussie
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
    $message = "probl�me � la connexion <br />";
    ajouterErreur($tabErr, $message);
  }
  // renvoyer les informations d'identification si r�ussi
  return $ligne;
}

function rechercherRef($uneRef,$tabErreurs)
{
  $fleur=array(1);
  
  $idConnexion = connecterServeurBD();
  
  // Si la connexion au SGBD � r�ussi
  if ($idConnexion) 
  {
    // s�lectionner la base de donn�e
    activerBD($idConnexion);
   
    // Cr�ation de la requ�te
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
  
  // Si la connexion au SGBD � r�ussi
  if ($idConnexion) 
  {
    // s�lectionner la base de donn�e
    activerBD($idConnexion);
   
    // V�rifier que la r�f�rence existe
     $requete="select * from produit";
    $requete=$requete." where pdt_ref = '".$ref."';"; 
    $jeuResultat=mysql_query($requete,$idConnexion);
    $nb_lignes=mysql_num_rows($jeuResultat);
    
    // Si la r�f�rence n'existe pa, la supression n'est pas possible
    if($nb_lignes==0)
    {
      $message= "Echec de la suppression : la r�f�rence n'existe pas !";
      ajouterErreur($tabErr, $message);
    }    
    else
    {
       // Cr�er la requ�te de suppression 
       $requete ="delete from produit where pdt_ref='".$_POST["ref"]."';";  
   
      // Lancer la requ�te de suppression 
      $ok= mysql_query($requete,$idConnexion);
      
      // Si la requ�te a r�ussi
      if ($ok)
      {
        $message= "La fleur a bien �t� supprim�e";
         ajouterErreur($tabErr, $message);
       }
      else
      {
        $message= "Attention, la suppression de la fleur a �chou� !";
        ajouterErreur($tabErr, $message);
      }

    }
    // fermer la connexion
    deconnecterServeurBD($idConnexion);
  }
  else
  {
    $message = "probl�me � la connexion <br />";
    ajouterErreur($tabErr, $message);
  }
}


function rechercherDes($description)
{

  $fleur=array();
  $idConnexion = connecterServeurBD(); 

  // Si la connexion au SGBD � r�ussi
  if ($idConnexion) 
  {
    // s�lectionner la base de donn�e
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
  
  // Si la connexion au SGBD � r�ussi
  if ($idConnexion) 
  {
      // s�lectionner la base de donn�e
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
