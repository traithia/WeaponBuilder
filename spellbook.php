<?PHP
session_start();

class spellBook {
	public $spellId;
	public $spellName;
}


if ($_POST['wcid']!=NULL) {
	
	$_SESSION['wcid'] = $_POST['wcid'];
	$_SESSION['phName'] = $_POST['phName'];
	$_SESSION['phValue'] = $_POST['phValue'];
	$_SESSION['phBurden'] = $_POST['phBurden'];
	$_SESSION['phWorkmanship'] = $_POST['phWorkmanship'];
	$_SESSION['phMaterial'] = $_POST['phMaterial'];
	$_SESSION['phSkillType'] = $_POST['phSkillType'];
	$_SESSION['phWeaponType'] = $_POST['phWeaponType'];
	$_SESSION['phDamageType'] = $_POST['phDamageType'];
	$_SESSION['phMaxDamage'] = $_POST['phMaxDamage'];
	$_SESSION['phSpeed'] = $_POST['phSpeed'];
	$_SESSION['phVariance'] = $_POST['phVariance'];
	$_SESSION['phMeleeBonus'] = $_POST['phMeleeBonus'];
	$_SESSION['phAttackBonus'] = $_POST['phAttackBonus'];
	$_SESSION['phMagDefBonus'] = $_POST['phMagDefBonus'];
	$_SESSION['phMissDefBonus'] = $_POST['phMissDefBonus'];
	$_SESSION['phAttuned'] = $_POST['phAttuned'];
	$_SESSION['phBonded'] = $_POST['phBonded'];
	$_SESSION['phIvoryable'] = $_POST['phIvoryable'];
	$_SESSION['phSellable'] = $_POST['phSellable'];
	$_SESSION['phDestroy'] = $_POST['phDestroy'];
	$_SESSION['phRetained'] = $_POST['phRetained'];
	$_SESSION['phInscribable'] = $_POST['phInscribable'];
	$_SESSION['phIgnoreMagRes'] = $_POST['phIgnoreMagRes'];
	$_SESSION['phIgnoreMagArm'] = $_POST['phIgnoreMagArm'];
	$_SESSION['phDescription'] = $_POST['phDescription'];
	$_SESSION['phSlayer'] = $_POST['phSlayer'];
	$_SESSION['phSlayerBonus'] = $_POST['phSlayerBonus'];
	$_SESSION['phATPunch'] = $_POST['phATPunch'];
	$_SESSION['phATThrust'] = $_POST['phATThrust'];
	$_SESSION['phATSlash'] = $_POST['phATSlash'];
	$_SESSION['phATKick'] = $_POST['phATKick'];
	$_SESSION['phATDoubSlash'] = $_POST['phATDoubSlash'];
	$_SESSION['phATTripSlash'] = $_POST['phATTripSlash'];
	$_SESSION['phATDoubThrust'] = $_POST['phATDoubThrust'];
	$_SESSION['phATTripThrust'] = $_POST['phATTripThrust'];
	$_SESSION['phCombatStyle'] = $_POST['phCombatStyle'];
	$_SESSION['phTinkCritStrike'] = $_POST['phTinkCritStrike'];
	$_SESSION['phTinkCripBlow'] = $_POST['phTinkCripBlow'];
	$_SESSION['phTinkArmorRend'] = $_POST['phTinkArmorRend'];
	$_SESSION['phTinkSlash'] = $_POST['phTinkSlash'];
	$_SESSION['phTinkPierce'] = $_POST['phTinkPierce'];
	$_SESSION['phTinkBludg'] = $_POST['phTinkBludg'];
	$_SESSION['phTinkAcid'] = $_POST['phTinkAcid'];
	$_SESSION['phTinkCold'] = $_POST['phTinkCold'];
	$_SESSION['phTinkLight'] = $_POST['phTinkLight'];
	$_SESSION['phTinkFire'] = $_POST['phTinkFire'];
	$_SESSION['phTimesTinkered'] = $_POST['phTimesTinkered'];
	$_SESSION['phImbuedBy'] = $_POST['phImbuedBy'];
	$_SESSION['phLastTinker'] = $_POST['phLastTinker'];
	$_SESSION['phSpellCraft'] = $_POST['phSpellCraft'];
	$_SESSION['phMaxMana'] = $_POST['phMaxMana'];
	$_SESSION['phCurrMana'] = $_POST['phCurrMana'];
	$_SESSION['phManaRate'] = $_POST['phManaRate'];
	$_SESSION['phArcane'] = $_POST['phArcane'];
	$_SESSION['phSpellBlob'] = $_POST['phSpellBlob'];
	$_SESSION['phDidSetup'] = $_POST['phDidSetup'];
	$_SESSION['phTranslucent'] = $_POST['phTranslucent'];
	$_SESSION['phScale'] = $_POST['phScale'];
	$_SESSION['phDidSoundTable'] = $_POST['phDidSoundTable'];
	$_SESSION['phDidPaletteBase'] = $_POST['phDidPaletteBase'];
	$_SESSION['phDidClothingBase'] = $_POST['phDidClothingBase'];
	$_SESSION['phDidIcon'] = $_POST['phDidIcon'];
	$_SESSION['phDidIconUnder'] = $_POST['phDidIconUnder'];
	$_SESSION['phDidIconOver1'] = $_POST['phDidIconOver1'];
	$_SESSION['phDidIconOver2'] = $_POST['phDidIconOver2'];
	$_SESSION['phDidPhysics'] = $_POST['phDidPhysics'];	
	$_SESSION['phWieldReq'] = $_POST['phWieldReq'];
	$_SESSION['phWieldSkill'] = $_POST['phWieldSkill'];
	$_SESSION['phWieldValue'] = $_POST['phWieldValue'];
	$_SESSION['phWieldAttribute'] = $_POST['phWieldAttribute'];
	$_SESSION['phWieldVital'] = $_POST['phWieldVital'];
	$_SESSION['phCombatUse'] = $_POST['phCombatUse'];
	$_SESSION['phDamageMod'] = $_POST['phDamageMod']; 
	$_SESSION['phLocationInt'] = $_POST['phLocationInt']; 
	$_SESSION['phItemType'] = $_POST['phItemType'];
	$_SESSION['phManaConvBonus'] = $_POST['phManaConvBonus'];
	$_SESSION['phElementalBonus'] = $_POST['phElementalBonus'];
	$_SESSION['phAmmoType'] = $_POST['phAmmoType'];
	$_SESSION['phVelocity'] = $_POST['phVelocity'];
	$_SESSION['phUiEffects'] = $_POST['phUiEffects'];
	$_SESSION['phResistMod'] = $_POST['phResistMod'];

	
	if ($_POST['phWieldReq']==0) {
		$_SESSION['phWieldSkill']=NULL;
		$_SESSION['phWieldValue']=NULL;
		$_SESSION['phWieldAttribute']=NULL;
		$_SESSION['phWieldVital']=NULL;
	}

	
	
}





