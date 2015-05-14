<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Contrat.class.php';
require_once 'Entreprise.class.php';
require_once 'Offre.class.php';

$p = new WebPage("Entreprises - Sinapp's");


try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();
    
    if ($user->estHabilite()) {

		$p->appendContent(<<<HTML
			<div class="content">
				<div class = "th1">Liste des entreprises</div>
HTML
		);

		$p->appendContent(Entreprise::getAllEntreprises());

		$p->appendContent(<<<HTML
				<input type="button" name="retour" value="Retour" onclick="history.back()">
			</div>
HTML
		);
	}

	else {
		header('location: ./index.php');
		exit;
	}
}

catch (notInSessionException $e) {
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    exit;
}

echo $p->toHTML();