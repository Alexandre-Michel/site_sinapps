<?php

require_once 'webpage.class.php';
require_once 'Incident.class.php';
require_once 'Personne.class.php';
require_once 'Type_incident.class.php';

$p = new WebPage("Nouvel Incident - Sinapp's");

try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();

	$msg = ""; 
	if(isset($_REQUEST['nom']) && !empty($_REQUEST['nom']) && isset($_REQUEST['desc']) && !empty($_REQUEST['desc'])) {
		Incident::createIncident($_REQUEST['nom'], $_REQUEST['desc'], $_REQUEST['type']);
		$msg = 1;
		header("location: ./newIncident.php?msg={$msg}");
		exit;
	}
	else {
		$msg = 2;
		header("location: ./newIncident.php?msg={$msg}");
		exit;
	}
	
	if (isset($_GET["msg"]) && $_GET["msg"] != "") {
		if ($_GET["msg"] == 1) $msg = "<div class='succes'>L'incident a été remporté et sera traité sous peu.</div>";
		else if ($_GET["msg"] == 2) $msg = "<div class='rate'>Echec, veuillez réessayer.</div>";
	}
	
    $p->appendContent(<<<HTML
    	<div class="content">
			<div class="th1">Nouvel Incident</div>
			{$msg}
			<form action="./incidents.php" method="post" onSubmit="return verify(this)">
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
		$desc = ucfirst($unType['description_type_incident']);
		$p->appendContent("<option selected name=\"{$unType['id_type_incident']}\">{$desc}</option>");
	}

	$p->appendContent(<<<HTML
				</select><br/>
				<input type="submit" value="Soumettre">
			</form>
			<script type="text/javascript">
				function verify(form) {
					var passed=false;
						
					var passAct = form.passAct;

					if ( form.password.value !=  form.confirm.value) {
						alert("Les deux mot de passe ne concordent pas");
						 form.password.select();
					}

					else {
						if (passAct.value != '' && passAct.value != null) {
							if (password.length >= 6) {
								passed=true;
								if ( form.password.value != "")  form.password.value = sha1( form.password.value);
								form.confirm.value = "";
								passAct.value = sha1(passAct.value);
							}
							else {
								alert("Mot de passe trop court !");
								password.select();
							}
						}
						else {
							alert("Remplissez votre mot de passe !");
							passAct.select();
						}
					}

					return passed;
				}
			</script>			
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