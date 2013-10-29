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
        if(isset($_POST['title']) && isset($_POST['author']))
        {
            $this->title = $_POST['title'];
            $this->author = $_POST['author'];
            $this->poem = $_POST['poem'];
        }

    }
    function add_breaks()
    {
        if(isset($_POST['title']) && isset($_POST['author']))
        {
            $this->poem = nl2br($_POST['poem']);//replaces \n with <br/>

            return $this->poem;
        }
    }

    function clean($poem)
    {
        return $this->conn->real_escape_string($poem);
    }

    function get_last_word($string)
    {
        $words = explode(' ', $string);
        $word = $words[count($words) - 1];
        $last = preg_replace('/[^a-z]+/i', '', $word);//remove punctuation
        $last = trim(preg_replace('/\s\s+/', ' ', $last));
        return $last;
    }

    /**
     * @param $word1
     * @param $word2
     * @return bool
     * compares differences between 2 words, returns true if
     * they seem close enough to rhyme
     */
    function check_rhyme($word1, $word2)
    {
        $check = levenshtein(soundex($word1),soundex($word2));
        if($check <= 3)
            return true;
        else
            return false;
    }

    /**
     * USE BEFORE ADDING BREAKS
     * @param $poem
     * @return array
     */
    function get_lines()
    {
        $lines = explode("\n", $this->poem);
        return $lines;
    }

    /**
     * checks rhyme scheme for
     * A
     * A
     * B
     * B
     * A
     */
    function check_scheme()
    {
        $lines = $this->get_lines();

        if(($this->check_rhyme($this->get_last_word($lines[0]),
            $this->get_last_word($lines[1])))
            &&
            ($this->check_rhyme($this->get_last_word($lines[0]),
                $this->get_last_word($lines[4])))
            &&
        ($this->check_rhyme($this->get_last_word($lines[2]),
            $this->get_last_word($lines[3]))))
        {
            return true;
        }
        else
            echo "Poem does not match rhyme scheme<br/>";
        return false;
    }

    function upload_poem()
    {
        global $BASEURL;
        if($this->check_scheme())
        {
            $this->poem = $this->clean($this->add_breaks());
            //call upload method of DB connector
            $details = ["title" => $this->title,
                "author" => $this->author,
                "poem" => $this->poem];

            $redirect = $this->putter->input_poem($details);
            //echo "SUCCESS!! <br/>";
            echo $redirect;

        }
        else
        {
            //redirect to failed page

            echo "failure<br/>";
            echo '<meta http-equiv="refresh" content="0;url='."$BASEURL".
                'index.php?view=confirmation&c=usher&conf=false"/>';

        }
    }
}

$cleaner = new cleaner();
$cleaner->upload_poem();

?>


