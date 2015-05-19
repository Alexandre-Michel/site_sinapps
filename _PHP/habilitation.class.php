<?php

require_once 'myPDO.include.php';

class Habilitation
{
	private $id_habilitation = null;

	private $type_habilitation = null;


	public function getIdHab()
	{
		return $this->id_habilitation;
	}

	public function getNomHab()
	{
		return $this->type_habilitation;
	}


	public function setNomHab($nom)
	{
		$this->type_habilitation = $nom;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE HABILITATION
			SET type_habilitation = :nom
			WHERE id_habilitation = :id
SQL
		);
		$stmt->bindValue(":nom", $nom);
		$stmt->bindValue(":id", $this->id_habilitation);
		$stmt->execute();
	}

	public function setNomHabById($nom, $id)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE HABILITATION
			SET type_habilitation = :nom
			WHERE id_habilitation = :id
SQL
		);
		$stmt->bindValue(":nom", $nom);
		$stmt->bindValue(":id", $id);
		$stmt->execute();
	}
	
	public static function createHabilitationFromId($id)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT * 
			FROM HABILITATION
			WHERE id_habilitation = :id
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		if (($object = $stmt->fetch()) !== false)
			return $object;
		else
			throw new Exception ("Habilitation not found");
	}

	public static function deleteHabilitation($id)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			DELETE FROM HABILITATION
			WHERE id_habilitation = :id
SQL
		);
		$stmt->bindValue(":id", $id);
		$stmt->execute();
	}

	public static function getAllHabilitations()
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT * 
			FROM HABILITATION
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute();	
		return $stmt->fetchAll();
	}

	public static function getNbHabilitations() 
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT COUNT(*) AS nb
			FROM HABILITATION
SQL
		);
		$stmt->execute();
		$count = $stmt->fetch();
		return $count['nb'];
	}
	
	public static function createHabilitation($nom_hab)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			INSERT INTO HABILITATION (type_habilitation)
			VALUES (:nom)
SQL
		);
		$stmt->bindValue(":nom", $nom_hab);
		$stmt->execute();
	}

}