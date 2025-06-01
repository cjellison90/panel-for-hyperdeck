<?php

require('_login_users.php');

setcookie($domain_code.'_uid', '');
setcookie($domain_code.'_cid', '');

header("LOCATION: login.php");

?>