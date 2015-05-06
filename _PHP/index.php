<?php

session_start();

header('Content-type: text/html; charset=utf-8');

require_once 'webpage.class.php';
require_once 'myPDO.include.php';
require_once 'box_container.php';

$pdo = myPDO::getInstance();

$stmt = $pdo->prepare(<<<SQL
	SELECT *
	FROM TYPE_PRESTATION
SQL
);

$stmt->execute();

$liste_noms = array();
$liste_img = array();
$liste_description = array();


while (($ligne = $stmt->fetch()) !== false) {
    array_push($liste_noms, $ligne['nom_prestation']);
    array_push($liste_img, $ligne['path_logo']);
    array_push($liste_description, $ligne['description_prestation']);

}

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
HTML
);

for ($i=0; $i < 6; $i++)
{
	$p->appendContent(<<< HTML
		<div class = "box_container">
			<div class = "presta">
				<div class = "th3">{$liste_noms[$i]}</div>
				<div class = "img_presta">
					<img id="logo_ordi" src="{$liste_img[$i]}" alt="logo1"/>
				</div>
				<div class = "border_logo"></div>
				<div class = "txt_box">{$liste_description[$i]}</div>
				<div class = "more">
					<a href="">En savoir plus &rsaquo;</a>
				</div>
			</div>
		</div>
HTML
	);
}


$p->appendContent(<<<HTML
	</div>
</div>
HTML
);


echo $p->toHTML();
