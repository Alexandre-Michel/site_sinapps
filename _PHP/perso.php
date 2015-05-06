<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Incident.class.php';

$p = new WebPage("Espace personnel - Sinapp's");


try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession() ;
	$p->appendContent(<<<HTML
		<div class="content">
			<h1>Zone membre de {$user->getNomPers()} {$user->getPrenomPers()}</h1>
HTML
	);
	
	switch ($user->getIdHabilitation()) {
		// Si l'utilisateur est un administrateur
		case 1:
		$p->appendContent(Incident::getAllIncident());
		break;
		//Si l'utilisateur n'est qu'un membre lambda sans droits
		case 2:
		$p->appendContent(<<<HTML
			<div>Oh le mauvais, échelon 2 !!</div>
HTML
		);
		break;
	}	

	$p->appendContent(<<<HTML
		<div class="box1">
			<div class="box2">
				<div class="row">
					Modifier vos infos
				</div>
				<div class="row">
					
				</div>
			</div>
		</div>
		<button onclick="location.href='./auth.php?action=logout'">Déconnexion</button>
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