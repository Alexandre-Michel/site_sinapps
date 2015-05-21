<?php

require_once 'webpage.class.php';
require_once 'Incident.class.php';
require_once 'Personne.class.php';
require_once 'Type_incident.class.php';
require_once 'Parc.class.php';
require_once 'Entreprise.class.php';


$p = new WebPage("Nouvel Incident - Sinapp's");

try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();
	
	$parcs = "";
	
	try {
		$listeParcs = Parc::getParcByIdEntreprise($user->getIdEntpPers());
		$parcs = "<div class='obligatoire'>Nom du parc</div><select name='parc'>";
		foreach($listeParcs as $unParc) {
			$parcs .= "<option value='{$unParc->getIdParc()}'>{$unParc->getNomParc()}</option>";
		}
		$parcs .= "<option selected value='null'>Non renseigné</option>
		</select><br/>";
	}
	catch (Exception $e) {
		
	}
	
	$msg = ""; 
	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == "Soumettre") {
		if(isset($_REQUEST['nom']) && $_REQUEST['nom'] != "" && isset($_REQUEST['desc']) && $_REQUEST['desc'] != "" && isset($_REQUEST['parc'])) {
			Incident::createIncident($_REQUEST['nom'], $_REQUEST['desc'], $_REQUEST['type'], $_REQUEST['parc'], $user->getIdEntpPers());
			$msg = 1;
			header("location: ./newIncident.php?msg={$msg}");
			exit;
		}
		else {
			$msg = 2;
			header("location: ./newIncident.php?msg={$msg}");
			exit;
		}
	}
	
	if (isset($_GET["msg"]) && $_GET["msg"] != "") {
		if ($_GET["msg"] == 1) $msg = "<div class='succes'>L'incident a été reporté et sera traité sous peu.</div>";
		else if ($_GET["msg"] == 2) $msg = "<div class='rate'>Echec, veuillez réessayer.</div>";
	}
	
    $p->appendContent(<<<HTML
    	<div class="content">
			<div class="box1">
			<div class="th1">Nouvel Incident</div>
			{$msg}
			<form method="post"> 
				<input type="text" required placeholder="Nom de l'incident" name="nom"/><br/>
				<textarea required row=8 placeholder="Description de votre incident" name="desc"></textarea><br/>
				<div class='obligatoire'>Type du problème</div>
				<select required name="type">
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
		$p->appendContent("<option value='{$unType['id_type_incident']}'>{$desc}</option>");
	}

	$p->appendContent(<<<HTML
				</select><br/>
				{$parcs}
				<div class = "obligatoire">Si le parc n'est pas renseigné, les frais forfaitaires s'appliqueront.</div><br/>
				<input type="submit" name="submit" value="Soumettre">
			</form>
			<input type="button" name="retour" value="Retour" onclick="history.back()">
			</div>
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