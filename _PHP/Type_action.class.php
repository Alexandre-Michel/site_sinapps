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

	public function getTypeAct() {
		return $this->type_action;
	}
}