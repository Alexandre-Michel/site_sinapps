<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';


$p = new WebPage("Connexion | Sinapp's");

$p->appendContent(Membre::connexionForm("./auth.php?action=login"));

echo $p->toHTML();