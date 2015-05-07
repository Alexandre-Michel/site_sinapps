<?php

require_once 'webpage.class.php';
require_once 'Incident.class.php';
require_once 'Personne.class.php';
require_once 'Type_incident.class.php';

$p = new WebPage("Nouvel Incident - Sinapp's");

try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();

    $p->appendContent(<<<HTML
    	<div class="content">
    		<input type="text" required placeholder="Nom de l'incident" name="nom"/><br/>
			<textarea required row=8 placeholder="Description de votre incident" name="desc"></textarea><br/>
			<select name="type">
HTML
	);

	$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT *
		FROM TYPE_INCIDENT
SQL
	);	
	$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);	
	$stmt->execute();
	$arrayType = $stmt->fetchAll();

	foreach ($arrayType as $unType) {
		$p->appendContent("<option selected name=\"{$unType->id_type_incident}\">{$unType->type_incident}</option>");
	}

	$p->appendContent(<<<HTML
			</select>
			<input type="submit" value="Soumettre">
    	</div>	
HTML
    );
}

catch (notInSessionException $e) {
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    die() ;
}

echo $p->toHTML();