<?php 

header('Content-type: text/html; charset=utf-8');

require_once 'webpage.class.php';
require_once 'myPDO.include.php';
require_once 'box_container.php';

$pdo = myPDO::getInstance();

$stmt = $pdo->prepare(<<<SQL
	SELECT description_entreprise
	FROM ENTREPRISE
	WHERE id_entreprise = 1
SQL
);

$stmt->execute();
$desc = $stmt->fetch();

$p = new WebPage("Agence");

$p->appendContent(<<<HTML
<div class="content">
	<div class="intro_agence">
		<div class = "th1">SinApp's</div>
		<div class = "th2">Qui sommes-nous ?</div>
	</div>
	<div class ="box_presentation">
		<div class = "presentation box">
			<div class = "presentation">
				<div class = "thpres">{$desc['description_entreprise']}</div>
			</div>
		</div>
	</div>
</div>
HTML
);

echo $p->toHTML();
