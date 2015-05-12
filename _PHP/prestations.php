<?php

require_once 'webpage.class.php';
require_once 'myPDO.include.php';
require_once 'box_container.php';
require_once 'Prestation.class.php';
require_once 'Type_Prestation.class.php';

$pdo = myPDO::getInstance();

$stmt = $pdo->prepare(<<<SQL
	SELECT COUNT(*) as nbre
	FROM TYPE_PRESTATION
SQL
);

$stmt->execute();
$count = $stmt->fetch();

$p = new WebPage("Prestations - Sinapp's");

$p->appendContent(<<<HTML
<div class = "content">
	<div class = "welcome">
		<div class = "th1">Nos prestations</div>
		<div class = "th2">Chaque besoin a sa solution ...</div>
	</div>
	<div class = "intro th2">
		<span></span>
	</div>
	<div class = "intro_box">
		<div class = "box1">
HTML
);

for($i = 1; $i <= $count["nbre"]; $i++)
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