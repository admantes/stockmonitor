<?php
include("conf.php");
 
if(!isset($_POST["symbol"])){
	echo "0";
	exit;
}
 
$symbol = $_POST["symbol"];
 
 
 
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



$sql = "DELETE FROM t_stocks WHERE `symbol`='$symbol' ";
$result = mysqli_query($conn, $sql);
  
echo "OK";
mysqli_close($conn);
 
				
  	
?>
