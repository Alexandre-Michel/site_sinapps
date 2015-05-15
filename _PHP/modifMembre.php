<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Contrat.class.php';
require_once 'Entreprise.class.php';
require_once 'Offre.class.php';
require_once 'Personne.class.php';

$p = new WebPage("Modification de membre - Sinapp's");

try
{
    // Lecture depuis les données de session
    $user = Personne::createFromSession();
    
    //On regarde si l'utilisateur est habilité
    if ($user->estHabilite())
    {
    	$msg = "";


    }
}