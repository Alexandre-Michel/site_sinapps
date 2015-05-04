<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';


$p = new WebPage("Connexion | Sinnap's");

$p->appendContent(<<<HTML

HTML
);

echo $p->toHTML();