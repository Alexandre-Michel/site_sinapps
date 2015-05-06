<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';

$p = new WebPage("Espace personnel - Sinapp's");
//$p->appendJs(console.log(Personne::isConnected()));


//Personne::checkConnected();

//$p->appendContent(session_status());
//$user = Personne::getCurrentUser();

try {
    // Lecture depuis les données de session
    $u = Personne::createFromSession() ;
	//var_dump($u);
    $p->appendContent(<<<HTML
        <h1>Zone membre de {$u->getNomPers()} {$u->getPrenomPers()}</h1>
        Page 2
HTML
    ) ;
}
catch (notInSessionException $e) {
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    die() ;
}

echo $p->toHTML();