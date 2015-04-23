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
     * Constructeur
     * @param string $title Titre de la page
     */
    public function __construct($title=null) {
        $this->setTitle($title) ;
        $this->appendToHead("<link href='http://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet' type='text/css'>");
        $this->appendCssUrl("./site_sinapps/_CSS/style.css");
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
            <img class='logo_sinapps' src ="./site_sinapps/_IMG/Test logo.jpg" alt='logo' width='384' height='216'/><br/>
            <div id='onglets'>
            	<div id='accueil'>
            		<a href="./index.php" target="_self">Accueil</a>
            	</div>

            	<div id='agence'>
            		<a href="./index.php" target="_self">Agence</a>
            	</div>

            	<div id='offres'>
            		<a href="./index.php" target="_self">Offres</a>
            	</div>

            	<div id='prestations'>
            		<a href="./index.php" target="_self">Prestations</a>
            	</div>

            	<div id='espace_perso'>
            		<a href="./index.php" target="_self">Espace personnel</a>
            	</div>

            	<div id='contact'>
            		<a href="./index.php" target="_self">Contactez-nous</a>
            	</div>
            </div>
        </div>
        <div id="banniere">
            
        </div>
        <div id='page'>
{$this->body}
        </div>
    </body>
</html>
HTML;
    }
}

//<img id="header" src="./site_sinapps/_IMG/imgHeaderSin.jpg" alt="header"/>