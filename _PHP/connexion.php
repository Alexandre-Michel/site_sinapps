<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';


$p = new WebPage("Connexion - Sinapp's");


try {
    // Lecture depuis les données de session
    $u = Personne::createFromSession() ;

    // Tout va bien, on continue : affichage du profile et bouton déconnexion
    $form = Personne::logoutForm('Se déconnecter', $_SERVER['PHP_SELF']) ;
    $p->appendContent(<<<HTML
        {$u->profile()}
        {$form}
HTML
) ;
}
catch (NotInSessionException $e) {
}

$p->appendContent(Personne::connexionForm("./auth.php?action=login", "Connecter"));

echo $p->toHTML();