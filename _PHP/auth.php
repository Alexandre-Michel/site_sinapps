<?php 

require_once 'webpage.class.php';
require_once 'Personne.class.php';

if(isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];

	if ($action == "login") {
		try {
			$user = Personne::createFromAuth($_REQUEST);
			$user->saveIntoSession();		
			header("Location: ./perso.php");
		}
		catch (AuthenticationException $e) {
			throw new AuthenticationException ("Echec d'authentification : {$e->getMessage()}");
		}
		catch (Exception $e) {
			header('location: ./connexion.php?msg=' . (is_numeric($e->getMessage()) ? $e->getMessage() : "-1"));
			exit;
		}
	}
	
	else if ($action == "logout") {
		Personne::logoutIfRequested();
	}
}