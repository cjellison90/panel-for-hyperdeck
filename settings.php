<?php require('scripts.php'); if($enable_login == "true"){require('_login.php');}else{} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
      <head>
            <meta name="apple-mobile-web-app-capable" content="yes">
            <meta name="viewport" content="width=1200, user-scalable=0">
            <meta name="apple-mobile-web-app-status-bar-style" content="default">
            <link rel="apple-touch-icon" href="images/hdcpIcon.png">
            <title>HyperDeck Settings Panel</title>
            <link rel="stylesheet" type="text/css" href="css/default.css" media="screen" />
            <link rel="icon" type="image/png" href="images/hdcpIcon.png">
            <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      </head>
      <body>
            <div class="hdcpInterface">
            <!--START HEADER -->
            <div class="hdcpHeader">
                  <a href="settings.php">
                        <?php if($enable_avatar == "true"){echo '<img class="avatar left" src="'.$avatar.'">';} ?>
                        <div class="left large"><span class="bold large">HyperDeck</span> Settings Panel</div>
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
                  <div class="right logout" style="margin-right: 20px;"><a href="index.php">Close</a></div>
            </div>
            <!--END HEADER-->
            
            <div class="right logout" style="margin-right: 40px;"><a href="export.php">Export</a></div>
            <div class="right medium" style="margin:10px 20px 0px 0px;">
                  <form action="import.php" method="post" enctype="multipart/form-data">
                        <input name="importfile" type="file" id="importfile">
                        <input  type="submit" name="submit" value="  Import  " style="border: none;background-color: #e2e1dd;padding: 6px;text-decoration: none;font-size:16px;color:#1d1d1d;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;text-transform: capitalize;">
                  </form>
            </div>
            <form action="write.php" method="post">
                  <div class="configsave left">
                        <input type="submit" value="  save  ">
                  </div>
                  <?php
                  foreach($config as $hd => $deck){
                        if( $hd === 'global' ){
                  ?>
                  <!-- GENERAL SETTINGS -->
                  <div style="width:1024px;display:block;float:left;">
                        <div class="config" style="border: 4px solid #444; height:200px;">
                              <div class="medium">Interface</div>
                                    <span class="small" style="padding-left:60px;">Authentication</span>
                                          <select name="enableLogin">
                                          <option <?php if($deck['enableLogin'] == 'true'){echo("selected");}?> value="true">Enabled</option>
                                          <option <?php if($deck['enableLogin'] == 'false'){echo("selected");}?> value="false">Disabled</option>
                                          </select>
                                    <br>
                                    <span class="small" style="padding-left:50px;">Avatar</span>
                                          <select name="avatarEnable">
                                          <option <?php if($deck['avatarEnable'] == 'true'){echo("selected");}?> value="true">Enabled</option>
                                          <option <?php if($deck['avatarEnable'] == 'false'){echo("selected");}?> value="false">Disabled</option>
                                          </select>
                                    <br>
                                    <span class="small">Avatar Url</span>
                                          <input type="text" name="avatarUrl" value="<?php echo $deck['avatarUrl']; ?>">
                                    <br>
                                    <!--<span class="small" style="padding-left:50px;">Clip Name Display</span>
                                          <select name="dispClip">
                                          <option <?php if($deck['dispClip'] == 'true'){echo("selected");}?> value="true">Enabled</option>
                                          <option <?php if($deck['dispClip'] == 'false'){echo("selected");}?> value="false">Disabled</option>
                                          </select>
                                    <br>
                                    <span class="small" style="padding-left:50px;">Clip Name Scroll</span>
                                          <select name="scroll">
                                          <option <?php if($deck['scroll'] == 'auto'){echo("selected");}?> value="auto">Auto</option>
                                          <option <?php if($deck['scroll'] == 'hover'){echo("selected");}?> value="hover">On hover</option>
                                          </select>-->
                                    <br>
                                    <br>
                                    <i class="fa fa-exclamation-circle fa-fw" style="color:yellow;"></i>
                                    <span class="small" style="color:red;">Total Configurable Decks</span>
                                          <input type="text" name="totalDecks" style="width:50px;" value="<?php echo $deck['totalDecks']; ?>">
                        </div>
                        <div class="config" style="border: 4px solid #444; height:200px;">
                              <div class="medium">Transport</div>
                                    <br>
                                    <span class="small" style="padding-left:6px;">Fast Forward Speed</span>
                                          <input type="text" style="width:80px;" name="ffspeed" value="<?php echo $deck['ffspeed']; ?>">
                                    <br>
                                    <span class="small" style="padding-left:36px;">Rewind Speed</span>
                                          <input type="text" name="rwspeed" style="width:80px;" value="<?php echo $deck['rwspeed']; ?>">
                                    <br>
                                    <span class="small" style="padding-left:36px;">Looping</span>
                                          <select name="looping">
                                          <option <?php if($deck['looping'] == "all"){echo("selected");}?> value="all">All</option>
                                          <option <?php if($deck['looping'] == "clip"){echo("selected");}?> value="clip">Per Clip</option>
                                          </select>
                        </div>
                        <div class="config" style="border: 4px solid #444; height:200px;">
                              <div class="medium">Timing</div>
                                    <br>
                                    <span class="small" style="padding-left:1px;"><a class="small" style="border-bottom: 1px dotted;" href="http://php.net/manual/en/timezones.php" target="blank">Timezone</a></span>
                                          <input type="text" name="timezone" value="<?php echo $deck['timezone']; ?>">
                                    <br>
                                    <span class="small">Scheduler Check Interval</span>
                                          <input type="text" name="timerInterval" style="width:50px;" value="<?php echo $deck['timerInterval']; ?>">
                        </div>
                  </div>
                  <div class="config" style="border: 4px solid #444; width:924px;height:60px;">
				<div style="float:left;width:910px;padding:12px 8px;">
                              <div style="margin:0 auto; width:910px;">
                              Custom Naming
                              <i class="fa fa-arrow-circle-right" style="color:white;"></i>
                              <input type="text" style="width:600px;border: none;background-color: #444;border-radius: 4px;padding: 2px 2px 2px 6px;margin-top: 5px;font-size: 16px;" name="fnUser" value="<?php echo $deck['fnUser']; ?>">_0000.format
                              &nbsp;<a style="border:none;" href="help.php#file"><i class="fa fa-question-circle" style="color:yellow;"></i></a>
                              </div>
                        </div>
                  </div>
                  <?php
                        }
                  }
                  //END GENERAL CONFIG
                  foreach($config as $hd => $deck){
                        if( $hd !== 'global' ){
                  ?>
                  <!-- DECK SETTINGS -->
                  <div class="config" style="<?php if($deck['enable'] == 'true'){echo("border: 4px solid green");}else{echo("border: 4px solid red");} ?>">
                        <span class="large">Deck <?php echo $deck['number']; ?></span>
                        <br>
                        <span class="medium"><?php echo $deck['name']; ?></span>
                        <br><br>
                        <span class="small">Deck State</span>
                              <select name="deck<?php echo $deck['number']; ?>enable">
                              <option <?php if($deck['enable'] == 'true'){echo("selected");}?> value="true">Enabled</option>
                              <option <?php if($deck['enable'] == 'false'){echo("selected");}?> value="false">Disabled</option>
                              </select><br>
                        <span class="small">Name</span>
                              <input type="text" maxlength="10" name="deck<?php echo $deck['number']; ?>name" value="<?php echo $deck['name']; ?>">
                        <br>
                        <span class="small" style="padding-left:16px;">IP</span>
                              <input type="text" name="deck<?php echo $deck['number']; ?>ip" value="<?php echo $deck['ip']; ?>">
                        <br>
                        <span class="small">Model</span>
                              <select name="deck<?php echo $deck['number']; ?>model">
                              <option value="mini" <?php if($deck['model'] == 'mini'){echo("selected");}?>>Hyperdeck Mini</option>
                              <option value="studio" <?php if($deck['model'] == 'studio'){echo("selected");}?>>Hyperdeck Studio</option>
                              <option value="12g" <?php if($deck['model'] == '12g'){echo("selected");}?>>Hyperdeck Studio 12G</option>
                              <option value="pro" <?php if($deck['model'] == 'pro'){echo("selected");}?>>Hyperdeck Studio Pro</option>
                              </select>
                  </div>
                  <?php
                        }
                  }
                  //END DECK SETTINGS
                  ?>
            </form>
            <!--FOOTER START-->  
            <?php include_once('footer.php'); ?>
            <!--FOOTER END-->
            </div>
      </body>
</html>