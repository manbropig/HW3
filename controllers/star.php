<?php
// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174
if(session_status() == PHP_SESSION_NONE)
{
    session_start();//ANY TIME using session, even to get values, must start session
}
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/config/config.php");
include_once($parent_dir . "/models/db_con.php");

        global $BASEURL;

        if(isset($_POST['star']))
        {
                $connection = new connector();
                $rating_value = $_POST['star'];
                if(!isset($_POST['selected']))
                {
                        echo "selected not set";
                        $selected = $connection->get_featured();
                }
                else
                {
                        echo "selected set";
                        $selected = $_POST['selected'];
                }

                $connection->update_rating($selected, $rating_value);

                if(!isset($_SESSION['yourRating']))
                {
                        $_SESSION['yourRating'] =
                            array($selected => $rating_value);
                }
                else
                {
                        $yourRating = $_SESSION['yourRating'];
                        $yourRating[$selected] = $rating_value;
                        $_SESSION['yourRating'] = $yourRating;
                }

                echo '<meta http-equiv="refresh" content="0;url='
                    .$BASEURL.
                    'index.php?view=landing&c=main&p='.$selected.'"/>';
        }
        else
        {
                echo "this isn't working";
        }

?>
