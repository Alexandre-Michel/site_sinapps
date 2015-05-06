<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';

$p = new WebPage("Espace personnel - Sinapp's");
//$p->appendJs(console.log(Personne::isConnected()));


//Personne::checkConnected();

//$p->appendContent(session_status());
//$user = Personne::getCurrentUser();



$p->appendContent(<<<HTML
	Bonjour toi !
HTML
);



echo $p->toHTML();