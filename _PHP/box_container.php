<?php

$pdo = myPDO::getInstance();

$stmt = $pdo->prepare(<<<SQL
	SELECT *
	FROM TYPE_PRESTATION
	WHERE id_type_prestation = 1
SQL
);

$stmt->execute();

$tableau = $stmt->fetch();
$var = 1;
function createBox($i)
{
var_dump($var);
	return <<< HTML
	<div class = "box_container">
			<div class = "presta box1">
				<div class = "th3">{$var}</div>
				<div class = "img_presta">
					<img id="logo_ordi" src="{$tableau['path_prestation']}" alt="logo1"/>
				</div>
				<div class = "border_logo"></div>
				<div class = "txt_box">{$tableau['description_prestation']}</div>
				<div class = "more">
					<a href="">En savoir plus &rsaquo;</a>
				</div>
			</div>
		</div>
HTML;
}