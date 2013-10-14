<?php

// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174

$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/config/config.php");
include_once($parent_dir . "/models/entry_model.php");

//$selected comes from entry_model.php
// $blogLines ='';
// $blogTitle = $selected[0];
// for($i = 1; $i < sizeof($selected) ; $i++)
// {
// 	$blogLines = $blogLines . $selected[$i] . "<br/>";
// }

/*
	For handling new entries:
		get the title from $_POST['blogtite']
		get the entry from $_POST['blogentry']
		use entry_model to store those in a file
		go back to loggedin view
*/
if((isset($_POST['blogentry']))&&(isset($_POST['title'])))
{
    $title = $_POST['title'];
    $entry = $_POST['blogentry'];
    echo $title;
    
    $scribe = new scribe();
    $scribe -> newEntry($title, $entry);
    
    echo '<meta http-equiv="refresh" content="0;url=' . $BASEURL . 
    'index.php?c=main&view=loggedin&e=mostrecent" />';
}

if(isset($_REQUEST['log']))
{
	session_start();
	if(isset($_SESSION['loggedin']))
  	unset($_SESSION['loggedin']);
	// session_destroy();
	echo '<meta http-equiv="refresh" content="0;url=' . $BASEURL . 
    'index.php?c=main&view=notloggedin&e=mostrecent" />';
}



?>

