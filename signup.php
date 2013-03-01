<? if ($register_token === NULL) { die("Permission denied!"); } /* Disable Direct Access */
$authToken = md5($register_token.$clientMAC.$clientIP);   /* Generate Auth token */ ?>
<div class="block">
    <form name="form" action="<?=$register_url?>" method="post">
    <input name="mac" type="hidden" value="<?=$clientMAC?>">
    <input name="ip" type="hidden" value="<?=$clientIP?>">
    <input name="token" type="hidden" value="<?=$authToken?>">
    <div class="left"></div>
    <div class="right">
        <div class="div-row">
            <input type="text" id="username" name="username"  onfocus="this.value='';" onblur="if (this.value=='') {this.value='Username';}" value="Username" />
        </div>
        <div class="div-row">
            <input type="text" id="username" name="email"  onfocus="this.value='';" onblur="if (this.value=='') {this.value='Email';}" value="Email" />
        </div>
        <div class="rm-row">
            <input type="checkbox" value="c" name="rm" id="remember"/> <label for="remember">I Agree to the TOS</label>
        </div>
        <div class="send-row">
            <button id="signup" value="" type="button" name="signup" onclick="checkthebox()"></button>
        </div><br/>
    </div>
    <div style="height:290px;width:90%;overflow:auto;position: absolute;top: 180px;left: 15px">
        <h1>Free Public Internet</h1><br/>
        Enter your desired username above and a valid email address, you will be emailed your login credentials instantly.<br/><br/>
        <h3>Benifits</h2>
        <ul>
            <li>Free &amp; Signup</li>
            <li>Access to Secure Public Wifi Network</li>
            <li>Online 24/7/365</li>
            <li>No Client Restrictions</li>
            <li>Dynamic Port Forwarding (uPnP)</li>
            <li>1.5MB/s Download - 150KB/s Upload</li>
        </ul>
    </div>
</div>