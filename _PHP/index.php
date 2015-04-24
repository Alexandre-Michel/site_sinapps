<?php 

require_once 'webpage.class.php';

$p = new WebPage("Accueil");

$p->appendContent(<<<HTML
<div class = "content">
	<div class "msg_welcome">
		<div class = "title welcome">Bienvenue chez SINAPP'S</div>
		<div class = "st welcome">Agence de maintenance informatique dédiée aux professionnels.</div>
	<div>
	<div class = "intro">
		<h2>
			<span class = "titre_intro">Que faisons-nous ?</span>
		</h2>
	</div>
	<div class = "intro_box">
		<div class = "presta box1">
			<h3>Presta 1</h3>
			<div class = "txt_box">Ceci est un texte de test MODEFOCKER</div>
		</div>
		<div class = "presta box2">
			<h3>Presta 2</h3>
			<div class = "txt_box">Ceci est un texte de test MODEFOCKER</div>
		</div>
		<div class = "presta box3">
			<h3>Presta 3</h3>
			<div class = "txt_box">Ceci est un texte de test MODEFOCKER</div>
		</div>
		<div class = "presta box4">
			<h3>Presta 4</h3>
			<div class = "txt_box">Ceci est un texte de test MODEFOCKER</div>
		</div>
		<div class = "presta box5">
			<h3>Presta 5</h3>
			<div class = "txt_box">Ceci est un texte de test MODEFOCKER</div>
		</div>
		<div class = "presta box6">
			<h3>Presta 6</h3>
			<div class = "txt_box">Ceci est un texte de test MODEFOCKER</div>
		</div>
	</div>
</div>
HTML
);

echo $p->toHTML();