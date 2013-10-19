<!--
Jamie Tahirkheli
006547398
CS 174
-->
<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" >
<title>Looney Limericks</title>
<?php
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/models/db_con.php");
include_once($parent_dir . "/config/config.php");

abstract class view
{
    var $title;             //title of the page/view
    var $data = array();    //data to be displayed in the view
    var $recent = array();  //list of top 10 recently added poems - make display function
    var $top = array();     //list of top 10 rated poems - make display function
    var $random;            //link to pick random poem from DB to be displayed

    //abstract function display_poem_lists();
}

//$connector = new connector();
//$connector->choose_db("LIMERICKS");
//

//
//$sql = "INSERT INTO POEMS VALUES(\"$beard\",\"$title\", \"$author\")";
//$connector->in_query($sql);
//$out = "SELECT * FROM POEMS";
//$res = $connector->out_query($out);


?>

</html>
