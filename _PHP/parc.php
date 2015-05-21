<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Contrat.class.php';
require_once 'Entreprise.class.php';
require_once 'Offre.class.php';
require_once 'parc.class.php';
require_once 'appareil.class.php';

$p = new WebPage("Détail du parc - Sinapp's");

try
{
	$user = Personne::createFromSession();
	$idEntp = $user->getIdEntpPers();
	if (isset($_GET['i']) && !empty($_GET['i'])) {
		try
		{
			$parc = Parc::createParcFromId($_GET['i']);
			if($idEntp == $parc->getIdEntreprise());
			{
				$num = $parc->getIdParc();
				$appareils = Appareil::getAppareilByParc($num);
				$p->appendContent(<<<HTML
					<div class="content">
						<div class="row th1">Détail du Parc n°{$num}</div>
						<div class="row">
							{$appareils}
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
			else
			{
				header('location: ./perso.php');
				exit;
			}
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