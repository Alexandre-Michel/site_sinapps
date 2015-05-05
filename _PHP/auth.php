<?php 

require_once 'Personne.class.php';

if(isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];

	if ($action == "login") {
		$mail = $_REQUEST['mail'];
		$mdp = $_REQUEST['pass'];

		try {
			Personne::createFromAuth($mail, $mdp);	
			header('location: ./index.php');
			exit;
		}
		catch (Exception $e) {
			throw new Exception("Error Processing Request", 1);
			exit;
		}

	}
}