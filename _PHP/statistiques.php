<?php


header('Content-type: text/html; charset=utf-8');

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Contrat.class.php';
require_once 'Entreprise.class.php';
require_once 'myPDO.include.php';

$pdo = myPDO::getInstance();

$p = new WebPage("Accueil - Sinapp's");

$nbPers = Personne::getNbPersSite();
$nbStaff = Personne::getNbPersStaff();
$nbContrats = Contrat::getNbContrats();
$nbSilver = Contrat::getNbContratsSilver();
$nbGold = Contrat::getNbContratsGold();
$nbPlatinum = Contrat::getNbContratsPlatinum();
$nbEntp = Entreprise::getNbEntreprises();

$p->appendContent(<<<HTML
<div class = "content">
	<div class = "welcome">
		<div class = "th1">Statistiques</div>
		<div class = "intro th2">
			<span>Quelques</span>
			<span class = "i1">chiffres</span>
			<span>...</span>
		</div>
	</div>

	<div class = "intro_box">
		<div class = "box1">
			<div class="th2">
				{$nbPers} personnes inscrites pour {$nbEntp} entreprises...<br/>
				{$nbStaff} personnes qui répondent à vos attentes...<br/>
				{$nbContrats} contrats souscrits dont :<br/>
					- {$nbSilver} contrats Silver<br/>
					- {$nbGold} contrats Gold<br/>
					- {$nbPlatinum} contrats Platinum<br/>
			</div>
HTML
);



$p->appendContent(<<<HTML
		</div>
	</div>
</div>
HTML
);


echo $p->toHTML();
