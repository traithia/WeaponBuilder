<?PHP
require ('../db_connect.php');

	$db_mat_query =       'SELECT * FROM materials ORDER BY name';
	$db_spell_query =     'SELECT * FROM spells';
	$db_creatType_query = 'SELECT * FROM creatureType ORDER BY creatName ASC';
	$db_skills_query =    'SELECT * FROM skills ORDER BY name';
	
	
	$db_materials = mysqli_query($db_conn,$db_mat_query);
	$db_spells =    mysqli_query($db_conn,$db_spell_query);
	$db_creatType = mysqli_query($db_conn,$db_creatType_query);
	$db_skills =    mysqli_query($db_conn,$db_skills_query);
	

mysqli_close ($db_conn);	


session_start();


$iconUnderlayArray = array('0x11CB','0x11CD','0x11CE','0x11CF','0x11D0','0x11D1','0x11D2','0x11D3','0x11D4','0x11D5','0x11F3','0x11F4','0x3353','0x3354','0x3355','0x3356','0x3357','0x3358','0x3359','0x335A','0x335B','0x335C');																																				

$iconOverlayArray = array('0x63D6','0x6486','0x64F7','0x665D','0x6BAF','0x7066','0x0x640F','0x0x6410','0x0x6411','0x0x6412','0x0x6413');



if ($_GET['theme']) {
	
	$_SESSION['theme'] = $_GET['theme'].'.css';

}

?>
<!DOCTYPE html>

