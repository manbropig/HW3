<?php
// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174

//$dirs = preg_grep('/^([^.])/', scandir($longURL . "entries"));

class data_puller extends connector
{
    function __construct()
    {
        parent::__contruct();
    }



    /**
     * @param $query
     * Executes a query that yields results
     */
    function out_query($query)
    {
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        if($results = mysqli_query($this->con, $query))
        {
            $res_str = "";

            echo "query successfully executed<br/>";
            $num_rows = mysqli_num_rows($results);

            for($i = 0; $i < $num_rows; $i++)
            {
                $row = mysqli_fetch_array($results);
                $res_str = $res_str . $row["POEM"] . "\t" . $row["TITLE"] .$row["AUTHOR"] . "<br/>";
            }
            return $res_str;
        }
        else
        {
            echo "query failed to execute<br/>";
        }
    }


    function get_rows($table_name)
    {
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $query = "SELECT COUNT(*) FROM $table_name";
        if($results = mysqli_query($this->con, $query))
        {
            echo "query successfully executed<br/>";
            $num_rows = mysqli_num_rows($results);

            $row = mysqli_fetch_array($results);
            $num_rows = $row["0"];

            return $num_rows;
        }
        else
        {
            echo "count query failed to execute<br/>";
        }


    }
}
//WHAT DOES HE MEAN BY "YOUR RATING" VS "USER RATING"?
//NEED ANOTHER DB FOR THE 10 MINUTE INTERVAL CHANGE
?>
