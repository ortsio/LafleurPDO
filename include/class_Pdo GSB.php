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
      	protected static $bdd='dbname=dsn_swiss';   		
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
 * Fonction qui renvoi tous les medicaments
 * @return Booleen
 */
	public function getMedicaments(){
		$req = "select * from  medicament order by MED_NOMCOMMERCIAL";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetchAll();
		return $ligne;
	}


/**
 * Fonction qui renvoi un médicament
 * parametre : $id est l'identifiant du medicament selectionnee
 * @return Booleen
 */
	public function getUnMedicament($id){
		$req = "select * from  medicament where MED_DEPOTLEGAL='$id'";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}
	

/**
 * Fonction qui renvoi le visiteur passer en parametre
 * Parametre : $login est le matricule que levisiteur à rentré
 * @return Booleen
 */
	public function getVisiteur($login){
		$req = "select * from  visiteur where VIS_MATRICULE='$login'";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}
	
/**
 * Fonction qui renvoi le type du visiteur passer en parametre
 * Parametre : $isVisiteur est le matricule que levisiteur à rentré
 * @return Booleen
 */
	public function getTypeVisiteur($idVisiteur){
		$req = "select TRA_ROLE, REG_CODE from  travailler where VIS_MATRICULE='$idVisiteur'";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}
	
	
	
		public function getTypeCode(){
		$req = "select * from type_praticien";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetchAll();
		return $ligne;
	}

/**
 * Fonction qui toutes les familles de medicament
 * @return Booleen
 */
	public function getFamille(){
		$req = "select * from famille";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetchAll();
		return $ligne;
	}


/**
 * Fonction qui renvoi un tableau de tout les visiteurs
 * @return Booleen
 */
	public function getListeVisiteurs(){
		$req = "select * from  visiteur order by VIS_MATRICULE";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetchAll();
		return $ligne;
	}
	
/**
 * Fonction qui renvoi un tableau de tout les visiteurs
 * @return Booleen
 */
	public function getListeSousVisiteurs($reg){
		$req = "select distinct REG_CODE,v.VIS_MATRICULE as visiteurmat, v.VIS_NOM as nom from  visiteur v, travailler t where t.TRA_ROLE ='visiteur' and REG_CODE='$reg' order by v.VIS_MATRICULE";
		$rs = PdoGsb::$monPdo->query($req);
		return $rs;
	}
	
/**
 * Fonction qui renvoi un tableau de tout les praticiens
 * @return Booleen
 */
	public function getListePraticiens(){
		$req = "select * from praticien order by PRA_NOM";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetchAll();
		return $ligne;
	}
	
/**
 * Fonction qui renvoi un praticien
 * @return Booleen
 */
	public function getUnPraticien($id){
		$req = "select * from praticien where PRA_NUM='$id' ";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}
	

/**
 * Fonction qui renvoi tout les  comptes rendu
 * @return Booleen
 */
	public function getLesCompteRendu($id){
		$req = "select r.rap_num as rapportnum,r.pra_num,p.pra_nom as nomprat ,r.rap_date as daterapport from  rapport_visite r, praticien p where VIS_MATRICULE='$id' and r.pra_num=p.pra_num order by r.rap_date";
		$rs = PdoGsb::$monPdo->query($req);
		return $rs;
	}	

/**
 * Fonction qui renvoi un compte rendu
 * @return Booleen
 */
	public function getUnCompteRendu($id){
		$req = "select * from  praticien P,rapport_visite R, visiteur V where R.RAP_NUM='$id' and P.PRA_NUM=R.PRA_NUM and r.vis_matricule = v.vis_matricule";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}
	












	/**
 * Fonction qui renvoi les 8 derniers compte rendu
 * @return Booleen
 */
	public function getDerniersComptesRendus($id){
		$req = "select R.RAP_DATE, P.PRA_NOM, P.PRA_PRENOM, P.PRA_NUM from  praticien P,rapport_visite R where R.VIS_MATRICULE='".$id."' and P.PRA_NUM=R.PRA_NUM LIMIT 0, 8;";
		$rs = PdoGsb::$monPdo->query($req);
		
		//$ligne = $rs->fetch();
		//return $ligne;
		return $rs;
	}

	/**
 * Fonction qui renvoi les 8 visiteurs ayant effectué le plus de visites (dans le mois courant)
 * @return Booleen
 */
	public function getTopVisiteurs(){
		$req = "SELECT COUNT( R.RAP_NUM ) AS VISITES, VIS_NOM, VIS_PRENOM FROM rapport_visite R, visiteur V WHERE R.VIS_MATRICULE = V.VIS_MATRICULE GROUP BY R.VIS_MATRICULE order by VISITES DESC LIMIT 0 , 8";
		$rs = PdoGsb::$monPdo->query($req);
		
		//$ligne = $rs->fetch();
		//return $ligne;
		return $rs;
	}
	
