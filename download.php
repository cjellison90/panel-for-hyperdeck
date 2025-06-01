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
	
foreach($config as $hd => $deck){
	if($deck['number'] == $_GET['deck']){
		$file = $_GET['file'];
		$slot = $_GET['slot'];
		$temp = "temp".rand();
		header('Content-type: file/binary');
		header('Content-Disposition: attachment; filename="'.$file.'"');
	//connect and login to mini
		$ftp_server = $deck['ip'];
		$ftp_conn = ftp_connect($ftp_server) or die ("Bad connection to ".$deck['name']." at ".$deck['ip']);
		$login = ftp_login($ftp_conn, "anonymous", "");
		ftp_pasv($ftp_conn, true);
		ftp_chdir($ftp_conn, $slot );
		
	//download file and temporarily store it
		ftp_get($ftp_conn,$temp, $file, FTP_BINARY);
	//engage download-aka transfer from temp folder	
		readfile($temp);	
	//close connection
		ftp_close($ftp_conn);
	//delete the temp file
		unlink($temp);
	}
}
?>