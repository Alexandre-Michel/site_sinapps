<?php

require_once 'myPDO.include.php';

class Incident
{
	private $id_incident = null;
	private $nom_incident = null;
	private $description_incident = null;
	private $id_personne = null;
	private $id_type_incident = null;

	private function __construct()
	{
		
	}

	public function getIdIncident()
	{
		return $this->id_incident;
	}

	public function getNomIncident()
	{
		return $this->nom_incident;
	}

	public function getDescriptionIncident()
	{
		return $this->description_incident;
	}

	public function getIdPersonne()
	{
		return $this->id_personne;
	}

	public function getIdType()
	{
		return $this->id_type_incident;
	}

	public function setDescriptionIncident($desc)
	{
		$this->description_incident = $desc;
	}

	public function setTypeIncident($type)
	{
		$this->id_type_incident = $type;
	}

	/*
	Récupération de tous les incidents en fonction de l'ID d'une personne
	*/
	public static function getIncidentByPers($id)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM INCIDENT
			WHERE id_personne = :id
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	/*
	Récupération de tous les incidents de toutes les personnes
	*/
	public static function getAllIncident()
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM INCIDENT
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute();
		$array = $stmt->fetchAll();
		$html = <<<HTML
			<div class = "box1">
				<div class = "box2">
					<div class = "row">
HTML;
		foreach ($array as $ligne)
		{
			$html.=<<<HTML
				<div class = "th3">
					{$ligne->getNomIncident()}
				</div>
HTML;
		}
		$html.=<<<HTML
					</div>
				</div>
			</div>
HTML;
		return $html;
	}

	/*
	Récupération de tous les incidents liés à une entreprise
	*/

	/*
	Récupération des actions effectuées sur un incident
	*/
	public static function getActionsIncident($id_incident)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM ACTION
			WHERE id_incident = :id
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->bindValue(":id", $id_incident);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	/*
	Permet la déclaration d'un incident
	*/
	public static function createIncident($nom_incident, $description = "", $id_type_incident)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			INSERT INTO INCIDENT (nom_incident, description_incident, id_personne, id_type_incident)
			VALUES (:nom, :description, :id_pers, :id_type)
SQL
		);
		$stmt->bindValue(":nom", $nom_incident);
		$stmt->bindValue(":description", $description);
		$stmt->bindValue(":id_pers", Personne::createFromSession());
		$stmt->bindValue(":id_type", $id_type_incident);
		$stmt->execute();
	}

	/*
	Permet la suppression d'un incident
	*/
	public static function deleteIncident($id)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			DELETE FROM INCIDENT
			WHERE id_incident = :id
SQL
		);
		$stmt->bindValue(":id", $id);
		$stmt->execute();
	}
}