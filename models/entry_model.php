<?php
// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/config/config.php");

$dirs = preg_grep('/^([^.])/', scandir($longURL . "entries"));
rsort($dirs);

//create array of all blogs
$blogArray = array();
for($i = 0; $i < sizeof($dirs) - 1 ; $i++)
	{$blogArray[$i] = $dirs[$i];}

class scribe
{
    /**
    * Writes a new blog entry into the file system
    */
    public function newEntry($title, $entry)
    {
//     	$this->renameOld();
        global $longURL;
        $tStamp = time();
        $path = $longURL . "entries/" . $tStamp;
        mkdir($path);
        //file_put_contents($path . "/" . $tStamp . ".txt" , $tStamp); 
        file_put_contents($path . "/" . "blog.txt" , $title ."\n" . $entry); 
    }
    
    /**
    * Writes a new comment into the file system
    */
    public function newComment($name, $comment, $tsp)
    {
    	global $longURL;
        $tStamp = time();
        $path = $longURL . "entries/" . $tsp;
    	file_put_contents($path . "/" . $tStamp . ".txt" , $name ."\n".$comment);
    }
    
    /**
    * Gets the selected blog from the file system
    */
    public function getBlog($folder)
    {
    	global $longURL;
    	$dirs = preg_grep('/^([^.])/', scandir($longURL . "entries"));
		rsort($dirs);
    	if($folder == 'mostrecent')
    		{return file($longURL . "entries/". $dirs[0] . "/blog.txt");}
    	else
    		{return file($longURL . "entries/". $folder . "/blog.txt");}
	}
	
function getCommentText($comArray, $folder)
{
        global $BASEURL;
        global $dirs;
        if(check_session())
        {
        	//print_r($comArray);
        	rsort($comArray);
            $text = '<ul  >';
            for ($i = 0; $i < sizeof($comArray) ; $i++)
	        {
		        $comment_data = file($comArray[$i]);
		        //echo $comArray[$i] . "\n";
		        $pre_comment_file = preg_match('/([0-9]+).txt/', $comArray[$i], $matches);
		        $comment_file = preg_match('/([0-9]+)/', $matches[0], $comment_files);
		        //echo $matches[0] . "\n";
		        $comment_file = $comment_files[0];
		        
		        $commenter = $comment_data[0] . '<a href= "'. $BASEURL .
		         'index.php?c=main&view=loggedin&e='. $folder . '&comment=' . $comment_file 
		         . '&delete=comment">[DELETE]</a>'; //This line needs to be directed correctly
		        $text = $text . '<li>
		        					Name: ' . $commenter . '<br/>';
		        for($j = 1; $j < sizeof($comment_data) ; $j++)
		        {
		        	$text = $text .$comment_data[$j] . "<br/>";
		        }
		        $text = $text . '</li>';
	        }
        }
        else
        {
                $text = '<ul  >';
                for ($i = 0; $i < sizeof($comArray) ; $i++)
	        {
		        rsort($comArray);
		        $comment_data = file($comArray[$i]);
		        $commenter = $comment_data[0];
		        $text = $text . '<li>
		        					Name: ' . $commenter . '<br/>';
		        for($j = 1; $j < sizeof($comment_data) ; $j++)
		        {
		        	$text = $text .$comment_data[$j] . "<br/>";
		        }
		        $text = $text . '</li>';
	        }
        }
	return $text;
}
	
	/**
    * Gets the comment files for current blog from the file system
    */
	public function getComments($folder)
	{
	    global $longURL;
	    global $dirs;
	    
	    if($folder == 'mostrecent')
    		{$folder = $dirs[0];}
    	$path = $longURL . "entries/" . $folder;
    	
    	$comArray = array();
    	if(file_exists($path)) 
    	{ //file_exists check if a file or dir exists
    		$h = opendir($path);
    		$i = 0;
   		 	while (($item = readdir($h)) !== false) 
   		 	{
        		if(preg_match('/([0-9]+).txt/', $item))//matches comment files
        			$comArray[$i++] =  $path .'/'. $item;
        			//echo $item;
    		}
    		
		}
    	//get array of all txt files that only have numbers in them
    	//return an array of files
    	//loop through each file and get all text
    	
    	return $this->getCommentText($comArray, $folder);
    }
    
}
?>