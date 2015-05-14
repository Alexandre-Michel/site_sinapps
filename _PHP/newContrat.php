<?php

require_once 'webpage.class.php';
require_once 'Entreprise.class.php';
require_once 'Personne.class.php';
require_once 'Contrat.class.php';
require_once 'Offre.class.php';

$p = new WebPage("Nouveau Contrat - Sinapp's");

try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();

	$msg = ""; 
	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == "Soumettre") {
		if(isset($_REQUEST['nom']) && $_REQUEST['nom'] != "" && isset($_REQUEST['desc']) && $_REQUEST['desc'] != "") {
			Incident::createIncident($_REQUEST['nom'], $_REQUEST['desc']);
			$msg = 1;
			header("location: ./newContrat.php?msg={$msg}");
			exit;
		}
		else {
			$msg = 2;
			header("location: ./newContrat.php?msg={$msg}");
			exit;
		}
	}
	
	if (isset($_GET["msg"]) && $_GET["msg"] != "") {
		if ($_GET["msg"] == 1) $msg = "<div class='succes'>Le contrat a été crée.</div>";
		else if ($_GET["msg"] == 2) $msg = "<div class='rate'>Echec, veuillez réessayer.</div>";
	}
	
    $p->appendContent(<<<HTML
    	<div class="content">
			<div class="th1">Nouveau Contrat</div>
			{$msg}
			<form method="post"> 
				<input type="date" required name="dateDeb"/><br/>
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
		$desc = ucfirst($unType['description_type_incident']);
		$p->appendContent("<option selected name=\"type_inc\">{$desc}</option>");
	}

	$p->appendContent(<<<HTML
				</select><br/>
				<input type="submit" name="submit" value="Soumettre">
			</form>
			<input type="button" name="retour" value="Retour" onclick="history.back()">
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