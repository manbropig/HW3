<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" >
<?php
// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/config/config.php");
include_once($parent_dir . "/models/authenticate.php");

if(session_status() == PHP_SESSION_NONE)
{
	session_start();//ANY TIME using session, even to get values, must start session 			
}

$auth = new authenticator();
$auth->authenticate();


?>
</html>