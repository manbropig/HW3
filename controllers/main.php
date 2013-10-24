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
        $this->puller = new data_puller();
        $this->putter = new data_putter();
        //$this->connector->choose_db("LIMERICKS");
        //$putter = new data_putter();
    }
    /**
     * probably need to pass this 2 arrays or strings, one for each list of 10 poems
     * $data['top'] and $data['recent']
     */
    function get_poem_lists()
    {
        $recent_poems = $this->get_most_recent();
        $top_poems = $this->get_top_rated(); //currently same as most recent

        //inside of this have a variable for each actual list which is an array of poems and links <br/>
        $lists = <<<LST
<div id="wrapper">
    <div id="leftcol">
        <u>Most Recent Poems</u>:<br/>
        $recent_poems
    </div>
    <div id="rightcol">
        <u>Top Rated Poems</u>:<br/>
        $top_poems
    </div>
</div>
LST;
        return $lists;
    }


    /**
     * @return string
     * Asks model for most recently added poems
     */
    function get_most_recent()
    {
        global $BASEURL;
        //get 10 most recent titles
        $rec_array = $this->puller->recent_query();

        //create links for each poem page
        $link = "$BASEURL". "index.php?view=landing&c=main&p=";
        $recent_list_str = "";
        foreach($rec_array as $ID => $title)
        {
            $recent_list_str .= "<a href=\"".$link.$ID."\">$title</a>
            <br/>";
        }
        return $recent_list_str;

        //and add each length to a string separated by <br/>'s

    }

    function get_top_rated()
    {
        global $BASEURL;
        $top_array = $this->puller->top_query();

        //create links for each poem page
        $link = "$BASEURL". "index.php?view=landing&c=main&p=";
        $top_list_str = "";
        foreach($top_array as $ID => $title)
        {
            $top_list_str .= "<a href=\"".$link.$ID."\">$title</a>
            <br/>";
        }
        return $top_list_str;

    }




    function setup()
    {
        global $BASEURL;
        $upload =
            "<a href="
            .$BASEURL."index.php?view=upload_page&c=uploader>
            Upload your own poem!</a>";
        $this->data["upload_link"] = $upload;

        $this->data["poem_lists"] = $this->get_poem_lists();


        if(!isset($_GET['p']))
            $poem_details = $this->puller->random_poem();
        else
        {
            $selected = $_GET['p'];
            //select this poem from the db
            //set $poem_details in regards to this poem
            $poem_details = $this->puller->get_poem($selected);
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

/*
 * marsupials
By not Jamie
soup dat sop
eat dat soup
and know you just ate
before its too late
a marsupial suit

Cool story NO
By Bro
No bro no
Dude... no
chyah
chyah
but no

goob
By noob
noob tube
noob tube
rump
jump
ube lube

yabadaba
By bill nye
yabadaba
abazaba
the arsonist
had oddly shaped feet
yaba

abazaba
By dave chapelle
aba zaba
yaba daba
gabagoo
boogyboo
yabadaba


Hungry Hippos
By Jamie Tahirkheli
Hungry hippo
Do the limbo
Dip down low
below the pole
you stupid hippo

When I'm Hungry
By Jamie Tahirkheli
When I'm hungry
I get grumpy
Sound the alarm
I can do harm
I'll eat food that is lumpy

John McKluskey
By Jamie Tahirkheli
Mr. McKluskey
Wasn't too huskey
wasn't too tall
Nor too small
Just a dog of type huskey

 */



?>

