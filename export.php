<?php require('scripts.php');
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
      

// Write data to file for user download        
header("Content-Type:text/plain");
header("Content-Disposition: Attachment; filename=HyperDeckPanel_Export_".date('Ymd\_Hi').".txt");
header("Pragma: no-cache");
$fp = fopen('config.txt','r');
$export = fread($fp, filesize("config.txt"));
fclose($fp);
print $export;
?>