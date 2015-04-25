<?php

require_once 'webpage.class.php';

$p = new WebPage("Accueil");

$p->appendContent(<<<HTML
<div class = "content">
	<div class = "welcome">
		<div class = "th1">Bienvenue chez SINAPP'S</div>
		<div class = "th2">Agence de maintenance informatique dédiée aux professionnels.</div>
	</div>
	<div class = "intro">
		<h2>
			<span>Ce que nous faisons</span>
			<span class = "i1">pour vous</span>
			<span>...</span>
		</h2>
	</div>
	<div class = "intro_box">
		<div class = "box_container">
			<div class = "presta box1">
				<div class = "th3">Presta 1</div>
				<div class = "img_presta">
					<img id="logo_ordi" src="../_IMG/ordi.png" alt="logo1"/>
				</div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, </div>
				<div class = "more">
					<a href="">En savoir plus</a>
				</div>
			</div>
		</div>
		<div class = "box_container">
			<div class = "presta box2">
				<div class = "th3">Presta 2</div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, </div>
				<div class = "more">
					<a href="">En savoir plus</a>
				</div>
			</div>
		</div>
		<div class = "box_container">
			<div class = "presta box3">
				<div class = "th3">Presta 3</div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, </div>
				<div class = "more">
					<a href="">En savoir plus</a>
				</div>
			</div>
		</div>
		<div class = "box_container">
			<div class = "presta box4">
				<div class = "th3">Presta 4</div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, </div>
				<div class = "more">
					<a href="">En savoir plus</a>
				</div>
			</div>
		</div>
		<div class = "box_container">
			<div class = "presta box5">
				<div class = "th3">Presta 5</div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, </div>
				<div class = "more">
					<a href="">En savoir plus</a>
				</div>
			</div>
		</div>
		<div class = "box_container">
			<div class = "presta box6">
				<div class = "th3">Presta 6</div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, </div>
				<div class = "more">
					<a href="">En savoir plus</a>
				</div>
			</div>
		</div>
	</div>
</div>
HTML
);

echo $p->toHTML();