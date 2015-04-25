<?php

require_once 'webpage.class.php';

$p = new WebPage("Accueil");

$p->appendContent(<<<HTML
<div class = "content">
	<div class = "welcome">
		<div class = "th1">Bienvenue chez SINAPP'S</div>
		<div class = "th2">Agence de maintenance informatique dédiée aux professionnels.</div>
	</div>
	<div class = "intro">
		<h2>
			<span>Ce que nous faisons</span>
			<span class = "i1">pour vous</span>
			<span>...</span>
		</h2>
	</div>
	<div class = "intro_box">
		<div class = "box_container">
			<div class = "presta box1">
				<div class = "th3">Presta 1</div>
				<img id="logo_ordi" src="../_IMG/ordi.png" alt="logo1"/>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, </div>
			</div>
		</div>
		<div class = "box_container">
			<div class = "presta box2">
				<div class = "th3">Presta 2</div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, egestas neque pretium, fringilla turpis. Maecenas eu orci nec purus imperdiet blandit. Quisque elementum dictum mi, maximus imperdiet lacus. Donec imperdiet lacus ac nibh elementum, a condimentum turpis dapibus. Nulla tincidunt pharetra nibh, id elementum elit vestibulum et. Pellentesque ut nisl at lacus hendrerit tincidunt et nec orci. Vivamus ullamcorper tellus tellus, ac ultricies lectus placerat ut. Aliquam ut risus leo. Aliquam erat volutpat.</div>
			</div>
		</div>
		<div class = "box_container">
			<div class = "presta box3">
				<div class = "th3">Presta 3</div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, egestas neque pretium, fringilla turpis. Maecenas eu orci nec purus imperdiet blandit. Quisque elementum dictum mi, maximus imperdiet lacus. Donec imperdiet lacus ac nibh elementum, a condimentum turpis dapibus. Nulla tincidunt pharetra nibh, id elementum elit vestibulum et. Pellentesque ut nisl at lacus hendrerit tincidunt et nec orci. Vivamus ullamcorper tellus tellus, ac ultricies lectus placerat ut. Aliquam ut risus leo. Aliquam erat volutpat.</div>
			</div>
		</div>
		<div class = "box_container">
			<div class = "presta box4">
				<div class = "th3">Presta 4</div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, egestas neque pretium, fringilla turpis. Maecenas eu orci nec purus imperdiet blandit. Quisque elementum dictum mi, maximus imperdiet lacus. Donec imperdiet lacus ac nibh elementum, a condimentum turpis dapibus. Nulla tincidunt pharetra nibh, id elementum elit vestibulum et. Pellentesque ut nisl at lacus hendrerit tincidunt et nec orci. Vivamus ullamcorper tellus tellus, ac ultricies lectus placerat ut. Aliquam ut risus leo. Aliquam erat volutpat.</div>
			</div>
		</div>
		<div class = "box_container">
			<div class = "presta box5">
				<div class = "th3">Presta 5</div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, egestas neque pretium, fringilla turpis. Maecenas eu orci nec purus imperdiet blandit. Quisque elementum dictum mi, maximus imperdiet lacus. Donec imperdiet lacus ac nibh elementum, a condimentum turpis dapibus. Nulla tincidunt pharetra nibh, id elementum elit vestibulum et. Pellentesque ut nisl at lacus hendrerit tincidunt et nec orci. Vivamus ullamcorper tellus tellus, ac ultricies lectus placerat ut. Aliquam ut risus leo. Aliquam erat volutpat.</div>
			</div>
		</div>
		<div class = "box_container">
			<div class = "presta box6">
				<div class = "th3">Presta 6</div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, egestas neque pretium, fringilla turpis. Maecenas eu orci nec purus imperdiet blandit. Quisque elementum dictum mi, maximus imperdiet lacus. Donec imperdiet lacus ac nibh elementum, a condimentum turpis dapibus. Nulla tincidunt pharetra nibh, id elementum elit vestibulum et. Pellentesque ut nisl at lacus hendrerit tincidunt et nec orci. Vivamus ullamcorper tellus tellus, ac ultricies lectus placerat ut. Aliquam ut risus leo. Aliquam erat volutpat.</div>
			</div>
		</div>
	</div>
</div>
HTML
);

echo $p->toHTML();