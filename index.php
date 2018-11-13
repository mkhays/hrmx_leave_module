<?php
//error_reporting(0);
$idletime=900;//after 60 seconds the user gets logged out
session_start();
if (time()-$_SESSION['timestamp']>$idletime){	
		unset($_SESSION['firstname']);
		unset($_SESSION['username']);
		unset($_SESSION['lastname']);
		unset($_SESSION['position']);
		unset($_SESSION['user_id']);
		unset($_SESSION['email']);
		unset($_SESSION['active_epm']);
		unset($_SESSION['user_sup']);
		unset($_SESSION['user_role']);
		unset($_SESSION['timestamp']);
    session_destroy();
    session_unset();
	header('Location: https://hris.baylor-uganda.org');
}else{
	//session_start();
	$_SESSION['timestamp']=time();
}
require_once('./controller/leave_controller.php');
$seek = new leave_controller();
$seek->main_function();  
?>
<!--<p style="text-align:center"><img src="images/logos/baylor_logo.JPG" width="180" height="150" /></p>
<p><h4 style="text-align:center">Dear Team. <br />The Leave management system is currently under upgrade. It will be up soon. <br />Sorry for the incovinience.<br /> I.T<br /><a href="https://hris.baylor-uganda.org/">< < BACK TO MAIN SYSTEM</h4></a></h4></p> -->
