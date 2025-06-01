<?php require('scripts.php'); if($enable_login == "true"){require('_login.php');}else{}
if(isset($_GET['rfr'])){$refresh = $_GET['rfr'];}else{$refresh = "60";}header("Refresh:$refresh");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="viewport" content="width=1200, user-scalable=0">
		<meta name="apple-mobile-web-app-status-bar-style" content="default">
		<link rel="apple-touch-icon" href="images/hdcpIcon.png">
		<title>HyperDeck Device Info</title>
		<link rel="stylesheet" type="text/css" href="css/default.css" media="screen" />
		<link rel="icon" type="image/png" href="images/hdcpIcon.png">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	</head>
	<body>
		<div class="hdcpInterface">
		<!--START HEADER -->
			<div class="hdcpHeader">
				<a href="" onclick="location.reload();">
					<?php if($enable_avatar == "true"){ echo '<img class="avatar left" src="'.$avatar.'">';} ?>
					<div class="left large" style="overflow:hidden; width:500px;height:52px;">
						<span class="bold large">HyperDeck </span><?php  echo (isset($dname)&&!empty($dname)) ? $dname : ''; ?> Info
					</div>
				</a>
				<?php
				//check for admin usage, if true show logout option
				if($enable_login == "true"){
					echo '<div class="right logout"><a href="logout.php">';
					if(strlen($login->username) <= "8"){
						echo $login->username;
					}else{
						echo substr_replace($login->username, "...", 7);
					}
					echo ' &rarr; Logout</a></div>';
					}
				?>
				<div class="right">
					<?php include_once('nav.php'); ?>
				</div>
				<?php
					if ( ! isset( $_GET['deck'] ) || empty( $_GET['deck'] ) ) {
						die('No deck ID set.');
					}
				?>
				<form method="get" action="?">
					<div class="right logout refresh" style="margin-right: 20px;">
						<input type="hidden" name="deck" value="<?php echo $_GET['deck']; ?>">Refresh
						<input name="rfr" type="text" value="<?php echo $refresh; ?>" size="4">
						<input type="submit" value="set">
					</div>
				</form>
			</div>
			<!--END HEADER-->
			<!--BIN GUI-->  
			<div class="hdcpDeckBorderlt">
				<div class="devinfo">
					<div class="termhdr">
						.../telnet/<?php echo $currentIp; ?>/<?php echo $currentDeck; ?>/raw
					</div>
					<div class="termcont">
						<ul>
						<?php
							if(!isset($_GET['deck'])){
								echo "<li></li><li>Error: Could not load - missing deck variable in url string</li><li></li>";
							}elseif ( gettype( $bin ) == 'resource' ) { 
								fwrite($bin, "uptime\r\n configuration\r\n clips count\r\n transport info\r\n slot info: slot id: 1\r\n slot info: slot id: 2\r\n");
								for ($x=0; $x<=$value;){ // (42 value for studio/pro/12g)(35 value for mini)
									$diskCheck = fgets($bin);
									$x++;
									if($x>3){
										echo "<li>".$diskCheck."</li>";
									}
								}
							} else {
								echo "<li>Could not connect to deck.</li>";
							}
						?>
					<li></li>
						</ul>
					</div>
				</div>
				<div class="devstat">
					<?php
					//show the deck remaining time
					if ( gettype( $bin ) == 'resource' ) {
						$clipKey = "recording time:";
						fwrite($bin, "slot info: slot id: 1\r\n");
						for ($x=0; $x<=4+$value2;){
							$diskCheck = fgets($bin);
							$x++;
							if ($x>=5+$value2){
								$sl1pos = strpos($diskCheck, $clipKey);
								$slot1rem = substr($diskCheck, $sl1pos+16); 
							}
						}
						$warncolor = preg_replace('/\s+/', '', $slot1rem);
						if($warncolor >= "600"){
							$warning = "#45D40C";
						}elseif($warncolor < "600" && $warncolor > "300"){
							$warning = "yellow";
						}else{
							$warning = "red";
						}
						echo "<span style='font-size:30px;'>Slot 1 Remaining <span style='font-size:30px;color:".$warning."'>".gmdate("H:i:s", intval($slot1rem) )."</span></span><br>";
						//SLOT TWO
						fwrite($bin, "slot info: slot id: 2\r\n");
						for ($x=0; $x<$value3;){
							$diskCheck = fgets($bin);
							$x++;
							if ($x>=7){
								$sl2pos = strpos($diskCheck, $clipKey);
								$slot2rem = substr($diskCheck, $sl2pos+16);
							}
						}
						$warncolor2 = preg_replace('/\s+/', '', $slot2rem);
							if($warncolor2 >= "600"){
								$warning = "#45D40C";
							}elseif($warncolor2 < "600" && $warncolor2 > "300"){
								$warning = "yellow";
							}else{
								$warning = "red";
							}
						echo "<span style='font-size:30px;'>Slot 2 Remaining <span style='font-size:30px;color:".$warning."'>".gmdate("H:i:s", intval($slot2rem) )."</span></span><br>";
					} else {
						echo 'Could not connect to deck.';
					}
					?>
				</div>
				<div class="devstat">
					<span style='font-size:30px;'>Current Clip:<br></span>
					<?php		//Figure out if there are any clips first
						if ( gettype( $bin ) == 'resource' ) {
							fwrite($bin, $clipsCount);
							$clipCount = '';
							for ($x=0; $x<=$value3-4;){
								$clipCount .= fgets($bin);
								$x++;
							}
							$count = explode(" ", $clipCount);
							//get the number of clips
							foreach($config as $hd => $deck){
									if( $hd !== 'global' ){
										if($deck['number'] == $_GET['deck'] && $deck['model'] == "mini"){
											$count_get = @trim($count[6]);
											break;
										}else{
											$count_get = @trim($count[34]);
											break;
										}
									}
								}
							if($count_get == "none" || $count_get == "0"){
								echo "Not in a playback mode, or no clips have been added to the timeline.";
							}else{
								//if clips do exist then get the list and match to the current clip number
								fwrite($bin, $status);
								$clipId = '';
								for ($x=0; $x<=5;){
									$clipId .= fgets($bin);
									$x++;
								}
								$clipId_base = explode("\n", $clipId);
								$clipId_get = explode(" ", $clipId_base[5]);
								if(trim($clipId_get[2]) != "none"){
									fwrite($bin, $clipsList);
									for ($x=0; $x<=intval($count_get)+7;){
										$clipName = fgets($bin);
										$x++;
										if($x==$clipId_get[2]+8){
											$clipName_base = explode("\n", $clipName);
											$clipName_get = explode(" ", $clipName_base[0]);
											echo $clipName_get[1];
										}
									}
								}else{
									//on reformat the decks may show they are on an non-existant clip
									echo "Not in a playback mode, or no clips have been added to the timeline.";	
								}
							}
						fclose($bin);
						} else {
							echo 'Could not connect to deck.';
						}
					?>
				</div>
			</div>
			<!--BIN GUI END-->
			<!--FOOTER START-->  
			<?php include_once('footer.php'); ?>
			<!--FOOTER END-->
		</div>
	</body>
</html>