require ('../db_connect.php');

	
	$db_spell_query='SELECT * FROM spells';
	$db_spells=mysqli_query($db_conn,$db_spell_query);


mysqli_close ($db_conn);	


if ($_GET['clearall']) {
	
	unset($_SESSION['phSpellBook']);
	$_SESSION['phSpellCount']=0;
}

if ($_GET['debug']) {
	var_dump($_SESSION['phSpellBook']);
	die();
}


if ($_GET['remid']) {
	
	$phSpellBook_tmp[] = new spellBook();
	$phSpellBook_old[] = new spellBook();
	
	$phSpellCount_tmp = 0;
	$phSpellBook_old = $_SESSION['phSpellBook'];
	
	for ($z=0 ; $z < $_SESSION['phSpellCount'] ; $z++) {
		
		if ($_GET['remid'] != $phSpellBook_old[$z]->spellId ) {
			
			$phSpellBook_tmp[$phSpellCount_tmp]->spellId = $phSpellBook_old[$z]->spellId;
			$phSpellBook_tmp[$phSpellCount_tmp]->spellName = $phSpellBook_old[$z]->spellName;
			
			$phSpellCount_tmp++;
			
		}
		
		
	}
	
	$_SESSION['phSpellBook'] = $phSpellBook_tmp;
	$_SESSION['phSpellCount'] = $phSpellCount_tmp;
	
	
}







