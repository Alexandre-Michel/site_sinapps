<?php

require_once 'myPDO.include.php';

class Type_incident {

	private id_type_incident = null;
	
	private description_incident = null;

	public function getIdType{} {
		return $this->id_type_incident;
	}

	public function getDescType() {
		return $this->description_incident;
	}
}