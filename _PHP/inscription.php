<?php

require_once 'webpage.class.php';
require_once 'myPDO.include.php';
require_once 'Personne.class.php';

$pdo = myPDO::getInstance();

$stmt = $pdo->prepare(<<<SQL
	SELECT count(*)
	FROM PERSONNE
	WHERE mail_personne = :mail
SQL
);

$stmt->bindValue(':mail', $_POST['mail']);
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
					/*
					//Vérification qu'il n'y a pas déjà un utilisateur avec le même mail
					if($count == 0)
					{
						//Création de l'utilisateur via son nom, prenom, mail et mot de passe
						createPersonne($_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['password']);
						$form = false;
					}
					//Adresse mail déjà utilisée
					else
					{
						$message = "L'adresse mail que vous avez rentrée est déjà utilisée.";
						$form = true;
					}
					*/
					Personne::createPersonne($_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['password']);
					$form = false;
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
		$form = true;
}
else
	$form = true;

if($form)
{
    //On affiche un message sil y a lieu
    if(isset($message))
        echo '<div class="message">'.$message.'</div>';

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
		<div class="content">
		    <form action="inscription.php" method="post">
		        Veuillez remplir ce formulaire pour vous inscrire:<br/>
		        <div class="center">
		            <label for="nom">Nom d'utilisateur</label>
		            	<input type="text" name="nom" value="{$nom_value}"><br/>
		            <label for="prenom">Prénom d'utilisateur</label>
		            	<input type="text" name="prenom" value="{$prenom_value}"/><br/>
		            <label for="password">Mot de passe (6 caractères min.)</label>
		            	<input type="password" name="password"><br/>
		            <label for="confirm">Mot de passe (vérification)</label>
		            	<input type="password" name="confirm"><br/>
		            <label for="mail">Email</label>
		            	<input type="text" name="mail" value="{$mail_value}"><br/>
		            <input type="submit" name="inscription" value="Inscription">
		        </div>
		    </form>
		</div>
HTML
	);
}

echo $p->toHTML();
