<?php

require_once 'myPDO.include.php';

class Contrat
{
	private $id_contrat = null;

	private $id_entreprise = null;

	private $id_offre = null;

	private $id_parc = null;

	private $fin_validite = null;

	private $date_signature_ctr = null;

	private $delai_resolution = null;


	public function getIdContrat()
	{
		return $this->id_contrat;
	}

	public function getIdEntp()
	{
		return $this->id_entreprise;
	}

	public function getIdOffre()
	{
		return $this->id_offre;
	}

	public function getIdParc()
	{
		return $this->id_parc;
	}

	public function getFinValidite()
	{
		return $this->fin_validite;
	}

	public function getDelaiContrat()
	{
		return $this->delai_resolution;
	}

	public function getDateSignContrat()
	{
		return $this->date_signature_ctr;
	}

	public function setFinValidite($date)
	{
		$this->fin_validite = $date;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE CONTRAT
			SET fin_validite = :date_fin
			WHERE id_contrat = :id
SQL
		);			
		$stmt->bindValue(":date_fin", $date);
		$stmt->bindValue(":id", $this->id_contrat);
		$stmt->execute();
	}




	/*
	Récupération de tous les incidents en fonction de l'ID d'une personne
	*/
	public static function getContratByIdEntp($id)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM CONTRAT
			WHERE id_entreprise = :id
			ORDER BY fin_validite DESC
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		$array = $stmt->fetchAll();
		$html = <<<HTML
			<div class = "box1">
HTML;
		foreach ($array as $ctr)
		{
			$i = $ctr->getIdContrat();
			$status = "";
			$dateFV = date('d-m-Y', strtotime($ctr->getFinValidite()));
			$dateSign = date('d-m-Y', strtotime($ctr->getDateSignContrat()));
			if (strtotime($dateFV) > strtotime(date("d-m-Y"))) {
				$status = "<div class = \"status t\">Contrat en cours de validité</div>";
			}
			else {
				$status = "<div class = \"status nt\">Contrat expiré</div>";
			}

			$offre = Offre::createOffreFromId($ctr->getIdOffre());
			$html.=<<<HTML
				<div class = "row bordure fond">
					<div class = "th2">Contrat n°{$ctr->getIdContrat()} 
						<span class="offre">({$offre->getNomOffre()})</span>
					</div>
					{$status}
					<div class = "row">Signé le : {$dateSign}</div>
					<div class = "row">Expire le : {$dateFV}</div>	
					<div class = "boutons_objet">
						<button type="submit" class="button" onclick="effacer({$ctr->getIdContrat()})">Supprimer</button>
					</div>				
				</div>
HTML;
		}
		$html.=<<<HTML
			</div>
HTML;

		$html .="<script>
			function effacer(num)
			{
				var confirm = window.confirm(\"Voulez-vous supprimer ce contrat ?\");
				if (confirm)
					document.location.href=\"./contrats.php?i=\" + num + \"&delete=yes\";
			};
		</script>";

		return $html;
	}

	/*
	Récupération de tous les incidents de toutes les personnes
	*/
	public static function getAllContrats()
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM CONTRAT
			ORDER BY fin_validite DESC
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute();
		$array = $stmt->fetchAll();
		$html = <<<HTML
			<div class = "box1">
HTML;
		foreach ($array as $ctr)
		{
			$i = $ctr->getIdContrat();
			$status = "";
			$dateFV = date('d-m-Y', strtotime($ctr->getFinValidite()));
			$dateSign = date('d-m-Y', strtotime($ctr->getDateSignContrat()));
			if (strtotime($dateFV) > strtotime(date("d-m-Y")))
			{
				$status = "<div class = \"status t\">Contrat en cours de validité</div>";
			}
			else {
				$status = "<div class = \"status nt\">Contrat expiré</div>";
			}

			$entp = Entreprise::createEntrepriseFromId($ctr->getIdEntp());
			$offre = Offre::createOffreFromId($ctr->getIdOffre());
			$html.=<<<HTML
				<div class = "row bordure fond">
					<div class = "th2">Contrat n°{$ctr->getIdContrat()} 
						<span class="offre">({$offre->getNomOffre()})</span>
					</div>
					<div class = "th3">Appartenant à l'entreprise {$entp->getNomEntreprise()}</div>
					{$status}
					<div class = "row">Signé le : {$dateSign}</div>
					<div class = "row">Expire le : {$dateFV}</div>
					<div class = "boutons_objet">
						<button type="submit" class="button" onclick="effacer({$ctr->getIdContrat()})">Supprimer</button>
					</div>		
				</div>
HTML;
		}
		$html.=<<<HTML
			</div>
HTML;

		$html .="<script>
			function effacer(num)
			{
				var confirm = window.confirm(\"Voulez-vous supprimer ce contrat ?\");
				if (confirm)
					document.location.href=\"./contrats.php?i=\" + num + \"&delete=yes\";
			};
		</script>";

		return $html;
	}


	/*
	Permet la déclaration d'un contrat
	*/
	public static function createContrat($id_entp, $id_parc, $id_offre, $dateDeb, $dateFin, $delai)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			INSERT INTO CONTRAT (id_entreprise, id_parc, id_offre, date_signature_ctr, fin_validite, delai_resolution)
			VALUES (:id_entp, :id_parc, :id_offre, :dateDeb, :dateFin, :delai)
SQL
		);
		$stmt->bindValue(":id_entp", $id_entp);
		$stmt->bindValue(":id_parc", $id_parc);
		$stmt->bindValue(":id_offre", $id_offre);
		$stmt->bindValue(":dateDeb", $dateDeb);
		$stmt->bindValue(":dateFin", $dateFin);
		$stmt->bindValue(":delai", $delai);
		$stmt->execute();
	}


	public static function createContratFromId($id) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT * 
			FROM CONTRAT
			WHERE id_contrat = :id_ctr
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->bindValue(":id_ctr", $id);
		$stmt->execute();
		if (($object = $stmt->fetch()) !== false) {
			return $object;
		}
		else throw new Exception ("Contrat not found");
	}


	/*
	Permet la suppression d'un incident
	*/
	public static function deleteContrat($id)
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			DELETE FROM CONTRAT
			WHERE id_contrat = :id
SQL
		);
		$stmt->bindValue(":id", $id);
		$stmt->execute();
	}
	
	
	
	
	
	
	
	
}