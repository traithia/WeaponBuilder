<?php
// icon HEX values from 4010 to 30065 (26055 total)

$subCount=0;


$iconScan = scandir('./img/ac_icons');



for ($z=0 ; $z<500 ; $z++) {

	if (substr($iconScan[$z],-4) == '.png') {
		echo '

		<img src="./img/ac_icons/'.$iconScan[$z].'.png">



		';


		if ($subCount==25) {
			echo '<br/>';
			$subCount=0;
		}
	}
}	

echo 'done.';

?>
