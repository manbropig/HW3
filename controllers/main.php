<?php
// Jamie Tahirkheli - 006547398
// Zohaib Khan - 007673133
// CS 174
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/config/config.php");
include_once($parent_dir . "/models/entry_model.php");

// $selection = 0;
// if(isset($_REQUEST['e']))
// {
// 	$selection = $_REQUEST['e'];
// }

$selection = get_selection(); //get the blog currently looking at

//get lines of selected file
$scribe = new scribe();
$blog = $scribe -> getBlog($selection);

//print_r($comments);
$blogLines ='';
$blogTitle = $blog[0];
for($i = 1; $i < sizeof($blog) ; $i++)
{
	$blogLines = $blogLines . $blog[$i] . "<br/>";
}

$prevEntry = 'Previous Entries:<br/>';
//SET UP BLOG LINKS
//this sets up the links depending on if you are logged in or not
$links = '<ol>';
if (check_session()) //if logged in
{
rsort($dirs);
	$i  = 0;
	for($d = 0; $d < sizeof($dirs) ; $d++)
	{
		$blog = $scribe -> getBlog($dirs[$d]);
		$title = $blog[0];
		$links = $links . '<li>
		<a href="' . $BASEURL . 'index.php?c=main&view=loggedin&e='
		. $dirs[$d] . '">
		'.$title.'</a>';
		
		if($d != sizeof($dirs)-1)
		 {
		 	$links = $links . '--'.'<a href= "'. $BASEURL . 'index.php?c=main&view=loggedin&e='
  			.$dirs[$d].'&delete=blog">[DELETE]</a> <br/>';
  		}
 		$links = $links . '</li>';
		$i += 15;
	}
	$links = $links . '</ol>';
}
else
{ 
	$i = 220;
for($d = 0; $d < sizeof($dirs) ; $d++)
 {
 	$blog = $scribe -> getBlog($dirs[$d]);
	$title = $blog[0];
 	$links = $links . '<li>
 	<a href="' . $BASEURL . 'index.php?c=main&view=notloggedin&e='
 	. $dirs[$d] . '">
 	'.$title.'
 	</a>
 	<br/>
 	</li>';
 	$i += 15;
 }
 $links = $links . '</ol>';
}



//New blogpost form
$newPostForm = 
'<form name="newblogentry" method="post" action=controllers/blog.php>Title:<br/>
  <input type="text" name="title" size="30">
  <br/><br/>
  Type blog here:<br/>
  <textarea name="blogentry" rows="10" cols="80" ></textarea>
  <input type="submit" name="save" value="Submit">
  </form>';

$loginForm = '<div>
  <form name="login" method="post" action=controllers/login.php>
  Username:
  <input type="text" name="Name" size="20">
  <br/><br/>
  Password:
  <input type="password" name="pword">
  <input type="submit" name="login" value="login">
  </form>
</div>';


//login link
$login = '<a href="' . $BASEURL . 'index.php?c=login&view=logingin">
Login
</a>';

//logout link
$logout = '<a href="' . $BASEURL .'controllers/blog.php?log=out">
Logout
</a>';

$logging = $login; //default logged out
$status = 'notloggedin';
if(check_session())//if logged in
{
	$logging = $logout;
	$newEntry = "<a href=\"" . $BASEURL . 
		"index.php?c=main&view=newpost\">Add New Entry</a>";
	$status = 'loggedin';
}



//new entry link
$newEntry = "<a href=\"" . $BASEURL . "index.php?c=main&view=newpost\">
Add New Entry
</a>";

$commentForm = 
	'<form name="commentform" method="post" action=index.php>
	    <input type="hidden" name="a" value="comment">
        <input type="hidden" name="c" value="main">
        <input type="hidden" name="view" value="'.$status.'">
        <input type="hidden" name="e" value="'.$selection.'">
        Name:
         <input type="text" name="Name" size="10">
         <br/><br/>
         Comment:<br/>
         
        <textarea name="commententry" rows="3" cols="80" ></textarea>
        
        <input type="submit" name="save" value="Submit">
    </form>';



$page_title = '<title>Simple Blog - ' . $blogTitle . '</title>' ;

$addEntryTitle = '<title>Simple Blog - New Post</title>' ;
$loginTitle = '<title>Simple Blog - Login</title>' ;

