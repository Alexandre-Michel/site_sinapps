<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Contrat.class.php';
require_once 'Entreprise.class.php';
require_once 'Offre.class.php';
require_once 'parc.class.php';

$p = new WebPage("Détail du parc - Sinapp's");

try
{
	$user = Personne::createFromSession();
	if (isset($_GET['i']) && !empty($_GET['i'])) {
		try
		{
			$parc = Parc::createParcFromId($_GET['i']);
			$p->appendContent(<<<HTML
				<div class="content">
					<div class="row th1">Détail du Parc n°{$parc->getIdParc()}</div>
					<div class="row">
						<div>Test</div>
					</div>
					<div class="row">
						<form method="post">
							<input type="button" name="retour" value="Retour" onclick="history.back()">
						</form>	
					</div>
				</div>
HTML
			);
		}
		catch (Exception $e)
		{
			header('location: ./index.php');
			exit;
		}
	}
	else
	{
		header('location: ./entreprises.php'); //A changer
		exit;
	}
}
catch (notInSessionException $e) {
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    die();
}

echo $p->toHTML();