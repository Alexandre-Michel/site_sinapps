<?php 

require_once 'webpage.class.php';
require_once 'myPDO.include.php';
require_once 'Personne.class.php';

$pdo = myPDO::getInstance();

$stmt = $pdo->prepare(<<<SQL
	SELECT *
	FROM ENTREPRISE
	WHERE id_entreprise = 1
SQL
);

$stmt->execute();
$sinapps = $stmt->fetch();

$p = new WebPage("Contactez-nous - Sinapp's");

	$nom = "";
	$prenom = "";
	$mail = "";

try {
	$user = Personne::createFromSession();
	$nom = $user->getNomPers();
	$prenom = $user->getPrenomPers();
	$mail = $user->getMailPers();
}
catch (NotInSessionException $e) {

}

//Soumission du formulaire
if(isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Envoyer')
{
	//Existence des variables
	if(isset($_REQUEST['nom']) && !empty($_REQUEST['nom'])
		&& isset($_REQUEST['prenom']) && !empty($_REQUEST['prenom'])
		&& isset($_REQUEST['mail']) && !empty($_REQUEST['mail'])
		&& isset($_REQUEST['message']) && !empty($_REQUEST['message']))
	{
		//Adresse mail valide ?
		if(filter_var($_REQUEST['mail'], FILTER_VALIDATE_EMAIL))
		{
			$form = false;
			$subject = $_REQUEST['nom']." ".$_REQUEST['prenom']." - Contact Sinapps";
			$text = $_REQUEST['message'];
			$from = $_REQUEST['mail'];
			Personne::mail($subject, $text, $from);
		}
		else
		{
			$form = true;
			$message = "Votre mail n'est pas valide.";
		}
	}
	else
	{
		$form = true;
		$message = "Il manque des informations.";
	}
}
else
	$form = true;

if($form)
{
	if(!isset($message))
		$message = "";
	$p->appendContent(<<<HTML
	<div class="content">	
		<div class="infos_contact">
			<div class="row">
				<div class="titre_contact th1">
					Contact
				</div>
				<div class="barre_contact"></div>
				<div class="logo_contact">
					<img src="{$sinapps["path_logo"]}" alt="logo_entp">
				</div>
				<div class="adresse_contact th2">
					{$sinapps["rue_entreprise"]}<br/>
					{$sinapps['cp_entreprise']} {$sinapps['ville_entreprise']}
				</div>
				<div class="tel_contact th1">
					{$sinapps["tel_entreprise"]}
				</div>
			</div>
		</div>
		<div class="titre_contact th1">
			Ou par mail...
		</div>
		<div>{$message}</div>
		<form method="post">
			<div class="form">
				<div class="row">
					<div class="champs">
						<input type="text" name="nom" placeholder="Votre nom" class="input_contact" value={$nom}> 
						<input type="text" name="prenom" placeholder="Votre prénom" class="input_contact" value={$prenom}>
						<input type="email" name="mail" placeholder="Votre adresse mail" class="input_contact" value={$mail}>
						<input type="tel" name="telephone" placeholder="Votre téléphone" pattern="[0][0-9]{9}" class="input_contact">
						<input type="text" name="societe" placeholder="Votre société" class="input_contact">
					</div>
					<div class="msg_contact">
						<textarea rows=8 name="message" placeholder="Votre message" class="text_contact"></textarea>
						<input type="text" name="captcha" placeholder="Code anti-spam" class="input_contact" id="captcha">
					</div>
				</div>	

				<div class="row">
					<div class="envoi_contact">
						<input type="submit" name="submit" value="Envoyer" id="envoi_bouton">
					</div>
				</div>
			</div>
		</form>
		
	</div>
HTML
	);
}

echo $p->toHTML();