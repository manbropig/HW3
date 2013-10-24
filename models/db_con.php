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
        if( mysqli_select_db($this->con, $db_name))
            echo "successfully chosen database $db_name<br/>";
        else
            echo "Unable to select $db_name<br/>";
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
        if (mysqli_query($this->con,$sql))
        {
            echo "Database $db_name created successfully<br/>";
        }
        else
        {
            echo "Error creating database: " . mysqli_error($this->con);
        }
         
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
        if (mysqli_query($this->con,$sql))
        {
            echo "Table created successfully<br/>";
        }
        else
        {
            echo "Error creating table: " . mysqli_error($this->con);
        }
         
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

        if(mysqli_query($this->con, $query))
        {
            echo "input query successfully executed<br/>";
        }
        else
        {
            echo "input query failed to execute<br/>";
        }
         
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

            echo "out query successfully executed<br/>";
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

    /**
     * @param $db_name
     * Drops database
     */
    function drop_db($db_name)
    {
         
        $sql = "DROP DATABASE $db_name";
        if(mysqli_query($this->con, $sql))
        {
            echo "successfully dropped table<br/>";
        }
        else{
            echo "no need to drop DB because the DB doesn't exist<br/>";
        }
         
    }

    /**
     * @param $table_name
     * drops table
     */
    function drop_table($table_name)
    {
         
        $sql = "DROP TABLE $table_name";
        if(mysqli_query($this->con, $sql))
        {
            echo "successfully dropped table<br/>";
        }
        else{
            echo "no need to drop the table because the table doesn't exist<br/>";
        }
         
    }


    function close_db()
    {
        if(mysqli_close($this->con))
            echo "successfully closed DB<br/>";
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
//NEED ANOTHER DB FOR THE 10 MINUTE INTERVAL CHANGE

include_once($parent_dir . "/models/putter.php");
include_once($parent_dir . "/models/puller.php");

?>
