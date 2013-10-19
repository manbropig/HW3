<?php
// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/models/db_con.php");
include_once($parent_dir . "/config/config.php");



$connector = new connector();
$connector->drop_table($table_name);
$connector->drop_db($db_name);
$connector->create_db($db_name);
$connector->choose_db($db_name);
$table_maker = "CREATE TABLE IF NOT EXISTS $table_name
    (ID INTEGER(3),
    TITLE VARCHAR(30),
    AUTHOR VARCHAR(30),
    POEM VARCHAR(200),
    MY_RATING DOUBLE DEFAULT 0,
    USER_RATING DOUBLE DEFAULT 0,
    VOTES INTEGER(2) DEFAULT 0,
    PRIMARY KEY (ID))";
$connector->create_table($table_maker);
$connector->close_db();

//what should the primary key be?
//Should the same title be allowed for diff poems?
?>

