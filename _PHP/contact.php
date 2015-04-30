<?php 

require_once 'webpage.class.php';

$pdo = myPDO::getInstance();

$stmt = $pdo->prepare(<<<SQL
	SELECT *
	FROM ENTREPRISE
	WHERE id_entreprise = 1
SQL
);

$stmt->setFetchMode("__FETCH_ASSOC__");
$stmt->execute();
$sinapps = $stmt->fetch();

$p = new WebPage("Contactez-nous | Sinapp's");

$p->appendContent(<<<HTML
	<div class="content">	
		<form method="post" action="mailto:alexandre.michel@etudiant.univ-reims.fr">

			<div class="infos_contact">
				<div class="row">
					<div class="titre_contact th1">
						Contact
					</div>
					<div class="barre_contact"></div>
					<div class="nom_contact">
						{$sinapps["nom_entreprise"]}
					</div>
					<div class="adresse_contact">
						{$sinapps["rue_entreprise"]}<br/>
						{$sinapps['cp_entreprise']}{$sinapps['ville_entreprise']}
					</div>
					<div class="tel_contact">
						{$sinapps["tel_entreprise"]}
					</div>
				</div>
			</div>

			<div class="form_contact">
				<div class="row">
					<div class="champs_contact">
						<input type="text" name="nom" placeholder="Votre nom" class="input_contact"> 
						<input type="text" name="prenom" placeholder="Votre prénom" class="input_contact">
						<input type="email" name="mail" placeholder="Votre adresse mail" class="input_contact">
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
						<input type="submit" value="Envoyer" id="envoi_bouton">
					</div>
				</div>
			</div>
		</form>
		
	</div>
HTML
);

echo $p->toHTML();