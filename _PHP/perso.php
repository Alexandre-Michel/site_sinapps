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
	$signaler = "";
	$newContrat = "";
	$admin = "";

	if($droit != 1) {
		$signaler = "<button onclick=\"location.href='./newIncident.php'\">Déclarer un nouvel incident</button>";
	}
	else {
		$signaler = "";
		$newContrat = "<button onclick=\"location.href='./newContrat.php'\">Nouveau contrat</button>";
		$admin = "<div class='row fond'>
					<div class='th2 center'>Entreprise(s)</div>
					<div><button onclick=\"location.href='./entreprises.php'\">Visualiser les entreprises</button>
					<button onclick=\"location.href='./newEntreprise.php'\">Ajouter une entreprise</button></div>
				</div>
				<div class=\"row fond\">
					<div class=\"th2 center\">Membre(s)</div>
					<div><button onclick=\"location.href='./membres.php'\">Visualiser les membres</button>
				</div>";
	}

	$contrats = "";
	if ($user->getIdEntpPers() != NULL)
	{
		
		$contrats = "<div class = 'row fond'>
				<div class='th2 center'>Contrat(s)</div>
				<div>
					<button onclick=\"location.href='./contrats.php'\">Visualiser les contrats</button>
					{$newContrat}
				</div>
			</div>	";
	}
	
	$p->appendContent(<<<HTML
		<div class="content">
			<div class = "th1">Bienvenue dans votre espace personnel</div>
			<div class = "box1">
				<div class = "row fond">
					<div class="th2 center">Incident(s)</div>
					<div><button onclick="location.href='./incidents.php'">Visualiser les incidents</button>{$signaler}</div>
				</div>
				{$contrats}
				{$admin}
				<div class="row fond">
					<div class="th2 center">Informations personnelles</div>
					<div><button onclick="location.href='./profil.php'">Modifier vos infos</button></div>
				</div>
				
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