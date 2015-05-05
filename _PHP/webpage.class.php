<?php

class WebPage {
    /**
     * Texte compris entre <head> et </head>
     * @var string
     */
    private $head  = null ;
    /**
     * Texte compris entre <title> et </title>
     * @var string
     */
    private $title = null ;
    /**
     * Texte compris entre <body> et </body>
     * @var string
     */
    private $body  = null ;

    /**
    * Numéro pour l'onglet selectionné
    */
    //private $numOnglet = null;

    /**
     * Constructeur
     * @param string $title Titre de la page
     */
    public function __construct($title=null) {
        $this->setTitle($title) ;
        $this->appendToHead("<link href='http://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet' type='text/css'>");
        $this->appendCssUrl("../_CSS/style.css");
        $this->appendJsUrl("../_JS/sha1.js");
    }

    /**
     * Protéger les caractères spéciaux pouvant dégrader la page Web
     * @param string $string La chaîne à protéger
     *
     * @return string La chaîne protégée
     */
    public function escapeString($string) {
        return htmlentities($string, ENT_QUOTES|ENT_HTML5, "utf-8") ;
    }

    /**
     * Affecter le titre de la page
     * @param string $title Le titre
     */
    public function setTitle($title) {
        $this->title = $title ;
    }


    /**
     * Affecter le numéro de la page
     * @param int $num le numero
     */
    /*public function setNumOnglet($num) {
        $this->numOnglet = $num ;
    }*/

    /**
     * Ajouter un contenu dans head
     * @param string $content Le contenu à ajouter
     *
     * @return void
     */
    public function appendToHead($content) {
        $this->head .= $content ;
    }

    /**
     * Ajouter un contenu CSS dans head
     * @param string $css Le contenu CSS à ajouter
     *
     * @return void
     */
    public function appendCss($css) {
        $this->appendToHead(<<<HTML
    <style type='text/css'>
    {$css}
    </style>

HTML
) ;    
    }

    /**
     * Ajouter l'URL d'un script CSS dans head
     * @param string $url L'URL du script CSS
     *
     * @return void
     */
    public function appendCssUrl($url) {
        $this->appendToHead(<<<HTML
    <link rel="stylesheet" type="text/css" href="{$url}">

HTML
) ;
    }

    /**
     * Ajouter un contenu JavaScript dans head
     * @param string $js Le contenu JavaScript à ajouter
     *
     * @return void
     */
    public function appendJs($js) {
        $this->appendToHead(<<<HTML
    <script type='text/javascript'>
    $js
    </script>

HTML
) ;    
    }

    /**
     * Ajouter l'URL d'un script JavaScript dans head
     * @param string $url L'URL du script JavaScript
     *
     * @return void
     */
    public function appendJsUrl($url) {
        $this->appendToHead(<<<HTML
    <script type='text/javascript' src='$url'></script>

HTML
) ;    
    }

    /**
     * Ajouter un contenu dans body
     * @param string $content Le contenu à ajouter
     * 
     * @return void
     */
    public function appendContent($content) {
        $this->body .= $content ;
    }

    /**
     * Produire la page Web complète
     * @throws Exception si title n'est pas défini
     *
     * @return string
     */
    public function toHTML() {
        if (is_null($this->title)) {
            throw new Exception(__CLASS__ . ": title not set") ;
        }

        $session_key = Personne::$SESSION_KEY;
        
        return <<<HTML
<!doctype html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>{$this->title}</title>
{$this->head}
    </head>
    <body>
        <div id='head_fixe'>
            <a href="./index.php"><img id='logo_sinapps' src ="../_IMG/logo_sinapps.png" alt='logo'/></a><br/>
            <div id='onglets'>
                <ul class="header_onglets">
                	<li id="accueil">
                		<a href="./index.php" target="_self">Accueil</a>
                	</li>

                	<li>
                		Agence 
                        <ul class="niveau2">
                            <li><a href="./presentation.php" target="_self">Présentation</a>
                                <ul class="niveau3">
                                    <li><a href="./presentation.php" target="_self">Hello</a></li>
                                    <li><a href="./presentation.php" target="_self">Hello2</a></li>
                                </ul>
                            </li>
                            <li><a href="./statistiques.php" target="_self">Statistiques</a></li>
                            <li><a href="./partenaires.php" target="_self">Partenaires</a></li>
                            <li><a href="./equipe.php" target="_self">L'équipe</a></li>
                            
                        </ul>
                	</li>

                	<li>
                		<a href="./offres.php" target="_self">Offres</a>
                        <ul class="niveau2">
                            <li><a href="./offre_silver.php" target="_self">Offre Silver</a></li>
                            <li><a href="./offre_gold.php" target="_self">Offre Gold</a></li>
                            <li><a href="./offre_platinum.php" target="_self">Offre Platinum</a></li>                            
                        </ul>
                	</li>

                	<li>
                		<a href="./prestations.php" target="_self">Prestations</a>
                	</li>

                	<li>
                		<a href="./perso.php" target="_self">Espace personnel</a>
                	</li>

                	<li>
                		<a href="./contact.php" target="_self">Contactez-nous</a>
                	</li>
                </ul>
            </div>
        </div>
        <div id="banniere">
            
        </div>
        <div id='page'>
{$this->body}
        </div>
        <div class="bandeau_bas">
            <div class="infos_bas">
                <div class="bas premier">
                    <ul>
                        <li><a href="./index.php"><img id="icone_bas" src="../_IMG/logo_bas.png" alt="logo bas"/></a></li>
                        <li><a href="./index.php"><img id="logo_sinapps_bas" src="../_IMG/logo_sinapps.png" alt="logo bas"/></a></li>
                    </ul>
                </div>   
                <div class="bas">
                    <div class="th4">Horaires d'ouverture</div>
                    <ul>
                        <li>Du Lundi au Vendredi : 9h00 - 12h00 / 13h30 - 19h00</li>
                        <li>Samedi : 9h00 - 12h00</li>
                    </ul>
                </div> 
                <div class="bas">
                    <div class="th4">Coordonnées</div>
                    <ul>
                        <li>30 Rue d'en Bas - 02400 GLAND</li>
                        <li>Tél : 03.04.05.06.07</li>
                        <li>Mail : contact@sinapps.fr</li>
                </div>
            </div>
        </div>
	  <script>
		//Constantes globales
		var GB_CONST = {
			"session_key"	: "{$SESSION_KEY}"
		};
	  </script>
	  <script src="../_JS/global.js"></script>
    </body>
</html>
HTML;
    }
}

//<img id="header" src="./site_sinapps/_IMG/imgHeaderSin.jpg" alt="header"/>