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
    use myMethods, urMethods{
        urMethods::say insteadof myMethods;
        myMethods::say as saydone;
    }
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

        // Create database
        $sql="CREATE DATABASE $db_name";
        if (mysqli_query($this->con,$sql))
        {
            echo "Database my_db created successfully\n";
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
        //$sql="CREATE TABLE Persons(FirstName CHAR(30),LastName CHAR(30),Age INT)";

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

            echo "query successfully executed\n";
            $num_rows = mysqli_num_rows($results);

            for($i = 0; $i < $num_rows; $i++)
            {
                $row = mysqli_fetch_array($results);
                $res_str = $res_str . $row["MAJOR"] . "\t" . $row["SID"] . "\n";
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
            echo "successfully dropped table\n";
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
            echo "successfully dropped table\n";
        }
        else{
            echo "no need, DB doesn't exist\n";
        }
    }
}

$connector = new connector();
$connector->drop_table("STUDENTS");
$connector->drop_db("school");
$connector->create_db("school");
$connector->choose_db("school");
$connector->create_table("CREATE TABLE STUDENTS(MAJOR VARCHAR(5), SID INT(10))");


$sql = "INSERT INTO STUDENTS VALUES('comp', 957252343)";
$connector->in_query($sql);
$sql = "INSERT INTO STUDENTS VALUES('comp', 234567890)";
$connector->in_query($sql);
$sql = "INSERT INTO STUDENTS VALUES('cs', 765445678)";
$connector->in_query($sql);
$sql = "INSERT INTO STUDENTS VALUES('cs', 019283746)";
$connector->in_query($sql);

$out = "SELECT * FROM STUDENTS";
echo $out . "\n";

$res = $connector->out_query($out);

echo $res;

/***** write results to file ******/
$filename="students.txt";

$filehandle = fopen($filename, "w");

if($filehandle)
    fwrite($filehandle, $res);
else
    echo "error, file not written.\n";
fclose($filehandle);
/***** write results to file ******/

$connector->saydone("done");
trait myMethods
{
    function say($word)
    {
        echo $word . "\n";
    }
}

trait urMethods
{
    function say($word)
    {
        echo $word . "zo";
    }
}

//$mysqli = new mysqli("localhost", "root", "", "applications");


$states = array("CA" => 9998375434, "AZ" => 90000, "OR" =>123123, "KS" =>1233, "TX" => 1231244234);
echo current($states);
echo ' ';
while(next($states))
{
    echo current($states) . ' ';
}

$states["WA"] = 789999;

echo "\n";
foreach($states as $state => $pop)
{
    echo $state . ' population:' . $pop. "\n";
}

?>