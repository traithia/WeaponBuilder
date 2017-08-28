<?PHP
Session_start();


if ($_GET['killsess']=='true') {
	
	
	session_unset();
	session_destroy();
	session_abort();
	
	header("Location: index.php?logout=success");
	die ('wtf');

}

if ($_GET['startnew']=='melee') {

	$themeTMP = $_SESSION['theme'];
	session_unset();
	$_SESSION['theme'] = $themeTMP;
	
	$_SESSION['authorized'] = True;
	$_SESSION['phWeenieType'] = 6;
		
	$_SESSION['phDef_setupDid']="0x20003d5";
	$_SESSION['phDef_iconDid']="0x10DD";
	
	
	header("Location: index.php");
	die ('wtf');
}

if ($_GET['startnew']=='magic') {

	$themeTMP = $_SESSION['theme'];
	session_unset();
	$_SESSION['theme'] = $themeTMP;
	
	$_SESSION['authorized'] = True;
	$_SESSION['phWeenieType'] = 35;
	
	$_SESSION['phDef_setupDid']="0x20012C0";
	$_SESSION['phDef_iconDid']="0x25DE";

	
	header("Location: index.php");
	die ('wtf');
}

if ($_GET['startnew']=='missile') {

	$themeTMP = $_SESSION['theme'];
	session_unset();
	$_SESSION['theme'] = $themeTMP;
	$_SESSION['authorized'] = True;
	$_SESSION['phWeenieType'] = 3;
	
	$_SESSION['phDef_setupDid']="0x20011F3";
	$_SESSION['phDef_iconDid']="0x3603";
	
	
	header("Location: index.php");
	die ('wtf');
}


require ('../pphrase.php');


if ($_POST['passphrase']==fetchPassword()) {
	
		
		$_SESSION['authorized'] = True;
		$_SESSION['theme'] = "classic.css";
		
		
		$_SESSION['phWeenieType'] = 6;
		
		$_SESSION['phDef_setupDid']="0x20003d5";
		$_SESSION['phDef_iconDid']="0x10DD";
		
		
		
		unset ($_SESSION['phSpellCount']);

		
		$logfile = fopen('../pwblog.txt', 'a');
		fwrite($logfile,date(DATE_RFC2822)." Successfull login from ".$_SERVER['REMOTE_ADDR']."\n");
		fclose($logfile);
		
		header("Location: index.php");
		
}

else {
	
	
		$logfile = fopen('../pwblog.txt', 'a');
		fwrite($logfile,date(DATE_RFC2822)." FAILED login from ".$_SERVER['REMOTE_ADDR']." using '".$_POST['passphrase']."'\n");
		fclose($logfile);
	
	
	header("Location: index.php?auth=fail");
	
}



?>