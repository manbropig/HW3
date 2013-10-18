<?php
// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/config/config.php");
include_once($parent_dir . "/models/db_con.php");

class controller
{
    var $data = array(); //data to be echoed in views


}
$connector = new connector();
$connector->choose_db("LIMERICKS");
$putter = new data_putter();
$ctrl = new controller();

$title = "My Dog";
$author = "Jamie";
$poem =
    "My dog is cool<br/>He knows how to drool<br/>
He runs all around<br/>And all over town<br/>
And then takes a dip in a pool";




$sql = "INSERT INTO POEMS VALUES(0, \"$title\", \"$author\",\"$poem\", 0, 0, 0)";
$connector->in_query($sql);

$poem_details = $connector->random_poem($ctrl, $connector);
//echo $poem_details["title"] ."<br/>By ".$poem_details["author"]."<br/>".$poem_details["poem"];

/*
Title: Guy Named Noah
Author: Louvenia Duncan

I once knew a guy named Noah
Mean as the snake called Boa
Loved him still
Wasn't God's will
Sent him back to Samoa
 */
?>

