<?php require('scripts.php'); if($enable_login == "true"){require('_login.php');}else{}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="viewport" content="width=1200, user-scalable=0">
		<meta name="apple-mobile-web-app-status-bar-style" content="default">
		<link rel="apple-touch-icon" href="images/hdcpIcon.png">
		<title>HyperDeck Utility Panel</title>
		<link rel="stylesheet" type="text/css" href="css/default.css" media="screen" />
		<link rel="icon" type="image/png" href="images/hdcpIcon.png">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	</head>
	<body>
		<div class="hdcpInterface">
			<!--START HEADER -->
			<div class="hdcpHeader">
				<a href="util.php">
					<?php if($enable_avatar == "true"){ echo '<img class="avatar left" src="'.$avatar.'">';} ?>
					<div class="left large"><span class="bold large">HyperDeck</span> Utility Panel</div>
				</a>
				
				<?php
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
			</div>
			<!--END HEADER-->
			
			<!--UTILITY GUI-->
			<!--PLAY ON STARTUP-->
			<?php
				$show = "false";
				foreach($config as $hd => $deck){
					if( $hd !== 'global' ){
						if($deck['model'] == "mini" && $deck['enable'] == "true"){
							$show = "true";
						}
					}
				}
				if($show == "false"){
					echo "<!--";
				}
			?>
			<div class="hdcpDeck hdcpDeckBorderlt" >
				<div class="hdcpDblBox hdcpBoxRborder left" style="line-height: 37px;">
					<div name="deckname" class="deckname medium">
						<br>Startup<div name="ipaddress"><i class="fa fa-exclamation-circle fa-fw" style="color:yellow;"></i> Only for Mini</div>
					</div>
				</div>
				
				
				<form action="?">
					<div class="left" style="line-height: 116px;padding-left:20px;">
						<input type="hidden" name="cmd" value="startup">
						<select name="startupstate" class="red" style="font-size:24px;vertical-align: middle;border:none;">
							<option value="true">Enable</option>
							<option value="false">Disable</option>
						</select>
						<span style="font-size:24px;vertical-align: middle;"> play on startup for </span>
						<select name="deck" class="red" style="font-size:24px;vertical-align: middle;border:none;">
							<?php
								foreach($config as $hd => $deck){
									if( $hd !== 'global' ){
										if($deck['model'] == "mini" && $deck['enable'] == "true"){
											echo "<option value='".$deck['number']."'>".$deck['name']."</option>";
										}
									}
								}
							?>
						</select>
					</div>
					<div class="hdcpBox left">
					<input type="submit" class="hdcpButton play" value="" style="border: none;">
					</div>
				</form>
			</div>
			<?php
				if($show == "false"){
					echo "-->";
				}
				
			?>
			<div class="hdcpDeck hdcpDeckBorderlt" >
				<div class="hdcpDblBox hdcpBoxRborder left" style="line-height: 37px;">
					<div name="deckname" class="deckname medium">
						<br>Slot Select
					</div>
				</div>
				<!--SLOT FORM-->
				<form action="?">
					<div class="left" style="line-height: 116px;padding-left:20px;">
						<input type="hidden" name="cmd" value="slot">
						<span style="font-size:24px;vertical-align: middle;">Set </span>
						<select name="deck" class="red" style="font-size:24px;vertical-align: middle;border:none;">
							<?php
								foreach($config as $hd => $deck){
									if( $hd !== 'global' ){
										if($deck['enable'] == "true"){
											echo "<option value='".$deck['number']."'>".$deck['name']."</option>";
										}
									}
								}
							?>
						</select>
						<span style="font-size:24px;vertical-align: middle;"> to slot </span>
						<select name="slotid" class="red" style="font-size:24px;vertical-align: middle;border:none;">
							<option value="1">1</option>
							<option value="2">2</option>
						</select>
					</div>
					<div class="hdcpBox left">
					<input type="submit" class="hdcpButton play" value="" style="border: none;">
					</div>
				</form>
			</div>
			
			<div class="hdcpDeck hdcpDeckBorderlt">
				<div class="hdcpDblBox hdcpBoxRborder left" style="line-height: 37px;">
					<div name="deckname" class="deckname medium">
						<br>Input
					</div>
				</div>
				<!--VIDEO STANDARD FORM-->
				<form action="?">
					<input type="hidden" name="cmd" value="vidstd">
					<div class="left" style="line-height: 116px;padding-left:20px;">
						<span style="font-size:24px;vertical-align: middle;">Set </span>
						<select name="deck" class="red" style="font-size:24px;vertical-align: middle;border:none;">
							<?php
								foreach($config as $hd => $deck){
									if( $hd !== 'global' ){
										if( isset( $deck['enable'] ) && $deck['enable'] == "true"){
											echo "<option value='".$deck['number']."'>".$deck['name']."</option>";
										}
									}
								}
							?>
						</select>
						<span style="font-size:24px;vertical-align: middle;">'s input to  </span>
						<select name="vidstd" class="red" style="font-size:24px;vertical-align: middle;border:none;">
							<option value="preview">Preview</option>
							<option value="SDI">SDI</option>
							<option value="HDMI">HDMI</option>
							<option value="component">Component</option>
						</select>
					</div>
					<div class="hdcpBox left">
						<input type="submit" class="hdcpButton play" value="" style="border: none;">
					</div>
				</form>
			</div>
			
			<div class="hdcpDeck hdcpDeckBorderlt">
				<div class="hdcpDblBox hdcpBoxRborder left" style="line-height: 37px;">
					<div name="deckname" class="deckname medium">
						<br>Audio
					</div>
				</div>
				<!--AUDIO STANDARD FORM-->
				<form action="?">
					<input type="hidden" name="cmd" value="audstd">
					<div class="left" style="line-height: 116px;padding-left:20px;">
						<span style="font-size:24px;vertical-align: middle;">Set </span>
						<select name="deck" class="red" style="font-size:24px;vertical-align: middle;border:none;">
							<?php
								foreach($config as $hd => $deck){
									if( $hd !== 'global' ){
										if($deck['enable'] == "true"){
											echo "<option value='".$deck['number']."'>".$deck['name']."</option>";
										}
									}
								}
							?>
						</select>
						<span style="font-size:24px;vertical-align: middle;">'s audio to  </span>
						<select name="audstd" class="red" style="font-size:24px;vertical-align: middle;border:none;">
							<option value="embedded">Embedded</option>
							<option value="XLR">XLR</option>
							<option value="RCA">RCA</option>
						</select>
					</div>
					<div class="hdcpBox left">
						<input type="submit" class="hdcpButton play" value="" style="border: none;">
					</div>
				</form>
				<!--END FORM-->
			</div>
			
			<div class="hdcpDeck hdcpDeckBorderlt">
				<div class="hdcpDblBox hdcpBoxRborder left" style="line-height: 37px;">
					<div name="deckname" class="deckname medium">
						<br>File Type<div name="ipaddress"><i class="fa fa-exclamation-circle fa-fw" style="color:yellow;"></i> May reboot</div>
					</div>
				</div>
				<!--FILE STANDARD FORM-->
				<form action="?">
					<input type="hidden" name="cmd" value="fmtstd">
					<div class="left" style="line-height: 116px;padding-left:20px;">
						<span style="font-size:24px;vertical-align: middle;">Set </span>
						<select name="deck" class="red" style="font-size:24px;vertical-align: middle;border:none;">
							<?php
								foreach($config as $hd => $deck){
									if( $hd !== 'global' ){
										if($deck['enable'] == "true"){
											echo "<option value='".$deck['number']."'>".$deck['name']."</option>";
										}
									}
								}
							?>
						</select>
						<span style="font-size:24px;vertical-align: middle;">'s file type to be  </span>
						<select name="fmtstd" class="red" style="font-size:24px;vertical-align: middle;border:none;">
							<option value="QuickTimeProResHQ">ProResHQ</option>
							<option value="QuickTimeProRes">ProRes</option>
							<option value="QuickTimeProResLT">ProResLT</option>
							<option value="QuickTimeProResProxy">ProResProxy</option>
							<option value="QuickTimeUncompressed">Uncompressed</option>
							<option value="QuickTimeDNxHD220">DNxHD220 QT</option>
							<option value="DNxHD220">DNxHD220</option>
						</select>
					</div>
					<div class="hdcpBox left">
						<input type="submit" class="hdcpButton play" value="" style="border: none;">
					</div>
				</form>
			</div>
			
			<div class="hdcpDeck hdcpDeckBorderlt">
				<div class="hdcpDblBox hdcpBoxRborder left" style="line-height: 37px;">
					<div name="deckname" class="deckname medium">
						<br>Format Disk
					</div>
				</div>
				<!--SELECT DECK TO FORMAT FORM-->
				<form action="?">
					<input type="hidden" name="cmd" value="format">
					<div class="left" style="line-height: 116px;padding-left:20px;">
						<span style="font-size:24px;vertical-align: middle;">Format the active disk in </span>
						<select name="deck" class="red" style="font-size:24px;vertical-align: middle;border:none;">
							<?php
								foreach($config as $hd => $deck){
									if( $hd !== 'global' ){
										if($deck['enable'] == "true"){
											echo "<option value='".$deck['number']."'>".$deck['name']."</option>";
										}
									}
								}
							?>
						</select>
						<span style="font-size:24px;vertical-align: middle;">  as </span>
						<select name="formatType" class="red" style="font-size:24px;vertical-align: middle;border:none;">
							<option value="HFS+">HFS+</option>
							<option value="exFAT">exFAT</option>
						</select>
					</div>
					<div class="hdcpBox left">
						<input type="submit" class="hdcpButton play" value="" onClick="return confirm('Formatting CANNOT be undone. Are you sure you want to proceed?');" style="border: none;">
					</div>
				</form>
			</div>
			
			<!--REPORTING-->
			<?php	
				if (isset($_GET['deck'])){
					foreach($config as $hd => $deck){
						if ( isset( $deck['number'] ) && $_GET['deck'] == $deck['number']){
							echo "<div class='hdcpDeck hdcpDeckBorderlt'><div class='reporting green'>".$deck['name'];
						}
					}
					if ($_GET['cmd'] == "slot"){
						echo " slot set to ".$_GET['slotid']."</div></div>";
					}elseif($_GET['cmd'] == "range"){
						echo " range set</div>";
					}elseif($_GET['cmd'] == "vidstd"){
						echo " input set to ".$_GET['vidstd']."</div></div>";
					}elseif($_GET['cmd'] == "audstd"){
						echo " audio set to ".$_GET['audstd']."</div></div>";
					}elseif($_GET['cmd'] == "fmtstd"){
						echo " format set to ".$_GET['fmtstd']."</div></div>";
					}elseif($_GET['cmd'] == "format"){
						echo " media formatted as ".$_GET['formatType']." has ". ( isset($complete) ? $complete : 'encountered an error' ) .".</div></div>";
					}elseif($_GET['cmd'] == "startup"){
						if($_GET['startupstate'] == "true"){$pos = "enabled";}else{$pos = "disabled";}
						echo " play on startup state changed to ".$pos.".</div></div>";
					}
				
				}
			?>
			<!--FOOTER START-->  
			<?php include_once('footer.php'); ?>
			<!--FOOTER END-->
		</div>
	</body>
</html>