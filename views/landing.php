<!--
Jamie Tahirkheli
006547398
CS 174
-->
<?php
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/models/db_con.php");
include_once($parent_dir . "/config/config.php");
include_once($parent_dir . "/views/page.php");

class landing_view extends view
{
    var $title = "Loony Limericks - home";             //title of the page/view
    var $data = array();    //data to be displayed in the view
    var $recent = array();  //list of top 10 recently added poems - make display function
    var $top = array();     //list of top 10 rated poems - make display function
    var $featured;
    var $random;            //link to pick random poem from DB to be displayed

    /**
     * probably need to pass this 2 arrays or strings, one for each list of 10 poems
     * $data['top'] and $data['recent']
     */
    function display_poem_lists()
    {
        //inside of this have a variable for each actual list which is an array of poems and links <br/>
        $lists = <<<LST
<div id="wrapper">
    <div id="leftcol">
        LEFT COL<br/>
        POEM 1<br/>
        POEM 2<br/>
    </div>
    <div id="rightcol">
        RIGHT COL<br/>
        POEM 1<br/>
        POEM 2<br/>
    </div>
</div>
LST;
        echo $lists;
    }
}


$landing = new landing_view();


?>

<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Looney Limericks</title>
    <link rel="stylesheet" type="text/css" href="/HW3/css/limerick_styles.css"/>
</head>
<body>

<table class="poem_holder">
    <tr>
        <th><?php echo $poem_details["title"];?></th>
    </tr>
    <tr>
        <th>By <?php echo $poem_details["author"];?></th>
    </tr>
    <tr>
        <td class="poem"><?php echo $poem_details["poem"];?></td>
    </tr>
</table>

    <?php
        $landing->display_poem_lists();
    ?>
</body>
</html>
