<?php
// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/models/db_con.php");
include_once($parent_dir . "/config/config.php");



$connector = new connector();
$putter = new data_putter();
$connector->drop_table($table_name);
$connector->drop_db($db_name);
$connector->create_db($db_name);
$connector->choose_db($db_name);
$table_maker = "CREATE TABLE IF NOT EXISTS $table_name
    (ID INTEGER(3) NOT NULL AUTO_INCREMENT,
    TITLE VARCHAR(30),
    AUTHOR VARCHAR(30),
    POEM VARCHAR(200),
    RATING_SUM DOUBLE DEFAULT 0,
    VOTES INTEGER(2) DEFAULT 0,
    RATING DOUBLE DEFAULT 0,
    FEATURED BOOLEAN NOT NULL DEFAULT FALSE,
    TIME INTEGER(12),
    PRIMARY KEY (ID))";
$connector->create_table($table_maker);
$titles = array("My Dog", "Guy Named Noah", "Marsupials", "Cool Story Bro", "Goob",
"Yabadaba", "Abazaba", "Hungry Hippos", "When I'm hungry", "John McKluskey");

$authors = array("Jamie Tahirkheli", "Louvenia Duncan", "Not Jamie", "Bro",
    "John John", "Bill", "Dave C", "Jamie Tahirkheli","Jamie Tahirkheli",
    "Jamie Tahirkheli");

$poems = array(
"My dog is cool<br/>
He knows how to drool<br/>
He runs all around<br/>
And all over town<br/>
And then takes a dip in a pool",
"I once knew a guy named Noah<br/>
Mean as the snake called Boa<br/>
Loved him still<br/>
Wasn't God's will<br/>
Sent him back to Samoa",
"soup dat sop<br/>
eat dat soup<br/>
and know you just ate<br/>
before its too late<br/>
a marsupial suit",
"No bro no<br/>
Dude, just... no<br/>
chyah<br/>
chyah<br/>
but no",
"noob tube<br/>
noob tube<br/>
rump<br/>
jump<br/>
ube gube",
"yabadaba<br/>
abazaba<br/>
the arsonist<br/>
had a burning wrist<br/>
yaba",
"aba zaba<br/>
Franklin Zapa<br/>
gabagoo<br/>
whoopdidoo<br/>
yabadaba",
"Hungry hippo<br/>
Do the limbo<br/>
Dip down low<br/>
below the pole<br/>
you stupid hippo",
"When I'm hungry<br/>
I get grumpy<br/>
Sound the alarm<br/>
I can do harm<br/>
I'll eat food that is lumpy",
"Mr. McKluskey<br/>
Wasn't too huskey<br/>
wasn't too tall<br/>
Nor too small<br/>
Just a dog of type huskey");
for($p = 0; $p < sizeof($poems); $p++)
{
    $title = $titles[$p];
    $author = $authors[$p];
    $poem = $poems[$p];
    $time = time();
    $query = "INSERT INTO POEMS VALUES(0,\"$title\", \"$author\", \"$poem\", 0,0,0,FALSE, null )";
    if($p == 7)
        $query = "INSERT INTO POEMS VALUES(0,\"$title\", \"$author\", \"$poem\", 0,0,0,TRUE, $time )";
    else if($p == 9)
        $query = "INSERT INTO POEMS VALUES(0,\"$title\", \"$author\", \"$poem\", 0,0,0,TRUE, null )";
    $putter->in_query($query);
}


$connector->close_db();

?>

