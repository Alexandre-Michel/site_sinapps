<?php

require_once 'webpage.class.php';
require_once 'offre.class.php';

$p = new WebPage("Détail de l'offre - Sinapp's");

if (isset($_GET['i']) && !empty($_GET['i']))
{
	try
	{
		$offre = Offre::createOffreFromId($_GET['i']);
		$p->appendContent(<<<HTML
			<div class='content'>
				{$offre->getOffreComplete()}
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