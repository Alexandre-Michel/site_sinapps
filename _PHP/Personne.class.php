<?php

require_once 'myPDO.include.php';

/**
 * Classe d'Exception concernant les connexions de la Classe Utilisateur
 */
class AuthenticationException extends Exception { }

/**
 * Classe d'Exception concernant les récupération de la Classe Utilisateur dans les données de session
 */
class NotInSessionException extends Exception { }

/**
 * Classe d'Exception concernant le démarrage d'une session
 */
class SessionException extends Exception { }


class Personne {
	private $id_personne = null;

	private $id_habilitation_pers = null;

	private $id_entreprise_pers = null;

	private $nom_personne = null;

	private $prenom_personne = null;

	private $mail_personne = null;

	private $emploi_personne = null;

	private $image_personne = null;

	const session_key = "__user__";

	private function __construct() {

	}

	public function getIdPers() {
		return $this->id_personne;
	}

	public function getIdHabilitation() {
		return $this->id_habilitation_pers;
	}

	public function getIdEntpPers() {
		return $this->id_entreprise_pers;
	}

	public function getNomPers() {
		return $this->nom_personne;
	}

	public function getPrenomPers() {
		return $this->prenom_personne;
	}

	public function getMailPers() {
		return $this->mail_personne;
	}

	public function getEmploiPers() {
		return $this->emploi_personne;
	}

	public function getImagePers() {
		return $this->image_personne;
	}

	public static function getPersByIdEntp($id_entp) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM PERSONNE
			WHERE id_entreprise_pers = :id_entp
SQL
		);	
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);	
		$stmt->bindValue(":id_entp", $id_entp);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public static function getPersByIdHab($id_hab) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM PERSONNE
			WHERE id_habilitation = :id_hab
SQL
		);	
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);	
		$stmt->bindValue(":id_hab", $id_hab);
		$stmt->execute();
		return $stmt->fetchAll();
	}

















	public static function getCurrentUser() {
		if(self::isConnected()) {
			return self::createPersFromId($_SESSION["Personne"]->getIdPers());
		}
		else {
			return null;
		}
	}





	/*private static function startSession() {
		session_status();
		if (headers_sent()) {
			throw new Exception ("Impossible de démarrer la session : Headers déjà envoyés");
		}
		else if (session_status() == PHP_SESSION_NONE) {
			session_start();
			try {
				$user = self::getCurrentUser();
			}
			catch (Exception $e) {
				$e->getMessage();
				//self::logout();
			}
		}
	}*/


    /**
     * Forumlaire de déconnexion de l'utilisateur
     * @param string $text texte du bouton de déconnexion
     * @param string $action URL cible du formulaire
     *
     * @return void
     */
    public static function logoutForm($text, $action) {
        $text = htmlspecialchars($text, ENT_COMPAT, 'utf-8') ;
        return <<<HTML
    <form action='$action' method='POST'>
    <input type='submit' value="$text" name='logout'>
    </form>
HTML;
    }

    /**
     * Déconnecter l'utilisateur
     *
     * @return void
     */
    public static function logoutIfRequested() {
        if (isset($_REQUEST['logout'])) {
            self::startSession() ;
            unset($_SESSION[self::session_key]) ;
        }
    }
	
	   /**
     * Un utilisateur est-il connecté ?
     *
     * @return bool connecté ou non
     */
    static public function isConnected() {
        self::startSession() ;
        return (isset($_SESSION[self::session_key]['connected']) && $_SESSION[self::session_key]['connected']) || (isset($_SESSION[self::session_key]['user']) && $_SESSION[self::session_key]['user'] instanceof User) ;
    }

    /**
     * Sauvegarde de l'objet Utilisateur dans la session
     *
     * @return void
     */
    public function saveIntoSession() {
        // Mise en place de la session
        self::startSession() ;
        // Mémorisation de l'Utilisateur
        $_SESSION[self::session_key]['user'] = $this ;
    }

	/**
     * Lecture de l'objet User dans la session
     * @throws NotInSessionException si l'objet n'est pas dans la session
     *
     * @return User
     */
    static public function createFromSession() {
        // Mise en place de la session
        self::startSession() ;
        // La variable de session existe ?
        if (isset($_SESSION[self::session_key]['user'])) {
            // Lecture de la variable de session
            $u = $_SESSION[self::session_key]['user'] ;
            // Est-ce un objet et un objet du bon type ?
            if (is_object($u) && get_class($u) == get_class()) {
                // OUI ! on le retourne
                return $u ;
            }
        }
        // NON ! exception NotInSessionException
        throw new NotInSessionException() ;
   }

   /**
    * Démarrer une session
    * @throws SessionException si la session ne peut être démarrée
    *
    * @return void
    */
    static protected function startSession($minutes = 0) {
        // Vision la plus contraignante et donc la plus fiable
        // Si les en-têtes ont deja été envoyés, c'est trop tard...
        if (headers_sent())
            throw new SessionException("Impossible de démarrer une session si les en-têtes HTTP ont été envoyés") ;
        // Si la session n'est pas demarrée, le faire
        if (!session_id()) session_start() ;

        // Vision la moins contraignante qui peut amener des comportements changeants
        // Si la session n'est pas demarrée, le faire
        /*
        if (!session_id()) {
            // Si les en-têtes ont deja été envoyés, c'est trop tard...
            if (headers_sent())
                throw new Exception("Impossible de démarrer une session si les en-têtes HTTP ont été envoyés") ;
            // Démarrer la session
            session_start() ;
        }
        */
   }






	public static function checkConnected() {
		if(!self::isConnected()) {
			echo "<script>window.alert('Hello')</script>";
			header("location: ./connexion.php");
			exit;
		}
	}











	public function setIdHabilitation($id_habilitation) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE PERSONNE
			SET id_habilitation = :id_hab
			WHERE id_personne = :id_pers
