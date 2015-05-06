<?php 

require_once 'webpage.class.php';
require_once 'Personne.class.php';
/*
if(isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];

	if ($action == "login") {*/
		//$mail = $_REQUEST['mail'];
		//$mdp = $_REQUEST['pass'];
		//var_dump($mail);
		//var_dump($mdp);

		$p = new WebPage("Authentification");
		try {
			Personne::createFromAuth($_REQUEST);	
			$p->appendContent("BONJOUR CONNARD !");
		}
		catch (Exception $e) {
			$p->appendContent("Echec : {$e->getMessage()}");
		}

		echo $p->toHTML();
	//}
//}