<script type='text/javascript'>
    function btnswap()
    {
        var mybtns = document.getElementsByClassName('btns');
        for(i=0; i < mybtns.length; i++)
        {
            var elem = document.getElementById(mybtns[i].id);
            elem.src = "images/emptyStar.jpg";
            elem.onmouseover = btnOver;
            elem.onmouseout = btnOut;

            function btnOver()
            {
                var lit = document.getElementById(this.id);

                if(lit.id == "rb1")
                {
                    lit.src = "images/filledStar.jpg";
                }
                else if(lit.id == "rb2")
                {
                    lit.src = "images/filledStar.jpg";
                    document.getElementById("rb1").src = "images/filledStar.jpg";
                }
                else if(lit.id == "rb3")
                {
                    lit.src = "images/filledStar.jpg";
                    document.getElementById("rb1").src = "images/filledStar.jpg";
                    document.getElementById("rb2").src = "images/filledStar.jpg";
                }
                else if(lit.id == "rb4")
                {
                    lit.src = "images/filledStar.jpg";
                    document.getElementById("rb1").src = "images/filledStar.jpg";
                    document.getElementById("rb2").src = "images/filledStar.jpg";
                    document.getElementById("rb3").src = "images/filledStar.jpg";
                }
                else if(lit.id == "rb5")
                {
                    lit.src = "images/filledStar.jpg";
                    document.getElementById("rb1").src = "images/filledStar.jpg";
                    document.getElementById("rb2").src = "images/filledStar.jpg";
                    document.getElementById("rb3").src = "images/filledStar.jpg";
                    document.getElementById("rb4").src = "images/filledStar.jpg";
                }
            }

            function btnOut()
            {
                var lit = document.getElementById(this.id);

                if(lit.id == "rb1")
                {
                    lit.src = "images/emptyStar.jpg";
                }
                else if(lit.id == "rb2")
                {
                    lit.src = "images/emptyStar.jpg";
                    document.getElementById("rb1").src = "images/emptyStar.jpg";
                }
                else if(lit.id == "rb3")
                {
                    lit.src = "images/emptyStar.jpg";
                    document.getElementById("rb1").src = "images/emptyStar.jpg";
                    document.getElementById("rb2").src = "images/emptyStar.jpg";
                }
                else if(lit.id == "rb4")
                {
                    lit.src = "images/emptyStar.jpg";
                    document.getElementById("rb1").src = "images/emptyStar.jpg";
                    document.getElementById("rb2").src = "images/emptyStar.jpg";
                    document.getElementById("rb3").src = "images/emptyStar.jpg";
                }
                else if(lit.id == "rb5")
                {
                    lit.src = "images/emptyStar.jpg";
                    document.getElementById("rb1").src = "images/emptyStar.jpg";
                    document.getElementById("rb2").src = "images/emptyStar.jpg";
                    document.getElementById("rb3").src = "images/emptyStar.jpg";
                    document.getElementById("rb4").src = "images/emptyStar.jpg";
                }
            }
        }
    }

    function ratings(id, num)
    {
        //session variable save here.
        //php update_rating(id, num);
        //$this->data["starImage"] = $this->get_star_rating($poem_ratings);
    }
</script>
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

    function get_rand_link()
    {
        global $BASEURL, $table_name;
        $rows = $this->puller->get_rows($table_name);
        $id = rand(1, $rows);
        $link = "$BASEURL". "index.php?view=landing&c=main&p=$id";
        $clickable = "<a href=\"".$link."\">Choose a random poem</a><br/>";
        return $clickable;
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
        {
            $poem_details = $this->puller->get_featured_poem();
            $poem_ratings = $this->connector->rating_out(1);
            $selected = 1;
        }
        else
        {
            $selected = $_GET['p'];
            //select this poem from the db
            //set $poem_details in regards to this poem
            $poem_details = $this->connector->get_poem($selected);
            $poem_ratings = $this->connector->rating_out($selected);
        }

        $this->data["clickableStarImage"] = $this->set_clickable_star_image($selected);
        $this->data["starImage"] = $this->get_star_rating($poem_ratings);
        $this->data["poem"] = $poem_details["poem"];
        $this->data["title"] = $poem_details["title"];
        $this->data["author"]= $poem_details["author"];
        $this->data['rand'] = $this->get_rand_link();
        echo "setup complete<br/>";
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

//        if($rating == 0.5)
//            $image = "0.5star";
//        else if($rating == 1)
//            $image = "1star";
//        else if($rating == 1.5)
//            $image = "1.5stars";
//        else if($rating == 2)
//            $image = "2stars";
//        else if($rating == 2.5)
//            $image = "2.5stars";
//        else if($rating == 3)
//            $image = "3stars";
//        else if($rating == 3.5)
//            $image = "3.5stars";
//        else if($rating == 4)
//            $image = "4stars";
//        else if($rating == 4.5)
//            $image = "4.5stars";
//        else if($rating == 5)
//            $image = "5stars";
//        else
//            $image = "0stars";

        return "<img border='0' src='images/".$rating."stars.jpg' alt='star rating' width='120' height='40'>";
    }

    function set_clickable_star_image($selected)
    {
        return
            <<<STAR
            <input type = "image" class="btns" id="rb1" src="images/emptyStar.jpg" alt="Star" width="20" height="40" onmouseover="btnswap(this.id);" onmouseout(this.id);" value="1" onclick="ratings($selected, 1);">
    <input type="hidden" name="choice" width="20" height="40" id="1" value="1">
<input type = "image" class="btns" id="rb2" src="images/emptyStar.jpg" alt="Star" width="20" height="40" onmouseover="btnswap(this.id);" onmouseout(this.id);" value="2" onclick="ratings($selected, 2);">
    <input type="hidden" name="choice" width="20" height="40" id="2" value="2">
<input type = "image" class="btns" id="rb3" src="images/emptyStar.jpg" alt="Star" width="20" height="40" onmouseover="btnswap(this.id);" onmouseout(this.id);" value="3" onclick="ratings($selected, 3);">
    <input type="hidden" name="choice" width="20" height="40" id="3" value="3">
<input type = "image" class="btns" id="rb4" src="images/emptyStar.jpg" alt="Star" width="20" height="40" onmouseover="btnswap(this.id);" onmouseout(this.id);" value="4" onclick="ratings($selected, 4);">
    <input type="hidden" name="choice" width="20" height="40" id="4" value="4">
<input type = "image" class="btns" id="rb5" src="images/emptyStar.jpg" alt="Star" width="20" height="40" onmouseover="btnswap(this.id);" onmouseout(this.id);" value="5" onclick="ratings($selected, 5);">
    <input type="hidden" name="choice" width="20" height="40" id="5" value="5">
STAR;
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




?>

