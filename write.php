<?php require('config.php');

$store = array();

for ($x=1; $x<=$_POST['totalDecks']; $x++){
	if( ! isset( $_POST["deck".$x."enable"] ) ){$enable = "false";}else{$enable = $_POST["deck".$x."enable"];}
	if( ! isset( $_POST["deck".$x."name"] ) ){$name = "New Deck ".$x;}else{$name = $_POST["deck".$x."name"];}
	if( ! isset( $_POST["deck".$x."ip"] ) ){$ip = "0.0.0.0";}else{$ip = $_POST["deck".$x."ip"];}
	if( ! isset( $_POST["deck".$x."model"] ) ){$model = "mini";}else{$model = $_POST["deck".$x."model"];}
	$store[] = array(
		"number" => $x,
		"enable" => $enable, 
		"name" => $name, 
		"ip" => $ip,
		"model" => $model,
	);
}
$store['global'] = array(  
	'enableLogin' => $_POST['enableLogin'],
	'ffspeed' => $_POST['ffspeed'],
	'rwspeed' => $_POST['rwspeed'],
	'looping' => $_POST['looping'],
	'avatarEnable' => $_POST['avatarEnable'],
	'avatarUrl' => $_POST['avatarUrl'],
	//'dispClip'	=> $_POST['dispClip'],
	//'scroll' => $_POST['scroll'],
	'timezone' => $_POST['timezone'],
	'timerInterval' => $_POST['timerInterval'],
	'totalDecks' => $_POST['totalDecks'],
	'fnUser' => $_POST['fnUser'],
);

// Write data to file         
$fp = fopen('config.txt','w'); 
fwrite($fp,serialize($store));
header('Location: settings.php');
?>