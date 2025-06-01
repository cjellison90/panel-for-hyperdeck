<?php

//HYPERDECK CONTROL PANEL CONFIG
      // Reading the config data
      $configtxt = file_get_contents('config.txt'); 
      $config = unserialize($configtxt);
      //Globals
      $startkey = "status:";
      $endkey = "speed:";
      foreach($config as $hd => $deck){
            if( $hd === 'global' ){
            
                  //General Config
                  $enable_login = $deck['enableLogin'];           //Enable login? 'true' by default, change to 'false' to disable
                  $ffspeed = $deck['ffspeed'];                    //Speed must be an integer between 0 & 1600
                  $rwspeed = $deck['rwspeed'];                    //Speed must be an integer between -1600 & 0
                  $loopKind = $deck['looping'];				//Loop single clip or entire deck
                  $enable_avatar = $deck['avatarEnable'];         //Enable avatar/branding? Change to 'false' to disable
                  $avatar = $deck['avatarUrl'];                   //Avatar location, can be url, use png for transparency, scaled down to 52px by 52px
			//$dispClip = $deck['dispClip'];			//Replacte time code text with current file name - coming at some point
			//$scroll = $deck['scroll'];				//Scroll constant or on hover - coming at some point
                  // Timer Config
                  date_default_timezone_set($deck['timezone']);   //Timezone for timer function - Find localizations here: http://www.w3schools.com/php/php_ref_timezones.asp
                  $interval = $deck['timerInterval'];             //How often, in seconds, the timer loop checks for the set execution time
                  $fnUser = $deck['fnUser'];                      //User file naming schema
                  $available_decks = $deck['totalDecks'];		 //Total number of configurable decks
            }
      }
?>