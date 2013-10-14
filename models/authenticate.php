<?php
/*
Finally, the login screen should be a separate view and use a separate controller login.php
The model for this controller should be authenticate.php. This model should also be used 
by main to read and write from $_SESSION to see if a user is logged in or not currently.
*/
$parent_dir = dirname(__FILE__) . '/..';
include_once($parent_dir . "/config/config.php");

class authenticator
{
    function __construct() 
    {
       $this->user = 'pat';
       $this->pass = 'secret';
   }
   
   
    public function authenticate(){
           //this checks if user enters correct credentials
        if(isset($_POST['Name']) && isset($_POST['pword']))
        {
            //at logout, DESTROY the session
            //$auth = new authenticator();
            $userName = $_POST['Name'];
            $password = $_POST['pword'];
            
            
            $uName = strtolower($userName);
            
            //do this with SESSION var to check - create a function for it
            //Uses the authenticate.php model to check username/password
            if(($uName == $this->user) && ($password == $this->pass))
            {
                // if(!isset($_SESSION['loggedin'])) 
//                 {
					//$_SESSION['password']=$pasword;
                    $_SESSION['loggedin']='true';
                    $_SESSION['username']=$uName;
                    
//                 }
              
                 global $BASEURL;
                 echo '<meta http-equiv="refresh" content="0;url=' . $BASEURL . 
                 'index.php?c=main&view=loggedin" />';
             }
             //if typed in but incorrect
             else
             {
                 global $BASEURL;
                 echo '<meta http-equiv="refresh" content="0;url=' . $BASEURL . 
                 'index.php?c=login&view=logingin2" />';
             }
        }
    }
}
?>