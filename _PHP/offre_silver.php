<?php 

header('Content-type: text/html; charset=utf-8');

require_once 'webpage.class.php';
require_once 'myPDO.include.php';
require_once 'box_container.php';

$pdo = myPDO::getInstance();

/**********Requête Offre**********/
$stmt = $pdo->prepare(<<<SQL
	SELECT *
	FROM OFFRE
	WHERE UPPER(nom_offre) LIKE '%SILVER%'
SQL
);
$stmt->execute();
$offre = $stmt->fetch();
/**********Requête Prestations**********/
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

/**********Création de la page**********/
$p = new WebPage($offre['nom_offre']);

$p->appendContent(<<<HTML
<div class="content">
	<div class="intro_offre">
		<div class = "th1">{$offre['nom_offre']}</div>
		<div class = "th2">A partir de {offre['prix_tarifaire']}</div>
	</div>
	<div class="offre_box">
		<div class="box_offre">
			<div class="offre">
				<div class = "img_offre">
					<img id="logo_offre" src="{$offre['path_logo']}" alt="logo1"/>
				</div>
				<div class = "border_logo"></div>
				<div class = "txt_box">{$offre['desc_page']}</div>
			</div>
		</div>
	</div>
	<div class = "intro_box">
HTML
);
for($i = 0; $i < 6; $i++)
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