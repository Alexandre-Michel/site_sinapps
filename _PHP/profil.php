<?php 

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'perso.php';

$p = new WebPage("Espace personnel - Sinapp's");


try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession() ;

    $msg = "";

    $p->appendContent(<<<HTML
    	<div class="content">
			<div class="title">
				<div class = "th1">Modifier votre profil</div>
			</div>
		    <form action="profil.php" method="post">
		        <div class = "msg">{$msg}</div>
		        <div class="form">
		        	<div class = "row">
			        	<div class = "champs">
				            <label for="nom">Nom d'utilisateur</label>
				            	<input type="text" name="nom" value="{$user->getNomPers()}" placeholder="Votre NOM"><br/>
				            <label for="prenom">Prénom d'utilisateur</label>
				            	<input type="text" name="prenom" value="{$user->getPrenomPers()}" placeholder="Votre Prenom"><br/>
				            <label for="mail">Email</label>
				            	<input type="text" name="mail" value="{$user->getMailPers()}" placeholder="Votre adresse e-mail"><br/>
				            <label for="password">Nouveau mot de passe (6 caractères min.)</label>
				            	<input type="password" name="password" placeholder="Veuillez entrer votre mot de passe"><br/>
				            <label for="confirm">Nouveau mot de passe (vérification)</label>
				            	<input type="password" name="confirm" placeholder="Veuillez confirmer votre mot de passe"><br/>
							<label for="passAct">Mot de passe actuel</label>
				            	<input type="password" name="passAct" placeholder="Veuillez entrer votre mot de passe actuel"><br/>
				            <input type="submit" name="inscription" value="Inscription">
				        </div>
			        </div>
		        </div>
		    </form>
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