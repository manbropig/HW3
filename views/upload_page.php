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

class upload_view extends view
{
    function __construct()
    {
        $this->setup_page();
    }


    function setup_page()
    {
        global $ctrl;
        $this->title = '<title>Poem Upload</title>';
        $this->data['title'] = $this->title;
        $this->data['css'] =  parent::css;
//        $this->data['recent'] = $this->recent;
//        $this->data['top'] = $this->top;
        $this->data["poem_form"] = $ctrl->data["poem_form"];
        $this->data["poem_lists"] = $ctrl->data["poem_lists"];
    }

}

$uploader = new upload_view();
?>

<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <?php echo $uploader->data['title'];
    echo $uploader->data['css'];?>
</head>
<body>
<div class="enter">
    <?php echo $uploader->data["poem_form"];?>
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
            ret = false;
        }

        if (auth==null || auth=="" || auth.length > 30)
        {
            {
                alert("Author must be between 1 and 30 characters");
                ret = false;
            }
        }

        var poem = poemForm["poem"].value;//document.getElementById("poem").value;
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

<div><?php echo $uploader->data["poem_lists"];?></div>
</body>

</html>