$phSpellBook[] = new spellBook();

if ($_SESSION['phSpellCount']==NULL) {
	$_SESSION['phSpellCount']=0;
}


if ($_SESSION['phSpellBook']) {
	$phSpellBook=$_SESSION['phSpellBook'];
}


if($_GET['addid']) {
	

	$phSpellBook[$_SESSION['phSpellCount']]->spellId=$_GET['addid'];
	$phSpellBook[$_SESSION['phSpellCount']]->spellName=$_GET['addname'];		

	$_SESSION['phSpellCount']++;
	
	$_SESSION['phSpellBook']=$phSpellBook;
}




?>
<!DOCTYPE html>

<html>
	<head>
		<title>
			Weapon Builder - Spell Book
		</title>

		<?PHP
			echo '<link rel="stylesheet" type="text/css" href="'.$_SESSION['theme'].'" />';
		?>

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

		
			
			<div class="mainTitle">
				
			</div>		
			
			<div class="sectionSpacer"> </div>

		
			<form name="create" action="buildjson.php" method="POST">
				<div class="section">
					<div class="sectionTitle">
						Spell Book for <?PHP echo $_SESSION['phName'].' ('.$_SESSION['wcid'].')'; ?>
					</div>
					<h3>
						Current Spells on Weapon: (click to remove) <a href="spellbook.php?clearall=true"><button type="button">Clear all</button></a>
					</h3>	
					<div id="phCurrentSpells">
						
						<ul id="currentSpellList">
						
							<?php
							
								for ($z=0;$z<count($phSpellBook);$z++){
									
									if (count($phSpellBook)==1 and $phSpellBook[0]->spellId==0) {
										//echo '<li><a href="spellbook.php#"><i>none</i></a></li>';
									}
									else {
										echo '<li><a href="spellbook.php?remid='.$phSpellBook[$z]->spellId.'">'.$phSpellBook[$z]->spellName.'</a></li>';
									}
								}
							
							
							?>
						</ul>
					</div>	
					
					<table>
						<tr>
							<th>
								<input type="text" class="phTextBox" id="searchInput" onkeyup="filterSpells()" style="width:200px; margin-bottom:5px;" placeholder="Search by spell name...">
							</th>
							<th>
								<h3>
									Click on desired spell in list below to add to weapon.
								</h3>
							</th>
						</tr>
					</table>
					
					<div id="spellContainer">
					
						<ul id="completeSpellList">
						
						<?PHP
									while ($db_row=mysqli_fetch_array($db_spells,MYSQLI_ASSOC)) {
										
										echo '<li><a href="spellbook.php?addid='.$db_row['spell_id'].'&addname='.$db_row['spell_name'].'">'.$db_row['spell_name'].'</a></li>';
										
										
										
									}
								?>
						
							
						</ul>
					</div>	

				</div>
				<div class="sectionSpacer"> </div>
				<div class="section">
					<center>
						<a href="index.php"><Button class="phButton" type="button">Back to Properties</button></a>
						<Button class="phButton" type="submit">Create Weapon</button>
					</center>
					
				</div>
			</form>
		</div>
		<script>
			function filterSpells() {
				var input, filter, ul, li, a, i;
				input = document.getElementById('searchInput');
				filter = input.value.toUpperCase();
				ul = document.getElementById("completeSpellList");
				li = ul.getElementsByTagName('li');

				
				for (i = 0; i < li.length; i++) {
					a = li[i].getElementsByTagName("a")[0];
					if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
						li[i].style.display = "";
					} 
					else {
						li[i].style.display = "none";
					}
				}
			}
		</script>
	</body>
</html>
		
		
		
		
		