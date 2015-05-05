<?php

require_once 'myPDO.insert.php';

class Personne {
	private $id_pers = null;

	private $id_habilitation = null;

	private $id_entp_pers = null;

	private $nom_pers = null;

	private $prenom_pers = null;

	private $mail_pers = null;

	private $emploi_pers = null;

	private $image_pers = null;

	public static $SESSION_KEY = "__sinapps__";



	public function getIdPers() {
		return $id_pers;
	}

	public function getIdHabilitation() {
		return $id_habilitation;
	}

	public function getIdEntpPers() {
		return $id_entp_pers;
	}

	public function getNomPers() {
		return $nom_pers;
	}

	public function getPrenomPers() {
		return $prenom_pers;
	}

	public function getMailPers() {
		return $mail_pers;
	}

	public function getEmploiPers() {
		return $emploi_pers;
	}

	public function getImagePers() {
		return $image_pers;
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
			return self::createPersFromId($_SESSION[self::$SESSION_KEY."Personne"]->getIdPers());
		}
		else {
			return null;
		}
	}


	public static function isConnected() {
		self::startSession();
		if(isset($_SESSION[self::$SESSION_KEY."connected"])) {
			return $_SESSION[self::$SESSION_KEY."connected"];
		}
		else {
			return false;
		}
	}


	private static function startSession() {
		if (headers_sent()) {
			throw new Exception ("Impossible de démarrer la session : Headers déjà envoyés");
		}
		else if (session_status() == PHP_SESSION_NONE) {
			session_start();
			try {
				$user = self::getCurrentUser();
			}
			catch (Exception $e) {
				self::logout();
			}
		}
	}


	public static function logout() {
		self::startSession();
		session_unset();
		session_destroy();
		header('location: ./');
	}


	public static function checkConnected() {
		if(!self::isConnected()) {
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


















	public static function createFromAuth($crypt) {
		$pdo = myPDO::getInstance();
		self::startSession();
		$stmt = $pdo->prepare(<<<SQL
			SELECT * 
			FROM PERSONNE
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute();
		$array = $stmt->fetchAll();

		$userRow = null;

		foreach ($array as $key => $pers) {
			if($mail == $pers->mail_personne && $pass == $pers->mdp_personne) {
				$userRow = $pers;
				break;
			}
		}

		if(!userRow) throw new Exception("Mail ou mot de passe incorrect !");

		$_SESSION[self::$SESSION_KEY.'Personne'] = $userRow;
		$_SESSION[self::$SESSION_KEY.'connected'] = true;
		return $_SESSION[self::$SESSION_KEY.'Personne'];
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


	public static function connexionForm($action) {
		self::startSession();
		//$_SESSION[self::$SESSION_KEY];

		$corps = <<<HTML
		<div class="content">
			<form method="post" action="{$action}" id="form_connexion">
				<label for="mail">Email</label>
				<input type="email" placeholder="Votre email" name="mail"/><br/>
				<label for="pass">Mot de passe</label>
				<input type="password" placeholder="Votre mot de passe" name="pass"/><br/>
				<input type="submit" value="Se Connecter"/>
				<a href="./inscription.php">Pas encore inscrit ? Cliquez ici</a>
			</form>
		</div>
		<script>
			document.getElementById('form_connexion').onsubmit = function() {
				this.crypt.value = sha1(this.mail.value) + sha1(this.pass.value);
			}
		</script>
HTML;
		return $corps;		
	}









}
