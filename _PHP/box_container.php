function createBox()
{
	echo <<< HTML
	<div class = "box_container">
			<div class = "presta box1">
				<div class = "th3">Presta 1</div>
				<div class = "img_presta">
					<img id="logo_ordi" src="../_IMG/ordi.png" alt="logo1"/>
				</div>
				<div class = "border_logo"></div>
				<div class = "txt_box">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare arcu nunc, sit amet consectetur ipsum tempor ut. Duis facilisis cursus faucibus. Morbi vehicula elit sit amet blandit fringilla. Etiam ut consequat eros. Sed quis tortor elementum, </div>
				<div class = "more">
					<a href="">En savoir plus &rsaquo;</a>
				</div>
			</div>
		</div>
HTML;
}