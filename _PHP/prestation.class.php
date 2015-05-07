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

	/*
	Premet l'affichage d'une prestation
	*/
	public static function getPrestationById($id)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM PRESTATION
			WHERE id_prestation = :id
SQL
		);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		
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
