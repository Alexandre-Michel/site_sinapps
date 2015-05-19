<?php

require_once 'myPDO.include.php';

class Entreprise
{
	private $id_entreprise;
	private $nom_entreprise;
	private $rue_entreprise;
	private $cp_entreprise;
	private $ville_entreprise;
	private $pays_entreprise;
	private $tel_entreprise;
	private $siret_entreprise;
	private $horaires_entreprise;
	private $description_entreprise;
	private $path_logo;

	private function __construct()
	{}

	public function getIdEntreprise()
	{
		return $this->id_entreprise;
	}

	public function getNomEntreprise()
	{
		return $this->nom_entreprise;
	}

	public function getRueEntreprise()
	{
		return$this->rue_entreprise;
	}

	public function getCpEntreprise()
	{
		return$this->cp_entreprise;
	}

	public function getVilleEntreprise()
	{
		return$this->ville_entreprise;
	}

	public function getPaysEntreprise()
	{
		return$this->pays_entreprise;
	}

	public function getTelEntreprise()
	{
		return$this->tel_entreprise;
	}

	public function getSiretEntreprise()
	{
		return$this->siret_entreprise;
	}

	public function getHorairesEntreprise()
	{
		return$this->horaires_entreprise;
	}

	public function getDescriptionEntreprise()
	{
		return$this->description_entreprise;
	}

	public function getPathLogoEntreprise()
	{
		return$this->path_logo;
	}

	public function setNomEntreprise($nom)
	{
		$this->nom_entreprise = $nom;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE ENTREPRISE
			SET nom_entreprise = :nom
			WHERE id_entreprise = :id
SQL
		);
		$stmt->bindValue(":nom", $nom);
		$stmt->bindValue(":id", $this->id_entreprise);
		$stmt->execute();
	}

	public function setRueEntreprise($rue)
	{
		$this->rue_entreprise = $rue;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE ENTREPRISE
			SET rue_entreprise = :rue
			WHERE id_entreprise = :id
SQL
		);
		$stmt->bindValue(":rue", $rue);
		$stmt->bindValue(":id", $this->id_entreprise);
		$stmt->execute();
	}

	public function setCpEntreprise($cp)
	{
		$this->cp_entreprise = $cp;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE ENTREPRISE
			SET cp_entreprise = :cp
			WHERE id_entreprise = :id
SQL
		);
		$stmt->bindValue(":cp", $cp);
		$stmt->bindValue(":id", $this->id_entreprise);
		$stmt->execute();
	}

	public function setVilleEntreprise($ville)
	{
		$this->ville_entreprise = $ville;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE ENTREPRISE
			SET ville_entreprise = :ville
			WHERE id_entreprise = :id
SQL
		);
		$stmt->bindValue(":ville", $ville);
		$stmt->bindValue(":id", $this->id_entreprise);
		$stmt->execute();
	}

	public function setPaysEntreprise($pays)
	{
		$this->pays_entreprise = $pays;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE ENTREPRISE
			SET pays_entreprise = :pays
			WHERE id_entreprise = :id
SQL
		);
		$stmt->bindValue(":pays", $pays);
		$stmt->bindValue(":id", $this->id_entreprise);
		$stmt->execute();
	}

	public function setTelEntreprise($tel)
	{
		$this->tel_entreprise = $tel;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE ENTREPRISE
			SET tel_entreprise = :tel
			WHERE id_entreprise = :id
SQL
		);
		$stmt->bindValue(":tel", $tel);
		$stmt->bindValue(":id", $this->id_entreprise);
		$stmt->execute();
	}

	public function setDescriptionEntreprise($description)
	{
		$this->description_entreprise = $description;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE ENTREPRISE
			SET description_entreprise = :description
			WHERE id_entreprise = :id
SQL
		);
		$stmt->bindValue(":description", $description);
		$stmt->bindValue(":id", $this->id_entreprise);
		$stmt->execute();
	}

	public function setSiretEntreprise($siret)
	{
		$this->siret_entreprise = $siret;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE ENTREPRISE
			SET siret_entreprise = :siret
			WHERE id_entreprise = :id
SQL
		);
		$stmt->bindValue(":siret", $siret);
		$stmt->bindValue(":id", $this->id_entreprise);
		$stmt->execute();
	}


	public static function createEntrepriseFromId($id)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT * 
			FROM ENTREPRISE
			WHERE id_entreprise = :id
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		if (($object = $stmt->fetch()) !== false)
			return $object;
		else
			throw new Exception ("Entreprise not found");
	}

	public static function deleteEntreprise($id)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			DELETE FROM ENTREPRISE
			WHERE id_entreprise = :id
SQL
		);
		$stmt->bindValue(":id", $id);
		$stmt->execute();
	}

	public static function getAllEntreprises()
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT * 
			FROM ENTREPRISE
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute();	
		$array = $stmt->fetchAll();

		$html = "<div class='box1'>";
		foreach($array as $uneEntp) {

			$html .= <<<HTML
				<div class = "row bordure">
					<div class = "th2">Entreprise n°{$uneEntp->getIdEntreprise()} 
						<span class="nomEntreprise">({$uneEntp->getNomEntreprise()})</span>
					</div>
					<div class = "row">Localisation : {$uneEntp->getRueEntreprise()} {$uneEntp->getCpEntreprise()} {$uneEntp->getVilleEntreprise()} - {$uneEntp->getPaysEntreprise()}</div>
					<div class = "row">Téléphone : {$uneEntp->getTelEntreprise()}</div>
					<div class = "row">Description : {$uneEntp->getDescriptionEntreprise()}</div>
					<div class = "boutons_objet">
						<button type="submit" class="button" onclick="modifier({$uneEntp->getIdEntreprise()})">Modifier</button>
						<button type="submit" class="button" onclick="effacer({$uneEntp->getIdEntreprise()})">Supprimer</button>
						<button type="submit" class="button" onclick="parc({$uneEntp->getIdEntreprise()})">Voir Parc(s)</button>
					</div>		
				</div>
HTML;
		}	
		$html .= "</div>";

		$html .="<script>
			function effacer(num) {
				var confirm = window.confirm(\"Voulez-vous supprimer cette entreprise ?\");
				if (confirm) {
					document.location.href=\"./entreprises.php?i=\" + num + \"&delete=yes\";
				}
			};

			function modifier(num) {
				document.location.href=\"./modifEntreprise.php?i=\" + num;
			};

			function parc(num)
			{
				document.location.href=\"./parc.php?i=\" + num;
			}
		</script>";

		return $html;
	}

	public static function getAllEntreprisesTab() {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT * 
			FROM ENTREPRISE
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute();	
		return $stmt->fetchAll();
	}

	public static function createEntreprise($nom, $rue, $cp, $ville, $tel, $pays, $desc) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			INSERT INTO ENTREPRISE (nom_entreprise, rue_entreprise, cp_entreprise, ville_entreprise, pays_entreprise, tel_entreprise, description_entreprise)
			VALUES (:nom, :rue, :cp, :ville, :tel, :pays, :description)
SQL
		);
		$stmt->bindValue(":nom", $nom);
		$stmt->bindValue(":rue", $rue);
		$stmt->bindValue(":cp", $cp);
		$stmt->bindValue(":ville", $ville);
		$stmt->bindValue(":tel", $tel);
		$stmt->bindValue(":pays", $pays);
		$stmt->bindValue(":description", $desc);
		$stmt->execute();

	}



}