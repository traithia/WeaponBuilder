<?PHP
/*



*/


session_start();

class spellBook {
	public $spellId;
	public $spellName;
}


$phWeaponBuild = '{'.  //build boolean stats
	'"boolStats":[';
	
		$phBoolFlag = False;		// this flag will be set to TRUE by the first stat to be appended thus allowing a comma (,) to be placed prior to further stat additions

	
		if ($_SESSION['phInscribable']) { 

			if ($phBoolFlag) {
				$phWeaponBuild .=',';
			}
			
			$phWeaponBuild .= '{"key":22 ,"value":'.$_SESSION['phInscribable'].'}';  	// is inscribable
			$phBoolFlag = True;
		}
		
		if ($_SESSION['phDestroy']) {

			if ($phBoolFlag) {
				$phWeaponBuild .=',';
			}
			
			$phWeaponBuild .= '{"key":23 ,"value":'.$_SESSION['phDestroy'].'}'; 		// destroy on sale
			$phBoolFlag = True;
		}
		
		if ($_SESSION['phIgnoreMagRes']) {

			if ($phBoolFlag) {
				$phWeaponBuild .=',';
			}
			
			$phWeaponBuild .= '{"key":65 ,"value":'.$_SESSION['phIgnoreMagRes'].'}'; 	// ignore magic resist
			$phBoolFlag = True;
		}	
		
		if ($_SESSION['phIgnoreMagArm']) {

			if ($phBoolFlag) {
				$phWeaponBuild .=',';
			}
			
			$phWeaponBuild .= '{"key":66 ,"value":'.$_SESSION['phIgnoreMagArm'].'}'; 	// ignore magic armor
			$phBoolFlag = True;
		}
		
		if ($_SESSION['phSellable']==1) {

			if ($phBoolFlag) {
				$phWeaponBuild .=',';
			}
			
			$phWeaponBuild .= '{"key":69 ,"value":0}';								// cannot be sold. 
			$phBoolFlag = True;
		}
		
		if ($_SESSION['phRetained']) {

			if ($phBoolFlag) {
				$phWeaponBuild .=',';
			}
			
			$phWeaponBuild .= '{"key":91 ,"value":'.$_SESSION['phRetained'].'}';		// is retained (leather already added) I believe this is set to true by the server when leather is applied
			$phBoolFlag = True;
		}
		
		if ($_SESSION['phIvoryable']) {

			if ($phBoolFlag) {
				$phWeaponBuild .=',';
			}
			
			$phWeaponBuild .= '{"key":99 ,"value":'.$_SESSION['phIvoryable'].'}';		// is ivoryable
			$phBoolFlag = True;
		}
	
	
$phWeaponBuild .= //build  DID stats
	'],'.
	'"didStats":[';

		$phWeaponBuild .= '{"key":1 ,"value":'.hexdec($_SESSION['phDidSetup']).'}';							// graphic model of the weapon
		$phWeaponBuild .= ',{"key":3 ,"value":'.hexdec($_SESSION['phDidSoundTable']).'}';
		$phWeaponBuild .= ',{"key":6 ,"value":'.hexdec($_SESSION['phDidPaletteBase']).'}';
		$phWeaponBuild .= ',{"key":7 ,"value":'.hexdec($_SESSION['phDidClothingBase']).'}';
		$phWeaponBuild .= ',{"key":8 ,"value":'.(hexdec($_SESSION['phDidIcon'])+100663296).'}'; 			// Icon ID (Ive been using "AC Icon Browser" so for ease of data entry)
		$phWeaponBuild .= ',{"key":22 ,"value":'.hexdec($_SESSION['phDidPhysics']).'}';
		
		if ($_SESSION['phDidIconOver1']) {
			$phWeaponBuild .= ',{"key":50 ,"value":'.(hexdec($_SESSION['phDidIconOver1'])+100663296).'}';	//icon overlay 2
		}	
		
		if ($_SESSION['phDidIconOver1']) {
			$phWeaponBuild .= ',{"key":51 ,"value":'.(hexdec($_SESSION['phDidIconOver1'])+100663296).'}';	//icon overlay 1
		}
		
		if ($_SESSION['phDidIconUnder']) {
			$phWeaponBuild .= ',{"key":52 ,"value":'.(hexdec($_SESSION['phDidIconUnder'])+100663296).'}';	//icon underlay 
		}
		
		//$phWeaponBuild .= ',{"key":55 ,"value":43}';														// CAST ON STRIKE PLACEHOLDER. not yet implemeneted as of phatac 1.0.0.5

		
		
		
