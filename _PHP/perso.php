<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';

Personne::checkConnected(); //Redirige vers connexion si non connecté !
//$user = Personne::getCurrentUser();

$p = new WebPage("Espace personnel | Sinapp's");

$p->appendContent(<<<HTML
	Bonjour {$user->getNomPers()} !
HTML
);

echo $p->toHTML();