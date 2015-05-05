<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';

$p = new WebPage("Espace personnel - Sinapp's");

<<<<<<< HEAD
Personne::checkConnected();

=======
$p->appendContent(session_status());
if(Personne::isConnected()) {
>>>>>>> origin/master
$user = Personne::getCurrentUser();



$p->appendContent(<<<HTML
	Bonjour {$user->getNomPers()} !
HTML
);


echo $p->toHTML();