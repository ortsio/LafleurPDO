<?php
/** 
 * Classe d'accès aux données. 
 
 * Utilise les services de la classe PDO
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{   		
      	protected static $serveur='mysql:host=localhost';
      	protected static $bdd='dbname=baseLafleur1';   		
      	protected static $user='root' ;    		
      	protected static $mdp='' ;	
		protected static $monPdo;
		protected static $monPdoGsb=null;
		protected $test='MARCHE';
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	protected function __construct(){
    	self::$monPdo = new PDO(self::$serveur.';'.self::$bdd, self::$user, self::$mdp); 
		self::$monPdo->query("SET CHARACTER SET utf8");
	}
	
	
	public function _destruct(){
		self::$monPdo = null;
	}
	
	
/**
 * Fonction statique qui crée l'unique instance de la classe
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 * @return l'unique objet de la classe PdoGsb
 */
	public static function getPdoGsb(){
		if(self::$monPdoGsb==null){
			self::$monPdoGsb= new PdoGsb();
		}
		return self::$monPdoGsb;  
	}

/**
 * Fonction qui renvoie les fleurs selon catégorie choisie
 * Toutes les fleurs sont renvoyées si aucune catégorie choisie 
 * Retourne un tableau contenant les lignes du jeu d'enregistrements
 */
	public function getFleurs($categ)
  {
      $requete="select * from produit";
      if ($categ!="")
      {
          $requete=$requete." where pdt_categorie='".$categ."';";
      }
		$rs = PdoGsb::$monPdo->query($requete);
		$ligne = $rs->fetchAll();
		return $ligne;
	}
	
 /**
 * Fonction qui renvoie les fleurs selon description choisie
 * Toutes les fleurs sont renvoyées si la description est vide
 * Retourne un tableau contenant les lignes du jeu d'enregistrements
 */
	public function getFleursDes($description)
  {
    $requete="select * from produit";
    $requete=$requete." where pdt_designation like '%".$description."%';"; 
	  $rs = PdoGsb::$monPdo->query($requete);
		$ligne = $rs->fetchAll();
		return $ligne;
	}
	
 /**
 * Fonction qui renvoie la fleurs selon référence choisie
 * Retourne une ligne du jeu d'enregistrements ou FALSE si référence pas trouvée
 */
	public function getFleurReference($reference)
  {
    $requete="select * from produit where pdt_ref = '$reference';"; 
	  $rs = PdoGsb::$monPdo->query($requete);
		$ligne = $rs->fetch(PDO::FETCH_ASSOC);
		return $ligne;
	} 

  /**
   * Fonction qui ajoute une fleur avec les valeurs passées en paramètre
   * Des messages sont créés pour indiquer la réussite ou les erreurs  
   */
  	
  function ajouter($ref, $des, $prix, $image, $cat,&$tabErr,&$tabOk)
  {
      // Vérifier que la référence saisie n'existe pas déja
      $requete="select * from produit";
      $requete=$requete." where pdt_ref = '".$ref."';"; 
   
   		$rs = PdoGsb::$monPdo->query($requete);
   		
		  //Extraire une ligne
      $ligne = $rs->fetch();
  
      if($ligne)
      {
        $message="Echec de l'ajout : la référence existe déjà !";
        ajouterMessage($tabErr, $message);
      }
      else
      {
        // Créer la requête d'ajout        
         $requete="insert into produit
           (
            pdt_ref,
            pdt_designation,
            pdt_prix,
            pdt_image, 
            pdt_categorie
           ) 
            values
           (       
            '$ref',
            '$des',
            '$prix',
            '$image',
            '$cat'
           )
           ";
           
          // Lancer la requête d'ajout 
  		    $exec = PdoGsb::$monPdo->exec($requete);
            
          // Si la requête a réussi (1 Ligne ajoutée)
          if ($exec==1)
          {
            $message = "La fleur a été correctement ajoutée";
            ajouterMessage($tabOk, $message);
          }
          else
          {
            $message = "Attention, l'ajout de la fleur a échoué !!!";
            ajouterMessage($tabErr, $message);
          } 
      }
      // fermer la connexion
  }	


  /**
   * Fonction qui ajoute une fleur avec les valeurs passées en paramètre
   * Des messages sont créés pour indiquer la réussite ou les erreurs  
   */

  function identifier($nom, $mdp,&$tabErr)
  {
    
    // Initialisation de l'identification a échec
    $ligne = false;
      
    // Vérifier que nom et login existent
    $requete="select * from utilisateur where nom ='".$nom."' and mdp ='".$mdp."' ;";

    // Envoyer la requete au SGBD
		$rs = PdoGsb::$monPdo->query($requete);
		
		//Extraire une ligne
    $ligne = $rs->fetch(PDO::FETCH_ASSOC);

    if($ligne)
    {
      // identification réussie
    }
    else
    {
      $message = "Echec de l'identification !!!";
      ajouterMessage($tabErr, $message);
    }
    // fermer la connexion
   
    // renvoyer les informations d'identification si réussi
    return $ligne;
  }


  /**
   * Fonction qui supprime la fleur dont la référence est passée en paramètre
   * Des messages sont créés pour indiquer la réussite ou les erreurs  
   */

   function modifier($ref, $des, $prix, $image, $cat,&$tabErr,&$tabOk)
   {
     // Créer la requête de modification 
     $requete ="update produit set 
        pdt_designation ='$des',
        pdt_prix='$prix',
        pdt_image='$image',
        pdt_categorie='$cat' 
     where 
        pdt_ref='$ref'
     ";             

     // Envoyer la requête au SGBD
     $exec = PdoGsb::$monPdo->exec($requete);
   
      // Si la requête a réussi
      if ($exec)
      {
        $message = "La modification a été effectuée.";
        ajouterMessage($tabOk, $message);
      }
      else
      {
        $message = "Attention, la modification de la fleur a échoué !!!";
        ajouterMessage($tabErr, $message);
      } 
  
    // fermer la connexion
  }

  /**
   * Fonction qui supprime la fleur dont la référence est passée en paramètre
   * Des messages sont créés pour indiquer la réussite ou les erreurs  
   */
 
  function supprimer($ref,&$tabErr,&$tabOk)
  {   
    // Vérifier que la référence existe
    
    // Former une requete pour rechercher 
    // la fleur qui a cette référence
    $requete="select * from produit";
    $requete=$requete." where pdt_ref = '$ref';"; 

    // Envoyer la requete au SGBD
		$rs = PdoGsb::$monPdo->query($requete);
		
		//Extraire une ligne
    $ligne = $rs->fetch(PDO::FETCH_ASSOC);
    
    // Si la référence n'existe pas, la supression n'est pas possible
    if($ligne==FALSE)
    {
      $message= "Echec de la suppression : la référence n'existe pas !";
      ajouterMessage($tabErr, $message);
    }    
    else
    {
      // Créer la requête de suppression 
      $requete ="delete from produit where pdt_ref='$ref';";  
   
     // Envoyer la requête au SGBD
	    $exec = PdoGsb::$monPdo->exec($requete);
        
      // Si la requête a réussi (Ligne supprimée)
      if ($exec==1)
      {
        $message= "La fleur a bien été supprimée";
        ajouterMessage($tabOk, $message);
       }
      else
      {
        $message= "Attention, la suppression de la fleur a échoué !";
        ajouterMessage($tabErr, $message);
      }

    }
    // fermer la connexion 
  }

}// find ela classe

?>
