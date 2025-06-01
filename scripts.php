<?php require_once('config.php');

//DECK COMMANDS
$play = "remote: enable: true\r\n play\r\n";					//sends command to play deck
$stop = "remote: enable: true\r\n stop\r\n";					//sends comand to stop deck
$ff = "remote: enable: true\r\n play: speed: ".$ffspeed."\r\n"; 		//sends command to fast forward
$rw = "remote: enable: true\r\n play: speed: ".$rwspeed."\r\n";  		//sends command to rewind
$record = "record\r\n";  								//sends command to record a deck, replaced by record naming per deck
$rem = "remote: enable: true\r\n";  						//sends command to enable deck to be controlled by above functions
$trkbk = "goto: clip id: -1\r\n";  							//sends command to jump to the previous clip
$trkfw = "goto: clip id: +1\r\n"; 							//sends command to jum to the next clip
if($loopKind == "all"){
	$loop = "remote: enable: true\r\n play: loop: true\r\n";
}else{
	$loop = "remote: enable: true\r\n play: loop: true single clip: true\r\n";
}
$slot = "remote: enable: true\r\n slot select: slot id: ". ( isset($_GET['slotid']) ? $_GET['slotid'] : '' ) ."\r\n";
$range = "playrange set: in: ". ( isset($_GET['prin']) ? urldecode($_GET['prin']) : '' ) ." out: ". ( isset($_GET['prout']) ? urldecode($_GET['prout']) : '' ) ."\r\n";
$input = "configuration: video input: ". ( isset($_GET['vidstd']) ? $_GET['vidstd'] : '' ) ."\r\n";
$audio = "configuration: audio input: ". ( isset($_GET['audstd']) ? $_GET['audstd'] : '' ) ."\r\n";
$format = "configuration: file format: ". ( isset($_GET['fmtstd']) ? $_GET['fmtstd'] : '' ) ."\r\n";
$preview = "preview: enable: true\r\n";
$status = "transport info\r\n";
$clip = "stop\r\n goto: clip id: ". ( isset($_GET['clip']) ? $_GET['clip'] : '' ) ."\r\n";
$clipAndPlay = "goto: clip id: ". ( isset($_GET['clip']) ? $_GET['clip'] : '' ) ."\r\n play\r\n";
$clipsCount = "clips count\r\n";
$clipsList = "clips get\r\n";
$blink = "identify: enable: true\r\n";
$blinkOff = "identify: enable: false\r\n";
$uptime = "uptime\r\n";
$posOn = "play on startup: enable: true\r\n";
$posOff = "play on startup: enable: false\r\n";

$tcall = "00:00:00:00";

//USER FILE NAMING - fn=file name
	//$fnUser called in config.php
		//get values from post and update cookies or set default
	if(isset($_GET['reel'])){
		setcookie("reel",$_GET['reel'],time() + (86400 * 7));
		$reel = $_GET['reel'];
	}elseif(isset($_COOKIE["reel"])){
		$reel = $_COOKIE["reel"];
	}else{
		$reel = "001";
		setcookie("reel", "001",time() + (86400 * 7));
	}
	if(isset($_GET['take'])){
		setcookie("take",$_GET['take'],time() + (86400 * 7));
		$take = $_GET['take'];
	}elseif(isset($_COOKIE["take"])){
		$take = $_COOKIE["take"];
	}else{
		$take = "001";
		setcookie("take", "001",time() + (86400 * 7));
	}
	if(isset($_GET['scene'])){
		setcookie("scene",$_GET['scene'],time() + (86400 * 7));
		$scene = $_GET['scene'];
	}elseif(isset($_COOKIE["scene"])){
		$scene = $_COOKIE["scene"];
	}else{
		$scene = "001";
		setcookie("scene", "001",time() + (86400 * 7));
	}
	if(isset($_GET['customfn'])){
		setcookie("customfn",$_GET['customfn'],time() + (86400 * 7));
		$customFn = $_GET['customfn'];
	}elseif(isset($_COOKIE["customfn"])){
		$customFn = $_COOKIE["customfn"];
	}else{
		$customFn = "";
		setcookie("customfn", "",time() + (86400 * 7));
	}

