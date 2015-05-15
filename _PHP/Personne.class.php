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
		return ucfirst($this->nom_personne);
	}

	public function getPrenomPers() {
		return ucfirst($this->prenom_personne);
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
			WHERE id_habilitation_pers = :id_hab
SQL
		);	
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);	
		$stmt->bindValue(":id_hab", $id_hab);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function getAllPersonne()
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM PERSONNE
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute();
		$array = $stmt->fetchAll();


		$html = "<div class='box1'>";
		foreach($array as $ligne) {

			$html .= <<<HTML
				<div class = "row bordure">
					<div class = "th2">Membre : {$ligne->getIdPers()} 
						<span class="nomEntreprise">({$ligne->getNomPers()} {$ligne->getPrenomPers()})</span>
					</div>
					<div class = "row">Mail : {$ligne->getMailPers()}</div>
					<div>
						<input type="button" value="Modifier" onclick="modifier({$ligne->getIdPers()})">
						<input type="button" value="Supprimer" onclick="effacer({$ligne->getIdPers()})">
					</div>		
				</div>
HTML;
		}	
		$html .= "</div>";

		$html .="<script>
			function effacer(num)
			{
				var confirm = window.confirm(\"Voulez-vous supprimer ce membre ?\");
				if (confirm)
					document.location.href=\"./membres.php?i=\" + num + \"&delete=yes\";
			};

			function modifier(num) {
				document.location.href=\"./modifMembre.php?i=\" + num;
			}
		</script>";

		return $html;
	}

















	public static function getCurrentUser() {
		if(self::isConnected()) {
			return self::createPersFromId($_SESSION['Personne']->getIdPers());
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
     * Déconnecter l'utilisateur
     *
     * @return void
     */
    public static function logoutIfRequested() {
		self::startSession() ;
        unset($_SESSION[self::session_key]) ;
		session_destroy();
		header('location: ./connexion.php');
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
		try {
			// Mise en place de la session
			self::startSession() ;
			// Mémorisation de l'Utilisateur
			$_SESSION[self::session_key]['user'] = $this ;
		}
		catch (Exception $e) {
			throw new Exception("{$e->getMessage()}");
		}
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
        if (!session_id())
        	session_start() ;

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
		$this->id_habilitation_pers = $id_habilitation;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE PERSONNE
			SET id_habilitation_pers = :id_hab
			WHERE id_personne = :id_pers
SQL
		);	
		$stmt->bindValue(":id_hab", $id_habilitation);
		$stmt->bindValue(":id_pers", $this->id_personne);
		$stmt->execute();		
	}


	public function setIdEntreprise($id_entreprise) {
		$this->id_entreprise_pers = $id_entreprise;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE PERSONNE
			SET id_entreprise_pers = :id_entp
			WHERE id_personne = :id_pers
SQL
		);	
		$stmt->bindValue(":id_entp", $id_entreprise);
		$stmt->bindValue(":id_pers", $this->id_personne);
		$stmt->execute();		
	}


	public function setNomPers($nom) {
		$this->nom_personne = $nom;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE PERSONNE
			SET nom_personne = :nom_pers
			WHERE id_personne = :id_pers
SQL
		);	
		$stmt->bindValue(":nom_pers", $nom);
		$stmt->bindValue(":id_pers", $this->id_personne);
		$stmt->execute();		
	}


	public function setPrenomPers($pnom) {
		$this->prenom_personne = $pnom;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE PERSONNE
			SET prenom_personne = :pnom_pers
			WHERE id_personne = :id_pers
SQL
		);	
		$stmt->bindValue(":pnom_pers", $pnom);
		$stmt->bindValue(":id_pers", $this->id_personne);
		$stmt->execute();		
	}


	public function setMailPers($mail) {
		
		$testMembre = myPDO::getInstance()->prepare(<<<SQL
			SELECT mail_personne
			FROM PERSONNE
			WHERE mail_personne = :mail
			AND id_personne != :id
SQL
);
		$testMembre->execute(array(
		 "mail" => $mail,
		 "id" => $this->id_personne
		));
		$array = $testMembre->fetchAll();
		
		if (count($array) == 0) {
			$this->mail_personne = $mail;
			$stmt = myPDO::getInstance()->prepare(<<<SQL
				UPDATE PERSONNE
				SET mail_personne = :mail_pers
				WHERE id_personne = :id_pers
SQL
		);	
			$stmt->bindValue(":mail_pers", $mail);
			$stmt->bindValue(":id_pers", $this->id_personne);
			$stmt->execute();		
		}
		else {
			throw new Exception("Cet email est déjà utilisé par un autre Membre");
		}
	}

	public function setEmploiPers($emploi) {
		$this->emploi_personne = $emploi;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE PERSONNE
			SET emploi_personne = :emploi_pers
			WHERE id_personne = :id_pers
SQL
		);	
		$stmt->bindValue(":emploi_pers", $emploi);
		$stmt->bindValue(":id_pers", $this->id_personne);
		$stmt->execute();		
	}

	public function setImagePers($image) {
		$this->image_personne = $image;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE PERSONNE
			SET image_personne = :image_pers
			WHERE id_personne = :id_pers
SQL
		);	
		$stmt->bindValue(":image_pers", $image);
		$stmt->bindValue(":id_pers", $this->id_personne);
		$stmt->execute();		
	}

	/** 
	 * setPassword
	 *
	 * Modifie le mot de passe du membre
	 *
	 * @param string $pass le mot de passe. Il doit être codé en sha1
	 */
	public function setPassword($pass) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
				UPDATE PERSONNE
				SET mdp_personne = :pass
				WHERE id_personne = :user