/*

63D6 - Rabbits Foot overlay, 
640F to 6413 corner icon overlays, 
6486 - mukkir slayer overlay, 
64F7 - undead slayer overlay
665D - spectral force overlay
6BAF - spectral Skull overlay
7066 - a'nekshey slayer overlay	
	
*/


	
$phWeaponBuild .=	//build float stats
	'],'.
	'"floatStats":[';
	
	//-----------Check for leading '0' on manually entered floats and add if neccessary	
		$phVariance=$_SESSION['phVariance'];
			if (substr($phVariance,0,1)=='.') { $phVariance = '0'.$phVariance; }
			
		$phScale=$_SESSION['phScale'];
			if (substr($phScale,0,1)=='.') { $phScale = '0'.$phScale; }
		
		$phTranslucent=$_SESSION['phTranslucent'];
			if (substr($phTranslucent,0,1)=='.') { $phTranslucent = '0'.$phTranslucent; }	
	//-------------------------------
	
	
	
	
		if ($_SESSION['phManaRate']) {
			$phWeaponBuild .= '{"key":5 ,"value":'.(1/$_SESSION['phManaRate']).'},';				// Sets the rate mana is drained from item **RESEARCH: should this value be negative? 
		}	
	
		if ($_SESSION['phVariance']) {
		$phWeaponBuild .= '{"key":22 ,"value":'.$phVariance.'},';									// sets weapon variance
		}
		
		$phWeaponBuild .= '{"key":26 ,"value":20},';  // MAX VELOCITY MISSILE
		
		if ($_SESSION['phMeleeBonus']) {
			$phWeaponBuild .= '{"key":29 ,"value":'.(($_SESSION['phMeleeBonus']/100)+1).'},';		// melee defense bonus multiplier. 
		}
		
		if ($_SESSION['phManaConvBonus']) {
			$phWeaponBuild .= '{"key":29 ,"value":'.(($_SESSION['phManaConvBonus']/100)+1).'},';	// mana conversion  bonus multiplier. 
		}
		
		if ($_SESSION['phMissDefBonus']) {
			$phWeaponBuild .= '{"key":149 ,"value":'.(($_SESSION['phMissDefBonus']/100)+1).'},';	// missile defense bonus multiplier. 
		}
		
		if ($_SESSION['phMagDefBonus']) {
			$phWeaponBuild .= '{"key":150 ,"value":'.(($_SESSION['phMagDefBonus']/100)+1).'},';		// magic defense bonus multiplier. 
		}
		
		if ($_SESSION['phElementalBonus']) {
			$phWeaponBuild .= '{"key":152 ,"value":'.(($_SESSION['phElementalBonus']/100)+1).'},';	// elemental damage bonus multiplier. 
		}
		
				
		$phWeaponBuild .= '{"key":39 ,"value":'.$phScale.'},';										// DEFAULT_SCALE_FLOAT the size or scale of the weapon
		
		
		if ($_SESSION['phAttackBonus']) {
			$phWeaponBuild .= '{"key":62 ,"value":'.(($_SESSION['phAttackBonus']/100)+1).'},';		// attack bonus multiplier
		}
		
		$phWeaponBuild .= '{"key":63 ,"value":'.(($_SESSION['phDamageMod']/100)+1).'},';			// Damage modifier multiplier (if missile, dam mod of 80% = 1.80
		
		if ($_SESSION['phTranslucent']) {
			$phWeaponBuild .= '{"key":76 ,"value":'.$phTranslucent.'},';							// translucency 0-1. 0 is solid 1 is invisable. Phantom weapons = .7
		}
		
		if ($_SESSION['phSlayer']) {
			$phWeaponBuild .= '{"key":138 ,"value":'.(($_SESSION['phSlayerBonus']/100)+1).'},';		// Slayer weapon bonus 
		}
		
		
		$phWeaponBuild .= '{"key":21 ,"value":1}';													// WEAPON_LENGTH_FLOAT absolutley no clue what this does.
		
		//$phWeaponBuild .= '{"key":147 ,"value":1}';												// CRITICAL_FREQUENCY_FLOAT	 bitting strike
		
		
	