//DECK GLOBALS
	foreach($config as $hd => $deck){
		if( $hd !== 'global' ){
			if($deck['enable'] == "true"){
				${"hd".$deck['number']} = @fsockopen("tcp://".$deck['ip'], 9993, $errno, $errstr, 2); //Establish Connection
				if(isset($_COOKIE["deck".$deck['number']."sync"])){
					
				}else{
					if ( ! headers_sent() ) { setcookie("deck".$deck['number']."sync", "false",time() + (86400 * 7)); }
				}
					//Set up the file naming string   
					$fnKey = array("%deckname","%month","%day","%year","%hour","%min","%sec","%reel","%take","%scene","%custom"," ");
					$fnReplace = array($deck['name'],date('m'),date('d'),date('Y'),date('H'),date('i'),date('s'),"R".$reel,"T".$take,"S".$scene,$customFn,"");
					$fnStructure = str_replace($fnKey, $fnReplace, $fnUser);
					//Make sure all spaces are stripped
					$fnOutput = str_replace(" ","",$fnStructure);
				${"recDeck".$deck['number']} = "remote: enable: true\r\n record: name: ".$fnOutput."_\r\n"; //Set Record Filename
				if( isset( $_GET['deck'] ) && $_GET['deck'] == $deck['number']){
					$go = ${"hd".$deck['number']};
				}
				//Specific Deck Commands
					//Related to clipbin & devinfo
					if( isset( $_GET['deck'] ) && $_GET['deck'] == $deck['number']){
						$currentDeck = $deck['name'];
						$currentIp = $deck['ip'];
						$bin = ${"hd".$deck['number']};
						if($deck['model'] == "mini"){
							$value = 38;
							$value2 = 1;
							$value3 = 7;
						}else{
							$value = 45;
							$value2 = 0;
							$value3 = 10;
						}
						$dname = $deck['name'];
					}
					//Timer related
					if( isset( $_GET['timeDeck'] ) && $_GET['timeDeck'] == $deck['number']){
						$name = $deck['name'];
					}else{
						$name = "Sync";
					}
					//Sync related
						//Timecode
						$tcjall = "goto: timecode: ". ( isset( $_POST["timecodeall"] ) ? $_POST["timecodeall"] : '' ) ."\r\n";
						if(isset($_POST["timecodeall"])){
							$tcall = "Timecode Set!";
						}else{
							$tcall = "00:00:00:00";
						}
						//Track Back
						if(@$_GET['cmd'] == "trkbkall"){
							if($_COOKIE["deck".$deck['number']."sync"] == "true"){
								if ( gettype( ${"hd".$deck['number']} ) == 'resource' ) { fwrite(${"hd".$deck['number']}, $trkbk); }
							}
						}
						//Track Forward
						if(@$_GET['cmd'] == "trkfwall"){
							if($_COOKIE["deck".$deck['number']."sync"] == "true"){
								if ( gettype( ${"hd".$deck['number']} ) == 'resource' ) { fwrite(${"hd".$deck['number']}, $trkfw); }
							}
						}
						//Record
						if(@$_GET['cmd'] == "recall"){
							if($_COOKIE["deck".$deck['number']."sync"] == "true"){
								if ( gettype( ${"hd".$deck['number']} ) == 'resource' ) { fwrite(${"hd".$deck['number']}, ${"recDeck".$deck['number']}); }
							}
						}
						//Play
						if(@$_GET['cmd'] == "playall"){
							if($_COOKIE["deck".$deck['number']."sync"] == "true"){
								if ( gettype( ${"hd".$deck['number']} ) == 'resource' ) { fwrite(${"hd".$deck['number']}, $play); }
							}
						}
						//Fast Forward
						if(@$_GET['cmd'] == "ffall"){
							if($_COOKIE["deck".$deck['number']."sync"] == "true"){
								if ( gettype( ${"hd".$deck['number']} ) == 'resource' ) { fwrite(${"hd".$deck['number']}, $ff); }
							}
						}
						//Rewind
						if(@$_GET['cmd'] == "rwall"){
							if($_COOKIE["deck".$deck['number']."sync"] == "true"){
								if ( gettype( ${"hd".$deck['number']} ) == 'resource' ) { fwrite(${"hd".$deck['number']}, $rw); }
							}
						}
						//Stop
						if(@$_GET['cmd'] == "stopall"){
							if($_COOKIE["deck".$deck['number']."sync"] == "true"){
								if ( gettype( ${"hd".$deck['number']} ) == 'resource' ) { fwrite(${"hd".$deck['number']}, $stop); }
							}
						}
						//Timecode Jump
						if(@$_GET['cmd'] == "tcjall"){
							if($_COOKIE["deck".$deck['number']."sync"] == "true"){
								if ( gettype( ${"hd".$deck['number']} ) == 'resource' ) { fwrite(${"hd".$deck['number']}, $tcjall); }
								${"deck".$deck['number']."tc"} = "Timecode Set!";
							}
						}
						//Play With Loop
						if(@$_GET['cmd'] == "loopall"){
							if($_COOKIE["deck".$deck['number']."sync"] == "true"){
								if ( gettype( ${"hd".$deck['number']} ) == 'resource' ) { fwrite(${"hd".$deck['number']}, $loop); }
							}
						}
						//Decktimecode
						${"deck".$deck['number']."tcj"} = "goto: timecode: ". ( isset( $_POST["timecode".$deck['number']] ) ? $_POST["timecode".$deck['number']] : '' ) ."\r\n";
						if(isset($_POST["timecode".$deck['number']])){
							${"deck".$deck['number']."tc"} = "Timecode Set!";
						}else{
							${"deck".$deck['number']."tc"} = "00:00:00:00";
						}
						if( isset( $_GET['deck'] ) && $_GET['deck'] == $deck['number'] && @$_GET['cmd'] == "syncfalse") {
							setcookie("deck".$deck['number']."sync", "false",time() + (86400 * 7));
						}elseif( isset( $_GET['deck'] ) && $_GET['deck'] == $deck['number'] && @$_GET['cmd'] == "synctrue") {
							setcookie("deck".$deck['number']."sync", "true",time() + (86400 * 7));
						}
						if(@$_GET['cmd'] == "tcj" && $_GET['deck'] == $deck['number']) {
							if ( gettype( $go ) == 'resource' ) { fwrite($go,${"deck".$deck['number']."tcj"}); }
						}elseif(@$_GET['cmd'] == "rec" && $_GET['deck'] == $deck['number']) {
							if ( gettype( $go ) == 'resource' ) { fwrite($go, ${"recDeck".$deck['number']}); }
						}
			}
	
		}
	}