SQL
);
		$stmt->bindValue(':pass', $pass);
		$stmt->bindValue(':user', $this->id_personne);
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
			throw new Exception('1');
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


	public static function createPersonne($nom, $prenom, $mail, $pass, $habilitation = 2) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			INSERT INTO PERSONNE (nom_personne, prenom_personne, mail_personne, mdp_personne, id_habilitation_pers)
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
		
		$error = "";
		if(isset($_GET['msg'])) {
			if($_REQUEST['msg'] == 1) {
				$error = "<p>Nom d'utilisateur ou mot de passe incorrect.</p>";
			}
			else {
				$error = "<p>Erreur lors de la connexion</p>";
			}
		}

		$corps = <<<HTML
		<div class="content">
			<div class="th1">Connectez-vous</div>
			<div class="intro th2">Pour accéder à votre espace personnel</div>	
			<div>{$error}</div>
			<form method="post" action="{$action}" id="form_connexion" onsubmit="return traitement(this);">
				<div class="box1">
		        	<div class = "row">
			        	<div class = "champs">
							<input type="email" required placeholder="Votre email" name="mail"/><br/>
							<input type="password" required placeholder="Votre mot de passe" name="pass"/><br/>
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



	public function estHabilite() {
		return ($this->id_habilitation_pers == 1) ? true : false;
	}

	public function mail($subject, $text, $from)
	{
		$texte = nl2br($text);
		$from = str_replace("\n", "", $from);
		$from = str_replace("\r", "", $from);
		$from = mb_encode_mimeheader(utf8_decode($from));
		$headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
		$headers .= 'Reply-To: '.$from."\n"; // Mail de reponse
		$headers .= 'From: "Nom_de_expediteur"<'.$from.'>'."\n"; // Expediteur
		//Envoi du mail
		mail('alexandre.michel@sinapps.fr',
			mb_encode_mimeheader(utf8_decode($subject)),
			$text,
			$headers/*,
			<<<HEADERS
MIME-Version: 1.0
Content-type: text/html;charset=utf-8
From: {$from} <mail@{$_SERVER['HTTP_HOST']}>
HEADERS*/
		);
	}

}
