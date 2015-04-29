<?php 

require_once 'webpage.class.php';

$p = new WebPage("Agence");

$p->appendContent(<<<HTML
	<div class="content">
		J'aime les vaches
	</div>
HTML
);

echo $p->toHTML();