//COMMAND GLOBALS
if ( isset( $_GET['cmd'] ) && isset( $go ) && gettype( $go ) == 'resource' ) { 
	if(@$_GET['cmd'] == "trkbk") {
		fwrite($go, $trkbk);
	}elseif(@$_GET['cmd'] == "rw") {
		fwrite($go, $rw);
	}elseif(@$_GET['cmd'] == "play") {
		fwrite($go, $play);
	}elseif(@$_GET['cmd'] == "ff") {
		fwrite($go, $ff);
	}elseif(@$_GET['cmd'] == "trkfw") {
		fwrite($go, $trkfw);
	}elseif(@$_GET['cmd'] == "stop") {
		fwrite($go, $stop);
	}elseif(@$_GET['cmd'] == "rem") {
		fwrite($go, $rem);
	}elseif(@$_GET['cmd'] == "slot") {
		fwrite($go, $slot);
	}elseif(@$_GET['cmd'] == "loop") {
		fwrite($go,$loop);
	}elseif(@$_GET['cmd'] == "range") {
		fwrite($go,$range);
	}elseif(@$_GET['cmd'] == "vidstd" && $_GET['vidstd'] == "preview") {
		fwrite($go,$preview);
	}elseif(@$_GET['cmd'] == "vidstd") {
		fwrite($go,$input);
	}elseif(@$_GET['cmd'] == "audstd") {
		fwrite($go,$audio);
	}elseif(@$_GET['cmd'] == "fmtstd") {
		fwrite($go,$format);
	}elseif(@$_GET['cmd'] == "startup" && $_GET['startupstate'] == "true") {
		fwrite($go,$posOn);
	}elseif(@$_GET['cmd'] == "startup" && $_GET['startupstate'] == "false") {
		fwrite($go,$posOff);
	}elseif(@$_GET['cmd'] == "id") {
		fwrite($go,$blink);
		sleep(5);
		fwrite($go,$blinkOff);
	}elseif(@$_GET['cmd'] == "gtc") {
		fwrite($go,$clip);
	}elseif(@$_GET['cmd'] == "gtcp") {
		fwrite($go,$clipAndPlay);
	}elseif(@$_GET['cmd'] == "cptrue") {
		setcookie("clipandplay", "true");
	}elseif(@$_GET['cmd'] == "cpfalse") {
		setcookie("clipandplay", "false");
	}
}

//SSD Formatting
	if( isset( $_GET['cmd'] ) && $_GET['cmd'] == 'format' && isset( $go ) && gettype( $go ) == 'resource' ){
		$fmt = $_GET['formatType'];
		$prepToken = "format: prepare: ".$fmt."\r\n";
		$key = "ready";
		$getToken = '';
		$result = '';
		fwrite($go, $prepToken);
		for ($x=0; $x<=5;){
			$getToken .= fgets($go);
				//echo $getToken."<br>";
			$x++;
			if ($x>=6){
				$findToken = strpos($getToken, $key);
				$tokenValue = substr($getToken, $findToken+8); 
			}
		}
		$token = $tokenValue;
		$sucesss = "200";
			//echo $token;
		$confirm = 	"format: confirm: ".$token."\r\n";
			//echo $confirm;
		fwrite($go, $confirm);
		for ($x=0; $x<=1;){
			$result .= fgets($go);
				//echo $result."<br>";
			$x++;
		}
		if($x>=1){
			//echo substr($result, 2,3);
			if(substr($result, 2,3) == "200"){
				$complete = "completed";
			}else{
				$complete = "failed";
			}
		}
	}

//Version information
	$installed_version = '4.1.0';
?>