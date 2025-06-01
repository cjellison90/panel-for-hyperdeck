<?php require('scripts.php');?>
<!--
//     __   ______   __    __      __   ______   ______  ______  ______   __    __   ______   ______  ______    
//    /\ \ /\  __ \ /\ "-./  \    /\ \ /\  ___\ /\  ___\/\  ___\/\  __ \ /\ "-./  \ /\  __ \ /\__  _\/\  __ \   
//    \ \ \\ \  __ \\ \ \-./\ \  _\_\ \\ \  __\ \ \  __\\ \  __\\ \  __ \\ \ \-./\ \\ \  __ \\/_/\ \/\ \ \/\ \  
//     \ \_\\ \_\ \_\\ \_\ \ \_\/\_____\\ \_____\\ \_\   \ \_\   \ \_\ \_\\ \_\ \ \_\\ \_\ \_\  \ \_\ \ \_____\ 
//      \/_/ \/_/\/_/ \/_/  \/_/\/_____/ \/_____/ \/_/    \/_/    \/_/\/_/ \/_/  \/_/ \/_/\/_/   \/_/  \/_____/ 
//      					PLEASE DON'T STEAL MY STUFF

      //Deck control developed and written by Jeff Amato - iamjeffamato.com @iamjeffamato
      //Hyperdeck is a registered trademark of Blackmagic Design Pty Ltd
      //Configuration and use notes can be found at hyperdeck.iamjeffamato.com
      //
      //      This software is distributed by purchase from hyperdeck.iamjeffamato.com via gumroad.com
      //	  This software comes as is, WITHOUT ANY WARRANTY.
      //      Feel free to modify it's contents, but remember if you break it... just re-download it.
      //      
      //Secure PHP login without Database provided by Jerry Low @crankberryblog.com   
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
      <head>
            <meta name="apple-mobile-web-app-capable" content="yes">
            <meta name="viewport" content="width=1200, user-scalable=0">
            <meta name="apple-mobile-web-app-status-bar-style" content="default">
            <link rel="apple-touch-icon" href="images/hdcpIcon.png">
            <title>HyperDeck Control Panel</title>
            <link rel="stylesheet" type="text/css" href="css/default.css" media="screen" />
            <link rel="icon" type="image/png" href="images/hdcpIcon.png">
            <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      </head>
      <body>
            <div class="hdcpInterface">
                  <!--START HEADER -->
                  <div class="hdcpHeader">
                        <a href="help.php?">
                              <?php if($enable_avatar == "true"){ echo '<img class="avatar left" src="'.$avatar.'">';} ?>
                              <div class="left large"><span class="bold large">HyperDeck</span> Panel Help</div>
                        </a>
                        <div class="right">
                              <?php include_once('nav.php'); ?>
                        </div>
                  </div>
                  <!--END HEADER-->
			<img src="images/interface.png">
                  <div id="help" style="float:left;margin-top:18px;">
                        <span class="large">General Notes</span><br>
                        <i class="fa fa-exclamation-circle fa-fw" style="color:yellow;"></i>For most of the transport and utility functions of HDP to work, a Hyperdeck must be placed in Remote mode. This happens by default when any
                        transport controls are activated from the control panel. However, if the deck is not in Remote mode, some features may not trigger because the deck is not enabled to receive commands.
                  </div>
			<div id="help" style="float:left;margin-top:18px;">
                        <span class="large">Clip Bin</span><br>
                              <i class="fa fa-exclamation-circle" style="color:yellow;"></i> The clip bin has two primary functions, cuing clips on the deck or playing clips on selection. By default Cue & Play
                              is disabled, which puts the clip bin in cue mode. By enabling Cue & Play, the clip will automatically cue and play when it is clicked on.<br>
					<i class="fa fa-exclamation-circle" style="color:yellow;"></i> For Hyperdeck Studio Mini models, the <i class='fa fa-download fa-fw'></i> icon to the right of each row will download
					the respective clip. Please note, most file sizes are large and can take some time to process before the transfer is complete.<br>
					<i class="fa fa-exclamation-circle" style="color:yellow;"></i> You can manually refresh the clip list by clicking the Refresh button.
			</div>
			<div id="help" style="float:left;margin-top:18px;">
                        <span class="large">Scheduler</span><br>
                              <i class="fa fa-exclamation-circle" style="color:yellow;"></i> For the Scheduler to work, pop-ups must be enabled for HDP in your web browser and the Scheduler
					tab or window must remain open.<br>
					<i class="fa fa-exclamation-circle" style="color:yellow;"></i> It is highly suggested that the timing interval be set no less than 20 seconds. The Scheduler refreshes
					itself to check the current time based on this interval. Inputting new events is difficult below 20 seconds.<br>
			</div>
			<a name="file"></a>
                  <div id="help" style="float:left;margin:18px 0px 24px 0px;">
                        <span class="large">File Naming Structure</span><br>
                        You can define the way your recorded file name will be written. By default the hardware will append built-in serialization to the end of the file name.
                        The file naming structure can contain dashes and underscores, all spaces will be stripped.<br><br>There are eleven definable values that can make up the file name:<br>Example: %month%day%year_%deckname_%reel-%take<br>
                        Output: 02202017_Program_R01-T22_0000.mov<br>
                        <div id="help" style="width:333px;float:left;margin-top:18px;">
                              <ul>
                                    <li>%month <i class="fa fa-arrow-circle-right" style="color:grey;"></i>two digit month</li>
                                    <li>%day <i class="fa fa-arrow-circle-right" style="color:grey;"></i>two digit day</li>
                                    <li>%year <i class="fa fa-arrow-circle-right" style="color:grey;"></i>four digit year</li>
                                    <li>%hour <i class="fa fa-arrow-circle-right" style="color:grey;"></i>two digit hour</li>
                                    <li>%min <i class="fa fa-arrow-circle-right" style="color:grey;"></i>two digit minute</li>
                                    <li>%sec <i class="fa fa-arrow-circle-right" style="color:grey;"></i>two digit second</li>
                              </ul>
                        </div>
                        <div id="help" style="width:500px;float:left;margin-top:18px;clear:right;">
                              <ul>
                                    <li>%reel <i class="fa fa-arrow-circle-right" style="color:grey;"></i>max 6 character user defined</li>
                                    <li>%take <i class="fa fa-arrow-circle-right" style="color:grey;"></i>max 6 character user defined</li>
                                    <li>%scene <i class="fa fa-arrow-circle-right" style="color:grey;"></i>max 10 character user defined</li>
						<li>%deckname <i class="fa fa-arrow-circle-right" style="color:grey;"></i>deck name defined in settings</li>
                                    <li>%custom <i class="fa fa-arrow-circle-right" style="color:grey;"></i>user defined entry</li>
                              </ul>
                        </div>
                  </div>
                  <!--FOOTER START-->  
                  <?php include_once('footer.php'); ?>
                  <!--FOOTER END-->
            </div>
      </body>
</html>