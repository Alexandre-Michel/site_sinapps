<?php 

require_once 'webpage.class.php';

$p = new WebPage("Accueil");

$p->appendContent(<<<HTML
<div class = 'content'>
	<div class = 'msg_welcome'>
		Bienvenue chez SINAPP'S \n
		Agence de maintenance informatique dédiée aux professionnels.
	</div>
</div>
HTML
);

echo $p->toHTML();