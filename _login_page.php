<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, user-scalable=0">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
            <link rel="apple-touch-icon" href="images/hdcpIcon.png">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>HyperDeck Control Panel</title>
<link rel="stylesheet" type="text/css" href="css/default.css" media="screen" />
<link rel="icon" type="image/png" href="images/hdcpIcon.png">
</head>

<body>
<form action="" method="post">
<div class="login_box">
    
    <h2>HyperDeck Control Panel</h2><br>
    
    <span class="login_text">Username</span><br />
    <input name="username" type="text" class="login_input<?php if($showerror == "yes"){print " errorborder";} ?>" /><br />
    <span class="login_text">Password</span><br />
    <input name="password" type="password" class="login_input<?php if($showerror == "yes"){print " errorborder";} ?>" /><br /><br />
	<div align="right"><input class="submit" name="login" type="submit" value="Login" /></div>
        
         <?php $login->error_login(); ?>
</div>
</form>
</body>
</html>