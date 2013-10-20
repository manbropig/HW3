<!--
Jamie Tahirkheli
006547398
CS 174
-->
<?php
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/models/db_con.php");
include_once($parent_dir . "/config/config.php");
//include_once($parent_dir . "/views/page.php");

class landing_view //extends view
{
    var $title = "Loony Limericks - home";             //title of the page/view
    var $data = array();    //data to be displayed in the view
    var $recent = array();  //list of top 10 recently added poems - make display function
    var $top = array();     //list of top 10 rated poems - make display function
    var $featured;
    var $random;            //link to pick random poem from DB to be displayed


}

//$landing = new landing_view();


?>

<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Looney Limericks</title>
    <link rel="stylesheet" type="text/css" href="/HW3/css/limerick_styles.css"/>
</head>
<body>

<div class="upload">
    <?php echo $ctrl->data["upload_link"];?>
</div>
<table class="poem_holder">
    <tr>
        <th><?php echo $ctrl->data["title"];?></th>
    </tr>
    <tr>
        <th>By <?php echo $ctrl->data["author"];?></th>
    </tr>
    <tr>
        <td class="poem"><?php echo $ctrl->data["poem"];?></td>
    </tr>
</table>

<div class="rating_holder">
<?php echo $ctrl->data["starImage"];?>
</div>

    <?php
        echo $ctrl->data["poem_lists"];
    ?>
</body>

</html>
