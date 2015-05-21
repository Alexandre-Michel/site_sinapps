<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Parc.class.php';
require_once 'Appareil.class.php';

$p = new WebPage("Nouveau Parc - Sinapp's");

try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();

	if($user->estHabilite()) {
		$msg = "";
		$idParc = "";
		if(isset($_REQUEST['submit']) && $_REQUEST['submit'] == "Soumettre")
		{
			if(isset($_REQUEST['parc']) && !empty($_REQUEST['parc']) && isset($_REQUEST['type']) && !empty($_REQUEST['type']))
			{
				$idParc = $_GET['i'];
				$idType = "";
				$name = "";
				Appareil::createAppareil($idParc, $idType, $name);
				$msg = 1;
			}
			else
				$msg = 2;

			header("location: ./newAppareil.php?i={$_GET['i']}&msg={$msg}");
			exit;
		}

		if(isset($_GET['msg']) && !empty($_GET['msg']))
		{
			if ($_GET["msg"] == 1) $msg = "<div class='succes'>Appareil créé avec succès.</div>";
			else if ($_GET["msg"] == 2) $msg = "<div class='rate'>Echec, veuillez réessayer.</div>";
		}

		$p->appendContent(<<<HTML
			<div class="content">
				<div class="th1">Nouvel Appareil</div>
				{$msg}
				<form method="post"> 
					<div class="form">
						<div class="row">
							<div class="champs">
								<label for="nom">Nom de l'appareil</label>
								<input type="text" name="nom"/><br/>
								<label for="serie">N° de série de l'appareil</label>
								<input type="text" name="serie"/><br/>
								<label for="mac">Adresse MAC de l'appareil</label>
								<input type="text" name="mac"/><br/>
								<label for="parc">Numéro de Parc</label>
								<input type="text" name="parc" value="{$idParc}"/><br/>
								<label for="type">Type de l'appareil</label>
								<select name"type">
HTML
		);

		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT type_appareil
			FROM TYPE_APPAREIL
SQL
		);
		$stmt->execute();
		$array = $stmt->fetchAll();

		foreach ($array as $ligne)
			$p->appendContent("<option value={$ligne['type_appareil']}>{$ligne['type_appareil']}</option>");
		
		$p->appendContent(<<<HTML
								</select><br/>
								<input type="submit" name="submit" value="Soumettre">
							</div>
						</div>
					</div>
				</form>
				<input type="button" name="retour" value="Retour" onclick="history.back()">
	    	</div>	
HTML
		);

	}
	else
	{
		header('location: ./index.php');
		exit;
	}
}
catch (notInSessionException $e)
{
	header("Location: ./connexion.php");
	die();
}

echo $p->toHTML();
