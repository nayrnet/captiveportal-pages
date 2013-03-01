<?
// Captive Portal Pages
// By: Ryan Hunt <admin@nayr.net>
// License: CC-BY-SA
// Description: Captive Portal Login and Signup Pages for Free Public WiFi and Secure Public WiFi
// Requires: pfSense 2.x, Working Radius Server w/mySQL Backend & PHP (I am running externally),
//      Guest user account with Password attribute instead of Cleartext Password.. this wont allow it access to 802.11x
//      WiFi AP Capable of VLAN Tagging SSID's
// Goals: To allow easy access to an encrypted public wifi, running on a seperate VLAN and using Radius Authentication

// Configuration Variables
$guest_username = "guest";
$guest_password = "VOnwCg8VdlSsqaP7quMW";
$main_url = "https://wifi.nayr.net:8001/";
$register_url = "https://admin.nayr.net/wifi-register.php";
$register_token = "BQhokuYh0xlCRAzQKtvD";
ini_set('display_errors', 0);   // Disable Debug Messages

// Fetch IP & MAC Address of Client
$clientIP=$_SERVER['REMOTE_ADDR'];
$clientMAC = `/usr/sbin/arp -an | grep {$clientIP} | cut -d" " -f4`;
$clientMAC = str_replace("\n","",$clientMAC);

if(isset($_GET['page'])) {      // Fetch Page Name
    $page = $_GET['page'];
} else {
    $page = "login";            // Set Default Page if none set
}

$content = "/var/db/cpelements/captiveportal-".$page.".php";  // Filename of Page Contents
if (file_exists($content)) {                    // Check for page
    $last_modified = date("M d Y",filemtime($content));
} else {
    $page='login';
    $content = "captiveportal-login.php" ;
}

// Begin HTML
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>wifi.nayr.net | <?=$page?></title>
<meta name="description" content="Free Public WiFi Portal page" />
<link rel="stylesheet" type="text/css" href="captiveportal-style.css" title="style" media="screen" />
<script type="text/javascript">
/* <![CDATA[ */
	$(document).ready(function(){
			$(".block").fadeIn(1000);				   
			$(".idea").fadeIn(1000);
			$('.idea').supersleight();
			$('#username').example('<?=$guest_username?>');
            $('#password').example('<?=$guest_password?>');
	});
/* ]]> */
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function checkthebox()
{
    if (document.form.rm.checked == true)
    {
        document.form.submit();
    }
    else
    {
        alert('You Forgot to agree to the Terms of Service.\nPlease read them carefully and try again.');
    }
}
-->
</script>
<body>
    <div id="wrap">
        <div align="center" class="top">
            <a href="/">[login]</a> - <a href="/&page=about">[about]</a> - <a href="/&page=signup">[signup]</a> -
            <a href="/&page=tos">[tos]</a> - <a href="mailto:admin@nayr.net">[contact]</a><br/>
            <a href="/"><img src="captiveportal-wifi.png"></a>
        </div>
            <?php include($content); /* Load Page Contents */ ?>
    </div>
</body>
<!-- This page was Last Modified: <?=$last_modified?> -->
</html>
