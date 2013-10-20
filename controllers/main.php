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
    </div>
</div>
LST;
        return $lists;
    }



    function get_most_recent()
    {
        global $BASEURL;
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

        function get_star_rating($ratings)
        {
                //gets average ratings. userRating/votes
                if($ratings["votes"] == 0)
                $avg = 0;
                else
                $avg = ($ratings["userRating"]/$ratings["votes"]);

                //This function rounds average to nearest half
                $roundResult = $this->round_to_half($avg);

                //After average set to nearest half this function sets image
                $starImage = $this->set_star_image($roundResult);

                return $starImage;
        }

//This function rounds average to nearest half
function round_to_half($avg)
{
        echo "avg: " .$avg;

        $ceil = ceil($avg);
        echo "ceil: " .$ceil;
        $half = ($ceil - 0.5);
        echo "half: " .$half;

        if($avg >= $half + 0.25) return $ceil;
        else if($avg < $half - 0.25) return floor($avg);
        else return $half;
}


        function set_star_image($rating)
        {

                $image = "";

                if($rating == 0.5)
                $image = "0.5star";
                else if($rating == 1)
                $image = "1star";
                else if($rating == 1.5)
                $image = "1.5stars";
                else if($rating == 2)
                $image = "2stars";
                else if($rating == 2.5)
                $image = "2.5stars";
                else if($rating == 3)
                $image = "3stars";
                else if($rating == 3.5)
                $image = "3.5stars";
                else if($rating == 4)
                $image = "4stars";
                else if($rating == 4.5)
                $image = "4.5stars";
                else if($rating == 5)
                $image = "5stars";
                else
                $image = "0stars";

                return "<img border='0' src='images/" .$image.".jpg' alt='star rating' width='100' height='50'>";
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
        echo "setup complete<br/>";

        if(!isset($_GET['p']))
            {
                $poem_details = $this->connector->random_poem();
                $poem_ratings = $this->connector->rating_out(1);
            }
        else
        {
            $selected = $_GET['p'];
            //select this poem from the db
            //set $poem_details in regards to this poem
            $poem_details = $this->connector->get_poem($selected);
            $poem_ratings = $this->connector->rating_out($selected);
        }
        $this->data["starImage"] = $this->get_star_rating($poem_ratings);
        $this->data["poem"] = $poem_details["poem"];
        $this->data["title"] = $poem_details["title"];
        $this->data["author"]= $poem_details["author"];
    }


}
//$connector = new connector();
//$connector->choose_db("LIMERICKS");
//$putter = new data_putter();

$ctrl = new controller();
$ctrl->setup();
//$title = "My Dog";
//$author = "Jamie";
//$poem =
//"My dog is cool<br/>He knows how to drool<br/>
//He runs all around<br/>And all over town<br/>
//And then takes a dip in a pool";

//$sql = "INSERT INTO POEMS VALUES(0, \"$title\", \"$author\",\"$poem\", 0, 0, 0)";
//$ctrl->connector->in_query($sql);//use model class to insert into DB





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

