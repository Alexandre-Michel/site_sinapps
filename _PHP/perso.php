<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';

$p = new WebPage("Espace personnel - Sinapp's");


try {
    // Lecture depuis les données de session
    $u = Personne::createFromSession() ;
	//var_dump($u);
    $p->appendContent(<<<HTML
        <h1>Zone membre de {$u->getNomPers()} {$u->getPrenomPers()}</h1>
		<a href="./auth.php?action=logout">Déconnexion</a>
HTML
    ) ;
}
catch (notInSessionException $e) {
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    die() ;
}

echo $p->toHTML();