<html>
	<head>
		<title>
			Trai's Weapon Builder
		</title>

		<?PHP
			if (!$_SESSION['theme']) {
				$theme = "classic.css";
			}
			else {
				$theme = $_SESSION['theme'];
			}
			
			echo '<link rel="stylesheet" type="text/css" href="'.$theme.'" />';
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
		
						<form name="authorize" action="auth.php" method="POST">
							
							<div class="section">
								<div class="sectionTitle">
									Welcome to Weapon Builder for PhatAC
								</div>
								<table class="gxTable1">
									<tr>
										<th class="gxTh1">
											Enter Group Passphrase:
										</th>
										<th class="gxTh1">
											<input type="password" name="passphrase" required>
										</th>
										<th class="gxTh1">
											<Button type="submit">Submit</button>
										</th>
									</tr>
								</table>
							</div>
						</form>
					</div>
				</body>
			</html>
		
		
					');
				}
		?>

	
		
		<div class="mainTitle">
			<font id="titleFont">Weapon Builder for PhatAC</font>
		</div>		
		
		<div class="sectionSpacer"> </div>

		<?PHP
		
			if ($_SESSION['jsonFile']) {
				echo '
				<div id="downloadBox">
					<table>
						<tr>
							<th>
								<img  class="weaponIcon" src="./img/ac_icons/'.strtoupper(substr($_SESSION['phDidIcon'],-4)).'.png">
							</th>
							<th>
								<b>'.$_SESSION['phName'].'</b> has been Created.
							</th>
							<th>
								<a href="./json_temp/'.$_SESSION['jsonFile'].'" download="./json_temp/'.$_SESSION['jsonFile'].'">
									<button type="button">Download</button>
								</a>
								<a href="./json_temp/'.$_SESSION['jsonFile'].'">
									<button type="button">View JSON</button>
								</a>
							</th>
						</tr>
					</table>
				</div>
				<div class="sectionSpacer"> </div>
				';
				
			}
			
			if ($_SESSION['phImportFile']) {
				
				echo '
				<div id="importReturn">
					'.$_SESSION['phImportFile'].' has been imported, '.$_SESSION['phImportedKeys'].' keys where recognized.';
					
				if ($_SESSION['phUnknownKeys'] > 0) {
						echo '<br/>
							WARNING: File contains '.$_SESSION['phUnknownKeys'].' unknown key(s).';
				
				}
				
				echo '</div>';
				echo '<div class="sectionSpacer"> </div>';
			}
			
			
			
		?>
		
	<div id="phMainMenu">
		<table class="gxMenuTable">
			<tr>
				<th class="gxThMenu">
					<button id="showImportButton" type="button">Import JSON...</button>
				</th>
				<th class="gxThMenu">
					<a href="auth.php?startnew=melee"><button class="menuButton" type="button">New Melee Weapon</button></a>
				</th>
				<th class="gxThMenu">
					<a href="auth.php?startnew=magic"><button class="menuButton" type="button">New Casting Weapon</button></a>
				</th>
				<th class="gxThMenu">
					<a href="auth.php?startnew=missile"><button class="menuButton" type="button">New Missile Weapon</button></a>
				</th>
				<th class="gxThMenu">
					<?PHP
						$recognizeWeenie=false;
						if ($_SESSION['phWeenieType']==6) {
							echo 'Current Type: Melee Weapon';
							$recognizeWeenie = True;
						}
						
						if ($_SESSION['phWeenieType']==35) {
							echo 'Current Type: Casting Weapon';
							$recognizeWeenie = True;
						}
						
						if ($_SESSION['phWeenieType']==3) {
							echo 'Current Type: Missile Weapon';
							$recognizeWeenie = True;
						}
						
						if ($recognizeWeenie == false) {
							echo '<font class="errorRed">Current Type: ERROR!!</font> <a href="fixweenie.php"><button>Fix This</button></a>';
							
						}
						
					
					
					?>
				</th>
			</tr>
		</table>
		
		<div id="importView">
			<p id="importText">Drag/Drop file into box or click in box to open browse window</p>
			<form enctype="multipart/form-data" action="import.php" method="POST" id="uploadForm">
				<input type="hidden" name="MAX_FILE_SIZE" value="300000" />
				<input type="file" name="userfile" id="userFile">
				
				
			</form>
		</div>
		
		
		
		
	</div>
		
	<div class="sectionSpacer"> </div>	
	
	<form name="create" action="spellbook.php" method="POST">
		<div class="section">
			<div class="sectionTitle">
				General Properties
			</div>
		
			<table class="gxTable1">
				<tr>
					<th class="gxTh1">
						WCID:
					</th>
					<th class="gxTh1">
						<input type="text" name="wcid" value="<?PHP echo $_SESSION['wcid']; ?>" required>
					</th>
					<th class="gxTh1">
						Weapon Name:
					</th>
					<th class="gxTh1">
						<input type="text" name="phName" value="<?PHP echo $_SESSION['phName']; ?>" required>
					</th>
				</tr>
				<tr>
					<th class="gxTh1">
						Value (Pyreals):
					</th>
					<th class="gxTh1">
						<input type="text" name="phValue" value="<?PHP echo $_SESSION['phValue']; ?>" required>
					</th>
					<th class="gxTh1">
						Burden:
					</th>
					<th class="gxTh1">
						<input type="text" name="phBurden" value="<?PHP echo $_SESSION['phBurden']; ?>" required>
					</th>
				</tr>
				<tr>
					<th class="gxTh1">
						Workmanship:
					</th>
					<th class="gxTh1">
						<select name="phWorkmanship">
							<option value=0>Property NOT used</option>
							<option value=1 <?PHP if ($_SESSION['phWorkmanship']==1){ echo 'SELECTED'; } ?>>Poorly crafted (1)</option>
							<option value=2 <?PHP if ($_SESSION['phWorkmanship']==2){ echo 'SELECTED'; } ?>>Well-crafted (2)</option>
							<option value=3 <?PHP if ($_SESSION['phWorkmanship']==3){ echo 'SELECTED'; } ?>>Finely crafted (3)</option>
							<option value=4 <?PHP if ($_SESSION['phWorkmanship']==4){ echo 'SELECTED'; } ?>>Exquisitely crafted (4)</option>
							<option value=5 <?PHP if ($_SESSION['phWorkmanship']==5){ echo 'SELECTED'; } ?>>Magnificent (5)</option>
							<option value=6 <?PHP if ($_SESSION['phWorkmanship']==6){ echo 'SELECTED'; } ?>>Nearly flawless (6)</option>
							<option value=7 <?PHP if ($_SESSION['phWorkmanship']==7){ echo 'SELECTED'; } ?>>Flawless (7)</option>
							<option value=8 <?PHP if ($_SESSION['phWorkmanship']==8){ echo 'SELECTED'; } ?>>Utterly Flawless (8)</option>
							<option value=9 <?PHP if ($_SESSION['phWorkmanship']==9){ echo 'SELECTED'; } ?>>Incomparable (9)</option>
							<option value=10 <?PHP if ($_SESSION['phWorkmanship']==10){ echo 'SELECTED'; } ?>>Priceless (10)</option>
						</select>		
					</th>
					<th class="gxTh1">
						Material:
					</th>
					<th class="gxTh1">
						<select name="phMaterial">
							<option value=0 <?PHP if ($_SESSION['phMaterial']==0){ echo 'SELECTED'; } ?>>Property NOT used</option>
						
						<?PHP
							while ($db_row=mysqli_fetch_array($db_materials,MYSQLI_ASSOC)) {
								
								echo '<option value='.$db_row['enum'];
								
								if ($_SESSION['phMaterial']==$db_row['enum']){ 
									echo ' SELECTED'; 
								}
								echo '>'.$db_row['name'].'</option>';
							}
						?>
						</select>
							
					</th>
				</tr>
			</table>
			
			<?PHP
			
			if ($_SESSION['phWeenieType']==6) {  	// display base melee attribute input
				echo '<input type="hidden" name="phCombatUse" value="1"> '; // combatuse 1 = melee weapons
				echo '<input type="hidden" name="phLocationInt" value="1048576"> ';	//phLocationInt 1048576 for melee
				echo '<input type="hidden" name="phItemType" value="1"> ';	// 1 = melee
				
				
				echo '
				<input type="hidden" name="phDamageMod" value="1">
	 
				<table class="gxTable1">
					<tr>
						<th class="gxTh1">
							Skill Type:
						</th>
						<th class="gxTh1">
							<select name="phSkillType">
								<option value=0'; if ($_SESSION['phSkillType']==0 OR $_SESSION['phSkillType']==NULL){ echo ' SELECTED'; } echo '>Not Set</option>
								<option value=1'; if ($_SESSION['phSkillType']==1){ echo ' SELECTED'; } echo '>Axe (depreciated)</option>
								<option value=4'; if ($_SESSION['phSkillType']==4){ echo ' SELECTED'; } echo '>Dagger (depreciated)</option>
								<option value=5'; if ($_SESSION['phSkillType']==5){ echo ' SELECTED'; } echo '>Mace (depreciated)</option>
								<option value=9'; if ($_SESSION['phSkillType']==9){ echo ' SELECTED'; } echo '>Spear (depreciated)</option>
								<option value=10'; if ($_SESSION['phSkillType']==10){ echo ' SELECTED'; } echo '>Staff  (depreciated)</option>
								<option value=11'; if ($_SESSION['phSkillType']==11){ echo ' SELECTED'; } echo '>Sword (depreciated)</option>
								<option value=13'; if ($_SESSION['phSkillType']==13){ echo ' SELECTED'; } echo '>Unarmed (depreciated)</option>
								
								<option value=41'; if ($_SESSION['phSkillType']==41){ echo ' SELECTED'; } echo '>Two Handed Combat</option>
								<option value=44'; if ($_SESSION['phSkillType']==44){ echo ' SELECTED'; } echo '>Heavy Weapons</option>
								<option value=45'; if ($_SESSION['phSkillType']==45){ echo ' SELECTED'; } echo '>Light Weapons</option>
								<option value=46'; if ($_SESSION['phSkillType']==46){ echo ' SELECTED'; } echo '>Finesse Weapons</option>
							</select>
						</th>
						<th class="gxTh1">
							Weapon Type:
						</th>
						<th class="gxTh1">
							<select name="phWeaponType">
								<option value=0'; if ($_SESSION['phWeaponType']==0 OR $_SESSION['phWeaponType']==NULL){ echo ' SELECTED'; } echo '>Not Set</option>
								<option value=1'; if ($_SESSION['phWeaponType']==1){ echo ' SELECTED'; } echo '>Unarmed</option>
								<option value=2'; if ($_SESSION['phWeaponType']==2){ echo ' SELECTED'; } echo '>Sword</option>
								<option value=3'; if ($_SESSION['phWeaponType']==3){ echo ' SELECTED'; } echo '>Axe</option>
								<option value=4'; if ($_SESSION['phWeaponType']==4){ echo ' SELECTED'; } echo '>Mace</option>
								<option value=5'; if ($_SESSION['phWeaponType']==5){ echo ' SELECTED'; } echo '>Spear</option>
								<option value=6'; if ($_SESSION['phWeaponType']==6){ echo ' SELECTED'; } echo '>Dagger</option>
								<option value=7'; if ($_SESSION['phWeaponType']==7){ echo ' SELECTED'; } echo '>Staff</option>
							</select>
						</th>
						<th class="gxTh1">
							Damage Type:
						</th>
						<th class="gxTh1">
							<select name="phDamageType">
								<option value=0'; if ($_SESSION['phDamageType']==0 OR $_SESSION['phDamageType']==NULL){ echo ' SELECTED'; } echo '>Not Set</option>
								<option value=1'; if ($_SESSION['phDamageType']==1){ echo ' SELECTED'; } echo '>Slashing</option>
								<option value=2'; if ($_SESSION['phDamageType']==2){ echo ' SELECTED'; } echo '>Piercing</option>
								<option value=3'; if ($_SESSION['phDamageType']==3){ echo ' SELECTED'; } echo '>Slashing/Piercing</option>
								<option value=4'; if ($_SESSION['phDamageType']==4){ echo ' SELECTED'; } echo '>Bludgeon</option>
								<option value=8'; if ($_SESSION['phDamageType']==8){ echo ' SELECTED'; } echo '>Frost</option>
								<option value=16'; if ($_SESSION['phDamageType']==16){ echo ' SELECTED'; } echo '>Fire</option>
								<option value=32'; if ($_SESSION['phDamageType']==32){ echo ' SELECTED'; } echo '>Acid</option>
								<option value=64'; if ($_SESSION['phDamageType']==64){ echo ' SELECTED'; } echo '>Electrical</option>
							</select>
						</th>
					</tr>
					<tr>
						<th class="gxTh1">
							Max Damage:
						</th>
						<th class="gxTh1">
							<input type="text" name="phMaxDamage" value="'.$_SESSION['phMaxDamage'].'" required>
						</th>
						<th class="gxTh1">
							Speed:
						</th>
						<th class="gxTh1">
							<input type="text" name="phSpeed" value="'.$_SESSION['phSpeed'].'" required>
						</th>	
						<th class="gxTh1">
							Variance:
						</th>
						<th class="gxTh1">
							<input type="text" name="phVariance" value="'.$_SESSION['phVariance'].'" required>
						</th>
					</tr>
				</table>
				
				';
			}
			
			if ($_SESSION['phWeenieType']==3) {  	// display base missile attribute input
				echo '<input type="hidden" name="phSkillType" value="47"> '; // skilltype 47 = missile weapons
				echo '<input type="hidden" name="phCombatUse" value="2"> '; // combatuse 2 = missile weapons
				echo '<input type="hidden" name="phDamageTypeXX" value="2"> '; // damagetype 0 = missile weapons
				echo '<input type="hidden" name="phLocationInt" value="4194304"> ';	//phLocationInt 4194304 for bow
				echo '<input type="hidden" name="phItemType" value="256"> ';	// 256= missile
				
				
				echo '
				<table class="gxTable1">
					
					<tr>
						<th class="gxTh1">
							Weapon Type:
						</th>
						<th class="gxTh1">
							<select name="phWeaponType">
								<option value=8'; if ($_SESSION['phWeaponType']==8){ echo ' SELECTED'; } echo '>Bow</option>
								<option value=9'; if ($_SESSION['phWeaponType']==9){ echo ' SELECTED'; } echo '>Crossbow</option>
								<option value=10'; if ($_SESSION['phWeaponType']==10){ echo ' SELECTED'; } echo '>Atlatl</option>
							</select>
						</th>
						<th class="gxTh1">
							Maximum Velocity:
						</th>
						<th class="gxTh1">
							<input type="text" name="phVelocity" value="'.$_SESSION['phVelocity'].'">
						</th>
						<th class="gxTh1">
							Ammo Type:
						</th>
						<th class="gxTh1">
							<select name="phAmmoType">
								<option value=1'; if ($_SESSION['phAmmoType']==1){ echo ' SELECTED'; } echo '>Arrows</option>
								<option value=2'; if ($_SESSION['phAmmoType']==2){ echo ' SELECTED'; } echo '>Quarrels</option>
								<option value=3'; if ($_SESSION['phAmmoType']==3){ echo ' SELECTED'; } echo '>Darts</option>
						</th>
					</tr>
						
					<tr>
						<th class="gxTh1">
							Damage Bonus:
						</th>
						<th class="gxTh1">
							<input type="text" name="phMaxDamage" value="'.$_SESSION['phMaxDamage'].'" required>
						</th>
						<th class="gxTh1">
							Damage Type:
						</th>
						<th class="gxTh1">
							<select name="phDamageType">
								<option value=1'; if ($_SESSION['phDamageType']==1){ echo ' SELECTED'; } echo '>Slashing</option>
								<option value=2'; if ($_SESSION['phDamageType']==2){ echo ' SELECTED'; } echo '>Piercing</option>
								
								<option value=4'; if ($_SESSION['phDamageType']==4){ echo ' SELECTED'; } echo '>Bludgeon</option>
								<option value=8'; if ($_SESSION['phDamageType']==8){ echo ' SELECTED'; } echo '>Frost</option>
								<option value=16'; if ($_SESSION['phDamageType']==16){ echo ' SELECTED'; } echo '>Fire</option>
								<option value=32'; if ($_SESSION['phDamageType']==32){ echo ' SELECTED'; } echo '>Acid</option>
								<option value=64'; if ($_SESSION['phDamageType']==64){ echo ' SELECTED'; } echo '>Electrical</option>
							</select>
						</th>
						<th class="gxTh1">
							Speed:
						</th>
						<th class="gxTh1">
							<input type="text" name="phSpeed" value="'.$_SESSION['phSpeed'].'" required>
						</th>
					</tr>
				</table>
				';
			}
			
			if ($_SESSION['phWeenieType']==35) { 	// display base casting attribute input
				
				echo '<input type="hidden" name="phLocationInt" value="16777216"> ';	//phLocationInt 16777216 for caster
				echo '<input type="hidden" name="phItemType" value="32768"> ';	// 32768=caster
				
				echo '
				<table class="gxTable1">
					<tr>
						<th class="gxTh1">
							Damage Type:
						</th>
						<th class="gxTh1">
							<select name="phDamageType">
								<option value=0'; if ($_SESSION['phDamageType']==1){ echo ' SELECTED'; } echo '>Property NOT used</option>
								<option value=1'; if ($_SESSION['phDamageType']==1){ echo ' SELECTED'; } echo '>Slashing</option>
								<option value=2'; if ($_SESSION['phDamageType']==2){ echo ' SELECTED'; } echo '>Piercing</option>
								<option value=3'; if ($_SESSION['phDamageType']==3){ echo ' SELECTED'; } echo '>Slashing/Piercing</option>
								<option value=4'; if ($_SESSION['phDamageType']==4){ echo ' SELECTED'; } echo '>Bludgeon</option>
								<option value=8'; if ($_SESSION['phDamageType']==8){ echo ' SELECTED'; } echo '>Frost</option>
								<option value=16'; if ($_SESSION['phDamageType']==16){ echo ' SELECTED'; } echo '>Fire</option>
								<option value=32'; if ($_SESSION['phDamageType']==32){ echo ' SELECTED'; } echo '>Acid</option>
								<option value=64'; if ($_SESSION['phDamageType']==64){ echo ' SELECTED'; } echo '>Electrical</option>
								<option value=1024'; if ($_SESSION['phDamageType']==1024){ echo ' SELECTED'; } echo '>Nether</option>
								
							</select>
						</th>
						<th class="gxTh1">
							Damage Bonus (%):
						</th>
						<th class="gxTh1">
							<input type="text" name="phElementalBonus" value="'.$_SESSION['phElementalBonus'].'">
						</th>
					</tr>
				</table>
				
				';
			}
			
			?>
			
			<table class="gxTable1">
				<tr>
					<th class="gxTh1">
						Bonus to Melee Defense (%):
					</th>
					<th class="gxTh1">
						<input type="text" name="phMeleeBonus" value="<?PHP echo $_SESSION['phMeleeBonus']; ?>">
					</th>
					
					<?PHP
					
					if ($_SESSION['phWeenieType']==35) {
					
						echo '
							<th class="gxTh1">
								Bonus to Mana Convertion (%):
							</th>
							<th class="gxTh1">
								<input type="text" name="phManaConvBonus" value="'.$_SESSION['phManaConvBonus'].'">
							</th>
						';	
						
					}
					if ($_SESSION['phWeenieType']==6) {
					
						echo '
							<th class="gxTh1">
								Bonus to Attack Skill (%):
							</th>
							<th class="gxTh1">
								<input type="text" name="phAttackBonus" value="'.$_SESSION['phAttackBonus'].'">
							</th>
						';
					}
					
					if ($_SESSION['phWeenieType']==3) {
					
						echo '
							<th class="gxTh1">
								Damage Modifier (%):
							</th>
							<th class="gxTh1">
								<input type="text" name="phDamageMod" value="'.$_SESSION['phDamageMod'].'" required>
							</th>
						';
					}
					
					?>
				</tr>
				<tr>
					<th class="gxTh1">
						Bonus to Magic Defense (%):
					</th>
					<th class="gxTh1">
						<input type="text" name="phMagDefBonus" value="<?PHP echo $_SESSION['phMagDefBonus']; ?>">
					</th>
					<th class="gxTh1">
						Bonus to Missile Defense (%):
					</th>
					<th class="gxTh1">
						<input type="text" name="phMissDefBonus" value="<?PHP echo $_SESSION['phMissDefBonus']; ?>">
					</th>
				</tr>
			</table>
			<table class="gxTable1">
				<tr>
					<th class="gxTh1">
						<input type="checkbox" name="phAttuned" value=1 <?PHP if ($_SESSION['phAttuned']==1){ echo 'CHECKED'; } ?>> Attuned<br/>
						<input type="checkbox" name="phBonded" value=1 <?PHP if ($_SESSION['phBonded']==1){ echo 'CHECKED'; } ?>> Bonded<br/>
						<input type="checkbox" name="phIvoryable" value=1 <?PHP if ($_SESSION['phIvoryable']==1){ echo 'CHECKED'; } ?>> Ivoryable
					</th>
					
					<th>
					</th>
					
					<th class="gxTh1">
						<input type="checkbox" name="phSellable" value=1 <?PHP if ($_SESSION['phSellable']==1){ echo 'CHECKED'; } ?>> Item Cannot Be Sold<br/>
						<input type="checkbox" name="phDestroy" value=1 <?PHP if ($_SESSION['phDestroy']==1){ echo 'CHECKED'; } ?>> Destroy when Sold<br/>
						<input type="checkbox" name="phRetained" value=1 <?PHP if ($_SESSION['phRetained']==1){ echo 'CHECKED'; } ?>> Has been Retained<br/>					
					</th>
					
					<th>
					</th>
					
					<th class="gxTh1">
						<input type="checkbox" name="phInscribable" value=1 <?PHP if ($_SESSION['phInscribable']==1){ echo 'CHECKED'; } ?>> Inscribable<br/>
						<input type="checkbox" name="phIgnoreMagRes" value=1 <?PHP if ($_SESSION['phIgnoreMagRes']==1){ echo 'CHECKED'; } ?>> Ignore Magic Resist<br/>
						<input type="checkbox" name="phIgnoreMagArm" value=1 <?PHP if ($_SESSION['phIgnoreMagArm']==1){ echo 'CHECKED'; } ?>> Ignore Magic Armor
					</th>
					
				</tr>
			</table>
			<table class="gxTable1">
				<tr>
					<th class="gxTh1">
						Weapon Description (Displayed on lower weapon ID panel in-game):
					</th>
					<th class="gxTh1">
						<input type="text" name="phDescription" size="60" value="<?PHP echo $_SESSION['phDescription']; ?>">
					</th>
				</tr>
			</table>
		</div>
		
		<div class="sectionSpacer"> </div>
		
		<div class="section">
			<div class="sectionTitle">
				Advanced Properties
			</div>
			
			<table class="gxTable1">
				<tr>
					<th class="gxTh1">
						Slayer Type:
					</th>
					<th class="gxTh1">
						<select name="phSlayer">
							<option value=0 <?PHP if ($_SESSION['phSlayer']==0){ echo 'SELECTED'; } ?>>Property NOT used</option>
						
						<?PHP
							while ($db_row=mysqli_fetch_array($db_creatType,MYSQLI_ASSOC)) {
								
								echo '<option value='.$db_row['creatId'];
								
								if ($_SESSION['phSlayer']==$db_row['creatId']){ 
									echo ' SELECTED'; 
								}
								echo '>'.$db_row['creatName'].'</option>';
							}
						?>
						</select>
							
					</th>					




					<th class="gxTh1">
						Slayer Damage Bonus (%):
					</th>
					<th class="gxTh1">
						<input type="text" name="phSlayerBonus" value="<?PHP echo $_SESSION['phSlayerBonus']; ?>">
					</th>
				</tr>
			</table>

