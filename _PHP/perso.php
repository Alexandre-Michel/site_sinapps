<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Incident.class.php';

$p = new WebPage("Espace personnel - Sinapp's");


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
			<div class = "th1">Bienvenue dans votre espace personnel</div>
			<div class="box1">
				<div class="row">Modifier vos infos</div>
				<div class="row">
					<button onclick="location.href='./profil.php'">Modifier vos infos</button>
				</div>
			</div>
			<div class="box1">
				<button onclick="location.href='./auth.php?action=logout'">Déconnexion</button>
			</div>
		</div>
HTML
    );
}
catch (notInSessionException $e) {
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    die() ;
}

echo $p->toHTML();