<?php
include('./inc/config.php');
include('./inc/functions.php');
include('./lang/'.$language.'.lng');


$page = addslashes($_REQUEST["page"]);
$user = mysql_real_escape_string(addslashes($_REQUEST["username"]));
$pass = mysql_real_escape_string(addslashes($_REQUEST["uword"]));

$language = strtolower($language);
if(empty($page)) $page="login";
$file = $page;
if(!empty($user) AND !empty($pass))
{$query = mysql_query('SELECT * FROM accounts WHERE name="'.$user.'" AND Uwort="'.$pass.'" LIMIT 1');
if(mysql_num_rows($query) == 1)
{
$_SESSION["user"] = ucfirst($user);
echo'<meta http-equiv="refresh" content="0; url=index.php?page=home">';
$ip = getenv ("REMOTE_ADDR");
$timestamp = time();
$ipupdate = mysql_query('INSERT INTO cplogin_log SET user="'.$user.'",ip ="'.$ip.'",date="'.date("d-m-Y H:i:s",$timestamp).'"');
}
else $error = '<center>Username oder Passwort ist falsch.<br> Bei 5 Mal Falsch Eingeben von Passwort wird die IP Gebannt!<br><a href="http://server.dsz-rl.org/ucp/index.php?page=Passwort-Vergessen-Funktion">Passwort-Vergessen-Funktion > Hier Klicken <</a> </center>';}

$query2 = mysql_query('SELECT * FROM accounts WHERE name="'.$_SESSION["user"].'"');
while($userinfos = mysql_fetch_array($query2))
{
$passwort = $userinfos["passwort"];
$adminrang = $userinfos["AdminLevel"];
$bankgeld = $userinfos["BankGeld"];
$eingeloggt = $userinfos["Adjustable"];
$premium = $userinfos["DonatorRank"];
$level = $userinfos["Level"];
$ffrak = $userinfos["Leader"];
$fmem = $userinfos["Member"];
$frank = $userinfos["Rang"];
$suprang = $userinfos["Supporter"];
$onlinesf = $userinfos["Scripter"];
$sronline = $userinfos["Adjustable"];
$sronline = $TimeOnline["Verbrechen"];
}


$online3 = "SELECT * from accounts WHERE `Adjustable` = '1' AND name='".$_SESSION["user"]."'"; 
$online2 = mysql_query($online3); 
$online = mysql_num_rows($online2); 


include('./designe/'.$designe.'/head.php');
include('./designe/'.$designe.'/navi.php');
include('./designe/'.$designe.'/middle.tpl');

	if(file_exists('./pages/'.$file.'.php'))
	{
	include('./pages/'.$file.'.php');}
	if(!empty($error)) echo '<font color="red">'.$error.'</font>'; 
	
include('./designe/'.$designe.'/foot.tpl');	
?>
