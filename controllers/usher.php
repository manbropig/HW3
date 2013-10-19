<?php
// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/config/config.php");
include_once($parent_dir . "/models/db_con.php");
include_once($parent_dir . "/controllers/main.php");


/*
 * this script is going to:
 * On the server, you should clean the data before saving it into the database
 * (at a minimum, mysqli_escape_string). The server should also attempt to validate
 * the rhyme scheme before accepting a poem. This might be done using the soundex()
 * or metaphone() functions in PHP. You can assume the language of submissions is English.
 * If a poem submission is not valid you should give an appropriate error message.
*/

if(isset($_GET['conf']))
{
    $status = $_GET['conf'];

    if($status == "true")
    {
        $id = $_GET['id'];
        $message = "Congratulations!<br/>
         Your poem has been uploaded to Looney Limericks.";
        $redirect = '<meta http-equiv="refresh" content="3;url='
            .$BASEURL.'index.php?view=landing&c=main&p='.$id.'"/>';
    }
    else{
        $message = "I'm sorry, your peom wasn't Looney enough.<br/>
        You can try a different poem though!";
        $redirect = '<meta http-equiv="refresh" content="3;url='
            .$BASEURL.'index.php?view=upload_page&c=uploader"/>';

    }
}


//$str = $cleaner->add_breaks();
//echo $str;
/*
Title: Guy Named Noah
Author: Louvenia Duncan
AABBA
I once knew a guy named Noah
Mean as the snake called Boa
Loved him still
Wasn't God's will
Sent him back to Samoa
 */

?>


