<?php 

require_once 'webpage.class.php';

$p = new WebPage("Contact");

$p->appendContent(<<<HTML
	<div class="content">
		<form method="post" action="mailto:alexandre.michel@etudiant.univ-reims.fr">
			<input type="text" name="nom" placeholder="Votre nom"> 
			<input type="text" name="prenom" placeholder="Votre prénom">
			<input type="email" name="mail" placeholder="Votre adresse mail">
			<input type="tel" name="telephone" placeholder="Votre téléphone">
			<input type="text" name="societe" placeholder="Votre société">
			<textarea rows=5 name="message">Votre message</textarea>
			<input type="submit" value="Envoyer">
		</form>
	</div>
HTML
);

echo $p->toHTML();