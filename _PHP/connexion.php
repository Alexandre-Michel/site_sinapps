<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';

//Personne::logoutIfRequested();

$p = new WebPage("Connexion - Sinapp's");

try {
    // Lecture depuis les données de session
    $u = Personne::createFromSession() ;
}
catch (NotInSessionException $e) {
}



$p->appendContent(Personne::connexionForm("./auth.php?action=login", "Connecter"));

echo $p->toHTML();