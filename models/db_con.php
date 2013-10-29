<?php
// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/config/config.php");

class connector
{
    //var $con;

    function __construct()
    {
        $this->connect();
    }

    function connect()
    {

        global $connection, $username, $password, $db_name;
        $this->con = mysqli_connect($connection,$username,$password);
        $this->choose_db($db_name);
    }

    protected function get_connection()
    {
        return $this->con;
    }

    function choose_db($db_name)
    {
        mysqli_select_db($this->con, $db_name);

    }

    /**
     * Create a database
     */
    function create_db($db_name)
    {
         
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        // SQL to create database
        $sql="CREATE DATABASE IF NOT EXISTS $db_name";
        mysqli_query($this->con,$sql);
         
    }

    /**
     * Create table
     */
    function create_table($sql)
    {
         
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        // Create table
        // Execute query
        mysqli_query($this->con,$sql);

         
    }

    /**
     * @param $query
     * Executes a query to input/change data
     */
    function in_query($query)
    {
         
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        mysqli_query($this->con, $query);

    }

    /**
     * @param $id
     * Executes a query getting the rating result
     */

    function rating_out($id)
    {
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $query = "SELECT * FROM POEMS WHERE ID = \"$id\"";

        if($results = mysqli_query($this->con, $query))
        {
            $row = mysqli_fetch_array($results);
            $rating = $row['RATING_SUM'];
            $votes = $row['VOTES'];
            $details = ["userRating" => $rating,
                "votes" => $votes, "id" => $id];
        }
        else
        {

            $details = ["userRating" => 0, "myRating" => 0, "votes" => 0];
        }
        return $details;
    }

    /**
     * 
     * Executes a query getting the feature poem id
     */

        function get_featured()
        {

        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $query = "SELECT ID FROM POEMS WHERE FEATURED = 1";//true

        if($results = mysqli_query($this->con, $query))
        {
            $row = mysqli_fetch_array($results);
            $id = $row["ID"];
        }
        else
        {
            $id = 0;
        }
        return $id;
        }

    /**

     * @param $query
     * Executes a query getting the rating result
     */

    function update_rating($id, $num)
    {
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $rating_info = $this->rating_out($id);

        $added_rating = $rating_info["userRating"] + $num;
        $added_votes = $rating_info["votes"] + 1;

        $updateQuery =
            "UPDATE poems SET RATING_SUM = \"$added_rating\",
            VOTES = \"$added_votes\" WHERE ID = \"$id\"";

        mysqli_query($this->con, $updateQuery);
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

            $num_rows = mysqli_num_rows($results);

            for($i = 0; $i < $num_rows; $i++)
            {
                $row = mysqli_fetch_array($results);
                $res_str = $res_str . $row["POEM"] . "\t" .
                    $row["TITLE"] .$row["AUTHOR"] . "<br/>";
            }
             
            return $res_str;
        }
        else
        {
            echo "query failed to execute<br/>";
             
        }
    }

    /**
     * @param $db_name
     * Drops database
     */
    function drop_db($db_name)
    {
         
        $sql = "DROP DATABASE $db_name";
        mysqli_query($this->con, $sql);
         
    }

    /**
     * @param $table_name
     * drops table
     */
    function drop_table($table_name)
    {
         
        $sql = "DROP TABLE $table_name";
        mysqli_query($this->con, $sql);
    }


    function close_db()
    {
        mysqli_close($this->con);
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
//NEED ANOTHER DB FOR THE 10 MINUTE INTERVAL CHANGE

//KEEP IN THIS ORDER
include_once($parent_dir . "/models/putter.php");
include_once($parent_dir . "/models/puller.php");

?>
