<?PHP


$uploaddir = './json_temp/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    //echo "File is valid, and was successfully uploaded.\n";
	//echo basename($_FILES['userfile']['name']);
} else {
    die( "An error occured while uploading the file.");
}




session_start();

class spellBook {
	public $spellId;
	public $spellName;
}


$themeTMP = $_SESSION['theme'];
session_unset();
	$_SESSION['theme'] = $themeTMP;
	$_SESSION['authorized'] = True;


require ('../db_connect.php');




$mkProp = "";
$tickTock = 0;
$notUsedCount = 0;
$totalUsed = 0;
$spellCount = 0;

$phSpellBook_tmp[] = new spellBook();


$json_array = json_decode(file_get_contents($uploadfile), true);

foreach($json_array as $key => $arrays){

    //echo $key . "<br />";
	
	$mkProp = $key;

    foreach($arrays as $array){
        foreach($array as $key => $value){
            //echo $key . " => " . $value . "<br />";
        
		$valueUsed = false;
		
		if ($tickTock==0 AND $mkProp != 'spellbook') {
			$mkKey = $value;
		}
		
		if ($tickTock==0 AND $mkProp == 'spellbook') { //---------------------------------------Load Spellbook
			
			$phSpellBook_tmp[$spellCount]->spellId = $value;
			
			
			$db_data = mysqli_fetch_assoc(mysqli_query($db_conn, ('SELECT spell_name FROM spells WHERE spell_id='.$value.' LIMIT 1')));
			
			$phSpellBook_tmp[$spellCount]->spellName = $db_data['spell_name'];
			
			$spellCount++;
			$totalUsed++;
		}
		
		if ($mkProp=="boolStats" AND $tickTock==1) { // ------------------------------------Load boolStats
			
			if ($mkKey==22){ $_SESSION['phInscribable'] = $value; $valueUsed = true;}
			if ($mkKey==23){ $_SESSION['phDestroy'] = $value; $valueUsed = true;}	
			if ($mkKey==65){ $_SESSION['phIgnoreMagRes'] = $value; $valueUsed = true;}	
			if ($mkKey==66){ $_SESSION['phIgnoreMagArm'] = $value; $valueUsed = true;}	
			if ($mkKey==69){ $_SESSION['phSellable'] = $value; $valueUsed = true;}	
			if ($mkKey==91){ $_SESSION['phRetained'] = $value; $valueUsed = true;}	
			if ($mkKey==99){ $_SESSION['phIvoryable'] = $value; $valueUsed = true;}		
		}
		
		
		if ($mkProp=="didStats" AND $tickTock==1) { // ------------------------------------Load didStats
		
			if ($mkKey==1){ $_SESSION['phDidSetup'] = '0x'.dechex($value); $valueUsed = true;}
			if ($mkKey==3){ $_SESSION['phDidSoundTable'] = '0x'.dechex($value); $valueUsed = true;}
			if ($mkKey==6){ $_SESSION['phDidPaletteBase'] = '0x'.dechex($value); $valueUsed = true;}
			if ($mkKey==7){ $_SESSION['phDidClothingBase'] = '0x'.dechex($value); $valueUsed = true;}
			if ($mkKey==8){ $_SESSION['phDidIcon'] = '0x'.(dechex($value-100663296)); $valueUsed = true;}
			if ($mkKey==22){ $_SESSION['phDidPhysics'] = '0x'.dechex($value); $valueUsed = true;}
			if ($mkKey==50){ $_SESSION['phDidIconOver2'] = '0x'.(dechex($value-100663296)); $valueUsed = true;}
			if ($mkKey==51){ $_SESSION['phDidIconOver1'] = '0x'.(dechex($value-100663296)); $valueUsed = true;}
			if ($mkKey==52){ $_SESSION['phDidIconUnder'] = '0x'.(dechex($value-100663296)); $valueUsed = true;}
			
		}
		
		if ($mkProp=="floatStats" AND $tickTock==1) { // ------------------------------------Load floatStats
			if ($mkKey==5){ $_SESSION['phManaRate'] = round(1/$value); $valueUsed = true;}	
			if ($mkKey==22){ $_SESSION['phVariance'] = ($value); $valueUsed = true;}	
			if ($mkKey==26){ $_SESSION['phVelocity'] = ($value); $valueUsed = true;}	
			if ($mkKey==29){ $_SESSION['phMeleeBonus'] = round(($value - 1) * 100); $valueUsed = true;}	
			if ($mkKey==144){ $_SESSION['phManaConvBonus'] = round(($value) * 100); $valueUsed = true;}	
			if ($mkKey==149){ $_SESSION['phMissDefBonus'] = round(($value - 1) * 100); $valueUsed = true;}	
			if ($mkKey==150){ $_SESSION['phMagDefBonus'] = round(($value - 1) * 100); $valueUsed = true;}	
			if ($mkKey==152){ $_SESSION['phElementalBonus'] = round(($value - 1) * 100); $valueUsed = true;}	
			if ($mkKey==39){ $_SESSION['phScale'] = ($value); $valueUsed = true;}	
			if ($mkKey==62){ $_SESSION['phAttackBonus'] = round(($value - 1) * 100); $valueUsed = true;}	
			if ($mkKey==63){ $_SESSION['phDamageMod'] = round(($value - 1) * 100); $valueUsed = true;}	
			if ($mkKey==76){ $_SESSION['phTranslucent'] = ($value); $valueUsed = true;}	
			if ($mkKey==138){ $_SESSION['phSlayerBonus'] = round(($value - 1) * 100); $valueUsed = true;}	
			if ($mkKey==21){ $_SESSION['phLength'] = ($value); $valueUsed = true;}	
			
		
		
		}
		
		
		if ($mkProp=="intStats" AND $tickTock==1) { // ------------------------------------Load intStats
		
			if ($mkKey==1){ $_SESSION['phItemType'] = $value; $valueUsed = true;}	
			if ($mkKey==5){ $_SESSION['phBurden'] = $value; $valueUsed = true;}	
			if ($mkKey==8){ $_SESSION['phMass'] = $value; $valueUsed = true;}	
			if ($mkKey==9){ $_SESSION['phLocationInt'] = $value; $valueUsed = true;}	
			if ($mkKey==16){ $_SESSION['phItemUsable'] = $value; $valueUsed = true;}
			if ($mkKey==18){ $_SESSION['phUiEffects'] = $value; $valueUsed = true;}
			if ($mkKey==19){ $_SESSION['phValue'] = $value; $valueUsed = true;}	
			if ($mkKey==33){ $_SESSION['phBonded'] = $value; $valueUsed = true;}	
			if ($mkKey==44){ $_SESSION['phMaxDamage'] = $value; $valueUsed = true;}	
			if ($mkKey==45){ $_SESSION['phDamageType'] = $value; $valueUsed = true;}	
			if ($mkKey==46){ $_SESSION['phCombatStyle'] = $value; $valueUsed = true;}	
			if ($mkKey==47){ $_SESSION['phAttackType'] = $value; $valueUsed = true;}	
			if ($mkKey==48){ $_SESSION['phSkillType'] = $value; $valueUsed = true;}	
			if ($mkKey==49){ $_SESSION['phSpeed'] = $value; $valueUsed = true;}	
			if ($mkKey==50){ $_SESSION['phAmmoType'] = $value; $valueUsed = true;}	
			if ($mkKey==51){ $_SESSION['phCombatUse'] = $value; $valueUsed = true;}	
			if ($mkKey==93){ $_SESSION['phPhsicsState'] = $value; $valueUsed = true;}	
			if ($mkKey==106){ $_SESSION['phSpellCraft'] = $value; $valueUsed = true;}	
			if ($mkKey==107){ $_SESSION['phCurrMana'] = $value; $valueUsed = true;}	
			if ($mkKey==108){ $_SESSION['phMaxMana'] = $value; $valueUsed = true;}	
			if ($mkKey==109){ $_SESSION['phArcane'] = $value; $valueUsed = true;}	
			if ($mkKey==114){ $_SESSION['phAttuned'] = $value; $valueUsed = true;}	
			if ($mkKey==131){ $_SESSION['phMaterial'] = $value; $valueUsed = true;}	
			if ($mkKey==105){ $_SESSION['phWorkmanship'] = $value; $valueUsed = true;}	
			
			if ($mkKey==150){ $_SESSION['phHookPlacement'] = $value; $valueUsed = true;}	
			if ($mkKey==151){ $_SESSION['phHookType'] = $value; $valueUsed = true;}	
			
			
			if ($mkKey==158){ $_SESSION['phWieldReq'] = $value; $valueUsed = true;}	
			if ($mkKey==159){ $_SESSION['phWieldSkill'] = $value; $valueUsed = true;}	
			if ($mkKey==160){ $_SESSION['phWieldValue'] = $value; $valueUsed = true;}	
			if ($mkKey==166){ $_SESSION['phSlayer'] = $value; $valueUsed = true;}	
			if ($mkKey==171){ $_SESSION['phTimesTinkered'] = $value; $valueUsed = true;}	
			
			
			if ($mkKey==179){ 
			
				$valTmp = $value;
				
				if ($valTmp >= 512) {
					$_SESSION['phTinkFire'] = 512;
					$valTmp = $valTmp - 512;
				}
				
				if ($valTmp >= 256) {
					$_SESSION['phTinkLight'] = 256;
					$valTmp = $valTmp - 256;
				}
				
				if ($valTmp >= 128) {
					$_SESSION['phTinkCold'] = 128;
					$valTmp = $valTmp - 128;
				}
				
				if ($valTmp >= 64) {
					$_SESSION['phTinkAcid'] = 64;
					$valTmp = $valTmp - 64;
				}
				
				if ($valTmp >= 32) {
					$_SESSION['phTinkBludg'] = 32;
					$valTmp = $valTmp - 32;
				}
				
				if ($valTmp >= 16) {
					$_SESSION['phTinkPierce'] = 16;
					$valTmp = $valTmp - 16;
				}
				
				if ($valTmp >= 8) {
					$_SESSION['phTinkSlash'] = 8;
					$valTmp = $valTmp - 8;
				}
				
				if ($valTmp >= 4) {
					$_SESSION['phTinkArmorRend'] = 4;
					$valTmp = $valTmp - 4;
				}
				
				if ($valTmp >= 2) {
					$_SESSION['phTinkCripBlow'] = 2;
					$valTmp = $valTmp - 2;
				}
				
				if ($valTmp >= 1) {
					$_SESSION['phTinkCritStrike'] = 1;
					$valTmp = $valTmp - 1;
				}
	
				
				$_SESSION['phImbued'] = $value; $valueUsed = true;
				
				
				
			}	
			
			if ($mkKey==263){ $_SESSION['phResisModType'] = $value; $valueUsed = true;}	
			if ($mkKey==353){ $_SESSION['phWeaponType'] = $value; $valueUsed = true;}	
			
			
		
		}
		
		if ($mkProp=="stringStats" AND $tickTock==1) { // ------------------------------------Load stringStats
		
			if ($mkKey==1){ $_SESSION['phName'] = $value; $valueUsed = true;}	
			if ($mkKey==16){ $_SESSION['phDescription'] = $value; $valueUsed = true;}	
			if ($mkKey==39){ $_SESSION['phLastTinker'] = $value; $valueUsed = true;}	
			if ($mkKey==40){ $_SESSION['phImbuedBy'] = $value; $valueUsed = true;}	
			
		
		}
		


		if ($valueUsed==False AND $tickTock==1 AND $mkProp!='spellbook') {
			
			$notUsedCount++;
			
		}
		else {
			$totalUsed++;
		}

		$valueUsed=false;
		
		$tickTock++;
		if ($tickTock==2) {$tickTock=0;}
		

		
		}
    }

}

mysqli_close ($db_conn);	


$_SESSION['phWeenieType'] = $json_array[weenieType];
$_SESSION['wcid'] = $json_array[wcid];

$_SESSION['phSpellBook'] = $phSpellBook_tmp;
$_SESSION['phSpellCount'] = $spellCount;
$_SESSION['phImportFile'] = basename($_FILES['userfile']['name']);
$_SESSION['phImportedKeys'] = $totalUsed;
$_SESSION['phUnknownKeys'] = $notUsedCount;


header("Location: index.php");



?>
<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="default.css" />
<body id="mainBody">

</body>
</html>


