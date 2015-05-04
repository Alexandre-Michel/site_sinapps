<?php 

require_once 'webpage.class.php';
require_once 'myPDO.include.php';

$pdo = myPDO::getInstance();

$stmt = $pdo->prepare(<<<SQL
	SELECT nom_personne AS nom_pers, prenom_personne AS p_pers, image_personne AS img_pers, emploi_personne AS emp_pers
	FROM PERSONNE
	WHERE id_entreprise_pers = 1
SQL
);

$stmt->execute();
$sinapps = $stmt->fetchAll();

var_dump($sinapps);

$p = new WebPage("Contactez-nous | Sinapp's");
/*
$p->appendContent(<<<HTML
	<div class="content">	
		<div class="infos_equipe">
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
	</div>
HTML
);
*/
echo $p->toHTML();