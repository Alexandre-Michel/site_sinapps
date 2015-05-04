<?php

require_once 'Personne.class.php';

Personne::checkConnected();
$user = Personne::getCurrentUser();

$p = new WebPage("Espace personnel | Sinapp's");

$p->appendContent(<<<HTML
	Bonjour {$user->getNomPers()} !
HTML
);

echo $p->toHTML();