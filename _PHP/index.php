<?php


header('Content-type: text/html; charset=utf-8');

require_once 'webpage.class.php';
require_once 'myPDO.include.php';
require_once 'box_container.php';
require_once 'Prestation.class.php';
require_once 'Type_Prestation.class.php';

$pdo = myPDO::getInstance();

$p = new WebPage("Accueil - Sinapp's");

$p->appendContent(<<<HTML
<div class = "content">
	<div class = "welcome">
		<div class = "th1">Bienvenue chez SINAPP'S</div>
		<div class = "th2">Agence de maintenance informatique dédiée aux professionnels.</div>
	</div>
	<div class = "intro th2">
		<span>Ce que nous faisons</span>
		<span class = "i1">pour vous</span>
		<span>...</span>
	</div>
	<div class = "intro_box">
		<div class = "box1">
HTML
);

for ($i=1; $i < 7; $i++)
{
	$type = Type_Prestation::createTypePrestationFromId($i);
	$p->appendContent($type->printTypePrestation());
}


$p->appendContent(<<<HTML
		</div>
	</div>
</div>
HTML
);


echo $p->toHTML();
