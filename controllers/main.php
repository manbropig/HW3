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

    public function __construct()
    {
        $this->connector = new connector();
        //$this->connector->choose_db("LIMERICKS");
        //$putter = new data_putter();
    }
    /**
     * probably need to pass this 2 arrays or strings, one for each list of 10 poems
     * $data['top'] and $data['recent']
     */
    function get_poem_lists()
    {
        $list_string = $this->get_most_recent();
        //inside of this have a variable for each actual list which is an array of poems and links <br/>
        $lists = <<<LST
<div id="wrapper">
    <div id="leftcol">
        <u>Most Recent Poems</u>:<br/>
        $list_string
    </div>
    <div id="rightcol">
        <u>Top Rated Poems</u>:<br/>
        POEM 1<br/>
        POEM 2<br/>
        POEM 3<br/>
        POEM 4<br/>
        POEM 5<br/>
        POEM 6<br/>
        POEM 7<br/>
        POEM 8<br/>
        POEM 9<br/>
        POEM 10<br/>
    </div>
</div>
LST;
        return $lists;
    }



    function get_most_recent()
    {
        //get 10 most recent titles
        $rec_array = $this->connector->recent_query();

        //create links for each poem page
        $link = "$BASEURL". "index.php?view=landing&c=main&p=";
        $recent_list_str = "";
        foreach($rec_array as $ID => $title)//check title for spaces???
        {
            $recent_list_str .= "<a href=\"".$link.$ID."\">$title</a>
            <br/>";
        }
        return $recent_list_str;

        //and add each length to a string separated by <br/>'s

    }




    function setup()
    {
        $upload =
            "<a href="
            .$BASEURL."index.php?view=upload_page&c=uploader>
            Upload your own poem!</a>";
        $this->data["upload_link"] = $upload;

        $this->data["poem_lists"] = $this->get_poem_lists();


        if(!isset($_GET['p']))
            $poem_details = $this->connector->random_poem();
        else
        {
            $selected = $_GET['p'];
            //select this poem from the db
            //set $poem_details in regards to this poem
            $poem_details = $this->connector->get_poem($selected);
        }

        $this->data["poem"] = $poem_details["poem"];
        $this->data["title"] = $poem_details["title"];
        $this->data["author"]= $poem_details["author"];
        echo "setup complete<br/>";
    }


}
//$connector = new connector();
//$connector->choose_db("LIMERICKS");
//$putter = new data_putter();

$ctrl = new controller();

//$title = "My Dog";
//$author = "Jamie";
//$poem =
//"My dog is cool<br/>He knows how to drool<br/>
//He runs all around<br/>And all over town<br/>
//And then takes a dip in a pool";
//
//$sql = "INSERT INTO POEMS VALUES(0, \"$title\", \"$author\",\"$poem\", 0, 0, 0)";
//$ctrl->connector->in_query($sql);//use model class to insert into DB

$ctrl->setup();



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

