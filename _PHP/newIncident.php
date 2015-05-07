<?php

require_once 'webpage.class.php';
require_once 'Incident.class.php';

$p = new WebPage("Nouvel Incident - Sinapp's");

try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();

    $p->appendContent(<<<HTML
    	<div class="content">
    		
HTML
    );
}

catch (notInSessionException $e) {
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    die() ;
}

echo $p->toHTML();