/*
 The main controller should be used for adding a comment. In this case, the form should be 
 posted, the controller,view, and entry should be hidden variables, and you should have a 
 hidden variable a with value comment.
*/
if((isset($_POST['commententry']))&&(isset($_POST['Name'])))
{
	if($_POST['commententry']!='')//only write a new comment if there is text to write
	{
		global $selection;
        $commenter = $_POST['Name'];
        $theComment = $_POST['commententry'];
        $tsp = $selection;
        
        $scribe = new scribe();
        $scribe -> newComment($commenter, $theComment, $selection);
        
        //MAY NEED TO BE MOVED - controllers can't output anything...
        //this might not count as output... no one sees it
        

    }
}

/*$data needs fields:
FOR NOTLOGGEDIN:
	blogTitle
	blogEntry
	commentform
	comments
	links
FOR LOGGEDIN
	blogTitle
	blogEntry
	commentform
	comments
	links
...continue for other views.
*/
$comments = $scribe -> getComments($selection);

$data = array(
"pagetitle"=>$page_title,
"newPostTitle" => $addEntryTitle,
"loginTitle" => $loginTitle,
"title" => $blogTitle, 
"blogText" => $blogLines, 
"bloglist" => $links,
"previous" => $prevEntry,
"logLink" => $logging,
"commentForm" => $commentForm,
"comments" => $comments,
"addNewEntry" => $newEntry,
"loginForm" => $loginForm,
"newPostForm" => $newPostForm);

// The main controller should be used for adding a comment. 
// In this case, the form should be posted, the controller,view, 
// and entry should be hidden variables, and you should have a hidden 
// variable a with value comment. A separate controller, blog.php and 
// view should be used for handling adding a blog post. It can still use 
// the entry_model.php model.
function get_selection()
{
	global $dirs;
	if( (!isset($_REQUEST['e'])) || ($_REQUEST['e'] == 'mostrecent') )
	{
		$sel = $dirs[0];
	}
	else
		$sel = $_REQUEST['e'];
	
	return $sel;
}

    /**
    * puts comment in proper HTML for unordered list
    */



function check_session()
{
	if(session_status() == PHP_SESSION_NONE)
	{
		session_start();//ANY TIME using session, even to get values, must start session 			
	}
	
	global $parent_dir;
	//include_once($parent_dir . "/models/authenticate.php");
	//$auth = new authenticator();
	if(isset($_SESSION['loggedin']))
	{
		//echo 'loggedin = ' . $_SESSION['loggedin'] ."\n";
		if($_SESSION['loggedin'] == 'true')
		{	
			return true;
		}
	}
	else 
		{return false;}
}

if(isset($_REQUEST['delete']) && ($_REQUEST['delete'] == 'comment'))
{
	if((isset($_REQUEST['comment'])) && isset($_REQUEST['e']))
	{
		$sel = $_REQUEST['comment'] . '.txt';
		$entry = $_REQUEST['e'];
	

	$selected = $longURL . "entries/" .$entry . '/' . $sel;
    unlink($selected);
    global $BASEURL;
    echo '<meta http-equiv="refresh" content="0;url=' . $BASEURL . 
    'index.php?c=main&view=loggedin&e=' . $entry .'" />';
    }
} 

if(isset($_REQUEST['e']))
{	
	$sel = $_REQUEST['e'];
}
//Will echo true if deletion was succesful
//echo rmdir($longURL . "entries/" . $sel); 
//$sel = $_REQUEST['e'];

/**
FOR DELETING BLOGS
*/
if(isset($_REQUEST['delete']) && ($_REQUEST['delete'] == 'blog'))
{
	if($sel == '')
	{
		$sel = $dirs[0];
	}
	$selected = $longURL . "entries/" . $sel;
    rrmdir($selected);
    global $BASEURL;
    echo '<meta http-equiv="refresh" content="0;url=' . $BASEURL . 
         'index.php?c=main&view=loggedin" />';
} 

function rrmdir($dir) 
{ 
	if (is_dir($dir)) 
    { 
         $objects = scandir($dir); 
         foreach ($objects as $object) 
         { 
             if ($object != "." && $object != "..") 
             { 
                 if (filetype($dir."/".$object) == "dir") 
                     rrmdir($dir."/".$object); else unlink($dir."/".$object); 
             } 
         } 
         reset($objects); 
         rmdir($dir); 
    } 
    global $BASEURL;
         echo '<meta http-equiv="refresh" content="0;url=' . $BASEURL . 
         'index.php?c=main&view=loggedin" />';
 }


?>

