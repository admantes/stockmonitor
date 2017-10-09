<?php
include("conf.php");
 
 
$symbol = $_GET["symbol"];
 
  
 
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$symbol = trim($symbol);


$sql = "INSERT INTO t_stocks(`symbol`,`shares`,`aveprice`) VALUES('$symbol',0,0)";
$result = mysqli_query($conn, $sql);
  
echo "OK";
mysqli_close($conn);
 
				
  	
?>
