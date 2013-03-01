<?php
// Captive Portal Pages
// By: Ryan Hunt <admin@nayr.net>
// License: CC-BY-SA
// Description: Remote Signup Proccessing
    
$portal_url = "https://wifi.nayr.net:8001/";                        // URL To Captive Portal
$register_token = "BQhokuYh0xlCRAzQKtvD";                           // This must match the portal side.
ini_set('display_errors', 0);   // Disable Debug Messages


$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING); // Username
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);        // Email
$ip = filter_var($_POST['ip'], FILTER_SANITIZE_STRING);             // Client IP
$mac = filter_var($_POST['mac'], FILTER_SANITIZE_STRING);           // Client MAC
$token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);       // Signup Token

$authToken = md5($register_token.$mac.$ip);                         // Validate Authtoken
if ($authToken != $token) { header("Location: ".$portal_url); die(); }

$password = strstr($email, '@', true) . rand(10,9999);              // Generate Password
$con=mysql_connect("localhost","radius","changeme");        	    // mySQL DB Connection
mysql_select_db('radius', $con);

// Email Sent upon Account Creation to User
$message = 'Your account @ wifi.nayr.net has been created.
 1. Disconnect from the Free Public WiFi network.
 2. Look for the Secure Public WiFi network and connect.
 3. Enter the Username/Password provided below and save password.
 4. Enjoy Faster Speeds, More Features and No Portal or Time Limits!

 - username: '.$username.'
 - password: '.$password.'

 If your client does not support the Secure WiFi standard
 use the above login on the portal page for faster internet.

Thank you,
-Ryan';

// Email Sent to admin
$admin_message = 'New account has been created:
    - email:    '.$email.'
    - username: '.$username.'
    - password: '.$password.'
    - mac:      '.$mac.'
    - ip:       '.$ip.'
    - date:     '.date("F j, Y, g:i a");
    
// Check username out
if (strlen($username) < 4) { die("Username too short - 4 Min, go back and try again"); }
if (strlen($username) > 20) { die("Username too long - 20 Max, go back and try again"); }
$checkquery = sprintf("SELECT * FROM radcheck WHERE username='%s' LIMIT 1", $username);
$result = mysql_query($checkquery);
if(mysql_result($result,0) != "") { die("User already exists, go back and try again."); }

// Check Email Address out
if ( filter_var($email, FILTER_VALIDATE_EMAIL)  == FALSE) {
        die("Invalid Email Address, go back and try again.");
} else {
        // Send Email
        include('SMTPconfig.php');  // Edit this for your SMTP Login Information
        include('SMTPclass.php');

        $SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, "admin+wifi@nayr.net", $email, "[wifi.nayr.net] Your Login Info", $message);
        $SMTPChat = $SMTPMail->SendMail();
        $SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, "admin+wifi@nayr.net", "admin@nayr.net", "[wifi.nayr.net] new user $username", $admin_message);
        $SMTPChat = $SMTPMail->SendMail();
}
// Add user to Database and send em back to portal page
    mysql_query("INSERT INTO radcheck (username, attribute, op, value) VALUES ('$username', 'Cleartext-Password',':=','$password')");
    mysql_close($con);
    header("Location: ".$portal_url."&page=success");   // Back to Success Page
?>