$phWeaponBuild .=	//build integer stats
	'],'.
	'"intStats":[';
	
	
		$phImbued=$_SESSION['phTinkCritStrike']  										// Calculate 'phImbued' value 
			+ $_SESSION['phTinkCripBlow']  
			+ $_SESSION['phTinkArmorRend']  
			+ $_SESSION['phTinkSlash'] 
			+ $_SESSION['phTinkPierce']  
			+ $_SESSION['phTinkBludg']  
			+ $_SESSION['phTinkAcid']  
			+ $_SESSION['phTinkCold']  
			+ $_SESSION['phTinkLight']  
			+ $_SESSION['phTinkFire']; 
		





		$phWeaponBuild .= '{"key":1 ,"value":'.$_SESSION['phItemType'].'}';				// item type 1=melee 256=missile 32768=caster
		
		$phWeaponBuild .= ',{"key":5 ,"value":'.$_SESSION['phBurden'].'}';
	
		//$phWeaponBuild .= ',{"key":8 ,"value":500}'; 								 	//	MASS_INT per Pea 7/31/17 PhatAc does not use this setting, go ahead and ignore it
		
		$phWeaponBuild .= ',{"key":9 ,"value":'.$_SESSION['phLocationInt'].'}';			// 4194304 = missile 1048576=melee 16777216=caster
		
		$phWeaponBuild .= ',{"key":16 ,"value":1}';
		
		$phWeaponBuild .= ',{"key":19 ,"value":'.$_SESSION['phValue'].'}';
		
		if ($_SESSION['phBonded']) {
			$phWeaponBuild .= ',{"key":33 ,"value":'.$_SESSION['phBonded'].'}';
		}
		
		
		if ($_SESSION['phMaxDamage']) {
			$phWeaponBuild .= ',{"key":44 ,"value":'.$_SESSION['phMaxDamage'].'}';
		}
		
		$phWeaponBuild .= ',{"key":45 ,"value":'.$_SESSION['phDamageType'].'}';
		
		
			if ($_SESSION['phWeaponType']==8) {
				$_SESSION['phCombatStyle']=16;
			}
			if ($_SESSION['phWeaponType']==9) {
				$_SESSION['phCombatStyle']=32;
			}
			if ($_SESSION['phWeenieType']==35) {
				$_SESSION['phCombatStyle']=512;
			}
			if ($_SESSION['phWeaponType'] > 0 AND $_SESSION['phWeaponType'] < 8) {
				$_SESSION['phCombatStyle']=2;
			}
			
		
		$phWeaponBuild .= ',{"key":46 ,"value":'.$_SESSION['phCombatStyle'].'}';		// DEFAULT_COMBAT_STYLE  **16=bow 32=crossbow 512=magic 2=melee
		
		
		if ($_SESSION['phWeenieType']==6) {	// check if weapon is melee
			$phWeaponBuild .= ',{"key":47 ,"value":'.$_SESSION['phAttackType'].'}';		// **animation type for attacks. I think this requires two combined values, one for fast attacks and one for slow attacks (ie stab or slash with sword)
		}
		
		
		if ($_SESSION['phSkillType']) {
			$phWeaponBuild .= ',{"key":48 ,"value":'.$_SESSION['phSkillType'].'}';		// weapon's skill type (heavy, finesse, etc) 
		}
		
		if ($_SESSION['phSpeed']) {
			$phWeaponBuild .= ',{"key":49 ,"value":'.$_SESSION['phSpeed'].'}';			// weapon's Speed
		}
		
		if ($_SESSION['phAmmoType']) {
			$phWeaponBuild .= ',{"key":50 ,"value":'.$_SESSION['phAmmoType'].'}';		// ammo type for missile
		}
		
		if ($_SESSION['phCombatUse']) {
			$phWeaponBuild .= ',{"key":51 ,"value":'.$_SESSION['phCombatUse'].'}';		// COMBAT_USE_INT  1=melee 2=missile 3=ammo 4=shield 5=two handed
		}
		
		$phWeaponBuild .= ',{"key":93 ,"value":1044}';									// PHYSICS_STATE_INT. just set it to 1044 and don't ask questions about the physics voodoo
		
		
		
		
		if ($_SESSION['phSpellCraft']) {
			$phWeaponBuild .= ',{"key":106 ,"value":'.$_SESSION['phSpellCraft'].'}';
		}

		if ($_SESSION['phCurrMana']) {
			$phWeaponBuild .= ',{"key":107 ,"value":'.$_SESSION['phCurrMana'].'}';
		}
		
		if ($_SESSION['phMaxMana']) {
			$phWeaponBuild .= ',{"key":108 ,"value":'.$_SESSION['phMaxMana'].'}';
		}

		if ($_SESSION['phArcane']) {
			$phWeaponBuild .= ',{"key":109 ,"value":'.$_SESSION['phArcane'].'}';
		}

		if ($_SESSION['phAttuned']) {
			$phWeaponBuild .= ',{"key":114 ,"value":'.$_SESSION['phAttuned'].'}';
		}
		
		
		if ($_SESSION['phMaterial']) {
			$phWeaponBuild .= ',{"key":131 ,"value":'.$_SESSION['phMaterial'].'}';		// Material Type (pine, oak, diamond, etc) (gameEnums.h->MaterialType)
			$phWeaponBuild .= ',{"key":105 ,"value":'.$_SESSION['phWorkmanship'].'}';	// Item WORKMANSHIP 1 to 10
		}
		
		

		if ($_SESSION['phWieldReq'] != 0) {
			
			$phWeaponBuild .= ',{"key":158 ,"value":'.$_SESSION['phWieldReq'].'}';
			
			if ( $_SESSION['phWieldReq'] > 0 AND $_SESSION['phWieldReq'] < 3 ) {
				$phWeaponBuild .= ',{"key":159 ,"value":'.$_SESSION['phWieldSkill'].'}';
				$phWeaponBuild .= ',{"key":160 ,"value":'.$_SESSION['phWieldValue'].'}';	
			}
			
			if ( $_SESSION['phWieldReq'] > 2 AND $_SESSION['phWieldReq'] < 5 ) {
				$phWeaponBuild .= ',{"key":159 ,"value":'.$_SESSION['phWieldAttribute'].'}';
				$phWeaponBuild .= ',{"key":160 ,"value":'.$_SESSION['phWieldValue'].'}';	
			}
			
			if ( $_SESSION['phWieldReq'] > 4 AND $_SESSION['phWieldReq'] < 7 ) {
				$phWeaponBuild .= ',{"key":159 ,"value":'.$_SESSION['phWieldVital'].'}';
				$phWeaponBuild .= ',{"key":160 ,"value":'.$_SESSION['phWieldValue'].'}';	
			}
			
			if ( $_SESSION['phWieldReq'] == 7 ) {
				$phWeaponBuild .= ',{"key":159 ,"value":0}';
				$phWeaponBuild .= ',{"key":160 ,"value":'.$_SESSION['phWieldValue'].'}';
			}

			if ( $_SESSION['phWieldReq'] == 8 ) {
				$phWeaponBuild .= ',{"key":159 ,"value":'.$_SESSION['phWieldSkill'].'}';
				$phWeaponBuild .= ',{"key":160 ,"value":0}';
			}		
		}
		
		if ($_SESSION['phSlayer'] > 0) { 
			$phWeaponBuild .= ',{"key":166 ,"value":'.$_SESSION['phSlayer'].'}';
		}
		
		if ($_SESSION['phTimesTinkered']) {
			$phWeaponBuild .= ',{"key":171 ,"value":'.$_SESSION['phTimesTinkered'].'}';	// NUMBER OF TIMES TINKED
		}
		
		
		if ($phImbued>0) {
			$phWeaponBuild .= ',{"key":179 ,"value":'.$phImbued.'}';
		}		
		
		$phWeaponBuild .= ',{"key":263 ,"value":4}';
		
		if ($_SESSION['phWeaponType']) {
			$phWeaponBuild .= ',{"key":353 ,"value":'.$_SESSION['phWeaponType'].'}';
		}
		
		
		
