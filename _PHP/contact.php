<?php 

require_once 'webpage.class.php';

$p = new WebPage("Contact");

$p->appendContent(<<<HTML
	<div class="content">
		<div class="form_contact">
		<form method="post" action="mailto:alexandre.michel@etudiant.univ-reims.fr">
			<div class="champs_contact">
				<input type="text" name="nom" placeholder="Votre nom" class="input_contact"> 
				<input type="text" name="prenom" placeholder="Votre prénom" class="input_contact">
				<input type="email" name="mail" placeholder="Votre adresse mail" class="input_contact">
				<input type="tel" name="telephone" placeholder="Votre téléphone" pattern="[0][0-9]{9}" class="input_contact">
				<input type="text" name="societe" placeholder="Votre société" class="input_contact">
			</div>
			<div class="msg_contact">
				<textarea rows=8 name="message" placeholder="Votre message" class="text_contact"></textarea>
				<input type="text" name="captcha" placeholder="Code anti-spam" class="captcha">
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