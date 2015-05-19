<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Contrat.class.php';
require_once 'Entreprise.class.php';
require_once 'Offre.class.php';
require_once 'parc.class.php';

$p = new WebPage("Parc(s) - Sinapp's");

try
{
    // Lecture depuis les données de session
    $user = Personne::createFromSession();
    if (isset($_GET['i']) && !empty($_GET['i']))
    {
	    if ($user->estHabilite())
	    {
			$p->appendContent(<<<HTML
				<div class="content">
					<div class = "th1">Liste des membres</div>
HTML
			);
	    	$p->appendContent(Parc::getParcByEntreprise($_GET['i']));
			$p->appendContent(<<<HTML
					<input type="button" name="retour" value="Retour" onclick="history.back()">
				</div>
HTML
			);
	    }
	    else
		{
			header('location: ./index.php');
			exit;
		}
	}

}
catch (notInSessionException $e)
{
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    exit;
}

echo $p->toHTML();