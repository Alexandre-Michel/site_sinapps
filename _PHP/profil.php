<?php 

require_once 'webpage.class.php';
require_once 'Personne.class.php';

$p = new WebPage("Espace personnel - Sinapp's");


try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession() ;

	$msg = "";
	
	if (isset($_REQUEST['passAct']) && $_REQUEST['passAct'] != '') {
		$passAct = sha1($_REQUEST['passAct']);
		$stmt = myPDO::getInstance()->prepare(<<<SQL
					SELECT mdp_personne
					FROM PERSONNE
					WHERE mdp_personne = :passAct
					AND id_personne = :num
SQL
	);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
		$stmt->bindValue(':passAct', $passAct);
		$stmt->bindValue(':num', $user->getIdPers());
		$stmt->execute() ;
		$member = $stmt->fetch();
		if ($member == false) {
			$msg = 3;
			header("location: ./profil.php?msg={$msg}");
			exit;
		}
		else {

			$msg = 1;
			
			// NOM
			if (isset($_REQUEST["nom"]) && $_REQUEST["nom"] != "") {
				$user->setNomPers($_REQUEST["nom"]);
			}

			// PASS
			if (isset($_REQUEST['password']) && $_REQUEST['password'] != '') {
				if (isset($_REQUEST['confirm']) && $_REQUEST['confirm'] != '') {
					$pass = $_REQUEST['password'];
					$confirm = $_REQUEST['confirm'];
					if ($pass == $confirm) {
						if (strlen($pass) >= 6) {
							$pwd = sha1($pass);
							$user->setPassword($pwd);
						}
						else {
							$msg = 4;
							header("location: ./profil.php?msg={$msg}");
							exit;
						}
					}
					else {
						$msg = 5;
						header("location: ./profil.php?msg={$msg}");
						exit;
					}
				}
				
			}
			
			// PRENOM
			if (isset($_REQUEST['prenom']) && $_REQUEST['prenom'] != '') {
				$user->setPrenomPers($_REQUEST['prenom']);
			}	
			
			// EMAIL
			if (isset($_REQUEST['mail']) && $_REQUEST['mail'] != '') {
				try {
					$user->setMailPers($_REQUEST['mail']);
				} catch (Exception $e) {
					$msg = 2;
				}
			}
			
			header("location: ./profil.php?msg={$msg}");
			exit;
			
		}	
	}

	if (isset($_GET["msg"])) {
		if ($_GET["msg"] == 1) $msg = "<div class='succes'>Profil modifié avec succès.</div>";
		else if ($_GET["msg"] == 2) $msg = "<div class='rate'>L'email spécifié est déjà utilisé par un autre membre.</div>";
		else if ($_GET["msg"] == 3) $msg = "<div class='rate'>Mot de passe incorrect.</div>";
		else if ($_GET["msg"] == 4) $msg = "<div class='rate'>Nouveau mot de passe trop court.</div>";
		else if ($_GET["msg"] == 5) $msg = "<div class='rate'>Vos mots de passe ne concordent pas.</div>";
	}

    $p->appendContent(<<<HTML
    	<div class="content">
			<div class = "th1">Modifier votre profil</div>
		    <form action="profil.php" method="post" onSubmit="return verify(this)">
		        <div class = "msg">{$msg}</div>
		        <div class="box1">
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
							<label for="passAct">Mot de passe actuel (*)</label>
				            	<input type="password" required name="passAct" placeholder="Veuillez entrer votre mot de passe actuel"><br/>
				            <input type="submit" name="save" value="Sauvegarder">
				        </div>
			        </div>
		        </div>
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