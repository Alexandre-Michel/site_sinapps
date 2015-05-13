<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';

//Personne::logoutIfRequested();

$p = new WebPage("Connexion - Sinapp's");

$user = "";
try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();
}
catch (NotInSessionException $e) {
}


if($user == NULL) {
	$p->appendContent(Personne::connexionForm("./auth.php?action=login", "Connecter"));
}
else {
	header("Location: ./index.php");
	exit;
}

echo $p->toHTML();