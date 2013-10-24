<?php
// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174

class data_putter extends connector
{
    function __construct()
    {
        parent::__construct();

    }

    function in_query($query)
    {
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        if(mysqli_query($this->con, $query))
        {
            echo "input query successfully executed<br/>";
        }
        else
        {
            echo "input query failed to execute<br/>";
        }
    }


    function input_poem($details)
    {
        global $table_name, $BASEURL;
        $title = $details['title'];
        $author = $details['author'];
        $poem = $details['poem'];
        $id = parent::get_rows($table_name) - 1;
        $id++;

        $query = "INSERT INTO POEMS VALUES($id,\"$title\", \"$author\", \"$poem\", 0,0,0 )";
        //echo $query."\n";

        $this->in_query($query);
        $redirect = '<meta http-equiv="refresh" content="0;url='
            .$BASEURL.
            'index.php?view=confirmation&c=usher&conf=true&p='.$id.'"/>';

        return $redirect;
    }
}

?>
