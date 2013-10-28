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

        $query =
            "INSERT INTO POEMS VALUES(0,\"$title\",
            \"$author\", \"$poem\", 0,0,0,FALSE, null )";
        //echo $query."\n";

        $this->in_query($query);
        echo $id;
        $redirect = '<meta http-equiv="refresh" content="3;url='
            .$BASEURL.
            "index.php?view=confirmation&c=usher&conf=true&p=$id\"/>";

        return $redirect;
    }

    function unfeature($id)
    {
        global $table_name;

        $query = "UPDATE $table_name SET FEATURED=FALSE WHERE ID=$id";
        $this->in_query($query);
    }

    function feature($id)
    {
        global $table_name;
        $time = time();
        $query =
            "UPDATE $table_name SET FEATURED=TRUE, TIME=$time WHERE ID=$id";
        $this->in_query($query);
    }
}

?>
