
<?php
// $parent_dir = dirname(__FILE__) . '/..';
// include_once($parent_dir . "/config/config.php");
// 
//     {
//     	//find the dir labelled 'mostrecent'
//     	//rename it to the timestamp from the timestamp file
//     	global $longURL;
//     	$path = $longURL . "entries";
//     	//$timeStampFile = glob($shortURL . "\d+.txt");
// $dir = new DirectoryIterator($parent_dir . '/entries/mostrecent');
// foreach ($dir as $fileinfo) 
// {
//     //echo $fileinfo->getFilename() . "\n";
//     if(preg_match("/[0-9]+.txt/", $fileinfo->getFilename(), $match))
//     {
//         echo str_replace('.txt', '', $match[0]);
//     }
// }
// 
//     	//echo $timeStampFile;
//     	//print_r( file_get_contents($path . '/mostrecent/'.$timeStampFile));
//     	//echo $timestamp[0];
//     	//rename($longURL . "mostrecent", $timestamp);
//     }
?>

<?php
$fruits = preg_split("/:/", "beer:pizza");
print_r($fruits);
$output =' '. $fruits[0] .' and '. $fruits[1];
$fileHandle = fopen("test.txt", "r");
$read = fread($fileHandle, 5);
echo $read;

$file = file("test.txt");
print_r($file);
fclose($fileHandle);
?>

<?php
//btw mostrecent should calculate which is most recent post, so both timestamp and 
//most recent should work
/*this sets the cookie
* would be a mistake to put this below any code that outputs anything
* because by that time, headers are assumed to have already been sent
*/
//header('Set-Cookie: bob=hungry');
// print_r($_COOKIE['bob']);
// echo 'hahahah';
// session_name("yup");
// session_start(); //shouldn't be able to output before the session start!
// if(!isset($_SESSION["cnt"]))
// {
// 	$_SESSION["cnt"] = 0;
// }
// else
// {
// 	echo $_SESSION["cnt"];
// 	$_SESSION["cnt"]++;
// }

//    session_start();
//    if(!isset($_SESSION['count']))
//        $_SESSION['count'] = 0;
//    else
//        $_SESSION['count']++;
//
//    echo $_SESSION['count'];
?>

<?php
// phpinfo();
// 
// $conn = mysqli_connect();
// //var_dump($conn);
// mysqli_select_db($conn, "applications");
// $result = mysqli_query( $conn, "SELECT DISTINCT PRIORITY FROM APPS");
// 
// while($row = mysqli_fetch_array($result)) 
// {
// 	print_r($row);
// }
// mysqli_close($conn);
?>

<?php
//namespace E;
//class A
//{
//	function foo()
//	{
//		echo 'A';
//	}
//}
//
//class B extends A
//{
//	function __construct($a)
//	{
//		$this->a = $a;
//	}
//	function foo()
//	{
//		echo $this->a;
//	}
//
//	function goo()
//	{
//		echo self::$a;//self must refer to static things
//	}
//}
//
//$tmp = new A();
//$tmp->foo();
//
//$tmp = new B(5);
//$tmp->foo();
//$tmp->goo();
?>
