<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';

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
		$p->appendContent(<<<HTML
			<div>Bravo, t'es habilité échelon 1 sale batard !</div>
HTML
		);
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
		<a href="./auth.php?action=logout">Déconnexion</a>
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