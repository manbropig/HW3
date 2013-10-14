<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<!--
Jamie Tahirkheli - 006547398
Zohaib Khan - 007673133
CS 174
-->
<html xmlns="http://www.w3.org/1999/xhtml" id="backgrnd">
<link rel="stylesheet" type="text/css" href="css/blogStyles.css">

<?php
include_once("config/config.php");

echo '<h1 class="blogTitle">
	<a href='.$BASEURL.' style="text-decoration:none"> SimpleBlog</a> <br/>
	</h1>';




//get list of entry directories and sort them descending
$dirs = preg_grep('/^([^.])/', scandir($longURL . "entries"));
rsort($dirs);
//print_r($dirs);

$mostrecent = $dirs[0];



if(
(!isset($_GET['c']))&& 
(!isset($_GET['view'])))
{
    $c = 'main.php';
    
   if(session_status() == PHP_SESSION_NONE)
	{
		session_start();//ANY TIME using session, even to get values, must start session 			
	}
	
	if(isset($_SESSION['loggedin']))
	{
		//echo 'loggedin = ' . $_SESSION['loggedin'] ."\n";
		if($_SESSION['loggedin'] == 'true') 
			$view = 'loggedin.php';
		else
        	$view = 'notloggedin.php';
        	
    }
    else
    {
    	$view = 'notloggedin.php';
    }
}
// C are already set.
else 

{
    $c = $_REQUEST['c'] . '.php';
    $view = $_REQUEST['view'] . '.php';
}

if (isset($_GET['e']))//if there IS an entry request, get it.
{
	$e = $_REQUEST['e'];
}
else 
{ 
	$e = 'mostrecent';
}

if(
(isset($_POST['c']))
&& 
(isset($_POST['view']))
&& 
(isset($_POST['a']))
&& 
(isset($_POST['e'])))
{
    $c = $_POST['c'] . '.php';
    $view = $_POST['view'] . '.php';
    $e = $_POST['e'];
    $a = $_POST['a'];
}

//echo $c . ' ' . $view . ' ' . $e;
require_once('controllers/' . $c );
require_once('views/' . $view );

/*
 The main controller should be used for adding a comment. In this case, the form should be 
 posted, the controller,view, and entry should be hidden variables, and you should have a 
 hidden variable a with value comment.
*/
function check2()
{
	
}

?>

</html>


