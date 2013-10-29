<?php
// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/config/config.php");
include_once($parent_dir . "/models/db_con.php");
include_once($parent_dir . "/controllers/main.php");

class uploader extends controller
{
    function __construct()
    {
        parent::__construct();
        $this->setup();
    }

    public function setup()
    {
        parent::setup();

    $poem_input =  <<<POEM
<form name='poemForm' method="post" action="controllers/cleaner.php"
onsubmit="return validateForm()">
                <input class="submit" type="text" name="title"
                placeholder='Title'><br/>
                <input class="submit" type="text" name="author"
                placeholder='Author Name'>
                <br/>
                <textarea  id="poem" name="poem" rows="5" cols="35"
                placeholder='Type poem here'></textarea>
                <br/>
                <input type="submit" value="Submit">
             </form>
POEM;

        $this->data["poem_form"] = $poem_input;

    }
}
$ctrl = new uploader();
?>

