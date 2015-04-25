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

        return <<<HTML
<!doctype html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>{$this->title}</title>
{$this->head}
    </head>
    <body>
        <ul class="niveau1">
           <li>
             Menu
             <ul class="niveau2">
               <li>
                 Extras
                 <ul class="niveau3">
                   <li>Demander la note</li>
                   <li>Draguer la serveuse</li>
                 </ul>
               </li>
               <li>Entr&eacute;e</li>
               <li>Plat</li>
               <li>Dessert</li>
               <li>Caf&eacute;</li>
             </ul>
           </li>
         </ul> 
        <div id="banniere">
            
        </div>
        <div id='page'>
{$this->body}
        </div>
        <div id="bandeau_bas">
        
        </div>
    </body>
</html>
HTML;
    }
}

//<img id="header" src="./site_sinapps/_IMG/imgHeaderSin.jpg" alt="header"/>