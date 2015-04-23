<?php 

require_once 'webpage.class.php';

$p = new WebPage("Accueil");

$p->appendContent(<<<HTML
<div>J'aime les patates</div>
HTML
);