<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Parc.class.php';

$p = new WebPage("Nouveau Parc - Sinapp's");

try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();

	if($user->estHabilite()) {
		
		$value = "";
		if (isset($_REQUEST['i']) && !empty($_GET['i'])) {
			$status = "Modification";
			$parc = Parc::createParcFromId($_REQUEST['i']);
			$value = "value='" . $parc->getNomParc() . "'";
		}
		else {
			$status = "Nouveau";
		}
	
		$msg = ""; 
		if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == "Soumettre") {
			if(isset($_REQUEST['nom']) && $_REQUEST['nom'] != "") {
				if (isset($_REQUEST['i']) && $_REQUEST['i'] != "") {			
					$parc->setNomParc($_REQUEST['nom']);
					$msg = 3;
					header("location: ./newParc.php?msg={$msg}");
					exit;
				}
				else {
					$idEntp = $user->getIdEntpPers();
					$idResp = isset($_REQUEST['select_resp']) ? $_REQUEST['select_resp'] : $user->getIdPers();
					Parc::createParc($idEntp, $idResp);
					$msg = 1;
					header("location: ./newParc.php?msg={$msg}");
					exit;
				}
			}
			else {
				$msg = 2;
				header("location: ./newParc.php?msg={$msg}");
				exit;
			}
		}
		
		if (isset($_GET["msg"]) && $_GET["msg"] != "") {
			if ($_GET["msg"] == 1) $msg = "<div class='succes'>Parc créée avec succès.</div>";
			else if ($_GET["msg"] == 2) $msg = "<div class='rate'>Echec, veuillez réessayer.</div>";
			else if ($_GET["msg"] == 3) {
				$msg = "<div class='succes'>Parc modifié avec succès.</div>";
				$status = "Modification";
			}
			
		}
		
		$p->appendContent(<<<HTML
			<div class="content">
				<div class="th1">Nouveau Parc</div>
				{$msg}
				<form method="post"> 
					<div class="champs">
						<select id="select_resp" name="responsable"> 
HTML
		);

		$personnes = Personne::getPersByIdEntp($user->getIdEntpPers());
		$option = "";
		foreach ($personnes as $personne) {
			$name = $personne->getNomPers()." ".$personne->getPrenomPers();
			$option .= "<option value=\"{$personne->getIdPers()}\">{$name}</option>";
		}

		$p->appendContent(<<<HTML
							{$option}
						</select>
						<input type="submit" name="submit" value="Soumettre">
					</div>	
				</form>
				<input type="button" name="retour" value="Retour" onclick="history.back()">
	    	</div>	
HTML
		);
	}
	else {
		header("Location: ./index.php") ;
		exit;
	}
}

catch (notInSessionException $e) {
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    die() ;
}

echo $p->toHTML();