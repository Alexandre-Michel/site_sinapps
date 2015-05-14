<?php

require_once 'myPDO.include.php';

class Type_incident {

	private $id_type_incident = null;
	
	private $description_type_incident = null;

	public function getIdType() {
		return $this->id_type_incident;
	}

	public function getDescType() {
		return $this->description_type_incident;
	}

	public static function createTypeIncidentFromId($id) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT * 
			FROM TYPE_INCIDENT
			WHERE id_type_incident = :id
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		if (($object = $stmt->fetch()) !== false)
			return $object;
		else
			throw new Exception ("Type incident not found");
	}
}