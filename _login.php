<?php

//Secure PHP login without Database by Jerry Low @crankberryblog.com
//Find other useful scripts at the Crankberry Blog

//Installation Guide At: 
//http://www.crankberryblog.com/2009/secure-php-login-without-database


//Start Class
require('_login_users.php');
require('_login_class.php');
require('config.php');

$login = new login_class;

$today_ts = strtotime("now");
$today_m = date('n', $today_ts);
$pass_login = FALSE;

$login->domain_code = $domain_code;
$login->today_ts = $today_ts;
$login->today_m = $today_m;
$login->users = $users;
$login->num_1 = $random_num_1;
$login->num_2 = $random_num_2;
$login->num_3 = $random_num_3;

//Verify
if (!$login->verify_settings()) {
	echo '<strong>Invalid Admin Settings for Login Script</strong><br />Check your settings and retry logging in';
	exit();
}
							 
//Logged In
if (isset($_COOKIE[$domain_code.'_uid']) && $_COOKIE[$domain_code.'_uid']!='' && isset($_COOKIE[$domain_code.'_cid']) && $_COOKIE[$domain_code.'_cid']!='') {
	$key_uid = $login->cleanse_input($_COOKIE[$domain_code.'_uid']);
	$key_cid = $login->cleanse_input($_COOKIE[$domain_code.'_cid']);
	
	if (!$login->verify_login($key_uid, $key_cid)) {
		$login->error_message = 'Login has expired';
	} else {
		$pass_login = TRUE;	
	}
}

//Verify Logged In Credentials
if (!$pass_login) {
	$need_login = TRUE;
	
	//Trying To Login
	if (isset($_POST['login'])) {
		//Verify Login
		$login_user = $login->cleanse_input($_POST['username']);
		$login_pass = $login->cleanse_input($_POST['password']);
		
		//Check Login
		if ($login->check_login($login_user, $login_pass)) {
			//Encode
			$login->encryption_key($login_user);
			
			$need_login = FALSE;
		} else {
			$login->error_message = 'Invalid username or password';
			$showerror = "yes";
			$need_login = TRUE;
		}
	} 
	
	//Login Page
	if ($need_login) {
		require('_login_page.php');
		exit();
	}
}




?>