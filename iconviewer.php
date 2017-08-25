<?PHP
session_start();

if ($_POST['iconPerPage']!=NULL) {
	$_SESSION['iconPerPage'] = $_POST['iconPerPage'];
	$_SESSION['iconScale'] = $_POST['iconScale'];
	$_SESSION['iconCurrPage'] = 1;
}

if (!$_SESSION['iconPerPage']) {
	$_SESSION['iconPerPage'] = 100;
	$_SESSION['iconCurrPage'] = 1;
	
}

if ($_GET['page']) {
	$_SESSION['iconCurrPage'] = $_GET['page'];
}


if ($_SESSION['iconValues']) {

	$iconValues = array();
	
	$iconValues = $_SESSION['iconValues'];
	
	$iconMatches = $_SESSION['iconMatches'];


}
else {  
	
	$iconScan = scandir('./img/ac_icons');
	
	$iconValues = array();
	
	$iconMatches = 0;
	
	for ($z = 0; $z < count($iconScan); $z++) {
		
		if (substr($iconScan[$z],-4) == '.png') {
			
			$iconValues[$iconMatches] = $iconScan[$z];
			
			$iconMatches++;
			
		}
	}
	
	$_SESSION['iconValues'] = $iconValues;
	$_SESSION['iconMatches'] = $iconMatches;
	
}

?>

<!DOCTYPE html>

<html>
	<head>
		<title>
			Trai's Weapon Builder
		</title>

		<link rel="stylesheet" type="text/css" href="default.css" />

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Melee Weapon Building Tool for PhatAC">

	</head>

	<body id="mainBody">
	

		<div id="mainContainer">
		
		
		<?PHP
			
				

					if (!$_SESSION['authorized']) {
			
						die ('
			
							PLEASE LOGIN TO USE THIS TOOL	
							
						</div>
					</body>
				</html>
			
			
						');
					}
			
			?>
		
		
			<div class="iconHeadFoot">
				<form name="changeview" action="iconviewer.php" method="POST">
					<table class="iconTable1">
						<tr>
							<th class="gxTh1">
								Icons per Page:
							</th>
							<th class="gxTh1">
								<select name="iconPerPage">
									<option value=50 <?PHP if ($_SESSION['iconPerPage']==50){ echo 'SELECTED'; } ?>>50</option>
									<option value=100 <?PHP if ($_SESSION['iconPerPage']==100){ echo 'SELECTED'; } ?>>100</option>
									<option value=250 <?PHP if ($_SESSION['iconPerPage']==250){ echo 'SELECTED'; } ?>>250</option>
									<option value=500 <?PHP if ($_SESSION['iconPerPage']==500){ echo 'SELECTED'; } ?>>500</option>
									<option value=1000 <?PHP if ($_SESSION['iconPerPage']==1000){ echo 'SELECTED'; } ?>>1000</option>
								</select>
							</th>
							<th class="gxTh1">
								<input type="checkbox" name="iconScale" value=1 <?PHP if ($_SESSION['iconScale']==1){ echo 'CHECKED'; } ?>> Scale Icons 2x
							</th>
							<th class="gxTh1">
								<input type="submit" value="Do it!">
							</th>
						</tr>
					</table>
				</form>
			</div>

	
<?php

if ($_SESSION['iconScale']==1) {
	$iconScaleH = 64;
	$iconScaleW = 64;
	
} else {
	$iconScaleH = 32;
	$iconScaleW = 32;
	
}



$z = (($_SESSION['iconCurrPage'] * $_SESSION['iconPerPage']) - ($_SESSION['iconPerPage'] ));

$currCount=0;

while ($currCount < $_SESSION['iconPerPage'] AND $z < count($iconValues)){


	
		
		
		echo '<div class="iconContainer">';
		echo '<center><img src="./img/ac_icons/'.$iconValues[$z].'" height="'.$iconScaleH.'" width="'.$iconScaleW.'"></center>';
		echo '<div class="iconHexText">0x'.substr($iconValues[$z],0,4);
		echo '</div>';
		echo '</div>';	
					
	$z++;
	$currCount++;
}	

?>
			<div class="iconHeadFoot">
				<table class="iconTable1">
						<tr>
							<th class="iconTh1">
								<?PHP echo 'Showing '.(($_SESSION['iconCurrPage'] * $_SESSION['iconPerPage']) - ($_SESSION['iconPerPage'] - 1)).' to '.($_SESSION['iconCurrPage'] * $_SESSION['iconPerPage']).' of '.(count($iconValues)-2); ?>
							</th>
						</tr>
						<tr>
							<th class="iconTh1">
								<?PHP 
									if ($_SESSION['iconCurrPage'] == 1) {
										
										echo '<a href="iconviewer.php?page='.($_SESSION['iconCurrPage'] + 1).'"> NEXT > </a>';
										
									} else {
										
										echo '<a href="iconviewer.php?page='.($_SESSION['iconCurrPage'] - 1).'">< PREV</a> | ';
										echo '<a href="iconviewer.php?page='.($_SESSION['iconCurrPage'] + 1).'">NEXT ></a>';
									
									}
					
								?>
							</th>
						</tr>
					</table>
				

			</div>
		</div>
	</body>
</html>