<?php

require_once 'myPDO.include.php';

class Prestation
{
	private $id_prestation = null;
	private $nom_prestation = null;
	private $prix_paye = null;
	private $id_entreprise = null;
	private $id_type_prestation = null;

	private function __construct()
	{

	}

	public function getIdPrestation()
	{
		return $this->id_prestation;
	}

	public function getNomPrestation()
	{
		return $this->nom_prestation;
	}

	public function getPrixPaye()
	{
		return $this->prix_paye;
	}

	public function getIdEntreprise()
	{
		return $this->id_entreprise;
	}

	public function getIdTypePrestation()
	{
		return $this->id_type_prestation;
	}

	public function setPrixPaye($prix)
	{
		$this->prix_paye = $prix;
	}

	public static function createPrestation()
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			INSERT INTO PRESTATION (id_prestation, nom_prestation, prix_paye, id_entreprise, id_type_prestation)
			VALUES (:id, :nom, :prix, :id_entreprise, :id_type)
SQL
		);
		$stmt->bindValue(':id');
		$stmt->bindValue(':nom');
		$stmt->bindValue(':prix');
		$stmt->bindValue(':id_entreprise');
		$stmt->bindValue('id_type');
		$stmt->execute();
	}

	public static function createPrestationFromId($id)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT * 
			FROM PRESTATION
			WHERE id_prestation = :id
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		if (($object = $stmt->fetch()) !== false)
		{
			return $object;
		}
		else throw new Exception ("Prestation not found");
	}

	/*
	Permet l'affichage d'une prestation
	*/
	public static function printPrestation()
	{

		$stmt = $pdo->prepare(<<<SQL
			SELECT *
			FROM TYPE_PRESTATION
			WHERE id_type_prestation = :id
SQL
		);
		$stmt->bindValue(':id', $this->getIdTypePrestation());
		$stmt->execute();

		$presta = $stmt->fetch();

		$prestation = <<<HTML
			<div class = "box1">
				<div class = "row">
					<div class = "th3">{$presta['nom_prestation']}</div>
					<div class = "img_presta">
						<img id="logo_ordi" src="{$presta['path_logo']}" alt="logo1"/>
					</div>
					<div class = "border_logo"></div>
					<div class = "txt_box">{$presta['description_description']}</div>
					<div class = "more">
						<a href="">En savoir plus &rsaquo;</a>
					</div>
				</div>
			</div>
HTML;
		return $prestation;
	}

	/*
	Permet la suppression d'une prestation
	*/
	public static function deletePrestation($id)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			DELETE FROM PRESTATION
			WHERE id_prestation = :id
SQL
		);
		$stmt->bindValue(":id", $id);
		$stmt->execute();
	}
}
