<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Contrat.class.php';
require_once 'Entreprise.class.php';
require_once 'Offre.class.php';
require_once 'parc.class.php';

$p = new WebPage("Parcs - Sinapp's");


try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();
    switch($user->getIdHabilitation())
    {
		case 1: //Admin
		$droit = 1;
		break;
		case 2: // Utilisateur
		$droit = 2;
		break;
    }

	$msg = "";

	if(isset($_REQUEST['i'])) {
		if(isset($_REQUEST['delete'])) {
			try {
    			Parc::deleteParc($_REQUEST['i']);
    			header("location: ./parcs.php?msg=1");
    			exit;
    		}
    		catch (Exception $e) {
    			header("location: ./parcs.php?msg=2");
    			exit;	    			
    		}
		}

	}

	if(isset($_REQUEST['msg']))
	{
		if($_REQUEST['msg'] == 1)
			$msg = "<div class='succes'>Parc supprimé avec succès.</div>";
		else if($_REQUEST['msg'] == 2)
			$msg = "<div class='rate'>Echec, veuillez réessayer.</div>";
	}

	$p->appendContent(<<<HTML
		<div class="content">
			<div class = "th1">Liste des Parcs</div>
			{$msg}
HTML
	);
	if(!($droit == 2 && $_GET['i'] != $user->getIdEntpPers()))
	{
		$p->appendContent(Parc::getParcByEntreprise($_GET['i']));

		$p->appendContent(<<<HTML
				<input type="button" name="retour" value="Retour" onclick="history.back()">
			</div>
HTML
		);
	}
	else
	{
		header("Location: ./perso.php") ;
		exit;
	}
}

catch (notInSessionException $e) {
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    exit;
}

echo $p->toHTML();