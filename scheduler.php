<?php require('scripts.php'); if($enable_login == "true"){require('_login.php');} header("Refresh:$interval"); ?>
<?php
	$schedule = unserialize(file_get_contents('schedule.txt'));
	array_multisort($schedule);
	if(@$_POST['function'] == "add"){
		$schedule[] = array(
		"date" => $_POST['date'],
		"time" => $_POST['time'], 
		"deck" => $_POST['deck'],
		"cmd" => $_POST['cmd'],
		"uid" => uniqid(),
		);
		// Write data to file
		$fp = fopen('schedule.txt','w'); 
		fwrite($fp,serialize($schedule));
		header('Location: scheduler.php');
	}elseif(@$_GET['function'] == "remove"){
		foreach ( $schedule as $event => $item ){
			if ( $_GET['uid'] == $item['uid'] ){
				unset($schedule[$event]);
				// Write data to file
				$fp = fopen('schedule.txt','w'); 
				fwrite($fp,serialize($schedule));
			}
		}
		header('Location: scheduler.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="viewport" content="width=1200, user-scalable=0">
		<meta name="apple-mobile-web-app-status-bar-style" content="default">
		<link rel="apple-touch-icon" href="images/hdcpIcon.png">
		<title>HyperDeck Schedule Panel</title>
		<link rel="stylesheet" type="text/css" href="css/default.css" media="screen" />
		<link rel="icon" type="image/png" href="images/hdcpIcon.png">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	</head>
	<body>
		<div class="hdcpInterface">
		<!--START HEADER -->
			<div class="hdcpHeader">
				<a href="scheduler.php">
					<?php if($enable_avatar == "true"){ echo '<img class="avatar left" src="'.$avatar.'">';} ?>
					<div class="left large"><span class="bold large">HyperDeck</span> Schedule Panel</div>
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
		<!-- SCHEDULE LIST -->
			<div class="hdcpDeckBorderlt">
				<div class="event">
					<ul>
						<?php
						if(!$schedule){
							echo "<li>There are no events currently scheduled, add an event below.</li>";    
						}else{
							foreach($schedule as $event => $item){
								if($item['cmd'] == "rec"){
									$command = "record";
								}else{
									$command = $item['cmd'];
								}
								if($item['cmd'] == "play" || $item['cmd'] == "playall"){
									echo "<li class='eventplay'>Deck ".$item['deck']." is scheduled to ".$command." at ".date("g:i a", strtotime($item['time']))." on ".date("F, j, Y", strtotime($item['date']))."<a href='?function=remove&uid=".$item['uid']."'><i style='float:right;background-color:transparent;line-height:40px;margin-right:10px;' class='fa fa-times-circle' style='color:red;'></i></a></li>";
								}elseif($item['cmd'] == "stop" || $item['cmd'] == "stopall"){
									echo "<li class='eventstop'>Deck ".$item['deck']." is scheduled to ".$command." at ".date("g:i a", strtotime($item['time']))." on ".date("F, j, Y", strtotime($item['date']))."<a href='?function=remove&uid=".$item['uid']."'><i style='float:right;background-color:transparent;line-height:40px;margin-right:10px;' class='fa fa-times-circle' style='color:red;'></i></a></li>";
								}else{
									echo "<li class='eventrecord'>Deck ".$item['deck']." is scheduled to ".$command." at ".date("g:i a", strtotime($item['time']))." on ".date("F, j, Y", strtotime($item['date']))."<a href='?function=remove&uid=".$item['uid']."'><i style='float:right;background-color:transparent;line-height:40px;margin-right:10px;' class='fa fa-times-circle' style='color:white;'></i></a></li>";									
								}
							}
						}
						?>
					</ul>
				</div>
			</div>
		<!--SCHEDULE GUI-->
			<div class="hdcpDeck hdcpDeckBorderlt" style="border-bottom: 1px solid #41423c;">
				<div class="hdcpDblBox left" style="width:100px;">
					<div name="deckname" class="deckname medium">
						<br>Add<br>Event
					</div>
				</div>
				<div class="left" style="line-height: 37px;">
				<!--SCHEDULE FORM-->
					<form action="" method="post">
						<input type="hidden" name="function" value="add">
						<div class="left" style="line-height: 116px;padding-left:20px;">
							<span style="font-size:24px;vertical-align: middle;">Schedule  </span>
							<select name="deck" class="red" style="font-size:24px;vertical-align: middle;border:none;">
								<?php
									foreach($config as $hd => $deck){
										if( $hd !== 'global' ) {
											if( isset( $deck['enable'] ) && $deck['enable'] == "true"){
												echo "<option value='".$deck['number']."'>".$deck['name']."</option>";
											}
										}
									}
								?>
								<option value="sync">Sync</option>
							</select>
							<span style="font-size:24px;vertical-align: middle;">  to  </span>
							<select name="cmd" class="red" style="font-size:24px;vertical-align: middle;border:none;">
								<option value="play">Play</option>
								<option value="stop">Stop</option>
								<option value="rec">Record</option>
							</select>
							<span style="font-size:24px;vertical-align: middle;">  at  </span>
								<input type="text" maxlength="5" name="time" value="<?php echo date("H:i"); ?>" class="red" style="border:none;font-size:24px;vertical-align: middle;width:86px;">
							<span style="font-size:24px;vertical-align: middle;">  on  </span>
								<input type="text" maxlength="12" name="date" value="<?php echo date("Y-m-d"); ?>" class="red" style="border:none;font-size:24px;vertical-align: middle;width:160px;">
						</div>
						<div class="hdcpBox left">
							<input type="submit" class="hdcpButton play" value="" style="border: none;">
						</div>
					</form>
				<!--END FORM-->
				</div>
			<!--FOOTER START-->  
			<?php include_once('footer.php'); ?>
			<!--FOOTER END-->
			</div>
		</div>
	</body>
</html>
<?php
	//SCHEDULE TRIGGER
	$currentTime = date('H:i');
	$currentDate = date('Y-m-d');
	//Schedule function if sync
	foreach($schedule as $event => $item){
		if ($currentTime == $item['time'] && $currentDate == $item['date'] && $item['deck'] == "sync"){
			$uid = $item['uid'];
			if ($item['cmd'] == "play"){
				print "<script> window.open('event.php?cmd=playall','_blank'); </script>";
				print "<script> window.location.href = '?function=remove&uid=$uid'; </script>";
			}elseif ($item['cmd'] == "stop"){
				print "<script> window.open('event.php?cmd=stopall','_blank'); </script>";
				print "<script> window.location.href = '?function=remove&uid=$uid'; </script>";
			}elseif ($item['cmd'] == "rec"){
				print "<script> window.open('event.php?cmd=recall','_blank'); </script>";
				print "<script> window.location.href = '?function=remove&uid=$uid'; </script>";
			}
		}
	}
	//Schedule function if normal
	foreach($schedule as $event => $item){    
		if ($currentTime == $item['time'] && $currentDate == $item['date']){
			$deck = $item['deck'];
			$cmd = $item['cmd'];
			$uid = $item['uid'];
			print "<script> window.open('event.php?deck=$deck&cmd=$cmd','_blank');</script>";
			print "<script> window.location.href = '?function=remove&uid=$uid'; </script>";
		}
	}
?>