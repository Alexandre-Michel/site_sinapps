<?php 

require_once 'webpage.class.php';

$p = new WebPage("Agence");

$p->appendContent(<<<HTML
J'aime les vaches
HTML
);

echo $p->toHTML();