/** 
 * Fonction qui insere un compte rendu dans la base
 * @return Booleen
 */
	public function ajouterCR($VIS_MATRICULE,$PRA_NUM, $RAP_DATE, $RAP_MOTIF, $RAP_BILAN, $PROD1, $PROD2, $RAP_DOC, $RAP_LOCK,$PRA_REMPLACANT)
		
		{
	
			$requete=  "Insert into rapport_visite (VIS_MATRICULE, PRA_NUM,RAP_DATE,RAP_BILAN,RAP_MOTIF,PROD1, PROD2, RAP_DOC, RAP_LOCK,PRA_REMPLACANT) values ('".$VIS_MATRICULE."','".$PRA_NUM."','".$RAP_DATE."','".$RAP_BILAN."','".$RAP_MOTIF."','".$PROD1."','".$PROD2."','".$RAP_DOC."','".$RAP_LOCK."','".$PRA_REMPLACANT."')";		
			PdoGsb::$monPdo->exec($requete);
			$idRapport=PdoGsb::$monPdo->lastInsertId();

			return $idRapport ;
		}
		
	public function ajouterEchantillon($VIS_MATRICULE,$RAP_NUM, $MED_DEPOTLEGAL, $OFF_QTE)
		{
			$requete=  "Insert into offrir (VIS_MATRICULE, RAP_NUM,MED_DEPOTLEGAL,OFF_QTE) values ('".$VIS_MATRICULE."','".$RAP_NUM."','".$MED_DEPOTLEGAL."','".$OFF_QTE."')";
			PdoGsb::$monPdo->exec($requete);
		
		}
	
	public function getListeMedOfferts(){
		$req = "Select sum(OFF_QTE) as total ,offrir.MED_DEPOTLEGAL, MED_NOMCOMMERCIAL from offrir, medicament where offrir.MED_DEPOTLEGAL=medicament.MED_DEPOTLEGAL group by MED_DEPOTLEGAL";
		$rs = PdoGsb::$monPdo->query($req);
		return $rs;
	}
	
	public function getTopMedOfferts(){
		$req = "Select sum(OFF_QTE) as total ,offrir.MED_DEPOTLEGAL, MED_NOMCOMMERCIAL from offrir, medicament where offrir.MED_DEPOTLEGAL=medicament.MED_DEPOTLEGAL group by MED_DEPOTLEGAL order by total desc LIMIT 0, 8";
		$rs = PdoGsb::$monPdo->query($req);
		return $rs;
	}
	
	
/**
 * Fonction ajoute un medicament
 * Paramètre : 
 * @return Booleen
 */		
	public function ajouterMedicament($MED_DEPOTLEGAL,
									$MED_NOMCOMMERCIAL,
									$FAM_CODE,
									$MED_COMPOSITION,
									$MED_EFFETS,
									$MED_CONTREINDIC,
									$MED_PRIXECHANTILLON){
				
		$req = "INSERT INTO medicament (
				`MED_DEPOTLEGAL` ,
				`MED_NOMCOMMERCIAL` ,
				`FAM_CODE` ,
				`MED_COMPOSITION` ,
				`MED_EFFETS` ,
				`MED_CONTREINDIC` ,
				`MED_PRIXECHANTILLON` 
				)
				VALUES (
				'$MED_DEPOTLEGAL', 
				'$MED_NOMCOMMERCIAL',  
				'$FAM_CODE',  
				'$MED_COMPOSITION',  
				'$MED_EFFETS',  
				'$MED_CONTREINDIC',
				'$MED_PRIXECHANTILLON'
				)   
				";
		$exec = PdoGsb::$monPdo->exec($req);
		return true;
	}
	
	public function ajouterPraticien($PRA_NOM,
									$PRA_PRENOM,
									$PRA_ADRESSE,
									$PRA_CP,
									$PRA_VILLE,
									$PRA_COEFNOTORIETE,
									$TYP_CODE){
				
		$req = "INSERT INTO praticien (
				PRA_NOM,
				PRA_PRENOM,
				PRA_ADRESSE,
				PRA_CP,
				PRA_VILLE,
				PRA_COEFNOTORIETE,
				TYP_CODE 
				)
				VALUES (
				'$PRA_NOM',
				'$PRA_PRENOM',
				'$PRA_ADRESSE',
				'$PRA_CP',
				'$PRA_VILLE',
				'$PRA_COEFNOTORIETE',
				'$TYP_CODE'
				
				)   
				";
				
		$exec = PdoGsb::$monPdo->exec($req);
		
		return true;
	}
	


	
	
}
?>
