<?php
include("conf.php");
 
 
$symbol = $_POST["symbol"];
$shares = $_POST["shares"];
$aveprice = $_POST["aveprice"];
 
 
 
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



$sql = "INSERT INTO t_stocks(`symbol`,`shares`,`aveprice`) VALUES('$symbol',$shares,$aveprice)";
$result = mysqli_query($conn, $sql);
  
echo "OK";
mysqli_close($conn);
 
				
  	
?>
