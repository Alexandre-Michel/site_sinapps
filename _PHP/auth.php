<?php 

require_once 'Personne.class.php';

if(isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];

	if ($action == "login") {
		$crypt = $_REQUEST['crypt'];

		try {
			Personne::createFromAuth($crypt);	
			header('Location: ./index.php');
			exit;
		}
		catch (Exception $e) {
			throw new Exception("Error Processing Request", 1);
			exit;
		}

	}
}