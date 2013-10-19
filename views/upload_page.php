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
}
?>

<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Looney Limericks</title>
    <link rel="stylesheet" type="text/css" href="/HW3/css/limerick_styles.css"/>
</head>
<body>
<div class="enter">
    <?php echo $ctrl->data["poem_form"];?>
</div>
<script type="text/javascript">

    /*
     Using Javascript you should verify the line lengths of
     title, author, and each line of the limerick before sending any
     data to the server. It should also check the number of lines in the poem.
     Accepted poem information should be stored in a database.
     */
    function validateForm()
    {
        var poemForm = document.forms["poemForm"];
        var title = poemForm["title"].value;
        var auth = poemForm["author"].value;

        var ret = true;

        if (title==null || title=="" || title.length > 30)
        {
            alert("Title must be between 1 and 30 characters");
            poemForm.focus();
            ret = false;
        }

        if (auth==null || auth=="" || auth.length > 30)
        {
            {
                alert("Author must be between 1 and 30 characters");
                ret = false;
            }
        }

        var poem = document.getElementById("poem").value;
        var lines = poem.split("\n");
        var lineCount = lines.length;

        if(poem==null || poem=="" || lineCount != 5)
        {
            alert("poem must be 5 lines");
            ret = false;
        }

        for(var i = 0; i < lineCount; i++)
        {
            var line = lines[i];

            /**CAREFUL - MIGHT REMOVE NEWLINES WHICH WE NEED **/
            //remove trailing whitespace from each line
            line = line.replace(/^\s+|\s+$/g,'')

            var lineLength = line.length;

            if(lineLength == 0)
            {
                ret = false;
                alert("No skipping lines");

            }
            if(lineLength > 30)
            {
                ret = false;
                alert("Sorry! Only 30 characters allowed per line");
                break;
            }
        }
        return ret;
    }

//    Title: Guy Named Noah
//    Author: Louvenia Duncan
//
//    I once knew a guy named Noah
//    Mean as the snake called Boa
//    Loved him still
//    Wasn't God's will
//    Sent him back to Samoa

</script>

<div><?php echo $ctrl->data["poem_lists"];?></div>
</body>

</html>
