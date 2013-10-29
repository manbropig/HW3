<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start();//ANY TIME using session, even to get values, must start session
}
?>
<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<!--
Jamie Tahirkheli - 006547398
Zohaib Khan - 007673133
CS 174
-->
<html xmlns="http://www.w3.org/1999/xhtml" id="backgrnd">
<head>
    <meta charset="utf-8">
</head>
<link rel="stylesheet" type="text/css" href="css/blogStyles.css">

<?php
include_once("config/config.php");

echo '<h1 class="siteTitle">
	<a href='.$BASEURL
    .' style="text-decoration:none"> LOONEY LIMERICKS</a> <br/>
	</h1>';

//get list of entry directories and sort them descending

$c = "main.php";
$view = "landing.php";

if(isset($_REQUEST['c']))
    $c = $_REQUEST['c'].".php";

if(isset($_REQUEST['view']))
    $view = $_REQUEST['view'].".php";

//echo $c . ' ' . $view;
require_once('controllers/' . $c );
require_once('views/' . $view );


?>

</html>


