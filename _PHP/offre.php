<?php

require_once 'webpage.class.php';
require_once 'offre.class.php';

$p = new WebPage("Détail de l'offre - Sinapp's");

if (isset($_GET['i']) && !empty($_GET['i']))
{
	try
	{
		$prestation = Offre::createOffreFromId($_GET['i']);
		$p->appendContent(<<<HTML
			<div class='content'>
				<div class = "box">
					{$prestation->getOffreComplete()}
				</div>
			</div>
HTML
		);
	}
	catch (Exception $e)
	{
		header('location: ./offres.php');
		exit;
	}
}
else
{
	header('Location: ./offres.php');
	exit;
}

echo $p->toHTML();