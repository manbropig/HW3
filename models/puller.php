<?php
// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174

//$dirs = preg_grep('/^([^.])/', scandir($longURL . "entries"));

class data_puller extends connector
{
    function __construct()
    {
        parent::__construct();
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
     * @return array
     * gets top 10 rated poems
     */
    function top_query()
    {

        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $recent_query = "SELECT ID, TITLE FROM POEMS ORDER BY RATING DESC LIMIT 10";
        if($results = mysqli_query($this->con, $recent_query))
        {
            $recent = array();

            $num_rows = mysqli_num_rows($results);

            for($i = 0; $i < $num_rows; $i++)
            {
                $row = mysqli_fetch_array($results);
                $recent[$row['ID']] = $row["TITLE"];
            }

            return $recent;
        }
        else
        {
            echo "query failed to execute<br/>";

        }
    }

    /**
     * @return array
     * gets top 10 most recent poems
     */
    function recent_query()
    {

        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $recent_query = "SELECT ID, TITLE FROM POEMS ORDER BY ID DESC LIMIT 10";
        if($results = mysqli_query($this->con, $recent_query))
        {
            $recent = array();
            $num_rows = mysqli_num_rows($results);

            for($i = 0; $i < $num_rows; $i++)
            {
                $row = mysqli_fetch_array($results);
                $recent[$row['ID']] = $row["TITLE"];
            }

            return $recent;
        }
        else
        {
            echo "query failed to execute<br/>";
        }
    }

    /**
     * @param $con -> the db connection
     * This function pulls a random poem from the LIMERICKS DB
     */
    function random_poem()
    {
        global $table_name;
        $total_rows = parent::get_rows($table_name);

        $index = rand(1, $total_rows); //gen rand # between 0 and amt of rows
        //THIS QUERY SHOULD ONLY RETURN ONE ROW
        $rand_query = "SELECT * FROM $table_name WHERE ID = $index";
        if($results = mysqli_query($this->con, $rand_query))
        {
            $row = mysqli_fetch_array($results);
            $title = $row['TITLE'];
            $author = $row['AUTHOR'];
            $poem = $row['POEM'];
            $details = ["title" => $title, "author" => $author, "poem" => $poem];
        }
        else
        {
            $details = ["No poems to show"];
        }

        return $details;
    }

    /**
     * @param $con -> the db connection
     * This function pulls a random poem from the LIMERICKS DB
     */
    function get_featured_poem()
    {
        global $table_name;
        $total_rows = parent::get_rows($table_name);

        $index = rand(1, $total_rows); //gen rand # between 1 and amt of rows
        //THIS QUERY SHOULD ONLY RETURN ONE ROW
        $featured_query = "SELECT * FROM $table_name WHERE FEATURED = TRUE";

        if($results = mysqli_query($this->con, $featured_query))
        {
            $row = mysqli_fetch_array($results);
            $time = $row['TIME'];
            if(time() - $time >= 600)
            {
                $this->change_featured_poem($row['ID']);
                //re-query for featured poem
                $results = mysqli_query($this->con, $featured_query);
                $row = mysqli_fetch_array($results);
            }
            $title = $row['TITLE'];
            $author = $row['AUTHOR'];
            $poem = $row['POEM'];
            $id = $row['ID'];
            $details = ["title" => $title, "author" => $author, "poem" => $poem, "id" => $id];
        }
        else
        {
            $details = ["No poems to show"];
        }

        return $details;
    }

    function change_featured_poem($id)
    {
        global $table_name;
        $total_rows = parent::get_rows($table_name);
        $index = rand(1, $total_rows);

        //ensure don't randomly pick same poem
        if($index == $id)
            $index += 1 % $total_rows;

        $changer = new data_putter();
        //turn currently featured poem to FALSE
        $changer->unfeature($id);
        //make new random poem featured with an UPDATE query
        $changer->feature($index);

        return $this->get_poem($index);
    }


    /**
     * @param $id
     * @return array
     * gets a specific poem's details
     */
    function get_poem($id)
    {

        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $query = "SELECT * FROM POEMS WHERE ID = \"$id\"";

        if($results = mysqli_query($this->con, $query))
        {
            $row = mysqli_fetch_array($results);
            $title = $row['TITLE'];
            $author = $row['AUTHOR'];
            $poem = $row['POEM'];
            $details = ["title" => $title,
                "author" => $author, "poem" => $poem];
        }
        else
        {
            $details = ["No poems to show"];
        }

        return $details;
    }
}

//NEED ANOTHER DB FOR THE 10 MINUTE INTERVAL CHANGE
?>
