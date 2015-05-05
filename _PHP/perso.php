<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';

$p = new WebPage("Espace personnel - Sinapp's");

if(Personne::isConnected()) {
$user = Personne::getCurrentUser();



$p->appendContent(<<<HTML
	Bonjour {$user->getNomPers()} !
HTML
);

}

else {
	Personne::checkConnected();
}
echo $p->toHTML();