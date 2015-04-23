<?php 

require_once 'webpage.class.php';

$p = new WebPage("Accueil");

$p->appendContent(<<<HTML
<div class = "content">
	<div class "msg_welcome">
		<div class = "title welcome">Bienvenue chez SINAPP'S</div>
		<div class = "st welcome">Agence de maintenance informatique dédiée aux professionnels.</div>
	<div>
</div>
HTML
);

echo $p->toHTML();