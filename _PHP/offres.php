<?php

require_once 'webpage.class.php';
require_once 'myPDO.include.php';
require_once 'box_container.php';
require_once 'offre.class.php';
/*
$pdo = myPDO::getInstance();

$stmt = $pdo->prepare(<<<SQL
	SELECT COUNT(*) as nbre
	FROM OFFRE
SQL
);

$stmt->execute();
$count = $stmt->fetch();
*/
$p = new WebPage("Offres - Sinapp's");

$p->appendContent(<<<HTML
<div class = "content">
	<div class = "welcome">
		<div class = "th1">Nos Offres</div>
		<div class = "th2">Chaque besoin a sa solution ...</div>
	</div>
	<div class = "intro th2">
		<span></span>
	</div>
	<div class = "offre_box">
HTML
);

$p->appendContent(Offre::getAllOffre());

$p->appendContent(<<<HTML
	</div>
</div>
HTML
);

echo $p->toHTML();