<?PHP 
if ($_SESSION['phWeenieType']==6) {	
	echo '
				<table class="gxTable1">
					<tr>
						<th class="gxTh1">
							Attack Type:
						</th>
						<th class="gxTh1">
						</th>
					</tr>
					<tr>
						<th class="gxTh1">
							<input type="checkbox" name="phATPunch" value=1 '; if ($_SESSION['phATPunch']==1){ echo 'CHECKED'; } echo '> Punch<br/>
							<input type="checkbox" name="phATThrust" value=2 '; if ($_SESSION['phATThrust']==2){ echo 'CHECKED'; } echo '> Thrust<br/>
							<input type="checkbox" name="phATSlash" value=4 '; if ($_SESSION['phATSlash']==4){ echo 'CHECKED'; } echo '> Slash<br/>
							<input type="checkbox" name="phATKick" value=8 '; if ($_SESSION['phATKick']==8){ echo 'CHECKED'; } echo '> Kick<br/>
						</th>	
						<th class="gxTh1">
							<input type="checkbox" name="phATDoubSlash" value=32 '; if ($_SESSION['phATDoubSlash']==32){ echo 'CHECKED'; } echo '> Double Slash<br/>
							<input type="checkbox" name="phATTripSlash" value=64 '; if ($_SESSION['phATTripSlash']==64){ echo 'CHECKED'; } echo '> Triple Slash<br/>
							<input type="checkbox" name="phATDoubThrust" value=128 '; if ($_SESSION['phATDoubThrust']==128){ echo 'CHECKED'; } echo '> Double Thrust<br/>
							<input type="checkbox" name="phATTripThrust" value=256 '; if ($_SESSION['phATTripThrust']==256){ echo 'CHECKED'; } echo '> Triple Thrust<br/>
						</th>					
						
					</tr>
				</table>
	';
}
?>			
			
			<table class="gxTable1">
				<tr>
					<th class="gxTh1">
						Wield Requirement:
					</th>
					<th class="gxTh1">
						<select name="phWieldReq" id="phWieldReq">
							<option value=0>No Wield Requirement</option>
							<option value=1 <?PHP if ($_SESSION['phWieldReq']==1){ echo 'SELECTED'; } ?>>Skill</option>
							<option value=2 <?PHP if ($_SESSION['phWieldReq']==2){ echo 'SELECTED'; } ?>>Base Skill</option>
							<option value=3 <?PHP if ($_SESSION['phWieldReq']==3){ echo 'SELECTED'; } ?>>Attribute</option>
							<option value=4 <?PHP if ($_SESSION['phWieldReq']==4){ echo 'SELECTED'; } ?>>Base Attribute</option>
							<option value=5 <?PHP if ($_SESSION['phWieldReq']==5){ echo 'SELECTED'; } ?>>Vital</option>
							<option value=6 <?PHP if ($_SESSION['phWieldReq']==6){ echo 'SELECTED'; } ?>>Base Vital</option>
							<option value=7 <?PHP if ($_SESSION['phWieldReq']==7){ echo 'SELECTED'; } ?>>Character Level</option>
							<option value=8 <?PHP if ($_SESSION['phWieldReq']==8){ echo 'SELECTED'; } ?>>Trained Skill</option>
						</select>
					</th>
					<th class="gxTh1">
						<select name="phWieldAttribute" id="phWieldAttribute" <?PHP if ( $_SESSION['phWieldReq'] > 2 AND $_SESSION['phWieldReq'] < 5 ) { echo 'style="display:block;"'; } ?>>
							<option value=1 <?PHP if ($_SESSION['phWieldAttribute']==1){ echo 'SELECTED'; } ?>>Strength</option>
							<option value=2 <?PHP if ($_SESSION['phWieldAttribute']==2){ echo 'SELECTED'; } ?>>Endurance</option>
							<option value=3 <?PHP if ($_SESSION['phWieldAttribute']==3){ echo 'SELECTED'; } ?>>Quickness</option>
							<option value=4 <?PHP if ($_SESSION['phWieldAttribute']==4){ echo 'SELECTED'; } ?>>Coordination</option>
							<option value=5 <?PHP if ($_SESSION['phWieldAttribute']==5){ echo 'SELECTED'; } ?>>Focus</option>
							<option value=6 <?PHP if ($_SESSION['phWieldAttribute']==6){ echo 'SELECTED'; } ?>>Self</option>
						</select>
						
						<select name="phWieldVital" id="phWieldVital" <?PHP if ( $_SESSION['phWieldReq'] > 4 AND $_SESSION['phWieldReq'] < 7 ) { echo 'style="display:block;"'; } ?>>
							<option value=1 <?PHP if ($_SESSION['phWieldVital']==1){ echo 'SELECTED'; } ?>>Max Health</option>
							<option value=2 <?PHP if ($_SESSION['phWieldVital']==2){ echo 'SELECTED'; } ?>>Health</option>
							<option value=3 <?PHP if ($_SESSION['phWieldVital']==3){ echo 'SELECTED'; } ?>>Max Stamina</option>
							<option value=4 <?PHP if ($_SESSION['phWieldVital']==4){ echo 'SELECTED'; } ?>>Stamina</option>
							<option value=5 <?PHP if ($_SESSION['phWieldVital']==5){ echo 'SELECTED'; } ?>>Max Mana</option>
							<option value=6 <?PHP if ($_SESSION['phWieldVital']==6){ echo 'SELECTED'; } ?>>Mana</option>
						</select>
						
							
						<select name="phWieldSkill" id="phWieldSkill" <?PHP if ( ($_SESSION['phWieldReq'] > 0 AND $_SESSION['phWieldReq'] < 3) OR ($_SESSION['phWieldReq'] == 8) ) { echo 'style="display:block;"'; } ?>>	
							<option value=0 <?PHP if ($_SESSION['phWieldSkill']==0 OR $_SESSION['phWieldSkill']==NULL){ echo 'SELECTED'; } ?>>Not Set</option>
							
							<?PHP
							while ($db_row=mysqli_fetch_array($db_skills,MYSQLI_ASSOC)) {
								
								echo '<option value='.$db_row['enum'];
								
								if ($_SESSION['phWieldSkill']==$db_row['enum']){ 
									echo ' SELECTED'; 
								}
								echo '>'.$db_row['name'].'</option>';
							}
							?>
						</select>
					</th>
					<th class="gxTh1">
						Value:
					</th>
					<th class="gxTh1">
						<input type="text" name="phWieldValue" id="phWieldValue" value="<?PHP echo $_SESSION['phWieldValue']; ?>" <?PHP if ($_SESSION['phWieldReq']) { echo 'style="display:block;"'; } ?>>
					</th>
				</tr>
			</table>			
		</div>
		
		<div class="sectionSpacer"> </div>
		
		<div class="section">
			<div class="sectionTitle">
				Imbue & Tinkering Properties
			</div>
			
			<table class="gxTable1">
				<tr>
					<th class="gxTh1">
						<input type="checkbox" name="phTinkCritStrike" value=1 <?PHP if ($_SESSION['phTinkCritStrike']==1){ echo 'CHECKED'; } ?>> Critical Strike<br/>
						<input type="checkbox" name="phTinkCripBlow" value=2 <?PHP if ($_SESSION['phTinkCripBlow']==2){ echo 'CHECKED'; } ?>>  Crippling Blow<br/>
						<input type="checkbox" name="phTinkArmorRend" value=4 <?PHP if ($_SESSION['phTinkArmorRend']==4){ echo 'CHECKED'; } ?>>  Armor Rend<br/>
						<input type="checkbox" name="phTinkSlash" value=8 <?PHP if ($_SESSION['phTinkSlash']==8){ echo 'CHECKED'; } ?>>  Slash Rend<br/>
						<input type="checkbox" name="phTinkPierce" value=16 <?PHP if ($_SESSION['phTinkPierce']==16){ echo 'CHECKED'; } ?>>  Pierce Rend
					</th>
					<th class="gxTh1">
						<input type="checkbox" name="phTinkBludg" value=32 <?PHP if ($_SESSION['phTinkBludg']==32){ echo 'CHECKED'; } ?>>  Bludgeon Rend<br/>
						<input type="checkbox" name="phTinkAcid" value=64 <?PHP if ($_SESSION['phTinkAcid']==64){ echo 'CHECKED'; } ?>>  Acid Rend<br/>
						<input type="checkbox" name="phTinkCold" value=128 <?PHP if ($_SESSION['phTinkCold']==128){ echo 'CHECKED'; } ?>>  Cold Rend<br/>
						<input type="checkbox" name="phTinkLight" value=256 <?PHP if ($_SESSION['phTinkLight']==256){ echo 'CHECKED'; } ?>>  Lightning Rend<br/>
						<input type="checkbox" name="phTinkFire" value=512 <?PHP if ($_SESSION['phTinkFire']==512){ echo 'CHECKED'; } ?>>  Fire Rend
					</th>
				</tr>
			</table>
					
			<table class="gxTable1">
				<tr>
					<th class="gxTh1">
						Times Tinkered:
					</th>
					<th class="gxTh1">
						<select name="phTimesTinkered">
							<option value=0>Not Tinkered by Player</option>
							<option value=1 <?PHP if ($_SESSION['phTimesTinkered']==1){ echo 'SELECTED'; } ?>>1</option>
							<option value=2 <?PHP if ($_SESSION['phTimesTinkered']==2){ echo 'SELECTED'; } ?>>2</option>
							<option value=3 <?PHP if ($_SESSION['phTimesTinkered']==3){ echo 'SELECTED'; } ?>>3</option>
							<option value=4 <?PHP if ($_SESSION['phTimesTinkered']==4){ echo 'SELECTED'; } ?>>4</option>
							<option value=5 <?PHP if ($_SESSION['phTimesTinkered']==5){ echo 'SELECTED'; } ?>>5</option>
							<option value=6 <?PHP if ($_SESSION['phTimesTinkered']==6){ echo 'SELECTED'; } ?>>6</option>
							<option value=7 <?PHP if ($_SESSION['phTimesTinkered']==7){ echo 'SELECTED'; } ?>>7</option>
							<option value=8 <?PHP if ($_SESSION['phTimesTinkered']==8){ echo 'SELECTED'; } ?>>8</option>
							<option value=9 <?PHP if ($_SESSION['phTimesTinkered']==9){ echo 'SELECTED'; } ?>>9</option>
							<option value=10 <?PHP if ($_SESSION['phTimesTinkered']==10){ echo 'SELECTED'; } ?>>10</option>
							
						</select>
					</th>
					<th class="gxTh1">
						Imbued By:
					</th>
					<th class="gxTh1">
						<input type="text" name="phImbuedBy" value="<?PHP echo $_SESSION['phImbuedBy']; ?>">
					</th>
					<th class="gxTh1">
						Last Tinkered By:
					</th>
					<th class="gxTh1">
						<input type="text" name="phLastTinker" value="<?PHP echo $_SESSION['phLastTinker']; ?>">
					</th>
				</tr>
			</table>		
		</div>
		
		<div class="sectionSpacer"> </div>
		
		<div class="section">
			<div class="sectionTitle">
				Magical Properties
			</div>
			NOTE: There has to be atleast one spell in the spellbook for the magical properties to show on a weapon when ID'd in-game
			<table class="gxTable1">
				<tr>
					<th class="gxTh1">
						Spellcraft:
					</th>
					<th class="gxTh1">
						<input type="text" name="phSpellCraft" value="<?PHP echo $_SESSION['phSpellCraft']; ?>">
					</th>
					<th class="gxTh1">
						Max Mana:
					</th>
					<th class="gxTh1">
						<input type="text" name="phMaxMana" value="<?PHP echo $_SESSION['phMaxMana']; ?>">
					</th>
					<th class="gxTh1">
						Current Mana:
					</th>
					<th class="gxTh1">
						<input type="text" name="phCurrMana" value="<?PHP echo $_SESSION['phCurrMana']; ?>">
					</th>
				</tr>
			</table>
			<table class="gxTable1">
				<tr>
					<th class="gxTh1">
						Mana Loss (1 point every N seconds):
					</th>
					<th class="gxTh1">
						<input type="text" name="phManaRate" value="<?PHP echo $_SESSION['phManaRate']; ?>">
					</th>
				</tr>
				<tr>
					<th class="gxTh1">
						Arcane Lore Activation Requirement:
					</th>		
					<th class="gxTh1">
						<input type="text" name="phArcane" value="<?PHP echo $_SESSION['phArcane']; ?>">
					</th>
				</tr>
			</table>
			
	
		
		</div>
		
		<div class="sectionSpacer"> </div>
		
		<div class="section">
			<div class="sectionTitle">
				Data IDs and Styling
			</div>
			*All values in this section should be in hexidecimal format EXCLUDING "Translucency" and "Scale", which are floating points.
			
			<input type="hidden" name="phDidSoundTable" value="0x20000014">
			<input type="hidden" name="phDidPaletteBase" value="0x4000BEF">
			<input type="hidden" name="phDidClothingBase" value="0x1000013A">
			<input type="hidden" name="phDidPhysics" value="0x3400002B">
			
			<table class="gxTable1">
				<tr>
					<th class="gxTh1">
						Setup ID (model):
					</th>
					<th class="gxTh1">
						<input type="text" name="phDidSetup" value="<?PHP echo $_SESSION['phDidSetup']; ?>" required>
					</th>
					<th class="gxTh1">
						Translucency:
					</th>
					<th class="gxTh1">
						<input type="text" name="phTranslucent" value="<?PHP echo $_SESSION['phTranslucent']; ?>">
					</th>
					<th class="gxTh1">
						Scale:
					</th>
					<th class="gxTh1">
						<input type="text" name="phScale" value="<?PHP if ($_SESSION['phScale']) { echo $_SESSION['phScale']; } else { echo '1'; } ?>" required>
					</th>
				</tr>
				
			</table>
			
			<div class="subSection">
				<center>
					<font class="subSectionTitle">Icon and Icon Layers</font>
				</center>
				
				<table class="gxTable1">
					<tr>
						<th class="gxTh1">
							Icon ID:
						</th>
						<th class="gxTh1">
							<input type="text" name="phDidIcon" value="<?PHP echo $_SESSION['phDidIcon']; ?>" required>
						</th>
						<th class="gxTh1">
							Icon Outline:
						</th>
						<th class="gxTh1">
							<select name="phUiEffects">
								<option value=0>Black / No Outline</option>
								<option value=1 <?PHP if ($_SESSION['phUiEffects']==1){ echo 'SELECTED'; } ?>>Blue</option>
								<option value=2 <?PHP if ($_SESSION['phUiEffects']==2){ echo 'SELECTED'; } ?>>Green</option>
								<option value=4 <?PHP if ($_SESSION['phUiEffects']==4){ echo 'SELECTED'; } ?>>Red</option>
								<option value=8 <?PHP if ($_SESSION['phUiEffects']==8){ echo 'SELECTED'; } ?>>Yellow</option>
								<option value=16 <?PHP if ($_SESSION['phUiEffects']==16){ echo 'SELECTED'; } ?>>Orange</option>
								<option value=32 <?PHP if ($_SESSION['phUiEffects']==32){ echo 'SELECTED'; } ?>>Purple</option>
								<option value=64 <?PHP if ($_SESSION['phUiEffects']==64){ echo 'SELECTED'; } ?>>Light Blue</option>
								<option value=128 <?PHP if ($_SESSION['phUiEffects']==128){ echo 'SELECTED'; } ?>>Light Green</option>
								<option value=256 <?PHP if ($_SESSION['phUiEffects']==256){ echo 'SELECTED'; } ?>>Grey</option>
								<option value=512 <?PHP if ($_SESSION['phUiEffects']==512){ echo 'SELECTED'; } ?>>Pink</option>
								<option value=1024 <?PHP if ($_SESSION['phUiEffects']==1024){ echo 'SELECTED'; } ?>>Cream/White</option>
							</select>
							
							
							
							
						</th>
					</tr>
						<th class="gxTh1">
							Underlay:
						</th>
						<th class="gxTh1">
							<input type="text" name="phDidIconUnder" value="<?PHP echo $_SESSION['phDidIconUnder']; ?>">
						</th>
						<th class="gxTh1">
							Overlay 1:
						</th>
						<th class="gxTh1">
							<input type="text" name="phDidIconOver1" value="<?PHP echo $_SESSION['phDidIconOver1']; ?>">
						</th>
						<th class="gxTh1">
							Overlay 2:
						</th>
						<th class="gxTh1">
							<input type="text" name="phDidIconOver2" value="<?PHP echo $_SESSION['phDidIconOver2']; ?>">
						</th>
					</tr>
				</table>
				<button id="exampleButton" type="button">Toggle Reference IDs</button>
				<div id="exampleBody">
					<div class="exampleTitle">
						Icon Underlays
					</div>
					<?PHP
						for ($z = 0 ; $z < count($iconUnderlayArray) ; $z++ ) { 
								echo '<div class="iconContainer">';
								echo '<center><img src="./img/ac_icons/'.substr($iconUnderlayArray[$z],-4).'.png"></center>';
								echo '<div class="iconHexText">'.$iconUnderlayArray[$z];
								echo '</div>';
								echo '</div>';	
						}	
					?>
					<div class="sectionSpacer"> </div>
					<div class="exampleTitle">
						Icon Overlays
					</div>
					<?PHP
						for ($z = 0 ; $z < count($iconOverlayArray) ; $z++ ) { 
								echo '<div class="iconContainer">';
								echo '<center><img src="./img/ac_icons/'.substr($iconOverlayArray[$z],-4).'.png"></center>';
								echo '<div class="iconHexText">'.$iconOverlayArray[$z];
								echo '</div>';
								echo '</div>';	
						}	
					?>
				
				
				</div>
				
			</div>
			<a href="iconviewer.php" target="_blank">Icon Viewer (Not Optimized, may run a little slow)</a>
		</div>
		<div class="sectionSpacer"> </div>
		
		<div class="section">
			<center><button class="phButton" type="submit">Proceed To Spellbook</button></center>
		</div>		
	</form>
	</div>
	
	Updated 8/27/2017
	<br/>
	<center>
		<?PHP
			if ($_SESSION['theme'] == "classic.css"){
				echo '<a href="index.php?theme=default">Business in the Front</a>';
			}
			if ($_SESSION['theme'] == "default.css"){
				echo '<a href="index.php?theme=classic">Party in the Back</a>';
			}
		?>
		
		
		<br/>
	
		<a href="auth.php?killsess=true">End Session</a>
	</center>
	
	
	
	
	
	
	
	</body>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script> 
		$(document).ready(function(){
			$("#exampleButton").click(function(){
				$("#exampleBody").slideToggle("fast");
			});
		});
	</script>
	
	<script> 
		$(document).ready(function(){
			$("#showImportButton").click(function(){
				$("#importView").slideToggle("fast");
			});
		});
	</script>
	
	<script>
	$(function() {
		$('#phWieldReq').change(function(){
			$('#phWieldAttribute').hide();
			$('#phWieldVital').hide();
			$('#phWieldSkill').hide();
			$('#phWieldValue').hide();
			
			if ( $(this).val() == 1 ) {
				$('#phWieldSkill').show();
				$('#phWieldValue').show();
			}
			
			if ( $(this).val() == 2 ) {
				$('#phWieldSkill').show();
				$('#phWieldValue').show();
			}
			
			if ( $(this).val() == 3 ) {
				$('#phWieldAttribute').show();
				$('#phWieldValue').show();
			}
			
			if ( $(this).val() == 4 ) {
				$('#phWieldAttribute').show();
				$('#phWieldValue').show();
			}
			
			if ( $(this).val() == 5 ) {
				$('#phWieldVital').show();
				$('#phWieldValue').show();
			}
			
			if ( $(this).val() == 6 ) {
				$('#phWieldVital').show();
				$('#phWieldValue').show();
			}
			
			if ( $(this).val() == 7 ) {
				$('#phWieldValue').show();
			}
			
			if ( $(this).val() == 8 ) {
				$('#phWieldSkill').show();
			}
		});
	});
	</script>
	
	<script>
	
		document.getElementById("userFile").onchange = function() {
		document.getElementById("uploadForm").submit();
		};
    </script>
	

</html>