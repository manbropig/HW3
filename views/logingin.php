<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" >
<!--
Jamie Tahirkheli - 006547398
Zohaib Khan - 007673133
CS 174
-->
    <h2>
        Login<br?>
    </h2>
<div>
<?php 
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/config/config.php");
include_once($parent_dir."/controllers/main.php");
echo $data['loginTitle'];
echo $data['loginForm'];
?>
<br/>
</div>


</html>