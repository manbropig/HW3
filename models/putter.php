<?php
// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174

class data_putter extends connector
{
    function __construct()
    {
        $this->con = parent::get_connection();
        echo $this->con . "yup";
    }

    function in_query($query)
    {
        //parent::in_query($query);
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
}

?>
