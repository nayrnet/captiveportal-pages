What is this?
 - This is my captive portal implementation for free internet, users can sign in as a guest user within certain times of the day or they can register an account to get on a WPA-EAP vlan that bypasses portal entirely.
 - Registration is very simple, users provide email and desired username. We only check to see if the user already exists, if not we generate a password for the user thats easy to remember and email it to them and the WiFi Admin. 

 - While not horribly robust this would make a fine framework to start off on a specific user signup needs.

 - It uses a very simple template, new pages can be added by creating a new pagename.php file and uploading it.

Requires: pfSense 2.x, Working Radius Server w/mySQL Backend & PHP (I am running externally),
 - Guest user account with Password attribute instead of Cleartext Password.. this wont allow it access to 802.11x
 - WiFi AP Capable of VLAN Tagging SSID's

Very Dirty Instructions below, just read the code its well documented.

pfSense Install Instructions:
 - Upload all .php, .png and style.css through the pfSense Captive Portal GUI
 - Edit portal.php to your liking and upload it as the main portal page
 - Upload autherror.html as your authentication error page
 - Allow passthrough access to registration server.

Remote LAMP Server w/Radius:
 - Configure SSL if Needed
 - Upload contents of register folder somewhere WiFi users can access
 - Edit wifi-register.php to include mysql login info and smtp server info

by: Ryan Hunt
license: CC-BY-SA
