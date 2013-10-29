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




        if(!isset($_GET['p']))
        {
            $poem_details = $this->puller->get_featured_poem();
            $selected = $poem_details["id"];
            $poem_ratings = $this->connector->rating_out($selected);
        }
        else
        {
            $selected = $_GET['p'];
            //select this poem from the db
            //set $poem_details in regards to this poem
            $poem_details = $this->puller->get_poem($selected);
            $poem_ratings = $this->connector->rating_out($selected);
        }

        $this->data["clickableStarImage"] =
            $this->set_clickable_star_image($selected);
        $this->data["starImage"] = $this->get_star_rating($poem_ratings);
        $this->data["poem_lists"] = $this->get_poem_lists();
        $this->data["poem"] = $poem_details["poem"];
        $this->data["title"] = $poem_details["title"];
        $this->data["author"]= $poem_details["author"];
        $this->data['rand'] = $this->get_rand_link();
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

        $id = $ratings["id"];
        $query = "UPDATE poems set RATING = " .$roundResult. " WHERE ID = "
            .$id;

        $this->putter->in_query($query);

        //After average set to nearest half this function sets image
        $starImage = $this->set_star_image($roundResult);

        return $starImage;
    }

//This function rounds average to nearest half
    function round_to_half($avg)
    {

        $ceil = ceil($avg);
        $half = ($ceil - 0.5);

        if($avg >= $half + 0.25) return $ceil;
        else if($avg < $half - 0.25) return floor($avg);
        else return $half;
    }


    function set_star_image($rating)
    {

        return "<img border='0' src='images/".$rating."stars.jpg'
        alt='star rating' width='120' height='40'>";
    }

    function set_clickable_star_image($selected)
    {

        if(!isset($_SESSION['yourRating']))
        {
                $filledStars = 0;
        }
        else
        {
                $yourRating = $_SESSION['yourRating'];
                if(isset($yourRating[$selected]))
                {
                        $filledStars = $yourRating[$selected];
                }
                else
                {
                        $filledStars = 0;
                }
        }

        if($filledStars == 1)
        {
        $star = 
'<input type = "image" name="star" src="images/filledStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/emptyStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/emptyStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/emptyStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/emptyStar.jpg"
alt="Star" width="20" height="40">';
        }
        else if($filledStars == 2)
        {
        $star = 
'<input type = "image" name="star" src="images/filledStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/filledStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/emptyStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/emptyStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/emptyStar.jpg"
alt="Star" width="20" height="40">';
        }
        else if($filledStars == 3)
        {
        $star = 
'<input type = "image" name="star" src="images/filledStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/filledStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/filledStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/emptyStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/emptyStar.jpg"
alt="Star" width="20" height="40">';
        }
        else if($filledStars == 4)
        {
        $star = 
'<input type = "image" name="star" src="images/filledStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/filledStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/filledStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/filledStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/emptyStar.jpg"
alt="Star" width="20" height="40">';
        }
        else if($filledStars == 5)
        {
        $star = 
'<input type = "image" name="star" src="images/filledStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/filledStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/filledStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/filledStar.jpg"
alt="Star" width="20" height="40">
<input type = "image" name="star" src="images/filledStar.jpg"
alt="Star" width="20" height="40">';
        }
        else
        {
        $star = '<form name="rating" method="post"
        action="controllers/star.php">
<input type = "image" name="star" class="btns" id="rb1"
src="images/emptyStar.jpg" alt="Star" width="20" height="40"
onmouseover="btnswap(this.id);" onmouseout(this.id);" value="1">
<input type = "image" name="star" class="btns" id="rb2"
src="images/emptyStar.jpg" alt="Star" width="20" height="40"
onmouseover="btnswap(this.id);" onmouseout(this.id);" value="2">
<input type = "image" name="star" class="btns" id="rb3"
src="images/emptyStar.jpg" alt="Star" width="20" height="40"
onmouseover="btnswap(this.id);" onmouseout(this.id);" value="3">
<input type = "image" name="star" class="btns" id="rb4"
src="images/emptyStar.jpg" alt="Star" width="20" height="40"
onmouseover="btnswap(this.id);" onmouseout(this.id);" value="4">
<input type = "image" name="star" class="btns" id="rb5"
src="images/emptyStar.jpg" alt="Star" width="20" height="40"
onmouseover="btnswap(this.id);" onmouseout(this.id);" value="5">
<input type="hidden" name="selected" value='.$selected.'>
</form>';
        }
        return $star;
}
}


$ctrl = new controller();
$ctrl->setup();
?>

