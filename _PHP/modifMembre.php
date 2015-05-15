<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Entreprise.class.php';
require_once 'Habilitation.class.php';


$p = new WebPage("Entreprises - Sinapp's");


try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();
    if (isset($_GET['i']) && !empty($_GET['i'])) {
	    if ($user->estHabilite()) {

	    	$msg = "";
	    	if(isset($_REQUEST['msg'])) {
	    		if($_REQUEST['msg'] == 1) {
	    			$msg = "<div class='succes'>Personne modifié avec succès.</div>";
	    		}
	    		else if($_REQUEST['msg'] == 2) {
	    			$msg = "<div class='rate'>Echec, veuillez réessayer.</div>";
	    		}
	    	}

	    	$membre = Personne::createPersFromId($_REQUEST['i']);
	    	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == "Sauvegarder") {

		    	if(isset($_REQUEST['nom']) && $_REQUEST['nom'] != "" && isset($_REQUEST['prenom']) && $_REQUEST['prenom'] != "" && isset($_REQUEST['mail']) && $_REQUEST['mail'] != "" && isset($_REQUEST['habilitation']) ) {

					$nom = $_REQUEST['nom'];
					$membre->setNomPers($nom);

					$prenom = $_REQUEST['prenom'];
					$membre->setPrenomPers($prenom);

					$mail = $_REQUEST['mail'];
					$membre->setMailPers($mail);

					$hab = $_REQUEST['habilitation'];
					$membre->setIdHabilitation($hab);

					$entp = $_REQUEST['entp'];
					$membre->setIdEntreprise($entp);

					$emploi = $_REQUEST['emploi'];
					$membre->setEmploiPers($emploi);

					$msg = 1;
					header("location: ./modifMembre.php?msg={$msg}");
					exit;
				}
				else {
					$msg = 2;
					header("location: ./modifMembre.php?msg={$msg}");
					exit;
				}
			}

			$tabHabilitation = Habilitation::getAllHabilitations();
			$hab = "<select name='habilitation'>";
			foreach($tabHabilitation as $uneHab) {
				if($membre->getIdHabilitation() == $uneHab->getIdHab()) {
					$hab .= "<option selected value='{$uneHab->getIdHab()}'>{$uneHab->getNomHab()}</option>";
				}
				else {
					$hab .= "<option value='{$uneHab->getIdHab()}'>{$uneHab->getNomHab()}</option>";
				}
				
			}
			$hab .= "</select>";

			$tabEntp = Entreprise::getAllEntreprisesTab();
			$entreprises = "<select name='entp'>";
			foreach($tabEntp as $uneEntp) {
				if($membre->getIdEntpPers() == $uneEntp->getIdEntreprise()) {
					$entreprises .= "<option selected value='{$uneEntp->getIdEntreprise()}'>{$uneEntp->getNomEntreprise()}</option>";
				}
				else {
					$entreprises .= "<option value='{$uneEntp->getIdEntreprise()}'>{$uneEntp->getNomEntreprise()}</option>";
				}
				
			}
			$entreprises .= "</select>";

			$p->appendContent(<<<HTML
			<div class="content">
				<div class = "th1">Modifier le profil</div>
			    <form method="post">
			        <div class = "msg">{$msg}</div>
			        <div class="box1">
			        	<div class = "row">
				        	<div class = "champs">
					            <label for="nom">Nom d'utilisateur</label>
					            	<input type="text" required name="nom" value="{$membre->getNomPers()}" placeholder="Votre NOM"><br/>
					            <label for="prenom">Prénom d'utilisateur</label>
					            	<input type="text" required name="prenom" value="{$membre->getPrenomPers()}" placeholder="Votre Prenom"><br/>
					            <label for="mail">Email</label>
					            	<input type="text" required name="mail" value="{$membre->getMailPers()}" placeholder="Votre adresse e-mail"><br/>
					     		<label for="emploi">Emploi</label>
					            	<input type="text" name="emploi" value="{$membre->getEmploiPers()}" placeholder="Votre adresse e-mail"><br/>
					            <label for="habilitation">Habilitation</label>
					            	{$hab}
					            <label for="entp">Entreprise</label>
					            	{$entreprises}
					            	
					            <input type="submit" name="submit" value="Sauvegarder">
					            <input type="button" name="retour" value="Retour" onclick="history.back()">
					        </div>
				        </div>
			        </div>
			    </form>

HTML
			);
		}

		else {
			header('location: ./index.php');
			exit;
		}
	}
	else {
		header('location: ./membres.php');
		exit;
	}
}

catch (notInSessionException $e) {
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    exit;
}

echo $p->toHTML();