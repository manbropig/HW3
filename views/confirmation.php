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

class confirmation extends view
{
    function __construct()
    {
        $this->setup_data();
    }
    function setup_data()
    {
        global $message, $redirect;
        $this->title = '<title>Poem Confirmation</title>';
        $this->data['css'] =  '<link rel="stylesheet" type="text/css" href="/HW3/css/limerick_styles.css"/>';
        $this->data['message'] = $message;
        $this->data['redirect'] = $redirect;
        $this->data['title'] = $this->title;
    }

    function display_page()
    {
        foreach($this->data as $value)
        {
            echo $value;
        }
    }

}
//TODO figure out why not redirecting properly
?>

<body>
<?php
$conf = new confirmation();
$conf->display_page();
//echo $conf->data['message'];
//echo $conf->data['redirect'];
?>

<br/>
Please wait while you're redirected back to the main site.

</body>

