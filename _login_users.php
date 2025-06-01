<?php

//Secure PHP login withou Database by Jerry Low @crankberryblog.com
//Find other useful scripts at the Crankberry Blog

//Installation Guide At: 
//http://www.crankberryblog.com/2009/secure-php-login-without-database


//Users and Settings
$domain_code = 'website';	//Alpha Numeric and no space
$random_num_1 = 20;		//Pick a random number between 1 to 500
$random_num_2 = 565;		//Pick a random number between 500 to 1000
$random_num_3 = 3;			//Pick a random number between 1 to 3

//Usernames can contain alphabets, numbers, hyphens and underscore only
//Set users below - Just add '' => '' with the first '' being
//the username and the second '' after the => being the password.
//Its an array so add an , after every password except for the
//last one in the list. As shown below
//Eg. $users = array(
//		'user1' => 'password',
//		'user2' => 'password'
//	);
//
//Users will stay logged in for 24hours before their session expires
//unless they logout by clicking the logout button
$users = array(
		'admin' => '1234',
		'user' => '4321'
	);

?>