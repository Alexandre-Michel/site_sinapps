<?php

require_once 'webpage.class.php';
require_once 'myPDO.include.php';
require_once 'Personne.class.php';

$pdo = myPDO::getInstance();

$stmt = $pdo->prepare(<<<SQL
	SELECT COUNT(*) AS nbre
	FROM PERSONNE
	WHERE mail_personne = :mail
SQL
);

$email = empty($_POST['mail']) ? '' : $_POST['mail'];

$stmt->bindValue(':mail', $email);
$stmt->execute();
$count = $stmt->fetch();

$p = new WebPage("Inscription | Sinapp's");

//Soumission du formulaire
if(isset($_POST['inscription']) && $_POST['inscription'] == 'Inscription')
{
	//Existence des variables
	if((isset($_POST['mail']) && !empty($_POST['mail'])) && (isset($_POST['password']) && !empty($_POST['password'])) && (isset($_POST['confirm']) && !empty($_POST['confirm'])))
	{
		//Correspondance des mots de passe
		if($_POST['password'] == $_POST['confirm'])
		{
			//Vérification de la longueur du mot de passs (6 caractères au minimum)
			if(strlen($_POST['password']) >= 6)
			{
				//Adresse mail valide ?
				if(filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
				{
					//Vérification qu'il n'y a pas déjà un utilisateur avec le même mail
					if($count["nbre"] == 0)
					{
						//Création de l'utilisateur via son nom, prenom, mail et mot de passe
						Personne::createPersonne($_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['password']);
						$form = false;
						$message = "Votre inscription s'est bien déroulée.";
					}
					//Adresse mail déjà utilisée
					else
					{
						$message = "L'adresse mail que vous avez rentrée est déjà utilisée.";
						$form = true;
					}
				}
				//Adresse mail non valide
				else
				{
					$message = "L'adresse mail que vous avez rentrée n'est pas valide.";
					$form = true;
				}
			}
			//Mot de passe trop court (moins de 6 caractères)
			else
			{
				$message = "Le mot de passe que vous avez saisi n'est pas assez long (6 caractères minimum).";
				$form = true;
			}
		}
		//Le mot de passe et la confirmation ne coïncident pas
		else
		{
			$message = "Les mots de passes saisis ne sont pas identiques.";
			$form = true;
		}
	}
	else
	{
		$message = "Vous n'avez pas remplis les champs du formulaire.";
		$form = true;
	}
}
else
	$form = true;

$p->appendContent(<<<HTML
	<div class="content">
		<div class="title">
			<div class = "th1">Inscription</div>
		</div>
HTML
);

if($form)
{
    //On affiche un message s'il y a lieu
    if(isset($message))
        $message = "<div class=\"message\">".$message."</div>";
    else
    	$message = '';

    if(isset($_POST['nom']))
    	$nom_value = $_POST['nom'];
    else
    	$nom_value = '';
    if(isset($_POST['prenom']))
    	$prenom_value = $_POST['prenom'];
    else
    	$prenom_value = '';
    if(isset($_POST['mail']))
    	$mail_value = $_POST['mail'];
    else
    	$mail_value = '';
    //On affiche le formulaire
	$p->appendContent(<<<HTML
		    <form action="inscription.php" method="post">
		        <div class = "msg">{$message}</div>
		        <div class="form">
		        	<div class = "row">
			        	<div class = "champs">
				            <label for="nom">Nom d'utilisateur (*)</label>
				            	<input type="text" name="nom" value="{$nom_value}" placeholder="Votre NOM"><br/>
				            <label for="prenom">Prénom d'utilisateur (*)</label>
				            	<input type="text" name="prenom" value="{$prenom_value}" placeholder="Votre Prenom"><br/>
				            <label for="password">Mot de passe (6 caractères min.) (*)</label>
				            	<input type="password" name="password" placeholder="Veuillez entrer votre mot de passe"><br/>
				            <label for="confirm">Mot de passe (vérification) (*)</label>
				            	<input type="password" name="confirm" placeholder="Veuillez confirmer votre mot de passe"><br/>
				            <label for="mail">Email (*)</label>
				            	<input type="text" name="mail" value="{$mail_value}" placeholder="Votre adresse e-mail"><br/>
				            <div class = "obligatoire">Les champs précédés d'un astérisque (*) sont obligatoires</div>
				            <input type="submit" name="inscription" value="Inscription">
				        </div>
			        </div>
		        </div>
		    </form>
HTML
	);
}

else
{
	$p->appendContent(<<<HTML
		<div class="msg">{$message}</div>
		<div class="msg">Vous pouvez dès à présent vous connecter.</div>
HTML
	);
}

$p->appendContent("</div>");
echo $p->toHTML();

header( "Refresh:5; ./connexion.php", TRUE, 303);
