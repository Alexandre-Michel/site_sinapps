<?php

require_once 'myPDO.include.php';
require_once 'type_prestation.class.php';

class Offre
{
	private $id_offre;
	private $nom_offre;
	private $description_offre;
	private $prix_tarifaire;
	private $path_logo;
	private $desc_page;

	private function __construct()
	{}

	public function getIdOffre()
	{
		return $this->id_offre;
	}

	public function getNomOffre()
	{
		return $this->nom_offre;
	}

	public function getDescriptionOffre()
	{
		return $this->description_offre;
	}

	public function getPrixTarifaire()
	{
		return $this->prix_tarifaire;
	}

	public function getPathLogo()
	{
		return $this->path_logo;
	}

	public function getDescriptionPage()
	{
		return $this->desc_page;
	}

	public function getAllOffre()
	{
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM OFFRE
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute();
		$array = $stmt->fetchAll();
		$html = "";
		foreach($array as $ligne)
		{
			$html .= (<<<HTML
				<div class="box_offre">
					<div class="offre">
						<div class = "th3">{$ligne->getNomOffre()}</div>
						<div class = "img_offre">
							<img id="logo_offre" src="{$ligne->getPathLogo()}" alt="Logo Offre"/>
						</div>
						<div class = "border_logo"></div>
						<div class = "txt_box">{$ligne->getDescriptionOffre()}</div>
						<div class = "more">
							<a href="./offre.php?i={$ligne->getIdOffre()}">En savoir plus &rsaquo;</a>
						</div>
					</div>
				</div>
HTML
			);
		}
		return $html;
	}

	public function getOffreComplete()
	{
		$html = <<<HTML
			<div class = 'row'>
				<div class = "th1">{$this->nom_offre}</div>
				<div class = "img">
					<img id="logo_ordi" src="{$this->path_logo}" alt="logo1"/>
				</div>
				<div class = 'border'></div>
			</div>
			<div class = 'row'>
				<div class = 'txt'>{$this->desc_page}</div>
				<div class = 'prix'>A partir de {$this->prix_tarifaire}€</div>
			</div>
HTML;
		
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT id_offre
			FROM TYPE_PRESTATION
SQL
		);
		$stmt->execute();
		$aray = $stmt->fetchAll();
		foreach($array as $ligne)
		{
			switch($ligne)
			{
				//La prestation n'est contenue dans aucune offre, on ne fait rien
				case 0:
					$html .= "";
					break;
				//La prestation est contenue dans l'offre SILVER, et donc dans les offres GOLD et PLAT
				case 1:
					$html .= Type_Prestation::printTypePrestation();
					break;
				//La prestation est contenue dans l'offre GOLD, et donc dans l'offre PLAT
				case 2:
					if($this->id_offre == 2 || $this->id_offre ==3)
						$html .= Type_Prestation::printTypePrestation();
					break;
				//La prestation n'est contenue que dans l'offre PLAT
				case 3:
					if($this->id_offre == 3)
						$html .= Type_Prestation::printTypePrestation();
					break;
			}
		return $html;
	}

	public function setNomOffre($nom)
	{
		$this->nom_offre = $nom;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE OFFRE
			SET nom_offre = :nom
			WHERE id_offre = :id
SQL
		);
		$stmt->bindValue(":nom", $nom);
		$stmt->bindValue(":id", $this->id_offre);
		$stmt->execute();
	}

	public function setDescriptionOffre($desc)
	{
		$this->description_offre = $desc;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE OFFRE
			SET description_offre = :descr
			WHERE id_offre = :id
SQL
		);
		$stmt->bindValue(":descr", $desc);
		$stmt->bindValue(":id", $this->id_offre);
		$stmt->execute();
	}

	public function setPrixOffre($prix)
	{
		$this->description_offre = $desc;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE OFFRE
			SET prix_tarifaire = :prix
			WHERE id_offre = :id
SQL
		);
		$stmt->bindValue(":prix", $prix);
		$stmt->bindValue(":id", $this->id_offre);
		$stmt->execute();
	}

	public function setPathLogo($path_logo)
	{
		$this->description_offre = $desc;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE OFFRE
			SET path_logo = :path_logo
			WHERE id_offre = :id
SQL
		);
		$stmt->bindValue(":path_logo", $path_logo);
		$stmt->bindValue(":id", $this->id_offre);
		$stmt->execute();
	}

	public function setDescriptionPage($desc)
	{
		$this->description_offre = $desc;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE OFFRE
			SET desc_page = :descr
			WHERE id_offre = :id
SQL
		);
		$stmt->bindValue(":descr", $desc);
		$stmt->bindValue(":id", $this->id_offre);
		$stmt->execute();
	}

	public static function createOffreFromId($id) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT * 
			FROM OFFRE
			WHERE id_offre = :id
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		if (($object = $stmt->fetch()) !== false)
			return $object;
		else
			throw new Exception ("Offre not found");
	}
}