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
		if(isset($_REQUEST['dateDeb']) && $_REQUEST['dateDeb'] != "" && isset($_REQUEST['dateFin']) && $_REQUEST['dateFin'] != "" && isset($_REQUEST['entp']) && isset($_REQUEST['offre'])) {
			Contrat::createContrat($_REQUEST['entp'], 1, $_REQUEST['offre'], $_REQUEST['dateDeb'], $_REQUEST['dateFin'], "12h");
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
				<label for="dateDeb">Date de signature :</label>
				<input type="date" required name="dateDeb"/><br/>
				<label for="dateFin">Date d'expiration :</label>
				<input type="date" required name="dateFin"/><br/>
				<label for="entp">Entreprise concernée :</label>
				<select name="entp">
HTML
	);

	$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT *
		FROM ENTREPRISE
SQL
	);	
	$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);	
	$stmt->execute();
	$arrayEntp = $stmt->fetchAll();

	foreach ($arrayEntp as $uneEntp) {
		$nom = ucfirst($uneEntp['nom_entreprise']);
		$p->appendContent("<option selected value=\"{$uneEntp['id_entreprise']}\">{$nom}</option>");
	}

	$p->appendContent("</select><br/><label for=\"offre\">Le contrat concerne :</label><select name='offre'>");

	$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT *
		FROM OFFRE
SQL
	);	
	$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);	
	$stmt->execute();
	$arrayOffre = $stmt->fetchAll();

	foreach ($arrayOffre as $uneOffre) {
		$nomOff = ucfirst($uneOffre['nom_offre']);
		$p->appendContent("<option selected value=\"{$uneOffre['id_offre']}\">{$nomOff}</option>");
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