$phWeaponBuild .=		//build SPELLBOOK
	'],'.
	'"spellbook":[';		
		
		if ($_SESSION['phSpellBook']) {
			
			$phSpellBook[] = new spellBook;
			
			$phSpellBook = $_SESSION['phSpellBook'];
			
			for ($zCount=0; $zCount < $_SESSION['phSpellCount'];$zCount++) {
				
				if ($zCount > 0) {
					$phWeaponBuild .=',';
				}
		
			
				$phWeaponBuild .= '{"key":'.$phSpellBook[$zCount]->spellId.',"value":{"casting_likelihood":2.0}}';

		
			}
		}
		
		
		
		
		
	

$phWeaponBuild .=		//build string stats
	'],'.
	'"stringStats":[';
	
			$phWeaponBuild .= '{"key":1 ,"value":"'.$_SESSION['phName'].'"}';				// Weapon name as displayed ingame
			
		if ($_SESSION['phDescription']) {
			$phWeaponBuild .= ',{"key":16 ,"value":"'.$_SESSION['phDescription'].'"}';		// Description that is displayed on the bottom of the weapon when id'd ingame
		}
		
		if ($_SESSION['phLastTinker']) {
			$phWeaponBuild .= ',{"key":39 ,"value":"'.$_SESSION['phLastTinker'].'"}';		// "Last Tinked By"
		}
		
		if ($_SESSION['phImbuedBy']) {
			$phWeaponBuild .= ',{"key":40 ,"value":"'.$_SESSION['phImbuedBy'].'"}';			// "Imbued By"
		}

$phWeaponBuild .=
	'],"wcid":'.$_SESSION['wcid'].',"weenieType":'.$_SESSION['phWeenieType'].'}'; 			// add wcid, weenietype and close json data
	


//echo $phWeaponBuild;

$jsonFile='PWB'.date('s').'_'.$_SESSION['wcid'].'.json';


file_put_contents('./json_temp/'.$jsonFile,$phWeaponBuild);

$_SESSION['jsonFile'] = $jsonFile;



header("Location: index.php");



?>
<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="default.css" />
<body id="mainBody">

</body>
</html>


























