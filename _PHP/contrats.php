<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Contrat.class.php';
require_once 'Entreprise.class.php';

$p = new WebPage("Contrats - Sinapp's");


try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();
    switch ($user->getIdHabilitation()) {
		// Si l'utilisateur est un administrateur
		case 1:
		$droit = 1;
		break;
		//Si l'utilisateur n'est qu'un membre lambda sans droits
		case 2:
		$droit = 2;
		break;
	}

	$p->appendContent(<<<HTML
		<div class="content">
			<div class = "th1">Liste des contrats</div>
HTML
	);

	if ($droit == 1) {
		$p->appendContent(Contrat::getAllContrats());
	}
	else {
		if ($user->getIdEntpPers() == NULL) {
			header("Location: ./perso.php") ;
			exit;
		}
		$entp = Entreprise::createEntrepriseFromId($user->getIdEntpPers());
		$p->appendContent(Contrat::getContratByIdEntp($entp->getIdEntreprise()));
	}

	$p->appendContent(<<<HTML
		</div>
HTML
	);
}

catch (notInSessionException $e) {
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    exit;
}

echo $p->toHTML();