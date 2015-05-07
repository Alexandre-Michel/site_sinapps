<?php

require_once 'myPDO.include.php';

class Incident
{
	private $id_incident = null;
	private $nom_incident = null;
	private $description_incident = null;
	private $id_personne = null;
	private $id_type_incident = null;
	private $date_incident = null;

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

	public function getDateIncident() {
		return $this->date_incident;
	}

	public function setDateIncident($date) {
		$this->date_incident = $date;
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
		$array = $stmt->fetchAll();
		$html = <<<HTML
			<div class = "box1">
HTML;
		foreach ($array as $ligne)
		{
			$i = $ligne->getIdIncident();
			$html.=<<<HTML
				<div class = "row">
					<div class = "th1">{$ligne->getNomIncident()}</div>
					<div class = "th2">{$ligne->getDescriptionIncident()}</div>
					<button onclick="location.href='./incident.php?i={$id}'">Déconnexion</button>
				</div>
HTML;
		}
		$html.=<<<HTML
			</div>
HTML;
		return $html;
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
HTML;
		foreach ($array as $ligne)
		{
			$i = $ligne->getIdIncident();
			$html.=<<<HTML
				<div class = "row">
					<div class = "th1">{$ligne->getNomIncident()}</div>
					<div class = "th2">{$ligne->getDescriptionIncident()}</div>
					<button onclick="location.href='./incident.php?i={$id}'">Déconnexion</button>
				</div>
HTML;
		}
		$html.=<<<HTML
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
			INSERT INTO INCIDENT (nom_incident, description_incident, id_personne, id_type_incident, date_incident)
			VALUES (:nom, :description, :id_pers, :id_type, :date_incident)
SQL
		);
		$stmt->bindValue(":nom", $nom_incident);
		$stmt->bindValue(":description", $description);
		$stmt->bindValue(":id_pers", Personne::createFromSession());
		$stmt->bindValue(":id_type", $id_type_incident);
		$stmt->bindValue(":date_incident", date("Le d-m-Y à H:i") );
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