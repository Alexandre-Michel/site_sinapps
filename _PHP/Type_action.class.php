<?php

require_once 'myPDO.include.php';

class Type_action {

	private $id_type_action = null;
	
	private $type_action = null;

	private $description_type_action = null;


	public function getIdTypeAct() {
		return $this->id_type_action;
	}

	public function getDescTypeAct() {
		return $this->description_type_action;
	}

	public function getNomTypeAction() {
		return $this->type_action;
	}

	public static function createTypeActionFromId($id) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT * 
			FROM TYPE_ACTION
			WHERE id_type_action = :id_act
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->bindValue(":id_act", $id);
		$stmt->execute();
		if (($object = $stmt->fetch()) !== false) {
			return $object;
		}
		else throw new Exception ("Action not found");
	}

	public static function getAllTypeAction() {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT * 
			FROM TYPE_ACTION
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute();
		return $stmt->fetchAll();
	}

}