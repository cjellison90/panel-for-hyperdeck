<?php

if ( empty( $_FILES['importfile']['tmp_name'] ) ) {
	die( 'No import file' );
}

//open the config file to rewrite
$fp = fopen('config.txt','w');
//write contents of uploaded file to config.txt
fwrite($fp,file_get_contents($_FILES['importfile']['tmp_name']));
//redirect back to settings when done, should reflect changes
header('Location: settings.php');
?>