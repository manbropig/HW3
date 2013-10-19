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
class cleaner extends controller
{
    function __construct()
    {
        parent::__construct();
        $this->conn = $this->connector->con;
    }
    function add_breaks()
    {
        if(isset($_POST['title']) && isset($_POST['author']))
        {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $poem = nl2br($_POST['poem']);//replaces \n with <br/>

            return $poem;
        }
    }

    function clean($poem)
    {
        return $this->conn->real_escape_string($poem);
    }


}

//$cleaner = new cleaner();
//$str = $cleaner->add_breaks();
//
//echo $cleaner->clean($str);


echo soundex("hello") ."\n";
echo soundex("yellow") ."\n";
echo soundex("mellow") ."\n";
echo soundex("fellow") ."\n";
echo soundex("brown") ."\n";
echo soundex("jamie") ."\n";
echo soundex("amy") ."\n";
echo soundex("bland") ."\n";
echo soundex("brand") ."\n";

?>


