<?php

require_once 'webpage.class.php';
require_once 'Type_Prestation.class.php';

$p = new WebPage("Détail de la préstation - Sinapp's");

if (isset($_GET['i']) && !empty($_GET['i']))
{
	try
	{
		$prestation = Type_Prestation::createTypePrestationFromId($_GET['i']);
		$p->appendContent(<<<HTML
			<div class='content'>
				<div class = "intro_box">
					<div class = "box1">
						{$prestation->printTypePrestaComplete()}
					</div>
				</div>
			</div>
HTML
		);
	}
	catch (Exception $e)
	{
		header('location: ./prestations.php');
		exit;
	}
}
else
{
	header('Location: ./prestations.php');
	exit;
}

echo $p->toHTML();