<?php

header('Content-type: text/html; charset=utf-8');

require_once 'webpage.class.php';
require_once 'myPDO.include.php';
require_once 'box_container.php';

$pdo = myPDO::getInstance();

$stmt = $pdo->prepare(<<<SQL
	SELECT *
	FROM TYPE_PRESTATION
	WHERE id_type_prestation = 1
SQL
);

$stmt->execute();

$tableau = $stmt->fetch();
var_dump($tableau);
$p = new WebPage("Accueil");

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

for ($i=0; $i < 6; $i++) {
	$p->appendContent(<<< HTML
	<div class = "box_container">
			<div class = "presta box1">
				<div class = "th3">{$tableau['nom_prestation']}</div>
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
HTML
	);
}

		/*<div class = "box_container">
			<div class = "presta box1">
				<div class = "th3">{$tableauNom[0]}</div>
				<div class = "img_presta">
					<img id="logo_ordi" src="../_IMG/ordi.png" alt="logo1"/>
				</div>
				<div class = "border_logo"></div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, </div>
				<div class = "more">
					<a href="">En savoir plus &rsaquo;</a>
				</div>
			</div>
		</div>
		<div class = "box_container">
			<div class = "presta box2">
				<div class = "th3">{$tableauNom[1]}</div>
				<div class = "img_presta">
					<img id="logo_ordi" src="../_IMG/ordi.png" alt="logo1"/>
				</div>
				<div class = "border_logo"></div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, </div>
				<div class = "more">
					<a href="">En savoir plus &rsaquo;</a>
				</div>
			</div>
		</div>
		<div class = "box_container">
			<div class = "presta box3">
				<div class = "th3">{$tableauNom[2]}</div>
				<div class = "img_presta">
					<img id="logo_ordi" src="../_IMG/ordi.png" alt="logo1"/>
				</div>
				<div class = "border_logo"></div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, </div>
				<div class = "more">
					<a href="">En savoir plus &rsaquo;</a>
				</div>
			</div>
		</div>
		<div class = "box_container">
			<div class = "presta box4">
				<div class = "th3">{$tableauNom[3]}</div>
				<div class = "img_presta">
					<img id="logo_ordi" src="../_IMG/ordi.png" alt="logo1"/>
				</div>
				<div class = "border_logo"></div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, </div>
				<div class = "more">
					<a href="">En savoir plus &rsaquo;</a>
				</div>
			</div>
		</div>
		<div class = "box_container">
			<div class = "presta box5">
				<div class = "th3">{$tableauNom[4]}</div>
				<div class = "img_presta">
					<img id="logo_ordi" src="../_IMG/ordi.png" alt="logo1"/>
				</div>
				<div class = "border_logo"></div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, </div>
				<div class = "more">
					<a href="">En savoir plus &rsaquo;</a>
				</div>
			</div>
		</div>
		<div class = "box_container">
			<div class = "presta box6">
				<div class = "th3">{$tableauNom[5]}</div>
				<div class = "img_presta">
					<img id="logo_ordi" src="../_IMG/ordi.png" alt="logo1"/>
				</div>
				<div class = "border_logo"></div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, </div>
				<div class = "more">
					<a href="">En savoir plus &rsaquo;</a>
				</div>
			</div>
		</div>*/

$p->appendContent(<<<HTML
	</div>
</div>
HTML
);

echo $p->toHTML();
