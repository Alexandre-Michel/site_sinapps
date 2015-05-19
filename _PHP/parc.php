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
    
    if ($user->estHabilite()) {

    	$msg = "";

    	if(isset($_REQUEST['i'])) {
    		if(isset($_REQUEST['delete'])) {
    			try {
	    			Entreprise::deleteEntreprise($_REQUEST['i']);
	    			header("location: ./parc.php?msg=1");
	    			exit;
	    		}
	    		catch (Exception $e) {
	    			header("location: ./parc.php?msg=2");
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

		$p->appendContent(Parc::getParcByEntreprise($_GET['i']));

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