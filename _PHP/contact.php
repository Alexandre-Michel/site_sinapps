<?php 

require_once 'webpage.class.php';

$p = new WebPage("Contact");

$p->appendContent(<<<HTML
	<div class="content">
		<div class="form_contact">
		<form method="post" action="mailto:alexandre.michel@etudiant.univ-reims.fr">
			<div class="champs_contact">
				<input type="text" name="nom" placeholder="Votre nom"> 
				<input type="text" name="prenom" placeholder="Votre prénom">
				<input type="email" name="mail" placeholder="Votre adresse mail">
				<input type="tel" name="telephone" placeholder="Votre téléphone" pattern="[0][0-9]{9}">
				<input type="text" name="societe" placeholder="Votre société">
			</div>
			<div class="msg_contact">
				<textarea rows=5 name="message" placeholder="Votre message"></textarea>
			</div>
			<div class="envoi_contact">	
				<input type="submit" value="Envoyer">
			</div>
		</form>
		</div>
	</div>
HTML
);

echo $p->toHTML();