SQL
		);	
		$stmt->bindValue(":id_hab", $id_habilitation);
		$stmt->bindValue(":id_pers", $this->id_pers);
		$stmt->execute();		
	}


	public function setIdEntreprise($id_entreprise) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE PERSONNE
			SET id_entreprise_pers = :id_entp
			WHERE id_personne = :id_pers
SQL
		);	
		$stmt->bindValue(":id_entp", $id_entreprise);
		$stmt->bindValue(":id_pers", $this->id_pers);
		$stmt->execute();		
	}


	public function setNomPers($nom) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE PERSONNE
			SET nom_personne = :nom_pers
			WHERE id_personne = :id_pers
SQL
		);	
		$stmt->bindValue(":nom_pers", $nom);
		$stmt->bindValue(":id_pers", $this->id_pers);
		$stmt->execute();		
	}


	public function setPrenomPers($nom) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE PERSONNE
			SET nom_personne = :pnom_pers
			WHERE id_personne = :id_pers
SQL
		);	
		$stmt->bindValue(":pnom_pers", $nom);
		$stmt->bindValue(":id_pers", $this->id_pers);
		$stmt->execute();		
	}


	public function setMailPers($mail) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE PERSONNE
			SET mail_personne = :mail_pers
			WHERE id_personne = :id_pers
SQL
		);	
		$stmt->bindValue(":mail_pers", $mail);
		$stmt->bindValue(":id_pers", $this->id_pers);
		$stmt->execute();		
	}

	public function setEmploiPers($emploi) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE PERSONNE
			SET emploi_personne = :emploi_pers
			WHERE id_personne = :id_pers
SQL
		);	
		$stmt->bindValue(":emploi_pers", $emploi);
		$stmt->bindValue(":id_pers", $this->id_pers);
		$stmt->execute();		
	}

	public function setImagePers($image) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE PERSONNE
			SET image_personne = :image_pers
			WHERE id_personne = :id_pers
SQL
		);	
		$stmt->bindValue(":image_pers", $image);
		$stmt->bindValue(":id_pers", $this->id_pers);
		$stmt->execute();		
	}


















	public static function createFromAuth(array $data) {
		if (!isset($data['mail']) || !isset($data['pass'])) {
			throw new Exception("Pas de login/mdp");
		}

		$pdo = myPDO::getInstance();
		$stmt = $pdo->prepare(<<<SQL
			SELECT * 
			FROM PERSONNE
			WHERE mail_personne = :mail_pers
			AND mdp_personne = :mdp_pers
SQL
		);
		$stmt->execute(array(':mail_pers' => $data['mail'], ':mdp_pers' => $data['pass']));
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		if(($user = $stmt->fetch()) !== false) {
			self::startSession();
			$_SESSION[self::session_key]['connected'] = true;
			return $user;
		}
		else {
			throw new Exception("Pas de login/mdp 22");
		}
	}


	public static function createPersFromId($id) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM PERSONNE
			WHERE id_personne = :id
SQL
		);	
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);	
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		if (($pers = $stmt->fetch()) !== false ) {
			return $pers;
		}	
		throw new Exception("Personne not found");
	}


	public static function createPersonne($nom, $prenom, $mail, $pass, $habilitation = 1) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			INSERT INTO PERSONNE (nom_personne, prenom_personne, mail_personne, mdp_personne, id_habilitation)
			VALUES (:nom_pers, :pnom_pers, :mail_pers, :mdp_pers, :hab_pers)
SQL
		);
		$stmt->bindValue(":nom_pers", $nom);	
		$stmt->bindValue(":pnom_pers", $prenom);
		$stmt->bindValue(":mail_pers", $mail);
		$stmt->bindValue(":mdp_pers", sha1($pass));
		$stmt->bindValue(":hab_pers", $habilitation);
		$stmt->execute();		

	}


	public static function deletePersonne($id) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			DELETE FROM PERSONNE 
			WHERE id_personne = :id_pers
SQL
		);		
		$stmt->bindValue(":id_pers", $id);
		$stmt->execute();
	}


	public static function connexionForm($action, $submitText = 'OK') {
		self::startSession();

		$corps = <<<HTML
		<div class="content">
			<form method="post" action="{$action}" id="form_connexion" onsubmit="return traitement(this);">
				<div class="form">
		        	<div class = "row">
			        	<div class = "champs">
							<input type="email" placeholder="Votre email" name="mail"/><br/>
							<input type="password" placeholder="Votre mot de passe" name="pass"/><br/>
							<input type="hidden" value='' name="crypt"/>
							<input type="submit" value={$submitText}>
							<a href="./inscription.php">Pas encore inscrit ? Cliquez ici</a>
						</div>
					</div>
				</div>
			</form>
		</div>
		<script type="text/javascript">
			var form = document.getElementById('form_connexion');

			form.onsubmit = traitement; 

			function traitement(form) {				
				this.crypt.value = "";
				this.pass.value = sha1(this.pass.value);
			}
		</script>
HTML;
		return $corps;		
	}









}
