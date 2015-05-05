<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';

$p = new WebPage("Espace personnel - Sinapp's");

Personne::checkConnected();

$user = Personne::getCurrentUser();



$p->appendContent(<<<HTML
	Bonjour {$user->getNomPers()} !
HTML
);


echo $p->toHTML();