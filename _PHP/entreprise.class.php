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
		$this->rue_entreprise = $ville;
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
		$this->rue_entreprise = $pays;
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

	public function setDescriptionEntreprise($description)
	{
		$this->rue_entreprise = $pays;
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

	public static function createEntrepriseFromId($id) {
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
}