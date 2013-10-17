<?php
// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/config/config.php");

$dirs = preg_grep('/^([^.])/', scandir($longURL . "entries"));

class connector
{
    var $con;

    function __construct()
    {
        $this->con=mysqli_connect("localhost","root","");
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
            echo "Database $db_name created successfully\n";
        }
        else
        {
            echo "Error creating database: " . mysqli_error($this->con);
        }
    }


    function choose_db($db_name)
    {
       if( mysqli_select_db($this->con, $db_name))
            echo "successfully chosen database $db_name\n";
       else
            echo "Unable to select $db_name\n";


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
            echo "Table created successfully\n";
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
            echo "query successfully executed\n";
        }
        else
        {
            echo "query failed to execute";
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
            echo "query failed to execute";
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
            echo "no need, DB doesn't exist\n";
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
            echo "no need, DB doesn't exist\n";
        }
    }
}

$connector = new connector();
//$connector->drop_table("LIMERICKS");
//$connector->drop_db("LIMERICKS");
$connector->create_db("LIMERICKS");
$connector->choose_db("LIMERICKS");
$table_maker = "CREATE TABLE IF NOT EXISTS POEMS(POEM VARCHAR(105), TITLE VARCHAR(30), AUTHOR VARCHAR(30))";
$connector->create_table($table_maker);

$title = "beardman";
$author = "Edward Lear";
$beard = "There was an Old Man with a beard<br/>Who said, 'It is just as I feard!<br/>Two Owls and a Hen,<br/>Four Larks and a Wren,<br/>Have all built their nests in my beard!";

$sql = "INSERT INTO POEMS VALUES(\"$beard\",\"$title\", \"$author\")";
$connector->in_query($sql);
//$sql = "INSERT INTO POEMS VALUES('comp', 234567890)";
//$connector->in_query($sql);
//$sql = "INSERT INTO POEMS VALUES('cs', 765445678)";
//$connector->in_query($sql);
//$sql = "INSERT INTO POEMS VALUES('cs', 019283746)";
//$connector->in_query($sql);

$out = "SELECT * FROM POEMS";
echo $out . "\n";
$res = $connector->out_query($out);
?>
<html>
<head>
    <title>Looney Limericks DB connector</title>
</head>
<body>
<?php


echo $res;

/***** write results to file ******/
//$filename="poems.txt";
//
//$filehandle = fopen($filename, "w");
//
//if($filehandle)
//    fwrite($filehandle, $res);
//else
//    echo "error, file not written.\n";
//fclose($filehandle);
/***** write results to file ******/



//$mysqli = new mysqli("localhost", "root", "", "applications");
?>
</body>
</html>
