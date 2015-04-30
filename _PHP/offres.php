<?php 

header('Content-type: text/html; charset=utf-8');

require_once 'webpage.class.php';
require_once 'myPDO.include.php';
require_once 'box_container.php';

$pdo = myPDO::getInstance();

$stmt = $pdo->prepare(<<<SQL
	SELECT *
	FROM OFFRE
SQL
);

$stmt->execute();

$liste_noms = array();
$liste_img = array();
$liste_descriptions = array();


while (($ligne = $stmt->fetch()) !== false)
{
    array_push($liste_noms, $ligne['nom_offre']);
    array_push($liste_img, $ligne['prix_tarifaire']);
    array_push($liste_descriptions, $ligne['description_offre']);
}

require_once 'webpage.class.php';

$p = new WebPage("Agence");

$p->appendContent(<<<HTML
<div class="content">
	<div class="intro_offre">
		<div class = "th1">Offres de maintenance</div>
		<div class = "th2">Ce que nous vous proposons ...</div>
	</div>
	<div class="offre_box">
HTML
);

for($i=0; $i<3; $i++)
{
	$p->appendContent(<<<HTML
		<div class="box_offre">
			<div class="offre">
				<div class = "th3">{$liste_noms[$i]}</div>
				<div class = "img_offre">
					<img id="logo_offre" src="{$liste_img[$i]}" alt="logo1"/>
				</div>
				<div class = "border_logo"></div>
				<div class = "txt_box">{$liste_descriptions[$i]}</div>
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